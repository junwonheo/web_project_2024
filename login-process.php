<?php
// 오류 출력 (삭제)
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

function searchUser($id, $pw)
{
    $db_host = "localhost";
    $db_user = "codesnack";
    $db_password = "";
    $db_name = "codesnack";

    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

    $query = "SELECT * FROM user WHERE id = '$id' AND passwd = '$pw'";
    $result = $mysqli->query($query);

    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['username'];
    $pw = $_POST['password'];

    $searchResult = searchUser($id, $pw);

    if ($searchResult->num_rows > 0) {
        $_SESSION['id'] = $id;
        echo "<script>location.href = 'frontend/index.php';</script>";
    } else {
        echo "<script>alert('아이디 또는 비밀번호가 존재하지 않습니다.');</script>";
        echo "<script>location.href = 'frontend/login.php';</script>";
    }
}