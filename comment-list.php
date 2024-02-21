<?php
include "connect-db.php";

// post_type
$request_uri = $_SERVER['REQUEST_URI'];
$post_type = "";
if (strpos($request_uri, 'free-text.php') !== false) {
    $post_type = 1;
} elseif (strpos($request_uri, 'market-text.php') !== false) {
    $post_type = 2;
} elseif (strpos($request_uri, 'suggestions-text.php') !== false) {
    $post_type = 3;
} elseif (strpos($request_uri, 'qna-text.php') !== false) {
    $post_type = 4;
}

$post_id = isset($_GET['postid']) ? $_GET['postid'] : '';

$query = "SELECT comment.comment, comment.Timestamp, user.nickname
          FROM comment
          INNER JOIN post ON comment.postId = post.postId
          INNER JOIN user ON post.userId = user.userId
          WHERE comment.postId = $post_id
          ORDER BY comment.Timestamp DESC";

$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comment = $row['comment'];
        $timestamp = $row['Timestamp'];
        $nickname = $row['nickname'];

        echo '<li><div class="comment_info">';
        echo '<p class="info2">' . $timestamp . '</p>';
        echo '<span class="comment_author">' . $nickname . '</span></div>';
        echo '<div class="comment_text">' . $comment . '</div></li>';
    }
}