<?php
    session_start();
?>
<?php
require_once("headerLogin.php");
$id=checkId();
require_once("functions.php");
require_once("pvCounter.php");
$by = 5;
// if(isset($_GET['page_num'])){
//     header( "Location: ErrorPage.php");
// }
if (!isset($_GET['page_num'])) {
    header("location: view2.php?page_num=1&post_id=".$id);
}



function checkId(){
    if($_GET['post_id']) {
        $id = $_GET['post_id'];
    }
    if(empty($id)){
        header( "Location: ErrorPage.php");
    }
    return($id);
}
function getComment($by){//コメントのデータを取ってくる
    try {
        $dbh = dbConnect();
        //コメント情報の表示
        $id = $_GET['post_id'];
        $pageNum = $_GET['page_num'] - 1;
        $by = 5;
        $first = $pageNum * $by;
        // $sql = 'SELECT post.*'
        
        $sql = 'SELECT * FROM comment WHERE comment.post_id=:id order by comment.time desc LIMIT :first, :second';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->bindValue(':first',$first, PDO::PARAM_INT);
        $stmt->bindValue(':second',$by, PDO::PARAM_INT);
        //結果を取得
        $stmt->execute();
        $comments =$stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //var_dump($comments);
        $dbh=null;
        //コメントの内容を返す
        return($comments);
    } catch (PDOException $e) {
        print "エラー:".$e->getMessage()."</br>";
        die();
    }

}

function getContents(){
    $dbh=dbConnect();
    try {
        $id = checkId();
        //SQL準備
        $stmt = $dbh->prepare('SELECT * FROM post Where post_id =:id');
        $stmt->bindValue(':id',(int)$id,PDO::PARAM_INT);
        //SQL実行
        $stmt->execute();
        //結果を取得
        $result =$stmt->fetch(PDO::FETCH_ASSOC);
        return($result);
    }catch (PDOException $e){
        print "エラー:".$e->getMessage()."</br>";
        die();
    }  

}

function countComments(){
    $dbh = dbConnect();
    $id = checkId();
    $sql = 'SELECT count(comment.comment) FROM comment WHERE comment.post_id=?';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($id));
    $count =$stmt->fetch(PDO::FETCH_ASSOC);

    return($count);
    
}

function checkUsername($userid){
    $dbh = dbConnect();
    $sql = 'SELECT username FROM user WHERE userid = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue('id',(int)$userid,PDO::PARAM_INT);
    $stmt->execute();
    $username = $stmt->fetch();
    $dbh = NULL;
    // var_dump($username);
    return $username;

}
$result = getContents();
if(!$result){
    exit('このブログは非表示です');
}
if(isset($_SESSION['userid'])){
    $sUserid = $_SESSION['userid'];
}else{
    $sUserid = 0;
}

//もし非公開だった場合
if($result["private"] == 2){
    if($sUserid == $result["userid"]){

    }else{
        echo('    <a href="main.php">戻る</a>');
        exit('この投稿は非公開です');
    }
}
countComments();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/view2.css"type="text/css">
    <title><?=h($result['title'])?>| Mylog</title>

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
                <?php

                ?>
                <h2><?php echo h($result['title']) ?></h2>
                <p id="time">投稿日時:<?=h($result["post_date"]) ?>,最終更新日:<?=h($result["update_date"]) ?></p>
                <p id="main"><?php echo h($result['content']) ?></p> 


                <?php
                    if(isset($_SESSION["isLogin"])){
                        echo('
                            <form id="comment_form" action="view2.php?page_num=1&post_id='.$id.'"method ="POST" name="comment_form" >         
                            <textarea name="comment" id="comment" cols="30" rows="3" size="100" placeholder="コメントする" required></textarea>
                            <br>     
                            </form>
                            <div id="alert">
                            <p id="emptyComment" class="hide">コメントが空です</p>
                            <p id="lengthComment" class="hide">コメントを100文字以下にしてください</p>
                            </div>
                            <div><button id="commentBtn">コメントする</button></div>
                            ');
                     
                     }else{
                         echo('<p>コメントするには<a href="login.php">ログイン</a>が必要です</p>');
                     }

                     //POSTを押された時の処理
                     if($_POST){
                     // echo('押された');
                     $comment = $_POST['comment'];
                     $userid = $_SESSION['userid'];
     
                     //DBに登録
                     try {
                         $dbh = dbConnect();
                         $sql = 'INSERT INTO
                             comment(comment, post_id, userid)
                         VALUES
                             (:comment, :post_id, :userid)';
                         $stmt = $dbh->prepare($sql);
                         $stmt->bindValue(':comment',$comment, PDO::PARAM_STR);
                         $stmt->bindValue(':post_id',$id, PDO::PARAM_INT);
                         $stmt->bindValue(':userid',$userid, PDO::PARAM_INT);
                         //DBに書き込み
                         $stmt->execute();
                         $dbh = null;
                         header("location: view2.php?page_num=1&post_id=".$id);
                         exit;
                     } catch (PDOException $e) {
                         print "エラー:".$e->getMessage()."</br>";
                         die();
                     }
                 }
                    
                ?>
                            <?php 
                            $comments = getComment($by);
                            ?>
                        <div id='comments'>
                            <?php
                            foreach($comments as $value):
                            ?>
                            <div id='comment'>
                                <?php
                                    $username = checkUsername($value['userid']);
                                ?>
                                <div id='details'>
                                <a href="view1.php?page_num=1&userid=<?=$value['userid']?>" id='username'><?php echo($username[0]);?></a>
                                <p id="date"><?=$value['time']?></p>
                                </div>
                                <div>
                                    <?=h($value['comment'])?>
                                </div>

                            </div>
                            <?php endforeach; ?>
                        </div>
                <?php
                    if (!isset($_GET['page_num'])) {
                        $page = 1;
                      } else {
                        $page = $_GET['page_num'];
                      }
                    $count = countComments();
                    $id_sum = $count['count(comment.comment)'];
                    // var_dump($count);
                    // echo($id_sum);
                    $max = ceil($id_sum / $by);
                        if($id_sum > $by):
                            if($page > 1 && $page!=$max):?>
                            <a href="view2.php?page_num=<?php echo ($page-1); ?>&post_id=<?php echo $id; ?>">前へ</a>
                            <a href="view2.php?page_num=<?php echo ($page+1); ?>&post_id=<?php echo $id; ?>">次へ</a>
                            <?php endif;?>
                            <?php if($page == $max): ?>
                            <a href="view2.php?page_num=<?php echo ($page-1); ?>&post_id=<?php echo $id; ?>">前へ</a>
                            <?php endif;?>
                            <?php if($page == 1):?>
                            <a href="view2.php?page_num=<?php echo ($page+1); ?>&post_id=<?php echo $id; ?>">次へ</a>
                            <?php endif; ?>
                            <?php if ($page > $max): 
                                header( "Location: view2.php?page_num=".$max."&post_id=".$id );
                            endif;
                        endif;?> 

                <script>
                    var commentBtn = document.querySelector('#commentBtn');

                    commentBtn.addEventListener('click', ()=>{
                        var comment = document.getElementById('comment').value;
                        let hideElement = document.querySelector('.show');
                        if(hideElement !== null){
                            hideElement.className = 'hide';
                        }

                        if(comment == ""){//コメントが空だった時の処理
                            //console.log('入力してください');
                            let element = document.querySelector('#emptyComment');
                            element.className = 'show';
                            return;
                        }
                        if(comment.length > 20){
                            let element = document.querySelector('#lengthComment');
                            element.className = 'show';
                            return;
                        }
                            const form = document.getElementById('comment_form');
                            form.submit();

                    }, false);
                </script>



            </div>

    </div>
</body>
<footer>
                <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                <p id="copy">&copy;beginner's</p>
</footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/menu.js"></script>
</html>