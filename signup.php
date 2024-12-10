<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $password])) {
        header('Location: login.php');
        exit;
    } else {
        $error = "Username already exists!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
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
          <h1>Admin Signup</h1>
          </div>
            <div class="forms">
                <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            </div>
            <form action="signup.php" method="POST">
                <div class="forms">
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                <div class="forms">
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="forms">
                    <button type="submit">Sign Up</button>
                </div>
            </form>
        </div>
    </div>

    <script src="./js/swiper.js"></script>
</body>

</html>