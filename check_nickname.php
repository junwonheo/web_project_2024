<?php
$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");

if(isset($_GET['nickname'])){
    $id=$_GET['nickname'];
    $result=mysqli_query($conn,"select * from user where id='$id';");
    $row=mysqli_fetch_assoc($result);
    if($row){
        echo "닉네임이 이미 있습니다.";
    }
    else{
        echo "<script>opener.document.getElementById('nickname').value='{$id}';window.close();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>닉네임 중복 확인</title>
</head>
<body>
    <form method="GET">
        <input type="text" name="nickname">
        <input type="submit" value="중복확인">
    </form>
</body>
</html>