<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Notification;
use App\Notifications\StatusNotification;
use App\Models\User;
use App\Models\ProductReview;
use App\Models\ReviewMedia;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = ProductReview::getAllReview();

        return view('backend.review.index')->with('reviews', $reviews);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_bkp(Request $request)
    {
        $this->validate($request, [
            'rate' => 'required|numeric|min:1',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:20480',
        ]);     


        $product_info = Product::getProductBySlug($request->slug);
        //  return $product_info;
        // return $request->all();
        $data = $request->all();
        $data['product_id'] = $product_info->id;
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'active';
        // dd($data);
        $status = ProductReview::create($data);

        $user = User::where('role', 'admin')->get();
        $details = [
            'title' => 'New Product Rating!',
            'actionURL' => route('product-detail', $product_info->slug),
            'fas' => 'fa-star'
        ];
        // Notification::send($user,new StatusNotification($details));
        if ($status) {
            request()->session()->flash('success', 'Thank you for your feedback');
        } else {
            request()->session()->flash('error', 'Something went wrong! Please try again!!');
        }
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'rate' => 'required|numeric|min:1|max:5',
            'review' => 'required',
        ]);
 
        $product_info = Product::getProductBySlug($request->slug);

        if (!$product_info) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $data = [
            'product_id' => $product_info->id,
            'user_id' => auth()->id(),
            'rate' => $request->rate,
            'review' => $request->review,
            'status' => 'active',
        ];

        $review = ProductReview::create($data);

        if ($review && $request->hasFile('media')) {

            $file = $request->file('media');

            $path = $file->store('reviews', 'public');

            $type = str_starts_with(
                $file->getMimeType(),
                'video/'
            ) ? 'video' : 'image';

            ReviewMedia::create([
                'review_id' => $review->id,
                'file_path' => $path,
                'type' => $type,
            ]);
        }

        if ($review) {
            return redirect()->back()
                ->with('success', 'Thank you for your feedback.');
        }

        return redirect()->back()
            ->with('error', 'Something went wrong.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = ProductReview::find($id);
        // return $review;
        return view('backend.review.edit')->with('review', $review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'rate' => 'required|numeric|min:1|max:5',
            'review' => 'required',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:20480',
        ]);

        $review = ProductReview::find($id);

        if (!$review) {
            return redirect()->route('review.index')
                ->with('error', 'Review not found!');
        }

        $data = [
            'rate' => $request->rate,
            'review' => $request->review,
        ];

        $status = $review->update($data);

        // Add new image/video (don't delete old ones)
        if ($status && $request->hasFile('media')) {

            $file = $request->file('media');

            $path = $file->store('reviews', 'public');

            $type = str_starts_with(
                $file->getMimeType(),
                'video/'
            ) ? 'video' : 'image';

            ReviewMedia::create([
                'review_id' => $review->id,
                'file_path' => $path,
                'type' => $type,
            ]);
        }

        if ($status) {
            return redirect()->route('review.index')
                ->with('success', 'Review successfully updated.');
        }

        return redirect()->route('review.index')
            ->with('error', 'Something went wrong. Please try again.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $review = ProductReview::find($id);

        if (!$review) {
            return redirect()->route('review.index')
                ->with('error', 'Review not found!');
        }

        // Delete media file if exists
        if (!empty($review->media)) {

            $filePath = storage_path('app/public/' . $review->media);

            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $status = $review->delete();

        if ($status) {
            return redirect()->route('review.index')
                ->with('success', 'Successfully deleted review');
        }

        return redirect()->route('review.index')
            ->with('error', 'Something went wrong! Try again');
    }
}
