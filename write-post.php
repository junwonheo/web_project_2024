<?php
session_start();

$user_id = $_SESSION['userId'];
$board = $_POST['board'];
$title = $_POST['title'];
$content = $_POST['content'];
$image = $_FILES['image']['name'];

// current_time
date_default_timezone_set('Asia/Seoul');
$current_time = date('Y-m-d H:i:s');

// image
if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $image = $_FILES['image']['name'];
} else {
    $image = '';
}

// post_type
switch ($board) {
    case 'notice-board':
        $post_type = 0;
        break;
    case 'free-board':
        $post_type = 1;
        break;
    case 'market_board':
        $post_type = 2;
        break;
    case 'suggestions-board':
        $post_type = 3;
        break;
    case 'qna_board':
        $post_type = 4;
        break;
    default:
        break;
}

include "connect-db.php";
$query = "INSERT INTO post (userId, postType, title, content, image, timeStamp) VALUES('$user_id', '$post_type', '$title', '$content', '$image', '$current_time')";
$mysqli->query($query);
if ($mysqli->affected_rows > 0) {
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

    echo "<script>alert('글이 성공적으로 업로드되었습니다.');</script>";
    echo "<script>location.href = 'frontend/$post_type';</script>";
} else {
    echo "<script>alert('글을 등록하는 중에 문제가 발생했습니다. 다시 시도해주세요.');</script>";
}