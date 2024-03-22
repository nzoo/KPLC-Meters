<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Procurement</title>
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

        .form-container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-container form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="date"],
        .form-container textarea {
            width: calc(33.33% - 10px);
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container input[type="submit"] {
            background-color: #00aaff;
            color: #fff;
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0077cc;
        }
    </style>
</head>
<body>
    <h2>Equipments Adding/Issuance and Return</h2>

    <!-- Form to add equipment -->
    <div class="form-container">
        <h3>Add Equipment</h3>
        <form method="post">
            <input type="text" name="equipment_type" placeholder="Equipment Type" required>
            <input type="text" name="serial_no" placeholder="Serial Number" required>
            <input type="text" name="model" placeholder="Model" required>
            <input type="submit" name="add_equipment" value="Add Equipment">
        </form>
    </div>

    <!-- Issue form -->
    <div class="form-container">
        <h3>Issue Equipment</h3>
        <form method="post">
            <input type="text" name="staff_no" placeholder="Staff No" required>
            <textarea name="comments_issued" placeholder="Comments Issued" required></textarea>
            <input type="date" name="date_issued" required>
            <input type="hidden" name="status_id" value="Issued">
            <input type="submit" name="issue_equipment" value="Issue Equipment">
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Staff No</th>
                <th>Equipment Type</th>
                <th>Serial No</th>
                <th>Model</th>
                <th>Comments Issued</th>
                <th>Comments Returned</th>
                <th>Date Issued</th>
                <th>Date Returned</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
       // Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection
// For example:

            // Check if the add equipment form is submitted
            if (isset($_POST['add_equipment'])) {
                // Get form data
                $equipment_type = $_POST['equipment_type'];
                $serial_no = $_POST['serial_no'];
                $model = $_POST['model'];

                // SQL query to insert equipment into EquipmentProcurement table
                $sql = "INSERT INTO EquipmentProcurement (equipment_type, serial_no, model, Status_ID)
                        VALUES ('$equipment_type', '$serial_no', '$model', NULL)";

                // Execute SQL query
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Equipment added successfully');</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Check if the issue equipment form is submitted
            if (isset($_POST['issue_equipment'])) {
                // Get form data
                $staff_no = $_POST['staff_no'];
                $comments_issued = $_POST['comments_issued'];
                $date_issued = $_POST['date_issued'];
                $status_id = $_POST['status_id'];

                // SQL query to insert issue details into EquipmentProcurement table
                $sql = "UPDATE EquipmentProcurement 
                        SET Comments_Issued = '$comments_issued', 
                            Date_Issued = '$date_issued', 
                            Status_ID = '$status_id' 
                        WHERE Staff_No = '$staff_no'";

                // Execute SQL query
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Equipment issued successfully');</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // SQL query to fetch data from EquipmentProcurement table
            $sql = "SELECT * FROM EquipmentProcurement";

            // Execute SQL query
            $result = $conn->query($sql);

            // Check if there are any rows in the result
            if ($result->num_rows > 0) {
                // Loop through each row in the result and display data in table rows
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Staff_No"] . "</td>";
                    echo "<td>" . $row["equipment_type"] . "</td>";
                    echo "<td>" . $row["serial_no"] . "</td>";
                    echo "<td>" . $row["model"] . "</td>";
                    echo "<td>" . $row["Comments_Issued"] . "</td>";
                    echo "<td>" . $row["Comments_Returned"] . "</td>";
                    echo "<td>" . $row["Date_Issued"] . "</td>";
                    echo "<td>" . $row["Date_Returned"] . "</td>";
                    echo "<td>" . $row["Status_ID"] . "</td>";
                    echo "</tr>";
                }
            } else {
                // If no rows are found, display a message
                echo "<tr><td colspan='9'>No data available</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
