<?php
    //ログアウト機能
    session_start();
    $_SESSION = array();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト画面</title>
</head>
<body>
    <?php    
        header( "Location: mypage.php" ) ;
    ?>
</body>
</html>