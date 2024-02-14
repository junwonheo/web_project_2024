<?php
session_start();

$user_id = $_SESSION['userId'];
$post_id = $_GET['postid'];
$comment = $_POST['comment'];

// current_time
date_default_timezone_set('Asia/Seoul');
$current_time = date('Y-m-d H:i:ㅋs');

// post_type
$uri = $_SERVER['HTTP_REFERER'];
$post_type = "";

if (strpos($uri, 'free-text.php') !== false) {
    $post_type = 1;
} elseif (strpos($uri, 'market-text.php') !== false) {
    $post_type = 2;
} elseif (strpos($uri, 'suggestions.php') !== false) {
    $post_type = 3;
} elseif (strpos($uri, 'qna.php') !== false) {
    $post_type = 4;
}

include "connect-db.php";
$query = "INSERT INTO comment (userId, postId, comment, timeStamp) VALUES('$user_id', '$post_id', '$comment', '$current_time')";
$mysqli->query($query);

if ($mysqli->affected_rows > 0) {
    switch ($post_type) {
        case 1:
            $post_type = "free-text.php";
            break;
        case 2:
            $post_type = "market-text.php";
            break;
        case 3:
            $post_type = "suggestions-text.php";
            break;
        case 4:
            $post_type = "qna-text.php";
            break;
        default:
            break;
    }
    echo "<script>alert('댓글이 성공적으로 업로드되었습니다');</script>";
    echo "<script>location.href = 'frontend/$post_type?postid=$post_id';</script>";
} else {
    echo "<script>alert('댓글을 등록하는 중에 문제가 발생했습니다. 다시 시도해주세요.');</script>";
}

