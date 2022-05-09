<?php
    session_start();
?>
<link rel="stylesheet" href="css/mypage.css">
<?php
   
require_once("checkLogin.php");

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my page</title>
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
    <div class="main">
        <h1>ようこそ!<?php echo $user?>さん</h1>
        <a class="btn" href="post_page.php">投稿画面</a><br>
        <a class="btn" href="view3.php?page_num=1&userid=".$sUserid>削除・編集画面</a><br>
        <a class="btn" href="view4.php?page_num=1&userid=".$sUserid>日記画面</a>
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