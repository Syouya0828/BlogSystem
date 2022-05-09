<?php
    session_start();
?>
<link rel="stylesheet" href="css/view3.css">

<?php
require_once('checkLogin.php');
require_once('functions.php');

//phpinfo();
$userId = $_GET['userid'];
$pageNum = $_GET['page_num'] - 1;
$by = 4;

if($userId != $sUserid){
    header( "Location: view3.php?page_num=1&userid=".$sUserid ) ;
}
function getUserData($userid){
    try {
        $dbh = dbConnect();
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = 'SELECT username FROM user WHERE userid = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('id',(int)$userid,PDO::PARAM_INT);
        $stmt->execute();
        $username = $stmt->fetch();
        $dbh = NULL;
        // var_dump($username);
        $dbh = null;
        return $username;
    } catch (PDOException $e) {
        print "エラー発生：".$e->getMessage()."</br>";
        die();
    }
}
try {
    $dbh = dbConnect();
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //プリペアドステートメント
    $stmt = $dbh->prepare('select post.* from post,user where post.userid=? and post.userid=user.userid order by post.post_id limit ?, ?');
    $stmt->execute(array($userId, $pageNum * $by, $by));
    $result = $stmt->fetchAll();

    $count = $dbh->prepare('select count(post.post_id) from post,user where post.userid=? and post.userid=user.userid' );
    $count->execute(array($userId));
    $cnt = $count->fetch(PDO::FETCH_NUM);

    $dbh = null;

} catch (PDOException $e) {
    print "エラー発生：".$e->getMessage()."</br>";
    die();
}

$id_sum = $cnt[0]; //総数
$max = ceil($id_sum / $by); //ページの最大値

if (!isset($_GET['page_num'])) {
    $page = 1;
  } else {
    $page = $_GET['page_num'];
  }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/view.css" rel="stylesheet" type=text/css>
    <title>閲覧ページ</title>
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
<div class=contents>
    <?php
        $username = getUserData($userId);
        // var_dump($username);
    ?>
    <p class="page"><?= $username['username'] ?>のブログ</p>
    <?php foreach($result as $content): ?>
    <div>
        <h2><a class="title" href="view2.php?page_num=1&post_id=<?= h($content["post_id"]) ?>"><?= h($content["title"]) ?></a></h2>
        <p class="content"><?= h(mb_substr($content['content'],0,20)).'…'; ?></p>
        <p class="date">投稿日:<?= h($content["post_date"]) ?> 最終更新日:<?=h($content["update_date"]) ?></p>
        <a href="update.php?post_id=<?=h($content["post_id"])?>">更新</a> <a href="delete.php?post_id=<?=h($content["post_id"])?>">削除</a>
    </div>
    <?php endforeach; ?>

    <?php if($id_sum > $by): ?>
    <?php  if ($page > 1 && $page!=$max): ?>
    <a href="view3.php?page_num=<?php echo ($page-1); ?>&userid=<?php echo $userId; ?>">前へ</a>
    <a href="view3.php?page_num=<?php echo ($page+1); ?>&userid=<?php echo $userId; ?>">次へ</a>
    <?php endif; ?>
    <?php  if ($page == $max): ?>
    <a href="view3.php?page_num=<?php echo ($page-1); ?>&userid=<?php echo $userId; ?>">前へ</a>
    <?php endif; ?>
    <?php  if ($page == 1): ?>
    <a href="view3.php?page_num=<?php echo ($page+1); ?>&userid=<?php echo $userId; ?>">次へ</a>
    <?php endif; ?>
    <?php if ($page > $max): 
        header( "Location: view3.php?page_num=".$max."&userid=".$sUserid );
    endif;
    ?>
    
    <?php endif; ?>
    
    <br>
    <?php echo '全'.$id_sum.'件' ; ?>
</div>
<footer>
<p id="copy">
    &copy;beginner's
</p>
</footer>
</body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/menu.js"></script>
</html>