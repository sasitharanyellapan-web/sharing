<!DOCTYPE html>

<html class="scroll-smooth" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>About Us | Code Geek Academy</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Inter:wght@400;500;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Montserrat:wght@100..900&display=swap" rel="stylesheet"/>
<!-- Tailwind Configuration -->
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-dim": "#d7dadc",
                    "on-primary-container": "#86a0cd",
                    "on-primary": "#ffffff",
                    "on-secondary-fixed-variant": "#00522c",
                    "deep-navy": "#1A365D",
                    "tertiary": "#371800",
                    "on-tertiary": "#ffffff",
                    "surface-container": "#ebeef0",
                    "on-tertiary-container": "#e88532",
                    "inverse-on-surface": "#eef1f3",
                    "on-primary-fixed": "#001b3c",
                    "inverse-primary": "#adc7f7",
                    "error-container": "#ffdad6",
                    "vibrant-green": "#48BB78",
                    "on-tertiary-fixed-variant": "#703700",
                    "secondary-fixed-dim": "#6bdc96",
                    "primary-fixed-dim": "#adc7f7",
                    "surface-variant": "#e0e3e5",
                    "on-tertiary-fixed": "#301400",
                    "on-surface": "#181c1e",
                    "on-secondary-container": "#00723f",
                    "energetic-orange": "#ED8936",
                    "secondary-fixed": "#88f9b0",
                    "glass-surface": "rgba(255, 255, 255, 0.7)",
                    "primary": "#002045",
                    "surface-container-low": "#f1f4f6",
                    "on-surface-variant": "#43474e",
                    "secondary": "#006d3c",
                    "surface": "#f7fafc",
                    "tertiary-fixed": "#ffdcc5",
                    "on-secondary": "#ffffff",
                    "on-error-container": "#93000a",
                    "on-secondary-fixed": "#00210f",
                    "background": "#f7fafc",
                    "surface-tint": "#455f88",
                    "tertiary-container": "#572900",
                    "surface-container-highest": "#e0e3e5",
                    "on-primary-fixed-variant": "#2d476f",
                    "on-error": "#ffffff",
                    "error": "#ba1a1a",
                    "outline": "#74777f",
                    "surface-container-lowest": "#ffffff",
                    "surface-container-high": "#e5e9eb",
                    "secondary-container": "#85f6ad",
                    "primary-fixed": "#d6e3ff",
                    "outline-variant": "#c4c6cf",
                    "on-background": "#181c1e",
                    "surface-bright": "#f7fafc",
                    "tertiary-fixed-dim": "#ffb783",
                    "primary-container": "#1a365d",
                    "inverse-surface": "#2d3133",
                    "glass-border": "rgba(255, 255, 255, 0.4)"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "stack-sm": "8px",
                    "stack-lg": "32px",
                    "margin-mobile": "20px",
                    "stack-md": "16px",
                    "section-gap": "120px",
                    "container-max": "1280px",
                    "gutter": "24px"
            },
            "fontFamily": {
                    "headline-sm": ["Montserrat"],
                    "display-lg": ["Montserrat"],
                    "body-lg": ["Inter"],
                    "body-md": ["Inter"],
                    "label-sm": ["Inter"],
                    "label-bold": ["Inter"],
                    "display-lg-mobile": ["Montserrat"],
                    "headline-md": ["Montserrat"]
            },
            "fontSize": {
                    "headline-sm": ["24px", {"lineHeight": "1.4", "fontWeight": "600"}],
                    "display-lg": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "label-sm": ["12px", {"lineHeight": "1.2", "fontWeight": "500"}],
                    "label-bold": ["14px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "700"}],
                    "display-lg-mobile": ["40px", {"lineHeight": "1.2", "fontWeight": "700"}],
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
            transition: all 0.3s ease-in-out;
        }
        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -10px rgba(26, 54, 93, 0.1);
        }
        .vibrant-gradient {
            background: linear-gradient(135deg, #002045 0%, #006d3c 100%);
        }
        .kinetic-hover:hover {
            scale: 1.05;
            transition: transform 0.2s;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md overflow-x-hidden">
<!-- TopNavBar -->
<header class="fixed top-0 w-full z-50 backdrop-blur-xl bg-glass-surface border-b border-glass-border shadow-sm">
<nav class="flex justify-between items-center px-8 py-4 max-w-container-max mx-auto">
<div class="text-headline-sm font-headline-sm font-bold text-primary">Code Geek Academy</div>
<div class="hidden md:flex space-x-8 items-center">
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="index.php">Home</a>
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="programs.php">Programs</a>
<a class="text-secondary border-b-2 border-secondary pb-1 font-label-bold text-label-bold" href="about.php">About</a>
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="contact.php">Contacts</a>
</div>
<a class="bg-primary text-on-primary px-6 py-2 rounded-full font-label-bold text-label-bold hover:scale-105 transition-all duration-300 shadow-md" href="parent/login.php">Parent Portal</a>
</nav>
</header>
<main class="pt-24">
<!-- Hero Section -->
<section class="relative px-margin-mobile md:px-8 py-section-gap max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-2 gap-gutter items-center">
<div class="z-10">
<span class="inline-block bg-energetic-orange text-white text-label-sm font-label-bold px-3 py-1 rounded-full mb-stack-md uppercase tracking-widest">Our Story</span>
<h1 class="text-display-lg-mobile md:text-display-lg font-display-lg text-primary mb-stack-lg">Shaping the Innovators of Tomorrow</h1>
<p class="text-body-lg font-body-lg text-on-surface-variant mb-stack-lg max-w-xl">
                    At Code Geek Academy, we believe every child has the potential to lead the next digital revolution. Our journey began with a simple mission: to bridge the gap between curiosity and creation through hands-on STEM education that inspires a lifelong passion for learning.
                </p>
<div class="flex gap-stack-md">
<button class="bg-primary text-on-primary px-8 py-4 rounded-full font-label-bold text-label-bold kinetic-hover shadow-lg">Start Learning</button>
<button class="border-2 border-primary text-primary px-8 py-4 rounded-full font-label-bold text-label-bold kinetic-hover">Watch Our Story</button>
</div>
</div>
<div class="relative rounded-xl overflow-hidden shadow-2xl h-[400px] md:h-[600px]">
<img alt="STEM Classroom Collaboration" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLtywpOKiLFh6B4tDqeWPiIjEIThvyrNoWhss3lq0sVsZ0QSGNCaErygvbopIrTm6j1b5JE33xZDktOrfa1y3ZZahoHuqt5kQ6eGEe6tGjtplYpCTrQWVjGoFiLM_OTqlj6pjdT2fCvHFMFJevqU4_zOJ9KPhD9HQXyTj3LKkO5m0sk78z0pKxSa0sG01N_p--y3TZ9L4BiwGmG0v6OEdBQ9yNLGcRdTHfeMivvc-NGoN-OZ0DtUo56pNC7L"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/20 to-transparent"></div>
</div>
<!-- Ambient Glow Background -->
<div class="absolute top-0 right-0 -z-10 w-[500px] h-[500px] bg-secondary/10 rounded-full blur-[100px]"></div>
</section>
<!-- Mission & Vision -->
<section class="bg-surface-container-low py-section-gap">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-8">
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
<div class="glass-card p-10 rounded-xl relative overflow-hidden group">
<div class="absolute -top-10 -right-10 w-40 h-40 bg-secondary/10 rounded-full blur-2xl group-hover:bg-secondary/20 transition-all"></div>
<span class="material-symbols-outlined text-4xl text-secondary mb-stack-md">rocket_launch</span>
<h2 class="text-headline-md font-headline-md text-primary mb-stack-md">Our Mission</h2>
<p class="text-body-lg font-body-lg text-on-surface-variant">To make STEM and AI education accessible, engaging, and impactful for students of all backgrounds, ensuring they have the tools to thrive in a tech-driven future.</p>
</div>
<div class="glass-card p-10 rounded-xl relative overflow-hidden group">
<div class="absolute -top-10 -right-10 w-40 h-40 bg-energetic-orange/10 rounded-full blur-2xl group-hover:bg-energetic-orange/20 transition-all"></div>
<span class="material-symbols-outlined text-4xl text-energetic-orange mb-stack-md">visibility</span>
<h2 class="text-headline-md font-headline-md text-primary mb-stack-md">Our Vision</h2>
<p class="text-body-lg font-body-lg text-on-surface-variant">Preparing future leaders to shape the world through a lifelong love for innovation, critical thinking, and a commitment to positive global impact.</p>
</div>
</div>
</div>
</section>
<!-- Core Values Grid -->
<section class="py-section-gap max-w-container-max mx-auto px-margin-mobile md:px-8">
<div class="text-center mb-16">
<h2 class="text-headline-md font-headline-md text-primary mb-4">Guided by Our Core Values</h2>
<div class="w-24 h-1 bg-vibrant-green mx-auto rounded-full"></div>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
<!-- Innovation -->
<div class="glass-card p-8 rounded-xl text-center flex flex-col items-center">
<div class="w-16 h-16 rounded-full bg-secondary-fixed flex items-center justify-center mb-stack-lg">
<span class="material-symbols-outlined text-secondary text-3xl" style="font-variation-settings: 'FILL' 1;">lightbulb</span>
</div>
<h3 class="text-headline-sm font-headline-sm text-primary mb-stack-sm">Innovation</h3>
<p class="text-body-md font-body-md text-on-surface-variant">Constantly pushing boundaries and exploring new technologies in our curriculum.</p>
</div>
<!-- Excellence -->
<div class="glass-card p-8 rounded-xl text-center flex flex-col items-center">
<div class="w-16 h-16 rounded-full bg-primary-fixed flex items-center justify-center mb-stack-lg">
<span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">verified</span>
</div>
<h3 class="text-headline-sm font-headline-sm text-primary mb-stack-sm">Excellence</h3>
<p class="text-body-md font-body-md text-on-surface-variant">Upholding the highest standards in educational quality and student outcomes.</p>
</div>
<!-- Collaboration -->
<div class="glass-card p-8 rounded-xl text-center flex flex-col items-center">
<div class="w-16 h-16 rounded-full bg-tertiary-fixed flex items-center justify-center mb-stack-lg">
<span class="material-symbols-outlined text-on-tertiary-container text-3xl" style="font-variation-settings: 'FILL' 1;">groups</span>
</div>
<h3 class="text-headline-sm font-headline-sm text-primary mb-stack-sm">Collaboration</h3>
<p class="text-body-md font-body-md text-on-surface-variant">Fostering a community where students and mentors learn together.</p>
</div>
<!-- Application of Knowledge -->
<div class="glass-card p-8 rounded-xl text-center flex flex-col items-center">
<div class="w-16 h-16 rounded-full bg-secondary-fixed-dim/30 flex items-center justify-center mb-stack-lg">
<span class="material-symbols-outlined text-secondary text-3xl" style="font-variation-settings: 'FILL' 1;">terminal</span>
</div>
<h3 class="text-headline-sm font-headline-sm text-primary mb-stack-sm">Application</h3>
<p class="text-body-md font-body-md text-on-surface-variant">Bridging theory and practice through project-based, real-world challenges.</p>
</div>
</div>
</section>
<!-- Meet Our Mentors -->
<section class="bg-surface-container-high py-section-gap">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-8">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-stack-md">
<div>
<h2 class="text-headline-md font-headline-md text-primary">Meet Our Mentors</h2>
<p class="text-body-lg font-body-lg text-on-surface-variant">The experts guiding our students toward the future.</p>
</div>
</div>
<div class="glass-card group rounded-xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 gap-0 items-stretch">
<div class="relative overflow-hidden min-h-[420px] lg:min-h-[560px] lg:col-span-5">
<img class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-110" alt="Sasitharan Yellapan, Founder of Code Geek Academy" src="assets/images/mentor-sasitharan-yellapan.png"/>
<div class="absolute bottom-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full text-label-sm font-label-bold">Founder</div>
</div>
<div class="lg:col-span-7 p-8 md:p-12 flex flex-col justify-center">
<span class="text-label-bold font-label-bold text-secondary mb-stack-md uppercase tracking-wide">Lead Instructor</span>
<h4 class="text-headline-md font-headline-md text-primary mb-stack-md">Sasitharan Yellapan</h4>
<p class="text-body-lg font-body-lg text-on-surface-variant italic leading-relaxed">"As the Founder of Code Geek Academy, I believe every child deserves the opportunity to explore technology, think critically, and create with confidence. My passion is helping students transform curiosity into innovation through coding, robotics, and AI."</p>
</div>
</div>
</div>
</section>
<!-- Join the Mission CTA -->
<section class="py-section-gap">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-8">
<div class="vibrant-gradient rounded-3xl p-12 md:p-20 text-center relative overflow-hidden">
<!-- Geometric Accent Shapes -->
<div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
<div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary/20 rounded-full translate-x-1/4 translate-y-1/4 blur-3xl"></div>
<div class="relative z-10 max-w-2xl mx-auto">
<h2 class="text-display-lg-mobile md:text-headline-md font-display-lg text-on-primary mb-stack-md">Ready to start your coding adventure?</h2>
<p class="text-body-lg font-body-lg text-on-primary/80 mb-stack-lg">Join hundreds of young innovators who are already building the future today. Programs available for all skill levels.</p>
<div class="flex flex-col sm:flex-row justify-center gap-stack-md">
<button class="bg-vibrant-green text-primary px-10 py-5 rounded-full font-label-bold text-label-bold hover:bg-white hover:scale-105 transition-all shadow-xl">Explore Programs</button>
<button class="bg-white/10 text-on-primary backdrop-blur-md border border-white/20 px-10 py-5 rounded-full font-label-bold text-label-bold hover:bg-white/20 transition-all">Book a Trial Session</button>
</div>
</div>
</div>
</div>
</section>
</main>
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
        // Micro-interaction for glass cards
        document.querySelectorAll('.glass-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            });
        });
    </script>
</body></html>
