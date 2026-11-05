<?php
session_start();
if (isset($_POST['place_order'])) {
    $_SESSION['cart'] = [];
    echo "<script>alert('Order placed successfully!'); window.location='index.php';</script>";
    exit;
}

$cart = $_SESSION['cart'] ?? [];

$total = 0;

foreach ($cart as $item) {
    $total += (float)($item['price'] ?? 0);
}

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopCart - Checkout</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        .checkout-container {
            width: 90%;
            max-width: 700px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        h1 {
            text-align: center;
            color: #1d3557;
        }

        .item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #ddd;
        }

        .total {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            margin-top: 20px;
            color: #159447;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            padding: 14px;
            margin-top: 25px;
            background: #1d3557;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background: #0b6e4f;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #1d3557;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="checkout-container">

    <h1>Checkout 🛒</h1>

    <h3>Order Summary</h3>

    <?php foreach ($cart as $item): ?>

        <div class="item">
            <span><?= htmlspecialchars($item['name'] ?? '') ?></span>
            <span>₹<?= number_format((float)($item['price'] ?? 0), 2) ?></span>
        </div>

    <?php endforeach; ?>

    <div class="total">
        Total: ₹<?= number_format($total, 2) ?>
    </div>

    <form method="POST">
    <button type="submit" name="place_order" class="checkout-btn">
        Place Order
    </button>
</form>
        Place Order
    </button>

    <a href="cart.php" class="back">← Back to Cart</a>

</div>

</body>
</html>