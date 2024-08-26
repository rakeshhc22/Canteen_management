<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $id = $_POST['id'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    $db_handle = pg_connect("host=localhost dbname=mce_canteen user=postgres password=Bdvt@123");

    if (!$db_handle) {
        die('Connection attempt failed.');
    }

    $query = "INSERT INTO CUSTOMER (CUSTNAME, ID, GENDER, DOB) VALUES ($1, $2, $3, $4)";
    $params = array($name, $id, $gender, $dob);

    $result = pg_query_params($db_handle, $query, $params);

    if ($result) {
        echo "<script>alert('Customer added successfully');</script>";
    } else {
        echo "<script>alert('Failed to add customer');</script>";
    }

    pg_close($db_handle);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: calc(100% - 240px); 
            max-width: 500px;
            margin: auto; 
        }
        .form-container h2 {
            color: #4CAF50;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"], .form-group input[type="date"] {
            width: 100%; 
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group .gender-options {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
        }
        .form-group .gender-options input[type="radio"] {
            margin-left: 10px;
        }
        .form-group .gender-options label {
            margin-right: 10px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
        .form-container .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
            font-size: 16px;
        }
        .form-container .back-link:hover {
            text-decoration: underline;
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

<div class="form-container">
    <h2>Add Customer</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label for="id">ID</label>
            <input type="text" id="id" name="id" placeholder="ID" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <div class="gender-options">
                <label for="male">Male</label>
                <input type="radio" id="male" name="gender" value="M" required>
                <label for="female">Female</label>
                <input type="radio" id="female" name="gender" value="F" required>
            </div>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>
        </div>
        <div class="form-group">
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

</body>
</html>
