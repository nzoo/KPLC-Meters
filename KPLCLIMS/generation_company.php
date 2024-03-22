<?php
// Include the config.php file
require_once('config.php');

// Handle record deletion
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $deleteQuery = "DELETE FROM power_companies WHERE company_id = $deleteId";
    if ($conn->query($deleteQuery) === TRUE) {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Handle record editing or new record addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit'])) {
        $editId = $_POST['edit_id'];
        $editedCompanyName = $_POST['edited_company_name'];
        $editedMeters = $_POST['edited_meters'];
        $editedAddress = $_POST['edited_address'];
        $editedGenerationGroups = $_POST['edited_generation_groups'];
        $editedContactPerson = $_POST['edited_contact_person'];
        $editedContactEmail = $_POST['edited_contact_email'];
        $editedContactPhone = $_POST['edited_contact_phone'];
        $editedRegistrationCert = $_POST['edited_registration_cert'];

        $updateQuery = "UPDATE power_companies SET 
                        company_name = '$editedCompanyName',
                        meters = '$editedMeters',
                        address = '$editedAddress',
                        generation_groups = '$editedGenerationGroups',
                        contact_person = '$editedContactPerson',
                        contact_email = '$editedContactEmail',
                        contact_phone = '$editedContactPhone',
                        registration_cert = '$editedRegistrationCert'
                        WHERE company_id = $editId";

        if ($conn->query($updateQuery) === TRUE) {
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['add'])) {
        $companyName = $_POST['company_name'];
        $meters = $_POST['meters'];
        $address = $_POST['address'];
        $generationGroups = $_POST['generation_groups'];
        $contactPerson = $_POST['contact_person'];
        $contactEmail = $_POST['contact_email'];
        $contactPhone = $_POST['contact_phone'];
        $registrationCert = $_POST['registration_cert'];

        $insertQuery = "INSERT INTO power_companies (company_name, meters, address, generation_groups, contact_person, contact_email, contact_phone, registration_cert, registration_date)
                        VALUES ('$companyName', '$meters', '$address', '$generationGroups', '$contactPerson', '$contactEmail', '$contactPhone', '$registrationCert', NOW())";

        if ($conn->query($insertQuery) === TRUE) {
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            echo "Error adding new record: " . $conn->error;
        }
    }
}

// Fetch data from power_companies table
$selectQuery = "SELECT * FROM power_companies";
$result = $conn->query($selectQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Power Companies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            background-color: #3498db;
            color: white;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        form {
            margin: 20px auto;
            width: 80%;
            background-color: #0000FF; /* Standard Blue */
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            display: inline-block;
            color: #fff;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="email"], input[type="tel"] {
            width: 80%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            display: inline-block;
            border: none;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #2ecc71;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        a.delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h2>Power Companies</h2>

    
    <form id="editForm" style="display:none;" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="edited_company_name" required>
        <label for="meters">Meters:</label>
        <input type="text" id="meters" name="edited_meters" required>
        <label for="address">Address:</label>
        <input type="text" id="address" name="edited_address" required>
        <label for="generation_groups">Generation Groups:</label>
        <input type="text" id="generation_groups" name="edited_generation_groups" required>
        <label for="contact_person">Contact Person:</label>
        <input type="text" id="contact_person" name="edited_contact_person" required>
        <label for="contact_email">Contact Email:</label>
        <input type="email" id="contact_email" name="edited_contact_email" required>
        <label for="contact_phone">Contact Phone:</label>
        <input type="tel" id="contact_phone" name="edited_contact_phone" required>
        <label for="registration_cert">Registration Cert:</label>
        <input type="text" id="registration_cert" name="edited_registration_cert" required>

        <input type="hidden" id="editId" name="edit_id">
        <input type="submit" name="edit" value="Save Changes">
    </form>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" required>
        <label for="meters">Meters:</label>
        <input type="text" name="meters" required>
        <label for="address">Address:</label>
        <input type="text" name="address" required>
        <label for="generation_groups">Generation Groups:</label>
        <input type="text" name="generation_groups" required>
        <label for="contact_person">Contact Person:</label>
        <input type="text" name="contact_person" required>
        <label for="contact_email">Contact Email:</label>
        <input type="email" name="contact_email" required>
        <label for="contact_phone">Contact Phone:</label>
        <input type="tel" name="contact_phone" required>
        <label for="registration_cert">Registration Cert:</label>
        <input type="text" name="registration_cert" required>

        <input type="submit" name="add" value="Add Record">
    </form>

    <script>
        function editRecord(id, companyName, meters, address, generationGroups, contactPerson, contactEmail, contactPhone, registrationCert) {
            document.getElementById("editId").value = id;
            document.getElementById("company_name").value = companyName;
            document.getElementById("meters").value = meters;
            document.getElementById("address").value = address;
            document.getElementById("generation_groups").value = generationGroups;
            document.getElementById("contact_person").value = contactPerson;
            document.getElementById("contact_email").value = contactEmail;
            document.getElementById("contact_phone").value = contactPhone;
            document.getElementById("registration_cert").value = registrationCert;

            document.getElementById("editForm").style.display = "block";
        }
    </script>
    <table>
        <tr>
            <th>ID</th>
            <th>Company Name</th>
            <th>Meters</th>
            <th>Address</th>
            <th>Generation Groups</th>
            <th>Contact Person</th>
            <th>Contact Email</th>
            <th>Contact Phone</th>
            <th>Registration Cert</th>
            <th>Registration Date</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['company_id']}</td>
                        <td>{$row['company_name']}</td>
                        <td>{$row['Meters']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['generation_groups']}</td>
                        <td>{$row['contact_person']}</td>
                        <td>{$row['contact_email']}</td>
                        <td>{$row['contact_phone']}</td>
                        <td>{$row['registration_cert']}</td>
                        <td>{$row['registration_date']}</td>
                        <td>
                            <a href='#' onclick='editRecord({$row['company_id']}, \"{$row['company_name']}\", \"{$row['Meters']}\", \"{$row['address']}\", \"{$row['generation_groups']}\", \"{$row['contact_person']}\", \"{$row['contact_email']}\", \"{$row['contact_phone']}\", \"{$row['registration_cert']}\")'>Edit</a>
                            | <a class='delete-btn' href='{$_SERVER['PHP_SELF']}?delete={$row['company_id']}'>Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No records found</td></tr>";
        }
        ?>
    </table>


    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
