<?php
// Include the config.php file
require_once('config.php');

// SQL to fetch data from audittrail table
$sql = "SELECT id, user_id, timestamp, description, action_performed, created_at, updated_at FROM audittrail";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audit Trail Records</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Audit Trail Records</h2>

<!-- Display data in table -->
<table>
    <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Timestamp</th>
        <th>Description</th>
        <th>Action Performed</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["id"]. "</td>
                <td>" . $row["user_id"]. "</td>
                <td>" . $row["timestamp"]. "</td>
                <td>" . $row["description"]. "</td>
                <td>" . $row["action_performed"]. "</td>
                <td>" . $row["created_at"]. "</td>
                <td>" . $row["updated_at"]. "</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>0 results</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
