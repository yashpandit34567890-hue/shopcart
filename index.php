<?php
session_start();
require_once 'products_data.php';
require_once 'product_image.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Original product indexes
$productIndexes = [];
foreach ($products as $index => $item) {
    $productIndexes[$item['name']] = $index;
}

// Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productName = trim($_POST['product_name'] ?? '');

    foreach ($products as $product) {
        if ($product['name'] === $productName) {
            $_SESSION['cart'][] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
            break;
        }
    }

    header('Location: index.php?q=' . urlencode($_GET['q'] ?? '') . '&added=1');
    exit;
}

// Search
$search = trim($_GET['q'] ?? '');
$searchResults = [];

if ($search !== '') {
    foreach ($products as $product) {
        if (
            stripos($product['name'], $search) !== false ||
            stripos($product['category'], $search) !== false
        ) {
            $searchResults[] = $product;
        }
    }
}

// Cart count
$cartCount = 0;
foreach ($_SESSION['cart'] as $item) {
    $cartCount += (int)($item['quantity'] ?? 1);
}

// Categories
$categories = [
    ['Mobiles', '📱'],
    ['Laptops', '💻'],
    ['Audio', '🎧'],
    ['Smart Watches', '⌚'],
    ['Mens Fashion', '👔'],
    ['Womens Fashion', '👗'],
    ['Shoes', '👟'],
    ['Bags', '🎒'],
    ['Beauty', '💄'],
    ['Home Kitchen', '🏠'],
    ['Toys Games', '🧸'],
    ['Books Stationery', '📚'],
    ['Sports Fitness', '🏋️'],
    ['Accessories', '🔌'],
    ['Gaming', '🎮'],
    ['Automotive', '🚗']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>ShopKart | Online Shopping Store</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: #f3f6fb;
    color: #202b3c;
}

a {
    text-decoration: none;
    color: inherit;
}

/* HEADER */
.header {
    background: #142b4a;
    color: white;
    padding: 17px 6%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.logo {
    font-size: 29px;
    font-weight: bold;
    white-space: nowrap;
}

.logo span {
    color: #ffad32;
}

.search-box {
    display: flex;
    flex: 1;
    max-width: 600px;
    background: white;
    border-radius: 7px;
    overflow: hidden;
}

.search-box input {
    width: 100%;
    padding: 14px;
    border: none;
    outline: none;
    font-size: 14px;
}

.search-box button {
    background: #ffad32;
    color: #142b4a;
    border: none;
    padding: 0 22px;
    font-weight: bold;
    cursor: pointer;
}

.header-links {
    display: flex;
    align-items: center;
    gap: 17px;
    font-size: 14px;
    font-weight: bold;
}

.header-links a:hover {
    color: #ffad32;
}

.cart-link {
    background: #ffad32;
    color: #142b4a !important;
    padding: 11px 15px;
    border-radius: 6px;
}

/* NAVIGATION */
.navbar {
    background: white;
    display: flex;
    justify-content: center;
    gap: 35px;
    padding: 16px;
    box-shadow: 0 3px 9px rgba(0,0,0,0.06);
}

.navbar a {
    font-size: 14px;
    font-weight: bold;
}

.navbar a:hover {
    color: #e99113;
}

/* CATEGORY STRIP */
.category-nav {
    background: white;
    margin-top: 12px;
    padding: 17px 5%;
    display: flex;
    justify-content: space-around;
    gap: 20px;
    overflow-x: auto;
    white-space: nowrap;
}

.category-nav a {
    font-size: 13px;
    font-weight: bold;
    color: #34445b;
}

.category-nav a:hover {
    color: #ed941b;
}

/* NOTICE */
.notice {
    max-width: 1100px;
    margin: 15px auto;
    padding: 13px;
    background: #e1f5e8;
    color: #16733d;
    text-align: center;
    border-radius: 7px;
}

/* HERO */
.hero {
    margin: 25px 5%;
    min-height: 390px;
    padding: 55px 7%;
    border-radius: 17px;
    background: linear-gradient(120deg, #102745, #28558a);
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
    overflow: hidden;
    position: relative;
}

.hero-content {
    max-width: 620px;
    position: relative;
    z-index: 1;
}

.hero-tag {
    display: inline-block;
    background: #ffad32;
    color: #142b4a;
    padding: 9px 17px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 22px;
}

.hero h1 {
    font-size: clamp(34px, 5vw, 55px);
    line-height: 1.15;
    margin-bottom: 17px;
}

.hero h1 span {
    color: #ffbd55;
}

.hero p {
    color: #dce8f6;
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 28px;
}

.hero-buttons {
    display: flex;
    gap: 13px;
    flex-wrap: wrap;
}

.shop-btn {
    display: inline-block;
    background: #ffad32;
    color: #142b4a;
    padding: 14px 23px;
    border-radius: 7px;
    font-weight: bold;
}

.shop-btn:hover {
    background: white;
}

.category-btn {
    display: inline-block;
    border: 1px solid #ffffff;
    color: white;
    padding: 14px 23px;
    border-radius: 7px;
    font-weight: bold;
}

.hero-art {
    font-size: clamp(100px, 17vw, 190px);
    filter: drop-shadow(0 12px 12px rgba(0,0,0,0.2));
}

/* FEATURES */
.features {
    margin: 25px 5%;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

.feature {
    background: white;
    border-radius: 12px;
    padding: 23px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
}

.feature-icon {
    width: 55px;
    height: 55px;
    border-radius: 12px;
    background: #fff3df;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 29px;
    flex-shrink: 0;
}

.feature h3 {
    font-size: 15px;
    margin-bottom: 7px;
}

.feature p {
    color: #788397;
    font-size: 12px;
    line-height: 1.5;
}

/* CATEGORY SECTION */
.section {
    margin: 28px 5%;
    background: white;
    padding: 28px;
    border-radius: 13px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
}

.section-heading {
    margin-bottom: 24px;
}

.section-heading h2 {
    font-size: 25px;
    color: #142b4a;
}

.section-heading p {
    color: #8993a2;
    font-size: 13px;
    margin-top: 7px;
}

.categories {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 17px;
}

.category-card {
    background: #f7f9fc;
    border: 1px solid #edf0f5;
    padding: 23px 10px;
    border-radius: 11px;
    text-align: center;
    transition: 0.25s;
}

.category-card:hover {
    background: #fff5e5;
    border-color: #ffad32;
    transform: translateY(-5px);
    box-shadow: 0 7px 17px rgba(0,0,0,0.07);
}

.category-icon {
    display: block;
    font-size: 37px;
    margin-bottom: 12px;
}

.category-name {
    font-size: 13px;
    font-weight: bold;
    color: #263a56;
}

/* PROMO BANNER */
.promo {
    margin: 28px 5%;
    padding: 30px 5%;
    border-radius: 13px;
    background: linear-gradient(100deg, #fff0d9, #fff9ef);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.promo h2 {
    color: #142b4a;
    font-size: 23px;
    margin-bottom: 9px;
}

.promo p {
    color: #68768a;
    font-size: 14px;
    line-height: 1.6;
}

.promo-icon {
    font-size: 65px;
}

/* SEARCH RESULTS */
.search-section {
    margin: 25px 5%;
    background: white;
    padding: 25px;
    border-radius: 12px;
}

.search-heading {
    margin-bottom: 22px;
}

.search-heading h2 {
    color: #142b4a;
    font-size: 24px;
}

.search-heading p {
    color: #777;
    margin-top: 8px;
    font-size: 14px;
}

.clear-search {
    display: inline-block;
    color: #2874f0;
    font-size: 13px;
    font-weight: bold;
    margin-top: 10px;
}

.products {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

.product {
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 13px;
    text-align: center;
    transition: 0.2s;
}

.product:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.09);
}

.product-img {
    height: 165px;
    background: #f5f7fa;
    border-radius: 7px;
    margin-bottom: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.product-img img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.product-img span {
    font-size: 60px;
}

.product-category {
    color: #888;
    font-size: 11px;
    text-transform: uppercase;
}

.product h3 {
    font-size: 14px;
    min-height: 35px;
    margin: 9px 0;
}

.price {
    color: #16834c;
    font-size: 19px;
    font-weight: bold;
    margin: 12px 0;
}

.cart-btn {
    width: 100%;
    border: none;
    background: #142b4a;
    color: white;
    padding: 11px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.cart-btn:hover {
    background: #315b91;
}

.no-result {
    text-align: center;
    padding: 55px 15px;
    color: #788397;
}

.no-result span {
    display: block;
    font-size: 55px;
    margin-bottom: 15px;
}

/* FOOTER */
footer {
    background: #14243d;
    color: white;
    padding: 40px 6% 20px;
    margin-top: 40px;
}

.footer-content {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 35px;
}

footer h3 {
    color: #ffad32;
    margin-bottom: 15px;
}

footer p,
footer a {
    color: #cbd5e1;
    font-size: 13px;
    line-height: 2;
}

footer a:hover {
    color: white;
}

.copyright {
    text-align: center;
    border-top: 1px solid #45546a;
    padding-top: 18px;
    margin-top: 28px;
}

/* MOBILE */
@media(max-width: 850px) {
    .header {
        justify-content: center;
    }

    .search-box {
        order: 3;
        flex-basis: 100%;
        max-width: none;
    }

    .hero-art {
        font-size: 100px;
    }

    .products {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media(max-width: 600px) {
    .navbar {
        gap: 20px;
    }

    .hero {
        padding: 38px 25px;
        min-height: 330px;
    }

    .hero-art {
        display: none;
    }

    .features {
        grid-template-columns: 1fr;
    }

    .categories {
        grid-template-columns: repeat(2, 1fr);
    }

    .promo-icon {
        font-size: 45px;
    }

    .footer-content {
        grid-template-columns: 1fr;
    }

    .section {
        padding: 20px;
    }

    .search-section {
        padding: 17px;
    }
}

@media(max-width: 380px) {
    .products {
        grid-template-columns: 1fr;
    }

    .header-links {
        font-size: 12px;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<header class="header">

    <a href="index.php" class="logo">
        🛒 Shop<span>Kart</span>
    </a>

    <form class="search-box" method="GET" action="index.php">
        <input
            type="text"
            name="q"
            placeholder="Search mobiles, laptops, fashion..."
            value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
        >
        <button type="submit">Search 🔍</button>
    </form>

    <div class="header-links">
        <a href="login.php">👤 Login</a>
        <a href="cart.php" class="cart-link">
            🛒 Cart (<?= $cartCount ?>)
        </a>
    </div>

</header>

<!-- NAVIGATION -->
<nav class="navbar">
    <a href="index.php">Home</a>
    <a href="products.php">All Products</a>
    <a href="#categories">Categories</a>
    <a href="login.php">My Account</a>
    <a href="cart.php">My Cart</a>
</nav>

<!-- CATEGORY STRIP -->
<div class="category-nav">
    <?php foreach ($categories as $category): ?>
        <a href="category.php?cat=<?= urlencode($category[0]) ?>">
            <?= htmlspecialchars($category[0]) ?>
        </a>
    <?php endforeach; ?>
</div>

<?php if (isset($_GET['added'])): ?>
    <div class="notice">
        ✓ Product successfully added to your cart!
    </div>
<?php endif; ?>

<?php if ($search === ''): ?>

<!-- HOME PAGE - NO PRODUCT CARDS -->

<section class="hero">

    <div class="hero-content">

        <span class="hero-tag">WELCOME TO SHOPKART</span>

        <h1>
            Your Shopping World,
            <span>One Destination.</span>
        </h1>

        <p>
            Discover a world of choices with ShopKart.
            From the latest mobiles and electronics to fashion,
            lifestyle and everyday essentials.
            Everything you need, all in one place.
        </p>

        <div class="hero-buttons">
            <a href="products.php" class="shop-btn">
                Explore Shopping →
            </a>

            <a href="#categories" class="category-btn">
                Browse Categories
            </a>
        </div>

    </div>

    <div class="hero-art">
        🛍️
    </div>

</section>

<!-- FEATURES -->
<section class="features">

    <div class="feature">
        <div class="feature-icon">🔍</div>
        <div>
            <h3>Smart Product Search</h3>
            <p>Find your favourite products easily.</p>
        </div>
    </div>

    <div class="feature">
        <div class="feature-icon">🛒</div>
        <div>
            <h3>Easy Shopping Cart</h3>
            <p>Add and manage your selected items.</p>
        </div>
    </div>

    <div class="feature">
        <div class="feature-icon">📦</div>
        <div>
            <h3>Simple Ordering</h3>
            <p>View your order details after checkout.</p>
        </div>
    </div>

</section>

<!-- CATEGORIES -->
<section class="section" id="categories">

    <div class="section-heading">
        <h2>Explore ShopKart Categories</h2>
        <p>Choose a category and discover what you are looking for.</p>
    </div>

    <div class="categories">

        <?php foreach ($categories as $category): ?>

            <a
                href="category.php?cat=<?= urlencode($category[0]) ?>"
                class="category-card"
            >
                <span class="category-icon">
                    <?= $category[1] ?>
                </span>

                <span class="category-name">
                    <?= htmlspecialchars($category[0]) ?>
                </span>
            </a>

        <?php endforeach; ?>

    </div>

</section>

<!-- PROMO -->
<section class="promo">

    <div>
        <h2>Everything You Need, In One Place!</h2>

        <p>
            Explore our complete collection and find products
            across your favourite shopping categories.
        </p>
    </div>

    <div class="promo-icon">🎁</div>

</section>

<?php else: ?>

<!-- SEARCH RESULTS ONLY -->

<section class="search-section">

    <div class="search-heading">

        <h2>Search Results</h2>

        <p>
            Showing products for:
            <strong><?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?></strong>
        </p>

        <a href="index.php" class="clear-search">
            ← Back to Home
        </a>

    </div>

    <?php if (!empty($searchResults)): ?>

        <div class="products">

            <?php foreach ($searchResults as $product): ?>

                <?php
                $productIndex = $productIndexes[$product['name']] ?? 0;

                $image = getProductImage(
                    $product['category'],
                    $productIndex,
                    $product['name']
                );
                ?>

                <div class="product">

                    <a href="product_details.php?name=<?= urlencode($product['name']) ?>">

                        <div class="product-img">

                            <?php if (!empty($image)): ?>

                                <img
                                    src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                                >

                                <span style="display:none;">
                                    <?= htmlspecialchars($product['icon'] ?? '🛍️') ?>
                                </span>

                            <?php else: ?>

                                <span>
                                    <?= htmlspecialchars($product['icon'] ?? '🛍️') ?>
                                </span>

                            <?php endif; ?>

                        </div>

                    </a>

                    <span class="product-category">
                        <?= htmlspecialchars($product['category']) ?>
                    </span>

                    <h3>
                        <a href="product_details.php?name=<?= urlencode($product['name']) ?>">
                            <?= htmlspecialchars($product['name']) ?>
                        </a>
                    </h3>

                    <p class="price">
                        ₹<?= number_format((float)$product['price']) ?>
                    </p>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="product_name"
                            value="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                        >

                        <button
                            type="submit"
                            name="add_to_cart"
                            value="1"
                            class="cart-btn"
                        >
                            Add to Cart +
                        </button>

                    </form>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="no-result">
            <span>🔎</span>
            <h3>No Products Found!</h3>
            <p>Try another product name or category.</p>
        </div>

    <?php endif; ?>

</section>

<?php endif; ?>

<!-- FOOTER -->
<footer>

    <div class="footer-content">

        <div>
            <h3>🛒 ShopKart</h3>
            <p>
                Your shopping destination for mobiles,
                electronics, fashion and much more.
            </p>
        </div>

        <div>
            <h3>Quick Links</h3>
            <p><a href="index.php">Home</a></p>
            <p><a href="products.php">All Products</a></p>
            <p><a href="cart.php">Shopping Cart</a></p>
            <p><a href="login.php">Login</a></p>
        </div>

        <div>
            <h3>Popular Categories</h3>
            <p><a href="category.php?cat=Mobiles">Mobiles</a></p>
            <p><a href="category.php?cat=Laptops">Laptops</a></p>
            <p><a href="category.php?cat=Audio">Audio</a></p>
            <p><a href="category.php?cat=Shoes">Shoes</a></p>
        </div>

    </div>

    <div class="copyright">
        <p>© <?= date('Y') ?> ShopKart. All Rights Reserved.</p>
    </div>

</footer>

</body>
</html>