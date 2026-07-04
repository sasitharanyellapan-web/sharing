<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('parent');
require_once __DIR__ . '/../includes/parent_data.php';

$current_user = current_user();
$pdo = get_db();
$error = null;
$success = null;

$programs = ['Artificial Intelligence (AI)', 'Microbit Robotics', 'Microbit Computing', 'Scratch Programming', 'Not sure yet'];

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_child_id'])) {
    $child = get_child_for_parent((int) $_POST['delete_child_id'], $current_user['id']);
    if ($child) {
        $stmt = $pdo->prepare('DELETE FROM children WHERE id = ? AND parent_id = ?');
        $stmt->execute([$child['id'], $current_user['id']]);
        $success = htmlspecialchars($child['full_name']) . ' has been removed.';
    }
}

// Handle add / edit
$editing_child = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['edit'])) {
    $editing_child = get_child_for_parent((int) $_GET['edit'], $current_user['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['full_name'])) {
    $full_name = trim($_POST['full_name'] ?? '');
    $dob = trim($_POST['date_of_birth'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $program = trim($_POST['program'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    $child_id = $_POST['child_id'] ?? '';

    if ($full_name === '') {
        $error = "Please enter your child's full name.";
    } elseif (!in_array($gender, ['male', 'female'], true) && $gender !== '') {
        $error = 'Please select a valid gender.';
    } else {
        $dob_value = $dob !== '' ? $dob : null;
        $gender_value = $gender !== '' ? $gender : null;

        if ($child_id !== '' && get_child_for_parent((int) $child_id, $current_user['id'])) {
            // Update existing
            $stmt = $pdo->prepare('UPDATE children SET full_name=?, date_of_birth=?, gender=?, program=?, notes=? WHERE id=? AND parent_id=?');
            $stmt->execute([$full_name, $dob_value, $gender_value, $program, $notes, (int) $child_id, $current_user['id']]);
            $success = htmlspecialchars($full_name) . "'s details have been updated.";
        } else {
            // Insert new
            $stmt = $pdo->prepare('INSERT INTO children (parent_id, full_name, date_of_birth, gender, program, notes) VALUES (?,?,?,?,?,?)');
            $stmt->execute([$current_user['id'], $full_name, $dob_value, $gender_value, $program, $notes]);
            $success = htmlspecialchars($full_name) . ' has been registered.';
        }
        $editing_child = null;
    }
}

$children = get_children($current_user['id']);

$page_title = 'Register Children';
$page_description = "Add and manage your children's profiles so we can track their classes, fees, and attendance.";
$active = 'children';
require __DIR__ . '/../includes/parent_header.php';
?>

<?php if ($error): ?>
<div class="mb-8 px-6 py-4 rounded-2xl bg-error/10 text-error border border-error/20"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<?php if ($success): ?>
<div class="mb-8 px-6 py-4 rounded-2xl bg-secondary/10 text-secondary border border-secondary/20"><?php echo $success; ?></div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-gutter">

<!-- Add / Edit form -->
<div class="lg:col-span-2">
<div class="glass-card p-8 rounded-3xl sticky top-24">
<h3 class="font-headline-sm text-headline-sm text-primary mb-6"><?php echo $editing_child ? 'Edit Child' : 'Register a New Child'; ?></h3>
<form method="post" class="flex flex-col gap-4">
<?php if ($editing_child): ?>
<input name="child_id" type="hidden" value="<?php echo (int) $editing_child['id']; ?>"/>
<?php endif; ?>
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Full Name *</label>
<input class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="full_name" required type="text" value="<?php echo htmlspecialchars($editing_child['full_name'] ?? ''); ?>"/>
</div>
<div class="grid grid-cols-2 gap-4">
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Date of Birth</label>
<input class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="date_of_birth" type="date" value="<?php echo htmlspecialchars($editing_child['date_of_birth'] ?? ''); ?>"/>
</div>
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Gender</label>
<select class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="gender">
<option value="">Select</option>
<option value="male" <?php echo (($editing_child['gender'] ?? '') === 'male') ? 'selected' : ''; ?>>Male</option>
<option value="female" <?php echo (($editing_child['gender'] ?? '') === 'female') ? 'selected' : ''; ?>>Female</option>
</select>
</div>
</div>
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Program Interested</label>
<select class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="program">
<option value="">Select a program</option>
<?php foreach ($programs as $p): ?>
<option value="<?php echo htmlspecialchars($p); ?>" <?php echo (($editing_child['program'] ?? '') === $p) ? 'selected' : ''; ?>><?php echo htmlspecialchars($p); ?></option>
<?php endforeach; ?>
</select>
</div>
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Notes (allergies, special needs, etc.)</label>
<textarea class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="notes" rows="3"><?php echo htmlspecialchars($editing_child['notes'] ?? ''); ?></textarea>
</div>
<div class="flex gap-3 mt-2">
<button class="flex-1 bg-primary text-on-primary py-3 rounded-full font-label-bold text-label-bold hover:scale-[1.02] transition-transform shadow-md" type="submit">
<?php echo $editing_child ? 'Save Changes' : 'Register Child'; ?>
</button>
<?php if ($editing_child): ?>
<a class="px-6 py-3 rounded-full font-label-bold text-label-bold border-2 border-glass-border text-on-surface-variant hover:bg-white/50 transition-all" href="children.php">Cancel</a>
<?php endif; ?>
</div>
</form>
</div>
</div>

<!-- Children list -->
<div class="lg:col-span-3">
<h3 class="font-headline-sm text-headline-sm text-primary mb-6">Your Children (<?php echo count($children); ?>)</h3>
<?php if (empty($children)): ?>
<div class="glass-card p-10 rounded-3xl text-center">
<span class="material-symbols-outlined text-5xl text-on-surface-variant/40 mb-4">family_restroom</span>
<p class="text-on-surface-variant">No children registered yet. Use the form to add your first child.</p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-gutter">
<?php foreach ($children as $child):
    $age = $child['date_of_birth'] ? floor((time() - strtotime($child['date_of_birth'])) / 31557600) : null;
    $childInitial = strtoupper(substr($child['full_name'], 0, 1));
?>
<div class="glass-card kinetic-hover p-6 rounded-3xl flex flex-col">
<div class="flex items-center gap-4 mb-4">
<div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-bold text-xl shrink-0"><?php echo htmlspecialchars($childInitial); ?></div>
<div class="min-w-0">
<p class="font-bold text-primary truncate"><?php echo htmlspecialchars($child['full_name']); ?></p>
<p class="text-label-sm text-on-surface-variant">
<?php echo $age !== null ? $age . ' yrs old' : 'Age not set'; ?>
<?php echo $child['gender'] ? ' · ' . ucfirst($child['gender']) : ''; ?>
</p>
</div>
</div>
<?php if ($child['program']): ?>
<span class="inline-block w-fit bg-secondary/10 text-secondary px-3 py-1 rounded-full text-[12px] font-bold mb-3"><?php echo htmlspecialchars($child['program']); ?></span>
<?php endif; ?>
<?php if ($child['notes']): ?>
<p class="text-label-sm text-on-surface-variant mb-4 line-clamp-2"><?php echo htmlspecialchars($child['notes']); ?></p>
<?php endif; ?>
<div class="mt-auto pt-4 flex gap-3 border-t border-glass-border">
<a class="flex-1 text-center py-2 rounded-full border-2 border-glass-border text-primary font-label-bold text-label-sm hover:bg-white/50 transition-all" href="children.php?edit=<?php echo (int) $child['id']; ?>">Edit</a>
<form class="flex-1" method="post" onsubmit="return confirm('Remove this child? This cannot be undone.');">
<input name="delete_child_id" type="hidden" value="<?php echo (int) $child['id']; ?>"/>
<button class="w-full py-2 rounded-full border-2 border-error/20 text-error font-label-bold text-label-sm hover:bg-error/10 transition-all" type="submit">Remove</button>
</form>
</div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</div>

<?php require __DIR__ . '/../includes/parent_footer.php'; ?>
