<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('parent');
$current_user = current_user();
?>
<!DOCTYPE html>

<html class="scroll-smooth" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Billing &amp; Payments | Code Geek Academy Parent Portal</title>
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
                    "surface-container-highest": "#e0e3e5",
                    "glass-border": "rgba(255, 255, 255, 0.4)",
                    "surface-bright": "#f7fafc",
                    "surface-container-low": "#f1f4f6",
                    "error": "#ba1a1a",
                    "tertiary-container": "#572900",
                    "on-secondary-container": "#00723f",
                    "vibrant-green": "#48BB78",
                    "on-primary-fixed-variant": "#2d476f",
                    "on-error-container": "#93000a",
                    "on-error": "#ffffff",
                    "surface": "#f7fafc",
                    "primary-container": "#1a365d",
                    "inverse-on-surface": "#eef1f3",
                    "on-tertiary-fixed-variant": "#703700",
                    "on-tertiary": "#ffffff",
                    "primary": "#002045",
                    "on-surface": "#181c1e",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary-fixed": "#301400",
                    "surface-dim": "#d7dadc",
                    "primary-fixed": "#d6e3ff",
                    "outline": "#74777f",
                    "tertiary": "#371800",
                    "on-tertiary-container": "#e88532",
                    "on-primary-fixed": "#001b3c",
                    "surface-container": "#ebeef0",
                    "primary-fixed-dim": "#adc7f7",
                    "secondary-fixed-dim": "#6bdc96",
                    "inverse-surface": "#2d3133",
                    "outline-variant": "#c4c6cf",
                    "deep-navy": "#1A365D",
                    "on-surface-variant": "#43474e",
                    "energetic-orange": "#ED8936",
                    "secondary-fixed": "#88f9b0",
                    "on-secondary-fixed-variant": "#00522c",
                    "inverse-primary": "#adc7f7",
                    "tertiary-fixed-dim": "#ffb783",
                    "on-primary-container": "#86a0cd",
                    "background": "#f7fafc",
                    "error-container": "#ffdad6",
                    "secondary": "#006d3c",
                    "surface-variant": "#e0e3e5",
                    "on-secondary-fixed": "#00210f",
                    "surface-container-high": "#e5e9eb",
                    "glass-surface": "rgba(255, 255, 255, 0.7)",
                    "on-primary": "#ffffff",
                    "tertiary-fixed": "#ffdcc5",
                    "on-background": "#181c1e",
                    "on-secondary": "#ffffff",
                    "secondary-container": "#85f6ad",
                    "surface-tint": "#455f88"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "container-max": "1280px",
                    "stack-sm": "8px",
                    "stack-md": "16px",
                    "margin-mobile": "20px",
                    "stack-lg": "32px",
                    "section-gap": "120px",
                    "gutter": "24px"
            },
            "fontFamily": {
                    "display-lg-mobile": ["Montserrat"],
                    "body-md": ["Inter"],
                    "label-bold": ["Inter"],
                    "headline-sm": ["Montserrat"],
                    "headline-md": ["Montserrat"],
                    "body-lg": ["Inter"],
                    "display-lg": ["Montserrat"],
                    "label-sm": ["Inter"]
            },
            "fontSize": {
                    "display-lg-mobile": ["40px", {"lineHeight": "1.2", "fontWeight": "700"}],
                    "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "label-bold": ["14px", {"lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "700"}],
                    "headline-sm": ["24px", {"lineHeight": "1.4", "fontWeight": "600"}],
                    "headline-md": ["32px", {"lineHeight": "1.3", "fontWeight": "700"}],
                    "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "display-lg": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "label-sm": ["12px", {"lineHeight": "1.2", "fontWeight": "500"}]
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
            box-shadow: 0 8px 32px 0 rgba(26, 54, 93, 0.05);
        }

        .kinetic-hover {
            transition: all 0.3s ease-out;
        }

        .kinetic-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(26, 54, 93, 0.1);
        }

        .gradient-mesh {
            background-color: #f7fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(72, 187, 120, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(26, 54, 93, 0.05) 0px, transparent 50%);
        }

        .sidebar-active {
            background: rgba(0, 32, 69, 0.05);
            border-right: 4px solid #1A365D;
            color: #1A365D;
            font-weight: 700;
        }
    </style>
</head>
<body class="font-body-md text-on-surface bg-background gradient-mesh min-h-screen">
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 backdrop-blur-xl bg-glass-surface border-b border-glass-border shadow-sm">
<div class="flex justify-between items-center px-8 py-4 max-w-container-max mx-auto">
<div class="text-headline-sm font-headline-sm font-bold text-primary">Code Geek Academy</div>
<div class="hidden md:flex space-x-8 items-center">
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="../index.php">Home</a>
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="../programs.php">Programs</a>
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="../about.php">About</a>
<a class="text-on-surface-variant font-label-bold text-label-bold hover:scale-105 transition-transform duration-200 hover:text-secondary" href="../contact.php">Contacts</a>
<a class="bg-primary-container text-on-primary-container font-label-bold text-label-bold px-6 py-2 rounded-full border-b-2 border-secondary pb-1 transition-all duration-300" href="logout.php">Log Out</a>
</div>
</div>
</nav>
<div class="pt-20 flex max-w-container-max mx-auto min-h-[calc(100vh-80px)]">
<!-- Side Navigation -->
<aside class="hidden md:flex flex-col w-64 bg-white/30 backdrop-blur-md border-r border-glass-border sticky top-20 h-[calc(100vh-80px)] py-8">
<nav class="flex-1 space-y-2">
<a class="flex items-center px-8 py-4 text-on-surface-variant hover:bg-white/50 transition-colors" href="dashboard.php">
<span class="material-symbols-outlined mr-4">dashboard</span>
<span class="font-label-bold text-label-bold">Dashboard</span>
</a>
<a class="flex items-center px-8 py-4 text-on-surface-variant hover:bg-white/50 transition-colors" href="progress.php">
<span class="material-symbols-outlined mr-4">group</span>
<span class="font-label-bold text-label-bold">Students</span>
</a>
<a class="flex items-center px-8 py-4 text-on-surface-variant hover:bg-white/50 transition-colors" href="schedule.php">
<span class="material-symbols-outlined mr-4">calendar_month</span>
<span class="font-label-bold text-label-bold">Schedule</span>
</a>
<a class="flex items-center px-8 py-4 sidebar-active" href="payments.php">
<span class="material-symbols-outlined mr-4" style="font-variation-settings: 'FILL' 1;">payments</span>
<span class="font-label-bold text-label-bold">Billing</span>
</a>
<a class="flex items-center px-8 py-4 text-on-surface-variant hover:bg-white/50 transition-colors" href="settings.php">
<span class="material-symbols-outlined mr-4">settings</span>
<span class="font-label-bold text-label-bold">Settings</span>
</a>
</nav>
<div class="px-8 mt-auto pt-8">
<div class="glass-card p-4 rounded-xl flex items-center space-x-3">
<div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold">JD</div>
<div>
<p class="text-label-sm font-label-bold text-primary">Jane Doe</p>
<p class="text-[10px] text-on-surface-variant">Parent Account</p>
</div>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="flex-1 p-8 md:p-12 overflow-y-auto">
<header class="mb-10">
<h1 class="text-display-lg-mobile md:text-headline-md font-headline-md text-primary mb-2">Billing &amp; Payments</h1>
<p class="text-body-md text-on-surface-variant">Manage your subscriptions, view invoices, and update payment methods for Aiden and Maya.</p>
</header>
<!-- Billing Overview Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter mb-section-gap">
<!-- Large Kinetic Glass Overview Card -->
<div class="lg:col-span-2 glass-card kinetic-hover p-8 rounded-3xl relative overflow-hidden flex flex-col justify-between">
<div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-vibrant-green/10 rounded-full blur-3xl"></div>
<div>
<div class="flex justify-between items-start mb-8">
<div>
<span class="bg-energetic-orange/10 text-energetic-orange px-3 py-1 rounded-full text-label-sm font-label-bold uppercase tracking-wider mb-4 inline-block">Current Term</span>
<h2 class="text-label-bold text-on-surface-variant uppercase tracking-widest">Total Balance Due</h2>
<p class="text-[56px] font-bold text-primary leading-tight mt-2">$425.00</p>
</div>
<div class="text-right">
<p class="text-label-sm font-label-bold text-on-surface-variant">Next Payment Date</p>
<p class="text-headline-sm font-headline-sm text-primary">Oct 15, 2024</p>
</div>
</div>
</div>
<div class="flex flex-col sm:flex-row gap-4 mt-8">
<button class="bg-primary hover:bg-deep-navy text-on-primary px-8 py-4 rounded-full font-label-bold text-label-bold shadow-lg shadow-primary/20 transition-all flex items-center justify-center space-x-2">
<span class="material-symbols-outlined">account_balance_wallet</span>
<span>Pay Now</span>
</button>
<button class="bg-transparent border-2 border-primary text-primary px-8 py-4 rounded-full font-label-bold text-label-bold hover:bg-primary/5 transition-all flex items-center justify-center">
                            View Breakdowns
                        </button>
</div>
</div>
<!-- Saved Payment Methods -->
<div class="glass-card p-8 rounded-3xl flex flex-col">
<div class="flex justify-between items-center mb-6">
<h3 class="font-headline-sm text-headline-sm text-primary">Saved Methods</h3>
<button class="text-vibrant-green hover:text-secondary transition-colors">
<span class="material-symbols-outlined">add_circle</span>
</button>
</div>
<div class="space-y-4 flex-1">
<!-- Card 1 -->
<div class="border border-glass-border bg-white/40 p-4 rounded-2xl flex items-center justify-between">
<div class="flex items-center space-x-4">
<div class="w-12 h-8 bg-primary rounded flex items-center justify-center text-white text-[10px] font-bold">VISA</div>
<div>
<p class="text-label-bold text-primary">•••• 4242</p>
<p class="text-label-sm text-on-surface-variant">Exp 12/26</p>
</div>
</div>
<span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary">more_vert</span>
</div>
<!-- Card 2 -->
<div class="border border-glass-border bg-white/40 p-4 rounded-2xl flex items-center justify-between">
<div class="flex items-center space-x-4">
<div class="w-12 h-8 bg-on-surface-variant rounded flex items-center justify-center text-white text-[10px] font-bold">MC</div>
<div>
<p class="text-label-bold text-primary">•••• 8890</p>
<p class="text-label-sm text-on-surface-variant">Exp 05/25</p>
</div>
</div>
<span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary">more_vert</span>
</div>
</div>
<button class="mt-6 w-full py-3 border-2 border-dashed border-outline-variant rounded-2xl text-on-surface-variant font-label-bold hover:border-primary hover:text-primary transition-all">
                        + Add New Method
                    </button>
</div>
</div>
<!-- Payment History -->
<section class="mb-section-gap">
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
<h3 class="font-headline-sm text-headline-sm text-primary">Transaction History</h3>
<div class="flex gap-4">
<div class="relative">
<input class="pl-10 pr-4 py-2 rounded-full border-glass-border bg-white/50 focus:ring-vibrant-green focus:border-vibrant-green text-label-sm" placeholder="Search history..." type="text"/>
<span class="material-symbols-outlined absolute left-3 top-2 text-on-surface-variant text-sm">search</span>
</div>
<button class="flex items-center space-x-2 bg-white/50 px-4 py-2 rounded-full border border-glass-border text-label-sm font-label-bold text-primary hover:bg-white transition-all">
<span class="material-symbols-outlined text-base">filter_list</span>
<span>Filter</span>
</button>
</div>
</div>
<div class="glass-card rounded-3xl overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead class="bg-primary/5 text-primary">
<tr>
<th class="px-8 py-5 text-label-bold font-label-bold">Date</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Description</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Student</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Amount</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Status</th>
<th class="px-8 py-5 text-label-bold font-label-bold text-right">Invoice</th>
</tr>
</thead>
<tbody class="divide-y divide-glass-border">
<!-- Row 1 -->
<tr class="hover:bg-white/40 transition-colors">
<td class="px-8 py-6 text-body-md text-on-surface-variant">Sep 15, 2024</td>
<td class="px-8 py-6">
<p class="font-bold text-primary">Advanced Robotics 101 - Term 4</p>
<p class="text-label-sm text-on-surface-variant">Tuition &amp; Materials</p>
</td>
<td class="px-8 py-6 text-body-md text-primary">Aiden</td>
<td class="px-8 py-6 font-bold text-primary">$350.00</td>
<td class="px-8 py-6">
<span class="bg-secondary/10 text-secondary px-3 py-1 rounded-full text-[12px] font-bold">Paid</span>
</td>
<td class="px-8 py-6 text-right">
<button class="text-primary hover:text-vibrant-green transition-colors">
<span class="material-symbols-outlined">download</span>
</button>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-white/40 transition-colors">
<td class="px-8 py-6 text-body-md text-on-surface-variant">Sep 10, 2024</td>
<td class="px-8 py-6">
<p class="font-bold text-primary">Global Youth Hackathon Entry</p>
<p class="text-label-sm text-on-surface-variant">Registration Fee</p>
</td>
<td class="px-8 py-6 text-body-md text-primary">Maya</td>
<td class="px-8 py-6 font-bold text-primary">$75.00</td>
<td class="px-8 py-6">
<span class="bg-secondary/10 text-secondary px-3 py-1 rounded-full text-[12px] font-bold">Paid</span>
</td>
<td class="px-8 py-6 text-right">
<button class="text-primary hover:text-vibrant-green transition-colors">
<span class="material-symbols-outlined">download</span>
</button>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-white/40 transition-colors">
<td class="px-8 py-6 text-body-md text-on-surface-variant">Aug 28, 2024</td>
<td class="px-8 py-6">
<p class="font-bold text-primary">Python for Beginners - Materials</p>
<p class="text-label-sm text-on-surface-variant">Digital License Fee</p>
</td>
<td class="px-8 py-6 text-body-md text-primary">Maya</td>
<td class="px-8 py-6 font-bold text-primary">$45.00</td>
<td class="px-8 py-6">
<span class="bg-secondary/10 text-secondary px-3 py-1 rounded-full text-[12px] font-bold">Paid</span>
</td>
<td class="px-8 py-6 text-right">
<button class="text-primary hover:text-vibrant-green transition-colors">
<span class="material-symbols-outlined">download</span>
</button>
</td>
</tr>
<!-- Row 4 -->
<tr class="hover:bg-white/40 transition-colors">
<td class="px-8 py-6 text-body-md text-on-surface-variant">Oct 15, 2024</td>
<td class="px-8 py-6">
<p class="font-bold text-primary">Upcoming: Fall Workshop Series</p>
<p class="text-label-sm text-on-surface-variant">Term 4 Advance</p>
</td>
<td class="px-8 py-6 text-body-md text-primary">Aiden &amp; Maya</td>
<td class="px-8 py-6 font-bold text-primary">$425.00</td>
<td class="px-8 py-6">
<span class="bg-energetic-orange/10 text-energetic-orange px-3 py-1 rounded-full text-[12px] font-bold">Pending</span>
</td>
<td class="px-8 py-6 text-right">
<button class="text-outline-variant cursor-not-allowed">
<span class="material-symbols-outlined">schedule</span>
</button>
</td>
</tr>
</tbody>
</table>
</div>
<div class="px-8 py-5 bg-white/20 border-t border-glass-border flex justify-between items-center">
<p class="text-label-sm text-on-surface-variant">Showing 1-4 of 12 transactions</p>
<div class="flex space-x-2">
<button class="p-2 rounded-lg border border-glass-border hover:bg-white transition-all text-primary"><span class="material-symbols-outlined text-sm">chevron_left</span></button>
<button class="p-2 rounded-lg border border-glass-border hover:bg-white transition-all text-primary"><span class="material-symbols-outlined text-sm">chevron_right</span></button>
</div>
</div>
</div>
</section>
</main>
</div>
<!-- Footer -->
<footer class="w-full py-section-gap bg-primary">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter max-w-container-max mx-auto px-margin-mobile">
<div class="col-span-1 md:col-span-2">
<div class="text-headline-md font-headline-md font-bold text-on-primary mb-6">Code Geek Academy</div>
<p class="text-on-primary/80 text-body-md mb-8 max-w-sm">© 2024 Code Geek Academy. Empowering the next generation of innovators with cutting-edge technology curriculum and hands-on mentorship.</p>
</div>
<div>
<h4 class="text-on-primary font-bold mb-6">Quick Links</h4>
<ul class="space-y-4">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../index.php">Home</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../programs.php">Programs</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../about.php">About</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="../contact.php">Contacts</a></li>
</ul>
</div>
<div>
<h4 class="text-on-primary font-bold mb-6">Legal</h4>
<ul class="space-y-4">
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="#">Privacy Policy</a></li>
<li><a class="text-on-primary/80 hover:text-vibrant-green transition-colors" href="#">Terms of Service</a></li>
</ul>
<div class="mt-8 flex space-x-4">
<a class="w-10 h-10 rounded-full bg-on-primary/10 flex items-center justify-center text-on-primary hover:bg-vibrant-green transition-all" href="#">
<span class="material-symbols-outlined text-sm">face_nod</span>
</a>
<a class="w-10 h-10 rounded-full bg-on-primary/10 flex items-center justify-center text-on-primary hover:bg-vibrant-green transition-all" href="#">
<span class="material-symbols-outlined text-sm">alternate_email</span>
</a>
</div>
</div>
</div>
</footer>
<script>
        // Micro-interactions for glass cards
        document.querySelectorAll('.glass-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            });
        });

        // Simple Pay Now alert for prototype feel
        const payBtn = document.querySelector('button:has(span:contains("Pay Now"))');
        if(payBtn) {
            payBtn.addEventListener('click', () => {
                alert('Secure payment gateway initializing... This is a demo interface.');
            });
        }
    </script>
</body></html>