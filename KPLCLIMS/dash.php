<!-- dash.php -->

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
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.dashboard-link').forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('content').innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error loading the page: ', error);
                            document.getElementById('content').innerHTML = '<p>Error loading the content.</p>';
                        });
                });
            });
        });
    </script>
	
</head>

<body>

    <div class="sidebar">
        <img src="logo.png" alt="Logo" class="logo">
        <ul>
            <?php
            // Add more links as needed
            $dashboardLinks = [
                ["meterinformation.php", "fas fa-tachometer-alt", "Receive Items"],
                ["supplier.php", "fas fa-users", "Suppliers"],
                ["generation_company.php", "fas fa-industry", "Companies"],
                ["calibration.php", "fas fa-wrench", "Calibration Results"],
                ["employees.php", "fas fa-user-tie", "Manage Users"],
                ["instrumentslist.php", "fas fa-clipboard-list", "Instrument Management"],
                ["inventory.php", "fas fa-tachometer-alt", "Inventory"],
                ["maintenancelog.php", "fas fa-tools", "Maintenance Log"],
                ["trackmetersnew.php", "fas fa-chart-line", "Sampled Energy Meters"],
                ["qualitycontrol.php", "fas fa-check-circle", "Quality Control"],
                ["testparameters.php", "fas fa-cogs", "Test Parameters"],
                ["reports.php", "fas fa-cogs", "Reports"],
                // Add more links as needed
            ];

            foreach ($dashboardLinks as $link) {
                echo "<li><a href='{$link[0]}' class='dashboard-link'><i class='{$link[1]}'></i>{$link[2]}</a></li>";
            }
            ?>
        </ul>
    </div>

    <div id="content">
        <!-- Content loaded from PHP files will appear here -->
          <!-- DeliveredInstruments Pie Chart Section -->
          <head>
<!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
          <div class="chart-section">
            <h2>Pie Chart - Delivered Instruments</h2>
            <canvas id="pieChart" width="300" height="200"></canvas>

            <?php
            // Include the config.php file
            require_once('config.php');

            $sqlDeliveredInstruments = "SELECT COUNT(*) as total, delivery_type FROM DeliveredInstruments GROUP BY delivery_type";
            $resultDeliveredInstruments = $conn->query($sqlDeliveredInstruments);

            $chartDataDeliveredInstruments = [];
            if ($resultDeliveredInstruments->num_rows > 0) {
                while ($rowDeliveredInstruments = $resultDeliveredInstruments->fetch_assoc()) {
                    $chartDataDeliveredInstruments[] = $rowDeliveredInstruments;
                }
            }
            ?>

            <script>
                // Pie Chart for DeliveredInstruments
                document.addEventListener('DOMContentLoaded', function () {
                    var pieChartCtx = document.getElementById('pieChart').getContext('2d');
                    var pieChart = new Chart(pieChartCtx, {
                        type: 'pie',
                        data: {
                            labels: [<?php foreach ($chartDataDeliveredInstruments as $row) echo "'{$row['delivery_type']}', "; ?>],
                            datasets: [{
                                data: [<?php foreach ($chartDataDeliveredInstruments as $row) echo "{$row['total']}, "; ?>],
                                backgroundColor: ['#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c'],
                            }]
                        },
                    });
                });
            </script>
        </div>

        <!-- Supplier Information Bar Chart Section -->
        <div class="chart-section">
            <h2>Supplier Information Chart</h2>
            <canvas id="barChartSupplier" width="300" height="200"></canvas>

            <?php
            // Fetch records from supplierinformation for the bar chart
            $sqlSupplierChart = "SELECT COUNT(*) as total, supplier_name FROM supplierinformation GROUP BY supplier_name";
            $resultSupplierChart = $conn->query($sqlSupplierChart);

            $chartDataSupplier = [];
            if ($resultSupplierChart->num_rows > 0) {
                while ($rowSupplierChart = $resultSupplierChart->fetch_assoc()) {
                    $chartDataSupplier[] = $rowSupplierChart;
                }
            }
            ?>
<?php
// Add your existing PHP code

foreach ($dashboardLinks as $link) {
    echo "<li><a href='{$link[0]}' class='dashboard-link'><i class='{$link[1]}'></i>{$link[2]}</a></li>";
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.dashboard-link').forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const url = this.getAttribute('href');
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('content').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading the page: ', error);
                        document.getElementById('content').innerHTML = '<p>Error loading the content.</p>';
                    });
            });
        });

     // Add event listener for form submission
    document.getElementById('submitBtn').addEventListener('click', function (event) {
        event.preventDefault();
        const form = document.getElementById('supplierForm'); // Update form ID if needed
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('content').innerHTML = html; // Update content with success message
        })
        .catch(error => {
            console.error('Error submitting form: ', error);
        });
    });
});
</script>

            <script>
                // Bar Chart for supplierinformation
                document.addEventListener('DOMContentLoaded', function () {
                    var barChartSupplierCtx = document.getElementById('barChartSupplier').getContext('2d');
                    var barChartSupplier = new Chart(barChartSupplierCtx, {
                        type: 'bar',
                        data: {
                            labels: [<?php foreach ($chartDataSupplier as $rowSupplierChart) {
                                            echo "'{$rowSupplierChart['supplier_name']}', ";
                                        } ?>],
                            datasets: [{
                                label: 'Meters Delivered',
                                data: [<?php foreach ($chartDataSupplier as $rowSupplierChart) {
                                            echo "{$rowSupplierChart['total']}, ";
                                        } ?>],
                                backgroundColor: '#3498db',
                            }]
                        },
                    });
                });
            </script>
        </div>

    </div>
        <!-- Initial content can be added here if needed -->
    </div>

</body>

</html>
