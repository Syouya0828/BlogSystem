<?php
function dbConnect(){
    $user = 'postuser';
    $pass = 'e2k2021';

    try {
        $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
    } catch (PDOException $e) {
        echo '接続失敗'.$e -> getMessage();
        die();
    }
    return $dbh;
}
function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>