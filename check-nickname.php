<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];

    include "connect-db.php";
    $query = "SELECT * FROM user WHERE nickname='$nickname'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        echo "<p style=\"color: red;\">사용 불가능한 닉네임입니다.</p>";
    } else {
        echo "<p style=\"color: green;\">사용 가능한 닉네임입니다.</p>";
        $_SESSION['nicknameCheck'] = $nickname . 'Check';
    }
}