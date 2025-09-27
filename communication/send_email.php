<?php include(__DIR__ . "/../php/includes/config.php"); 
      include(__DIR__ . "/../php/includes/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Email - Driving School</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Send Email Notification</h2>
    <form action="process_email.php" method="POST">
        <label for="to">Recipient Email:</label>
        <input type="email" name="to" required>

        <label for="subject">Subject:</label>
        <input type="text" name="subject" required>

        <label for="message">Message:</label>
        <textarea name="message" rows="5" required></textarea>

        <button type="submit">Send Email</button>
    </form>

    <a href="view_logs.php" class="btn">View Sent Emails</a>
</div>
</body>
</html>
