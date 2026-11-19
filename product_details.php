<?php
session_start();
include 'products_data.php';
require_once 'product_image.php';

// FIND PRODUCT AND ITS INDEX
$productName = $_GET['name'] ?? '';
$product = null;
$productIndex = 0;

foreach ($products as $index => $item) {
    if ($item['name'] === $productName) {
        $product = $item;
        $productIndex = $index;
        break;
    }
}

if ($product === null) {
    die("Product not found.");
}

// ADD TO CART / BUY NOW
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $quantity = max(1, (int)($_POST['quantity'] ?? 1));

    $_SESSION['cart'][] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity
    ];

    $action = $_POST['action'] ?? 'cart';

    if ($action === 'buy') {
        header("Location: checkout.php");
        exit;
    }

    header("Location: cart.php");
    exit;
}

// GET CORRECT PRODUCT IMAGE
$image = getProductImage(
    $product['category'],
    $productIndex,
    $product['name']
);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($product['name']) ?> - ShopKart</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: #f1f3f6;
    color: #222;
}

.navbar {
    background: #172337;
    color: white;
    padding: 18px 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.logo {
    font-size: 25px;
    font-weight: bold;
    color: #ffcc00;
}

.nav-links a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-size: 15px;
}

.nav-links a:hover {
    color: #ffcc00;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 30px auto;
}

.product-box {
    background: white;
    display: flex;
    gap: 40px;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.product-left {
    width: 45%;
}

.product-image {
    height: 420px;
    background: #f8f8f8;
    border: 1px solid #eee;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 15px;
}

.image-fallback {
    display: none;
    font-size: 130px;
}

.product-right {
    width: 55%;
}

.product-name {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 15px;
}

.category {
    color: #777;
    margin-bottom: 20px;
}

.price {
    font-size: 32px;
    font-weight: bold;
    color: #0b8f45;
    margin: 15px 0;
}

.offer {
    color: #0b8f45;
    font-weight: bold;
    margin: 15px 0;
}

.description {
    border-top: 1px solid #ddd;
    padding-top: 20px;
    margin-top: 20px;
    line-height: 1.8;
}

.quantity {
    margin: 25px 0;
}

.quantity input {
    width: 75px;
    padding: 10px;
    margin-left: 10px;
    font-size: 16px;
}

.buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.add-cart,
.buy-now {
    border: none;
    padding: 16px 25px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 5px;
    color: white;
}

.add-cart {
    background: #ff9f00;
}

.buy-now {
    background: #fb641b;
}

.add-cart:hover {
    background: #fb8c00;
}

.buy-now:hover {
    background: #e85b16;
}

.details-box {
    background: white;
    margin-top: 22px;
    padding: 25px;
    border-radius: 8px;
}

.details-box h2 {
    border-bottom: 1px solid #ddd;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.details-box p {
    line-height: 2;
}

.back-link {
    display: inline-block;
    margin-bottom: 15px;
    color: #172337;
    text-decoration: none;
    font-weight: bold;
}

@media(max-width: 768px) {

    .product-box {
        flex-direction: column;
        padding: 20px;
    }

    .product-left,
    .product-right {
        width: 100%;
    }

    .product-image {
        height: 300px;
    }

    .product-name {
        font-size: 23px;
    }

    .price {
        font-size: 27px;
    }
}

</style>
</head>

<body>

<div class="navbar">

    <div class="logo">🛒 ShopKart</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart 🛒</a>
    </div>

</div>

<div class="container">

    <a href="products.php" class="back-link">
        ← Back to Products
    </a>

    <div class="product-box">

        <div class="product-left">

            <div class="product-image">

                <img
                    src="<?= htmlspecialchars($image) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                >

                <span class="image-fallback">
                    <?= htmlspecialchars($product['icon'] ?? '🛍️') ?>
                </span>

            </div>

        </div>

        <div class="product-right">

            <div class="product-name">
                <?= htmlspecialchars($product['name']) ?>
            </div>

            <div class="category">
                Category:
                <?= htmlspecialchars($product['category']) ?>
            </div>

            <div class="price">
                ₹<?= number_format($product['price']) ?>
            </div>

            <div class="offer">
                ✓ Available on ShopKart
            </div>

            <div class="description">

                <h3>Product Description</h3>

                <p>
                    Explore this product on ShopKart.
                    Check the product category and price,
                    select your required quantity, and add
                    it to your shopping cart.
                </p>

            </div>

            <form method="POST">

                <div class="quantity">

                    <b>Quantity:</b>

                    <input
                        type="number"
                        name="quantity"
                        value="1"
                        min="1"
                    >

                </div>

                <div class="buttons">

                    <button
                        type="submit"
                        name="action"
                        value="cart"
                        class="add-cart">
                        🛒 ADD TO CART
                    </button>

                    <button
                        type="submit"
                        name="action"
                        value="buy"
                        class="buy-now">
                        ⚡ BUY NOW
                    </button>

                </div>

            </form>

        </div>

    </div>

    <div class="details-box">

        <h2>Product Details</h2>

        <p>
            <b>Product:</b>
            <?= htmlspecialchars($product['name']) ?>
        </p>

        <p>
            <b>Category:</b>
            <?= htmlspecialchars($product['category']) ?>
        </p>

        <p>
            <b>Price:</b>
            ₹<?= number_format($product['price']) ?>
        </p>

    </div>

</div>

</body>
</html>