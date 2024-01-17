<?php
session_start();
$host = "localhost";
$user = "codesnack";
$password = "codesnack";
$dbname = "codesnack";

$mysqli = new mysqli($host, $user, $password, $dbname);

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM user WHERE userId = '$username' AND passwd = '$password'";
$result = $mysqli->query($query);  // 쿼리 전송
$array = $result->fetch_array(MYSQLI_ASSOC);  // 쿼리 결과 연관배열로 저장

if($array != null) {
    $_SESSION['username'] = $array['username'];
    $_SESSION[''] = $array[''];
    echo "<script>location.replace('index.php');</script>";
    exit;
} else {
    echo "<script>alert('아이디 또는 패스워드가 존재하지 않습니다.')</script>";
    echo "<script>location.replace('login.php');</script>";
    exit;
}

?>