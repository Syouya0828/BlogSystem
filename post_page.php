<?php
    session_start();
?>
<link rel="stylesheet" href="css/post.css">
    <?php
        require_once("checkLogin.php");
        require_once("functions.php");
    ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PostPage</title>
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
    <div id='contents'>
        <form id="post-form" method='post' action='post_page.php'>
            <div class="post">
                <input type='text' id='title' name='title' placeholder="タイトルを入力してください"><br>
                <textarea name="content" id="content" cols="120" rows="10" placeholder="内容を入力してください"></textarea>
            </div>

            <br>
            <div class="radio">
                <input class = 'radio' type='radio' name='private' value='1' checked/>公開
                <input class = 'radio' type='radio' name='private' value='2'/>非公開
                <input class = 'radio' type='radio' name='private' value='3'/>限定公開
            </div>

            </br>
        </form>
        <div id='alert'>
            <p id='emptyTitle' class="hide">タイトルが空です</p>
            <p id='lengthTitle' class="hide">タイトルを40文字以下にしてください</p>
            <p id='emptyContent' class="hide">本文が空です</p>
        </div>
        <div>
        <button id='postBtn'>投稿</button>
        </div>


    </div>
    

        <script>
            const post = document.querySelector('#postBtn');
            post.addEventListener('click', ()=> {
                //console.log("ボタン押された");
                var title = document.getElementById('title').value;
                var content = document.getElementById('content').value;
                let hideElement = document.querySelector('.show');
                //console.log(hideElement);
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
            if(content == ""){
                let element = document.querySelector('#emptyContent');
                element.className = 'show';
                return;
            }
            var result = window.confirm("投稿しますか？");
            if(result){
                const form = document.getElementById('post-form');
                form.submit();//POST送信
            }

            }, false);
        </script>

    <?php
    if($_POST){
            $title = $_POST["title"];
            $content = $_POST["content"];
            $private = $_POST["private"];
            $userid = $_SESSION["userid"];
            //echo($userid);
            //sql文
            $sql =  'INSERT INTO
                post(title, content, private, userid, pv)
            VALUES
                (:title, :content, :private, :userid, :pv)';
            try{
                //DBに接続
                $dbh = dbConnect();;
                // $dbh = null;
                //var_dump($dbh);
                // print "接続成功しています";
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':title',$title, PDO::PARAM_STR);
                $stmt->bindValue(':content',$content, PDO::PARAM_STR);
                $stmt->bindValue(':private',$private, PDO::PARAM_INT);
                $stmt->bindValue(':userid',$userid, PDO::PARAM_INT);
                $stmt->bindValue(':pv',0, PDO::PARAM_INT);
                //DBに書き込み
                $stmt->execute();

                $_SESSION['postTitle'] = $title;
                $_SESSION['postContent'] = $content;
                $_SESSION['postPrivate'] = $private;
                header( "Location: post_result.php" ) ;
                $dbh = null;
            }catch (PDOException $e){
                print "エラー:".$e->getMessage()."</br>";
                die();
            }   

    }
    ?>
    <footer>
        <p id="copy">
            &copy;beginner's
        </p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/menu.js"></script>
</body>
</html>