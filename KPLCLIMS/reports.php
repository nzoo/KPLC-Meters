<?php
// Include the config.php file
require_once('config.php');

// Assuming you have a table for users with a 'created_at' timestamp column
$sql = "SELECT model, count(*) as total FROM `meterinformation` WHERE 1 GROUP BY model;";
$result = $conn->query($sql);

$modelreport = [];
if ($result->num_rows > 0) {
    // Fetch all model data
    while($row = $result->fetch_assoc()) {
        $modelreport[$row["model"]] = $row["total"];
    }
} else {
    echo "No model data found";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Model Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: blue;
            color: white;
            padding: 10px;
        }
        td {
            padding: 8px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #ffff99; /* light yellow */
        }
        tr:nth-child(odd) {
            background-color: #ffffcc; /* even lighter yellow */
        }
        .report-container {
            margin: 20px auto;
            width: 80%;
            box-shadow: 0 0 10px #ccc;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="report-container">
    <h2>Model Report</h2>

    <?php if (!empty($modelreport)): ?>
        <table>
            <thead>
                <tr>
                    <th>Model</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modelreport as $model => $total): ?>
                <tr>
                    <td><?php echo htmlspecialchars($model); ?></td>
                    <td><?php echo htmlspecialchars($total); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No data to display.</p>
    <?php endif; ?>
</div>

</body>
</html>
<?php
