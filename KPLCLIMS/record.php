<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivered Instruments</title>
    <style>
        /* CSS styling */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #0000ff; /* Blue border */
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ffff00; /* Yellow background */
        }
        /* Popup form styles */
        .popup-form-container {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .popup-form-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Delivered Instruments</h2>

    <!-- Button to display instruments delivered for calibration and repair -->
    <form method="post">
        <button type="submit" name="display">Display Instruments Delivered for Calibration and Repair</button>
    </form>

    <!-- Button to show pop-up form -->
    <button onclick="showForm()">Add Delivered Instrument</button>

    <!-- Pop-up form -->
    <div id="popupForm" class="popup-form-container">
        <div class="popup-form-content">
            <span class="close" onclick="hideForm()">&times;</span>
            <h3>Add Delivered Instrument</h3>
            <!-- Form to add a delivered instrument -->
            <form method="post">
                <label for="instrument_id">Instrument ID:</label>
                <input type="text" id="instrument_id" name="instrument_id" required>
                <label for="delivery_date">Delivery Date:</label>
                <input type="date" id="delivery_date" name="delivery_date" required>
                <label for="delivery_type">Delivery Type:</label>
                <input type="text" id="delivery_type" name="delivery_type" required>
                <label for="delivery_notes">Delivery Notes:</label>
                <textarea id="delivery_notes" name="delivery_notes" required></textarea>
                <button type="submit" name="add">Add Record</button>
            </form>
        </div>
    </div>

    <!-- Display records from the database -->
    <table>
        <tr>
            <th>ID</th>
            <th>Instrument ID</th>
            <th>Delivery Date</th>
            <th>Delivery Type</th>
            <th>Delivery Notes</th>
        </tr>
        <?php
        // Database connection
 // Include the config.php file
require_once('config.php');

// Now you can use the $conn variable to access your database connection

        // Process form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
            $instrument_id = $_POST['instrument_id'];
            $delivery_date = $_POST['delivery_date'];
            $delivery_type = $_POST['delivery_type'];
            $delivery_notes = $_POST['delivery_notes'];

            $sql = "INSERT INTO DeliveredInstruments (instrument_id, delivery_date, delivery_type, delivery_notes) 
                    VALUES ('$instrument_id', '$delivery_date', '$delivery_type', '$delivery_notes')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Record added successfully!')</script>";
            } else {
                echo "<script>alert('Error adding record: " . $conn->error . "')</script>";
            }
        }

        // Fetch records from database
        $sql = "SELECT * FROM DeliveredInstruments";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['instrument_id']}</td>
                        <td>{$row['delivery_date']}</td>
                        <td>{$row['delivery_type']}</td>
                        <td>{$row['delivery_notes']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }

        // Close database connection
        $conn->close();
        ?>
    </table>

    <script>
        // Function to show the pop-up form
        function showForm() {
            document.getElementById("popupForm").style.display = "block";
        }

        // Function to hide the pop-up form
        function hideForm() {
            document.getElementById("popupForm").style.display = "none";
        }
    </script>
</body>
</html>


composer require phpoffice/phpspreadsheet
composer require tecnickcom/tcpdf
