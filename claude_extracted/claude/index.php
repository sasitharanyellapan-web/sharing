<!DOCTYPE html>

<html class="scroll-smooth" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Code Geek Academy | Empowering Young Innovators</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&amp;family=Inter:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "secondary-fixed-dim": "#6bdc96",
                        "on-primary-container": "#86a0cd",
                        "surface-container-lowest": "#ffffff",
                        "surface-bright": "#f7fafc",
                        "primary": "#002045",
                        "on-background": "#181c1e",
                        "surface-container": "#ebeef0",
                        "inverse-on-surface": "#eef1f3",
                        "inverse-surface": "#2d3133",
                        "surface-variant": "#e0e3e5",
                        "on-primary-fixed": "#001b3c",
                        "tertiary": "#371800",
                        "tertiary-container": "#572900",
                        "secondary": "#006d3c",
                        "error": "#ba1a1a",
                        "on-surface": "#181c1e",
                        "secondary-container": "#85f6ad",
                        "on-surface-variant": "#43474e",
                        "background": "#f7fafc",
                        "on-tertiary": "#ffffff",
                        "surface-dim": "#d7dadc",
                        "surface": "#f7fafc",
                        "on-primary-fixed-variant": "#2d476f",
                        "tertiary-fixed-dim": "#ffb783",
                        "error-container": "#ffdad6",
                        "on-secondary-fixed": "#00210f",
                        "tertiary-fixed": "#ffdcc5",
                        "energetic-orange": "#ED8936",
                        "surface-tint": "#455f88",
                        "inverse-primary": "#adc7f7",
                        "glass-border": "rgba(255, 255, 255, 0.4)",
                        "outline": "#74777f",
                        "on-primary": "#ffffff",
                        "primary-fixed": "#d6e3ff",
                        "on-secondary-fixed-variant": "#00522c",
                        "outline-variant": "#c4c6cf",
                        "glass-surface": "rgba(255, 255, 255, 0.7)",
                        "secondary-fixed": "#88f9b0",
                        "on-error": "#ffffff",
                        "primary-fixed-dim": "#adc7f7",
                        "on-secondary-container": "#00723f",
                        "surface-container-highest": "#e0e3e5",
                        "surface-container-low": "#f1f4f6",
                        "surface-container-high": "#e5e9eb",
                        "vibrant-green": "#48BB78",
                        "primary-container": "#1a365d",
                        "on-error-container": "#93000a",
                        "deep-navy": "#1A365D",
                        "on-tertiary-fixed": "#301400",
                        "on-secondary": "#ffffff",
                        "on-tertiary-fixed-variant": "#703700",
                        "on-tertiary-container": "#e88532"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "section-gap": "120px",
                        "container-max": "1280px",
                        "stack-lg": "32px",
                        "margin-mobile": "20px",
                        "gutter": "24px",
                        "stack-md": "16px",
                        "stack-sm": "8px"
                    },
                    "fontFamily": {
                        "label-sm": ["Inter"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "display-lg": ["Montserrat"],
                        "display-lg-mobile": ["Montserrat"],
                        "label-bold": ["Inter"],
                        "headline-sm": ["Montserrat"],
                        "headline-md": ["Montserrat"]
                    },
                    "fontSize": {
                        "label-sm": ["12px", {"lineHeight": "1.2", "fontWeight": "500"}],
                        "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "display-lg": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "display-lg-mobile": ["40px", {"lineHeight": "1.2", "fontWeight": "700"}],
                        "label-bold": ["14px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "700"}],
                        "headline-sm": ["24px", {"lineHeight": "1.4", "fontWeight": "600"}],
                        "headline-md": ["32px", {"lineHeight": "1.3", "fontWeight": "700"}]
                    }
                },
            },
        }
    </script>
<style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 10px 30px -10px rgba(0, 32, 69, 0.1);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -15px rgba(0, 32, 69, 0.2);
            background: rgba(255, 255, 255, 0.85);
        }
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .gradient-text {
            background: linear-gradient(135deg, #002045 0%, #48BB78 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface selection:bg-secondary-container selection:text-on-secondary-container">
<!-- Top Navigation Bar -->
<nav class="fixed top-0 w-full z-50 backdrop-blur-xl bg-glass-surface border-b border-glass-border shadow-sm">
<div class="flex justify-between items-center px-8 py-4 max-w-container-max mx-auto">
<div class="text-headline-sm font-headline-sm font-bold text-primary">
                Code Geek Academy
            </div>
<div class="hidden md:flex items-center gap-8">
<a class="text-secondary border-b-2 border-secondary pb-1 font-label-bold text-label-bold transition-all duration-300" href="index.php">Home</a>
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="programs.php">Programs</a>
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="about.php">About</a>
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="contact.php">Contacts</a>
</div>
<a class="bg-primary text-on-primary px-6 py-2 rounded-full font-label-bold text-label-bold hover:scale-105 transition-transform shadow-md" href="parent/login.php">
                Parent Portal
            </a>
</div>
</nav>
<!-- Hero Section -->
<header class="relative min-h-screen flex items-center pt-24 overflow-hidden">
<div class="absolute inset-0 z-0">
<div class="absolute inset-0 bg-gradient-to-r from-primary/80 to-transparent z-10"></div>
<img class="w-full h-full object-cover" data-alt="A bright, modern STEM classroom filled with advanced educational technology like robotics kits and laptops. Students are seen in the soft-focused background, creating a high-energy, technical learning atmosphere. The lighting is clean and professional with a deep navy blue and vibrant green color grade to match the academy's branding." src="assets/images/hero-stem-classroom.png"/>
</div>
<div class="relative z-20 max-w-container-max mx-auto px-8 w-full">
<div class="max-w-3xl">
<span class="inline-block px-4 py-1 rounded-full bg-energetic-orange text-white text-label-bold font-label-bold mb-6 tracking-widest uppercase">
                    Latest Info
                </span>
<h1 class="font-display-lg text-display-lg md:text-display-lg text-white mb-6 reveal">
                    Empowering young minds. <br/>
<span class="text-secondary-fixed-dim">Inspiring tomorrow's innovators.</span>
</h1>
<p class="font-body-lg text-body-lg text-white/90 mb-10 max-w-xl reveal" style="transition-delay: 200ms;">
                    At Code Geek Academy, we make STEM and AI education accessible, engaging, and impactful for school students. Our programs are designed to spark curiosity and build the foundations for future success.
                </p>
<div class="flex flex-wrap gap-4 reveal" style="transition-delay: 400ms;">
<a class="bg-vibrant-green hover:bg-secondary text-white px-10 py-4 rounded-full font-label-bold text-label-bold transition-all hover:scale-105 shadow-xl flex items-center gap-2" href="#programs">
                        Explore Programs
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
</a>
<a class="glass-card px-10 py-4 rounded-full text-primary font-label-bold text-label-bold hover:bg-white/90 transition-all border-none" href="contact.php">
                        Contacts
                    </a>
</div>
</div>
</div>
</header>
<!-- Mission Section -->
<section class="py-section-gap bg-surface-bright">
<div class="max-w-container-max mx-auto px-8">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter items-center">
<div class="space-y-stack-lg reveal">
<h2 class="font-headline-md text-headline-md text-primary gradient-text">Our Mission to Shape the Future</h2>
<div class="space-y-stack-md text-on-surface-variant font-body-md text-body-md leading-relaxed">
<p>At Code Geek Academy, we are passionate about shaping the future by equipping school students with the skills and knowledge they need to thrive in the modern world.</p>
<p>Through our hands-on programs in coding, robotics, and artificial intelligence, we transform learning into an exciting journey of exploration and discovery. Our industry-aligned curriculum and expert educators ensure that every student gains technical expertise and vital skills.</p>
<p>We believe in fostering a nurturing environment where students can confidently explore their potential, collaborate with peers, and ignite their curiosity.</p>
</div>
</div>
<div class="relative reveal" style="transition-delay: 300ms;">
<div class="glass-card p-12 rounded-3xl relative z-10">
<span class="material-symbols-outlined text-secondary text-5xl mb-6">school</span>
<h3 class="font-headline-sm text-headline-sm text-primary mb-4">STEM learning for school students</h3>
<p class="text-on-surface-variant mb-8">Hands-on coding, robotics, AI, and design programs that connect technology concepts with real-world creation.</p>
<div class="flex items-center gap-4 text-vibrant-green font-label-bold">
<span class="material-symbols-outlined">check_circle</span>
<span>Industry-Aligned Curriculum</span>
</div>
</div>
<!-- Decorative blur -->
<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-secondary-fixed-dim/30 blur-3xl -z-0 rounded-full"></div>
</div>
</div>
</div>
</section>
<!-- Programs Grid -->
<section class="py-section-gap bg-surface" id="programs">
<div class="max-w-container-max mx-auto px-8">
<div class="text-center mb-16">
<h2 class="font-headline-md text-headline-md text-primary mb-4">Our Tech Pathways</h2>
<p class="text-on-surface-variant max-w-2xl mx-auto">Explore our 2026/27 core programs designed to help school students build confidence through coding, electronics, robotics, and AI projects.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-gutter">
<!-- Scratch Programming -->
<div class="glass-card group overflow-hidden rounded-3xl reveal">
<div class="h-40 overflow-hidden bg-white">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Students learning Scratch Programming in a STEM classroom" src="assets/images/course-scratch-real.png"/>
</div>
<div class="p-8">
<div class="flex justify-between items-start mb-4">
<h3 class="font-headline-sm text-headline-sm text-primary">Scratch Programming</h3>
<span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-label-sm font-label-bold">Beginner</span>
</div>
<p class="text-on-surface-variant mb-6">A creative first step into coding where students build games, stories, quizzes, and animations using visual blocks.</p>
<a class="text-secondary font-label-bold flex items-center gap-2 group/link" href="programs.php">
                            Learn More 
                            <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-1">arrow_forward</span>
</a>
</div>
</div>
<!-- Microbit Computing -->
<div class="glass-card group overflow-hidden rounded-3xl reveal" style="transition-delay: 200ms;">
<div class="h-40 overflow-hidden bg-white">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Students building Microbit Computing electronics projects" src="assets/images/course-microbit-computing-real.png"/>
</div>
<div class="p-8">
<div class="flex justify-between items-start mb-4">
<h3 class="font-headline-sm text-headline-sm text-primary">Microbit Computing</h3>
<span class="bg-primary-fixed text-primary px-3 py-1 rounded-full text-label-sm font-label-bold">Hardware</span>
</div>
<p class="text-on-surface-variant mb-6">Students connect code with LEDs, sensors, buttons, sound, temperature, and movement through hands-on builds.</p>
<a class="text-secondary font-label-bold flex items-center gap-2 group/link" href="programs.php">
                            Learn More 
                            <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-1">arrow_forward</span>
</a>
</div>
</div>
<!-- Microbit Robotics -->
<div class="glass-card group overflow-hidden rounded-3xl reveal" style="transition-delay: 400ms;">
<div class="h-40 overflow-hidden bg-white">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Students testing a Microbit Robotics car project" src="assets/images/course-microbit-robotics-real.png"/>
</div>
<div class="p-8">
<div class="flex justify-between items-start mb-4">
<h3 class="font-headline-sm text-headline-sm text-primary">Microbit Robotics</h3>
<span class="bg-energetic-orange/10 text-energetic-orange px-3 py-1 rounded-full text-label-sm font-label-bold">Robotics</span>
</div>
<p class="text-on-surface-variant mb-6">A practical robotics pathway where students program motors, sensors, cars, barriers, smart bins, and automation projects.</p>
<a class="text-secondary font-label-bold flex items-center gap-2 group/link" href="programs.php">
                            Learn More 
                            <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-1">arrow_forward</span>
</a>
</div>
</div>
<!-- Artificial Intelligence -->
<div class="glass-card group overflow-hidden rounded-3xl reveal" style="transition-delay: 600ms;">
<div class="h-40 overflow-hidden bg-white">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Students exploring Artificial Intelligence projects" src="assets/images/course-ai-real.png"/>
</div>
<div class="p-8">
<div class="flex justify-between items-start mb-4">
<h3 class="font-headline-sm text-headline-sm text-primary">Artificial Intelligence</h3>
<span class="bg-secondary-fixed text-on-secondary-fixed-variant px-3 py-1 rounded-full text-label-sm font-label-bold">AI</span>
</div>
<p class="text-on-surface-variant mb-6">Students explore computer vision, speech, text recognition, ChatGPT ideas, and machine learning through PictoBlox.</p>
<a class="text-secondary font-label-bold flex items-center gap-2 group/link" href="programs.php">
                            Learn More 
                            <span class="material-symbols-outlined text-sm transition-transform group-hover/link:translate-x-1">arrow_forward</span>
</a>
</div>
</div>
</div>
</div>
</section>
<!-- Key Values Bento Grid -->
<section class="py-section-gap bg-surface-container-low overflow-hidden">
<div class="max-w-container-max mx-auto px-8">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-gutter">
<div class="reveal">
<h2 class="font-headline-md text-headline-md text-primary mb-2">Key Values</h2>
<p class="text-on-surface-variant">The foundation of everything we do at the academy.</p>
</div>
<div class="text-on-surface-variant font-label-bold text-label-bold reveal">
                    Practical Learning • Confidence • Curiosity
                </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter">
<!-- Value 01 -->
<div class="glass-card p-10 rounded-3xl reveal" style="transition-delay: 100ms;">
<div class="text-label-bold font-label-bold text-secondary mb-8">01</div>
<span class="material-symbols-outlined text-energetic-orange text-4xl mb-6">lightbulb</span>
<h3 class="font-headline-sm text-headline-sm text-primary mb-4">Innovation</h3>
<p class="text-on-surface-variant text-body-md">Fostering creativity and encouraging forward-thinking approaches to problem-solving in STEM.</p>
</div>
<!-- Value 02 -->
<div class="glass-card p-10 rounded-3xl reveal" style="transition-delay: 200ms;">
<div class="text-label-bold font-label-bold text-secondary mb-8">02</div>
<span class="material-symbols-outlined text-vibrant-green text-4xl mb-6">verified</span>
<h3 class="font-headline-sm text-headline-sm text-primary mb-4">Excellence</h3>
<p class="text-on-surface-variant text-body-md">Striving for high standards, ensuring students receive strong mentorship and resources.</p>
</div>
<!-- Value 03 -->
<div class="glass-card p-10 rounded-3xl reveal" style="transition-delay: 300ms;">
<div class="text-label-bold font-label-bold text-secondary mb-8">03</div>
<span class="material-symbols-outlined text-primary text-4xl mb-6">groups</span>
<h3 class="font-headline-sm text-headline-sm text-primary mb-4">Collaboration</h3>
<p class="text-on-surface-variant text-body-md">Encouraging teamwork and partnerships between students and industry pros.</p>
</div>
<!-- Value 04 -->
<div class="glass-card p-10 rounded-3xl reveal" style="transition-delay: 400ms;">
<div class="text-label-bold font-label-bold text-secondary mb-8">04</div>
<span class="material-symbols-outlined text-on-tertiary-container text-4xl mb-6">architecture</span>
<h3 class="font-headline-sm text-headline-sm text-primary mb-4">Application</h3>
<p class="text-on-surface-variant text-body-md">Bridging the gap between theory and practical, real-world tech applications.</p>
</div>
</div>
</div>
</section>
<!-- CTA Section -->
<section class="py-section-gap relative overflow-hidden">
<div class="absolute inset-0 bg-primary -z-10">
<div class="absolute top-0 right-0 w-1/2 h-full bg-vibrant-green/10 blur-[100px]"></div>
</div>
<div class="max-w-4xl mx-auto px-8 text-center">
<h2 class="font-display-lg text-display-lg-mobile md:text-display-lg text-white mb-8 reveal">Ready to start the journey?</h2>
<p class="text-white/80 font-body-lg text-body-lg mb-12 reveal" style="transition-delay: 200ms;">Join hundreds of students shaping the future with code. Secure your spot in our upcoming intake.</p>
<div class="flex flex-col md:flex-row justify-center gap-6 reveal" style="transition-delay: 400ms;">
<button class="bg-vibrant-green text-white px-12 py-5 rounded-full font-label-bold text-label-bold text-lg hover:scale-105 transition-all shadow-2xl">Register Now</button>
<button class="border-2 border-white/30 text-white px-12 py-5 rounded-full font-label-bold text-label-bold text-lg hover:bg-white hover:text-primary transition-all">Download Prospectus</button>
</div>
</div>
</section>
<!-- Footer -->
<footer class="bg-primary py-section-gap text-on-primary">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter max-w-container-max mx-auto px-margin-mobile">
<div>
<a class="inline-flex items-center mb-6" href="index.php" aria-label="Code Geek Academy home">
<img class="h-16 w-auto object-contain" src="assets/images/logo-codegeek-white.png" alt="Code Geek Academy"/>
</a>
<p class="text-base leading-7 text-on-primary/75 max-w-sm">Empowering the next generation of innovators with future-ready STEM, coding, robotics, and AI skills.</p>
</div>
<div class="flex flex-col gap-3">
<h4 class="text-sm font-bold uppercase tracking-widest text-on-primary mb-1">Explore</h4>
<a class="text-base leading-7 text-on-primary/80 hover:text-vibrant-green transition-colors" href="index.php">Home</a>
<a class="text-base leading-7 text-on-primary/80 hover:text-vibrant-green transition-colors" href="programs.php">Programs</a>
<a class="text-base leading-7 text-on-primary/80 hover:text-vibrant-green transition-colors" href="about.php">About</a>
<a class="text-base leading-7 text-on-primary/80 hover:text-vibrant-green transition-colors" href="contact.php">Contacts</a>
</div>
<div class="flex flex-col gap-3">
<h4 class="text-sm font-bold uppercase tracking-widest text-on-primary mb-1">Support</h4>
<a class="text-base leading-7 text-on-primary/80 hover:text-vibrant-green transition-colors" href="parent/login.php">Parent Portal</a>
<a class="text-base leading-7 text-on-primary/80 hover:text-vibrant-green transition-colors" href="#">Privacy Policy</a>
<a class="text-base leading-7 text-on-primary/80 hover:text-vibrant-green transition-colors" href="#">Terms of Service</a>
</div>
<div class="flex flex-col gap-3">
<h4 class="text-sm font-bold uppercase tracking-widest text-on-primary mb-1">Contact</h4>
<a class="text-base leading-7 text-on-primary/80 hover:text-vibrant-green transition-colors" href="contact.php">Send an enquiry</a>
<span class="text-base leading-7 text-on-primary/75">codegeekacademy.com.my</span>
</div>
</div>
<div class="max-w-container-max mx-auto px-margin-mobile mt-section-gap pt-8 border-t border-white/10">
<p class="text-sm text-on-primary/60">© 2026 Code Geek Academy. All rights reserved.</p>
</div>
</footer>
<script>
        // Scroll Reveal Implementation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Smooth Navbar Interaction
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('py-2', 'shadow-md');
                nav.classList.remove('py-4', 'shadow-sm');
            } else {
                nav.classList.add('py-4', 'shadow-sm');
                nav.classList.remove('py-2', 'shadow-md');
            }
        });
    </script>
</body></html>
