<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $_SESSION['user'] = [
            'name' => $name,
            'email' => $phone,
            'password' => $password
        ];

        echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopCart - Register</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        .register-container {
            width: 90%;
            max-width: 400px;
            margin: 60px auto;
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

        .register-btn {
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

        .register-btn:hover {
            background: #0b6e4f;
        }

        .login {
            text-align: center;
            margin-top: 20px;
        }

        .login a {
            color: #1d3557;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="register-container">

    <h1>Create Account 🛒</h1>

    <form method="POST">

        <input type="text" name="name" placeholder="Enter Name" required>

        <input type="tel" name="Phone" placeholder="Enter Phone Number" maxlength="10"required>

        <input type="password" name="password" placeholder="Enter Password" required>

        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <button type="submit" class="register-btn">
            Register
        </button>

    </form>

    <div class="login">
        Already have an account?
        <a href="login.php">Login</a>
    </div>

</div>

</body>
</html>