<?php

// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection
// For example:

// Define variables to store success or error messages
$successMessage = $errorMessage = "";

// Add form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Process form data and insert into database
        $instrumentId = $_POST['instrument_id'];
        $deliveryDate = $_POST['delivery_date'];
        $deliveryType = $_POST['delivery_type'];
        $deliveryNotes = $_POST['delivery_notes'];

        $insertSql = "INSERT INTO DeliveredInstruments (instrument_id, delivery_date, delivery_type, delivery_notes) 
                      VALUES ('$instrumentId', '$deliveryDate', '$deliveryType', '$deliveryNotes')";

        if ($conn->query($insertSql) === TRUE) {
            $successMessage = "Record added successfully!";
        } else {
            $errorMessage = "Error adding record: " . $conn->error;
        }
    }
}

// Fetch data from DeliveredInstruments table
$sql = "SELECT * FROM DeliveredInstruments";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instrument Delivery</title>
    <!-- Add CSS styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        h2 {
            color: #004080;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }
        button {
            background-color: #004080;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #003366;
        }
        .message {
            color: green;
        }
        .error {
            color: red;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
<body>

<div class="container">
    <h2>Instrument Delivery</h2>

    <!-- Display success or error messages -->
    <?php if (!empty($successMessage)) : ?>
        <div class="message"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    <?php if (!empty($errorMessage)) : ?>
        <div class="error"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <!-- Add delivery form -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="instrument_id">Instrument ID:</label>
        <input type="text" name="instrument_id" required>
        <label for="delivery_date">Delivery Date:</label>
        <input type="date" name="delivery_date" required>
        <label for="delivery_type">Delivery Type:</label>
        <input type="text" name="delivery_type" required>
        <label for="delivery_notes">Delivery Notes:</label>
        <textarea name="delivery_notes" rows="4" required></textarea>
        <button type="submit" name="submit">Submit</button>
    </form>

    <!-- Display instrument delivery records -->
    <h3>Instrument Delivery Records</h3>
    <table>
        <tr>
            <th>Instrument ID</th>
            <th>Delivery Date</th>
            <th>Delivery Type</th>
            <th>Delivery Notes</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['instrument_id']}</td>
                        <td>{$row['delivery_date']}</td>
                        <td>{$row['delivery_type']}</td>
                        <td>{$row['delivery_notes']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
