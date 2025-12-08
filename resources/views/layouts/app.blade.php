<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>{{ $title ?? 'Linkon Mondol - Portfolio' }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        /* Animated Background Container */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0f1419 0%, #1a1f2e 50%, #0f1419 100%);
            z-index: -1;
            overflow: hidden;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(11, 114, 185, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(16, 163, 127, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255, 209, 102, 0.08) 0%, transparent 50%);
            animation: gradientShift 15s ease-in-out infinite;
            top: -50%;
            left: -50%;
        }

        .animated-bg::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(90deg, transparent 0%, rgba(11, 114, 185, 0.03) 50%, transparent 100%),
                linear-gradient(180deg, transparent 0%, rgba(16, 163, 127, 0.02) 50%, transparent 100%);
            animation: waveMotion 20s linear infinite;
        }

        @keyframes gradientShift {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(-30px, -30px) scale(1.05);
            }
            50% {
                transform: translate(0, -50px) scale(1.1);
            }
            75% {
                transform: translate(30px, -30px) scale(1.05);
            }
        }

        @keyframes waveMotion {
            0% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-20px) translateX(-20px);
            }
            100% {
                transform: translateY(0) translateX(0);
            }
        }

        /* Particle System */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            pointer-events: none;
        }

        .particle-dot {
            width: 2px;
            height: 2px;
            background: rgba(11, 114, 185, 0.5);
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(11, 114, 185, 0.3);
        }

        /* Floating Music Button */
        #music-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #0b72b9;
            color: #fff;
            padding: 12px 16px;
            border-radius: 50px;
            cursor: pointer;
            display: none; /* hidden by default */
            font-size: 14px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            z-index: 9999;
            transition: all 0.3s ease;
        }

        #music-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(11, 114, 185, 0.5);
        }
    </style>
</head>
<body>
<!-- Animated Background -->
<div class="animated-bg">
    <div class="particles" id="particles"></div>
</div>

<!-- Background music -->
<audio id="bgm" autoplay loop>
    <source src="{{ asset('sounds/bgm.mp3') }}" type="audio/mpeg">
</audio>

<div id="music-btn">▶ Play Music</div>

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
        © {{ date('Y') }} Linkon Mondol — BSc in CSE, Daffodil International University
    </div>
</footer>

<script>
    // Particle Animation System
    function initParticles() {
        const particleContainer = document.getElementById('particles');
        if (!particleContainer) return;

        const particleCount = 40;
        const particles = [];

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            
            const dotDiv = document.createElement('div');
            dotDiv.className = 'particle-dot';
            particle.appendChild(dotDiv);
            
            particleContainer.appendChild(particle);

            const size = Math.random() * 3 + 1;
            const x = Math.random() * window.innerWidth;
            const y = Math.random() * window.innerHeight;
            const vx = (Math.random() - 0.5) * 0.5;
            const vy = (Math.random() - 0.5) * 0.5;
            const opacity = Math.random() * 0.5 + 0.3;

            particles.push({
                el: particle,
                x: x,
                y: y,
                vx: vx,
                vy: vy,
                size: size,
                opacity: opacity
            });

            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = x + 'px';
            particle.style.top = y + 'px';
            particle.style.opacity = opacity;
        }

        // Animation loop
        function animate() {
            particles.forEach(p => {
                p.x += p.vx;
                p.y += p.vy;

                // Wrap around edges
                if (p.x < 0) p.x = window.innerWidth;
                if (p.x > window.innerWidth) p.x = 0;
                if (p.y < 0) p.y = window.innerHeight;
                if (p.y > window.innerHeight) p.y = 0;

                // Gentle floating motion
                p.vy += (Math.random() - 0.5) * 0.05;
                p.vx += (Math.random() - 0.5) * 0.05;

                // Limit velocity
                p.vx = Math.max(-1, Math.min(1, p.vx));
                p.vy = Math.max(-1, Math.min(1, p.vy));

                p.el.style.left = p.x + 'px';
                p.el.style.top = p.y + 'px';
            });

            requestAnimationFrame(animate);
        }

        animate();

        // Handle window resize
        window.addEventListener('resize', () => {
            particles.forEach(p => {
                if (p.x > window.innerWidth) p.x = window.innerWidth;
                if (p.y > window.innerHeight) p.y = window.innerHeight;
            });
        });
    }

    // Music Control
    function initAudioControl() {
        const audio = document.getElementById("bgm");
        const btn = document.getElementById("music-btn");

        if (!audio) return;

        audio.volume = 0.25;
        let isPlaying = true;

        const playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.then(function() {
                btn.innerHTML = "⏸ Pause Music";
                btn.style.display = 'block';
                isPlaying = true;
            }).catch(function(error) {
                btn.innerHTML = "▶ Play Music";
                btn.style.display = 'block';
                isPlaying = false;
            });
        } else {
            btn.style.display = 'block';
            isPlaying = false;
        }

        btn.addEventListener("click", function () {
            if (isPlaying) {
                audio.pause();
                btn.innerHTML = "▶ Play Music";
                isPlaying = false;
            } else {
                audio.play();
                btn.innerHTML = "⏸ Pause Music";
                isPlaying = true;
            }
        });

        audio.addEventListener("ended", function() {
            btn.innerHTML = "▶ Play Music";
            isPlaying = false;
        });
    }

    // Snowfall Animation System
    function initSnowfall() {
        const snowfallContainer = document.getElementById('snowfall');
        if (!snowfallContainer) return;

        const snowflakeCount = 50;
        const snowflakes = [];

        function createSnowflake() {
            const snowflake = document.createElement('div');
            snowflake.className = 'snowflake';
            snowflake.innerHTML = '❄';
            
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
            
            // Remove snowflake after animation ends
            setTimeout(() => {
                snowflake.remove();
            }, (duration + delay) * 1000);
        }

        // Create snowflakes continuously
        const snowfallInterval = setInterval(() => {
            createSnowflake();
        }, 200);

        // Stop creating snowflakes after 30 seconds (when section is likely not visible)
        setTimeout(() => {
            clearInterval(snowfallInterval);
        }, 30000);
    }

    // Text animation staggering (for multiple animated elements)
    function initTextAnimations() {
        const animatedTexts = document.querySelectorAll('.animate-slide-in-text');
        animatedTexts.forEach((el, index) => {
            if (!el.style.animationDelay) {
                el.style.animationDelay = (index * 0.15) + 's';
            }
        });
    }

    // Initialize everything
    document.addEventListener("DOMContentLoaded", function () {
        initParticles();
        initAudioControl();
        initSnowfall();
        initTextAnimations();
    });
</script>

</body>
</html>
