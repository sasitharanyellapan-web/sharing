<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('parent');
require_once __DIR__ . '/../includes/parent_data.php';

$current_user = current_user();
$pdo = get_db();
$children = get_children($current_user['id']);
$error = null;
$success = null;

$methods = [
    'bank_transfer' => 'Bank Transfer',
    'online_banking' => 'Online Banking (FPX)',
    'duitnow' => 'DuitNow',
    'cash' => 'Cash',
    'other' => 'Other',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $child_id = (int) ($_POST['child_id'] ?? 0);
    $billing_period = trim($_POST['billing_period'] ?? '');
    $amount = $_POST['amount'] ?? '';
    $method = $_POST['payment_method'] ?? '';
    $reference_no = trim($_POST['reference_no'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    $child = get_child_for_parent($child_id, $current_user['id']);

    if (!$child) {
        $error = 'Please select a valid child.';
    } elseif ($billing_period === '') {
        $error = 'Please enter the billing period (e.g. "July 2026").';
    } elseif (!is_numeric($amount) || (float) $amount <= 0) {
        $error = 'Please enter a valid amount.';
    } elseif (!isset($methods[$method])) {
        $error = 'Please select a payment method.';
    } else {
        $upload = handle_receipt_upload($_FILES['receipt'] ?? null);
        if ($upload['error']) {
            $error = $upload['error'];
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO fee_payments (parent_id, child_id, billing_period, amount, payment_method, reference_no, receipt_path, notes, status)
                 VALUES (?,?,?,?,?,?,?,?,\'pending\')'
            );
            $stmt->execute([
                $current_user['id'], $child_id, $billing_period, (float) $amount,
                $method, $reference_no ?: null, $upload['path'], $notes ?: null,
            ]);
            $success = 'Your fee submission has been received and is pending verification.';
        }
    }
}

$page_title = 'Fee Submission';
$page_description = 'Submit your tuition fee payment details for our team to verify.';
$active = 'fees-submission';
require __DIR__ . '/../includes/parent_header.php';
?>

<?php if (empty($children)): ?>
<div class="glass-card p-10 rounded-3xl text-center max-w-2xl">
<span class="material-symbols-outlined text-5xl text-on-surface-variant/40 mb-4">family_restroom</span>
<p class="text-on-surface-variant mb-6">You need to register a child before submitting a tuition fee payment.</p>
<a class="bg-primary text-on-primary px-6 py-3 rounded-full font-label-bold text-label-bold hover:scale-105 transition-transform inline-block" href="children.php">Register a Child</a>
</div>
<?php else: ?>

<?php if ($error): ?>
<div class="mb-8 px-6 py-4 rounded-2xl bg-error/10 text-error border border-error/20 max-w-2xl"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<?php if ($success): ?>
<div class="mb-8 px-6 py-4 rounded-2xl bg-secondary/10 text-secondary border border-secondary/20 max-w-2xl flex items-center justify-between gap-4">
<span><?php echo htmlspecialchars($success); ?></span>
<a class="text-primary font-label-bold text-label-sm whitespace-nowrap hover:underline" href="fees-record.php">View Fee Record →</a>
</div>
<?php endif; ?>

<div class="glass-card p-8 rounded-3xl max-w-2xl">
<form method="post" enctype="multipart/form-data" class="flex flex-col gap-5">
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Child *</label>
<select class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="child_id" required>
<option value="">Select a child</option>
<?php foreach ($children as $c): ?>
<option value="<?php echo (int) $c['id']; ?>"><?php echo htmlspecialchars($c['full_name']); ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Billing Period *</label>
<input class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="billing_period" placeholder="e.g. July 2026" required type="text"/>
</div>
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Amount (RM) *</label>
<input class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" min="0" name="amount" required step="0.01" type="number"/>
</div>
</div>
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Payment Method *</label>
<select class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="payment_method" required>
<option value="">Select a method</option>
<?php foreach ($methods as $key => $label): ?>
<option value="<?php echo $key; ?>"><?php echo htmlspecialchars($label); ?></option>
<?php endforeach; ?>
</select>
</div>
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Transaction / Reference No.</label>
<input class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="reference_no" type="text"/>
</div>
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Upload Receipt (JPG, PNG or PDF, max 5MB)</label>
<input class="w-full px-4 py-3 rounded-xl border border-dashed border-glass-border bg-white/60" name="receipt" type="file" accept=".jpg,.jpeg,.png,.pdf"/>
</div>
<div>
<label class="block text-label-sm font-label-bold text-on-surface-variant mb-1">Notes</label>
<textarea class="w-full px-4 py-3 rounded-xl border border-glass-border bg-white/60 focus:ring-2 focus:ring-secondary focus:border-secondary" name="notes" rows="3"></textarea>
</div>
<button class="mt-2 bg-primary text-on-primary py-4 rounded-full font-label-bold text-label-bold hover:scale-[1.01] transition-transform shadow-md flex items-center justify-center gap-2" type="submit">
<span class="material-symbols-outlined">upload_file</span>
Submit Fee Payment
</button>
<p class="text-label-sm text-on-surface-variant text-center">Our team will verify your submission — track its status anytime under <a class="text-secondary hover:underline font-bold" href="fees-record.php">Fee Record</a>.</p>
</form>
</div>
<?php endif; ?>

<?php require __DIR__ . '/../includes/parent_footer.php'; ?>
