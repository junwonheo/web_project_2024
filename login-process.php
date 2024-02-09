<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['username'];
    $pw = $_POST['password'];

    $db_host = "localhost";
    $db_user = "codesnack";
    $db_password = "";
    $db_name = "codesnack";

    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

    $query = "SELECT * FROM user WHERE id = '$id' AND passwd = '$pw'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['id'] = $id;
        $_SESSION['userId'] = $mysqli->query("SELECT userId FROM user WHERE id = '$id'")->fetch_assoc()['userId'];
        echo "<script>location.href = 'frontend/index.php';</script>";
    } else {
        echo "<script>alert('아이디 또는 비밀번호가 존재하지 않습니다.');</script>";
        echo "<script>location.href = 'frontend/login.php';</script>";
    }
}