<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer and Equipment Input Form</title>
    <link rel="stylesheet" href="print.css" media="print">
    <!-- Your existing styles -->
    <style>
      body {
            font-family: Arial, sans-serif;
            background-color: #87CEEB; /* Sky Blue */
            margin: 0;
            padding: 0px;
            color: #000080; /* Yellow */
        }

        h1, h2 {
            background-color: #000080; /* Navy */
            color: #FFFFFF; /* White */
            border-radius: 3px;
            padding: 10px;
        }

        form, #submittedData {
            background-color: #FFFF00; /*Yellow*/
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
        } 

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000080; /* Navy */
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        input[type="text"], textarea, select {
            width: calc(100% - 20px); /* Adjusted width to fit beside the label */
            padding: 8px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 3px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        input[type="submit"], #printBtn {
            background-color: #000080; /* Navy */
            color: #FFFFFF; /* White */
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        #validity_period_section {
            display: block;
        }

        #submittedData {
            display: none;
        }
    </style>
   
</head>

<body>

<?php
// Include the config.php file
require_once('config.php');

// Function to insert data into the database
function insertData($conn, $table, $data) {
    $columns = implode(', ', array_keys($data));
    $values = "'" . implode("', '", $data) . "'";
    $insertSql = "INSERT INTO $table ($columns) VALUES ($values)";
    
    if ($conn->query($insertSql) === TRUE) {
        echo "<script>alert('Record added successfully!')</script>";
    } else {
        echo "<script>alert('Error adding record: {$conn->error}')</script>";
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Capture customer information
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];
    $customer_phone = $_POST['customer_phone'];

    // Capture equipment information
    $manufacturer = $_POST['manufacturer'];
    $item_description = $_POST['item_description'];
    $model = $_POST['model'];
    $serial_number = $_POST['serial_number'];
    $ratings_kva = $_POST['ratings_kva'];

    // Capture service_type
    $service_type = isset($_POST['service_type']) ? implode(', ', $_POST['service_type']) : '';

    // Capture calibration period information
    $calibration_period = $_POST['calibration_period'];
    $validity_period = ($calibration_period == 'yes') ? $_POST['validity_period'] : null;

    // Insert data into the database
    $data = [
        'customer_name' => $customer_name,
        'customer_email' => $customer_email,
        'customer_address' => $customer_address,
        'customer_phone' => $customer_phone,
        'manufacturer' => $manufacturer,
        'item_description' => $item_description,
        'model' => $model,
        'serial_number' => $serial_number,
        'ratings_kva' => $ratings_kva,
        'service_type' => $service_type,
        'calibration_period' => $calibration_period,
        'validity_period' => $validity_period,
    ];

    insertData($conn, 'meterinformation', $data);

    // Close database connection
    $conn->close();
}
?>

<h1>Input form Customer and Equipment</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Customer Information</h2>
    <label for="customer_name">Customer Name:</label>
    <input type="text" name="customer_name" required>

    <label for="customer_email">Customer Email:</label>
    <input type="text" name="customer_email" required>

    <label for="customer_address">Customer Address:</label>
    <input type="text" name="customer_address" required>

    <label for="customer_phone">Customer Phone:</label>
    <input type="text" name="customer_phone" required>

    <h2>Equipment Information</h2>
    <label for="manufacturer">Manufacturer:</label>
    <input type="text" name="manufacturer">

    <label for="item_description">Item Description:</label>
    <input type="text" name="item_description">

    <label for="model">Model:</label>
    <input type="text" name="model">

    <label for="serial_number">Serial Number:</label>
    <input type="text" name="serial_number">

    <label for="ratings_kva">Ratings (KVA):</label>
    <input type="text" name="ratings_kva">

    <h2>Service Type</h2>
    <input type="checkbox" name="service_type[]" value="Calibration/Testing of Energy Meters -IEC 62052-11">Calibration/Testing of Energy Meters -IEC 62052-11<br>
    <input type="checkbox" name="service_type[]" value="Calibration/Testing of Energy Meters -IEC 62052-31">Calibration/Testing of Energy Meters -IEC 62052-31<br>
    <input type="checkbox" name="service_type[]" value="Testing of miniature breaakers -IEC 60898-2">Testing of miniature breaakers -IEC 60898-2<br>
    <input type="checkbox" name="service_type[]" value="Testing of low current Energy Transformers -IEC 60044-1">Testing of low current Energy Transformers -IEC 60044-1<br>
    <input type="checkbox" name="service_type[]" value="Testing of low current Energy Transformers - IEC 61869-1&2">Testing of low current Energy Transformers - IEC 61869-1&2<br>
    <input type="checkbox" name="service_type[]" value="AC/DC testing and calibration - ANSI/NCSL - Z 540 3">AC/DC testing and calibration - ANSI/NCSL - Z 540 3<br>
    <input type="checkbox" name="service_type[]" value="Others">Others<br>
    <label for="other_services">Specify Other Services:</label>
    <textarea name="other_services"></textarea>

    <h2>Calibration Period</h2>
    <label>Indicate Validity of Calibration Period:</label>
    <label><input type="radio" name="calibration_period" value="yes"> Yes</label>
    <label><input type="radio" name="calibration_period" value="no"> No</label>

    <div id="validity_period_section">
        <label for="validity_period">Validity Period (months):</label>
        <input type="text" name="validity_period">
    </div>

    <input type="submit" name="submit" value="Submit" id="submitBtn">
</form>

<div id="submittedData">
    
    <div>
    
    <img id="logo" src="logo.png" alt="Company Logo">
    <h1>Job Card</h1>
</div>

        <table>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Customer Name</td>
            <td id="customerName"></td>
        </tr>
        <tr>
            <td>Customer Email</td>
            <td id="customerEmail"></td>
        </tr>
        <tr>
            <td>Customer Address</td>
            <td id="customerAddress"></td>
        </tr>
        <tr>
            <td>Customer Phone</td>
            <td id="customerPhone"></td>
        </tr>
                <tr>
            <td>Manufacturer</td>
            <td id="manufacturer"></td>
        </tr>
        <tr>
            <td>Item Description</td>
            <td id="itemDescription"></td>
        </tr>
        <tr>
            <td>Model</td>
            <td id="model"></td>
        </tr>
        <tr>
            <td>Serial Number</td>
            <td id="serialNumber"></td>
        </tr>
        <tr>
            <td>Ratings (KVA)</td>
            <td id="ratingsKva"></td>
        </tr>
                <tr>
            <td>Service Type</td>
            <td id="serviceType"></td>
        </tr>
                <tr>
            <td>Calibration Period</td>
            <td id="calibrationPeriod"></td>
        </tr>
        <tr>
            <td>Validity Period (months)</td>
            <td id="validityPeriod"></td>
        </tr>
        <tr>
            <td>Signature</td>
            <td><input type="text" id="signature"></td>
        </tr>
        <tr>
            <td>Date</td>
            <td><input type="date" id="date"></td>
        </tr>
    </table>
    <button id="printBtn">Print</button>
</div>

<!-- Add the custom script for showing/hiding the validity period section and displaying submitted data -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide validity period based on radio button selection
        var calibrationPeriodRadio = document.getElementsByName('calibration_period');
        var validityPeriodSection = document.getElementById('validity_period_section');

        for (var i = 0; i < calibrationPeriodRadio.length; i++) {
            calibrationPeriodRadio[i].addEventListener('change', function() {
                validityPeriodSection.style.display = (this.value === 'yes') ? 'block' : 'none';
            });
        }

        // Add a click event listener to the submit button to display submitted data
        document.getElementById('submitBtn').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission behavior
            displaySubmittedData();
        });

        // Function to display submitted data
        function displaySubmittedData() {
            document.getElementById('customerName').textContent = document.getElementsByName('customer_name')[0].value;
            document.getElementById('customerEmail').textContent = document.getElementsByName('customer_email')[0].value;
            document.getElementById('customerAddress').textContent = document.getElementsByName('customer_address')[0].value;
            document.getElementById('customerPhone').textContent = document.getElementsByName('customer_phone')[0].value;
            document.getElementById('manufacturer').textContent = document.getElementsByName('manufacturer')[0].value;
            document.getElementById('itemDescription').textContent = document.getElementsByName('item_description')[0].value;
            document.getElementById('model').textContent = document.getElementsByName('model')[0].value;
            document.getElementById('serialNumber').textContent = document.getElementsByName('serial_number')[0].value;
            document.getElementById('ratingsKva').textContent = document.getElementsByName('ratings_kva')[0].value;

            var serviceTypes = document.getElementsByName('service_type[]');
            var selectedServices = [];
            for (var i = 0; i < serviceTypes.length; i++) {
                if (serviceTypes[i].checked) {
                    selectedServices.push(serviceTypes[i].value);
                }
            }
            document.getElementById('serviceType').textContent = selectedServices.join(', ');

            var calibrationPeriod = document.querySelector('input[name="calibration_period"]:checked');
            document.getElementById('calibrationPeriod').textContent = calibrationPeriod ? calibrationPeriod.value : '';

            if (calibrationPeriod && calibrationPeriod.value === 'yes') {
                document.getElementById('validityPeriod').textContent = document.getElementsByName('validity_period')[0].value;
            } else {
                document.getElementById('validityPeriod').textContent = '';
            }

            // Display the submitted data section
            document.getElementById('submittedData').style.display = 'block';
        }

        // Add a click event listener to the print button to open print window
        document.getElementById('printBtn').addEventListener('click', function() {
            printData();
        });

        // Function to print the form
        function printData() {
            // Get the submitted data section HTML content
            var submittedDataContent = document.getElementById('submittedData').innerHTML;

            // Create a new window for printing
            var printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write('<!DOCTYPE html>');
            printWindow.document.write('<html lang="en">');
            printWindow.document.write('<head>');
            printWindow.document.write('<meta charset="UTF-8">');
            printWindow.document.write('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
            printWindow.document.write('<title>Print Job Card</title>');
            printWindow.document.write('<style>');
            // Add print styles here if needed
            printWindow.document.write('</style>');
            printWindow.document.write('</head>');
            printWindow.document.write('<body>');
            printWindow.document.write('<h2>Job Card</h2>');
            printWindow.document.write(submittedDataContent); // Insert submitted data content
            printWindow.document.write('<br><br>');
            printWindow.document.write('<div>');
            printWindow.document.write('Signature: <input type="text" id="signature">');
            printWindow.document.write('</div>');
            printWindow.document.write('<div>');
            printWindow.document.write('Date: <input type="date" id="date">');
            printWindow.document.write('</div>');
            printWindow.document.write('</body>');
            printWindow.document.write('</html>');
            printWindow.document.close();

            // Print the window
            printWindow.print();
        }
    });
</script>


</body>

</html>
