<?php
session_start();
require_once("headerLogin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/error.css"type="text/css">
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
            </ul>
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
    <div class="contents">
        <h2>ページを表示できません</h2>
        <p>ご指定のページは削除、または、非公開の可能性がございます。もしくは、ご指定のURLが違う可能性がございます。URLを再度お確かめのうえアクセスをお願いいたします。</p>
        <a href="main.php">メインページへ戻る</a>
    </div>
    <footer>
        <p id="copy">&copy;beginner's</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/menu.js"></script>
</body>

</html>