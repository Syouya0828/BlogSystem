<?php
    session_start();
?>

<?php
require_once('checkRegister.php');
require_once('functions.php');

if(isset($_SESSION["isLogin"])){
    $isLogin = $_SESSION["isLogin"];
    $user = $_SESSION["user"];
    $userid = $_SESSION['userid'];
    

    //ログインしているか確かめる
    if($isLogin == True){//ログインできていない場合
        header( "Location: login.php" ) ;
    }
}    

//ユーザーのデータを取ってくる関数
function getUserData($address){
    $data = [];
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM user WHERE address = :address';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
        $dbh = NULL;
        return $data;

    } catch (PDOException $e) {
        print "エラー:".$e->getMessage()."</br>";
        die();
    }
}
//ログインしていた時の処理

?>
<?php
if($_POST){
    // echo("ポスト飛んできた");
    $data = [];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $data = getUserData($address);
    //var_dump($data);
    if(!$data){
        try {
            $dbh = dbConnect();
            $sql = 'INSERT INTO 
                    user(username, password, address)
                VALUES
                    (:username, :password, :address)';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':username',$username, PDO::PARAM_STR);
            $stmt->bindValue(':password',$password, PDO::PARAM_STR);
            $stmt->bindValue(':address',$address, PDO::PARAM_STR);

            $stmt->execute();
            $dbh = null;

            // echo("完了");
            header("Location:registerResult.php");
        } catch (PDOException $e) {
            print "エラー:".$e->getMessage()."</br>";
            die();
        }
        die();
    }else{
        ?>
        <script>
            let element = document.querySelector('#alreadySignedUp');
            element.className = 'show';
        </script>
        <?php
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/register.css" rel="stylesheet" type=text/css>
    <title>登録画面</title>
</head>
<body>
<div class="container">


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
            <div class="signup">新規登録</div>
            <form id="register-form" method="post" action="register.php">
                <div class="inputForm">
                    <input type="address" id="address" name="address" placeholder="メールアドレス"><br>
                    <input type="username" id="username" name="username" placeholder="ユーザーネーム"><br>
                    <input type="password" id="password" name="password" placeholder="パスワード"><br>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="パスワード(確認用)">
                </div>
            </form>
            <!-- エラーメッセージ -->
            <div id='alert'>
                <p id='emptyAddress' class='hide'>メールアドレスを入力してください</p>
                <p id='wrongAddress' class='hide'>メールアドレスが間違っています</p>
                <p id='emptyUsername' class='hide'>ユーザーネームを入力してください</p>
                <p id='emptyPassword' class='hide'>パスワードを入力してください</p>
                <p id='emptyConfPassword' class='hide'>パスワード(確認用)を入力してください</p>
                <p id='doNotMatch' class='hide'>パスワードが一致していません</p>
                <p id='alreadySignedUp' class='hide'>このメールアドレスは既に登録されています</p>
            </div>
            <button id="registerBtn">新規登録</button>
        </div>
        <footer>
        <p id="copy">
            &copy;beginner's
        </p>
        </footer>
    </body>
</div>
</html>
<script>
    const register = document.querySelector('#registerBtn');
    register.addEventListener('click', ()=> {
        let element;
        var reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}.[A-Za-z0-9]{1,}$/;
        var address = document.getElementById('address').value;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirmPassword').value;
        console.log(address + username + password + confirmPassword);
        let hideElement = document.querySelector('.show');
        if(hideElement !== null){
            hideElement.className = 'hide';
        }
        if(address == ""){//メールアドレスが空だった処理
            element = document.querySelector('#emptyAddress');
            element.className = 'show';
            return;
        }
        if(!reg.test(address)){//メールアドレスが正しくなかった時の処理
            element = document.querySelector('#wrongAddress');
            element.className = 'show';
            return;
        }
        if(username == ""){//ユーザー名が空だった処理
            element = document.querySelector('#emptyUsername');
            element.className = 'show';
            return;
        }
        if(password == ""){//パスワードが空だった処理
            element = document.querySelector('#emptyPassword');
            element.className = 'show';
            return;
        }
        if(confirmPassword == ""){//パスワード(確認用)が空だった処理
            element = document.querySelector('#emptyConfPassword');
            element.className = 'show';
            return;
        }
        if(password != confirmPassword){//パスワードが一致しない処理
            element = document.querySelector('#doNotMatch');
            element.className = 'show';
            return;
        }
        const form = document.getElementById('register-form');
        
        form.submit();
    })
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="js/menu.js"></script>