<?php
// Database connection
// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection

// Fetch data from QualityControl table
$sql = "SELECT * FROM QualityControl";
$result = $conn->query($sql);

// Add record form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serial_number = $_POST['serial_number'];
    $test_date = $_POST['test_date'];
    $test_parameters = $_POST['test_parameters'];
    $results = $_POST['results'];
    $acceptance_criteria = $_POST['acceptance_criteria'];
    $technician_id = $_POST['technician_id'];

    $insertSql = "INSERT INTO QualityControl (serial_number, test_date, test_parameters, results, acceptance_criteria,technician_id) 
                  VALUES ('$serial_number', '$test_date', '$test_parameters', '$results', '$acceptance_criteria', '$technician_id')";

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
    <title>Quality Control</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .form-container {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            width: 50%;
        }

        .form-container input, .form-container select {
            width: calc(100% - 20px);
            margin-bottom: 10px;
        }

        .form-container button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Quality Control</h2>
    <table>
        <tr>
            <th>Serial Number</th>
            <th>Test Date</th>
            <th>Test Parameters</th>
            <th>Results</th>
            <th>Acceptance Criteria</th>
            <th>Technician</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['serial_number']}</td>
                        <td>{$row['test_date']}</td>
                        <td>{$row['test_parameters']}</td>
                        <td>{$row['results']}</td>
                        <td>{$row['acceptance_criteria']}</td>
                        <td>{$row['technician_id']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data available</td></tr>";
        }
        ?>
    </table>

    <div class="form-container">
        <h2>Add Record</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="serial_number">Serial Number:</label>
            <input type="text" name="serial_number" required>
            <label for="test_date">Test Date:</label>
            <input type="date" name="test_date" required>
            <label for="test_parameters">Test Parameters:</label>
            <input type="text" name="test_parameters" required>
            <label for="results">Results:</label>
            <input type="text" name="results" required>
            <label for="acceptance_criteria">Acceptance Criteria:</label>
            <input type="text" name="acceptance_criteria" required>
            <label for="technician_id">Technician:</label>
            <input type="text" name="technician_id" required>
            <button type="submit">Add Record</button>
        </form>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
