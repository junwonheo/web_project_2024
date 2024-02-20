<?php
$search = $_GET['search'];

include "connect-db.php";
$query = "SELECT post.*, user.nickname
          FROM post 
          INNER JOIN user ON post.userId = user.userId
          WHERE post.title LIKE '%$search%' OR post.content LIKE '%$search%'
          ORDER BY timeStamp DESC";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $post_type = $row['postType'];
        $post_id = $row['postId'];
        $timestamp = $row['timeStamp'];
        $nickname = $row['nickname'];
        $title_summary = mb_substr($row['title'], 0, 20);
        $content_summary = mb_substr($row['content'], 0, 40);
        if (mb_strlen($row['title']) > 20) {
            $title_summary .= "...";
        }
        if (mb_strlen($row['content']) > 40) {
            $content_summary .= "...";
        }
        $content_summary = str_ireplace($search, "<strong>$search</strong>", $content_summary);

        switch ($post_type) {
            case 0:
                $post_type = "notice-text.php";
                break;
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

        echo '<a href="' . $post_type . '?postid=' . $post_id . '">';
        echo "<article><h3>" . $title_summary . "</h3>" . $content_summary . "<br>";
        echo '<p>' . $timestamp . '</p>';
        echo '<p>' . $nickname . '</p>';
        echo "</article></a>";
    }
} else {
    echo "<article><h2>검색 결과가 없습니다.</h2></article>";
}