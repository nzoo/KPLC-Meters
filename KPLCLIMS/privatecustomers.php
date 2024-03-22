<?php
// Database connection
// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection
// Fetch data from PrivateCustomers table
$sql = "SELECT * FROM PrivateCustomers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Customers</title>
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

input[type="text"], textarea {
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
    <h2>Private Customers</h2>
    <table>
        <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Contact Information</th>
            <th>Calibration Standards Provided</th>
            <th>Other Details</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['customer_id']}</td>
                        <td>{$row['customer_name']}</td>
                        <td>{$row['contact_information']}</td>
                        <td>{$row['calibration_standards_provided']}</td>
                        <td>{$row['other_details']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data available</td></tr>";
        }
        ?>
    </table>

    <h2>Add New Customer</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name" required><br>
        <label for="contact_information">Contact Information:</label>
        <input type="text" name="contact_information" required><br>
        <label for="calibration_standards_provided">Calibration Standards Provided:</label>
        <input type="text" name="calibration_standards_provided" required><br>
        <label for="other_details">Other Details:</label>
        <textarea name="other_details"></textarea><br>
        <button type="submit" name="add">Add Customer</button>
    </form>

    <?php
    // Add new customer
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $customer_name = $_POST['customer_name'];
        $contact_information = $_POST['contact_information'];
        $calibration_standards_provided = $_POST['calibration_standards_provided'];
        $other_details = $_POST['other_details'];

        $insertSql = "INSERT INTO PrivateCustomers (customer_name, contact_information, calibration_standards_provided, other_details) 
                      VALUES ('$customer_name', '$contact_information', '$calibration_standards_provided', '$other_details')";

        if ($conn->query($insertSql) === TRUE) {
            echo "<p>Customer added successfully!</p>";
        } else {
            echo "<p>Error adding customer: " . $conn->error . "</p>";
        }
    }
    ?>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
