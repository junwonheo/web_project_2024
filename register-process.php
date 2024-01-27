<?php
$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");

if(isset($_POST['username'])&&isset($_POST['id'])&&isset($_POST['nickname'])
&&isset($_POST['passwd'])&&isset($_POST['confirm-passwd'])&&isset($_POST['miss'])&&isset($_POST['missQuestion'])){
    $username = $_POST['username'];
    $id = $_POST['id'];
    $nickname = $_POST['nickname'];
    $passwd = $_POST['passwd'];
    $confirmPasswd = $_POST['confirm-passwd'];
    $answer = $_POST['miss'];
    $question = $_POST['missQuestion'];

    if($passwd != $confirmPasswd){
        die("<script>alert('비밀번호가 다릅니다!'); location.href = '/index.php?board=register';</script>");
    }
    $result = mysqli_query($conn,"insert into user (userName, id, passwd, nickname, question, answer, point)
    values ('$username','$id','$passwd','$nickname',CAST('$question' as unsigned),'$answer',500);");
    if($result){
        echo "<script>alert('회원가입 성공!');location.href = '/index.php?board=index';</script>";
    }
    else{
        die("회원가입 실패! $result");
    }
}
?>