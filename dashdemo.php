<?php  
    echo "Welcome to PHP page";
    $db_handle = pg_connect("host=localhost dbname=mce_canteen user=postgres password=Bdvt@123");

    if (!$db_handle) {
        die('Connection attempt failed.');
    }

    
    $query = "SELECT NAME, SUM(QTY) AS total FROM CART GROUP BY NAME";
    $result = pg_query($db_handle, $query);
    $response = array();
    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $response[] = array(
                'name' => $row['name'],
                'y' => (int)$row['total'],
            );
        }
    }

  
    $revenue_query = "SELECT SUM(TOTAL) AS REVENUE FROM CART";
    $revenue_result = pg_query($db_handle, $revenue_query);
    $total_revenue = 0;
    if ($revenue_result) {
        $revenue_row = pg_fetch_assoc($revenue_result);
        $total_revenue = $revenue_row['revenue'];
    }

    $customer_query = "SELECT COUNT(DISTINCT CUSTNAME) AS TOTALCUSTOMER FROM CUSTOMER";
    $customer_result = pg_query($db_handle, $customer_query);
    $total_customers = 0;
    if ($customer_result) {
        $customer_row = pg_fetch_assoc($customer_result);
        $total_customers = $customer_row['totalcustomer'];
    }

   
    $invoice_query = "SELECT COUNT(RECEIPT_NO) AS TOTALINVOICE FROM CART";
    $invoice_result = pg_query($db_handle, $invoice_query);
    $total_invoices = 0;
    if ($invoice_result) {
        $invoice_row = pg_fetch_assoc($invoice_result);
        $total_invoices = $invoice_row['totalinvoice'];
    }

    pg_close($db_handle);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Dashboard</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
        }
        .sidebar {
            height: 100%;
            width: 240px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #2c3e50;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #ecf0f1;
            display: block;
            transition: color 0.3s ease, background-color 0.3s ease;
        }
        .sidebar a:hover {
            color: #2c3e50;
            background-color: #ecf0f1;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            column-gap: 20px;
            width: 100%;
        }
        .card {
            background-color: #fff;
            padding: 24px;
            text-align: center;
            width: calc(25% - 65px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 4px;
            border: 1px solid #e3e3e3;
            box-shadow: 0px -1px 4px 0px rgba(24, 28, 31, 0.08), 0px 2px 4px 0px rgba(24, 28, 31, 0.16);
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
        .card h3 {
            margin: 0;
            font-size: 36px;
            color: #34495e;
        }
        .card p {
            font-size: 20px;
            margin: 10px 0 0 0;
            color: #7f8c8d;
        }
        .card i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #ecf0f1;
        }
        .chart-container {
            width: 100%;
            margin-top: 20px;
        }
        .table-container {
            margin-top: 20px;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #ecf0f1;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            color: #fff;
            background-color: #2980b9;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #3498db;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidebar a { float: left; }
            .content {
                margin-left: 0;
                flex-direction: column;
            }
            .cards-container, .chart-container {
                max-width: 100%;
                width: 100%;
            }
            .card {
                width: calc(100% - 20px);
            }
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #2980b9;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #3498db;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#"><i class="fas fa-home"></i> Dashboard</a>
        <a href="addcustomer.php"><i class="fas fa-user"></i> Add Customer</a>
        <a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
        <a href="food section.html"><i class="fas fa-th-large"></i> Food Section</a>
        <a href="feedback2.php"><i class="fas fa-comments"></i> Know Feedback</a>
        <a href="knowmore.html"><i class="fas fa-info-circle"></i> Know More</a>
        <a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="content">
        <div class="cards-container">
            <div class="card" style="background-color: #ecf0f1;">
                <i class="fas fa-users" style="color: #3498db;"></i>
                <h3><?php echo $total_customers; ?></h3>
                <a href="customerdetails.php" class="btn">Customer Details</a>
            </div>
            <div class="card" style="background-color: #f5b7b1;">
                <i class="fas fa-receipt" style="color: #e74c3c;"></i>
                <h3><?php echo $total_invoices; ?></h3>
                <a href="report.php" class="btn">Total Invoice</a>
            </div>
            <div class="card" style="background-color: #e8f8f5;">
                <i class="fas fa-calendar-alt" style="color: #2ecc71;"></i>
                <h3 id="current-date"></h3>
            </div>
            <div class="card" style="background-color: #f9e79f;">
                <i class="fas fa-dollar-sign" style="color: #f1c40f;"></i>
                <h3><?php echo number_format($total_revenue, 2); ?></h3>
                <p>Total Revenue</p>
            </div>
        </div>
        <div class="chart-container">
            <div id="container" style="width:100%; height:400px;"></div>
        </div>
    </div>
    <script>
        var results = <?php echo json_encode($response); ?>;
        console.log('results ', results);
        document.addEventListener('DOMContentLoaded', function() {
           
            const currentDateElement = document.getElementById('current-date');
            const currentDate = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            currentDateElement.textContent = currentDate.toLocaleDateString('en-US', options);

            Highcharts.setOptions({
                colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                    return {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.3,
                            r: 0.7
                        },
                        stops: [
                            [0, color],
                            [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                        ]
                    };
                })
            });
            Highcharts.chart('container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Food Sales Per Day'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<span style="font-size: 1.2em"><b>{point.name}</b></span><br><span style="opacity: 0.6">{point.percentage:.1f}%</span>',
                            connectorColor: 'rgba(128,128,128,0.5)'
                        }
                    }
                },
                series: [{
                    name: 'Share',
                    data: results
                }]
            });
        });
    </script>
</body>
</html>


