<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['id'];
    $username = $_POST['username'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $pw = $_POST['password'];
    $new_pw = $_POST['password_re'];

    include "connect-db.php";
    $select_query = "SELECT * FROM user WHERE id='$user_id' AND userName='$username' AND question='$question' AND answer='$answer'";
    $select_result = $mysqli->query($select_query);

    if ($select_result->num_rows > 0) {
        if ($pw != $new_pw) {
            echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
            echo "<script>window.history.go(-1);</script>";
        }
        $update_query = "UPDATE user SET passwd='$new_pw' WHERE id='$user_id'";
        $update_result = $mysqli->query($update_query);
        if ($update_result) {
            echo "<script>alert('비밀번호가 변경되었습니다.');</script>";
            echo "<script>window.location.href = 'frontend/login.php';</script>";
        }

    } else {
        echo "<script>alert('사용자 정보가 옳지 않습니다.');</script>";
        echo "<script>window.history.go(-1);</script>";
    }
}