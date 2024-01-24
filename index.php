<?php
require_once 'vendor/autoload.php'; // Composer의 autoload 파일

$loader = new \Twig\Loader\FilesystemLoader('C:/xampp/htdocs/frontend');
$twig = new \Twig\Environment($loader);

$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");
session_start();

if (isset($_GET['board'])) {           // 현재 보고 있는 게시판
    $board = "{$_GET['board']}";
} else {
    $board = "index";
}

if (isset($_SESSION['nickname'])){      //로그인 확인
    $user = $_SESSION['nickname'];
}else {
    $user = '';
}

$boardType = array(
    "index" => 'index',
    "notice-board" => 0,
    "free-board" => 1,
    "market-board" => 2,
    "suggestions-board" => 3,
    "qna-board" => 4
);

$currentPage = isset($_GET['currentPage']) ? (int)$_GET['currentPage']: 1;       //page 검색
$perPage = 5;
$startPage = ($currentPage > 1) ? ($currentPage * $perPage) - $perPage : 0;
$sql = "SELECT p.postId, p.userId, p.postType, p.title, p.content, p.image, p.timeStamp, u.nickname From post as p
INNER JOIN user AS u ON p.userId = u.userId LIMIT {$startPage}, {$perPage}";
$sqlResult = $conn->query($sql);
$posts = array();
if($sqlResult->num_rows > 0){
    while($row = $sqlResult->fetch_assoc()){
        $posts[] = $row;
    }
}
$total = $conn->query("SELECT COUNT(*) as total FROM post")->fetch_assoc()['total'];
$totalPage = ceil($total/$perPage);
$conn->close();

echo $twig->render($board . '.html',['user' => $user, 'posts' => $posts, 'currentPage' => $currentPage, 'totalPage' => $totalPage, 'boardType' => isset($boardType[$board])?$boardType[$board]:'' ]);
?>