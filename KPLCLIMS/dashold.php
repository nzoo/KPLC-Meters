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
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
        }

        .logo {
            width: 150px;
            height: auto;
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        h1 {
            color: #fff;
            margin: 0;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        ul {
            list-style-type: none; /* Remove bullets */
            padding: 0;
            margin: 0;
        }

        .dashboard-link {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 15px 20px;
            text-decoration: none;
            color: #fff;
            transition: background-color 0.3s;
        }

        .dashboard-link i {
            margin-right: 10px;
        }

        .dashboard-sublink {
            color: #fff;
            display: block;
            padding-left: 40px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .dashboard-sublink i {
            margin-right: 10px;
        }

        .dashboard-link:hover,
        .dashboard-sublink:hover {
            background-color: #3498db; /* Blue background on hover */
        }

        #content {
            padding: 20px;
            margin-left: 200px; /* Adjust this value to match the width of the sidebar */
            width: calc(100% - 200px); /* Adjust this value to match the width of the sidebar */
        }
    </style>
</head>
<body>

<div class="sidebar">
    <img src="logo.png" alt="Logo" class="logo">
    <h1>Dashboard</h1>
    <ul>
        <li><a href="meterinformation.php" class="dashboard-link">
                <i class="fas fa-tachometer-alt"></i> Meter Information</a></li>
        <li><a href="supplier.php" class="dashboard-link">
                <i class="fas fa-users"></i> Supplier Information</a></li>
        <li><a href="generation_company.php" class="dashboard-link">
                <i class="fas fa-users"></i> Power Generation Companies</a></li>
        <li><a href="audittrail.php" class="dashboard-link">
                <i class="fas fa-clipboard-list"></i> Audit Trail</a></li>
        <li><a href="calibration.php" class="dashboard-link">
                <i class="fas fa-wrench"></i> Calibration</a></li>
        <li><a href="equipmentprocurement.php" class="dashboard-link">
                <i class="fas fa-shopping-cart"></i> Equipments Issuance</a></li>
        <li><a href="employees.php" class="dashboard-link">
                <i class="fas fa-user-tie"></i> Employees</a></li>
        <li><a href="instrumentIinventory.php" class="dashboard-link">
                <i class="fas fa-clipboard-list"></i> Instrument Inventory</a></li>
        <li><a href="inventory.php" class="dashboard-link">
                <i class="fas fa-tachometer-alt"></i> Inventory</a></li>
        <li><a href="maintenancelog.php" class="dashboard-link">
                <i class="fas fa-tools"></i> Maintenance Log</a></li>
        <li><a href="trackmetersnew.php" class="dashboard-link">
                <i class="fas fa-chart-line"></i> Sampled Energy Meters</a></li>
        <li><a href="qualitycontrol.php" class="dashboard-link">
                <i class="fas fa-check-circle"></i> Quality Control</a></li>
        <li><a href="testparameters.php" class="dashboard-link">
                <i class="fas fa-cogs"></i> Test Parameters</a></li>
        <li><a href="reports.php" class="dashboard-link">
                <i class="fas fa-cogs"></i> Reports</a></li>
    </ul>
</div>

<!-- Content section -->
<div id="content">
    <!-- Content will be loaded dynamically here -->
</div>

<script>
    // Intercept clicks on PHP links
    document.querySelectorAll('.dashboard-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            const url = this.getAttribute('href'); // Get the href attribute

            // Fetch content from the clicked URL
            fetch(url)
                .then(response => response.text()) // Get the response as text
                .then(html => {
                    document.getElementById('content').innerHTML = html; // Replace content with fetched HTML
                })
                .catch(error => console.error('Error fetching content:', error));
        });
    });

    <div class="row">
					<table class="table table_dashboard">
						<thead>
							<tr>
								<td><strong>Staff_No</strong></td>
								<td><strong>name</strong></td>
								<td><strong>email</strong></td>
								<td><strong>phone</strong></td>
	
								
							</tr>
						</thead>
					</table>
				</div>
</script>

</body>
</html>
