<!-- XXX-text -->
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (isset($_GET['postid'])) {
    $postid = $_GET['postid'];

    $db_host = "localhost";
    $db_user = "codesnack";
    $db_password = "";
    $db_name = "codesnack";

    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
    $query = "SELECT * FROM post WHERE postId=$postid";
    $result = $mysqli->query($query);
    $rows = array();

    $route = "../images/";

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $content = $row['content'];
            $image = $row['image'];
            echo '<div class="title">' . $title . '</div>';
            echo '<div class="content">' . $content . '</div>';
            if (!empty($image) && file_exists($route . $image)) {
                echo '<div class="image"><img src="' . $route . $image . '"></div>';
            }
        }
    }
}