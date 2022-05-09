<?php
function checkPostId(){
    if(!isset($_GET['userid'])){
        header( "Location: ErrorPage.php");
    }
}
function checkPage(){
    if(!isset($_GET['page_num'])){
        header( "Location: ErrorPage.php");
    }
}
?>