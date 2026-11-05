<?php
session_start();

$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - ShopCart</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
        }

        header {
            background: #222;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            background: #222;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<header>
    <h1>🛒 ShopCart</h1>
    <p>Your Shopping Cart</p>
</header>

<div class="container">

    <h2>My Cart</h2>

    <?php if (empty($cart)): ?>

        <div class="empty">
            <h3>Your cart is empty</h3>
            <p>Add some products to your cart.</p>

            <a class="back" href="index.php">Continue Shopping</a>
        </div>

    <?php else: ?>


        <?php $total= 0;?>
        <?php foreach ($cart as $loop_index => $item): ?>
            <?php
$total += (float)($item['price'] ?? 0) * (int)($item['quantity'] ?? 1);
?>

            <div class="cart-item">
                <h3>
                    <?= htmlspecialchars($item['name'] ?? 'Product') ?>
                </h3>

                <p>
                    Price:
                    ₹<?= htmlspecialchars($item['price'] ?? '0') ?>
                </p>
                <p>
                  Quantity: <?= (int)($item['quantity'] ?? 1) ?>
                </p>
                <div>
    <form method="POST" action="update_quantity.php" style="display:inline;">
        <input type="hidden" name="index" value="<?= $loop_index ?>">
        <input type="hidden" name="action" value="decrease">
        <button type="submit">−</button>
    </form>

    <span style="margin: 0 10px;">
        <?= (int)($item['quantity'] ?? 1) ?>
    </span>

    <form method="POST" action="update_quantity.php" style="display:inline;">
        <input type="hidden" name="index" value="<?= $loop_index ?>">
        <input type="hidden" name="action" value="increase">
        <button type="submit">+</button>
    </form>
</div>

                <form method="POST" action="remove.php">
    <input type="hidden" name="name" value="<?= htmlspecialchars($item['name'] ?? '') ?>">
    <button type="submit" class="remove-btn">Remove</button>
</form>
            </div>

        <?php endforeach; ?>
        <div class="cart-total">
    <h2>Total: ₹<?= number_format($total, 2) ?></h2>
    <a href="checkout.php" class="checkout-btn">Checkout</a>
</div>
       

        <a class="back" href="index.php">Continue Shopping</a>

    <?php endif; ?>

</div>

</body>
</html>