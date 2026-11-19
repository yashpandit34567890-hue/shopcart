<?php
session_start();
include 'products_data.php';
require_once 'product_image.php';

// ADD TO CART
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {

    $productName = $_POST['product_name'] ?? '';
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));

    foreach ($products as $item) {
        if ($item['name'] === $productName) {

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $_SESSION['cart'][] = [
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $quantity
            ];

            header("Location: cart.php");
            exit;
        }
    }

    header("Location: products.php?error=1");
    exit;
}
?>

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
    background: #f1f3f6;
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

.navbar a {
    color: white;
    text-decoration: none;
    margin-left: 18px;
    font-size: 15px;
}

.navbar a:hover {
    color: #ffcc00;
}

.heading {
    padding: 25px 5%;
    font-size: 25px;
    color: #172337;
}

.products {
    padding: 10px 5% 40px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.card {
    background: white;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.16);
}

.image-box {
    width: 100%;
    height: 190px;
    margin-bottom: 12px;
    background: #f7f7f7;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    overflow: hidden;
}

.card img {
    width: 100%;
    height: 190px;
    object-fit: contain;
}

.image-fallback {
    display: none;
    width: 100%;
    height: 190px;
    align-items: center;
    justify-content: center;
    font-size: 75px;
}

.card h3 {
    font-size: 16px;
    margin: 10px 0;
    min-height: 38px;
}

.price {
    color: #0b8f45;
    font-size: 19px;
    font-weight: bold;
    margin: 10px;
}

.card button {
    background: #ff9f00;
    border: none;
    padding: 11px 18px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    margin-top: 10px;
    width: 100%;
}

.card button:hover {
    background: #fb8c00;
}

@media(max-width: 900px) {
    .products {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media(max-width: 500px) {
    .products {
        grid-template-columns: 1fr;
    }
}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo">🛒 ShopKart</div>

    <div>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart 🛒</a>
        <a href="login.php">Login</a>
    </div>
</div>

<h2 class="heading">Explore All Products</h2>

<?php if (isset($_GET['error'])): ?>
<p style="color:red; text-align:center;">
    Product not found. Please try again.
</p>
<?php endif; ?>

<div class="products">

<?php $i = 0; ?>

<?php foreach ($products as $product): ?>

<div class="card">

    <a href="product_details.php?name=<?php echo urlencode($product['name']); ?>">
        <div class="image-box">

            <img
                src="<?php echo htmlspecialchars(getProductImage($product['category'], $i, $product['name'])); ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>"
                loading="lazy"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >

            <div class="image-fallback">
                <?php echo htmlspecialchars($product['icon'] ?? '🛍️'); ?>
            </div>

        </div>
    </a>

    <h3>
        <a href="product_details.php?name=<?php echo urlencode($product['name']); ?>"
           style="color:#222; text-decoration:none;">
            <?php echo htmlspecialchars($product['name']); ?>
        </a>
    </h3>

    <div class="price">
        ₹<?php echo number_format($product['price']); ?>
    </div>

    <form method="POST" action="products.php">
        <input type="hidden" name="product_name"
               value="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>">

        <input type="hidden" name="quantity" value="1">

        <button type="submit" name="add_to_cart" value="1">
            🛒 Add to Cart
        </button>
    </form>

</div>

<?php $i++; ?>
<?php endforeach; ?>

</div>

</body>
</html>