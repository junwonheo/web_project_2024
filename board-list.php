<?php
include "connect-db.php";

// post_type
$request_uri = $_SERVER['REQUEST_URI'];
$post_type = "";
if (strpos($request_uri, 'notice-board.php') !== false) {
    $post_type = 0;
} elseif (strpos($request_uri, 'free-board.php') !== false) {
    $post_type = 1;
} elseif (strpos($request_uri, 'market-board.php') !== false) {
    $post_type = 2;
} elseif (strpos($request_uri, 'suggestions-board.php') !== false) {
    $post_type = 3;
} elseif (strpos($request_uri, 'qna-board.php') !== false) {
    $post_type = 4;
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$list_num = 9;
$start = ($page - 1) * $list_num;

$query = "SELECT post.postId, post.title, post.content, post.timeStamp, user.nickname
          FROM post
          INNER JOIN user ON post.userId = user.userId
          WHERE post.postType = $post_type
          ORDER BY post.timeStamp DESC
          LIMIT $start, $list_num";

$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $post_id = $row['postId'];
        $title_summary = substr($row['title'], 0, 25);
        $content_summary = substr($row['content'], 0, 40);
        if (strlen($row['title']) > 25) {
            $title_summary .= "...";
        }
        if (strlen($row['content']) > 40) {
            $content_summary .= "...";
        }
        $timestamp = $row['timeStamp'];
        $nickname = $row['nickname'];

        echo '<a href="free-text.php?postid=' . $post_id . '" class="free-post-link">';
        echo '<article>';
        echo '<h3>' . $title_summary . '</h3>';
        //echo '<p>' . $content_summary . '</p>';
        echo '<p>' . $timestamp . '</p>';
        echo '<p>' . $nickname . '</p>';
        echo '</article>';
        echo '</a>';
    }
}

// pagination
$total_query = "SELECT COUNT(*) AS total_count FROM post WHERE postType = $post_type";
$total_result = $mysqli->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_posts = $total_row['total_count'];
$total_page = ceil($total_posts / $list_num);

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

echo '<div class="pagination">';
if ($page > 1) {
    echo '<a class="pre" href="' . $post_type . '?page=' . ($page - 1) . '">이전</a>';
}
for ($i = 1; $i <= $total_page; $i++) {
    echo '<a class="num" href="' . $post_type . '?page=' . $i . '">' . $i . '</a>';
}
if ($page < $total_page) {
    echo '<a class="next" href="' . $post_type . '?page=' . ($page + 1) . '">다음</a>';
}
echo '</div>';