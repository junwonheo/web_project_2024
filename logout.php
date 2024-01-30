<?php
session_start();

if (isset($_SESSION['id'])) {
    unset($_SESSION['id']);

    session_destroy();
    
    echo "<script>alert('로그아웃 되었습니다.');</script>";
    echo "<script>location.href = 'frontend/index.php';</script>";
    exit();
}