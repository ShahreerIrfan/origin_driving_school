<?php
include("../includes/config.php");

if (isset($_GET['invoice_id']) && isset($_GET['student_id']) && isset($_GET['amount'])) {
    $invoice_id = $_GET['invoice_id'];
    $student_id = $_GET['student_id'];
    $amount = $_GET['amount'];
    $date = date("Y-m-d H:i:s");

   
    $sql1 = "INSERT INTO payments (student_id, amount, payment_date, payment_status)
             VALUES ('$student_id', '$amount', '$date', 'Paid')";
    mysqli_query($conn, $sql1);

 
    $sql2 = "UPDATE invoices SET status='Paid' WHERE invoice_id='$invoice_id'";
    mysqli_query($conn, $sql2);

    echo "<script>alert('✅ Payment successful!'); window.location.href='manage_invoices.php';</script>";
}
?>
