<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing and Calibration Schedule</title>
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
        
        input[type="text"], input[type="date"], select, textarea {
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
    </style>
</head>
<body>
    <h2>Testing and Calibration Schedule</h2>
    
    <!-- Form to add new record -->
    <form action="" method="post">
        <label for="meter_id">Meter ID:</label>
        <input type="text" id="meter_id" name="meter_id" required>
        
        <label for="calibration_date">Calibration Date:</label>
        <input type="date" id="calibration_date" name="calibration_date" required>
        
        <label for="calibration_technician">Calibration Technician:</label>
        <input type="text" id="calibration_technician" name="calibration_technician" required>
        
        <label for="calibration_standard_used">Calibration Standard Used:</label>
        <input type="text" id="calibration_standard_used" name="calibration_standard_used" required>
        
        <label for="before_calibration_readings">Before Calibration Readings:</label>
        <input type="text" id="before_calibration_readings" name="before_calibration_readings" required>
        
        <label for="after_calibration_readings">After Calibration Readings:</label>
        <input type="text" id="after_calibration_readings" name="after_calibration_readings" required>
        
        <label for="calibration_result">Calibration Result:</label>
        <select id="calibration_result" name="calibration_result" required>
            <option value="Pass">Pass</option>
            <option value="Fail">Fail</option>
        </select>
        
        <label for="comments">Comments:</label>
        <textarea id="comments" name="comments" rows="4"></textarea>
        
        <button type="submit">Add Record</button>
    </form>
    
    <?php
    // Database connection
// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection

    
    // Add new record
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $meter_id = $_POST['meter_id'];
        $calibration_date = $_POST['calibration_date'];
        $calibration_technician = $_POST['calibration_technician'];
        $calibration_standard_used = $_POST['calibration_standard_used'];
        $before_calibration_readings = $_POST['before_calibration_readings'];
        $after_calibration_readings = $_POST['after_calibration_readings'];
        $calibration_result = $_POST['calibration_result'];
        $comments = $_POST['comments'];
        
        $sql = "INSERT INTO CalibrationResults (meter_id, calibration_date, calibration_technician, calibration_standard_used, before_calibration_readings, after_calibration_readings, calibration_result, comments) 
                VALUES ('$meter_id', '$calibration_date', '$calibration_technician', '$calibration_standard_used', '$before_calibration_readings', '$after_calibration_readings', '$calibration_result', '$comments')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<p>New record added successfully</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    // Fetch schedule based on company name
    $company_name = "Your Company Name"; // Change this to the desired company name
    
    $sql = "SELECT * FROM CalibrationResults WHERE company_name = '$company_name'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table>
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
                </tr>";
        
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
                </tr>";
        }
        
        echo "</table>";
    } else {
        echo "No records found.";
    }
    
    // Close connection
    $conn->close();
    ?>
</
