<?php
// Database connection
// Replace these values with your database connection details
// Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection
// For example:

// Handle form submission for adding employees
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_employee"])) {
    $staff_no = $_POST["staff_no"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Prepare and execute SQL statement to insert employee
    $sql = "INSERT INTO Employees (Staff_No, Name, Email, Phone) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $staff_no, $name, $email, $phone);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission for removing employees
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_employee"])) {
    $staff_no = $_POST["staff_no"];

    // Prepare and execute SQL statement to delete employee
    $sql = "DELETE FROM Employees WHERE Staff_No = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $staff_no);
    $stmt->execute();
    $stmt->close();
}

// Fetch all employees from the database
$sql = "SELECT * FROM Employees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
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
            margin-bottom: 20px;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"], input[type="tel"] {
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
    </style>
</head>
<body>
    <h2>Employee Management</h2>

    <!-- Form to add employee -->
    <form method="post">
        <label for="staff_no">Staff No:</label>
        <input type="text" id="staff_no" name="staff_no" required>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>
        <button type="submit" name="add_employee">Add Employee</button>
    </form>

    <!-- Form to remove employee -->
    <form method="post">
        <label for="staff_no_remove">Staff No to Remove:</label>
        <input type="text" id="staff_no_remove" name="staff_no" required>
        <button type="submit" name="remove_employee">Remove Employee</button>
    </form>

    <!-- Display table of employees -->
    <table>
        <tr>
            <th>Staff No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Staff_No']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['Email']}</td>
                        <td>{$row['Phone']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No employees found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
``