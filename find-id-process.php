<?php
$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");

$username = $_POST['username'];
$nickname = $_POST['nickname'];

$sql = "select id from user where userName = '{$username}' and nickname = '{$nickname}'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if(isset($row)){
    $resultId = $row['id'];
    echo "<script>alert('아이디: {$resultId}'); location.href='/index.php?board=index'</script>";
}else{
    echo "<script>alert('아이디를 찾을 수 없습니다!'); location.href='/index.php?board=index'</script></script>";
}
?>