<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('parent');
$current_user = current_user();
?>
<!DOCTYPE html>

<html class="scroll-smooth" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Student Schedule | Parent Portal - Code Geek Academy</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@400;500;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Montserrat:wght@100..900&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-container-lowest": "#ffffff",
                    "tertiary-fixed-dim": "#ffb783",
                    "on-secondary": "#ffffff",
                    "on-primary": "#ffffff",
                    "surface-tint": "#455f88",
                    "on-secondary-fixed-variant": "#00522c",
                    "on-surface": "#181c1e",
                    "on-error-container": "#93000a",
                    "surface-dim": "#d7dadc",
                    "on-primary-container": "#86a0cd",
                    "surface-container-highest": "#e0e3e5",
                    "secondary": "#006d3c",
                    "background": "#f7fafc",
                    "on-tertiary-fixed-variant": "#703700",
                    "tertiary": "#371800",
                    "surface-container": "#ebeef0",
                    "secondary-container": "#85f6ad",
                    "surface-variant": "#e0e3e5",
                    "on-tertiary-fixed": "#301400",
                    "primary-fixed": "#d6e3ff",
                    "on-primary-fixed": "#001b3c",
                    "primary-container": "#1a365d",
                    "inverse-on-surface": "#eef1f3",
                    "vibrant-green": "#48BB78",
                    "on-secondary-container": "#00723f",
                    "on-primary-fixed-variant": "#2d476f",
                    "energetic-orange": "#ED8936",
                    "outline-variant": "#c4c6cf",
                    "on-error": "#ffffff",
                    "error-container": "#ffdad6",
                    "on-surface-variant": "#43474e",
                    "secondary-fixed-dim": "#6bdc96",
                    "tertiary-container": "#572900",
                    "secondary-fixed": "#88f9b0",
                    "on-secondary-fixed": "#00210f",
                    "on-tertiary": "#ffffff",
                    "error": "#ba1a1a",
                    "surface-container-low": "#f1f4f6",
                    "glass-surface": "rgba(255, 255, 255, 0.7)",
                    "glass-border": "rgba(255, 255, 255, 0.4)",
                    "surface-container-high": "#e5e9eb",
                    "inverse-primary": "#adc7f7",
                    "tertiary-fixed": "#ffdcc5",
                    "on-background": "#181c1e",
                    "outline": "#74777f",
                    "on-tertiary-container": "#e88532",
                    "surface": "#f7fafc",
                    "surface-bright": "#f7fafc",
                    "deep-navy": "#1A365D",
                    "inverse-surface": "#2d3133",
                    "primary-fixed-dim": "#adc7f7",
                    "primary": "#002045"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "stack-md": "16px",
                    "margin-mobile": "20px",
                    "gutter": "24px",
                    "section-gap": "120px",
                    "stack-sm": "8px",
                    "stack-lg": "32px",
                    "container-max": "1280px"
            },
            "fontFamily": {
                    "label-bold": ["Inter"],
                    "display-lg-mobile": ["Montserrat"],
                    "label-sm": ["Inter"],
                    "body-md": ["Inter"],
                    "display-lg": ["Montserrat"],
                    "body-lg": ["Inter"],
                    "headline-sm": ["Montserrat"],
                    "headline-md": ["Montserrat"]
            },
            "fontSize": {
                    "label-bold": ["14px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "700"}],
                    "display-lg-mobile": ["40px", {"lineHeight": "1.2", "fontWeight": "700"}],
                    "label-sm": ["12px", {"lineHeight": "1.2", "fontWeight": "500"}],
                    "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "display-lg": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "headline-sm": ["24px", {"lineHeight": "1.4", "fontWeight": "600"}],
                    "headline-md": ["32px", {"lineHeight": "1.3", "fontWeight": "700"}]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(26, 54, 93, 0.1);
        }
        .kinetic-gradient {
            background: radial-gradient(circle at top right, rgba(72, 187, 120, 0.1), transparent),
                        radial-gradient(circle at bottom left, rgba(26, 54, 93, 0.05), transparent);
        }
        .scroll-hide::-webkit-scrollbar { display: none; }
        .active-schedule-item {
            border-left: 4px solid #48BB78;
            background: rgba(72, 187, 120, 0.05);
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md kinetic-gradient min-h-screen">
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 backdrop-blur-xl bg-glass-surface border-b border-glass-border shadow-sm">
<div class="flex justify-between items-center px-8 py-4 max-w-container-max mx-auto">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-3xl">terminal</span>
<span class="text-headline-sm font-headline-sm font-bold text-primary">Code Geek Academy</span>
</div>
<div class="hidden md:flex items-center gap-8">
<a class="text-on-surface-variant hover:text-secondary transition-all duration-200 font-label-bold text-label-bold" href="../index.php">Home</a>
<a class="text-on-surface-variant hover:text-secondary transition-all duration-200 font-label-bold text-label-bold" href="../programs.php">Programs</a>
<a class="text-on-surface-variant hover:text-secondary transition-all duration-200 font-label-bold text-label-bold" href="../about.php">About</a>
<a class="text-on-surface-variant hover:text-secondary transition-all duration-200 font-label-bold text-label-bold" href="../contact.php">Contacts</a>
</div>
<a class="bg-primary text-on-primary px-6 py-2 rounded-full font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 shadow-lg inline-block" href="logout.php">
                Log Out
            </a>
</div>
</nav>
<!-- Main Canvas -->
<main class="pt-32 pb-section-gap px-margin-mobile md:px-8 max-w-container-max mx-auto">
<!-- Header Section & Profile Switcher -->
<header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-stack-lg">
<div>
<h1 class="text-headline-md font-headline-md text-primary mb-2">Student Schedule</h1>
<p class="text-on-surface-variant">Manage and track your child's learning journey and upcoming milestones.</p>
</div>
<!-- Student Profile Switcher -->
<div class="glass-card p-2 rounded-full flex items-center gap-2 shadow-sm">
<div class="flex -space-x-2">
<div class="w-10 h-10 rounded-full border-2 border-white overflow-hidden ring-2 ring-vibrant-green/20">
<img class="w-full h-full object-cover" data-alt="A portrait of a young Asian boy named Ethan, smiling brightly, wearing a modern blue tech-themed hoodie. The background is a soft-focus classroom with neon blue and green accents, perfectly aligning with a high-end tech academy aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC6bwNeloP483bphNV8x2ff9GHGNt6GI4Yxk7gm2SFXZTNQopuaOLNbwTJycBmQaMEFlQZ3HgFqV-k9rF3jAjdouaPDKUAYTcLbKLijLAlT1jR3-DM5nhOV4knPau_ilbuCp_sW-YJh0GocFEFTBOFR_82fygWqLF_396mlcRoZjpnXsXautbgkeORrZXscutD_G0qFdxk5IKOrVBTGG9T7mS45M3978LNXVT0xR4DEbiE-re2UBvyy7zVatNy9rd-rHQXi4HPZL99P"/>
</div>
<div class="w-10 h-10 rounded-full border-2 border-white overflow-hidden opacity-60 hover:opacity-100 transition-opacity cursor-pointer">
<img class="w-full h-full object-cover" data-alt="A portrait of a young girl with curly hair and glasses, looking curious and engaged. She wears a yellow shirt that contrasts with a sleek, minimalist tech background. The lighting is professional and high-key, suitable for an educational portal." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCtfdApUr1R6Z3knFZNUBkz-wF_yWJ5pieLwiESJVKOrZxMPgczCLxGBNPlJfrJZhD-KyE5JCy-lUSPZHAeaVONEAZhx8uYlqwrZS4FPgOC-pRRx95Jy-z1Z7knZYGe2-8h5lNbGlaZv945R-D4GKG98sUPR9mB_M7yIcSZRAJkyZzHG2qjHfXY0dzoll_Mx_-brbpi_h79DlmQehaEeIXIf-rLocUt8xJNRTdy7hnq0FBnTxhrbnDZGaHm7p4qcMgZa93fCEBqL0T8"/>
</div>
</div>
<div class="px-4 pr-6">
<p class="text-label-bold font-label-bold text-primary leading-none">Ethan Chen</p>
<p class="text-label-sm font-label-sm text-on-surface-variant">Level 3 Enthusiast</p>
</div>
<span class="material-symbols-outlined text-on-surface-variant pr-2">unfold_more</span>
</div>
</header>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Weekly Calendar View (Left/Main Column) -->
<section class="lg:col-span-8">
<div class="glass-card rounded-xl p-6 shadow-sm overflow-hidden">
<div class="flex justify-between items-center mb-8">
<div class="flex items-center gap-4">
<h2 class="text-headline-sm font-headline-sm text-primary">This Week</h2>
<span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-label-sm font-label-sm">October 14 - 20</span>
</div>
<div class="flex gap-2">
<button class="p-2 rounded-lg border border-outline-variant hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<button class="p-2 rounded-lg border border-outline-variant hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>
</div>
<div class="grid grid-cols-7 gap-2 mb-4">
<div class="text-center text-label-sm font-label-bold text-on-surface-variant py-2">MON</div>
<div class="text-center text-label-sm font-label-bold text-on-surface-variant py-2">TUE</div>
<div class="text-center text-label-sm font-label-bold text-on-surface-variant py-2">WED</div>
<div class="text-center text-label-sm font-label-bold text-on-surface-variant py-2">THU</div>
<div class="text-center text-label-sm font-label-bold text-on-surface-variant py-2">FRI</div>
<div class="text-center text-label-sm font-label-bold text-on-surface-variant py-2">SAT</div>
<div class="text-center text-label-sm font-label-bold text-on-surface-variant py-2">SUN</div>
</div>
<div class="grid grid-cols-7 gap-4 min-h-[500px]">
<!-- Column Monday -->
<div class="flex flex-col gap-4">
<div class="bg-primary/5 rounded-lg p-3 border-t-4 border-primary group cursor-pointer transition-all hover:bg-primary/10">
<p class="text-label-sm font-label-bold text-primary">04:30 PM</p>
<h3 class="font-bold text-primary mt-1 text-sm leading-tight">Robotics & IoT</h3>
<div class="flex items-center gap-1 mt-2 text-label-sm text-on-surface-variant">
<span class="material-symbols-outlined text-[14px]">person</span>
<span>Dr. Aris</span>
</div>
</div>
</div>
<!-- Column Tuesday -->
<div class="flex flex-col gap-4"></div>
<!-- Column Wednesday -->
<div class="flex flex-col gap-4">
<div class="active-schedule-item rounded-lg p-3 group cursor-pointer transition-all shadow-sm ring-1 ring-vibrant-green/20">
<p class="text-label-sm font-label-bold text-vibrant-green">04:30 PM</p>
<h3 class="font-bold text-primary mt-1 text-sm leading-tight">Game Dev with Python</h3>
<div class="flex items-center gap-1 mt-2 text-label-sm text-on-surface-variant">
<span class="material-symbols-outlined text-[14px]">person</span>
<span>Sarah J.</span>
</div>
<div class="mt-2 flex items-center gap-1 text-[10px] uppercase tracking-wider font-bold text-vibrant-green">
<span class="w-1.5 h-1.5 rounded-full bg-vibrant-green animate-pulse"></span>
                                    Now Live
                                </div>
</div>
</div>
<!-- Column Thursday -->
<div class="flex flex-col gap-4"></div>
<!-- Column Friday -->
<div class="flex flex-col gap-4">
<div class="bg-energetic-orange/5 rounded-lg p-3 border-t-4 border-energetic-orange group cursor-pointer transition-all hover:bg-energetic-orange/10">
<p class="text-label-sm font-label-bold text-energetic-orange">05:00 PM</p>
<h3 class="font-bold text-primary mt-1 text-sm leading-tight">Web Mastery</h3>
<div class="flex items-center gap-1 mt-2 text-label-sm text-on-surface-variant">
<span class="material-symbols-outlined text-[14px]">person</span>
<span>K. Miller</span>
</div>
</div>
</div>
<!-- Column Saturday -->
<div class="flex flex-col gap-4">
<div class="bg-tertiary-container/5 rounded-lg p-3 border-t-4 border-tertiary-container group cursor-pointer transition-all hover:bg-tertiary-container/10">
<p class="text-label-sm font-label-bold text-tertiary-container">10:00 AM</p>
<h3 class="font-bold text-primary mt-1 text-sm leading-tight">Math Logic</h3>
<div class="flex items-center gap-1 mt-2 text-label-sm text-on-surface-variant">
<span class="material-symbols-outlined text-[14px]">person</span>
<span>Prof. Lin</span>
</div>
</div>
</div>
<!-- Column Sunday -->
<div class="flex flex-col gap-4"></div>
</div>
</div>
</section>
<!-- Details & Upcoming Sidebar (Right Column) -->
<aside class="lg:col-span-4 space-y-8">
<!-- Class Details Sidebar -->
<div class="glass-card rounded-xl p-6 shadow-sm border-l-4 border-vibrant-green">
<div class="flex justify-between items-start mb-6">
<div>
<span class="text-label-sm font-label-bold text-vibrant-green uppercase tracking-widest">Active Class</span>
<h2 class="text-headline-sm font-headline-sm text-primary mt-1">Game Dev with Python</h2>
</div>
<div class="w-12 h-12 rounded-xl bg-vibrant-green/10 flex items-center justify-center">
<span class="material-symbols-outlined text-vibrant-green">sports_esports</span>
</div>
</div>
<div class="space-y-4 mb-8">
<div class="flex items-center gap-4">
<div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center">
<span class="material-symbols-outlined text-on-surface-variant text-sm">meeting_room</span>
</div>
<div>
<p class="text-label-sm text-on-surface-variant leading-none">Room Number</p>
<p class="font-bold text-primary">Lab 402 (Digital Arts Wing)</p>
</div>
</div>
<div class="flex items-center gap-4">
<div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center">
<span class="material-symbols-outlined text-on-surface-variant text-sm">menu_book</span>
</div>
<div>
<p class="text-label-sm text-on-surface-variant leading-none">Today's Lesson</p>
<p class="font-bold text-primary">Physics Engines & Collisions</p>
</div>
</div>
</div>
<a class="block w-full text-center bg-vibrant-green text-on-primary py-4 rounded-xl font-label-bold hover:scale-[1.02] transition-transform shadow-lg shadow-vibrant-green/20" href="#">
                        Join Virtual Link
                    </a>
</div>
<!-- Upcoming Events/Workshops -->
<div class="glass-card rounded-xl p-6 shadow-sm">
<h2 class="text-headline-sm font-headline-sm text-primary mb-6">Upcoming Events</h2>
<div class="space-y-4">
<div class="flex items-start gap-4 p-3 rounded-lg hover:bg-white/50 transition-colors cursor-pointer border border-transparent hover:border-glass-border">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-energetic-orange/10 flex flex-col items-center justify-center text-energetic-orange">
<span class="text-xs font-bold leading-none">OCT</span>
<span class="text-lg font-extrabold leading-none">24</span>
</div>
<div>
<h4 class="font-bold text-primary text-sm">STEM Fair: Fall Edition</h4>
<p class="text-label-sm text-on-surface-variant">4:00 PM - Main Auditorium</p>
</div>
</div>
<div class="flex items-start gap-4 p-3 rounded-lg hover:bg-white/50 transition-colors cursor-pointer border border-transparent hover:border-glass-border">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary/10 flex flex-col items-center justify-center text-primary">
<span class="text-xs font-bold leading-none">NOV</span>
<span class="text-lg font-extrabold leading-none">02</span>
</div>
<div>
<h4 class="font-bold text-primary text-sm">AI Ethics Workshop</h4>
<p class="text-label-sm text-on-surface-variant">Online Only - Zoom</p>
</div>
</div>
<div class="flex items-start gap-4 p-3 rounded-lg hover:bg-white/50 transition-colors cursor-pointer border border-transparent hover:border-glass-border">
<div class="flex-shrink-0 w-12 h-12 rounded-lg bg-secondary/10 flex flex-col items-center justify-center text-secondary">
<span class="text-xs font-bold leading-none">NOV</span>
<span class="text-lg font-extrabold leading-none">15</span>
</div>
<div>
<h4 class="font-bold text-primary text-sm">Intro to Crypto-Math</h4>
<p class="text-label-sm text-on-surface-variant">5:30 PM - Room 102</p>
</div>
</div>
</div>
<button class="w-full mt-6 py-2 text-primary font-label-bold text-label-bold border border-primary/20 rounded-lg hover:bg-primary/5 transition-colors">
                        View All Events
                    </button>
</div>
</aside>
</div>
</main>
<!-- Footer -->
<footer class="bg-primary text-on-primary w-full py-section-gap">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter max-w-container-max mx-auto px-margin-mobile">
<div class="md:col-span-2">
<div class="flex items-center gap-2 mb-6">
<span class="material-symbols-outlined text-secondary-fixed-dim text-4xl">terminal</span>
<span class="text-headline-md font-headline-md font-bold text-on-primary">Code Geek Academy</span>
</div>
<p class="text-on-primary/80 max-w-md mb-8">Empowering the next generation of innovators with cutting-edge technology education and logic-driven creativity.</p>
<div class="flex gap-4">
<a class="w-10 h-10 rounded-full border border-on-primary/20 flex items-center justify-center hover:bg-on-primary hover:text-primary transition-all" href="#"><span class="material-symbols-outlined">alternate_email</span></a>
<a class="w-10 h-10 rounded-full border border-on-primary/20 flex items-center justify-center hover:bg-on-primary hover:text-primary transition-all" href="#"><span class="material-symbols-outlined">public</span></a>
<a class="w-10 h-10 rounded-full border border-on-primary/20 flex items-center justify-center hover:bg-on-primary hover:text-primary transition-all" href="#"><span class="material-symbols-outlined">hub</span></a>
</div>
</div>
<div>
<h4 class="font-bold mb-6">Quick Links</h4>
<ul class="space-y-4">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../index.php">Home</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../programs.php">Programs</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../about.php">About Us</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../contact.php">Contact</a></li>
</ul>
</div>
<div>
<h4 class="font-bold mb-6">Legal</h4>
<ul class="space-y-4">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="#">Privacy Policy</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="#">Terms of Service</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="#">Cookie Policy</a></li>
</ul>
</div>
</div>
<div class="max-w-container-max mx-auto px-margin-mobile mt-16 pt-8 border-t border-on-primary/10 text-center text-on-primary/60 text-sm">
            © 2024 Code Geek Academy. Empowering the next generation of innovators.
        </div>
</footer>
<script>
        // Simple micro-interaction for cards
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