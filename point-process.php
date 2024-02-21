<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "connect-db.php";
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $query = "SELECT point FROM user WHERE id='$user_id'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $point = $row['point'];
            echo '<h1>보유 포인트: <span id="point">' . $point . '</span></h1>';
        }
    }
}

// else {
//     echo "<script>alert('로그인 후 이용해주세요.');</script>";
//     echo "<script>location.href = 'frontend/pointshop.php';</script>";
// }

// $is_buy = $_POST['isBuy'];


// if($is_buy === true){

// }
