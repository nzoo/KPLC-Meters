<?php
// Include the configuration file
require_once 'config.php';

// Add or Edit form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Process add form data and insert into database
        $meterId = $_POST['meter_id'];
        $supplierId = $_POST['supplier_id'];
        $deliveryDate = $_POST['delivery_date'];
        $quantity = $_POST['quantity'];

        $insertSql = "INSERT INTO DeliveredEnergyMeters (meter_id, supplier_id, delivery_date, quantity) 
                      VALUES ('$meterId', '$supplierId', '$deliveryDate', '$quantity')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Record added successfully!";
        } else {
            echo "Error adding record: " . $conn->error;
        }
    } elseif (isset($_POST['edit'])) {
        // Process edit form data and update database
        $id = $_POST['edit_id'];
        $meterId = $_POST['edit_meter_id'];
        $supplierId = $_POST['edit_supplier_id'];
        $deliveryDate = $_POST['edit_delivery_date'];
        $quantity = $_POST['edit_quantity'];

        $updateSql = "UPDATE DeliveredEnergyMeters 
                      SET meter_id='$meterId', supplier_id='$supplierId', delivery_date='$deliveryDate', quantity='$quantity'
                      WHERE id=$id";

        if ($conn->query($updateSql) === TRUE) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Process delete action and remove record from the database
        $id = $_POST['delete_id'];

        $deleteSql = "DELETE FROM DeliveredEnergyMeters WHERE id=$id";

        if ($conn->query($deleteSql) === TRUE) {
            echo "Record deleted successfully!";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Fetch data from DeliveredEnergyMeters table
$sql = "SELECT * FROM DeliveredEnergyMeters";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Energy Meters</title>
    <style>
        /* CSS styles */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<h2>Supplier Energy Meters</h2>

<!-- Display add form -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="meter_id">Meter ID:</label>
    <input type="text" name="meter_id" required>
    <label for="supplier_id">Supplier ID:</label>
    <input type="text" name="supplier_id" required>
    <label for="delivery_date">Delivery Date:</label>
    <input type="date" name="delivery_date" required>
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" required>
    <button type="submit" name="add">Add Record</button>
</form>

<!-- Display data in a table -->
<table>
    <tr>
        <th>ID</th>
        <th>Meter ID</th>
        <th>Supplier ID</th>
        <th>Delivery Date</th>
        <th>Quantity</th>
        <th>Actions</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['meter_id']}</td>
                <td>{$row['supplier_id']}</td>
                <td>{$row['delivery_date']}</td>
                <td>{$row['quantity']}</td>
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
        echo "<tr><td colspan='6'>0 results</td></tr>";
    }
    ?>
</table>

<!-- Display edit form when edit button is clicked -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $edit_id = $_POST['edit_id'];
    $edit_sql = "SELECT * FROM DeliveredEnergyMeters WHERE id=$edit_id";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
        ?>
        <h3>Edit Record</h3>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
            <label for="edit_meter_id">Meter ID:</label>
            <input type="text" name="edit_meter_id" value="<?php echo $edit_row['meter_id']; ?>" required>
            <label for="edit_supplier_id">Supplier ID:</label>
            <input type="text" name="edit_supplier_id" value="<?php echo $edit_row['supplier_id']; ?>" required>
            <label for="edit_delivery_date">Delivery Date:</label>
            <input type="date" name="edit_delivery_date" value="<?php echo $edit_row['delivery_date']; ?>" required>
            <label for="edit_quantity">Quantity:</label>
            <input type="number" name="edit_quantity" value="<?php echo $edit_row['quantity']; ?>" required>
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
