<?php
if (isset($_GET['postid'])) {
    $post_id = $_GET['postid'];

    include "connect-db.php";
    $query = "SELECT post.title, post.content, post.image, post.timeStamp, user.nickname
            FROM post
            INNER JOIN user ON post.userId = user.userId
            WHERE post.postId = $post_id";

    $result = $mysqli->query($query);
    $rows = array();

    $route = "../images/";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $content = $row['content'];
            $image = $row['image'];
            $timestamp = $row['timeStamp'];
            $nickname = $row['nickname'];
            echo '<p class="info1">' . $nickname . '</p>';
            echo '<p class="info2">' . $timestamp . '</p>';
            echo '<div class="text">';
            echo '<div class="title">' . $title . '</div>';
            echo '<div class="content">' . $content . '</div>';
            if (!empty($image) && file_exists($route . $image)) {
                echo '<div class="image"><img src="' . $route . $image . '"></div>';
            }
            echo '</div>';
        }
    }
}