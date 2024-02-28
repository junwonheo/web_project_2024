<?php
$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");

session_start();
if(!isset($_SESSION['nickname'])){
    die("<script>alert('로그인 먼저 해주세요!'); window.close();</script>");
}

if(isset($_GET['nickname'])){
    $nickname=$_GET['nickname'];
    $userId = $_SESSION['userId'];

    $sql = "select point from user where userId='$userId'";
    $result = $conn->query($sql);
    if($result){
        if($result->fetch_assoc()['point'] <= 0){
            die("<script>alert('포인트가 부족합니다!'); window.close();</script>");
        }
    }

    $sql = "select nickname from user where nickname = '$nickname'";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        echo "<script>alert('닉네임이 이미 있습니다!')</script>";
    }else{
        $sql = "update user set nickname='$nickname' where userId = '$userId'";
        $result = $conn->query($sql);
        if($result){
            $sql = "update user set point = point - 100 where userId = '$userId'";
            $result = $conn->query($sql);
            $_SESSION['nickname'] = $nickname;
            die("<script>alert('닉네임 변경에 성공했습니다!'); window.close();</script>");
        }else{
            die("<script>alert('닉네임 변경에 실패했습니다!');</script>");
    }
}}
?>

<html>
<head>
    <title>포인트샵</title>
</head>
<body>
<form method="GET">
        <input type="text" name="nickname">
        <input type="submit" value="닉네임 변경">
</form>
</body>
</html>