<?php
include("../includes/header.php");
include("../includes/config.php");
include("../includes/sidebar.php");

// ADD Student
if (isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $license_status = $_POST['license_status'];
    $progress = $_POST['progress'];

    $sql = "INSERT INTO students (name, email, phone, license_status, progress) 
            VALUES ('$name', '$email', '$phone', '$license_status', '$progress')";
    mysqli_query($conn, $sql);
    header("Location: manage_students.php");
    exit();
}

// DELETE Student
if (isset($_GET['delete'])) {
    $student_id = $_GET['delete'];
    $sql = "DELETE FROM students WHERE student_id=$student_id";
    mysqli_query($conn, $sql);
    header("Location: manage_students.php");
    exit();
}

// UPDATE Student
if (isset($_POST['update_student'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $license_status = $_POST['license_status'];
    $progress = $_POST['progress'];

    $sql = "UPDATE students 
            SET name='$name', email='$email', phone='$phone', license_status='$license_status', progress='$progress' 
            WHERE student_id=$student_id";
    mysqli_query($conn, $sql);
    header("Location: manage_students.php");
    exit();
}

// READ
$result = mysqli_query($conn, "SELECT * FROM students ORDER BY registration_date DESC");
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/students/manage_students.css">

<div class="container">
    <h2>🎓 Manage Students</h2>

    <!-- Add Student Form -->
    <form method="POST" class="add-form">
        <div class="form-group">
            <label>Name:</label>
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
            <label>License Status:</label>
            <select name="license_status">
                <option value="pending">Pending</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="form-group">
            <label>Progress:</label>
            <textarea name="progress" rows="3"></textarea>
        </div>
        <button type="submit" name="add_student">➕ Add Student</button>
    </form>

    <!-- Student List -->
    <h3>📋 Student List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>License Status</th>
            <th>Progress</th>
            <th>Registered</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['student_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td>
                <?php if ($row['license_status'] == 'completed'): ?>
                    <span class="badge badge-active">Completed</span>
                <?php elseif ($row['license_status'] == 'in-progress'): ?>
                    <span class="badge badge-warning">In Progress</span>
                <?php else: ?>
                    <span class="badge badge-inactive">Pending</span>
                <?php endif; ?>
            </td>
            <td><?= $row['progress'] ?></td>
            <td><?= date("d M Y", strtotime($row['registration_date'])) ?></td>
            <td class="actions">
                <!-- Edit -->
                <i class="fa-solid fa-pen-to-square edit-btn"
                   onclick="openModal(
                        '<?= $row['student_id'] ?>',
                        '<?= htmlspecialchars($row['name']) ?>',
                        '<?= htmlspecialchars($row['email']) ?>',
                        '<?= htmlspecialchars($row['phone']) ?>',
                        '<?= $row['license_status'] ?>',
                        '<?= htmlspecialchars($row['progress']) ?>'
                   )"></i>
                <!-- Delete -->
                <a href="?delete=<?= $row['student_id'] ?>" onclick="return confirm('Delete this student?')">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Update Modal -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>✏️ Update Student</h2>
        <form method="POST">
            <input type="hidden" name="student_id" id="studentId">
            <label>Name:</label>
            <input type="text" name="name" id="studentName" required>
            <label>Email:</label>
            <input type="email" name="email" id="studentEmail" required>
            <label>Phone:</label>
            <input type="text" name="phone" id="studentPhone" required>
            <label>License Status:</label>
            <select name="license_status" id="studentLicense">
                <option value="pending">Pending</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            <label>Progress:</label>
            <textarea name="progress" id="studentProgress" rows="3"></textarea>
            <button type="submit" name="update_student">💾 Save Changes</button>
        </form>
    </div>
</div>

<script>
function openModal(id, name, email, phone, license, progress) {
    document.getElementById("updateModal").style.display = "flex";
    document.getElementById("studentId").value = id;
    document.getElementById("studentName").value = name;
    document.getElementById("studentEmail").value = email;
    document.getElementById("studentPhone").value = phone;
    document.getElementById("studentLicense").value = license;
    document.getElementById("studentProgress").value = progress;
}
function closeModal() {
    document.getElementById("updateModal").style.display = "none";
}
</script>

<?php include("../includes/footer.php"); ?>
