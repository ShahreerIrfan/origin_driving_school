<?php
session_start();
include("../includes/header.php");
include("../includes/config.php");
include("../includes/sidebar.php");

$message = "";

// CREATE
if (isset($_POST['add_class'])) {
    $class_name   = mysqli_real_escape_string($conn, $_POST['class_name']);
    $instructor_id = $_POST['instructor_id'];
    $date         = $_POST['date'];
    $duration     = $_POST['duration'];
    $location     = mysqli_real_escape_string($conn, $_POST['location']);
    $vehicle_id   = $_POST['vehicle_id'];

    // Prevent double booking
    $check = "SELECT * FROM classes 
              WHERE (instructor_id = '$instructor_id' OR vehicle_id = '$vehicle_id') 
              AND `date` = '$date'";
    $result = $conn->query($check);

    if ($result && $result->num_rows > 0) {
        $message = "<div class='message error'>❌ Instructor or vehicle already booked at this time.</div>";
    } else {
        $sql = "INSERT INTO classes (class_name, instructor_id, `date`, duration, location, vehicle_id)
                VALUES ('$class_name', '$instructor_id', '$date', '$duration', '$location', '$vehicle_id')";
        if ($conn->query($sql)) {
            $message = "<div class='message success'>✅ Class created successfully!</div>";
        } else {
            $message = "<div class='message error'>❌ Error: " . $conn->error . "</div>";
        }
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $class_id = $_GET['delete'];

    // Prevent deletion if the class is linked to any bookings in schedules
    $check_booking = $conn->query("SELECT * FROM schedules WHERE class_id = '$class_id'");

    if ($check_booking && $check_booking->num_rows > 0) {
        $message = "<div class='message error'>❌ You cannot delete this class as it has active bookings.</div>";
    } else {
        // If no bookings exist, proceed to delete
        $sql = "DELETE FROM classes WHERE class_id = $class_id";
        if ($conn->query($sql)) {
            header("Location: manage_classes.php");
            exit();
        } else {
            $message = "<div class='message error'>❌ Error deleting class: " . $conn->error . "</div>";
        }
    }
}

// UPDATE
if (isset($_POST['update_class'])) {
    $class_id = $_POST['class_id'];
    $class_name   = mysqli_real_escape_string($conn, $_POST['class_name']);
    $instructor_id = $_POST['instructor_id'];
    $date         = $_POST['date'];
    $duration     = $_POST['duration'];
    $location     = mysqli_real_escape_string($conn, $_POST['location']);
    $vehicle_id   = $_POST['vehicle_id'];

    $sql = "UPDATE classes 
            SET class_name='$class_name', instructor_id='$instructor_id', `date`='$date',
                duration='$duration', location='$location', vehicle_id='$vehicle_id'
            WHERE class_id=$class_id";
    mysqli_query($conn, $sql);
    header("Location: manage_classes.php");
    exit();
}

// READ
$classes = $conn->query("
    SELECT c.class_id, c.class_name, c.`date`, c.duration, c.location,
           c.instructor_id, c.vehicle_id,
           i.name AS instructor_name, f.vehicle_number, f.model
    FROM classes c
    JOIN instructors i ON c.instructor_id = i.instructor_id
    JOIN fleet f ON c.vehicle_id = f.vehicle_id
    ORDER BY c.`date` DESC
");
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="/driving_school/assets/css/classes/manage_classes.css">

<div class="container">
    <h2>📅 Manage Classes</h2>
    <?php if ($message) echo $message; ?>

    <!-- Add Class Form -->
    <form method="POST" class="add-form">
        <div class="form-group">
            <label>Class Name:</label>
            <input type="text" name="class_name" required>
        </div>
        <div class="form-group">
            <label>Instructor:</label>
            <select name="instructor_id" required>
                <option value="">-- Select Instructor --</option>
                <?php 
                $instResult = $conn->query("SELECT * FROM instructors");
                while ($row = $instResult->fetch_assoc()) { ?>
                    <option value="<?= $row['instructor_id']; ?>"><?= $row['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Date & Time:</label>
            <input type="datetime-local" name="date" required>
        </div>
        <div class="form-group">
            <label>Duration (HH:MM:SS):</label>
            <input type="time" name="duration" required>
        </div>
        <div class="form-group">
            <label>Location:</label>
            <input type="text" name="location" required>
        </div>
        <div class="form-group">
            <label>Vehicle:</label>
            <select name="vehicle_id" required>
                <option value="">-- Select Vehicle --</option>
                <?php 
                $vehResult = $conn->query("SELECT * FROM fleet");
                while ($row = $vehResult->fetch_assoc()) { ?>
                    <option value="<?= $row['vehicle_id']; ?>"><?= $row['vehicle_number']; ?> - <?= $row['model']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="add_class">➕ Create Class</button>
    </form>

    <!-- Class List -->
    <div class="list-section">
        <h3>📋 Class List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Class</th>
                <th>Instructor</th>
                <th>Date</th>
                <th>Duration</th>
                <th>Location</th>
                <th>Vehicle</th>
                <th>Actions</th>
            </tr>
            <?php if ($classes && $classes->num_rows > 0): ?>
                <?php while ($row = $classes->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['class_id'] ?></td>
                    <td><?= $row['class_name'] ?></td>
                    <td><?= $row['instructor_name'] ?></td>
                    <td><?= date("d M Y, H:i", strtotime($row['date'])) ?></td>
                    <td><?= $row['duration'] ?></td>
                    <td><?= $row['location'] ?></td>
                    <td><?= $row['vehicle_number'] ?> (<?= $row['model'] ?>)</td>
                    <td class="actions">
                        <!-- Edit -->
                        <i class="fa-solid fa-pen-to-square edit-btn"
                           onclick="openModal(
                                '<?= $row['class_id'] ?>',
                                '<?= htmlspecialchars($row['class_name']) ?>',
                                '<?= $row['instructor_id'] ?>',
                                '<?= $row['date'] ?>',
                                '<?= $row['duration'] ?>',
                                '<?= htmlspecialchars($row['location']) ?>',
                                '<?= $row['vehicle_id'] ?>'
                           )"></i>
                        <!-- Delete -->
                        <a href="?delete=<?= $row['class_id'] ?>" onclick="return confirm('Delete this class?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No classes found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<!-- Update Modal -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>✏️ Update Class</h2>
        <form method="POST" class="modal-form">
            <input type="hidden" name="class_id" id="classId">
            <div class="form-group">
                <label>Class Name:</label>
                <input type="text" name="class_name" id="className" required>
            </div>
            <div class="form-group">
                <label>Instructor:</label>
                <select name="instructor_id" id="classInstructor" required>
                    <?php 
                    $instResult = $conn->query("SELECT * FROM instructors");
                    while ($row = $instResult->fetch_assoc()) { ?>
                        <option value="<?= $row['instructor_id']; ?>"><?= $row['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Date & Time:</label>
                <input type="datetime-local" name="date" id="classDate" required>
            </div>
            <div class="form-group">
                <label>Duration (HH:MM:SS):</label>
                <input type="time" name="duration" id="classDuration" required>
            </div>
            <div class="form-group">
                <label>Location:</label>
                <input type="text" name="location" id="classLocation" required>
            </div>
            <div class="form-group">
                <label>Vehicle:</label>
                <select name="vehicle_id" id="classVehicle" required>
                    <?php 
                    $vehResult = $conn->query("SELECT * FROM fleet");
                    while ($row = $vehResult->fetch_assoc()) { ?>
                        <option value="<?= $row['vehicle_id']; ?>"><?= $row['vehicle_number']; ?> - <?= $row['model']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" name="update_class">💾 Save Changes</button>
        </form>
    </div>
</div>

<script>
function openModal(id, name, instructor, date, duration, location, vehicle) {
    document.getElementById("updateModal").style.display = "flex";
    document.getElementById("classId").value = id;
    document.getElementById("className").value = name;
    document.getElementById("classInstructor").value = instructor;
    document.getElementById("classDate").value = date.replace(" ", "T");
    document.getElementById("classDuration").value = duration;
    document.getElementById("classLocation").value = location;
    document.getElementById("classVehicle").value = vehicle;
}
function closeModal() {
    document.getElementById("updateModal").style.display = "none";
}
</script>

<?php include("../includes/footer.php"); ?>
