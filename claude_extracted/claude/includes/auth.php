<?php
require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Redirects to the correct login page for a role, remembering where the
 * user was trying to go so we can send them back after login.
 */
function login_url_for_role($role) {
    $base = ($role === 'admin') ? 'login.php' : 'login.php';
    return $base;
}

/**
 * Call this at the very top of any page that requires the user to be
 * logged in as a specific role ('parent' or 'admin'). If they are not,
 * they get redirected to the matching login page.
 */
function require_role($role) {
    if (empty($_SESSION['user_id']) || empty($_SESSION['role']) || $_SESSION['role'] !== $role) {
        $redirect = ($role === 'admin') ? 'login.php' : 'login.php';
        header('Location: ' . $redirect);
        exit;
    }
}

/**
 * Returns the logged-in user's row (id, name, email, role) as an array,
 * or null if nobody is logged in. Cached for the duration of the request.
 */
function current_user() {
    static $user = null;
    if ($user !== null) return $user;
    if (empty($_SESSION['user_id'])) return null;

    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT id, name, email, role, created_at FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    return $user ?: null;
}

/**
 * Attempts to log a user in. Returns true on success, or a string error
 * message on failure.
 */
function attempt_login($email, $password, $expected_role) {
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([trim($email)]);
    $row = $stmt->fetch();

    if (!$row || !password_verify($password, $row['password_hash'])) {
        return 'Incorrect email or password.';
    }
    if ($row['role'] !== $expected_role) {
        return 'This account is not registered as a ' . $expected_role . '.';
    }

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['name'] = $row['name'];
    return true;
}

/**
 * Creates a new user account. Returns true on success, or a string error
 * message on failure.
 */
function attempt_signup($name, $email, $password, $confirm_password, $role) {
    $name = trim($name);
    $email = trim($email);

    if ($name === '' || $email === '' || $password === '') {
        return 'Please fill in all required fields.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Please enter a valid email address.';
    }
    if (strlen($password) < 8) {
        return 'Password must be at least 8 characters long.';
    }
    if ($password !== $confirm_password) {
        return 'Passwords do not match.';
    }

    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return 'An account with that email already exists.';
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, NOW())');
    $stmt->execute([$name, $email, $hash, $role]);

    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['role'] = $role;
    $_SESSION['name'] = $name;
    return true;
}

function logout_user() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
