<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $id = $_POST['id'];
    $pw = $_POST['password'];
    $confirm_pw = $_POST['confirm-password'];
    $nickname = $_POST['nickname'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    include "connect-db.php";

    if ($pw != $confirm_pw) {
        echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
        echo "<script>window.history.go(-1);</script>";
    } else {
        if (isset($_SESSION['idCheck']) && isset($_SESSION['nicknameCheck'])) {
            $query = "INSERT INTO user (userName, id, passwd, nickname, question, answer) VALUES('$username', '$id', '$pw', '$nickname', '$question', '$answer')";
            $mysqli->query($query);
            if ($mysqli->affected_rows > 0) {
                unset($_SESSION['idCheck']);
                unset($_SESSION['nicknameCheck']);
                echo "<script>alert('회원가입에 성공하였습니다.');</script>";
                echo "<script>location.href = 'frontend/login.php';</script>";
            } else {
                echo "<script>alert('회원가입에 실패하였습니다. 다시 시도해주세요.');</script>";
                echo "<script>location.href = 'frontend/register.php';</script>";
            }
        } else {
            echo "<script>alert('중복 확인이 완료되지 않았습니다.');</script>";
            echo "<script>window.history.go(-1);</script>";
        }
    }
}