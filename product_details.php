<?php
session_start();

include 'products_data.php';

$productName = $_GET['name'] ?? '';
$product = null;

foreach ($products as $item) {
    if ($item['name'] === $productName) {
        $product = $item;
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

    $quantity = (int)($_POST['quantity'] ?? 1);

    if ($quantity < 1) {
        $quantity = 1;
    }

    $_SESSION['cart'][] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity
    ];

    $action = $_POST['action'] ?? 'cart';

    // Buy Now → Checkout
    if ($action === 'buy') {
        header("Location: checkout.php");
        exit;
    }

    // Add to Cart → Cart
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

    <title><?= htmlspecialchars($product['name']) ?> - ShopKart</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f3f6;
        }

        .navbar {
            background: #2874f0;
            color: white;
            padding: 14px 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-weight: bold;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 25px auto;
        }

        .product-box {
            background: white;
            display: flex;
            gap: 40px;
            padding: 30px;
            border-radius: 5px;
        }

        .product-left {
            width: 42%;
            text-align: center;
        }

        .product-image {
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            font-size: 150px;
            background: white;
        }

        .product-right {
            width: 58%;
        }

        .product-name {
            font-size: 27px;
            margin-bottom: 15px;
            color: #212121;
        }

        .rating {
            display: inline-block;
            background: #388e3c;
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .category {
            color: #777;
            margin-bottom: 20px;
        }

        .price {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }

        .old-price {
            color: #878787;
            text-decoration: line-through;
            margin-left: 12px;
            font-size: 18px;
        }

        .offer {
            color: #388e3c;
            font-weight: bold;
            margin: 15px 0;
        }

        .description {
            border-top: 1px solid #ddd;
            padding-top: 20px;
            line-height: 1.7;
        }

        .quantity {
            margin: 20px 0;
        }

        .quantity input {
            width: 70px;
            padding: 10px;
            font-size: 16px;
            text-align: center;
        }

        .buttons {
            display: flex;
            gap: 15px;
        }

        .add-cart,
        .buy-now {
            border: none;
            padding: 16px 35px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 3px;
            color: white;
        }

        .add-cart {
            background: #ff9f00;
        }

        .buy-now {
            background: #fb641b;
        }

        .details-box {
            background: white;
            margin-top: 20px;
            padding: 25px;
        }

        .details-box h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }

        .details-box p {
            line-height: 1.7;
        }

        @media (max-width: 768px) {

            .product-box {
                flex-direction: column;
            }

            .product-left,
            .product-right {
                width: 100%;
            }

            .product-image {
                height: 300px;
            }

        }

    </style>

</head>

<body>


<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        ShopKart
    </div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">🛒 Cart</a>
    </div>

</div>


<!-- PRODUCT -->

<div class="container">

    <div class="product-box">


        <!-- LEFT SIDE -->

        <div class="product-left">

            <div class="product-image">

    <?php if ($product['name'] === 'Vivo T4'): ?>

        <img src="images/mobile1.jpg" alt="Product Image" style="width: 300px; height: 300px; object-fit: contain;">

    <?php else: ?>

        <span style="font-size: 120px;">
            <?= htmlspecialchars($product['icon']) ?>
        </span>

    <?php endif; ?>

</div>

        </div>


        <!-- RIGHT SIDE -->

        <div class="product-right">

            <div class="product-name">
                <?= htmlspecialchars($product['name']) ?>
            </div>


            <div class="rating">
                ⭐ 4.3
            </div>


            <div class="category">
                Category:
                <?= htmlspecialchars($product['category']) ?>
            </div>


            <div class="price">

                ₹<?= number_format($product['price']) ?>

                <span class="old-price">
                    ₹<?= number_format($product['price'] + 1000) ?>
                </span>

            </div>


            <div class="offer">
                ✓ Special Price available
            </div>


            <div class="description">

                <h3>Product Description</h3>

                <p>
                    This is a quality product available on ShopKart.
                    You can add this product to your cart or use
                    Buy Now to proceed directly to checkout.
                </p>

            </div>


            <!-- QUANTITY + BUTTONS -->

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


    <!-- PRODUCT DETAILS -->

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

        <p>
            <b>Availability:</b>
            In Stock
        </p>

        <p>
            <b>Delivery:</b>
            Available across India
        </p>

    </div>

</div>

</body>
</html>