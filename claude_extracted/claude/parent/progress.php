<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('parent');
$current_user = current_user();
?>
<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Student Progress Report | Code Geek Academy</title>
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
                      "surface-dim": "#d7dadc",
                      "surface-container-highest": "#e0e3e5",
                      "on-tertiary-fixed": "#301400",
                      "deep-navy": "#1A365D",
                      "tertiary-fixed": "#ffdcc5",
                      "secondary-fixed-dim": "#6bdc96",
                      "on-surface-variant": "#43474e",
                      "on-tertiary": "#ffffff",
                      "on-secondary-fixed-variant": "#00522c",
                      "glass-surface": "rgba(255, 255, 255, 0.7)",
                      "error-container": "#ffdad6",
                      "secondary-fixed": "#88f9b0",
                      "on-primary-container": "#86a0cd",
                      "primary-fixed": "#d6e3ff",
                      "on-tertiary-container": "#e88532",
                      "on-background": "#181c1e",
                      "glass-border": "rgba(255, 255, 255, 0.4)",
                      "outline-variant": "#c4c6cf",
                      "on-error": "#ffffff",
                      "tertiary-fixed-dim": "#ffb783",
                      "on-error-container": "#93000a",
                      "on-tertiary-fixed-variant": "#703700",
                      "on-surface": "#181c1e",
                      "surface": "#f7fafc",
                      "on-primary-fixed": "#001b3c",
                      "on-secondary-fixed": "#00210f",
                      "vibrant-green": "#48BB78",
                      "surface-container-low": "#f1f4f6",
                      "secondary": "#006d3c",
                      "on-primary-fixed-variant": "#2d476f",
                      "surface-container": "#ebeef0",
                      "outline": "#74777f",
                      "inverse-surface": "#2d3133",
                      "on-primary": "#ffffff",
                      "on-secondary": "#ffffff",
                      "error": "#ba1a1a",
                      "surface-container-lowest": "#ffffff",
                      "primary": "#002045",
                      "surface-variant": "#e0e3e5",
                      "tertiary": "#371800",
                      "secondary-container": "#85f6ad",
                      "surface-container-high": "#e5e9eb",
                      "inverse-on-surface": "#eef1f3",
                      "primary-fixed-dim": "#adc7f7",
                      "primary-container": "#1a365d",
                      "surface-bright": "#f7fafc",
                      "surface-tint": "#455f88",
                      "energetic-orange": "#ED8936"
              },
              "borderRadius": {
                      "DEFAULT": "0.25rem",
                      "lg": "0.5rem",
                      "xl": "0.75rem",
                      "full": "9999px"
              },
              "spacing": {
                      "container-max": "1280px",
                      "section-gap": "120px",
                      "gutter": "24px",
                      "stack-sm": "8px",
                      "stack-lg": "32px",
                      "margin-mobile": "20px",
                      "stack-md": "16px"
              },
              "fontFamily": {
                      "label-bold": ["Inter"],
                      "display-lg-mobile": ["Montserrat"],
                      "body-lg": ["Inter"],
                      "label-sm": ["Inter"],
                      "headline-md": ["Montserrat"],
                      "display-lg": ["Montserrat"],
                      "headline-sm": ["Montserrat"],
                      "body-md": ["Inter"]
              },
              "fontSize": {
                      "label-bold": ["14px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "700"}],
                      "display-lg-mobile": ["40px", {"lineHeight": "1.2", "fontWeight": "700"}],
                      "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                      "label-sm": ["12px", {"lineHeight": "1.2", "fontWeight": "500"}],
                      "headline-md": ["32px", {"lineHeight": "1.3", "fontWeight": "700"}],
                      "display-lg": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "headline-sm": ["24px", {"lineHeight": "1.4", "fontWeight": "600"}],
                      "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}]
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
        }
        .gradient-mesh {
            background-color: #f7fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(72, 187, 120, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(26, 54, 93, 0.1) 0px, transparent 50%);
        }
        .progress-ring-circle {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface selection:bg-secondary-container">
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 backdrop-blur-xl bg-glass-surface border-b border-glass-border shadow-sm">
<div class="flex justify-between items-center px-8 py-4 max-w-container-max mx-auto">
<div class="text-headline-sm font-headline-sm font-bold text-primary">Code Geek Academy</div>
<div class="hidden md:flex space-x-8 items-center">
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="../index.php">Home</a>
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="../programs.php">Programs</a>
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="../about.php">About</a>
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="../contact.php">Contacts</a>
</div>
<div class="flex items-center space-x-4">
<a class="bg-primary text-on-primary px-6 py-2 rounded-full font-label-bold text-label-bold transition-all duration-300 hover:scale-105 hover:shadow-lg active:scale-95 inline-block" href="logout.php">
                    Log Out
                </a>
</div>
</div>
</nav>
<main class="pt-24 pb-section-gap gradient-mesh min-h-screen">
<div class="max-w-container-max mx-auto px-margin-mobile">
<!-- Breadcrumbs -->
<div class="flex items-center space-x-2 text-label-sm font-label-sm text-outline mb-8">
<span class="hover:text-primary cursor-pointer transition-colors">Dashboard</span>
<span class="material-symbols-outlined text-[14px]">chevron_right</span>
<span class="text-primary font-bold">Ethan Chen - Progress Report</span>
</div>
<!-- Student Profile Header -->
<section class="glass-card p-stack-lg rounded-xl mb-stack-lg flex flex-col md:flex-row items-center md:items-start justify-between gap-gutter shadow-sm transition-all hover:translate-y-[-4px]">
<div class="flex items-center gap-stack-md">
<div class="relative">
<img class="w-24 h-24 rounded-full border-4 border-vibrant-green/20 object-cover shadow-md" data-alt="A professional studio portrait of a young Asian boy with glasses, smiling confidently, wearing a navy blue tech hoodie. The lighting is soft and cinematic with a subtle green glow in the background. High-end, clean academic aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBYGlL_ngAXWfDAYmE6MXO_b7X_UdnItL4wo36JrTz4Mlv9bB3J-QC0r3E3wLUXIh9GfhnpwVs1hnb8k89eLpk4Pi3f7hHcS8R9kIRhF3uWBJ9SktwQ2u6UsZJ08N4ba4y9wwtZVVtXqs1B2g70AB9-PGSjkF4tG3FnMhuQ4KQXT1zbRyMqT5iCzVnJsRKIcwJxLw9UsV6eWc-0vw-D_avHcw0Lv_LpbrIeK_1Tf8as1xy853dznri8DrZTP9cBpgCXYRl8L_EzQck8"/>
<div class="absolute bottom-0 right-0 bg-vibrant-green p-1 rounded-full border-2 border-white">
<span class="material-symbols-outlined text-white text-[16px] block" data-weight="fill">verified</span>
</div>
</div>
<div>
<h1 class="text-headline-md font-headline-md text-primary">Ethan Chen</h1>
<p class="text-body-lg font-body-lg text-on-surface-variant">Robotics & IoT <span class="mx-2 text-outline">•</span> Level 3 Junior Engineer</p>
<div class="mt-2 flex items-center gap-2">
<span class="px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-label-sm font-label-bold">Current Term: Fall 2024</span>
<span class="px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-label-sm font-label-bold">Academic Honors</span>
</div>
</div>
</div>
<div class="flex items-center gap-4 bg-white/40 p-4 rounded-xl border border-white/60">
<div class="text-right">
<p class="text-label-sm font-label-bold text-outline uppercase tracking-wider">Overall Progress</p>
<p class="text-headline-sm font-headline-sm text-primary">87.5%</p>
</div>
<div class="w-16 h-16 relative">
<svg class="w-full h-full" viewbox="0 0 36 36">
<circle class="stroke-surface-container-highest" cx="18" cy="18" fill="none" r="16" stroke-width="3"></circle>
<circle class="stroke-vibrant-green progress-ring-circle" cx="18" cy="18" fill="none" r="16" stroke-dasharray="100" stroke-dashoffset="12.5" stroke-width="3"></circle>
</svg>
<div class="absolute inset-0 flex items-center justify-center">
<span class="material-symbols-outlined text-vibrant-green text-[20px]" data-weight="fill">trending_up</span>
</div>
</div>
</div>
</section>
<!-- Bento Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
<!-- Skill Mastery Visualization -->
<div class="lg:col-span-8 glass-card p-stack-lg rounded-xl shadow-sm">
<div class="flex items-center justify-between mb-stack-lg">
<h2 class="text-headline-sm font-headline-sm text-primary flex items-center gap-2">
<span class="material-symbols-outlined text-vibrant-green">query_stats</span>
                            Skill Mastery
                        </h2>
<span class="text-label-sm text-outline">Updated 2 days ago</span>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-stack-lg">
<div class="space-y-6">
<div>
<div class="flex justify-between mb-2">
<span class="text-label-bold font-label-bold text-on-surface">Logic & Algorithms</span>
<span class="text-label-bold font-label-bold text-primary">92%</span>
</div>
<div class="h-3 w-full bg-surface-container-highest rounded-full overflow-hidden">
<div class="h-full bg-vibrant-green rounded-full transition-all duration-1000 ease-out" style="width: 92%"></div>
</div>
</div>
<div>
<div class="flex justify-between mb-2">
<span class="text-label-bold font-label-bold text-on-surface">Hardware Integration</span>
<span class="text-label-bold font-label-bold text-primary">78%</span>
</div>
<div class="h-3 w-full bg-surface-container-highest rounded-full overflow-hidden">
<div class="h-full bg-vibrant-green rounded-full transition-all duration-1000 ease-out" style="width: 78%"></div>
</div>
</div>
<div>
<div class="flex justify-between mb-2">
<span class="text-label-bold font-label-bold text-on-surface">Problem Solving</span>
<span class="text-label-bold font-label-bold text-primary">85%</span>
</div>
<div class="h-3 w-full bg-surface-container-highest rounded-full overflow-hidden">
<div class="h-full bg-vibrant-green rounded-full transition-all duration-1000 ease-out" style="width: 85%"></div>
</div>
</div>
<div>
<div class="flex justify-between mb-2">
<span class="text-label-bold font-label-bold text-on-surface">Collaboration</span>
<span class="text-label-bold font-label-bold text-primary">95%</span>
</div>
<div class="h-3 w-full bg-surface-container-highest rounded-full overflow-hidden">
<div class="h-full bg-vibrant-green rounded-full transition-all duration-1000 ease-out" style="width: 95%"></div>
</div>
</div>
</div>
<!-- Radar Chart Placeholder / Visual -->
<div class="flex items-center justify-center bg-white/30 rounded-xl border border-white/40 p-4">
<div class="relative w-48 h-48 flex items-center justify-center">
<div class="absolute inset-0 border-2 border-dashed border-vibrant-green/20 rounded-full animate-[spin_20s_linear_infinite]"></div>
<div class="absolute inset-4 border-2 border-dashed border-primary/10 rounded-full animate-[spin_15s_linear_infinite_reverse]"></div>
<div class="bg-primary/5 p-8 rounded-full">
<span class="material-symbols-outlined text-primary text-[48px]" data-weight="fill">architecture</span>
</div>
<!-- Symbolic Skill Markers -->
<div class="absolute -top-2 left-1/2 -translate-x-1/2 bg-white px-2 py-1 rounded shadow-sm border border-glass-border text-[10px] font-bold">LOGIC</div>
<div class="absolute top-1/2 -right-4 -translate-y-1/2 bg-white px-2 py-1 rounded shadow-sm border border-glass-border text-[10px] font-bold">TEAM</div>
<div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-white px-2 py-1 rounded shadow-sm border border-glass-border text-[10px] font-bold">CODE</div>
<div class="absolute top-1/2 -left-4 -translate-y-1/2 bg-white px-2 py-1 rounded shadow-sm border border-glass-border text-[10px] font-bold">HW</div>
</div>
</div>
</div>
</div>
<!-- Instructor Feedback -->
<div class="lg:col-span-4 glass-card p-stack-lg rounded-xl shadow-sm">
<h2 class="text-headline-sm font-headline-sm text-primary flex items-center gap-2 mb-stack-lg">
<span class="material-symbols-outlined text-energetic-orange">chat_bubble</span>
                        Instructor Feedback
                    </h2>
<div class="flex items-center gap-3 mb-4">
<img class="w-12 h-12 rounded-full border-2 border-primary/10 object-cover" data-alt="A portrait of a male computer science instructor with a friendly smile, wearing a professional polo shirt. Modern tech office background with soft bokeh lighting. Cinematic light-mode style." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCi5gYWD1R15fPFWGwfNSoQQL6NeP8GDXwol6h5IahAqBhpsiGJ9wiiMSnvFO2oacee5m6uVBkrAq0YCLAMouYZEdAFKzzGIOv_heoz2xzHR15diPgMLxv9dfyKNvD7qFcSv4ArftZO4f1WN8p_25HnOuj-i39y1QvujUad8pJzEEuNaprtMIys-l1e3YCJ96HX9C_qIQWrvAZPT4Df0uLkh3ugo_rlLdfBvdW09BjyJAttiPTMMvoCGlflhfI3sdZEmwywwKRbLuX7"/>
<div>
<p class="text-label-bold font-label-bold text-primary">Sarah Jenkins</p>
<p class="text-[10px] text-outline uppercase font-bold">Lead Robotics Mentor</p>
</div>
</div>
<div class="relative">
<span class="material-symbols-outlined absolute -top-2 -left-2 text-surface-container-highest text-[32px]">format_quote</span>
<p class="italic text-on-surface-variant font-body-md pl-4">
                            "Ethan has shown incredible initiative this term. His approach to the 'Autonomous Rover' logic was sophisticated for his age. He occasionally rushes through documentation, but his hardware troubleshooting skills are becoming a real asset to the team. A natural leader in the group sessions."
                        </p>
</div>
<div class="mt-6 pt-4 border-t border-glass-border">
<p class="text-label-sm font-label-bold text-primary mb-2">Growth Focus:</p>
<ul class="space-y-1">
<li class="flex items-center gap-2 text-label-sm text-on-surface-variant">
<span class="w-1.5 h-1.5 rounded-full bg-vibrant-green"></span> Code commenting consistency
                            </li>
<li class="flex items-center gap-2 text-label-sm text-on-surface-variant">
<span class="w-1.5 h-1.5 rounded-full bg-vibrant-green"></span> Advanced sensory calibration
                            </li>
</ul>
</div>
</div>
<!-- Module Completion Timeline -->
<div class="lg:col-span-12 glass-card p-stack-lg rounded-xl shadow-sm">
<h2 class="text-headline-sm font-headline-sm text-primary flex items-center gap-2 mb-stack-lg">
<span class="material-symbols-outlined text-primary-fixed-dim">timeline</span>
                        Learning Journey Timeline
                    </h2>
<div class="relative pt-8 px-4 overflow-x-auto pb-4">
<div class="absolute top-[4.5rem] left-8 right-8 h-1 bg-surface-container-highest"></div>
<div class="flex justify-between min-w-[800px] relative z-10">
<!-- Step 1 (Completed) -->
<div class="flex flex-col items-center group">
<div class="w-10 h-10 rounded-full bg-vibrant-green flex items-center justify-center text-white shadow-lg shadow-vibrant-green/20 mb-4 transition-transform group-hover:scale-110">
<span class="material-symbols-outlined text-[20px]">check</span>
</div>
<p class="text-label-bold font-label-bold text-primary">Microcontrollers</p>
<p class="text-[10px] text-outline font-bold">SEP 2024</p>
</div>
<!-- Step 2 (Completed) -->
<div class="flex flex-col items-center group">
<div class="w-10 h-10 rounded-full bg-vibrant-green flex items-center justify-center text-white shadow-lg shadow-vibrant-green/20 mb-4 transition-transform group-hover:scale-110">
<span class="material-symbols-outlined text-[20px]">check</span>
</div>
<p class="text-label-bold font-label-bold text-primary">Intro to Sensors</p>
<p class="text-[10px] text-outline font-bold">OCT 2024</p>
</div>
<!-- Step 3 (Active) -->
<div class="flex flex-col items-center group">
<div class="w-12 h-12 -mt-1 rounded-full bg-white border-4 border-vibrant-green flex items-center justify-center text-vibrant-green shadow-xl mb-4 transition-transform group-hover:scale-110 relative">
<span class="material-symbols-outlined text-[24px]" data-weight="fill">play_arrow</span>
<div class="absolute -top-6 bg-energetic-orange text-white text-[9px] px-2 py-0.5 rounded-full font-bold">CURRENT</div>
</div>
<p class="text-label-bold font-label-bold text-primary">Wireless Protocols</p>
<p class="text-[10px] text-outline font-bold">NOV 2024</p>
</div>
<!-- Step 4 (Upcoming) -->
<div class="flex flex-col items-center opacity-40 group">
<div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center text-outline mb-4 group-hover:bg-primary group-hover:text-white transition-all">
<span class="material-symbols-outlined text-[20px]">lock</span>
</div>
<p class="text-label-bold font-label-bold text-on-surface">Data Visualization</p>
<p class="text-[10px] text-outline font-bold">DEC 2024</p>
</div>
<!-- Step 5 (Upcoming) -->
<div class="flex flex-col items-center opacity-40 group">
<div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center text-outline mb-4 group-hover:bg-primary group-hover:text-white transition-all">
<span class="material-symbols-outlined text-[20px]">flag</span>
</div>
<p class="text-label-bold font-label-bold text-on-surface">Capstone Project</p>
<p class="text-[10px] text-outline font-bold">JAN 2025</p>
</div>
</div>
</div>
</div>
<!-- Project Showcase -->
<div class="lg:col-span-7 glass-card p-stack-lg rounded-xl shadow-sm">
<h2 class="text-headline-sm font-headline-sm text-primary flex items-center gap-2 mb-stack-lg">
<span class="material-symbols-outlined text-secondary">rocket_launch</span>
                        Featured Project
                    </h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
<div class="relative group overflow-hidden rounded-lg">
<img class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110" data-alt="Close-up of a DIY robotics project featuring a circuit board with glowing green LEDs, intricate wiring, and an ultrasonic sensor mounted on a 3D-printed chassis. High-tech macro photography style with shallow depth of field and soft light-mode studio lighting." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAevvUNMt8E_gTpFkQjDfzRFPoZplAvM_PRw042G6ZumwFsqcLb0mNXXOyy3XeqLPdGI-JERalJJBzTB2NqupeAIQlRejEzSZ5u6bBBiHJivJWpnAxvVeynttqDS8RLRlP7Fhr66FGN2DcZcwtyF6WiEcFtO78doxPy2QiRiHnadh7qcfa-ff25ZKYvbs76QmMJRrfBDXLmgeu5ju9QXi_Wyd620iWT0LkPvPWIt1CAvaYLqOIwt4IwC2KbwMPwTFOYUOmsRA2GvZiL"/>
<div class="absolute inset-0 bg-primary/20 group-hover:bg-primary/10 transition-colors"></div>
<div class="absolute top-2 right-2 bg-white/90 px-2 py-1 rounded text-[10px] font-bold text-primary backdrop-blur-sm">PROTOTYPE V2.4</div>
</div>
<div class="flex flex-col justify-center">
<h3 class="text-headline-sm font-headline-sm text-primary mb-2">Smart Watering System</h3>
<p class="text-body-md text-on-surface-variant mb-4">
                                Ethan built an IoT-based soil moisture monitor that alerts the user via a custom web dashboard when plants need hydration.
                            </p>
<div class="flex flex-wrap gap-2 mb-4">
<span class="bg-surface-container-low text-primary text-[10px] font-bold px-2 py-1 rounded border border-glass-border">C++</span>
<span class="bg-surface-container-low text-primary text-[10px] font-bold px-2 py-1 rounded border border-glass-border">NodeMCU</span>
<span class="bg-surface-container-low text-primary text-[10px] font-bold px-2 py-1 rounded border border-glass-border">MQTT</span>
</div>
<button class="flex items-center gap-2 text-label-bold font-label-bold text-secondary hover:translate-x-2 transition-transform">
                                View Technical Journal
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</button>
</div>
</div>
</div>
<!-- Next Steps / Recommendations -->
<div class="lg:col-span-5 glass-card p-stack-lg rounded-xl shadow-sm bg-primary text-on-primary">
<h2 class="text-headline-sm font-headline-sm text-secondary-fixed-dim flex items-center gap-2 mb-stack-lg">
<span class="material-symbols-outlined">auto_awesome</span>
                        Future Path
                    </h2>
<p class="text-on-primary-container text-body-md mb-6">
                        Based on Ethan's aptitude for hardware-logic interfacing, we recommend these advanced paths for the next semester.
                    </p>
<div class="space-y-4">
<div class="bg-white/10 p-4 rounded-lg border border-white/10 hover:bg-white/15 transition-colors cursor-pointer group">
<div class="flex justify-between items-start">
<div>
<p class="text-label-bold font-label-bold text-white mb-1">Advanced AI & Vision</p>
<p class="text-[12px] text-on-primary-container">Integrate machine learning into robotics projects.</p>
</div>
<span class="material-symbols-outlined text-vibrant-green opacity-0 group-hover:opacity-100 transition-opacity">add_circle</span>
</div>
</div>
<div class="bg-white/10 p-4 rounded-lg border border-white/10 hover:bg-white/15 transition-colors cursor-pointer group">
<div class="flex justify-between items-start">
<div>
<p class="text-label-bold font-label-bold text-white mb-1">Industrial Design Workshop</p>
<p class="text-[12px] text-on-primary-container">3D modeling and custom enclosure fabrication.</p>
</div>
<span class="material-symbols-outlined text-vibrant-green opacity-0 group-hover:opacity-100 transition-opacity">add_circle</span>
</div>
</div>
</div>
<button class="w-full mt-6 bg-vibrant-green text-primary font-label-bold text-label-bold py-3 rounded-full hover:scale-[1.02] transition-transform shadow-lg shadow-vibrant-green/20">
                        Enroll in Next Term
                    </button>
</div>
</div>
</div>
</main>
<!-- Footer -->
<footer class="w-full py-section-gap bg-primary text-on-primary">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter max-w-container-max mx-auto px-margin-mobile">
<div class="space-y-4">
<div class="text-headline-md font-headline-md font-bold text-on-primary">Code Geek Academy</div>
<p class="text-on-primary/80 font-body-md">Empowering the next generation of innovators through code and creativity.</p>
</div>
<div>
<h4 class="text-headline-sm font-headline-sm text-secondary-fixed-dim mb-4">Quick Links</h4>
<ul class="space-y-2">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors font-body-md" href="../index.php">Home</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors font-body-md" href="../programs.php">Programs</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors font-body-md" href="../about.php">About</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors font-body-md" href="../contact.php">Contacts</a></li>
</ul>
</div>
<div>
<h4 class="text-headline-sm font-headline-sm text-secondary-fixed-dim mb-4">Support</h4>
<ul class="space-y-2">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors font-body-md" href="dashboard.php">Parent Portal</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors font-body-md" href="#">Curriculum Guide</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors font-body-md" href="#">Privacy Policy</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors font-body-md" href="#">Terms of Service</a></li>
</ul>
</div>
<div class="space-y-4">
<h4 class="text-headline-sm font-headline-sm text-secondary-fixed-dim mb-4">Stay Connected</h4>
<div class="flex space-x-4">
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-vibrant-green transition-colors" href="#">
<span class="material-symbols-outlined text-[20px]">share</span>
</a>
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-vibrant-green transition-colors" href="#">
<span class="material-symbols-outlined text-[20px]">alternate_email</span>
</a>
</div>
<p class="text-[12px] text-on-primary/60 mt-8">© 2024 Code Geek Academy. Empowering the next generation of innovators.</p>
</div>
</div>
</footer>
<script>
        // Micro-interaction: Update progress bar on scroll or load
        document.addEventListener('DOMContentLoaded', () => {
            const bars = document.querySelectorAll('.h-full.bg-vibrant-green');
            bars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
        });
    </script>
</body></html>