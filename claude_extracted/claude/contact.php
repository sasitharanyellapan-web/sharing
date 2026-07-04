<?php
$programOptions = [
    'Scratch Programming',
    'Microbit Computing',
    'Microbit Robotics',
    'Artificial Intelligence (AI)',
];

$formValues = [
    'name' => trim($_POST['name'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'phone' => trim($_POST['phone'] ?? '+60 '),
    'program' => trim($_POST['program'] ?? ''),
    'message' => trim($_POST['message'] ?? ''),
];
$formErrors = [];
$formSuccess = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($formValues as $field => $value) {
        if ($value === '') {
            $formErrors[] = 'Please fill in all fields before sending your message.';
            break;
        }
    }

    if ($formValues['email'] !== '' && !filter_var($formValues['email'], FILTER_VALIDATE_EMAIL)) {
        $formErrors[] = 'Please enter a valid email address.';
    }

    $phoneDigits = preg_replace('/\D+/', '', $formValues['phone']);
    if ($formValues['phone'] !== '' && strlen($phoneDigits) <= 2) {
        $formErrors[] = 'Please enter your phone number after +60.';
    }

    if ($formValues['program'] !== '' && !in_array($formValues['program'], $programOptions, true)) {
        $formErrors[] = 'Please choose a valid program of interest.';
    }

    if (empty($formErrors)) {
        $to = 'codegeekacademy@gmail.com';
        $subject = 'New enquiry from Code Geek Academy website';
        $body = "Name: {$formValues['name']}\n"
            . "Email: {$formValues['email']}\n"
            . "Phone: {$formValues['phone']}\n"
            . "Program of Interest: {$formValues['program']}\n\n"
            . "Message:\n{$formValues['message']}\n";
        $headers = [
            'From: Code Geek Academy Website <no-reply@codegeekacademy.com.my>',
            'Reply-To: ' . $formValues['email'],
            'Content-Type: text/plain; charset=UTF-8',
        ];

        if (mail($to, $subject, $body, implode("\r\n", $headers))) {
            $formSuccess = 'Thank you. Your message has been sent successfully.';
            $formValues = [
                'name' => '',
                'email' => '',
                'phone' => '+60 ',
                'program' => '',
                'message' => '',
            ];
        } else {
            $formErrors[] = 'Sorry, your message could not be sent right now. Please email codegeekacademy@gmail.com directly.';
        }
    }
}
?>
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
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="index.php">Home</a>
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="programs.php">Programs</a>
<a class="text-on-surface-variant hover:scale-105 transition-transform duration-200 hover:text-secondary font-label-bold text-label-bold" href="about.php">About</a>
<a class="text-secondary border-b-2 border-secondary pb-1 font-label-bold text-label-bold transition-all duration-300" href="contact.php">Contacts</a>
</div>
<a class="bg-primary text-on-primary px-6 py-2 rounded-full font-label-bold text-label-bold hover:scale-105 transition-transform shadow-md" href="parent/login.php">
                Parent Portal
            </a>
</div>
</nav>
<main class="pt-32 pb-section-gap">
<!-- Hero Section -->
<section class="max-w-container-max mx-auto px-margin-mobile mb-20 text-center relative">
<div class="absolute -top-20 left-1/2 -translate-x-1/2 w-64 h-64 bg-vibrant-green/10 blur-3xl rounded-full -z-10"></div>
<h1 class="font-display-lg text-display-lg text-primary mb-stack-md">Get in Touch</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                Ready to ignite your child's passion for technology? Whether you have questions about our curriculum or need help choosing the right path, we're here to support your STEM journey.
            </p>
</section>
<!-- Main Content Section -->
<section class="max-w-container-max mx-auto px-margin-mobile grid grid-cols-1 md:grid-cols-12 gap-gutter">
<!-- Left Column: Contact Form -->
<div class="md:col-span-7 glass-card p-10 rounded-xl hover-lift">
<h2 class="font-headline-md text-headline-md text-primary mb-stack-lg">Send us a message</h2>
<?php if (!empty($formErrors)): ?>
<div class="mb-stack-md rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
<?php foreach ($formErrors as $error): ?>
<p><?php echo htmlspecialchars($error); ?></p>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if ($formSuccess): ?>
<div class="mb-stack-md rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-secondary">
<?php echo htmlspecialchars($formSuccess); ?>
</div>
<?php endif; ?>
<form class="space-y-stack-md" method="post" action="contact.php">
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
<div>
<label class="block font-label-bold text-label-bold text-primary mb-2" for="name">Name</label>
<input class="w-full bg-surface-container-lowest border border-primary/20 rounded-lg p-3 focus:ring-2 focus:ring-vibrant-green focus:border-vibrant-green outline-none transition-all" id="name" name="name" placeholder="Your Name" required type="text" value="<?php echo htmlspecialchars($formValues['name']); ?>"/>
</div>
<div>
<label class="block font-label-bold text-label-bold text-primary mb-2" for="email">Email</label>
<input class="w-full bg-surface-container-lowest border border-primary/20 rounded-lg p-3 focus:ring-2 focus:ring-vibrant-green focus:border-vibrant-green outline-none transition-all" id="email" name="email" placeholder="your@email.com" required type="email" value="<?php echo htmlspecialchars($formValues['email']); ?>"/>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
<div>
<label class="block font-label-bold text-label-bold text-primary mb-2" for="phone">Phone</label>
<input class="w-full bg-surface-container-lowest border border-primary/20 rounded-lg p-3 focus:ring-2 focus:ring-vibrant-green focus:border-vibrant-green outline-none transition-all" id="phone" name="phone" placeholder="+60 10 460 6759" required type="tel" value="<?php echo htmlspecialchars($formValues['phone']); ?>"/>
</div>
<div>
<label class="block font-label-bold text-label-bold text-primary mb-2" for="program">Program of Interest</label>
<select class="w-full bg-surface-container-lowest border border-primary/20 rounded-lg p-3 focus:ring-2 focus:ring-vibrant-green focus:border-vibrant-green outline-none transition-all" id="program" name="program" required>
<option value="">Select a program</option>
<?php foreach ($programOptions as $program): ?>
<option value="<?php echo htmlspecialchars($program); ?>" <?php echo $formValues['program'] === $program ? 'selected' : ''; ?>><?php echo htmlspecialchars($program); ?></option>
<?php endforeach; ?>
</select>
</div>
</div>
<div>
<label class="block font-label-bold text-label-bold text-primary mb-2" for="message">Message</label>
<textarea class="w-full bg-surface-container-lowest border border-primary/20 rounded-lg p-3 focus:ring-2 focus:ring-vibrant-green focus:border-vibrant-green outline-none transition-all" id="message" name="message" placeholder="How can we help your student grow?" required rows="5"><?php echo htmlspecialchars($formValues['message']); ?></textarea>
</div>
<button class="w-full bg-primary text-on-primary py-4 rounded-full font-label-bold text-label-bold hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg flex items-center justify-center gap-2" type="submit">
<span class="material-symbols-outlined">send</span> Send Message
                    </button>
</form>
</div>
<!-- Right Column: Info & Socials -->
<div class="md:col-span-5 space-y-gutter">
<!-- Contact Info Card -->
<div class="glass-card p-10 rounded-xl hover-lift">
<h3 class="font-headline-sm text-headline-sm text-primary mb-stack-lg">Contact Information</h3>
<div class="space-y-stack-lg">
<div class="flex items-start gap-4">
<div class="w-12 h-12 bg-primary-container rounded-full flex items-center justify-center text-on-primary-container shrink-0">
<span class="material-symbols-outlined">mail</span>
</div>
<div>
<p class="font-label-bold text-label-bold text-primary">Email Address</p>
<a class="text-on-surface-variant hover:text-secondary transition-colors" href="mailto:codegeekacademy@gmail.com">codegeekacademy@gmail.com</a>
</div>
</div>
<div class="flex items-start gap-4">
<div class="w-12 h-12 bg-primary-container rounded-full flex items-center justify-center text-on-primary-container shrink-0">
<span class="material-symbols-outlined">call</span>
</div>
<div>
<p class="font-label-bold text-label-bold text-primary">Phone Number</p>
<a class="text-on-surface-variant hover:text-secondary transition-colors" href="tel:+60104606759">+60 10 460 6759</a>
</div>
</div>
<div class="flex items-start gap-4">
<div class="w-12 h-12 bg-primary-container rounded-full flex items-center justify-center text-on-primary-container shrink-0">
<span class="material-symbols-outlined">chat</span>
</div>
<div>
<p class="font-label-bold text-label-bold text-primary">WhatsApp</p>
<a class="text-on-surface-variant hover:text-secondary transition-colors" href="https://wa.me/60104606759" rel="noopener" target="_blank">Message us on WhatsApp</a>
</div>
</div>
</div>
</div>
<!-- Social Media Card -->
<div class="glass-card p-10 rounded-xl hover-lift">
<h3 class="font-headline-sm text-headline-sm text-primary mb-stack-lg">Follow Our Updates</h3>
<p class="text-on-surface-variant mb-stack-lg">Join our community of over 5,000 parents and students exploring the future of STEM.</p>
<div class="flex gap-4">
<a aria-label="Facebook" class="w-12 h-12 bg-surface-container-high hover:bg-vibrant-green hover:text-white transition-colors rounded-full flex items-center justify-center" href="https://www.facebook.com/p/Code-Geek-Academy-61550354368654/" rel="noopener" target="_blank">
<svg class="w-6 h-6 fill-current" viewbox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path></svg>
</a>
<a aria-label="TikTok" class="w-12 h-12 bg-surface-container-high hover:bg-vibrant-green hover:text-white transition-colors rounded-full flex items-center justify-center" href="https://www.tiktok.com/@codegeekacademy" rel="noopener" target="_blank">
<svg class="w-6 h-6 fill-current" viewbox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 1 1-2.89-2.89c.3 0 .6.05.88.14V9.4a6.34 6.34 0 0 0-.88-.06A6.34 6.34 0 1 0 15.82 15.67V8.74a8.16 8.16 0 0 0 4.77 1.53V6.69z"></path></svg>
</a>
<span aria-label="Instagram" class="w-12 h-12 bg-surface-container-high rounded-full flex items-center justify-center text-on-surface-variant">
<svg class="w-6 h-6 fill-current" viewbox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
</span>
<span aria-label="LinkedIn" class="w-12 h-12 bg-surface-container-high rounded-full flex items-center justify-center text-on-surface-variant">
<svg class="w-6 h-6 fill-current" viewbox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path></svg>
</span>
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
        // Micro-interaction for form inputs
        document.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('focus', () => {
                el.parentElement.querySelector('label')?.classList.add('text-vibrant-green');
            });
            el.addEventListener('blur', () => {
                el.parentElement.querySelector('label')?.classList.remove('text-vibrant-green');
            });
        });

        // Simple smooth scroll reveal effect
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-10');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.glass-card').forEach(card => {
            card.classList.add('transition-all', 'duration-700', 'opacity-0', 'translate-y-10');
            observer.observe(card);
        });
    </script>
</body></html>
