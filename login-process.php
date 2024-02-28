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
        $nickname=mysqli_fetch_assoc(mysqli_query($conn,"select nickname from user where id = '$id'"))['nickname'];
        $_SESSION['nickname']=$nickname;
        $_SESSION['userId']=mysqli_fetch_assoc(mysqli_query($conn,"select userId from user where id = '$id'"))['userId'];
        echo "<script>alert('$_SESSION[nickname]로 로그인했습니다!'); location.href='/index.php?board=index'</script>";
    }
    else{
        echo "<script>alert('로그인에 실패했습니다!'); location.href='/index.php?board=login'</script>";
    }
}

?>