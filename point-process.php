<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "connect-db.php";

if (isset($_SESSION['id']) && isset($_POST['newNickname'])) {
    $user_id = $_SESSION['id'];
    $new_nickname = $_POST['newNickname'];
    
    $point_query = "SELECT point FROM user WHERE id='$user_id'";
    $point_result = $mysqli->query($point_query);

    if ($point_result && $point_result->num_rows > 0) {
        $row = $point_result->fetch_assoc();
        $point = $row['point'];

        if ($point >= 100) {
            $new_point = $point - 100;
            $update_query = "UPDATE user SET point='$new_point', nickname='$new_nickname' WHERE id='$user_id'";
            $update_result = $mysqli->query($update_query);

            if ($update_result) {
                $_SESSION['nickname'] = $new_nickname;
                echo "<script>alert('닉네임이 변경되었습니다.'); window.location.href = 'pointshop.php';</script>";
                exit;
            } else {
                echo "<script>alert('쿼리 실행 중 오류가 발생했습니다.');</script>";
            }
        } else {
            echo "<script>alert('포인트가 부족합니다.');</script>";
        }
    } else {
        echo "<script>alert('사용자 정보를 가져오는 중 오류가 발생했습니다.');</script>";
    }
} else {
    echo "<script>alert('요청이 올바르지 않습니다.');</script>";
}