<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart = json_decode($_POST['cart'], true);
    $username = $_SESSION['username']; 

    $db_handle = pg_connect("host=localhost dbname=mce_canteen user=postgres password=Bdvt@123");

    if (!$db_handle) {
        die('Connection attempt failed.');
    }

    
    foreach ($cart as $item) {
        $name = $item['name'];
        $cost = $item['price'];
        $qty = $item['qty'];
        $total = $cost * $qty;
        $receipt_no = mt_rand(1000, 9999);
        $ord_date = date('Y-m-d');
        $status = 'SUCCESSFUL';

        $query_cart = "INSERT INTO CART (NAME, COST, QTY, TOTAL, RECEIPT_NO, ORD_DATE, STATUS) VALUES ($1, $2, $3, $4, $5, $6, $7)";
        $params_cart = array($name, $cost, $qty, $total, $receipt_no, $ord_date, $status);
        $result_cart = pg_query_params($db_handle, $query_cart, $params_cart);

        if (!$result_cart) {
            echo "<script>alert('Failed to add item to cart');</script>";
            pg_close($db_handle);
            exit();
        }
    }

    echo "<script>alert('Cart items added successfully');</script>";

    pg_close($db_handle);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .cart-items {
            margin: 20px auto;
            width: 80%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .cart-header, .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .cart-item div, .cart-header div {
            flex: 1;
        }
        .cart-header div {
            font-weight: bold;
        }
        .cart-item div:nth-child(2), .cart-header div:nth-child(2) {
            text-align: center;
        }
        .cart-item div:nth-child(3), .cart-header div:nth-child(3) {
            text-align: right;
        }
        .cart-item div:nth-child(4), .cart-header div:nth-child(4) {
            text-align: right;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .checkout {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .checkout button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .checkout button:hover {
            background-color: #45a049;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            text-decoration: none;
            color: #fff;
        }
        .search-bar {
            margin-bottom: 10px;
            text-align: center;
        }
        .search-bar input[type="text"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
        }
        .search-bar button {
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        .search-bar button:hover {
            background-color: #45a049;
        }
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Your Cart</h1>
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search items in your cart...">
        <button onclick="searchCart()">Search</button>
    </div>
    <div class="cart-items" id="cart-items">
        <div class="receipt-info">
            <div>Receipt No: <span id="receipt-no"></span></div>
            <div>Date: <span id="current-date"></span></div>
        </div>
        <div class="cart-header">
            <div>Name</div>
            <div>Cost</div>
            <div>Qty</div>
            <div>Total</div>
        </div>
        
    </div>
    <div class="total" id="total-amount">Total: ₹0</div>
    <div class="checkout">
        <button onclick="proceedToPayment()">Proceed to Payment</button>
    </div>
    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function generateReceiptNumber() {
            return Math.floor(1000 + Math.random() * 9000);
        }

        function displayDate() {
            const date = new Date();
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function displayCart(items = cart) {
            const cartItemsContainer = document.getElementById('cart-items');
            const totalAmountContainer = document.getElementById('total-amount');
            cartItemsContainer.innerHTML = `
                <div class="receipt-info">
                    <div>Receipt No: ${generateReceiptNumber()}</div>
                    <div>Date: ${displayDate()}</div>
                </div>
                <div class="cart-header">
                    <div>Name</div>
                    <div>Cost</div>
                    <div>Qty</div>
                    <div>Total</div>
                </div>
            `;
            let totalAmount = 0;

            items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.classList.add('cart-item');
                itemElement.innerHTML = `
                    <div>${item.name}</div>
                    <div>Rs ${item.price}</div>
                    <div>${item.qty}</div>
                    <div>Rs ${item.price * item.qty}</div>
                `;
                cartItemsContainer.appendChild(itemElement);
                totalAmount += item.price * item.qty;
            });

            totalAmountContainer.innerText = `Total: Rs ${totalAmount}`;
        }

        function searchCart() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const filteredItems = cart.filter(item => item.name.toLowerCase().includes(input));
            displayCart(filteredItems);
        }

        function proceedToPayment() {
            const cartData = JSON.stringify(cart);
            const formData = new FormData();
            formData.append('cart', cartData);

            fetch('cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                window.location.href = 'payment.html';
            })
            .catch(error => console.error('Error:', error));
        }

        
        function updateCartItem(foodItemId) {
            const foodItem = document.getElementById(foodItemId);
            const updatedPrice = parseFloat(foodItem.value); 

            cart.forEach(item => {
                if (item.id === foodItemId) {
                    item.price = updatedPrice;
                }
            });

            localStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
        }

        document.getElementById('receipt-no').innerText = generateReceiptNumber();
        document.getElementById('current-date').innerText = displayDate();

        displayCart();
    </script>
    <button><a href="order.html" class="back-link">Back to Home</a></button>
</body>
</html>
