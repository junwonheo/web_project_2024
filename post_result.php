<?php
$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");

session_start();

if(!isset($_SESSION['nickname'])){
    die("<script>alert('로그인 먼저 해주세요'); location.href='/index.php?board=login';</script>");
}
$image='';
$userId=$_SESSION['userId'];
$board=$_POST['board'];
$title=$_POST['title'];
$content=$_POST['content'];
if (isset($_FILES['image'])) {
    $defaultPath = 'uploads/';
    $tempPath = $_FILES['image']['tmp_name'];
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = 'image_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.' . $extension;
    $filePath = $defaultPath . $filename;

    if (move_uploaded_file($tempPath, $filePath)) {
        $image = $filePath;
    }
}
else{
    $image='';
}

if($board == 0){
    if($_SESSION['nickname'] !== 'admin'){
        die("<script>alert('admin 계정만 공지사항 게시물 작성 가능합니다');location.href='index.php?board=write-post-page'</script>");
    }
}

$result=mysqli_query($conn,"insert into post (userId, postType, title, content, image) values ('$userId', '$board','$title' ,'$content', '$image')");
if($result){
    die("<script>alert('게시글 업로드에 성공했습니다!'); location.href='/index.php?board=index'</script>");
}
else {
    die("<script>alert('게시글 업로드에 실패했습니다!'); location.href='/index.php?board=index'</script>");
}
?>