<?php
// Replace these values with your database connection details
// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection
// For example:

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $instrumentID = $_POST['instrument_id'];
    $deliveryDate = $_POST['delivery_date'];
    $deliveryType = $_POST['delivery_type'];

    // Insert delivery record into database
    $sql = "INSERT INTO InstrumentDeliveries (instrument_id, delivery_date, delivery_type) 
            VALUES ('$instrumentID', '$deliveryDate', '$deliveryType')";

    if ($conn->query($sql) === TRUE) {
        echo "Delivery recorded successfully!";
    } else {
        echo "Error recording delivery: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instrument Delivery Tracking</title>
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
        select {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #00aaff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0077cc;
        }
    </style>
</head>
<body>

<h2>Instrument Delivery Tracking</h2>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="instrument_id">Instrument ID:</label>
    <input type="text" name="instrument_id" required>
    <label for="delivery_date">Delivery Date:</label>
    <input type="date" name="delivery_date" required>
    <label for="delivery_type">Delivery Type:</label>
    <select name="delivery_type" required>
        <option value="Calibration">Calibration</option>
        <option value="Repair">Repair</option>
    </select>
    <input type="submit" value="Record Delivery">
</form>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
