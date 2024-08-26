<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $feedback = $_POST['feedback'];

    $db_handle = pg_connect("host=localhost dbname=mce_canteen user=postgres password=Bdvt@123");

    if (!$db_handle) {
        die('Connection attempt failed.');
    }

    $query = "INSERT INTO feedback (feedback) VALUES ($1)";
    $params = array($feedback);

    $result = pg_query_params($db_handle, $query, $params);

    if ($result) {
        echo "<script>alert('Feedback submitted successfully');</script>";
    } else {
        echo "<script>alert('Failed to submit feedback');</script>";
    }

    pg_close($db_handle);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            display: flex;
        }
        .sidebar {
            width: 240px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            bottom: 0;
        }
        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 15px;
        }
        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 18px;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .sidebar ul li a:hover {
            background-color: #34495e;
        }
        .sidebar ul li a i {
            margin-right: 10px;
        }
        .container {
            margin-left: 260px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: calc(100% - 280px);
            margin-top: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
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
        a {
            display: block;
            margin: 20px 0;
            text-align: center;
            text-decoration: none;
            color: #4CAF50;
            font-size: 20px;
        }
        .message {
            text-align: center;
            color: #4CAF50;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
        <li>
                <a href="order.html"><i class="fas fa-utensils"></i>Menu</a>
            </li>
            <li>
                <a href="knowmore2.html"><i class="fas fa-info-circle"></i> Know More</a>
            </li>
            <li>
                <a href="feedback.php"><i class="fas fa-comments"></i> Feedback</a>
            </li>
            <li>
                <a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>

    <div class="container">
        <h1>Feedback</h1>
        <form id="feedbackForm" method="POST" action="">
            <textarea name="feedback" placeholder="Enter your feedback here..." required></textarea>
            <button type="submit">Submit</button>
        </form>
        
        <div class="message" id="responseMessage" style="display: none;">Your response was recorded</div>
    </div>
    <script>
        document.getElementById('feedbackForm').addEventListener('submit', function(event) {
            document.getElementById('responseMessage').style.display = 'block';
        });
    </script>
</body>
</html>
12