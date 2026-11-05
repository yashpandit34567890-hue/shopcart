<?php
session_start();

include 'products_data.php';

$category = $_GET['cat'] ?? 'Products';

$currentProducts = [];

foreach ($products as $product) {

    if ($product['category'] === $category) {
        $currentProducts[] = $product;
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ShopCart - <?= htmlspecialchars($category) ?></title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f7fa;
        }

        header {
            background: #1d3557;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .product {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .product:hover {
            transform: translateY(-5px);
        }

        .product-img {
            font-size: 65px;
            padding: 20px;
        }

        .product h3 {
            font-size: 21px;
        }

        .price {
            color: #159447;
            font-weight: bold;
            font-size: 20px;
            margin: 15px 0;
        }

        .cart-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #1d3557;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .cart-btn:hover {
            background: #0b6e4f;
        }

        .back {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 18px;
            background: #1d3557;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }

    </style>

</head>

<body>

<header>

    <h1>ShopCart 🛒</h1>

    <h2>
        <?= htmlspecialchars($category) ?>
    </h2>

</header>

<div class="container">

    <div class="products">

        <?php if (!empty($currentProducts)): ?>

            <?php foreach ($currentProducts as $product): ?>

                <div class="product">

                    <div class="product-img">
                        <?= $product['icon'] ?>
                    </div>

                    <h3>
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>

                    <p class="price">
                        ₹<?= number_format($product['price']) ?>
                    </p>

                    <form method="POST" action="index.php">

                        <input
                            type="hidden"
                            name="name"
                            value="<?= htmlspecialchars($product['name']) ?>"
                        >

                        <input
                            type="hidden"
                            name="price"
                            value="<?= $product['price'] ?>"
                        >

                        <button
                            type="submit"
                            class="cart-btn"
                        >
                            Add to Cart
                        </button>

                    </form>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <h2>No products found in this category.</h2>

        <?php endif; ?>

    </div>

    <a href="index.php" class="back">
        ← Back to Home
    </a>

</div>

</body>

</html>