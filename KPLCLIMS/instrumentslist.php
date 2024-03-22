<?php
// Database connection
// Replace these values with your database connection details
// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection
// For example:
// Fetch all employees from the database
$sql = "SELECT * FROM instruments_list";
$result = $conn->query($sql);

//&& isset($_POST["add_instrument"]))
// Handle form submission for adding instrument
if ($_SERVER["REQUEST_METHOD"] == "POST")  {
    $SerialNumber = $_POST["SerialNumber"];
    $Name = $_POST["Name"];
    $Type = $_POST["Type"];
    $Manufacturer = $_POST["Manufacturer"];
    $Model = $_POST["Model"];
    $LastCalibrationDate = $_POST["LastCalibrationDate"];
    $CalibrationDueDate = $_POST["CalibrationDueDate"];
    $Status = $_POST["Status"];
    $Notes = $_POST["Notes"];
    // Prepare and execute SQL statement to insert instrument
    $insertSql = "INSERT INTO instruments_list(SerialNumber, Name, Type, Manufacturer, Model, LastCalibrationDate, CalibrationDueDate, Status, Notes)
     VALUES ('$SerialNumber', '$Name', '$Type', '$Manufacturer', '$Model', '$LastCalibrationDate', '$CalibrationDueDate', '$Status', '$Notes')";
   $stmt = $conn->prepare($insertSql);
   $stmt->bind_param($SerialNumber, $Name, $Type, $Manufacturer, $Model, $LastCalibrationDate, $CalibrationDueDate, $Status, $Notes);
   $stmt->execute();
  $stmt->close();
    if ($conn->query($insertSql) === TRUE) {
        echo "Record added successfully!";
        // Refresh the page to display the updated data
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error adding record: " . $conn->error;
    }
}

// Handle form submission for removing instrument
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    $SerialNumber = $_POST["SerialNumber"];

    // Prepare and execute SQL statement to delete employee
    $insertSql = "DELETE FROM instruments_list WHERE SerialNumber = '$SerialNumber' ";
   $stmt = $conn->prepare($sql);
    $stmt->bind_param( $SerialNumber, $Name, $Type, $Manufacturer, $Model, $LastCalibrationDate, $CalibrationDueDate, $Status, $Notes);
   $stmt->execute();
   $stmt->close();

    if ($conn->query($insertSql) === TRUE) {
        echo "Record added successfully!";
        // Refresh the page to display the updated data
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error adding record: " . $conn->error;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruments Management</title>
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
        }

        form {
            background-color: #00aaff;
            color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"], input[type="tel"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: none;
            border-radius: 3px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #00aaff;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h2>Instrument Management</h2>

    
    <!-- Form to add Instrument -->
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="SerialNumber">Serial Number:</label>
        <input type="text" id="SerialNumber" name="SerialNumber" required>

        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name" required>

        <label for="Type">Type:</label>
        <input type="text" id="Type" name="Type" required>

        <label for="Manufacturer">Manufacturer:</label>
        <input type="text" id="Manufacturer" name="Manufacturer" required>

        <label for="Model">Model:</label>
        <input type="text" id="Model" name="Model" required>

        <label for="LastCalibrationDate">Last Calibration Date:</label>
        <input type="date" id="LastCalibrationDate" name="LastCalibrationDate" required>

        <label for="CalibrationDueDate">Calibration Due Date:</label>
        <input type="date" id="CalibrationDueDate" name="CalibrationDueDate" required>

        <label for="Status">Status:</label>
        <input type="text" id="Status" name="Status" required>

        <label for="Notes">Notes:</label>
        <input type="text" id="Notes" name="Notes" required>

              <button type="submit">Add Record</button>
    </form>
    
    <!-- Form to remove Instrument -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="instrument_no_remove">Instrument Serial Number to Remove:</label>
        <input type="text" id="instrument_no_remove" name="SerialNumber" required>
        <button type="submit" name="remove_instrument">Remove Instrument</button>
    </form>

    <!-- Display table of Instrument -->
    <table>
        <tr>
            <th>Serial Number</th>
            <th>Name</th>
            <th>Model</th>
            <th>Type</th>
            <th>Manufacturer</th>
            <th>LastCalibration Date</th>
            <th>Calibration Due Date</th>
            <th>Status</th>
            <th>Notes</th>
        </tr>
    <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['SerialNumber']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['Type']}</td>
                        <td>{$row['Manufacturer']}</td>
                        <td>{$row['Model']}</td>
                        <td>{$row['LastCalibrationDate']}</td>
                        <td>{$row['CalibrationDueDate']}</td>
                        <td>{$row['Status']}</td>
                        <td>{$row['Notes']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No instrument found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
``