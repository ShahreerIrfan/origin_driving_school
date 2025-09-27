<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../includes/config.php"); // must be silent (no echo/whitespace)

// Helper: redirect with JS/meta fallback if headers already sent
function safe_redirect(string $url) {
    if (!headers_sent()) {
        header("Location: $url");
        exit;
    }
    echo '<script>window.location.href="'.htmlspecialchars($url, ENT_QUOTES).'";</script>';
    echo '<noscript><meta http-equiv="refresh" content="0;url='.$url.'"></noscript>';
    exit;
}

// If already logged in, route them out of the login page
if (!empty($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin')      safe_redirect('/driving_school/php/php_files/admin_dashboard.php');
    if ($_SESSION['role'] === 'instructor') safe_redirect('/driving_school/php/php_files/instructor_dashboard.php');
    if ($_SESSION['role'] === 'student')    safe_redirect('/driving_school/php/php_files/student_dashboard.php');
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Try staff (admin/instructor)
    $stmt = $conn->prepare("SELECT * FROM staff WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $staff_result = $stmt->get_result();

    if ($staff_result && $staff_result->num_rows === 1) {
        $user = $staff_result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['staff_id'];
            $_SESSION['role']    = $user['role'];

            if ($user['role'] === 'admin')      safe_redirect('/driving_school/php/php_files/admin_dashboard.php');
            if ($user['role'] === 'instructor') safe_redirect('/driving_school/php/php_files/instructor_dashboard.php');
            if ($user['role'] === 'student') safe_redirect('/driving_school/php/php_files/student_dashboard.php');

            // unknown staff role
            $error = "❌ Unknown staff role.";
        } else {
            $error = "❌ Invalid password!";
        }
    } else {
        // Try student
        $stmt2 = $conn->prepare("SELECT * FROM students WHERE email = ?");
        $stmt2->bind_param("s", $email);
        $stmt2->execute();
        $student_result = $stmt2->get_result();

        if ($student_result && $student_result->num_rows === 1) {
            $student = $student_result->fetch_assoc();
            if (password_verify($password, $student['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $student['student_id'];
                $_SESSION['role']    = 'student';

                // ✅ Auto-redirect student
                safe_redirect('/driving_school/php/php_files/student_dashboard.php');
            } else {
                $error = "❌ Invalid password!";
            }
        } else {
            $error = "❌ User not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="/driving_school/assets/css/login/login.css">
</head>
<body>
<?php include("../includes/header.php"); ?> <!-- include AFTER PHP logic -->
<div class="register-container">
    <h2>🔑 Login</h2>
    <?php if (!empty($error)) echo "<div class='message error'>$error</div>"; ?>
    <form method="POST" autocomplete="on">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required autofocus>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>