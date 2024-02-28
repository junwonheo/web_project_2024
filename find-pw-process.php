<?php
$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");

$id = $_POST['id'];
$userName = $_POST['userName'];
$question = $_POST['question'];
$answer = $_POST['answer'];
$password = $_POST['password'];
$password_re = $_POST['password_re'];

$sql = "select * from user where id = '{$id}' and userName = '{$userName}'
 and question = '{$question}' and answer = '{$answer}'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if(isset($row)){
    if($password !== $password_re){
        die("<script>alert('비밀번호가 다릅니다'); location.href='/index.php?board=find-pw'</script>");
    }
    $sql = "update user set passwd = '{$password}' where id = '{$id}'";
    $result = $conn->query($sql);
    if($result){
        die("<script>alert('비밀번호를 변경했습니다'); location.href='/index.php?board=index'</script>");
    }
}else{
    die("<script>alert('계정을 찾을 수 없습니다'); location.href='/index.php?board=find-pw'</script>");
}
?>