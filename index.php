<?php
session_start();
include 'products_data.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';

    if ($name !== '' && $price !== '') {
        $_SESSION['cart'][] = [
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    }

    header("Location: cart.php");
    exit;
}

/* All Products */

$allProducts = [

    ['name'=>'Smartphone', 'price'=>19999, 'icon'=>'📱'],
    ['name'=>'Premium Phone', 'price'=>29999, 'icon'=>'📱'],
    ['name'=>'Budget Phone', 'price'=>12999, 'icon'=>'📱'],

    ['name'=>'Gaming Laptop', 'price'=>74999, 'icon'=>'💻'],
    ['name'=>'Student Laptop', 'price'=>45999, 'icon'=>'💻'],
    ['name'=>'Business Laptop', 'price'=>59999, 'icon'=>'💻'],

    ['name'=>'Wireless Headphones', 'price'=>1999, 'icon'=>'🎧'],
    ['name'=>'Bluetooth Speaker', 'price'=>2499, 'icon'=>'🔊'],
    ['name'=>'Wireless Earbuds', 'price'=>1499, 'icon'=>'🎵'],

    ['name'=>'Smart Watch Pro', 'price'=>3999, 'icon'=>'⌚'],
    ['name'=>'Fitness Watch', 'price'=>2999, 'icon'=>'⌚'],
    ['name'=>'Classic Smart Watch', 'price'=>2499, 'icon'=>'⌚'],

    ['name'=>'Men T-Shirt', 'price'=>799, 'icon'=>'👕'],
    ['name'=>'Men Shirt', 'price'=>1299, 'icon'=>'👔'],
    ['name'=>'Men Jeans', 'price'=>1799, 'icon'=>'👖'],

    ['name'=>'Women Dress', 'price'=>1499, 'icon'=>'👗'],
    ['name'=>'Women Top', 'price'=>899, 'icon'=>'👚'],
    ['name'=>'Women Saree', 'price'=>2499, 'icon'=>'🥻'],

    ['name'=>'Running Shoes', 'price'=>1999, 'icon'=>'👟'],
    ['name'=>'Sports Shoes', 'price'=>2499, 'icon'=>'👟'],
    ['name'=>'Casual Shoes', 'price'=>1799, 'icon'=>'👞'],

    ['name'=>'College Backpack', 'price'=>999, 'icon'=>'🎒'],
    ['name'=>'Travel Bag', 'price'=>1799, 'icon'=>'👜'],
    ['name'=>'Laptop Bag', 'price'=>1299, 'icon'=>'💼'],

    ['name'=>'Face Wash', 'price'=>299, 'icon'=>'🧴'],
    ['name'=>'Skin Care Kit', 'price'=>799, 'icon'=>'💄'],
    ['name'=>'Beauty Kit', 'price'=>999, 'icon'=>'💅'],

    ['name'=>'Mixer Grinder', 'price'=>2499, 'icon'=>'🍳'],
    ['name'=>'Electric Kettle', 'price'=>1299, 'icon'=>'☕'],
    ['name'=>'Cookware Set', 'price'=>1999, 'icon'=>'🍲'],

    ['name'=>'Remote Car', 'price'=>899, 'icon'=>'🚗'],
    ['name'=>'Building Blocks', 'price'=>699, 'icon'=>'🧱'],
    ['name'=>'Board Game', 'price'=>599, 'icon'=>'🎲'],

    ['name'=>'Programming Book', 'price'=>599, 'icon'=>'📚'],
    ['name'=>'Notebook Set', 'price'=>299, 'icon'=>'📒'],
    ['name'=>'Pen Set', 'price'=>199, 'icon'=>'🖊️'],

    ['name'=>'Cricket Bat', 'price'=>1999, 'icon'=>'🏏'],
    ['name'=>'Football', 'price'=>799, 'icon'=>'⚽'],
    ['name'=>'Yoga Mat', 'price'=>599, 'icon'=>'🧘'],

    ['name'=>'Mobile Charger', 'price'=>799, 'icon'=>'🔌'],
    ['name'=>'Power Bank', 'price'=>1499, 'icon'=>'🔋'],
    ['name'=>'USB Cable', 'price'=>299, 'icon'=>'🔌'],

    ['name'=>'Gaming Mouse', 'price'=>1299, 'icon'=>'🖱️'],
    ['name'=>'Gaming Keyboard', 'price'=>2499, 'icon'=>'⌨️'],
    ['name'=>'Game Controller', 'price'=>1999, 'icon'=>'🎮'],

    ['name'=>'Car Phone Holder', 'price'=>499, 'icon'=>'🚗'],
    ['name'=>'Car Cleaning Kit', 'price'=>799, 'icon'=>'🧽'],
    ['name'=>'Car Charger', 'price'=>699, 'icon'=>'🔌']
];

/* Search */

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$searchResults = [];

if ($search != '') {

    foreach ($allProducts as $product) {

        if (stripos($product['name'], $search) !== false) {
            $searchResults[] = $product;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ShopKart - Online Shopping</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        /* Navbar */

        .navbar {
            background-color: #222;
            color: white;
            padding: 18px 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        /* Search */

        .search-box {
            background: white;
            padding: 25px;
            text-align: center;
        }

        .search-box form {
            display: flex;
            justify-content: center;
            max-width: 650px;
            margin: auto;
        }

        .search-box input {
            width: 80%;
            padding: 13px;
            border: 1px solid #ccc;
            border-radius: 7px 0 0 7px;
            font-size: 16px;
            outline: none;
        }

        .search-box button {
            padding: 13px 20px;
            border: none;
            background: #1d3557;
            color: white;
            border-radius: 0 7px 7px 0;
            cursor: pointer;
            font-size: 16px;
        }

        .search-box button:hover {
            background: #0b6e4f;
        }

        /* Hero */

        .hero {
            text-align: center;
            padding: 70px 20px;
            background: white;
        }

        .hero h1 {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 20px;
            color: #555;
            margin-bottom: 25px;
        }

        .shop-btn {
            background-color: orange;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Sections */

        .section {
            padding: 40px 50px;
        }

        .section h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Categories */

        .categories {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .category {
            background: white;
            padding: 25px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #ccc;
            text-decoration: none;
            color: #222;
            transition: 0.3s;
        }

        .category:hover {
            transform: translateY(-5px);
            background: #f0f4f8;
        }

        /* Products */

        .products {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            padding: 20px 0;
        }

        .product {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.12);
            transition: 0.3s;
        }

        .product:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.18);
        }

        .product-img {
            height: 150px;
            background: #f5f7fa;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 65px;
            margin-bottom: 15px;
        }

        .product h3 {
            font-size: 21px;
            margin: 10px 0;
        }

        .price {
            color: #159447;
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0 15px;
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
            transition: 0.3s;
        }

        .cart-btn:hover {
            background: #0b6e4f;
            transform: scale(1.03);
        }

        /* No Search Result */

        .no-result {
            text-align: center;
            padding: 30px;
            font-size: 20px;
            color: #555;
        }

        .clear-search {
            display: block;
            width: fit-content;
            margin: 10px auto 25px;
            padding: 10px 20px;
            background: #1d3557;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }

        /* Footer */

        footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }

        /* Mobile */

        @media (max-width: 900px) {

            .products {
                grid-template-columns: repeat(2, 1fr);
            }

            .navbar {
                padding: 18px 20px;
            }

        }

        @media (max-width: 600px) {

            .products {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 32px;
            }

            .section {
                padding: 30px 20px;
            }

            .search-box form {
                width: 100%;
            }

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

            <a href="cart.php">Cart 🛒</a>

            <a href="login.php">Login 👤</a>

            <a href="logout.php">Logout 🚪</a>

        </div>

    </nav>


    <!-- Search -->

    <div class="search-box">

        <form method="GET" action="index.php">

            <input
                type="text"
                name="q"
                value="<?= htmlspecialchars($search) ?>"
                placeholder="Search products..."
                required
            >

            <button type="submit">
                🔍 Search
            </button>

        </form>

    </div>


    <!-- Hero -->

    <section class="hero">

        <h1>
            Welcome to ShopKart
        </h1>

        <p>
            Everything you need, all in one place.
        </p>

        <a href="#categories" class="shop-btn">
            Shop Now
        </a>

    </section>


    <!-- Categories -->

    <section class="section" id="categories">

        <h2>
            Shop by Category
        </h2>

        <div class="categories">

            <a href="category.php?cat=Mobiles" class="category">
                📱 Mobiles
            </a>

            <a href="category.php?cat=Laptops" class="category">
                💻 Laptops & Computers
            </a>

            <a href="category.php?cat=Audio" class="category">
                🎧 Audio
            </a>

            <a href="category.php?cat=Smart Watches" class="category">
                ⌚ Smart Watches
            </a>

            <a href="category.php?cat=Mens Fashion" class="category">
                👕 Men's Fashion
            </a>

            <a href="category.php?cat=Womens Fashion" class="category">
                👗 Women's Fashion
            </a>

            <a href="category.php?cat=Shoes" class="category">
                👟 Shoes
            </a>

            <a href="category.php?cat=Bags" class="category">
                🎒 Bags
            </a>

            <a href="category.php?cat=Beauty" class="category">
                💄 Beauty
            </a>

            <a href="category.php?cat=Home Kitchen" class="category">
                🏠 Home & Kitchen
            </a>

            <a href="category.php?cat=Toys Games" class="category">
                🧸 Toys & Games
            </a>

            <a href="category.php?cat=Books Stationery" class="category">
                📚 Books & Stationery
            </a>

            <a href="category.php?cat=Sports Fitness" class="category">
                🏋️ Sports & Fitness
            </a>

            <a href="category.php?cat=Accessories" class="category">
                🔌 Accessories
            </a>

            <a href="category.php?cat=Gaming" class="category">
                🎮 Gaming
            </a>

            <a href="category.php?cat=Automotive" class="category">
                🚗 Automotive
            </a>

        </div>

    </section>


    <!-- Search Results -->

    <?php if ($search !== ''): ?>

        <section class="section">

            <h2>
                Search Results for "<?= htmlspecialchars($search) ?>"
            </h2>

            <?php if (!empty($searchResults)): ?>

                <div class="products">

                    <?php foreach ($searchResults as $product): ?>

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

                            <form method="POST">

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

                </div>

                <a href="index.php" class="clear-search">
                    ✖ Clear Search
                </a>

            <?php else: ?>

                <div class="no-result">

                    ❌ No product found.

                </div>

                <a href="index.php" class="clear-search">
                    ← Back to Home
                </a>

            <?php endif; ?>

        </section>

    <?php else: ?>


        <!-- Featured Products -->

        <section class="section">

            <h2>
                Featured Products
            </h2>

            <div class="products">


                <!-- Smartphone -->

                <div class="product">

                    <div class="product-img">
                        📱
                    </div>

                    <h3>
                        Smartphone
                    </h3>

                    <p class="price">
                        ₹19,999
                    </p>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="name"
                            value="Smartphone"
                        >

                        <input
                            type="hidden"
                            name="price"
                            value="19999"
                        >

                        <button
                            type="submit"
                            class="cart-btn"
                        >
                            Add to Cart
                        </button>

                    </form>

                </div>


                <!-- Laptop -->

                <div class="product">

                    <div class="product-img">
                        💻
                    </div>

                    <h3>
                        Laptop
                    </h3>

                    <p class="price">
                        ₹49,999
                    </p>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="name"
                            value="Laptop"
                        >

                        <input
                            type="hidden"
                            name="price"
                            value="49999"
                        >

                        <button
                            type="submit"
                            class="cart-btn"
                        >
                            Add to Cart
                        </button>

                    </form>

                </div>


                <!-- Headphones -->

                <div class="product">

                    <div class="product-img">
                        🎧
                    </div>

                    <h3>
                        Headphones
                    </h3>

                    <p class="price">
                        ₹1,999
                    </p>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="name"
                            value="Headphones"
                        >

                        <input
                            type="hidden"
                            name="price"
                            value="1999"
                        >

                        <button
                            type="submit"
                            class="cart-btn"
                        >
                            Add to Cart
                        </button>

                    </form>

                </div>


                <!-- Smart Watch -->

                <div class="product">

                    <div class="product-img">
                        ⌚
                    </div>

                    <h3>
                        Smart Watch
                    </h3>

                    <p class="price">
                        ₹2,999
                    </p>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="name"
                            value="Smart Watch"
                        >

                        <input
                            type="hidden"
                            name="price"
                            value="2999"
                        >

                        <button
                            type="submit"
                            class="cart-btn"
                        >
                            Add to Cart
                        </button>

                    </form>

                </div>

            </div>

        </section>

    <?php endif; ?>


    <!-- Footer -->

    <footer>

        <p>
            © 2026 ShopKart | All Rights Reserved
        </p>

    </footer>

</body>

</html>