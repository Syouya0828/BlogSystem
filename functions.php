<?php
function dbConnect(){
    require './vendor/autoload.php';

    Dotenv/Dotenv::createImmutable(__DIR__)->load();

    $user = $_ENV['user'];
    $pass = $_ENV['pass'];

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