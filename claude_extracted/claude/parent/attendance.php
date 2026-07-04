<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('parent');
require_once __DIR__ . '/../includes/parent_data.php';

$current_user = current_user();
$children = get_children($current_user['id']);

$filter_child_id = isset($_GET['child']) ? (int) $_GET['child'] : null;
if ($filter_child_id && !get_child_for_parent($filter_child_id, $current_user['id'])) {
    $filter_child_id = null; // ignore invalid/foreign child id
}

$records = get_attendance_for_parent($current_user['id'], $filter_child_id);

$total = count($records);
$present = count(array_filter($records, fn($r) => $r['status'] === 'present'));
$late = count(array_filter($records, fn($r) => $r['status'] === 'late'));
$absent = count(array_filter($records, fn($r) => $r['status'] === 'absent'));
$rate = $total > 0 ? round(($present / $total) * 100) : null;

$page_title = 'Attendance';
$page_description = "View your children's class attendance records.";
$active = 'attendance';
require __DIR__ . '/../includes/parent_header.php';
?>

<?php if (empty($children)): ?>
<div class="glass-card p-10 rounded-3xl text-center max-w-2xl">
<span class="material-symbols-outlined text-5xl text-on-surface-variant/40 mb-4">family_restroom</span>
<p class="text-on-surface-variant mb-6">Register a child to start tracking their attendance.</p>
<a class="bg-primary text-on-primary px-6 py-3 rounded-full font-label-bold text-label-bold hover:scale-105 transition-transform inline-block" href="children.php">Register a Child</a>
</div>
<?php else: ?>

<!-- Child filter -->
<div class="flex flex-wrap gap-3 mb-8">
<a href="attendance.php" class="px-5 py-2 rounded-full font-label-bold text-label-sm transition-all <?php echo !$filter_child_id ? 'bg-primary text-on-primary' : 'bg-white/50 text-on-surface-variant border border-glass-border hover:bg-white'; ?>">All Children</a>
<?php foreach ($children as $c): ?>
<a href="attendance.php?child=<?php echo (int) $c['id']; ?>" class="px-5 py-2 rounded-full font-label-bold text-label-sm transition-all <?php echo $filter_child_id === (int) $c['id'] ? 'bg-primary text-on-primary' : 'bg-white/50 text-on-surface-variant border border-glass-border hover:bg-white'; ?>"><?php echo htmlspecialchars($c['full_name']); ?></a>
<?php endforeach; ?>
</div>

<!-- Summary -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-gutter mb-section-gap">
<div class="glass-card p-6 rounded-3xl">
<p class="text-label-sm text-on-surface-variant mb-1">Attendance Rate</p>
<p class="text-[32px] font-bold text-primary leading-none"><?php echo $rate !== null ? $rate . '%' : '—'; ?></p>
</div>
<div class="glass-card p-6 rounded-3xl">
<p class="text-label-sm text-on-surface-variant mb-1">Present</p>
<p class="text-[32px] font-bold text-secondary leading-none"><?php echo $present; ?></p>
</div>
<div class="glass-card p-6 rounded-3xl">
<p class="text-label-sm text-on-surface-variant mb-1">Late</p>
<p class="text-[32px] font-bold text-energetic-orange leading-none"><?php echo $late; ?></p>
</div>
<div class="glass-card p-6 rounded-3xl">
<p class="text-label-sm text-on-surface-variant mb-1">Absent</p>
<p class="text-[32px] font-bold text-error leading-none"><?php echo $absent; ?></p>
</div>
</div>

<?php if (empty($records)): ?>
<div class="glass-card p-10 rounded-3xl text-center">
<span class="material-symbols-outlined text-5xl text-on-surface-variant/40 mb-4">fact_check</span>
<p class="text-on-surface-variant">No attendance records yet. Records will appear here once your child's sessions have started.</p>
</div>
<?php else: ?>
<div class="glass-card rounded-3xl overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead class="bg-primary/5 text-primary">
<tr>
<th class="px-8 py-5 text-label-bold font-label-bold">Date</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Child</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Program</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Status</th>
<th class="px-8 py-5 text-label-bold font-label-bold">Remarks</th>
</tr>
</thead>
<tbody class="divide-y divide-glass-border">
<?php foreach ($records as $r):
    $badge = ['present' => 'bg-secondary/10 text-secondary', 'late' => 'bg-energetic-orange/10 text-energetic-orange', 'absent' => 'bg-error/10 text-error'][$r['status']];
?>
<tr class="hover:bg-white/40 transition-colors">
<td class="px-8 py-6 text-body-md text-on-surface-variant"><?php echo date('d M Y', strtotime($r['session_date'])); ?></td>
<td class="px-8 py-6 font-bold text-primary"><?php echo htmlspecialchars($r['child_name']); ?></td>
<td class="px-8 py-6 text-body-md text-on-surface-variant"><?php echo htmlspecialchars($r['program'] ?: '—'); ?></td>
<td class="px-8 py-6">
<span class="<?php echo $badge; ?> px-3 py-1 rounded-full text-[12px] font-bold capitalize"><?php echo htmlspecialchars($r['status']); ?></span>
</td>
<td class="px-8 py-6 text-body-md text-on-surface-variant"><?php echo htmlspecialchars($r['remarks'] ?: '—'); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
<?php endif; ?>
<?php endif; ?>

<?php require __DIR__ . '/../includes/parent_footer.php'; ?>
