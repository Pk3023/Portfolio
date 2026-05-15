<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>{{ $title ?? 'Linkon Mondol - Portfolio' }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">

    <style>
        .animated-bg {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0f1419 0%, #1a1f2e 45%, #0f1419 100%);
            z-index: -1;
            overflow: hidden;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background:
                radial-gradient(circle at 18% 45%, rgba(11, 114, 185, 0.28) 0%, transparent 42%),
                radial-gradient(circle at 82% 76%, rgba(16, 163, 127, 0.22) 0%, transparent 42%),
                radial-gradient(circle at 42% 16%, rgba(255, 209, 102, 0.18) 0%, transparent 38%);
            animation: gradientShift 10s ease-in-out infinite;
        }

        .animated-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(90deg, transparent 0%, rgba(11, 114, 185, 0.08) 50%, transparent 100%),
                linear-gradient(180deg, transparent 0%, rgba(16, 163, 127, 0.06) 50%, transparent 100%);
            animation: waveMotion 12s linear infinite;
        }

        @keyframes gradientShift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(-34px, -34px) scale(1.05); }
            50% { transform: translate(0, -58px) scale(1.12); }
            75% { transform: translate(34px, -34px) scale(1.05); }
        }

        @keyframes waveMotion {
            0% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-26px) translateX(-26px); }
            100% { transform: translateY(0) translateX(0); }
        }

        .particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            pointer-events: none;
        }

        .particle-dot {
            width: 3px;
            height: 3px;
            background: rgba(255, 209, 102, 0.72);
            border-radius: 50%;
            box-shadow: 0 0 14px rgba(11, 114, 185, 0.65);
        }

        #music-btn {
            position: fixed;
            right: 20px;
            bottom: 20px;
            display: none;
            z-index: 9999;
            padding: 12px 16px;
            border-radius: 999px;
            background: #0b72b9;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        #music-btn:hover {
            transform: translateY(-2px) scale(1.04);
            background: #10a37f;
            box-shadow: 0 12px 30px rgba(16, 163, 127, 0.36);
        }
    </style>
</head>
<body>
<div class="animated-bg">
    <div class="particles" id="particles"></div>
</div>

<audio id="bgm" autoplay loop>
    <source src="{{ asset('sounds/bgm.mp3') }}" type="audio/mpeg">
</audio>

<div id="music-btn">Play Music</div>

<header class="site-header">
    <div class="container">
        <div class="logo">Linkon Mondol</div>
        <nav class="nav">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('projects') }}">Projects</a>
            <a href="{{ route('contact') }}">Contact</a>
        </nav>
    </div>
</header>

<main class="main">
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @yield('content')
</main>

<footer class="site-footer">
    <div class="container">
        Copyright {{ date('Y') }} Linkon Mondol - BSc in CSE, Daffodil International University
    </div>
</footer>

<script>
    function initParticles() {
        const particleContainer = document.getElementById('particles');
        if (!particleContainer) return;

        const particleCount = 75;
        const particles = [];

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';

            const dotDiv = document.createElement('div');
            dotDiv.className = 'particle-dot';
            particle.appendChild(dotDiv);
            particleContainer.appendChild(particle);

            const size = Math.random() * 3.5 + 1.5;
            const x = Math.random() * window.innerWidth;
            const y = Math.random() * window.innerHeight;
            const vx = (Math.random() - 0.5) * 0.9;
            const vy = (Math.random() - 0.5) * 0.9;
            const opacity = Math.random() * 0.55 + 0.4;

            particles.push({ el: particle, x, y, vx, vy, size, opacity });

            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = x + 'px';
            particle.style.top = y + 'px';
            particle.style.opacity = opacity;
        }

        function animate() {
            particles.forEach((p) => {
                p.x += p.vx;
                p.y += p.vy;

                if (p.x < 0) p.x = window.innerWidth;
                if (p.x > window.innerWidth) p.x = 0;
                if (p.y < 0) p.y = window.innerHeight;
                if (p.y > window.innerHeight) p.y = 0;

                p.vy += (Math.random() - 0.5) * 0.05;
                p.vx += (Math.random() - 0.5) * 0.05;
                p.vx = Math.max(-1.15, Math.min(1.15, p.vx));
                p.vy = Math.max(-1.15, Math.min(1.15, p.vy));

                p.el.style.left = p.x + 'px';
                p.el.style.top = p.y + 'px';
            });

            requestAnimationFrame(animate);
        }

        animate();

        window.addEventListener('resize', () => {
            particles.forEach((p) => {
                if (p.x > window.innerWidth) p.x = window.innerWidth;
                if (p.y > window.innerHeight) p.y = window.innerHeight;
            });
        });
    }

    function initAudioControl() {
        const audio = document.getElementById('bgm');
        const btn = document.getElementById('music-btn');
        if (!audio || !btn) return;

        audio.volume = 0.25;
        let isPlaying = true;

        const playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.then(() => {
                btn.innerHTML = 'Pause Music';
                btn.style.display = 'block';
                isPlaying = true;
            }).catch(() => {
                btn.innerHTML = 'Play Music';
                btn.style.display = 'block';
                isPlaying = false;
            });
        } else {
            btn.style.display = 'block';
            isPlaying = false;
        }

        btn.addEventListener('click', () => {
            if (isPlaying) {
                audio.pause();
                btn.innerHTML = 'Play Music';
                isPlaying = false;
            } else {
                audio.play();
                btn.innerHTML = 'Pause Music';
                isPlaying = true;
            }
        });

        audio.addEventListener('ended', () => {
            btn.innerHTML = 'Play Music';
            isPlaying = false;
        });
    }

    function initSnowfall() {
        const snowfallContainer = document.getElementById('snowfall');
        if (!snowfallContainer) return;

        function createSnowflake() {
            const snowflake = document.createElement('div');
            snowflake.className = 'snowflake';
            snowflake.innerHTML = '*';

            const size = Math.random() * 1.5 + 0.5;
            const left = Math.random() * 100;
            const duration = Math.random() * 10 + 10;
            const delay = Math.random() * 2;
            const opacity = Math.random() * 0.5 + 0.5;

            snowflake.style.left = left + '%';
            snowflake.style.fontSize = size + 'em';
            snowflake.style.opacity = opacity;
            snowflake.style.animationDuration = duration + 's';
            snowflake.style.animationDelay = delay + 's';
            snowflake.style.animationTimingFunction = 'linear';

            snowfallContainer.appendChild(snowflake);
            setTimeout(() => snowflake.remove(), (duration + delay) * 1000);
        }

        const snowfallInterval = setInterval(createSnowflake, 200);
        setTimeout(() => clearInterval(snowfallInterval), 30000);
    }

    function initTextAnimations() {
        const animatedTexts = document.querySelectorAll('.animate-slide-in-text');
        animatedTexts.forEach((el, index) => {
            if (!el.style.animationDelay) {
                el.style.animationDelay = (index * 0.12) + 's';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initParticles();
        initAudioControl();
        initSnowfall();
        initTextAnimations();
    });
</script>
</body>
</html>
