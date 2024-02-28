<?php

$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");
session_start();

if(!isset($_SESSION['nickname'])){
    die("<script>alert('로그인 먼저 해주세요'); location.href='/index.php?board=login';</script>");
}
$result = mysqli_query($conn, "insert into comment (userId, postId, comment) values ('{$_SESSION['userId']}', '{$_POST['postId']}', '{$_POST['comment']}')");
if($result){
    die("<script>alert('댓글을 성공적으로 달았습니다!'); history.back();</script>");
}
else{
    die("<script>alert('댓글 달기에 실패했습니다!'); history.back();</script>");
}

?>