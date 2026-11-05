<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (
        isset($_SESSION['user']) &&
        $_SESSION['user']['email'] === $email &&
        $_SESSION['user']['password'] === $password
    ) {
        $_SESSION['logged_in'] = true;

        echo "<script>alert('Login successful!'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Invalid email or password!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopCart - Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        .login-container {
            width: 90%;
            max-width: 400px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        h1 {
            text-align: center;
            color: #1d3557;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #1d3557;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-btn:hover {
            background: #0b6e4f;
        }

        .register {
            text-align: center;
            margin-top: 20px;
        }

        .register a {
            color: #1d3557;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="login-container">

    <h1>ShopCart Login 🛒</h1>

    <form method="POST">

        <input type="tel" name="Phone" placeholder="Enter Phone Number"maxlength="10" required>

        <input type="password" name="password" placeholder="Enter Password" required>

        <button type="submit" class="login-btn">
            Login
        </button>

    </form>

    <div class="register">
        Don't have an account?
        <a href="register.php">Register</a>
    </div>

</div>

</body>
</html>