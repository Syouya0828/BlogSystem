<?php
if(isset($_SESSION["isLogin"])){
    $isLogin = $_SESSION["isLogin"];
    //ログインしているか確かめる
}

if(isset($_SESSION["isLogin"])){
    $log = '<li><a href="mypage.php">マイページ</a></li><li><a href="logout.php">ログアウト</a></li>';
}else{
    $log = '<li><a href="login.php">ログイン</a></li>';
}
?>