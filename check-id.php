<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    include "connect-db.php";
    $query = "SELECT * FROM user WHERE id='$id'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        echo "<p style=\"color: red;\">사용 불가능한 아이디입니다.</p>";
    } else {
        echo "<p style=\"color: green;\">사용 가능한 아이디입니다.</p>";
        $_SESSION['idCheck'] = $id . 'Check';
    }
}