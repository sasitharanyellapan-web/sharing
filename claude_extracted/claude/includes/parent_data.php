<?php
require_once __DIR__ . '/db.php';

/** All children belonging to a parent, most recently added first. */
function get_children($parent_id) {
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT * FROM children WHERE parent_id = ? ORDER BY created_at DESC');
    $stmt->execute([$parent_id]);
    return $stmt->fetchAll();
}

/** A single child, but only if it belongs to this parent (ownership check). */
function get_child_for_parent($child_id, $parent_id) {
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT * FROM children WHERE id = ? AND parent_id = ? LIMIT 1');
    $stmt->execute([$child_id, $parent_id]);
    return $stmt->fetch() ?: null;
}

/** Fee submissions for a parent, newest first, with child name attached. */
function get_fee_payments($parent_id) {
    $pdo = get_db();
    $stmt = $pdo->prepare(
        'SELECT fp.*, c.full_name AS child_name
         FROM fee_payments fp
         JOIN children c ON c.id = fp.child_id
         WHERE fp.parent_id = ?
         ORDER BY fp.submitted_at DESC'
    );
    $stmt->execute([$parent_id]);
    return $stmt->fetchAll();
}

/** Attendance rows for every child belonging to a parent. */
function get_attendance_for_parent($parent_id, $child_id = null) {
    $pdo = get_db();
    $sql = 'SELECT a.*, c.full_name AS child_name
            FROM attendance a
            JOIN children c ON c.id = a.child_id
            WHERE c.parent_id = ?';
    $params = [$parent_id];
    if ($child_id) {
        $sql .= ' AND a.child_id = ?';
        $params[] = $child_id;
    }
    $sql .= ' ORDER BY a.session_date DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/** Small dashboard summary numbers for the current parent. */
function get_dashboard_summary($parent_id) {
    $pdo = get_db();

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM children WHERE parent_id = ?');
    $stmt->execute([$parent_id]);
    $children_count = (int) $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM fee_payments WHERE parent_id = ? AND status = 'pending'");
    $stmt->execute([$parent_id]);
    $pending_fees = (int) $stmt->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM attendance a JOIN children c ON c.id = a.child_id
         WHERE c.parent_id = ?"
    );
    $stmt->execute([$parent_id]);
    $total_sessions = (int) $stmt->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT COUNT(*) FROM attendance a JOIN children c ON c.id = a.child_id
         WHERE c.parent_id = ? AND a.status = 'present'"
    );
    $stmt->execute([$parent_id]);
    $present_sessions = (int) $stmt->fetchColumn();

    $attendance_rate = $total_sessions > 0 ? round(($present_sessions / $total_sessions) * 100) : null;

    return [
        'children_count' => $children_count,
        'pending_fees' => $pending_fees,
        'attendance_rate' => $attendance_rate,
        'total_sessions' => $total_sessions,
    ];
}

/** Handles a receipt file upload for a fee submission. Returns the relative
 *  path to store in the DB, or null if no file was uploaded, or throws a
 *  string error via the returned ['error' => ...] shape. */
function handle_receipt_upload($file) {
    if (empty($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['path' => null, 'error' => null];
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['path' => null, 'error' => 'There was a problem uploading your file.'];
    }
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'application/pdf' => 'pdf'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!isset($allowed[$mime])) {
        return ['path' => null, 'error' => 'Please upload a JPG, PNG, or PDF file only.'];
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        return ['path' => null, 'error' => 'File is too large (max 5MB).'];
    }

    $uploadDir = __DIR__ . '/../uploads/receipts/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $filename = uniqid('receipt_', true) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        return ['path' => null, 'error' => 'Could not save the uploaded file.'];
    }
    return ['path' => 'uploads/receipts/' . $filename, 'error' => null];
}
