<?php
// Include the config.php file
require_once('config.php');

// Fetch data from SampledEnergyMeter table
$sql = "SELECT * FROM SampledEnergyMeter";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sampled Energy Meter Data</title>
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
    </style>
</head>
<body>

<h2>Sampled Energy Meter Data</h2>

<!-- Display data in a table -->
<table>
    <tr>
        <th>ID</th>
        <th>Serial Number</th>
        <th>Energy Reading</th>
        <th>Timestamp</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['serial_number']}</td>
                <td>{$row['energy_reading']}</td>
                <td>{$row['timestamp']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>0 results</td></tr>";
    }
    ?>

</table>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
