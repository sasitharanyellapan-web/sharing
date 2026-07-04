<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('parent');
require_once __DIR__ . '/../includes/parent_data.php';

$current_user = current_user();
$children = get_children($current_user['id']);
$summary = get_dashboard_summary($current_user['id']);
$recent_fees = array_slice(get_fee_payments($current_user['id']), 0, 3);
$recent_attendance = array_slice(get_attendance_for_parent($current_user['id']), 0, 3);

$first_name = explode(' ', $current_user['name'])[0];
$page_title = 'Dashboard';
$page_description = "Welcome back, {$first_name}. Here's what's happening with your family's account.";
$active = 'dashboard';
require __DIR__ . '/../includes/parent_header.php';
?>

<!-- Quick Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-section-gap">
<div class="glass-card kinetic-hover p-6 rounded-3xl">
<div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-4">
<span class="material-symbols-outlined">family_restroom</span>
</div>
<p class="text-[32px] font-bold text-primary leading-none mb-1"><?php echo count($children); ?></p>
<p class="text-label-sm text-on-surface-variant">Children Registered</p>
</div>
<div class="glass-card kinetic-hover p-6 rounded-3xl">
<div class="w-12 h-12 rounded-2xl bg-energetic-orange/10 flex items-center justify-center text-energetic-orange mb-4">
<span class="material-symbols-outlined">pending_actions</span>
</div>
<p class="text-[32px] font-bold text-primary leading-none mb-1"><?php echo $summary['pending_fees']; ?></p>
<p class="text-label-sm text-on-surface-variant">Fee Submissions Pending</p>
</div>
<div class="glass-card kinetic-hover p-6 rounded-3xl">
<div class="w-12 h-12 rounded-2xl bg-vibrant-green/10 flex items-center justify-center text-secondary mb-4">
<span class="material-symbols-outlined">fact_check</span>
</div>
<p class="text-[32px] font-bold text-primary leading-none mb-1"><?php echo $summary['attendance_rate'] !== null ? $summary['attendance_rate'] . '%' : '—'; ?></p>
<p class="text-label-sm text-on-surface-variant">Overall Attendance Rate</p>
</div>
<div class="glass-card kinetic-hover p-6 rounded-3xl">
<div class="w-12 h-12 rounded-2xl bg-deep-navy/10 flex items-center justify-center text-primary mb-4">
<span class="material-symbols-outlined">event_available</span>
</div>
<p class="text-[32px] font-bold text-primary leading-none mb-1"><?php echo $summary['total_sessions']; ?></p>
<p class="text-label-sm text-on-surface-variant">Sessions Recorded</p>
</div>
</div>

<!-- Quick Actions -->
<div class="mb-section-gap">
<h3 class="font-headline-sm text-headline-sm text-primary mb-6">Quick Actions</h3>
<div class="grid grid-cols-1 sm:grid-cols-3 gap-gutter">
<a href="children.php" class="glass-card kinetic-hover p-6 rounded-3xl flex items-center gap-4">
<div class="w-12 h-12 rounded-full bg-primary text-on-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined">add</span>
</div>
<div>
<p class="font-bold text-primary">Register a Child</p>
<p class="text-label-sm text-on-surface-variant">Add your child's details</p>
</div>
</a>
<a href="fees-submission.php" class="glass-card kinetic-hover p-6 rounded-3xl flex items-center gap-4">
<div class="w-12 h-12 rounded-full bg-primary text-on-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined">upload_file</span>
</div>
<div>
<p class="font-bold text-primary">Submit Tuition Fee</p>
<p class="text-label-sm text-on-surface-variant">Record a new payment</p>
</div>
</a>
<a href="attendance.php" class="glass-card kinetic-hover p-6 rounded-3xl flex items-center gap-4">
<div class="w-12 h-12 rounded-full bg-primary text-on-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined">fact_check</span>
</div>
<div>
<p class="font-bold text-primary">View Attendance</p>
<p class="text-label-sm text-on-surface-variant">Check session records</p>
</div>
</a>
</div>
</div>

<?php if (empty($children)): ?>
<div class="glass-card p-8 rounded-3xl mb-section-gap flex flex-col md:flex-row items-center justify-between gap-6">
<div class="flex items-center gap-4">
<div class="w-14 h-14 rounded-2xl bg-energetic-orange/10 flex items-center justify-center text-energetic-orange">
<span class="material-symbols-outlined">info</span>
</div>
<div>
<p class="font-bold text-primary">You haven't registered any children yet</p>
<p class="text-label-sm text-on-surface-variant">Register your child to unlock fee submission and attendance tracking.</p>
</div>
</div>
<a href="children.php" class="bg-primary text-on-primary px-6 py-3 rounded-full font-label-bold text-label-bold whitespace-nowrap hover:scale-105 transition-transform">Register Now</a>
</div>
<?php endif; ?>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
<div class="glass-card p-8 rounded-3xl">
<div class="flex justify-between items-center mb-6">
<h3 class="font-headline-sm text-headline-sm text-primary">Recent Fee Submissions</h3>
<a href="fees-record.php" class="text-secondary text-label-sm font-label-bold hover:underline">View all</a>
</div>
<?php if (empty($recent_fees)): ?>
<p class="text-on-surface-variant text-body-md">No fee submissions yet.</p>
<?php else: ?>
<div class="space-y-4">
<?php foreach ($recent_fees as $fee): ?>
<div class="flex items-center justify-between border-b border-glass-border pb-4 last:border-0 last:pb-0">
<div>
<p class="font-bold text-primary"><?php echo htmlspecialchars($fee['child_name']); ?> — <?php echo htmlspecialchars($fee['billing_period']); ?></p>
<p class="text-label-sm text-on-surface-variant">RM <?php echo number_format($fee['amount'], 2); ?></p>
</div>
<?php $badge = ['pending' => 'bg-energetic-orange/10 text-energetic-orange', 'verified' => 'bg-secondary/10 text-secondary', 'rejected' => 'bg-error/10 text-error'][$fee['status']]; ?>
<span class="<?php echo $badge; ?> px-3 py-1 rounded-full text-[12px] font-bold capitalize"><?php echo htmlspecialchars($fee['status']); ?></span>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
<div class="glass-card p-8 rounded-3xl">
<div class="flex justify-between items-center mb-6">
<h3 class="font-headline-sm text-headline-sm text-primary">Recent Attendance</h3>
<a href="attendance.php" class="text-secondary text-label-sm font-label-bold hover:underline">View all</a>
</div>
<?php if (empty($recent_attendance)): ?>
<p class="text-on-surface-variant text-body-md">No attendance records yet.</p>
<?php else: ?>
<div class="space-y-4">
<?php foreach ($recent_attendance as $a): ?>
<div class="flex items-center justify-between border-b border-glass-border pb-4 last:border-0 last:pb-0">
<div>
<p class="font-bold text-primary"><?php echo htmlspecialchars($a['child_name']); ?></p>
<p class="text-label-sm text-on-surface-variant"><?php echo date('d M Y', strtotime($a['session_date'])); ?><?php echo $a['program'] ? ' · ' . htmlspecialchars($a['program']) : ''; ?></p>
</div>
<?php $abadge = ['present' => 'bg-secondary/10 text-secondary', 'late' => 'bg-energetic-orange/10 text-energetic-orange', 'absent' => 'bg-error/10 text-error'][$a['status']]; ?>
<span class="<?php echo $abadge; ?> px-3 py-1 rounded-full text-[12px] font-bold capitalize"><?php echo htmlspecialchars($a['status']); ?></span>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</div>

<?php require __DIR__ . '/../includes/parent_footer.php'; ?>
