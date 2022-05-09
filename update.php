<?php
    session_start();
?>

<?php
require_once("checkLogin.php");
require_once("functions.php");
//もしGETのidが不正だった場合
if(empty($_GET['post_id'])){
    // echo('不正だよー');
    $_GET['post_id'] = NULL;
    exit('PostIDが不正です');
}
$id = h($_GET['post_id']);

//ポスト
if($_POST) {
    $title = h($_POST['title']);
    $content = h($_POST['content']);
    $private = h($_POST['private']);
    //echo($id);
    try {
        $sql = "UPDATE post SET title = :title, content = :content, private = :private, update_date = NOW() WHERE post_id = :id";
        $dbh = dbConnect();
        $stmt = $dbh->prepare($sql);
    
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->bindValue(':title',$title, PDO::PARAM_STR);
        $stmt->bindValue(':content',$content, PDO::PARAM_STR);
        $stmt->bindValue(':private',$private, PDO::PARAM_INT);
        
        $stmt->execute();

        $_SESSION['upId'] = $id;
        $_SESSION['upTitle'] = $title;
        $_SESSION['upContent'] = $content;
        $_SESSION['upPrivate'] = $private;

        header("Location: update_result.php");

    } catch (PDOException $e) {
        print "エラー発生：".$e->getMessage()."</br>";
        die();
    }
}

//echo($id);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/update.css">
    <title>更新画面</title>
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
    <?php
        try {
            $dbh = dbConnect();
            $sql = 'SELECT * FROM post WHERE post_id =:id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue('id',(int)$id,PDO::PARAM_INT);
            $stmt->execute();
            //var_dump($stmt);
            $data = $stmt->fetch();
            //var_dump($data);
            $dbh = NULL;
            $sql = NULL;
        } catch (PDOException $e) {
            print "エラー発生：".$e->getMessage()."</br>";
            die();
        }
        //投稿者のIDとセッションのIDが同じか
        if($data['userid'] != $sUserid){
            header( "Location: view3.php?page_num=1&userid=".$sUserid ) ;
        }
        $action = 'update.php?post_id='.$id;
    ?>
    <div id='contents'>
        <form id="edit-form" method='post' action="<?=$action?>">
            <div class="post">
                <input type="text" id='title' name='title' value='<?=$data['title']?>'><br>
                <textarea name="content" id="content" cols="120" rows="10" placeholder="内容を入力してください"><?=$data['content']?></textarea>
            </div>
            <br>
            <div class="radio">
                <input id = 'release' class = 'radio' type='radio' name='private' value='1'/>公開
                <input id = 'private' class = 'radio' type='radio' name='private' value='2'/>非公開
                <input id = 'limited' class = 'radio' type='radio' name='private' value='3'/>限定公開
            </div>

            <br>
            <!-- <input type="submit" name='update' value='更新'> -->
        </form>
        <div id='alert'>
            <p id='emptyTitle' class="hide">タイトルが空です</p>
            <p id='lengthTitle' class="hide">タイトルを40文字以下にしてください</p>
            <p id='emptyContent' class="hide">本文が空です</p>
        </div>
            <button id="submitBtn">更新</button>
    </div>
    <script>
        const privateNum = '<?php echo($data['private']); ?>';
        // console.log(typeof privateNum);
        let element;
        switch (privateNum) {
            case '1':
                element = document.getElementById('release');
                console.log(element);
                element.checked = true;
                break;
        
            case '2':
                element = document.getElementById('private');
                console.log(element);
                element.checked = true;
                break;
            
            case '3':
                element = document.getElementById('limited');
                console.log(element);
                element.checked = true;
                break;
        }
    </script>
    <script>
        const submit = document.querySelector('#submitBtn');
        submit.addEventListener('click', ()=> {
            var title = document.getElementById('title').value;
            let hideElement = document.querySelector('.show');
            console.log(hideElement);
            if(hideElement !== null){
                hideElement.className = 'hide';
            }
            if(title == ""){
                let element = document.querySelector('#emptyTitle');
                element.className = 'show';
                return;
            }
            if(title.length > 40){
                let element = document.querySelector('#lengthTitle');
                element.className = 'show';
                return;
            }
            if(document.getElementById('content').value == ""){
                let element = document.querySelector('#emptyContent');
                element.className = 'show';
                return;
            }
            

            var result = window.confirm('本当に更新しますか？');
            console.log(result);
            if(result) {
                const form = document.getElementById('edit-form');
                form.submit();

            }
        }, false);
    </script>
    <footer>
        <p id="copy">
            &copy;beginner's
        </p>
    </footer>
</body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/menu.js"></script>
</html>