<?php
session_start();

if (isset($_SESSION['id'])) {
    echo "<script>location.href = 'frontend/write-post-page.php';</script>";
} else {
    echo "<script>alert('로그인 후 이용해주세요.');</script>";
    echo "<script>location.href = 'frontend/login.php';</script>";
}