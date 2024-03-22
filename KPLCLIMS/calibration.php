<?php
// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection
// For example:


// Add or Edit form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Process add form data and insert into database
        $serialnumber = $_POST['serial_number'];
        $calibrationDate = $_POST['calibration_date'];
        $calibrationTechnician = $_POST['calibration_technician'];
        $calibrationStandardUsed = $_POST['calibration_standard_used'];
        $beforeCalibrationReadings = $_POST['before_calibration_readings'];
        $afterCalibrationReadings = $_POST['after_calibration_readings'];
        $calibrationResult = $_POST['calibration_result'];
        $comments = $_POST['comments'];

        $insertSql = "INSERT INTO CalibrationResults (serial_number, calibration_date, calibration_technician, calibration_standard_used, before_calibration_readings, after_calibration_readings, calibration_result, comments) 
                      VALUES ('$serialnumber', '$calibrationDate', '$calibrationTechnician', '$calibrationStandardUsed', '$beforeCalibrationReadings', '$afterCalibrationReadings', '$calibrationResult', '$comments')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Record added successfully!";
        } else {
            echo "Error adding record: " ;
        }
    } elseif (isset($_POST['edit'])) {
        // Process edit form data and update database
        $serialnumber = $_POST['edit_serial_number'];
        $calibrationDate = $_POST['edit_calibration_date'];
        $calibrationTechnician = $_POST['edit_calibration_technician'];
        $calibrationStandardUsed = $_POST['edit_calibration_standard_used'];
        $beforeCalibrationReadings = $_POST['edit_before_calibration_readings'];
        $afterCalibrationReadings = $_POST['edit_after_calibration_readings'];
        $calibrationResult = $_POST['edit_calibration_result'];
        $comments = $_POST['edit_comments'];

        $updateSql = "UPDATE CalibrationResults 
                      SET serial_number='$serialnumber', calibration_date='$calibrationDate', calibration_technician='$calibrationTechnician', 
                          calibration_standard_used='$calibrationStandardUsed', before_calibration_readings='$beforeCalibrationReadings', 
                          after_calibration_readings='$afterCalibrationReadings', calibration_result='$calibrationResult', comments='$comments'
                      WHERE serial_number=$serialnumber";

        if ($conn->query($updateSql) === TRUE) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " ;
        }
    } elseif (isset($_POST['delete'])) {
        // Process delete action and remove record from the database
        $id = $_POST['delete_id'];

        $deleteSql = "DELETE FROM CalibrationResults WHERE serial_number=$serialnumber";

        if ($conn->query($deleteSql) === TRUE) {
            echo "Record deleted successfully!";
        } else {
            echo "Error deleting record: " ;
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
    <style>
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
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #00aaff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0077cc;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .edit-form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .edit-form input[type="text"],
        .edit-form input[type="date"],
        .edit-form select,
        .edit-form textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .edit-form button[type="submit"] {
            background-color: #00aaff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-form button[type="submit"]:hover {
            background-color: #0077cc;
        }
    </style>
</head>
<body>

<h2>Calibration Results</h2>

<!-- Display add form -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="serial_number">Serial Number:</label>
    <input type="text" name="serial_number" required>
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
        <th>Serial_Number</th>
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
                <td>{$row['serial_number']}</td>
                <td>{$row['calibration_date']}</td>
                <td>{$row['calibration_technician']}</td>
                <td>{$row['calibration_standard_used']}</td>
                <td>{$row['before_calibration_readings']}</td>
                <td>{$row['after_calibration_readings']}</td>
                <td>{$row['calibration_result']}</td>
                <td>{$row['comments']}</td>
                <td>
                    <form method='post' action='{$_SERVER['PHP_SELF']}'>
                                               <button type='submit' name='edit'>Edit</button>
                    </form>
                    <form method='post' action='{$_SERVER['PHP_SELF']}'>
                        <input type='hidden' name='delete_serial_number' value='{$row['serial_number']}'>
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
    $edit_serial_number = $_POST['edit_serial_number'];
    $edit_sql = "SELECT * FROM CalibrationResults WHERE serial_number=$edit_serial_number";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
        ?>
         <h3>Edit Record</h3>
        <form class="edit-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="edit_serial_number">Serial Number:</label>
            <input type="text" name="edit_serial_number" value="<?php echo $edit_row['meter_id']; ?>" required>
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
