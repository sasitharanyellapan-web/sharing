<?php
require_once '../includes/auth.php';

// Already logged in? Send them straight to the dashboard.
if (!empty($_SESSION['user_id']) && ($_SESSION['role'] ?? '') === 'parent') {
    header('Location: dashboard.php');
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = attempt_login($_POST['email'] ?? '', $_POST['password'] ?? '', 'parent');
    if ($result === true) {
        header('Location: dashboard.php');
        exit;
    }
    $error = $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Parent Login | Code Geek Academy</title>
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@400;500;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
tailwind.config = {
  theme: { extend: { colors: {
    primary: "#002045", "on-primary": "#ffffff",
    secondary: "#006d3c", "vibrant-green": "#48BB78",
    surface: "#f7fafc", "on-surface": "#181c1e",
    "on-surface-variant": "#43474e", "outline-variant": "#c4c6cf",
    "surface-container-lowest": "#ffffff"
  }, fontFamily: { display: ["Montserrat", "sans-serif"], body: ["Inter", "sans-serif"] } } }
};
</script>
<style>.material-symbols-outlined{font-family:'Material Symbols Outlined';}</style>
</head>
<body class="bg-surface font-body text-on-surface min-h-screen flex items-center justify-center px-4">
<div class="w-full max-w-md">
<a href="../index.php" class="block text-center mb-8 font-display font-bold text-2xl text-primary">Code Geek Academy</a>
<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-xl p-8">
<h1 class="font-display text-2xl font-bold text-primary mb-1">Parent Portal Login</h1>
<p class="text-on-surface-variant text-sm mb-6">Sign in to manage your children, tuition fees, and attendance.</p>

<?php if ($error): ?>
<div class="mb-4 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-200"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" class="flex flex-col gap-4">
<div>
<label class="block text-sm font-bold mb-1" for="email">Email</label>
<input class="w-full px-4 py-3 rounded-lg border border-outline-variant focus:ring-2 focus:ring-secondary focus:border-secondary" id="email" name="email" required type="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"/>
</div>
<div>
<label class="block text-sm font-bold mb-1" for="password">Password</label>
<input class="w-full px-4 py-3 rounded-lg border border-outline-variant focus:ring-2 focus:ring-secondary focus:border-secondary" id="password" name="password" required type="password"/>
</div>
<button class="mt-2 bg-primary text-on-primary py-3 rounded-full font-bold hover:scale-[1.02] transition-transform shadow-md" type="submit">Log In</button>
</form>

<p class="text-sm text-on-surface-variant mt-6 text-center">
Don't have an account? <a class="text-secondary font-bold hover:underline" href="signup.php">Sign up</a>
</p>
</div>
<p class="text-center text-sm text-on-surface-variant mt-6">
<a class="hover:underline" href="../index.php">&larr; Back to homepage</a> &nbsp;|&nbsp;
<a class="hover:underline" href="../admin/login.php">Staff / Admin Login</a>
</p>
</div>
</body>
</html>
