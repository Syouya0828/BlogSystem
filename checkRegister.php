<?php
if(isset($_SESSION["isLogin"])){
    $isLogin = $_SESSION["isLogin"];
    $user = $_SESSION["user"];
    $sUserid = $_SESSION['userid'];
    //ログインしているか確かめる
    if($isLogin == True){//ログインできていない場合
        header( "Location: mypage.php" ) ;
    }
}  
$log = '<li><a href="login.php">ログイン</a></li>';