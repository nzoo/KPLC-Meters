<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Information</title>
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
            margin: 20px;
            border-radius: 10px;
            display: inline-block;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: none;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            background-color: #ffcc00;
            color: #333;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #ffdd33;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #00aaff; /* Adjusted color to match your provided color */
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
    <?php
// Replace these values with your database connection details
// Include the config.php file
require_once('config.php');

// Add or Edit form processing

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Process add form data and insert into database
        $supplierName = $_POST['supplier_name'];
        $contactPerson = $_POST['contact_person'];
        $contactEmail = $_POST['contact_email'];
        $contactPhone = $_POST['contact_phone'];
        $metersDelivered = $_POST['meters_delivered'];

        $insertSql = "INSERT INTO SupplierInformation (supplier_name, contact_person, contact_email, contact_phone, meters_delivered) 
                      VALUES ('$supplierName', '$contactPerson', '$contactEmail', '$contactPhone', $metersDelivered)";

        if ($conn->query($insertSql) === TRUE) {
            echo "Record added successfully!";
        } else {
            echo "Error adding record: " . $conn->error;
        }
    } elseif (isset($_POST['edit'])) {
        // Process edit form data and update database
        $id = $_POST['edit_id'];
        $supplierName = $_POST['edit_supplier_name'];
        $contactPerson = $_POST['edit_contact_person'];
        $contactEmail = $_POST['edit_contact_email'];
        $contactPhone = $_POST['edit_contact_phone'];
        $metersDelivered = $_POST['edit_meters_delivered'];

        $updateSql = "UPDATE SupplierInformation 
                      SET supplier_name='$supplierName', contact_person='$contactPerson', contact_email='$contactEmail', contact_phone='$contactPhone', 
                          , meters_delivered=$metersDelivered
                      WHERE id=$id";

        if ($conn->query($updateSql) === TRUE) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Process delete action and remove record from the database
        $id = $_POST['delete_id'];

        $deleteSql = "DELETE FROM SupplierInformation WHERE id=$id";

        if ($conn->query($deleteSql) === TRUE) {
            echo "Record deleted successfully!";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Fetch data from SupplierInformation table
$sql = "SELECT * FROM SupplierInformation";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Information</title>
</head>
<body>

<h2>Supplier Information</h2>

<!-- Display add form -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="supplier_name">Supplier Name:</label>
    <input type="text" name="supplier_name" required>
    <label for="contact_person">Contact Person:</label>
    <input type="text" name="contact_person">
    <label for="contact_email">Contact Email:</label>
    <input type="email" name="contact_email">
    <label for="contact_phone">Contact Phone:</label>
    <input type="tel" name="contact_phone">
    <label for="meters_delivered">Meters Delivered:</label>
    <input type="number" name="meters_delivered" min="0">
    <button type="submit" name="add">Add Record</button>
</form>

<!-- Display data in a table -->
<table border='1'>
    <tr>
        <th>ID</th>
        <th>Supplier Name</th>
        <th>Contact Person</th>
        <th>Contact Email</th>
        <th>Contact Phone</th>
        <th>Meters Delivered</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['supplier_name']}</td>
                <td>{$row['contact_person']}</td>
                <td>{$row['contact_email']}</td>
                <td>{$row['contact_phone']}</td>
                <td>{$row['meters_delivered']}</td>
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
        echo "<tr><td colspan='8'>0 results</td></tr>";
    }
    ?>

</table>

<!-- Display edit form when edit button is clicked -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $edit_id = $_POST['edit_id'];
    $edit_sql = "SELECT * FROM SupplierInformation WHERE id=$edit_id";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
        ?>
         <h3>Edit Record</h3>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
            <label for="edit_supplier_name">Supplier Name:</label>
            <input type="text" name="edit_supplier_name" value="<?php echo $edit_row['supplier_name']; ?>" required>
            <label for="edit_contact_person">Contact Person:</label>
            <input type="text" name="edit_contact_person" value="<?php echo $edit_row['contact_person']; ?>">
            <label for="edit_contact_email">Contact Email:</label>
            <input type="email" name="edit_contact_email" value="<?php echo $edit_row['contact_email']; ?>">
            <label for="edit_contact_phone">Contact Phone:</label>
            <input type="tel" name="edit_contact_phone" value="<?php echo $edit_row['contact_phone']; ?>">
            <input type="text" name="edit_calibration_standards_provided" value="<?php echo $edit_row['calibration_standards_provided']; ?>">
            <label for="edit_meters_delivered">Meters Delivered:</label>
            <input type="number" name="edit_meters_delivered" value="<?php echo $edit_row['meters_delivered']; ?>" min="0">
            <button type="submit" name="edit">Update Record</button>
        </form>
    <?php
    } else {
        echo "Error: Record not found.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    // Assuming the form processing code here

    // Display success message
    echo "<p>Form submitted successfully!</p>";
    exit; // Terminate further execution
}
?>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
</body>
</html>
