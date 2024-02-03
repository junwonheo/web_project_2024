<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$db_host = "localhost";
$db_user = "codesnack";
$db_password = "";
$db_name = "codesnack";

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
$query = "SELECT * FROM post";
$result = $mysqli->query($query);
$rows = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}
?>

<form>
    <div class="text">
        <div class="title"> <!-- 차례대로 -->
            <?php echo $rows[5]['title']; ?>
        </div>
        <div class="content">
            <?php echo $rows[5]['content']; ?>
        </div>
        <div class="image"> <!-- 이미지 가져오기 수정 -->
            <?php echo $rows[5]['image']; ?>
        </div>
    </div>
</form>