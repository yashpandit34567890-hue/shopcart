<?php
session_start();

if (isset($_SESSION['cart']) && isset($_POST['name'])) {

    $name = $_POST['name'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if (($item['name'] ?? '') === $name) {
            unset($_SESSION['cart'][$key]);
        }
    }

    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header("Location: cart.php");
exit;
?>