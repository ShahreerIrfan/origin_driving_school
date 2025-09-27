<?php
include("../includes/header.php");
include("../includes/config.php");
include("../includes/sidebar.php");

// CREATE
if (isset($_POST['add_vehicle'])) {
    $vehicle_number = $_POST['vehicle_number'];
    $model = $_POST['model'];
    $status = $_POST['status'];
    $maintenance_due = $_POST['maintenance_due'];

    $sql = "INSERT INTO fleet (vehicle_number, model, status, maintenance_due) 
            VALUES ('$vehicle_number', '$model', '$status', '$maintenance_due')";
    mysqli_query($conn, $sql);
    header("Location: manage_vehicles.php");
    exit();
}

// DELETE
if (isset($_GET['delete'])) {
    $vehicle_id = $_GET['delete'];
    $sql = "DELETE FROM fleet WHERE vehicle_id=$vehicle_id";
    mysqli_query($conn, $sql);
    header("Location: manage_vehicles.php");
    exit();
}

// UPDATE
if (isset($_POST['update_vehicle'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $vehicle_number = $_POST['vehicle_number'];
    $model = $_POST['model'];
    $status = $_POST['status'];
    $maintenance_due = $_POST['maintenance_due'];

    $sql = "UPDATE fleet 
            SET vehicle_number='$vehicle_number', model='$model', status='$status', maintenance_due='$maintenance_due'
            WHERE vehicle_id=$vehicle_id";
    mysqli_query($conn, $sql);
    header("Location: manage_vehicles.php");
    exit();
}

// READ
$result = mysqli_query($conn, "SELECT * FROM fleet");
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/vehicles/manage_vehicles.css">

<div class="container">
    <h2>🚘 Manage Vehicles</h2>

    <!-- Add Vehicle Form -->
    <form method="POST" class="add-form">
        <div class="form-group">
            <label>Vehicle Number:</label>
            <input type="text" name="vehicle_number" required>
        </div>
        <div class="form-group">
            <label>Model:</label>
            <input type="text" name="model" required>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status">
                <option value="available">Available</option>
                <option value="in use">In Use</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>
        <div class="form-group">
            <label>Maintenance Due:</label>
            <input type="date" name="maintenance_due">
        </div>
        <button type="submit" name="add_vehicle">➕ Add Vehicle</button>
    </form>

    <!-- Vehicle List -->
    <h3>📋 Vehicle List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Number</th>
            <th>Model</th>
            <th>Status</th>
            <th>Maintenance Due</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['vehicle_id'] ?></td>
            <td><?= $row['vehicle_number'] ?></td>
            <td><?= $row['model'] ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td><?= $row['maintenance_due'] ?></td>
            <td class="actions">
                <!-- Edit -->
                <i class="fa-solid fa-pen-to-square edit-btn" 
                   onclick="openModal(
                        '<?= $row['vehicle_id'] ?>',
                        '<?= htmlspecialchars($row['vehicle_number']) ?>',
                        '<?= htmlspecialchars($row['model']) ?>',
                        '<?= $row['status'] ?>',
                        '<?= $row['maintenance_due'] ?>'
                   )"></i>
                <!-- Delete -->
                <a href="?delete=<?= $row['vehicle_id'] ?>" onclick="return confirm('Delete this vehicle?')">
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
        <h2>✏️ Update Vehicle</h2>
        <form method="POST">
            <input type="hidden" name="vehicle_id" id="vehicleId">
            <label>Vehicle Number:</label>
            <input type="text" name="vehicle_number" id="vehicleNumber" required>
            <label>Model:</label>
            <input type="text" name="model" id="vehicleModel" required>
            <label>Status:</label>
            <select name="status" id="vehicleStatus">
                <option value="available">Available</option>
                <option value="in use">In Use</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <label>Maintenance Due:</label>
            <input type="date" name="maintenance_due" id="vehicleDue">
            <button type="submit" name="update_vehicle">💾 Save Changes</button>
        </form>
    </div>
</div>

<script>
function openModal(id, number, model, status, due) {
    document.getElementById("updateModal").style.display = "flex";
    document.getElementById("vehicleId").value = id;
    document.getElementById("vehicleNumber").value = number;
    document.getElementById("vehicleModel").value = model;
    document.getElementById("vehicleStatus").value = status;
    document.getElementById("vehicleDue").value = due;
}
function closeModal() {
    document.getElementById("updateModal").style.display = "none";
}
</script>

<?php include("../includes/footer.php"); ?>
