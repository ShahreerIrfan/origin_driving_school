<?php
include("../includes/header.php");
include("../includes/config.php");
include("../includes/sidebar.php");

// ADD Branch
if (isset($_POST['add_branch'])) {
    $branch_name = mysqli_real_escape_string($conn, $_POST['branch_name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    $sql = "INSERT INTO branches (branch_name, location, contact_number) 
            VALUES ('$branch_name', '$location', '$contact_number')";
    mysqli_query($conn, $sql);
    header("Location: manage_branches.php");
    exit();
}

// DELETE Branch
if (isset($_GET['delete'])) {
    $branch_id = $_GET['delete'];
    $sql = "DELETE FROM branches WHERE branch_id=$branch_id";
    mysqli_query($conn, $sql);
    header("Location: manage_branches.php");
    exit();
}

// UPDATE Branch
if (isset($_POST['update_branch'])) {
    $branch_id = $_POST['branch_id'];
    $branch_name = mysqli_real_escape_string($conn, $_POST['branch_name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    $sql = "UPDATE branches 
            SET branch_name='$branch_name', location='$location', contact_number='$contact_number' 
            WHERE branch_id=$branch_id";
    mysqli_query($conn, $sql);
    header("Location: manage_branches.php");
    exit();
}

// READ
$result = mysqli_query($conn, "SELECT * FROM branches ORDER BY branch_id DESC");
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/branches/manage_branches.css">

<div class="container">
    <h2>🏢 Manage Branches</h2>

    <!-- Add Branch Form -->
    <form method="POST" class="add-form">
        <div class="form-group">
            <label>Branch Name:</label>
            <input type="text" name="branch_name" required>
        </div>
        <div class="form-group">
            <label>Location:</label>
            <input type="text" name="location" required>
        </div>
        <div class="form-group">
            <label>Contact Number:</label>
            <input type="text" name="contact_number" required>
        </div>
        <button type="submit" name="add_branch">➕ Add Branch</button>
    </form>

    <!-- Branch List -->
    <h3>📋 Branch List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Branch Name</th>
            <th>Location</th>
            <th>Contact Number</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['branch_id'] ?></td>
            <td><?= $row['branch_name'] ?></td>
            <td><?= $row['location'] ?></td>
            <td><?= $row['contact_number'] ?></td>
            <td class="actions">
                <!-- Edit -->
                <i class="fa-solid fa-pen-to-square edit-btn"
                   onclick="openModal(
                        '<?= $row['branch_id'] ?>',
                        '<?= htmlspecialchars($row['branch_name']) ?>',
                        '<?= htmlspecialchars($row['location']) ?>',
                        '<?= htmlspecialchars($row['contact_number']) ?>'
                   )"></i>
                <!-- Delete -->
                <a href="?delete=<?= $row['branch_id'] ?>" onclick="return confirm('Delete this branch?')">
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
        <h2>✏️ Update Branch</h2>
        <form method="POST">
            <input type="hidden" name="branch_id" id="branchId">
            <label>Branch Name:</label>
            <input type="text" name="branch_name" id="branchName" required>
            <label>Location:</label>
            <input type="text" name="location" id="branchLocation" required>
            <label>Contact Number:</label>
            <input type="text" name="contact_number" id="branchContact" required>
            <button type="submit" name="update_branch">💾 Save Changes</button>
        </form>
    </div>
</div>

<script>
function openModal(id, name, location, contact) {
    document.getElementById("updateModal").style.display = "flex";
    document.getElementById("branchId").value = id;
    document.getElementById("branchName").value = name;
    document.getElementById("branchLocation").value = location;
    document.getElementById("branchContact").value = contact;
}
function closeModal() {
    document.getElementById("updateModal").style.display = "none";
}
</script>

<?php include("../includes/footer.php"); ?>
