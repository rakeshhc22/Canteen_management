<?php

$db_handle = pg_connect("host=localhost dbname=mce_canteen user=postgres password=Bdvt@123");


if (!$db_handle) {
    die('Connection attempt failed.');
}

$query = "SELECT feedback FROM feedback";
$result = pg_query($db_handle, $query);

if (!$result) {
    die('Query failed.');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Display</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }
        h1 {
            text-align: center;
        }
        .feedback-item {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            border-left: 5px solid #4CAF50;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
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
        <h1>Feedback Display</h1>
        <?php
        
        while ($row = pg_fetch_assoc($result)) {
            echo '<div class="feedback-item">';
            echo htmlspecialchars($row['feedback']);
            echo '</div>';
        }

        
        pg_free_result($result);

        
        pg_close($db_handle);
        ?>
    </div>
    <button type="submit"><a href="dashdemo.php">Back to Home</a></button>
</body>
</html>
