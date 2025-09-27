<?php
// Read the POST data
$data = json_decode(file_get_contents('php://input'), true);
$class_id = $data['class_id'] ?? null;

if ($class_id) {
    // Simulate payment processing
    // Update payment status to 'Paid' for the class
    include("../includes/config.php");
    $student_id = $_SESSION['user_id'];  // Get the logged-in student ID

    // Update invoice status to "Paid"
    $sql = "UPDATE invoices SET payment_status = 'Paid' WHERE student_id = '$student_id' AND class_id = '$class_id' AND payment_status = 'Pending'";
    if ($conn->query($sql)) {
        echo json_encode(['message' => '✅ Payment successful! You can now book your class.']);
    } else {
        echo json_encode(['message' => '❌ Payment failed. Please try again later.']);
    }
} else {
    echo json_encode(['message' => '❌ Invalid class ID.']);
}
?>
