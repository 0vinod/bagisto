<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuperTET 2026 Preparation App – Learn smart, score high</title>
    <meta name="description"
        content="Practice MCQs by topic, read subject-wise notes and track your SuperTET syllabus in one free app.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;700;800&family=Hind:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --paper: #ffffff;
            --wash: #f3f5fa;
            --ink: #14213d;
            --mute: #5b6478;
            --line: #d9deea;
            --omr: #d6336c;
            --ok: #1fa37a;
            --no: #e03131;
            --hl: #ffd43b;
            --head: "Bricolage Grotesque", "Trebuchet MS", system-ui, sans-serif;
            --body: "Hind", "Segoe UI", system-ui, sans-serif;
        }

        @media (prefers-color-scheme:dark) {
            :root {
                --paper: #10172a;
                --wash: #162038;
                --ink: #eef1fa;
                --mute: #a3adc4;
                --line: #2b3857;
                --omr: #ff6b9a;
                --ok: #3ddba8;
                --no: #ff7b7b
            }
        }

        * {
            box-sizing: border-box;
            margin: 0
        }

        html {
            scroll-behavior: smooth
        }

        body {
            font-family: var(--body);
            background: var(--paper);
            color: var(--ink);
            line-height: 1.6;
            font-size: 17px;
            padding-top: env(safe-area-inset-top, 0px)
        }

        a {
            color: inherit
        }

        :focus-visible {
            outline: 3px solid var(--omr);
            outline-offset: 3px;
            border-radius: 6px
        }

        .wrap {
            max-width: 1040px;
            margin: 0 auto;
            padding: 0 20px
        }

        h1,
        h2,
        h3 {
            font-family: var(--head);
            line-height: 1.1;
            letter-spacing: -.02em
        }

        /* nav */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0
        }

        .logo {
            font-family: var(--head);
            font-weight: 800;
            font-size: 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px
        }

        .logo i {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 3px solid var(--omr);
            background: radial-gradient(circle, var(--omr) 45%, transparent 50%)
        }

        .btn {
            display: inline-block;
            background: var(--ink);
            color: var(--paper);
            font-family: var(--head);
            font-weight: 700;
            font-size: 16px;
            padding: 13px 24px;
            border-radius: 999px;
            text-decoration: none;
            border: 0;
            cursor: pointer
        }

        .btn:hover {
            background: var(--omr);
            color: #fff
        }

        .btn.alt {
            background: transparent;
            color: var(--ink);
            border: 2px solid var(--ink)
        }

        .btn.alt:hover {
            background: var(--ink);
            color: var(--paper)
        }

        /* hero */
        .hero {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 44px;
            align-items: center;
            padding: 36px 0 72px
        }

        .hero h1 {
            font-size: clamp(38px, 6.4vw, 66px);
            font-weight: 800
        }

        .hero h1 mark {
            background: linear-gradient(transparent 58%, var(--hl) 58%);
            color: inherit
        }

        .hero .hi {
            font-size: 19px;
            color: var(--omr);
            font-weight: 600;
            margin: 14px 0 6px
        }

        .hero p.lead {
            color: var(--mute);
            max-width: 46ch;
            margin-bottom: 26px
        }

        .cta {
            display: flex;
            gap: 12px;
            flex-wrap: wrap
        }

        .free {
            margin-top: 14px;
            font-size: 14px;
            color: var(--mute)
        }

        /* live question */
        .sheet {
            background: var(--wash);
            border: 2px solid var(--ink);
            border-radius: 20px;
            padding: 22px;
            box-shadow: 8px 8px 0 var(--ink)
        }

        .sheet .meta {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: var(--mute);
            margin-bottom: 10px
        }

        .sheet h3 {
            font-size: 19px;
            margin-bottom: 14px;
            line-height: 1.3
        }

        .opt {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            text-align: left;
            font: inherit;
            color: inherit;
            background: var(--paper);
            border: 2px solid var(--line);
            border-radius: 12px;
            padding: 10px 12px;
            margin: 8px 0;
            cursor: pointer
        }

        .opt:hover:not(:disabled) {
            border-color: var(--omr)
        }

        .opt b {
            flex: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid var(--mute);
            display: grid;
            place-items: center;
            font-size: 13px;
            font-family: var(--head)
        }

        .opt.ok {
            border-color: var(--ok)
        }

        .opt.ok b {
            background: var(--ok);
            border-color: var(--ok);
            color: #fff
        }

        .opt.no {
            border-color: var(--no)
        }

        .opt.no b {
            background: var(--no);
            border-color: var(--no);
            color: #fff
        }

        .opt:disabled {
            cursor: default
        }

        .why {
            font-size: 14.5px;
            color: var(--mute);
            margin-top: 10px;
            min-height: 44px
        }

        .again {
            font: inherit;
            font-size: 14px;
            background: none;
            border: 0;
            color: var(--omr);
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            margin-top: 4px;
            text-decoration: underline
        }

        /* sections */
        section {
            padding: 64px 0
        }

        section.tint {
            background: var(--wash)
        }

        .sh {
            max-width: 600px;
            margin-bottom: 36px
        }

        .sh h2 {
            font-size: clamp(28px, 4.4vw, 42px);
            font-weight: 800;
            margin-bottom: 10px
        }

        .sh p {
            color: var(--mute)
        }

        .feat {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px
        }

        .f {
            border-top: 5px solid var(--c);
            padding: 18px 4px 0
        }

        .f .e {
            font-size: 34px
        }

        .f h3 {
            font-size: 22px;
            margin: 8px 0
        }

        .f p {
            color: var(--mute);
            font-size: 16px
        }

        /* progress preview */
        .split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center
        }

        .split h2 {
            font-size: clamp(28px, 4.2vw, 40px);
            font-weight: 800;
            margin-bottom: 12px
        }

        .split p {
            color: var(--mute);
            margin-bottom: 14px
        }

        .split ul {
            list-style: none;
            padding: 0
        }

        .split li {
            padding: 6px 0 6px 28px;
            position: relative
        }

        .split li:before {
            content: "✔";
            position: absolute;
            left: 0;
            color: var(--ok);
            font-weight: 700
        }

        .tbox {
            background: var(--paper);
            border: 2px solid var(--line);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 14px
        }

        .tbox h4 {
            font-family: var(--head);
            font-size: 17px
        }

        .tbox small {
            color: var(--mute)
        }

        .pb {
            height: 9px;
            border-radius: 9px;
            background: var(--line);
            overflow: hidden;
            margin: 10px 0 8px
        }

        .pb i {
            display: block;
            height: 100%;
            background: var(--c);
            border-radius: 9px
        }

        .st {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600
        }

        .st .g {
            color: var(--ok)
        }

        .st .r {
            color: var(--no)
        }

        /* steps */
        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            counter-reset: s;
            list-style: none;
            padding: 0
        }

        .steps li {
            counter-increment: s;
            border-left: 3px solid var(--omr);
            padding-left: 16px
        }

        .steps li:before {
            content: counter(s);
            font-family: var(--head);
            font-weight: 800;
            font-size: 34px;
            color: var(--omr);
            display: block;
            line-height: 1
        }

        .steps b {
            font-family: var(--head);
            font-size: 18px;
            display: block;
            margin: 6px 0 2px
        }

        .steps span {
            color: var(--mute);
            font-size: 15px
        }

        /* final cta */
        .final {
            background: var(--ink);
            color: var(--paper);
            border-radius: 28px;
            padding: 52px 28px;
            text-align: center;
            margin: 40px 0 56px
        }

        .final h2 {
            font-size: clamp(28px, 5vw, 46px);
            font-weight: 800;
            max-width: 18ch;
            margin: 0 auto 12px
        }

        .final p {
            opacity: .8;
            margin-bottom: 24px
        }

        .final .btn {
            background: var(--hl);
            color: #14213d
        }

        .final .btn:hover {
            background: #fff;
            color: #14213d
        }

        footer {
            padding: 0 0 40px;
            text-align: center;
            color: var(--mute);
            font-size: 14px
        }

        @media (max-width:820px) {

            .hero,
            .split {
                grid-template-columns: 1fr
            }

            .feat {
                grid-template-columns: 1fr
            }

            .steps {
                grid-template-columns: 1fr 1fr
            }

            .hero {
                padding-bottom: 48px
            }

            section {
                padding: 48px 0
            }
        }

        @media (max-width:480px) {
            .steps {
                grid-template-columns: 1fr
            }
        }

        @media (prefers-reduced-motion:reduce) {
            html {
                scroll-behavior: auto
            }
        }
    </style>
</head>

<body>

    <div class="wrap">
        <nav>
            <a class="logo" href="#top"><i></i>SuperTET Prep</a>
            <a class="btn alt" href="#get" data-app>Open the app</a>
        </nav>

        <header class="hero" id="top">
            <div>
                <h1>Crack SuperTET, <mark>one question</mark> at a time.</h1>
                <p class="hi">सुपर टेट की तैयारी, अब आसान।</p>
                <p class="lead">Practice MCQs topic by topic, read short point-wise notes for every subject, and tick
                    off the syllabus as you finish it. Your score and progress are saved automatically.</p>
                <div class="cta">
                    <a class="btn" href="#get" data-app>Start practising free</a>
                    <a class="btn alt" href="#features">See what’s inside</a>
                </div>
                <p class="free">Works on any phone or laptop. No download needed.</p>
            </div>

            <div class="sheet" aria-live="polite">
                <div class="meta"><span>Try a question</span><span>Child Development</span></div>
                <h3>Which of these is a stage of Piaget’s cognitive development?</h3>
                <div id="opts"></div>
                <p class="why" id="why">Pick an answer to see the explanation.</p>
                <button class="again" id="again" hidden>Try again</button>
            </div>
        </header>
    </div>

    <section id="features" class="tint">
        <div class="wrap">
            <div class="sh">
                <h2>Everything for SuperTET in one place</h2>
                <p>Three tools, one login. Pick a subject and start.</p>
            </div>
            <div class="feat">
                <div class="f" style="--c:#10b981">
                    <div class="e">📝</div>
                    <h3>Practice by topic</h3>
                    <p>MCQs grouped by topic. Each topic shows how many questions you have attempted, and how many you
                        got right or wrong.</p>
                </div>
                <div class="f" style="--c:#6366f1">
                    <div class="e">📒</div>
                    <h3>Subject-wise notes</h3>
                    <p>Easy point-wise notes with headings and pictures. Quick to read the night before the exam.</p>
                </div>
                <div class="f" style="--c:#f97316">
                    <div class="e">✅</div>
                    <h3>Syllabus checklist</h3>
                    <p>Every topic of the SuperTET syllabus as a checklist. Tick it off and watch your progress bar
                        fill.</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="wrap split">
            <div>
                <h2>Know exactly where you stand</h2>
                <p>Every topic is a box with its own progress. You always see what is left, and what needs more
                    revision.</p>
                <ul>
                    <li>New questions first: only unattempted MCQs are shown</li>
                    <li>Open “Attempted Questions” to review any time</li>
                    <li>See your correct and incorrect percentage per topic</li>
                </ul>
            </div>
            <div aria-label="Example topic progress">
                <div class="tbox" style="--c:#10b981">
                    <h4>Learning &amp; Pedagogy</h4><small>40 questions</small>
                    <div class="pb"><i style="width:75%"></i></div>
                    <div class="st"><span>30 / 40 attempted · 75%</span></div>
                    <div class="st" style="margin-top:4px"><span class="g">✔ 24 correct</span><span
                            class="r">✖ 6 incorrect</span></div>
                </div>
                <div class="tbox" style="--c:#6366f1">
                    <h4>Inclusive Education</h4><small>25 questions</small>
                    <div class="pb"><i style="width:36%"></i></div>
                    <div class="st"><span>9 / 25 attempted · 36%</span></div>
                    <div class="st" style="margin-top:4px"><span class="g">✔ 5 correct</span><span
                            class="r">✖ 4 incorrect</span></div>
                </div>
            </div>
        </div>
    </section>

    <section class="tint">
        <div class="wrap">
            <div class="sh">
                <h2>Start in four steps</h2>
            </div>
            <ol class="steps">
                <li><b>Create your account</b><span>Register with your email in under a minute.</span></li>
                <li><b>Choose a subject</b><span>Practice, notes or syllabus. Your pick.</span></li>
                <li><b>Study and answer</b><span>Read the notes, then test yourself with MCQs.</span></li>
                <li><b>Track your progress</b><span>Check your score and revise weak topics.</span></li>
            </ol>
        </div>
    </section>

    <div class="wrap" id="get">
        <div class="final">
            <h2>Your next question is waiting.</h2>
            <p>Join other SuperTET aspirants and make every study hour count.</p>
            <a class="btn" href="#" data-app>Open SuperTET Prep</a>
        </div>
        <footer>© <span id="yr"></span> SuperTET Preparation App · Learn smart, score high</footer>
    </div>

    <script>
        /* Put your real app link here. All “Open the app / Start” buttons use it. */
        const APP_URL = "{{ $apkUrl }}";
        document.querySelectorAll("[data-app]").forEach(a => {
            a.href = APP_URL;
            if (APP_URL !== "#") a.setAttribute("download", "SuperTET-Prep.apk");
        });

        document.getElementById("yr").textContent = new Date().getFullYear();

        const demo = {
            options: ["Sensorimotor stage", "Oral stage", "Latency stage", "Identity stage"],
            answer: 0,
            why: "Piaget’s four stages are sensorimotor, preoperational, concrete operational and formal operational. The others come from Freud and Erikson."
        };
        const opts = document.getElementById("opts"),
            why = document.getElementById("why"),
            again = document.getElementById("again");

        function render() {
            opts.innerHTML = "";
            why.textContent = "Pick an answer to see the explanation.";
            again.hidden = true;
            demo.options.forEach((t, i) => {
                const b = document.createElement("button");
                b.className = "opt";
                b.innerHTML = `<b>${"ABCD"[i]}</b><span></span>`;
                b.lastChild.textContent = t;
                b.onclick = () => pick(i);
                opts.appendChild(b);
            });
        }

        function pick(i) {
            [...opts.children].forEach((b, k) => {
                b.disabled = true;
                if (k === demo.answer) b.classList.add("ok");
                else if (k === i) b.classList.add("no");
            });
            why.textContent = (i === demo.answer ? "Correct. " : "Not quite. ") + demo.why;
            again.hidden = false;
        }
        again.onclick = render;
        render();
    </script>
</body>

</html>
