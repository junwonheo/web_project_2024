<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nickname = $_POST['nickname'];

    include "connect-db.php";
    $query = "SELECT id FROM user WHERE userName='$username' AND nickname='$nickname'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        echo "<script>alert('사용자 ID는 " . $user_id . " 입니다.');</script>";
        echo "<script>location.href = 'frontend/login.php';</script>";
    } else {
        echo "<script>alert('이름 또는 닉네임이 존재하지 않습니다.');</script>";
        echo "<script>location.href = 'frontend/fing-id.php';</script>";
    }
}