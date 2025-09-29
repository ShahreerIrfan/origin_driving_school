<?php
session_start();
require_once("../includes/config.php");
include("../includes/student_dashboard_sidebar.php");
include("../includes/header.php");

// Ensure only logged-in students can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$success = "";
$error = "";

// Fetch all instructors for dropdown
$instructors = [];
$sql = "SELECT instructor_id, name FROM instructors ORDER BY name";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $instructors[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id    = $_SESSION['user_id'];
    $instructor_id = intval($_POST['instructor_id']);
    $class_id      = !empty($_POST['class_id']) ? intval($_POST['class_id']) : null;
    $rating        = intval($_POST['rating']);
    $comments      = trim($_POST['comments']);

    if ($instructor_id && $rating >= 1 && $rating <= 5) {
        if ($class_id) {
            // Insert with class_id
            $stmt = $conn->prepare("INSERT INTO instructor_performance 
                (instructor_id, student_id, class_id, rating, comments) 
                VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiss", $instructor_id, $student_id, $class_id, $rating, $comments);
        } else {
            // Insert without class_id
            $stmt = $conn->prepare("INSERT INTO instructor_performance 
                (instructor_id, student_id, rating, comments) 
                VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $instructor_id, $student_id, $rating, $comments);
        }

        if ($stmt->execute()) {
            $success = "✅ Feedback submitted successfully!";
        } else {
            $error = "❌ Failed to submit feedback. Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "❌ Please select an instructor and give a valid rating.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instructor Evaluation</title>
    <link rel="stylesheet" href="../../assets/css/instructor_performance/instructor_performance.css">
</head>
<body>
<div class="feedback-container">
    <h2>Instructor Evaluation</h2>

    <?php if ($success): ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="feedback-form">
        <div class="form-group">
            <label for="instructor_id">Select Instructor:</label>
            <select name="instructor_id" id="instructor_id" required>
                <option value="">-- Choose Instructor --</option>
                <?php foreach ($instructors as $inst): ?>
                    <option value="<?php echo $inst['instructor_id']; ?>">
                        <?php echo htmlspecialchars($inst['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="rating">Rating (1–5):</label>
            <select name="rating" id="rating" required>
                <option value="">-- Select Rating --</option>
                <option value="1">⭐ 1 - Poor</option>
                <option value="2">⭐⭐ 2 - Fair</option>
                <option value="3">⭐⭐⭐ 3 - Good</option>
                <option value="4">⭐⭐⭐⭐ 4 - Very Good</option>
                <option value="5">⭐⭐⭐⭐⭐ 5 - Excellent</option>
            </select>
        </div>

        <div class="form-group">
            <label for="comments">Comments:</label>
            <textarea name="comments" id="comments" rows="4" placeholder="Write your feedback..."></textarea>
        </div>

        <button type="submit" class="btn-submit">Submit Feedback</button>
    </form>
</div>
</body>
</html>
