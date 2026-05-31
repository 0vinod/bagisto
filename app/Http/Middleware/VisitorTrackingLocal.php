<?php
// E:\xampp\htdocs\hnuman\packages\Vinod\VisitorTracking\src\Middleware\VisitorTracking.php
namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Vinod\VisitorTracking\Models\VisitorTable;

class VisitorTrackingLocal
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $ip = $request->ip();

        if (!($request->is('api/*')) && (!$response instanceof \Illuminate\Http\Response || !str_contains($response->headers->get('Content-Type'), 'text/html'))) {
            return $response;
        }

        if ($request->is('admin') || $request->is('admin/*') || in_array($response->getStatusCode(), [404, 500])) {
            return $response;
        }

        $userAgent = $request->userAgent();
        if (preg_match('/bot|crawl|spider|slurp/i', $userAgent)) {
            return $response;
        }

        $pageTitle = null;

        if ($response instanceof \Illuminate\Http\Response && str_contains($response->headers->get('Content-Type'), 'text/html')) {
            $content = $response->getContent();
            preg_match('/<title>(.*?)<\/title>/', $content, $matches);
            $pageTitle = $matches[1] ?? null;
        }

        $referrer = $request->headers->get('referer');

        $sessionId = session()->getId();
        $url = $request->fullUrl();
        $today = now()->toDateString();

        // ?? 1?? Time-based deduplication (avoid refresh spam within 30 sec)
        $cacheKey = "visit_lock_{$ip}_{$url}_{$sessionId}";

        if (Cache::has($cacheKey)) {
            return $response;
        }

        Cache::put($cacheKey, true, now()->addSeconds(30));

        DB::table('page_views')->insert([
            'session_id' => $sessionId,
            'ip' => $ip,
            'url' => $url,
            'page_title' => $pageTitle,
            'created_at' => now()
        ]);

        // ?? 2?? Check existing visitor today (Unique Visitor Per Day)
        $existingVisitor = VisitorTable::where('ip', $ip)
            ->where('url', $url)
            ->whereDate('created_at', $today)
            ->first();

        // ?? 3?? Cache IP location (7 days)
        if (in_array($ip, ['127.0.0.1', '::1']) || strpos($ip, '192.168.0.') == 0) {
            $location = [
                'country' => 'India',
                'country_code' => 'In',
                'region' => 'Local',
                'city' => 'Localhost',
            ];
        } else {
            $location = Cache::remember("ip_location_{$ip}", now()->addDays(7), function () use ($ip) {
                return Http::timeout(2)
                    ->get("https://ipinfo.io/{$ip}/json")
                    ->json();
            });
        }

        // ?? 4?? If visitor exists ? Update counts
        if ($existingVisitor) {
            $existingVisitor->increment('visit_count');
            $existingVisitor->update([
                'last_visit_at' => now(),
            ]);
        } else {

            // ?? 5?? New Unique Visitor
            VisitorTable::create([
                'ip' => $ip,
                'session_id' => $sessionId,
                'country_code' => strtoupper($location['country_code']) ?? null,
                'country' => $location['country'] ?? null,
                'region' => $location['region'] ?? null,
                'city' => $location['city'] ?? null,
                'device' => $this->detectDevice($userAgent),
                'os' => $this->detectOS($userAgent),
                'browser' => $this->detectBrowser($userAgent),
                'page_title' => $pageTitle,
                'url' => $url,
                'referrer' => $referrer,
                'source' => $this->detectSource($referrer),
                'visit_count' => 1,
                'is_unique' => true,
                'last_visit_at' => now(),
            ]);
        }

        return $response;
    }


    protected function detectDevice($userAgent): string
    {
        if (preg_match('/mobile|android|touch|webos|hpwos/i', $userAgent)) {
            return 'Mobile';
        }

        return 'Desktop';
    }

    protected function detectOS($userAgent): string
    {
        $oses = [
            'Windows' => 'Windows NT',
            'Mac OS' => 'Macintosh',
            'Linux' => 'Linux',
            'Android' => 'Android',
            'iOS' => 'iPhone|iPad',
        ];

        foreach ($oses as $os => $pattern) {
            if (preg_match("/{$pattern}/i", $userAgent)) {
                return $os;
            }
        }

        return 'Unknown';
    }

    protected function detectBrowser($userAgent): string
    {
        $browsers = [
            'Edge' => 'Edg',
            'Chrome' => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari' => 'Safari',
            'Opera' => 'OPR|Opera',
            'Internet Explorer' => 'MSIE|Trident',
        ];

        foreach ($browsers as $browser => $pattern) {
            if (preg_match("/{$pattern}/i", $userAgent)) {
                return $browser;
            }
        }

        return 'Unknown';
    }

    /**
     * Detect the traffic source from a referrer URL.
     *
     * @param string|null $referrer
     * @return string
     */
    protected function detectSource(?string $referrer): string
    {
        if (empty($referrer)) {
            return 'Direct';
        }

        $host = parse_url($referrer, PHP_URL_HOST);
        $host = strtolower($host);

        return match (true) {
            // Search Engines
            str_contains($host, 'google.') => 'Search (Google)',
            str_contains($host, 'bing.com')   => 'Search (Bing)',
            str_contains($host, 'yahoo.com')  => 'Search (Yahoo)',

            // Social Media
            str_contains($host, 'facebook.com') || str_contains($host, 'fb.me') => 'Social (Facebook)',
            str_contains($host, 't.co') || str_contains($host, 'twitter.com') || str_contains($host, 'x.com') => 'Social (X/Twitter)',
            str_contains($host, 'instagram.com') => 'Social (Instagram)',
            str_contains($host, 'linkedin.com')  => 'Social (LinkedIn)',

            // Default to Referral for everything else
            default => 'Referral (' . $host . ')',
        };
    }

    //     protected function detectSource(?string $referrer): string
    // {
    //     if (!$referrer) {
    //         return 'Direct';
    //     }

    //     $sources = [
    //         'Google' => 'google.',
    //         'Facebook' => 'facebook.',
    //         'Instagram' => 'instagram.',
    //         'Twitter' => 'twitter.',
    //         'LinkedIn' => 'linkedin.',
    //         'YouTube' => 'youtube.',
    //         'Bing' => 'bing.',
    //     ];

    //     foreach ($sources as $name => $pattern) {
    //         if (stripos($referrer, $pattern) !== false) {
    //             return $name;
    //         }
    //     }

    //     return 'Other';
    // }
}
