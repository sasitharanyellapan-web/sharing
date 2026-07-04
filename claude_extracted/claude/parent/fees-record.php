<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('parent');
require_once __DIR__ . '/../includes/parent_data.php';

$current_user = current_user();
$payments = get_fee_payments($current_user['id']);

$total_verified = 0;
$total_pending = 0;
foreach ($payments as $p) {
    if ($p['status'] === 'verified') $total_verified += $p['amount'];
    if ($p['status'] === 'pending') $total_pending += $p['amount'];
}

$method_labels = [
    'bank_transfer' => 'Bank Transfer',
    'online_banking' => 'Online Banking (FPX)',
    'duitnow' => 'DuitNow',
    'cash' => 'Cash',
    'other' => 'Other',
];

$page_title = 'Fee Record';
$page_description = 'A full history of your tuition fee submissions and their verification status.';
$active = 'fees-record';
require __DIR__ . '/../includes/parent_header.php';
?>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-gutter mb-section-gap">
<div class="glass-card p-6 rounded-3xl">
<p class="text-label-sm text-on-surface-variant mb-1">Total Verified</p>
<p class="text-[32px] font-bold text-secondary leading-none">RM <?php echo number_format($total_verified, 2); ?></p>
</div>
<div class="glass-card p-6 rounded-3xl">
<p class="text-label-sm text-on-surface-variant mb-1">Pending Verification</p>
<p class="text-[32px] font-bold text-energetic-orange leading-none">RM <?php echo number_format($total_pending, 2); ?></p>
</div>
<div class="glass-card p-6 rounded-3xl">
<p class="text-label-sm text-on-surface-variant mb-1">Total Submissions</p>
<p class="text-[32px] font-bold text-primary leading-none"><?php echo count($payments); ?></p>
</div>
</div>

<?php if (empty($payments)): ?>
<div class="glass-card p-10 rounded-3xl text-center">
<span class="material-symbols-outlined text-5xl text-on-surface-variant/40 mb-4">receipt_long</span>
<p class="text-on-surface-variant mb-6">No fee submissions yet.</p>
<a class="bg-primary text-on-primary px-6 py-3 rounded-full font-label-bold text-label-bold hover:scale-105 transition-transform inline-block" href="fees-submission.php">Submit a Payment</a>
</div>
<?php else: ?>
<div class="glass-card rounded-3xl overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead class="bg-primary/5 text-primary">
<tr>
<th class="px-8 py-5 text-label-bold font-label-bold">Submitted</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Child</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Billing Period</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Method</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Amount</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Status</th>
<th class="px-8 py-5 text-label-bold font-label-bold text-right">Receipt</th>
</tr>
</thead>
<tbody class="divide-y divide-glass-border">
<?php foreach ($payments as $p):
    $badge = ['pending' => 'bg-energetic-orange/10 text-energetic-orange', 'verified' => 'bg-secondary/10 text-secondary', 'rejected' => 'bg-error/10 text-error'][$p['status']];
?>
<tr class="hover:bg-white/40 transition-colors">
<td class="px-8 py-6 text-body-md text-on-surface-variant"><?php echo date('d M Y', strtotime($p['submitted_at'])); ?></td>
<td class="px-8 py-6 font-bold text-primary"><?php echo htmlspecialchars($p['child_name']); ?></td>
<td class="px-8 py-6">
<p class="font-bold text-primary"><?php echo htmlspecialchars($p['billing_period']); ?></p>
<?php if ($p['reference_no']): ?><p class="text-label-sm text-on-surface-variant">Ref: <?php echo htmlspecialchars($p['reference_no']); ?></p><?php endif; ?>
</td>
<td class="px-8 py-6 text-body-md text-on-surface-variant"><?php echo htmlspecialchars($method_labels[$p['payment_method']] ?? $p['payment_method']); ?></td>
<td class="px-8 py-6 font-bold text-primary">RM <?php echo number_format($p['amount'], 2); ?></td>
<td class="px-8 py-6">
<span class="<?php echo $badge; ?> px-3 py-1 rounded-full text-[12px] font-bold capitalize"><?php echo htmlspecialchars($p['status']); ?></span>
</td>
<td class="px-8 py-6 text-right">
<?php if ($p['receipt_path']): ?>
<a class="text-primary hover:text-vibrant-green transition-colors inline-flex" href="../<?php echo htmlspecialchars($p['receipt_path']); ?>" target="_blank">
<span class="material-symbols-outlined">download</span>
</a>
<?php else: ?>
<span class="text-outline-variant"><span class="material-symbols-outlined">block</span></span>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
<?php endif; ?>

<?php require __DIR__ . '/../includes/parent_footer.php'; ?>
