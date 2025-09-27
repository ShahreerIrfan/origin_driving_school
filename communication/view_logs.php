<?php
include("../includes/config.php");
$result = $conn->query("SELECT * FROM email_logs ORDER BY sent_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Logs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Sent Email Logs</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Recipient</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Sent At</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['recipient_email']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo $row['message']; ?></td>
            <td><?php echo $row['sent_at']; ?></td>
        </tr>
        <?php } ?>
    </table>
    <a href="send_email.php" class="btn">Back to Send Email</a>
</div>
</body>
</html>
