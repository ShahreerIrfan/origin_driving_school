<?php
include("../includes/header.php");
include("../includes/config.php");
include("../includes/sidebar.php");

// ADD Instructor
if (isset($_POST['add_instructor'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $qualification = $_POST['qualification'];
    $status = $_POST['status'];

    $sql = "INSERT INTO instructors (name, email, phone, qualification, status) 
            VALUES ('$name', '$email', '$phone', '$qualification', '$status')";
    mysqli_query($conn, $sql);
    header("Location: manage_instructors.php");
    exit();
}

// DELETE Instructor
if (isset($_GET['delete'])) {
    $instructor_id = $_GET['delete'];
    $sql = "DELETE FROM instructors WHERE instructor_id=$instructor_id";
    mysqli_query($conn, $sql);
    header("Location: manage_instructors.php");
    exit();
}

// UPDATE Instructor
if (isset($_POST['update_instructor'])) {
    $instructor_id = $_POST['instructor_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $qualification = $_POST['qualification'];
    $status = $_POST['status'];

    $sql = "UPDATE instructors 
            SET name='$name', email='$email', phone='$phone', qualification='$qualification', status='$status' 
            WHERE instructor_id=$instructor_id";
    mysqli_query($conn, $sql);
    header("Location: manage_instructors.php");
    exit();
}

// READ
$result = mysqli_query($conn, "SELECT * FROM instructors");
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/instructors/manage_instructors.css">

<div class="container">
    <h2>👨‍🏫 Manage Instructors</h2>

    <!-- Add Instructor Form -->
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
            <label>Qualification:</label>
            <input type="text" name="qualification" required>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <button type="submit" name="add_instructor">➕ Add Instructor</button>
    </form>

    <!-- Instructor List -->
    <h3>📋 Instructor List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Qualification</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['instructor_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['qualification'] ?></td>
            <td>
                <?php if ($row['status'] == 'active'): ?>
                    <span class="badge badge-active">Active</span>
                <?php else: ?>
                    <span class="badge badge-inactive">Inactive</span>
                <?php endif; ?>
            </td>
            <td class="actions">
                <!-- Edit -->
                <i class="fa-solid fa-pen-to-square edit-btn"
                   onclick="openModal(
                        '<?= $row['instructor_id'] ?>',
                        '<?= htmlspecialchars($row['name']) ?>',
                        '<?= htmlspecialchars($row['email']) ?>',
                        '<?= htmlspecialchars($row['phone']) ?>',
                        '<?= htmlspecialchars($row['qualification']) ?>',
                        '<?= $row['status'] ?>'
                   )"></i>
                <!-- Delete -->
                <a href="?delete=<?= $row['instructor_id'] ?>" onclick="return confirm('Delete this instructor?')">
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
        <h2>✏️ Update Instructor</h2>
        <form method="POST">
            <input type="hidden" name="instructor_id" id="instructorId">
            <label>Name:</label>
            <input type="text" name="name" id="instructorName" required>
            <label>Email:</label>
            <input type="email" name="email" id="instructorEmail" required>
            <label>Phone:</label>
            <input type="text" name="phone" id="instructorPhone" required>
            <label>Qualification:</label>
            <input type="text" name="qualification" id="instructorQualification" required>
            <label>Status:</label>
            <select name="status" id="instructorStatus">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <button type="submit" name="update_instructor">💾 Save Changes</button>
        </form>
    </div>
</div>

<script>
function openModal(id, name, email, phone, qualification, status) {
    document.getElementById("updateModal").style.display = "flex";
    document.getElementById("instructorId").value = id;
    document.getElementById("instructorName").value = name;
    document.getElementById("instructorEmail").value = email;
    document.getElementById("instructorPhone").value = phone;
    document.getElementById("instructorQualification").value = qualification;
    document.getElementById("instructorStatus").value = status;
}
function closeModal() {
    document.getElementById("updateModal").style.display = "none";
}
</script>

<?php include("../includes/footer.php"); ?>
