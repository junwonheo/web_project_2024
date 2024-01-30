<?php
// 오류 출력 (삭제)
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

$id = $_POST['id'];
$post_type = $_POST['board'];
$title = $_POST['title'];
$content = $_POST['content'];
$image = $_FILES['image']['name'];
$current_time = date('Y-m-d H:i:s');

echo "<script>alert('$id, $post_type, $title, $content, $image, $current_time');</script>";

$db_host = "localhost";
$db_user = "codesnack";
$db_password = "";
$db_name = "codesnack";

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

$query = "INSERT INTO post (userId, postType, title, content, timeStamp) VALUES('$id', '$post_type', $title', '$content', '$current_time')";
$mysqli->query($query);

if ($mysqli->affected_rows > 0) {
    echo "<script>alert('글이 성공적으로 업로드되었습니다');</script>";
    echo "<script>history.back();</script>";
} else {
    echo "<script>alert('글을 등록하는 중에 문제가 발생했습니다. 다시 시도해주세요.');</script>";
}
// 오류 출력 (삭제)
$err = error_reporting(E_ALL);
ini_set("display_errors", 1);
echo "<script>alert('$err');</script>";