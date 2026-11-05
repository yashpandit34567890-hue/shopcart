<?php
session_start();

if (isset($_POST['index']) && isset($_POST['action'])) {

    $index = (int)$_POST['index'];
    $action = $_POST['action'];

    if (isset($_SESSION['cart'][$index])) {

        if ($action === 'increase') {
            $_SESSION['cart'][$index]['quantity']++;
        }

        if ($action === 'decrease') {
            $_SESSION['cart'][$index]['quantity']--;

            if ($_SESSION['cart'][$index]['quantity'] < 1) {
                $_SESSION['cart'][$index]['quantity'] = 1;
            }
        }
    }
}

header("Location: cart.php");
exit;
?>