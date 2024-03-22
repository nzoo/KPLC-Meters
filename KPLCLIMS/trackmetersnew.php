<?php
// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection

// Fetch data from SampledEnergyMeters table
$sql = "SELECT * FROM SampledEnergyMeters";
$result = $conn->query($sql);

// Add data to SampledEnergyMeters table

if ($_SERVER["REQUEST_METHOD"] == "POST") if (isset($_POST['add'])){
    $meter_id = $_POST['serial_number'];
    $sampling_date = $_POST['sampling_date'];
    $test_parameters = $_POST['test_parameters'];
    $results = $_POST['results'];
    $comments = $_POST['comments'];

    $insertSql = "INSERT INTO SampledEnergyMeters (serial_number, sampling_date, test_parameters, results, comments) 
                  VALUES ('$serial_number', '$sampling_date', '$test_parameters', '$results', '$comments')";

    if ($conn->query($insertSql) === TRUE) {
        echo '<div style="color:green;">Record added successfully!</div>';
    } else {
        echo '<div style="color:red;">Error adding record: ' . $conn->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sampled Energy Meters</title>
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

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Sampled Energy Meters</h2>
    <!-- Form to add new data -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="serial_number">Serial Number:</label>
        <input type="text" name="meter_id" required>
        <label for="sampling_date">Sampling Date:</label>
        <input type="date" name="sampling_date" required>
        <label for="test_parameters">Test Parameters:</label>
        <input type="text" name="test_parameters" required>
        <label for="results">Results:</label>
        <input type="text" name="results" required>
        <label for="comments">Comments:</label>
        <textarea name="comments"></textarea>
        <input type="submit" value="Add Record">
    </form>

    <!-- Display data in a table -->
    <table>
        <tr>
            
            <th>Serial Number</th>
            <th>Sampling Date</th>
            <th>Test Parameters</th>
            <th>Results</th>
            <th>Comments</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        
                        <td>{$row['serial_number']}</td>
                        <td>{$row['sampling_date']}</td>
                        <td>{$row['test_parameters']}</td>
                        <td>{$row['results']}</td>
                        <td>{$row['comments']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data available</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
