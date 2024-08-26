<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db_handle = pg_connect("host=localhost dbname=mce_canteen user=postgres password=Bdvt@123");

    if (!$db_handle) {
        die('Connection attempt failed.');
    }

    if ($username === "admin" && $password === "admin@123") {
        header("Location: dashdemo.php");
        exit();
    } elseif ($username === "user" && $password === "user@123") {
        header("Location: order.html");
        exit();
    } elseif (preg_match('/^[0-4][A-Za-z][A-Za-z][0-9][0-9][A-Za-z][A-Za-z][0-9][0-9][0-9]$/', $username) && $password === "sahana") {
        $query_login = "INSERT INTO LOGIN (CUST_ID, PASSWORD) VALUES ($1, $2)";
        $params_login = array($username, $password);

        $result_login = pg_query_params($db_handle, $query_login, $params_login);

        if ($result_login) {
            header("Location: order.html");
            exit();
        } else {
            echo "<script>alert('Failed to add customer to login');</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials. Please try again.');</script>";
    }

    pg_close($db_handle);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malnad Canteen Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            background-size: cover;
            background-image: url('Images/background.jpg');
            background-repeat: no-repeat;
            background-position: center;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-container img {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
        }
        .login-container h1 {
            font-size: 24px;
            margin: 10px 0;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .login-container input {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .login-container button {
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .login-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="Images/canteen_logo.png" alt="Malnad Canteen Logo">
        <h1>Malnad Canteen</h1>
        <form method="POST" action="">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
