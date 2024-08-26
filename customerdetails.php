<?php

$db_handle = pg_connect("host=localhost dbname=mce_canteen user=postgres password=Bdvt@123");

if (!$db_handle) {
    die('Connection attempt failed.');
}

$query = "SELECT * FROM CUSTOMER";
$result = pg_query($db_handle, $query);

if (!$result) {
    die('Query failed: ' . pg_last_error());
}

$cart_details = pg_fetch_all($result);

pg_close($db_handle);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
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
        .container {
            margin-left: 260px;
            padding: 20px;
            width: calc(100% - 260px);
            max-width: 1200px;
            background: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            tr {
                margin-bottom: 15px;
            }
            th, td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            th::before, td::before {
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
            }
            th::before {
                content: attr(data-label);
                font-weight: bold;
            }
            td::before {
                content: attr(data-label);
            }
        }
    </style>
</head>
<body>
<div class="sidebar">
    <a href="dashdemo.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="addcustomer.php"><i class="fas fa-user"></i> Add Customer</a>
    <a href="addfood.php"><i class="fas fa-utensils"></i> Add Food</a>
    <a href="food section.html"><i class="fas fa-th-large"></i> Food Section</a>
    <a href="feedback2.php"><i class="fas fa-comments"></i> Know Feedback</a>
    <a href="knowmore.html"><i class="fas fa-info-circle"></i> Know More</a>
    <a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
<div class="container">
    <h1>Customer Details</h1>
    <table>
        <thead>
            <tr>
                <th data-label="CUST_NAME">CUST_NAME</th>
                <th data-label="ID">ID</th>
                <th data-label="Gender">Gender</th>
                <th data-label="DOB">DOB</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($cart_details): ?>
                <?php foreach ($cart_details as $cart): ?>
                    <tr>
                        <td data-label="CUST_NAME"><?php echo htmlspecialchars($cart['custname']); ?></td>
                        <td data-label="ID"><?php echo htmlspecialchars($cart['id']); ?></td>
                        <td data-label="Gender"><?php echo htmlspecialchars($cart['gender']); ?></td>
                        <td data-label="DOB"><?php echo htmlspecialchars($cart['dob']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No customer details found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
