<?php

// Include the config.php file
require_once('config.php');

// Add or Edit form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Process add form data and insert into database
        $parameterName = $_POST['parameter_name'];
        $unit = $_POST['unit'];
        $toleranceLimits = $_POST['tolerance_limits'];
        $recommendedCalibrationFrequency = $_POST['recommended_calibration_frequency'];

        $insertSql = "INSERT INTO TestParameters (parameter_name, unit, tolerance_limits, recommended_calibration_frequency) 
                      VALUES ('$parameterName', '$unit', '$toleranceLimits', '$recommendedCalibrationFrequency')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Record added successfully!";
        } else {
            echo "Error adding record: " . $conn->error;
        }
    } elseif (isset($_POST['edit'])) {
        // Process edit form data and update database
        $id = $_POST['edit_id'];
        $parameterName = $_POST['edit_parameter_name'];
        $unit = $_POST['edit_unit'];
        $toleranceLimits = $_POST['edit_tolerance_limits'];
        $recommendedCalibrationFrequency = $_POST['edit_recommended_calibration_frequency'];

        $updateSql = "UPDATE TestParameters 
                      SET parameter_name='$parameterName', unit='$unit', tolerance_limits='$toleranceLimits', 
                          recommended_calibration_frequency='$recommendedCalibrationFrequency'
                      WHERE id=$id";

        if ($conn->query($updateSql) === TRUE) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Process delete action and remove record from the database
        $id = $_POST['delete_id'];

        $deleteSql = "DELETE FROM TestParameters WHERE id=$id";

        if ($conn->query($deleteSql) === TRUE) {
            echo "Record deleted successfully!";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Fetch data from TestParameters table
$sql = "SELECT * FROM TestParameters";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Parameters</title>
</head>
<body>

<h2>Test Parameters</h2>

<!-- Display add form -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="parameter_name">Parameter Name:</label>
    <input type="text" name="parameter_name" required>
    <label for="unit">Unit:</label>
    <input type="text" name="unit">
    <label for="tolerance_limits">Tolerance Limits:</label>
    <input type="text" name="tolerance_limits">
    <label for="recommended_calibration_frequency">Recommended Calibration Frequency:</label>
    <input type="number" name="recommended_calibration_frequency" min="1" required>
    <button type="submit" name="add">Add Record</button>
</form>

<!-- Display data in a table -->
<table border='1'>
    <tr>
        <th>ID</th>
        <th>Parameter Name</th>
        <th>Unit</th>
        <th>Tolerance Limits</th>
        <th>Recommended Calibration Frequency</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['parameter_name']}</td>
                <td>{$row['unit']}</td>
                <td>{$row['tolerance_limits']}</td>
                <td>{$row['recommended_calibration_frequency']}</td>
                <td>
                    <form method='post' action='{$_SERVER['PHP_SELF']}'>
                        <input type='hidden' name='edit_id' value='{$row['id']}'>
                        <button type='submit' name='edit'>Edit</button>
                    </form>
                    <form method='post' action='{$_SERVER['PHP_SELF']}'>
                        <input type='hidden' name='delete_id' value='{$row['id']}'>
                        <button type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>0 results</td></tr>";
    }
    ?>

</table>

<!-- Display edit form when edit button is clicked -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $edit_id = $_POST['edit_id'];
    $edit_sql = "SELECT * FROM TestParameters WHERE id=$edit_id";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
        ?>
         <h3>Edit Record</h3>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
            <label for="edit_parameter_name">Parameter Name:</label>
            <input type="text" name="edit_parameter_name" value="<?php echo $edit_row['parameter_name']; ?>" required>
            <label for="edit_unit">Unit:</label>
            <input type="text" name="edit_unit" value="<?php echo $edit_row['unit']; ?>">
            <label for="edit_tolerance_limits">Tolerance Limits:</label>
            <input type="text" name="edit_tolerance_limits" value="<?php echo $edit_row['tolerance_limits']; ?>">
            <label for="edit_recommended_calibration_frequency">Recommended Calibration Frequency:</label>
            <input type="number" name="edit_recommended_calibration_frequency" value="<?php echo $edit_row['recommended_calibration_frequency']; ?>" min="1" required>
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
