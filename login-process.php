<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['username'];
    $pw = $_POST['password'];

    include "connect-db.php";
    $query = "SELECT * FROM user WHERE id = '$id' AND passwd = '$pw'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $id;
        $_SESSION['nickname'] = $row['nickname'];
        $_SESSION['userId'] = $row['userId'];
        echo "<script>location.href = 'frontend/index.php';</script>";
    } else {
        echo "<script>alert('아이디 또는 비밀번호가 존재하지 않습니다.');</script>";
        echo "<script>location.href = 'frontend/login.php';</script>";
    }
}
