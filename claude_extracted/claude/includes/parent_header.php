<?php
// Expects $page_title, $page_description, $active, and $current_user to
// already be set by the including page.
$active = $active ?? '';
function nav_class($key, $active) {
    return $key === $active
        ? 'flex items-center px-8 py-4 sidebar-active'
        : 'flex items-center px-8 py-4 text-on-surface-variant hover:bg-white/50 transition-colors';
}
function nav_icon_style($key, $active) {
    return $key === $active ? " style=\"font-variation-settings: 'FILL' 1;\"" : '';
}
$initials = '';
if (!empty($current_user['name'])) {
    $parts = preg_split('/\s+/', trim($current_user['name']));
    $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
}
?>
<!DOCTYPE html>
<html class="scroll-smooth" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo htmlspecialchars($page_title); ?> | Code Geek Academy Parent Portal</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&amp;family=Inter:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
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
        .kinetic-hover { transition: all 0.3s ease-out; }
        .kinetic-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(26, 54, 93, 0.1); }
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
        .sidebar-group-label {
            font-size: 11px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #74777f;
            padding: 0 2rem;
            margin-top: 1.5rem;
            margin-bottom: 0.25rem;
        }
    </style>
</head>
<body class="font-body-md text-on-surface bg-background gradient-mesh min-h-screen">
<!-- TopNavBar (standardized — matches the public homepage header) -->
<nav class="fixed top-0 w-full z-50 backdrop-blur-xl bg-glass-surface border-b border-glass-border shadow-sm">
<div class="flex justify-between items-center px-8 py-4 max-w-container-max mx-auto">
<a href="../index.php" class="text-headline-sm font-headline-sm font-bold text-primary">Code Geek Academy</a>
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
<aside class="hidden md:flex flex-col w-64 bg-white/30 backdrop-blur-md border-r border-glass-border sticky top-20 h-[calc(100vh-80px)] py-8 overflow-y-auto">
<nav class="flex-1 space-y-1">
<a class="<?php echo nav_class('dashboard', $active); ?>" href="dashboard.php">
<span class="material-symbols-outlined mr-4"<?php echo nav_icon_style('dashboard', $active); ?>>dashboard</span>
<span class="font-label-bold text-label-bold">Dashboard</span>
</a>

<div class="sidebar-group-label">Tuition Fee</div>
<a class="<?php echo nav_class('fees-submission', $active); ?>" href="fees-submission.php">
<span class="material-symbols-outlined mr-4"<?php echo nav_icon_style('fees-submission', $active); ?>>upload_file</span>
<span class="font-label-bold text-label-bold">Fee Submission</span>
</a>
<a class="<?php echo nav_class('fees-record', $active); ?>" href="fees-record.php">
<span class="material-symbols-outlined mr-4"<?php echo nav_icon_style('fees-record', $active); ?>>receipt_long</span>
<span class="font-label-bold text-label-bold">Fee Record</span>
</a>

<div class="sidebar-group-label">My Family</div>
<a class="<?php echo nav_class('children', $active); ?>" href="children.php">
<span class="material-symbols-outlined mr-4"<?php echo nav_icon_style('children', $active); ?>>family_restroom</span>
<span class="font-label-bold text-label-bold">Register Children</span>
</a>
<a class="<?php echo nav_class('attendance', $active); ?>" href="attendance.php">
<span class="material-symbols-outlined mr-4"<?php echo nav_icon_style('attendance', $active); ?>>fact_check</span>
<span class="font-label-bold text-label-bold">Attendance</span>
</a>
</nav>
<div class="px-8 mt-auto pt-8">
<div class="glass-card p-4 rounded-xl flex items-center space-x-3">
<div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold"><?php echo htmlspecialchars($initials ?: 'P'); ?></div>
<div class="min-w-0">
<p class="text-label-sm font-label-bold text-primary truncate"><?php echo htmlspecialchars($current_user['name'] ?? 'Parent'); ?></p>
<p class="text-[10px] text-on-surface-variant">Parent Account</p>
</div>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="flex-1 p-8 md:p-12 overflow-y-auto">
<header class="mb-10">
<h1 class="text-display-lg-mobile md:text-headline-md font-headline-md text-primary mb-2"><?php echo htmlspecialchars($page_title); ?></h1>
<?php if (!empty($page_description)): ?>
<p class="text-body-md text-on-surface-variant"><?php echo htmlspecialchars($page_description); ?></p>
<?php endif; ?>
</header>
