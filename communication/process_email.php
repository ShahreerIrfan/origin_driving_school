<?php
include("../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $to = $_POST['to'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Driving School <noreply@drivingschool.com>" . "\r\n";

    // Send email (may require SMTP if running on localhost)
    $sent = mail($to, $subject, $message, $headers);

    if ($sent) {
        $stmt = $conn->prepare("INSERT INTO email_logs (recipient_email, subject, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $to, $subject, $message);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('✅ Email Sent Successfully!'); window.location.href='send_email.php';</script>";
    } else {
        echo "<script>alert('❌ Failed to send email.'); window.location.href='send_email.php';</script>";
    }
}
?>
