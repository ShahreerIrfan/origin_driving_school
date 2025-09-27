<?php include("../includes/header.php"); ?>
<?php
include("../includes/config.php");

// Initialize variables
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $checkEmail = "SELECT * FROM staff WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $message = "<div class='message error'>❌ Email already registered!</div>";
    } else {
        $sql = "INSERT INTO staff (name, email, phone, role, password) 
                VALUES ('$name', '$email', '$phone', '$role', '$password')";
        if (mysqli_query($conn, $sql)) {

            // Insert into extra table based on role
            if ($role == "student") {
                $student_sql = "INSERT INTO students (name, email, phone, license_status) 
                                VALUES ('$name', '$email', '$phone', 'learner')";
                mysqli_query($conn, $student_sql);
            }
            if ($role == "instructor") {
                $instructor_sql = "INSERT INTO instructors (name, email, phone, qualification, status) 
                                   VALUES ('$name', '$email', '$phone', 'Not Set', 'active')";
                mysqli_query($conn, $instructor_sql);
            }

            $message = "<div class='message success'>✅ Registration successful! You can now <a href='login.php'>Login</a></div>";
        } else {
            $message = "<div class='message error'>❌ Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<link rel="stylesheet" href="../../assets/css/register/register.css">

<div class="register-container">
    <h2>🚗 Driving School - Register</h2>

    <?php if ($message != "") echo $message; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" required>
        </div>

        <div class="form-group">
            <label>Role:</label>
            <select name="role" required>
                <option value="student">Student</option>
                <option value="instructor">Instructor</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Register</button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
