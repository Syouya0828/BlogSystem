<?php
    session_start();
?>
<link rel="stylesheet" href="css/main.css">
<?php
require_once('headerLogin.php');
require_once('functions.php');

//pvが多い投稿を調べる
function pvPosts(){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM post WHERE post.private=1 order by pv desc limit 5';
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $dbh = null;
        // var_dump($data);
        return $data;
    } catch (PDOException $e) {
        echo '接続失敗'.$e -> getMessage();
        die();
    }
}
//ユーザーIDの引数からユーザー情報を取り出す
function searchPostID($userid){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM user WHERE userid =:id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('id',(int)$userid,PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch();
        $dbh = NULL;
        // var_dump($data);
        return $data;
    } catch (PDOException $eh) {
        print "エラー発生：".$e->getMessage()."</br>";
        die();
    }
}
//最近の投稿 TOP5をDBから取り出す
function recentPosts(){
    $dbh = dbConnect();
    $sql = 'SELECT * FROM post WHERE post.private=:privateNum order by post_date desc limit 5';
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue('privateNum',1,PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll();
    // var_dump($data);
    $dbh = null;
    return $data;
}
//登録されているユーザーが何人いるか調べる
function searchUser(){
    $dbh = dbConnect();
    $sql = 'SELECT count(userid) FROM user';
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch();
    var_dump($data['count(userid)']);
    $dbh = null;
    return $data['count(userid)'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メイン</title>
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
    <div>
    <div class="main">
        <br><h1>"Mylog"<span style="color:gray">とは？</span></h1>
        <h4>
            Mylogとは、誰でも<span style="color:#f8a065">気軽に・簡単に</span>ブログを作成し・投稿できるサービスです。<br>
        </h4>
        <br>
        <h2>            
        <span style="color:gray">今すぐ</span>Mylog<span style="color:gray">を始めよう！</span><br>
        </h2>
        <h4>
            <a class="register" href="register.php">新規登録</a>
        </h4>
        <br>
        <p class="none"> </p>
        <br>
        <h1>最近の投稿</h1>
        <?php
        //ループのカウント
        $count = 1;
        $result = recentPosts();
        ?>
        <div class='recentPosts'>
        <?php
        foreach($result as $data):?>
            <div class='box'>
                <h3><a href="view2.php?post_id=<?=$data['post_id']?>"><?=h(mb_substr($data['title'],0,8)).'...'?></a></h3>
                <?php
                $user = searchPostID($data['userid']);//useridからユーザー情報を呼び出す

                ?>
                <a href="view1.php?userid=<?=$data['userid'];?>&page_num=1"><?=$user["username"]?></a>
                <p class="post_date"><?=$data['post_date']?></p>
            </div>

            <?php
            $count++;
        endforeach;
        ?>
        </div>
        <h1>アクセス数</h1>
        <div class="pvRanking">
        <?php
        $result = pvPosts();
        $count = 1;
        //resultのデータすべてループ
        foreach($result as $data)://もし見た目に内容が必要であれば$data['content']で表示できます?>
            <div class='box'>
            <h2><?=$count?>位</h2>
            <h3><a href="view2.php?post_id=<?=$data['post_id']?>"><?=mb_substr($data['title'],0,8).'...'?></a></h3><!-- 投稿内容に飛ぶリンク -->
            <?php
            $user = searchPostID($data['userid']);//useridからユーザー情報を呼び出す
            // var_dump($user);
            ?>
            <a href="view1.php?userid=<?=$data['userid']?>&page_num=1"><?=$user['username']?></a><!-- ユーザーの投稿ページ -->
            <p><?=$data['pv']?>PV</p>
            </div>
        <?php
        $count++; //ループのカウント
        endforeach;
        ?>
        </div>
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