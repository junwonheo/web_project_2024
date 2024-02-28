<?php
require_once 'vendor/autoload.php'; // Composer의 autoload 파일

$loader = new \Twig\Loader\FilesystemLoader('C:/xampp/htdocs/frontend');
$twig = new \Twig\Environment($loader);

$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");

$search = $_GET['search'];
$nickname = isset($_SESSION['nickname'])?$_SESSION['nickname']:'';

$perPage = 5;
$currentPage = isset($_GET['currentPage']) ? (int)$_GET['currentPage']: 1;
$startPage = ($currentPage > 1) ? ($currentPage * $perPage) - $perPage : 0;
$total = $conn->query("SELECT count(*) as total from post where (content like '%{$search}%' or title like '%{$search}%')")->fetch_assoc()['total'];
$totalPage = ceil($total/$perPage);

$sql = "SELECT p.postId, p.userId, p.postType, p.title, p.content, p.image, p.timeStamp, u.nickname From post as p
INNER JOIN user AS u ON p.userId = u.userId where (p.content like '%{$search}%' or p.title like '%{$search}%') order by p.timeStamp desc LIMIT {$startPage}, {$perPage}";
$result = $conn->query($sql);
$posts = array();
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $posts[] = $row;
    }
}

echo $twig->render('search.html',
    ['nickname' => $nickname,
     'posts' => $posts,
     'currentPage' => $currentPage,
     'perPage' => $perPage,
     'totalPage' => $totalPage,
     'search' => $search
]);
?>