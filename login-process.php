<?php
$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");

session_start();

if(isset($_POST['id'])&&isset($_POST['passwd'])){
    $id=$_POST['id'];
    $passwd=$_POST['passwd'];

    $result=mysqli_query($conn,"select * from user where id = '$id' and passwd = '$passwd'");
    if(mysqli_fetch_assoc($result)){
        $_SESSION['id']=$id;
        echo "<script>location.href='/index.php?page=index.html'</script>";
    }
    else{
        echo "<script>alert('로그인에 실패했습니다!'); location.href='/index.php?page=login.html'</script>";
    }
}

?>