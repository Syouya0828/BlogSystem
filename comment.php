<?php
    session_start();
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
        header("location: view2.php?page_num=1&post_id=");
    } catch (PDOException $e){
        print "エラー:".$e->getMessage()."</br>";
        die();
    }

?>