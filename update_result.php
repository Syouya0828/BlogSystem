<?php
    session_start();
?>
<link rel="stylesheet" href="css/update.css">

<?php
    require("checkLogin.php");
    
    if(isset($_SESSION["upId"])){
        if($_SESSION["upId"] == NULL){//ログインできていない場合
            header( "Location: view3.php?page_num=1" ) ;
        }
        $id = $_SESSION["upId"];
        $title = $_SESSION["upTitle"];
        $content = $_SESSION["upContent"];
        $private = $_SESSION["upPrivate"];

        unset($_SESSION["upId"]);
        unset($_SESSION["upTitle"]);
        unset($_SESSION["upContent"]);
        unset($_SESSION["upPrivate"]);

    }else{//セッション何もなかった場合
        header( "Location: view3.php?page_num=1" ) ;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
    <div class="main">
        <h2>更新しました</h2>
        <a class="btn" href="view3.php?page_num=1">戻る</a>
    </div>

</body>
<footer>
        <p id="copy">
            &copy;beginner's
        </p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/menu.js"></script>
</html>