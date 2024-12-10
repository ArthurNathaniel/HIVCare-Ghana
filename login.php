<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        session_start();
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        header('Location: charts.php');
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
</head>
<body>
<div class="all">
        <div class="swiper_box">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="./images/swiper_1.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="./images/swiper_2.jpg" alt="">
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="forms_all">
          <div class="forms">
          <h1>Admin Login</h1>
          </div>
            <div class="forms">
                <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            </div>
            <form action="login.php" method="POST">
                <div class="forms">
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                <div class="forms">
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="forms">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="./js/swiper.js"></script>
</body>
</html>
