<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
           
        }

        .sidebar {
            background-color: #2c3e50;
            color: #fff;
            width: 200px;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            
        }

        .logo {
            width: 150px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        .dashboard-link {
            display: flex;
            align-items: center;
            justify-content: start;
            padding: 10px;
            text-decoration: none;
            color: white;
        }

        .dashboard-link:hover {
            background-color: #2980b9;
        }

        .dashboard-link i {
            margin-right: 10px;
        }

        #content {
            margin-left:200px;
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-wrap: wrap;
            border: 2px solid red;

        }

        #charts-container {
            display: flex;
            justify-content: space-between;
            max-width: 800px;
            margin: 20px 0;
        }

        .chart-section {
            width: 48%;
        }

        #pieChart,
        #barChart,
        #barChartSupplier {
            width: 100%;
            height: 200px;
        }

    </style>
</head>

<body>
    <div class="sidebar">
        <!-- Existing sidebar content remains unchanged -->
        <!-- Add any additional sidebar links here -->
        <a class="dashboard-link" href="#" id="meterInformationLink">
            <i class="fas fa-chart-pie"></i> Meter Information
			
        </a>
    </div>

    <div id="content">
        <!-- Existing content remains unchanged -->
        <!-- Add any additional content sections here -->
        <div id="meterInformationContent">
            <!-- This div will be updated with the content from meterinformation.php -->
        </div>
    </div>

    <script>
        // Set up AJAX request for meter information form submission
        document.querySelector('#meterInformationLink').addEventListener('click', function(event) {
            event.preventDefault();

            // Send AJAX request to meterinformation.php
            fetch('meterinformation.php', {
                method: 'POST',
                // Add any necessary headers or body data here
            })
            .then(response => response.text())
            .then(data => {
                // Update meterInformationContent div with the response
                document.querySelector('#meterInformationContent').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>
