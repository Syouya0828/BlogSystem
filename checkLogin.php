<?php
if(isset($_SESSION["isLogin"])){
    $isLogin = $_SESSION["isLogin"];
    $user = $_SESSION["user"];
    $sUserid = $_SESSION['userid'];
    //ログインしているか確かめる
    if($isLogin == False){//ログインできていない場合
        header( "Location: login.php" ) ;
    }
}else{//セッション何もなかった場合
    header( "Location: login.php" ) ;
}    

if(isset($_SESSION["isLogin"])){
    $log = '<li><a href="mypage.php">マイページ</a></li><li><a href="logout.php">ログアウト</a></li>';
}else{
    $log = '<li><a href="login.php">ログイン</a></li>';
}
?>