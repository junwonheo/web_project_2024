<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../connect-db.php";

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $query = "SELECT point FROM user WHERE id='$user_id'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $point = $row['point'];
            echo '<h1 style="margin-left:15px;">보유 포인트: <span id="point">' . $point . 'p</span></h1>';
            echo '<a href=""><article>';
            echo '<h2>닉네임 변경권(100p)</h2>';
            echo '<form id="buy-form" method="post">';
            echo '<button type="submit" id="is_buy_button" name="isBuy" value="true">구매</button>';
            echo '</form>';
            if ($point > 99) {
                echo '<p>구매 가능합니다. 버튼을 눌러주세요.</p></article></a>';
            } else {
                echo '<p>필요 포인트: <span id="pointValue">' . (100 - $point) . '</span>p</p></article></a>';
            }
        }
    }
} else {
    echo '<h1 style="margin-left:15px;">보유 포인트: <span id="point">0p</span></h1>';
    echo '<a href=""><article>';
    echo '<h2>닉네임 변경권(100p)</h2>';
    echo '<p>로그인 후 이용해주세요.</p></article></a>';
}