<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_host = "localhost";
    $db_user = "codesnack";
    $db_password = "";
    $db_name = "codesnack";

    $nickname = $_POST['nickname'];

    $db_host = "localhost";
    $db_user = "codesnack";
    $db_password = "";
    $db_name = "codesnack";

    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

    $query = "SELECT * FROM user WHERE nickname='$nickname'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        echo "<p style=\"color: red;\">사용 불가능한 닉네임입니다.</p>";
    } else {
        echo "<p style=\"color: green;\">사용 가능한 닉네임입니다.</p>";
    }
}