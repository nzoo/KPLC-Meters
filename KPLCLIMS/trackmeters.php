<?php
// Include the config.php file
require_once('config.php');

// Add or Edit form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Process add form data and insert into database
        $meterId = $_POST['meter_id'];
        $calibrationDate = $_POST['calibration_date'];
        $calibrationTechnician = $_POST['calibration_technician'];
        $calibrationStandardUsed = $_POST['calibration_standard_used'];
        $beforeCalibrationReadings = $_POST['before_calibration_readings'];
        $afterCalibrationReadings = $_POST['after_calibration_readings'];
        $calibrationResult = $_POST['calibration_result'];
        $comments = $_POST['comments'];

        $insertSql = "INSERT INTO CalibrationResults (meter_id, calibration_date, calibration_technician, calibration_standard_used, before_calibration_readings, after_calibration_readings, calibration_result, comments) 
                      VALUES ('$meterId', '$calibrationDate', '$calibrationTechnician', '$calibrationStandardUsed', '$beforeCalibrationReadings', '$afterCalibrationReadings', '$calibrationResult', '$comments')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Record added successfully!";
        } else {
            echo "Error adding record: " . $conn->error;
        }
    } elseif (isset($_POST['edit'])) {
        // Process edit form data and update database
        $id = $_POST['edit_id'];
        $meterId = $_POST['edit_meter_id'];
        $calibrationDate = $_POST['edit_calibration_date'];
        $calibrationTechnician = $_POST['edit_calibration_technician'];
        $calibrationStandardUsed = $_POST['edit_calibration_standard_used'];
        $beforeCalibrationReadings = $_POST['edit_before_calibration_readings'];
        $afterCalibrationReadings = $_POST['edit_after_calibration_readings'];
        $calibrationResult = $_POST['edit_calibration_result'];
        $comments = $_POST['edit_comments'];

        $updateSql = "UPDATE CalibrationResults 
                      SET meter_id='$meterId', calibration_date='$calibrationDate', calibration_technician='$calibrationTechnician', 
                          calibration_standard_used='$calibrationStandardUsed', before_calibration_readings='$beforeCalibrationReadings', 
                          after_calibration_readings='$afterCalibrationReadings', calibration_result='$calibrationResult', comments='$comments'
                      WHERE id=$id";

        if ($conn->query($updateSql) === TRUE) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Process delete action and remove record from the database
        $id = $_POST['delete_id'];

        $deleteSql = "DELETE FROM CalibrationResults WHERE id=$id";

        if ($conn->query($deleteSql) === TRUE) {
            echo "Record deleted successfully!";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Fetch data from CalibrationResults table
$sql = "SELECT * FROM CalibrationResults";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calibration Results</title>
</head>
<body>

<h2>Calibration Results</h2>

<!-- Display add form -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="meter_id">Meter ID:</label>
    <input type="text" name="meter_id" required>
    <label for="calibration_date">Calibration Date:</label>
    <input type="date" name="calibration_date" required>
    <label for="calibration_technician">Calibration Technician:</label>
    <input type="text" name="calibration_technician" required>
    <label for="calibration_standard_used">Calibration Standard Used:</label>
    <input type="text" name="calibration_standard_used" required>
    <label for="before_calibration_readings">Before Calibration Readings:</label>
    <input type="text" name="before_calibration_readings" required>
    <label for="after_calibration_readings">After Calibration Readings:</label>
    <input type="text" name="after_calibration_readings" required>
    <label for="calibration_result">Calibration Result:</label>
    <select name="calibration_result" required>
        <option value="Pass">Pass</option>
        <option value="Fail">Fail</option>
    </select>
    <label for="comments">Comments:</label>
    <textarea name="comments"></textarea>
    <button type="submit" name="add">Add Record</button>
</form>

<!-- Display data in a table -->
<table border='1'>
    <tr>
        <th>ID</th>
        <th>Meter ID</th>
        <th>Calibration Date</th>
        <th>Calibration Technician</th>
        <th>Calibration Standard Used</th>
        <th>Before Calibration Readings</th>
        <th>After Calibration Readings</th>
        <th>Calibration Result</th>
        <th>Comments</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['meter_id']}</td>
                <td>{$row['calibration_date']}</td>
                <td>{$row['calibration_technician']}</td>
                <td>{$row['calibration_standard_used']}</td>
                <td>{$row['before_calibration_readings']}</td>
                <td>{$row['after_calibration_readings']}</td>
                <td>{$row['calibration_result']}</td>
                <td>{$row['comments']}</td>
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
        echo "<tr><td colspan='10'>0 results</td></tr>";
    }
    ?>

</table>

<!-- Display edit form when edit button is clicked -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $edit_id = $_POST['edit_id'];
    $edit_sql = "SELECT * FROM CalibrationResults WHERE id=$edit_id";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
        ?>
         <h3>Edit Record</h3>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
            <label for="edit_meter_id">Meter ID:</label>
            <input type="text" name="edit_meter_id" value="<?php echo $edit_row['meter_id']; ?>" required>
            <label for="edit_calibration_date">Calibration Date:</label>
            <input type="date" name="edit_calibration_date" value="<?php echo $edit_row['calibration_date']; ?>" required>
            <label for="edit_calibration_technician">Calibration Technician:</label>
            <input type="text" name="edit_calibration_technician" value="<?php echo $edit_row['calibration_technician']; ?>" required>
            <label for="edit_calibration_standard_used">Calibration Standard Used:</label>
            <input type="text" name="edit_calibration_standard_used" value="<?php echo $edit_row['calibration_standard_used']; ?>" required>
            <label for="edit_before_calibration_readings">Before Calibration Readings:</label>
            <input type="text" name="edit_before_calibration_readings" value="<?php echo $edit_row['before_calibration_readings']; ?>" required>
            <label for="edit_after_calibration_readings">After Calibration Readings:</label>
            <input type="text" name="edit_after_calibration_readings" value="<?php echo $edit_row['after_calibration_readings']; ?>" required>
            <label for="edit_calibration_result">Calibration Result:</label>
            <select name="edit_calibration_result" required>
                <option value="Pass" <?php if ($edit_row['calibration_result'] == 'Pass') echo 'selected'; ?>>Pass</option>
                <option value="Fail" <?php if ($edit_row['calibration_result'] == 'Fail') echo 'selected'; ?>>Fail</option>
            </select>
            <label for="edit_comments">Comments:</label>
            <textarea name="edit_comments"><?php echo $edit_row['comments']; ?></textarea>
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
<?php

// Replace these values with your database connection details
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add or Edit form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Process add form data and insert into database
        $meterId = $_POST['meter_id'];
        $calibrationDate = $_POST['calibration_date'];
        $calibrationTechnician = $_POST['calibration_technician'];
        $calibrationStandardUsed = $_POST['calibration_standard_used'];
        $beforeCalibrationReadings = $_POST['before_calibration_readings'];
        $afterCalibrationReadings = $_POST['after_calibration_readings'];
        $calibrationResult = $_POST['calibration_result'];
        $comments = $_POST['comments'];

        $insertSql = "INSERT INTO CalibrationResults (meter_id, calibration_date, calibration_technician, calibration_standard_used, before_calibration_readings, after_calibration_readings, calibration_result, comments) 
                      VALUES ('$meterId', '$calibrationDate', '$calibrationTechnician', '$calibrationStandardUsed', '$beforeCalibrationReadings', '$afterCalibrationReadings', '$calibrationResult', '$comments')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Record added successfully!";
        } else {
            echo "Error adding record: " . $conn->error;
        }
    } elseif (isset($_POST['edit'])) {
        // Process edit form data and update database
        $id = $_POST['edit_id'];
        $meterId = $_POST['edit_meter_id'];
        $calibrationDate = $_POST['edit_calibration_date'];
        $calibrationTechnician = $_POST['edit_calibration_technician'];
        $calibrationStandardUsed = $_POST['edit_calibration_standard_used'];
        $beforeCalibrationReadings = $_POST['edit_before_calibration_readings'];
        $afterCalibrationReadings = $_POST['edit_after_calibration_readings'];
        $calibrationResult = $_POST['edit_calibration_result'];
        $comments = $_POST['edit_comments'];

        $updateSql = "UPDATE CalibrationResults 
                      SET meter_id='$meterId', calibration_date='$calibrationDate', calibration_technician='$calibrationTechnician', 
                          calibration_standard_used='$calibrationStandardUsed', before_calibration_readings='$beforeCalibrationReadings', 
                          after_calibration_readings='$afterCalibrationReadings', calibration_result='$calibrationResult', comments='$comments'
                      WHERE id=$id";

        if ($conn->query($updateSql) === TRUE) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Process delete action and remove record from the database
        $id = $_POST['delete_id'];

        $deleteSql = "DELETE FROM CalibrationResults WHERE id=$id";

        if ($conn->query($deleteSql) === TRUE) {
            echo "Record deleted successfully!";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Fetch data from CalibrationResults table
$sql = "SELECT * FROM CalibrationResults";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calibration Results</title>
</head>
<body>

<h2>Calibration Results</h2>

<!-- Display add form -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="meter_id">Meter ID:</label>
    <input type="text" name="meter_id" required>
    <label for="calibration_date">Calibration Date:</label>
    <input type="date" name="calibration_date" required>
    <label for="calibration_technician">Calibration Technician:</label>
    <input type="text" name="calibration_technician" required>
    <label for="calibration_standard_used">Calibration Standard Used:</label>
    <input type="text" name="calibration_standard_used" required>
    <label for="before_calibration_readings">Before Calibration Readings:</label>
    <input type="text" name="before_calibration_readings" required>
    <label for="after_calibration_readings">After Calibration Readings:</label>
    <input type="text" name="after_calibration_readings" required>
    <label for="calibration_result">Calibration Result:</label>
    <select name="calibration_result" required>
        <option value="Pass">Pass</option>
        <option value="Fail">Fail</option>
    </select>
    <label for="comments">Comments:</label>
    <textarea name="comments"></textarea>
    <button type="submit" name="add">Add Record</button>
</form>

<!-- Display data in a table -->
<table border='1'>
    <tr>
        <th>ID</th>
        <th>Meter ID</th>
        <th>Calibration Date</th>
        <th>Calibration Technician</th>
        <th>Calibration Standard Used</th>
        <th>Before Calibration Readings</th>
        <th>After Calibration Readings</th>
        <th>Calibration Result</th>
        <th>Comments</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['meter_id']}</td>
                <td>{$row['calibration_date']}</td>
                <td>{$row['calibration_technician']}</td>
                <td>{$row['calibration_standard_used']}</td>
                <td>{$row['before_calibration_readings']}</td>
                <td>{$row['after_calibration_readings']}</td>
                <td>{$row['calibration_result']}</td>
                <td>{$row['comments']}</td>
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
        echo "<tr><td colspan='10'>0 results</td></tr>";
    }
    ?>

</table>

<!-- Display edit form when edit button is clicked -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $edit_id = $_POST['edit_id'];
    $edit_sql = "SELECT * FROM CalibrationResults WHERE id=$edit_id";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
        ?>
         <h3>Edit Record</h3>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
            <label for="edit_meter_id">Meter ID:</label>
            <input type="text" name="edit_meter_id" value="<?php echo $edit_row['meter_id']; ?>" required>
            <label for="edit_calibration_date">Calibration Date:</label>
            <input type="date" name="edit_calibration_date" value="<?php echo $edit_row['calibration_date']; ?>" required>
            <label for="edit_calibration_technician">Calibration Technician:</label>
            <input type="text" name="edit_calibration_technician" value="<?php echo $edit_row['calibration_technician']; ?>" required>
            <label for="edit_calibration_standard_used">Calibration Standard Used:</label>
            <input type="text" name="edit_calibration_standard_used" value="<?php echo $edit_row['calibration_standard_used']; ?>" required>
            <label for="edit_before_calibration_readings">Before Calibration Readings:</label>
            <input type="text" name="edit_before_calibration_readings" value="<?php echo $edit_row['before_calibration_readings']; ?>" required>
            <label for="edit_after_calibration_readings">After Calibration Readings:</label>
            <input type="text" name="edit_after_calibration_readings" value="<?php echo $edit_row['after_calibration_readings']; ?>" required>
            <label for="edit_calibration_result">Calibration Result:</label>
            <select name="edit_calibration_result" required>
                <option value="Pass" <?php if ($edit_row['calibration_result'] == 'Pass') echo 'selected'; ?>>Pass</option>
                <option value="Fail" <?php if ($edit_row['calibration_result'] == 'Fail') echo 'selected'; ?>>Fail</option>
            </select>
            <label for="edit_comments">Comments:</label>
            <textarea name="edit_comments"><?php echo $edit_row['comments']; ?></textarea>
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
