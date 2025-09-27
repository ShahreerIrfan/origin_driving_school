<?php
session_start();
include("../includes/header.php");
include("../includes/config.php");

                         
$student_id = $_SESSION['user_id'] ?? 1;   
$message = "";

 
if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];

    $class = $conn->query("SELECT * FROM classes WHERE class_id = '$class_id'")->fetch_assoc();
    if ($class) {
        $instructor_id = $class['instructor_id'];
        $schedule_time = $class['date'];

  
        $sql = "INSERT INTO schedules (class_id, student_id, instructor_id, schedule_time) 
                VALUES ('$class_id', '$student_id', '$instructor_id', '$schedule_time')";
        if ($conn->query($sql)) {
            $message = "<div class='message success'>✅ Class booked successfully!</div>";
        } else {
            $message = "<div class='message error'>❌ Error: " . $conn->error . "</div>";
        }
    } else {
        $message = "<div class='message error'>❌ Class not found.</div>";
    }
}


$classes = $conn->query("SELECT c.*, i.name as instructor_name, f.vehicle_name 
                         FROM classes c 
                         JOIN instructors i ON c.instructor_id = i.instructor_id
                         LEFT JOIN fleet f ON c.vehicle_id = f.vehicle_id");

?>


<style>
#paymentModal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    display: none; 
    z-index: 9999;
}

#paymentModal .modal-content {
    text-align: center;
}

button {
    margin: 10px;
    padding: 10px 20px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
}

button:hover {
    background-color: #0056b3;
}
</style>

<div class="container">
    <h2>📖 Book a Class</h2>
    <?php if ($message) echo $message; ?>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Class Name</th>
            <th>Instructor</th>
            <th>Date</th>
            <th>Duration</th>
            <th>Location</th>
            <th>Vehicle</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $classes->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['class_name']; ?></td>
            <td><?= $row['instructor_name']; ?></td>
            <td><?= $row['date']; ?></td>
            <td><?= $row['duration']; ?></td>
            <td><?= $row['location']; ?></td>
            <td><?= $row['vehicle_name']; ?></td>
            <td>
                <?php
                
                $check_booking = $conn->query("SELECT * FROM schedules WHERE student_id = '$student_id' AND class_id = '".$row['class_id']."'");
                if ($check_booking && $check_booking->num_rows > 0) {
                    echo "<span class='message success'>✅ Already Booked</span>";
                } else {
                    echo "
                        <button type='button' class='book-class-btn' data-class-id='".$row['class_id']."'>Book Class</button>
                    ";
                }
                ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<div id="paymentModal">
    <div class="modal-content">
        <h3>Payment</h3>
        <p><strong>Amount:</strong> $50 (Fake Payment)</p>
        <p><strong>Card Number:</strong> 1234 5678 9012 3456</p>
        <p><strong>Expiry Date:</strong> 12/25</p>
        <form method="POST" action="">
            <input type="hidden" name="class_id" id="class_id_input">
            <button type="submit" id="payNowBtn">Pay Now</button>
            <button type="button" id="cancelBtn">Cancel</button>
        </form>
    </div>
</div>

<?php include("../includes/footer.php"); ?>


<script>

document.querySelectorAll('.book-class-btn').forEach(button => {
    button.addEventListener('click', function() {
        let classId = this.getAttribute('data-class-id');
        

        document.getElementById('paymentModal').style.display = 'block';
        
  
        document.getElementById('class_id_input').value = classId;
    });
});


document.getElementById('cancelBtn').addEventListener('click', function() {
    document.getElementById('paymentModal').style.display = 'none';
});
</script>
