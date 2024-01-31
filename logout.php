<?php
session_start();

if (isset($_SESSION['id']) && $_SESSION['userId']) {
    unset($_SESSION['id']);
    unset($_SESSION['userId']);

    session_destroy();
    
    echo "<script>alert('로그아웃 되었습니다.');</script>";
    echo "<script>location.href = 'frontend/index.php';</script>";
    exit();
}