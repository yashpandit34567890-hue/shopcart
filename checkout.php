<?php
session_start();

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$total = 0;

foreach ($cart as $item) {
    $price = (float)($item['price'] ?? 0);
    $quantity = (int)($item['quantity'] ?? 1);
    $total += $price * $quantity;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {

    $name = trim($_POST['customer_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');
    $payment = $_POST['payment'] ?? '';

    if (
        $name === '' || $phone === '' ||
        $address === '' || $city === '' ||
        $pincode === ''
    ) {
        $error = "Please fill all delivery details.";
    }
    elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $error = "Please enter a valid 10-digit mobile number.";
    }
    elseif (!preg_match('/^[0-9]{6}$/', $pincode)) {
        $error = "Please enter a valid 6-digit PIN code.";
    }
    elseif (!in_array($payment, ['COD', 'ONLINE'], true)) {
        $error = "Please select a payment method.";
    }
    elseif ($payment === 'ONLINE') {
        $error = "Online payment is not connected yet. Please select Cash on Delivery.";
    }
    else {
        $order = [
            'order_id' => 'SK' . date('Ymd') . random_int(1000, 9999),
            'customer_name' => $name,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'pincode' => $pincode,
            'payment' => 'Cash on Delivery',
            'items' => $cart,
            'total' => $total,
            'date' => date('d-m-Y h:i A'),
            'status' => 'Order Placed'
        ];

        $_SESSION['last_order'] = $order;

        if (!isset($_SESSION['orders'])) {
            $_SESSION['orders'] = [];
        }

        $_SESSION['orders'][] = $order;

        $_SESSION['cart'] = [];

        header("Location: order_success.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ShopKart - Checkout</title>

<style>
* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    margin: 0;
    background: #f1f3f6;
    color: #222;
}

header {
    background: #172b4d;
    color: white;
    padding: 18px 5%;
    font-size: 25px;
    font-weight: bold;
}

header span {
    color: #ffb02e;
}

.container {
    width: 92%;
    max-width: 1050px;
    margin: 30px auto;
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 22px;
}

.box {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 3px 12px rgba(0,0,0,.06);
}

h2 {
    color: #172b4d;
    margin-top: 0;
}

input, textarea {
    width: 100%;
    padding: 13px;
    margin: 8px 0 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
}

textarea {
    resize: vertical;
    min-height: 85px;
}

label {
    font-weight: bold;
    font-size: 14px;
}

.item {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    padding: 13px 0;
    border-bottom: 1px solid #eee;
}

.total {
    display: flex;
    justify-content: space-between;
    font-size: 21px;
    font-weight: bold;
    color: #16834c;
    margin-top: 20px;
}

.payment-option {
    display: block;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 7px;
    margin: 12px 0;
    cursor: pointer;
}

.payment-option input {
    width: auto;
    margin: 0 8px 0 0;
}

.checkout-btn {
    width: 100%;
    background: #ffb02e;
    color: #172b4d;
    border: none;
    padding: 15px;
    font-size: 17px;
    font-weight: bold;
    border-radius: 7px;
    cursor: pointer;
    margin-top: 15px;
}

.checkout-btn:hover {
    background: #f5a000;
}

.error {
    background: #ffe5e5;
    color: #b00020;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.back {
    display: block;
    margin-top: 20px;
    color: #2874f0;
    text-decoration: none;
}

.small-note {
    color: #777;
    font-size: 12px;
    line-height: 1.5;
}

@media(max-width: 700px) {
    .container {
        grid-template-columns: 1fr;
    }
}
</style>
</head>

<body>

<header>🛒 Shop<span>Kart</span> Checkout</header>

<div class="container">

    <div class="box">
        <h2>Delivery Address 📍</h2>

        <?php if ($error !== ''): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <label>Full Name</label>
            <input type="text" name="customer_name"
                value="<?= htmlspecialchars($_POST['customer_name'] ?? '') ?>"
                placeholder="Enter your full name" required>

            <label>Mobile Number</label>
            <input type="tel" name="phone"
                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                placeholder="10-digit mobile number"
                maxlength="10" required>

            <label>Full Address</label>
            <textarea name="address"
                placeholder="House number, street, area..."
                required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>

            <label>City</label>
            <input type="text" name="city"
                value="<?= htmlspecialchars($_POST['city'] ?? '') ?>"
                placeholder="Enter city" required>

            <label>PIN Code</label>
            <input type="text" name="pincode"
                value="<?= htmlspecialchars($_POST['pincode'] ?? '') ?>"
                placeholder="6-digit PIN code"
                maxlength="6" required>

            <h2>Payment Method 💳</h2>

            <label class="payment-option">
                <input type="radio" name="payment"
                    value="COD" checked>
                Cash on Delivery (COD)
            </label>

            <label class="payment-option">
                <input type="radio" name="payment"
                    value="ONLINE">
                Online Payment
                <p class="small-note">
                    Online payment gateway is not connected yet.
                </p>
            </label>

            <button type="submit" name="place_order"
                class="checkout-btn">
                Place Order →
            </button>

        </form>

        <a href="cart.php" class="back">← Back to Cart</a>
    </div>

    <div class="box">
        <h2>Order Summary 🛍️</h2>

        <?php foreach ($cart as $item): ?>
            <?php
            $price = (float)($item['price'] ?? 0);
            $quantity = (int)($item['quantity'] ?? 1);
            ?>

            <div class="item">
                <span>
                    <?= htmlspecialchars($item['name'] ?? '') ?>
                    × <?= $quantity ?>
                </span>

                <strong>
                    ₹<?= number_format($price * $quantity, 2) ?>
                </strong>
            </div>
        <?php endforeach; ?>

        <div class="total">
            <span>Total Amount</span>
            <span>₹<?= number_format($total, 2) ?></span>
        </div>

        <p class="small-note">
            This is a ShopKart project demo checkout.
            No online payment will be collected.
        </p>
    </div>

</div>

</body>
</html>