<?php

// Include the config.php file
require_once('config.php');

// Define variables to store success or error messages
$successMessage = $errorMessage = "";

// Add or Edit form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Process add form data and insert into database
        $instrumentId = $_POST['instrument_id'];
        $deliveryDate = $_POST['delivery_date'];
        $deliveryType = $_POST['delivery_type'];
        $deliveryNotes = $_POST['delivery_notes'];
        // Add other form fields as needed

        $insertSql = "INSERT INTO DeliveredInstruments (instrument_id, delivery_date, delivery_type, delivery_notes) 
                      VALUES ('$instrumentId', '$deliveryDate', '$deliveryType', '$deliveryNotes')";

        if ($conn->query($insertSql) === TRUE) {
            $successMessage = "Record added successfully!";
        } else {
            $errorMessage = "Error adding record: " ;
        }
    } elseif (isset($_POST['edit'])) {
        // Process edit form data and update database
        // Add similar code as above for editing records
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
    <title>Delivered Instruments</title>
    <!-- Add CSS styles here -->
    <style>
        /* Add your CSS styles */
        body {
            font-family: Arial, sans-serif;
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

<h2>Delivered Instruments</h2>

<!-- Display success or error messages -->
<?php if (!empty($successMessage)) : ?>
    <div style="color: green;"><?php echo $successMessage; ?></div>
<?php endif; ?>
<?php if (!empty($errorMessage)) : ?>
    <div style="color: red;"><?php echo $errorMessage; ?></div>
<?php endif; ?>

<!-- Display add form -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <!-- Add input fields for the form -->
    <button type="submit" name="add">Add Record</button>
</form>

<!-- Display data in a table -->
<table>
    <tr>
        <th>Instrument ID</th>
        <th>Delivery Date</th>
        <th>Delivery Type</th>
        <th>Delivery Notes</th>
        <!-- Add more table headers as needed -->
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['instrument_id']}</td>
                <td>{$row['delivery_date']}</td>
                <td>{$row['delivery_type']}</td>
                <td>{$row['delivery_notes']}</td>
                <!-- Add more table data as needed -->
            </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>0 results</td></tr>";
    }
    ?>

</table>

<!-- Display edit form when edit button is clicked -->
<?php
// Add edit form display code here
?>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
