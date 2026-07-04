<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('parent');
$current_user = current_user();
?>
<!DOCTYPE html>

<html class="scroll-smooth" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Parent Portal Settings | Code Geek Academy</title>
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
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed-variant": "#703700",
                        "on-surface": "#181c1e",
                        "surface": "#f7fafc",
                        "on-primary-fixed": "#001b3c",
                        "on-secondary-fixed": "#00210f",
                        "vibrant-green": "#48BB78",
                        "surface-container-low": "#f1f4f6",
                        "secondary": "#006d3c",
                        "energetic-orange": "#ED8936",
                        "inverse-primary": "#adc7f7",
                        "tertiary-container": "#572900",
                        "on-background": "#181c1e",
                        "glass-border": "rgba(255, 255, 255, 0.4)",
                        "outline-variant": "#c4c6cf",
                        "on-error": "#ffffff",
                        "tertiary-fixed-dim": "#ffb783",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#00522c",
                        "glass-surface": "rgba(255, 255, 255, 0.7)",
                        "error-container": "#ffdad6",
                        "secondary-fixed": "#88f9b0",
                        "on-primary-container": "#86a0cd",
                        "primary-fixed": "#d6e3ff",
                        "on-tertiary-container": "#e88532",
                        "on-secondary-container": "#00723f",
                        "background": "#f7fafc",
                        "surface-dim": "#d7dadc",
                        "surface-container-highest": "#e0e3e5",
                        "on-tertiary-fixed": "#301400",
                        "deep-navy": "#1A365D",
                        "tertiary-fixed": "#ffdcc5",
                        "secondary-fixed-dim": "#6bdc96",
                        "on-surface-variant": "#43474e",
                        "inverse-on-surface": "#eef1f3",
                        "primary-fixed-dim": "#adc7f7",
                        "primary-container": "#1a365d",
                        "surface-bright": "#f7fafc",
                        "surface-tint": "#455f88",
                        "surface-variant": "#e0e3e5",
                        "tertiary": "#371800",
                        "secondary-container": "#85f6ad",
                        "surface-container-high": "#e5e9eb",
                        "primary": "#002045",
                        "on-primary-fixed-variant": "#2d476f",
                        "surface-container": "#ebeef0",
                        "outline": "#74777f",
                        "inverse-surface": "#2d3133",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "error": "#ba1a1a",
                        "surface-container-lowest": "#ffffff"
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
                        "gutter": "24px",
                        "margin-mobile": "20px",
                        "stack-sm": "8px",
                        "stack-lg": "32px",
                        "stack-md": "16px"
                    },
                    "fontFamily": {
                        "body-lg": ["Inter"],
                        "label-sm": ["Inter"],
                        "headline-md": ["Montserrat"],
                        "display-lg": ["Montserrat"],
                        "headline-sm": ["Montserrat"],
                        "body-md": ["Inter"],
                        "label-bold": ["Inter"],
                        "display-lg-mobile": ["Montserrat"]
                    },
                    "fontSize": {
                        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "label-sm": ["12px", {"lineHeight": "1.2", "fontWeight": "500"}],
                        "headline-md": ["32px", {"lineHeight": "1.3", "fontWeight": "700"}],
                        "display-lg": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-sm": ["24px", {"lineHeight": "1.4", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "label-bold": ["14px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "700"}],
                        "display-lg-mobile": ["40px", {"lineHeight": "1.2", "fontWeight": "700"}]
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(26, 54, 93, 0.1);
        }
        .nav-active {
            color: #006d3c;
            border-left: 4px solid #006d3c;
            background: rgba(133, 246, 173, 0.2);
        }
        .toggle-checkbox:checked {
            right: 0;
            background-color: #48BB78;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #48BB78;
        }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface">
<!-- TopNavBar -->
<header class="fixed top-0 w-full z-50 backdrop-blur-xl bg-glass-surface border-b border-glass-border shadow-sm">
<div class="flex justify-between items-center px-8 py-4 max-w-container-max mx-auto">
<div class="text-headline-sm font-headline-sm font-bold text-primary">
                Code Geek Academy
            </div>
<nav class="hidden md:flex space-x-8">
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="../index.php">Home</a>
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="../programs.php">Programs</a>
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="../about.php">About</a>
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="../contact.php">Contacts</a>
</nav>
<div class="flex items-center gap-4">
<a class="bg-primary text-on-primary px-6 py-2 rounded-full font-label-bold text-label-bold hover:scale-105 transition-all duration-300 shadow-lg inline-block" href="logout.php">
                    Log Out
                </a>
</div>
</div>
</header>
<main class="pt-32 pb-section-gap max-w-container-max mx-auto px-margin-mobile">
<!-- Header Section -->
<div class="mb-12">
<h1 class="font-headline-md text-headline-md text-deep-navy mb-2">Settings</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant">Manage your account, security, and preferences.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-4 gap-gutter items-start">
<!-- Sidebar Navigation -->
<aside class="lg:col-span-1 space-y-2">
<nav class="flex flex-col space-y-1">
<button class="nav-active flex items-center gap-3 px-4 py-3 rounded-lg font-label-bold text-label-bold text-left transition-all duration-200 hover:bg-surface-container" id="btn-profile" onclick="switchTab('profile')">
<span class="material-symbols-outlined">person</span> Profile
                    </button>
<button class="flex items-center gap-3 px-4 py-3 rounded-lg font-label-bold text-label-bold text-on-surface-variant text-left transition-all duration-200 hover:bg-surface-container" id="btn-security" onclick="switchTab('security')">
<span class="material-symbols-outlined">security</span> Security
                    </button>
<button class="flex items-center gap-3 px-4 py-3 rounded-lg font-label-bold text-label-bold text-on-surface-variant text-left transition-all duration-200 hover:bg-surface-container" id="btn-notifications" onclick="switchTab('notifications')">
<span class="material-symbols-outlined">notifications</span> Notifications
                    </button>
<button class="flex items-center gap-3 px-4 py-3 rounded-lg font-label-bold text-label-bold text-on-surface-variant text-left transition-all duration-200 hover:bg-surface-container" id="btn-billing" onclick="switchTab('billing')">
<span class="material-symbols-outlined">payments</span> Billing
                    </button>
</nav>
</aside>
<!-- Settings Content -->
<div class="lg:col-span-3">
<!-- Profile Section -->
<section class="glass-card p-8 rounded-xl" id="section-profile">
<div class="flex items-center gap-6 mb-8">
<div class="relative group">
<div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-xl">
<img class="w-full h-full object-cover" data-alt="A high-quality studio portrait of a professional modern parent in their late 30s, smiling warmly. The lighting is soft and high-key, suggesting a bright and welcoming atmosphere. The background is a clean, minimalist workspace with subtle tech accents, aligning with the premium academic and glassmorphic aesthetic of the Code Geek Academy brand." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCshytRpdj56aJ-fPaPLjX0YiyPvXNJkJMtgw47vpeaTxBpEXUpZ-0ZtZORhQH3R36J8RaOHkSUNAd2x5yOTm274Ti1s_w-ElblhNgBeK6ET6ZcOBwCP_DlmvS1W90cnyoCX8dyvBaJBBPwr9140HLZaNYjGSwD2QLXPLc0EM3vvKc9IJphlm1r48WqZV9G99LBpsFzNUsdXgrVMxRGsvNTER3F_LHcnmkldHYuLNyM5uh5vYerAHE2B0tbRN0nwtzkXHjFXSz2oHTK"/>
</div>
<button class="absolute bottom-0 right-0 bg-deep-navy text-on-primary p-2 rounded-full shadow-lg hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-sm">photo_camera</span>
</button>
</div>
<div>
<h3 class="font-headline-sm text-headline-sm text-deep-navy">Personal Information</h3>
<p class="text-on-surface-variant">Update your photo and personal details.</p>
</div>
</div>
<form class="grid grid-cols-1 md:grid-cols-2 gap-stack-lg">
<div class="space-y-2">
<label class="font-label-bold text-label-bold text-deep-navy">Full Name</label>
<input class="w-full px-4 py-3 rounded-lg border border-outline-variant focus:ring-2 focus:ring-vibrant-green focus:border-transparent bg-white/50 outline-none transition-all" type="text" value="Sarah Jenkins"/>
</div>
<div class="space-y-2">
<label class="font-label-bold text-label-bold text-deep-navy">Email Address</label>
<input class="w-full px-4 py-3 rounded-lg border border-outline-variant focus:ring-2 focus:ring-vibrant-green focus:border-transparent bg-white/50 outline-none transition-all" type="email" value="s.jenkins@example.com"/>
</div>
<div class="space-y-2 md:col-span-2">
<label class="font-label-bold text-label-bold text-deep-navy">Phone Number</label>
<input class="w-full px-4 py-3 rounded-lg border border-outline-variant focus:ring-2 focus:ring-vibrant-green focus:border-transparent bg-white/50 outline-none transition-all" type="tel" value="+1 (555) 012-3456"/>
</div>
<div class="md:col-span-2 flex justify-end gap-4 mt-4">
<button class="px-6 py-2 rounded-full border border-deep-navy text-deep-navy font-label-bold hover:bg-deep-navy/5 transition-colors" type="button">Cancel</button>
<button class="px-8 py-2 rounded-full bg-deep-navy text-on-primary font-label-bold hover:scale-105 transition-transform shadow-lg" type="submit">Save Changes</button>
</div>
</form>
</section>
<!-- Security Section (Hidden initially) -->
<section class="hidden glass-card p-8 rounded-xl" id="section-security">
<h3 class="font-headline-sm text-headline-sm text-deep-navy mb-6">Security Settings</h3>
<div class="space-y-8">
<!-- Password Change -->
<div class="p-6 bg-white/40 rounded-lg border border-glass-border">
<div class="flex items-center gap-4 mb-4">
<span class="material-symbols-outlined text-deep-navy p-2 bg-primary-fixed rounded-lg">lock_reset</span>
<h4 class="font-label-bold text-lg text-deep-navy">Change Password</h4>
</div>
<div class="grid gap-4 max-w-md">
<input class="px-4 py-3 rounded-lg border border-outline-variant bg-white/50" placeholder="Current Password" type="password"/>
<input class="px-4 py-3 rounded-lg border border-outline-variant bg-white/50" placeholder="New Password" type="password"/>
<button class="w-fit px-6 py-2 rounded-full bg-deep-navy text-on-primary font-label-bold">Update Password</button>
</div>
</div>
<!-- 2FA -->
<div class="flex items-center justify-between p-6 bg-white/40 rounded-lg border border-glass-border">
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-vibrant-green p-2 bg-secondary-container rounded-lg">verified_user</span>
<div>
<h4 class="font-label-bold text-lg text-deep-navy">Two-Factor Authentication</h4>
<p class="text-sm text-on-surface-variant">Add an extra layer of security to your account.</p>
</div>
</div>
<div class="relative inline-block w-12 mr-2 align-middle select-none">
<input class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer outline-none transition-all duration-300" id="2fa-toggle" name="toggle" type="checkbox"/>
<label class="toggle-label block overflow-hidden h-6 rounded-full bg-outline-variant cursor-pointer transition-colors duration-300" for="2fa-toggle"></label>
</div>
</div>
</div>
</section>
<!-- Notifications Section (Hidden initially) -->
<section class="hidden glass-card p-8 rounded-xl" id="section-notifications">
<h3 class="font-headline-sm text-headline-sm text-deep-navy mb-2">Notification Preferences</h3>
<p class="text-on-surface-variant mb-8">Choose how and when you want to stay updated.</p>
<div class="space-y-6">
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
<!-- Email Preferences -->
<div class="space-y-4">
<h4 class="font-label-bold text-deep-navy border-b pb-2">Email Notifications</h4>
<div class="flex items-center justify-between">
<span class="text-body-md">Student Progress</span>
<input checked="" class="w-5 h-5 rounded text-vibrant-green focus:ring-vibrant-green border-outline-variant" type="checkbox"/>
</div>
<div class="flex items-center justify-between">
<span class="text-body-md">Class Reminders</span>
<input checked="" class="w-5 h-5 rounded text-vibrant-green focus:ring-vibrant-green border-outline-variant" type="checkbox"/>
</div>
<div class="flex items-center justify-between">
<span class="text-body-md">Billing Statements</span>
<input class="w-5 h-5 rounded text-vibrant-green focus:ring-vibrant-green border-outline-variant" type="checkbox"/>
</div>
</div>
<!-- SMS Preferences -->
<div class="space-y-4">
<h4 class="font-label-bold text-deep-navy border-b pb-2">SMS Alerts</h4>
<div class="flex items-center justify-between">
<span class="text-body-md">Student Progress</span>
<input class="w-5 h-5 rounded text-vibrant-green focus:ring-vibrant-green border-outline-variant" type="checkbox"/>
</div>
<div class="flex items-center justify-between">
<span class="text-body-md">Class Reminders</span>
<input checked="" class="w-5 h-5 rounded text-vibrant-green focus:ring-vibrant-green border-outline-variant" type="checkbox"/>
</div>
<div class="flex items-center justify-between">
<span class="text-body-md">Billing Statements</span>
<input class="w-5 h-5 rounded text-vibrant-green focus:ring-vibrant-green border-outline-variant" type="checkbox"/>
</div>
</div>
</div>
</div>
</section>
<!-- Billing Section (Placeholder) -->
<section class="hidden glass-card p-8 rounded-xl" id="section-billing">
<h3 class="font-headline-sm text-headline-sm text-deep-navy mb-6">Billing & Payments</h3>
<div class="space-y-4">
<div class="flex items-center justify-between p-4 bg-white/40 border border-glass-border rounded-lg">
<div class="flex items-center gap-4">
<div class="bg-primary-fixed p-3 rounded-lg">
<span class="material-symbols-outlined text-deep-navy">credit_card</span>
</div>
<div>
<p class="font-label-bold text-deep-navy">Visa ending in 4242</p>
<p class="text-xs text-on-surface-variant">Expires 12/26</p>
</div>
</div>
<button class="text-deep-navy font-label-bold hover:underline">Edit</button>
</div>
<div class="p-4 bg-secondary-container/20 border border-secondary/20 rounded-lg">
<p class="text-sm text-secondary font-label-bold">Next payment of $450.00 is due on May 15, 2024.</p>
</div>
</div>
</section>
</div>
</div>
</main>
<!-- Footer -->
<footer class="bg-primary text-on-primary py-section-gap w-full">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter max-w-container-max mx-auto px-margin-mobile">
<div class="space-y-4">
<div class="text-headline-md font-headline-md font-bold text-on-primary">Code Geek Academy</div>
<p class="text-on-primary/80 font-body-md text-body-md">Empowering the next generation of innovators with cutting-edge tech education.</p>
</div>
<div>
<h4 class="font-headline-sm text-headline-sm mb-4">Quick Links</h4>
<ul class="space-y-2">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../index.php">Home</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../programs.php">Programs</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../about.php">About</a></li>
</ul>
</div>
<div>
<h4 class="font-headline-sm text-headline-sm mb-4">Support</h4>
<ul class="space-y-2">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../contact.php">Contacts</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="#">Privacy Policy</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="#">Terms of Service</a></li>
</ul>
</div>
<div>
<h4 class="font-headline-sm text-headline-sm mb-4">Connect</h4>
<div class="flex gap-4">
<span class="material-symbols-outlined text-on-primary/60 hover:text-vibrant-green cursor-pointer">share</span>
<span class="material-symbols-outlined text-on-primary/60 hover:text-vibrant-green cursor-pointer">alternate_email</span>
<span class="material-symbols-outlined text-on-primary/60 hover:text-vibrant-green cursor-pointer">public</span>
</div>
</div>
</div>
<div class="max-w-container-max mx-auto px-margin-mobile mt-12 pt-8 border-t border-on-primary/10 text-on-primary/60 text-center">
            © 2024 Code Geek Academy. Empowering the next generation of innovators.
        </div>
</footer>
<script>
        function switchTab(tabName) {
            // Hide all sections
            const sections = ['profile', 'security', 'notifications', 'billing'];
            sections.forEach(sec => {
                document.getElementById(`section-${sec}`).classList.add('hidden');
                document.getElementById(`btn-${sec}`).classList.remove('nav-active');
                document.getElementById(`btn-${sec}`).classList.remove('bg-surface-container');
                document.getElementById(`btn-${sec}`).classList.add('text-on-surface-variant');
            });

            // Show selected section
            const targetSection = document.getElementById(`section-${tabName}`);
            const targetBtn = document.getElementById(`btn-${tabName}`);
            
            targetSection.classList.remove('hidden');
            targetSection.classList.add('animate-in', 'fade-in', 'slide-in-from-bottom-4', 'duration-500');
            
            targetBtn.classList.add('nav-active');
            targetBtn.classList.remove('text-on-surface-variant');
        }

        // Simple animation trigger for initial load
        document.addEventListener('DOMContentLoaded', () => {
            const firstSection = document.getElementById('section-profile');
            firstSection.classList.add('animate-in', 'fade-in', 'slide-in-from-bottom-4', 'duration-500');
        });
    </script>
</body></html>