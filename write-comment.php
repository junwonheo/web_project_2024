<?php
// 오류 출력 (삭제)
error_reporting(E_ALL);
ini_set("display_errors", 1);
// userId, postId

session_start();

$request_uri = $_SERVER['REQUEST_URI'];
echo "<script>alert('$request_uri')</script>";
echo "<script>alert('0')</script>";
$user_id = $_SESSION['userId'];
$post_id = $_GET['postid'];
$comment = $_POST['comment'];

// current_time
date_default_timezone_set('Asia/Seoul');
$current_time = date('Y-m-d H:i:s');

// post_type
switch ($request_uri) {
    case strpos($request_uri, 'notice-text.php') !== false:
        $post_type = 0;
        break;
    case strpos($request_uri, 'free-text.php') !== false:
        $post_type = 1;
        echo "<script>alert('1');</script>";
        break;
    case strpos($request_uri, 'market-text.php') !== false:
        $post_type = 2;
        break;
    case strpos($request_uri, 'suggestions-text.php') !== false:
        $post_type = 3;
        break;
    case strpos($request_uri, 'qna-text.php') !== false:
        $post_type = 4;
        break;
    default:
        break;
}

$db_host = "localhost";
$db_user = "codesnack";
$db_password = "";
$db_name = "codesnack";

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
$query = "INSERT INTO comment (userId, postId, comment, timeStamp) VALUES('$user_id', '$post_id', '$comment', '$current_time')";
$mysqli->query($query);
echo "<script>alert('2');</script>";
if ($mysqli->affected_rows > 0) {
    echo "<script>alert('3');</script>";
    switch ($post_type) {
        case 0:
            $post_type = "notice-board.php";
            break;
        case 1:
            $post_type = "free-board.php";
            break;
        case 2:
            $post_type = "market-board.php";
            break;
        case 3:
            $post_type = "suggestions-board.php";
            break;
        case 4:
            $post_type = "qna-board.php";
            break;
        default:
            break;
    }
    echo "<script>alert('댓글이 성공적으로 업로드되었습니다');</script>";
    echo "<script>location.href = 'frontend/$post_type?postid=$post_id';</script>";
} else {
    echo "<script>alert('댓글을 등록하는 중에 문제가 발생했습니다. 다시 시도해주세요.');</script>";
}

