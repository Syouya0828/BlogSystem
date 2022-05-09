<?php
    session_start();
?>
<?php
    require_once('headerLogin.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/registerResult.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="logo/logo2.png">
        </div>
        <nav>
            <ul class="nav_header">
                <li>
                    <a href="main.php">メインページ</a>
                </li>
                    <?php echo($log); ?>
            </ul>
        </nav>
            <div class="menu"></div>
            <div class="menu_contents">
                <ul>
                    <li>
                        <a href="main.php">メインページ</a>
                    </li>
                        <?php echo($log); ?>
                </ul>
            </div>
    </header>
    <div id='contents'>
        <h1>登録できました</h1>
        <a href="login.php" class="loginBtn">ログイン</a>
    </div>
    <footer>
    <p id="copy">
        &copy;beginner's
    </p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/menu.js"></script>
</body>
</html>