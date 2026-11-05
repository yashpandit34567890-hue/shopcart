<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Products - ShopKart</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f5f5;
        }

        .navbar {
            background: #222;
            color: white;
            padding: 18px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
        }

        .nav-links a:hover {
            color: orange;
        }

        .title {
            text-align: center;
            padding: 40px 20px 20px;
        }

        .title h1 {
            font-size: 35px;
        }

        .products {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            padding: 30px 50px;
        }

        .product {
            background: white;
            width: 230px;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 2px 10px #ccc;
        }

        .product-img {
            height: 160px;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 65px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product h2 {
            margin-bottom: 10px;
        }

        .price {
            color: green;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .cart-btn {
            background: orange;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .cart-btn:hover {
            background: #e69500;
        }

        footer {
            background: #222;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">

        <div class="logo">
            🛒 ShopKart
        </div>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="#">Cart 🛒</a>
            <a href="#">Login</a>
        </div>

    </nav>


    <!-- Page Title -->
    <div class="title">
        <h1>Our Products</h1>
        <p>Choose your favourite product</p>
    </div>


    <!-- Products -->

<?php
include 'products_data.php';
?>

<div class="products">

    <?php foreach ($products as $product): ?>

        <div class="product">

            <a href="product_details.php?name=<?= urlencode($product['name']) ?>"
               style="text-decoration:none; color:inherit;">

                <div class="product-img">
                    <?= htmlspecialchars($product['icon']) ?>
                </div>

                <h2>
                    <?= htmlspecialchars($product['name']) ?>
                </h2>

            </a>

            <p class="price">
                ₹<?= number_format($product['price']) ?>
            </p>

            <form method="POST" action="index.php">

                <input type="hidden"
                       name="name"
                       value="<?= htmlspecialchars($product['name']) ?>">

                <input type="hidden"
                       name="price"
                       value="<?= $product['price'] ?>">

                <button type="submit" class="cart-btn">
                    🛒 Add to Cart
                </button>

            </form>

        </div>

    <?php endforeach; ?>

</div>

    </div>


    <!-- Footer -->
    <footer>
        <p>© 2026 ShopKart | All Rights Reserved</p>
    </footer>

</body>
</html>