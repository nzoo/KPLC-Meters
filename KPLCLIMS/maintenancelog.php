<?php
// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection
// For example:
// Add or Edit form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Process add form data and insert into database
        $meterId = $_POST['serial_number'];
        $maintenanceDate = $_POST['maintenance_date'];
        $maintenanceTechnician = $_POST['maintenance_technician'];
        $description = $_POST['description'];
        $partsReplaced = $_POST['parts_replaced'];
        $calibrationStatusAfterMaintenance = $_POST['calibration_status_after_maintenance'];

        $insertSql = "INSERT INTO MaintenanceLog (serial_number, maintenance_date, maintenance_technician, description, parts_replaced, calibration_status_after_maintenance) 
                      VALUES ('$serial_number', '$maintenanceDate', '$maintenanceTechnician', '$description', '$partsReplaced', '$calibrationStatusAfterMaintenance')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Record added successfully!";
        } else {
            echo "Error adding record: " . $conn->error;
        }
    } elseif (isset($_POST['edit'])) {
        // Process edit form data and update database
        $id = $_POST['edit_id'];
        $serialnumber = $_POST['edit_serial_number'];
        $maintenanceDate = $_POST['edit_maintenance_date'];
        $maintenanceTechnician = $_POST['edit_maintenance_technician'];
        $description = $_POST['edit_description'];
        $partsReplaced = $_POST['edit_parts_replaced'];
        $calibrationStatusAfterMaintenance = $_POST['edit_calibration_status_after_maintenance'];

        $updateSql = "UPDATE MaintenanceLog 
                      SET serial_number='$serialnumber', maintenance_date='$maintenanceDate', maintenance_technician='$maintenanceTechnician', 
                          description='$description', parts_replaced='$partsReplaced', calibration_status_after_maintenance='$calibrationStatusAfterMaintenance'
                      WHERE id=$id";

        if ($conn->query($updateSql) === TRUE) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Process delete action and remove record from the database
        $id = $_POST['delete_id'];

        $deleteSql = "DELETE FROM MaintenanceLog WHERE id=$id";

        if ($conn->query($deleteSql) === TRUE) {
            echo "Record deleted successfully!";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Fetch data from MaintenanceLog table
$sql = "SELECT * FROM MaintenanceLog";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Log</title>
    <!-- Add CSS styles here -->
    <style>
        /* Add your CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        h2 {
            color: #333;
            background-color: #ffcc00;
            padding: 10px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        button {
            background-color: #ffcc00;
            color: #333;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #ffdd33;
        }
        form {
            display: inline;
        }
    </style>
</head>
<body>

<h2>Maintenance Log</h2>

<!-- Display add form -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="text-align: center;">
    <label for="serial_number">Serial Number:</label>
    <input type="number" name="serial_number" required>
    <label for="maintenance_date">Maintenance Date:</label>
    <input type="date" name="maintenance_date" required>
    <label for="maintenance_technician">Maintenance Technician:</label>
    <input type="text" name="maintenance_technician" required>
    <label for="description">Description:</label>
    <textarea name="description" required></textarea>
    <label for="parts_replaced">Parts Replaced:</label>
    <input type="text" name="parts_replaced" required>
    <label for="calibration_status_after_maintenance">Calibration Status After Maintenance:</label>
    <input type="text" name="calibration_status_after_maintenance" required>
    <button type="submit" name="add">Add Record</button>
</form>

<!-- Display data in a table -->
<table>
    <tr>
        <th>ID</th>
        <th>Serial Number</th>
        <th>Maintenance Date</th>
        <th>Maintenance Technician</th>
        <th>Description</th>
        <th>Parts Replaced</th>
        <th>Calibration Status After Maintenance</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                
                <td>{$row['serial_number']}</td>
                <td>{$row['maintenance_date']}</td>
                <td>{$row['maintenance_technician']}</td>
                <td>{$row['description']}</td>
                <td>{$row['parts_replaced']}</td>
                <td>{$row['calibration_status_after_maintenance']}</td>
                <td>
                    <form method='post' action='{$_SERVER['PHP_SELF']}' style='display:inline;'>
                        <input type='hidden' name='edit_id' value='{$row['serial_number']}'>
                        <button type='submit' name='edit'>Edit</button>
                    </form>
                    <form method='post' action='{$_SERVER['PHP_SELF']}' style='display:inline;'>
                        <input type='hidden' name='delete_id' value='{$row['serial_number']}'>
                        <button type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='

8'>0 results</td></tr>";
    }
    ?>

</table>

<!-- Display edit form when edit button is clicked -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $edit_id = $_POST['edit_id'];
    $edit_sql = "SELECT * FROM MaintenanceLog WHERE id=$edit_id";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
        ?>
         <h3>Edit Record</h3>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="text-align: center;">
            <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
            <label for="edit_serial_number">Serial Number:</label>
            <input type="number" name="edit_serial_number" value="<?php echo $edit_row['meter_id']; ?>" required>
            <label for="edit_maintenance_date">Maintenance Date:</label>
            <input type="date" name="edit_maintenance_date" value="<?php echo $edit_row['maintenance_date']; ?>" required>
            <label for="edit_maintenance_technician">Maintenance Technician:</label>
            <input type="text" name="edit_maintenance_technician" value="<?php echo $edit_row['maintenance_technician']; ?>" required>
            <label for="edit_description">Description:</label>
            <textarea name="edit_description" required><?php echo $edit_row['description']; ?></textarea>
            <label for="edit_parts_replaced">Parts Replaced:</label>
            <input type="text" name="edit_parts_replaced" value="<?php echo $edit_row['parts_replaced']; ?>" required>
            <label for="edit_calibration_status_after_maintenance">Calibration Status After Maintenance:</label>
            <input type="text" name="edit_calibration_status_after_maintenance" value="<?php echo $edit_row['calibration_status_after_maintenance']; ?>" required>
            <button type="submit" name="edit">Update Record</button>
        </form>
    <?php
    } else {
        echo "Error: Record not found.";
    }
}
?>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
