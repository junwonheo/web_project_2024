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

$board = isset($_GET['board']) ? $_GET['board'] : 'index'; // 현재 보고있는 게시판
$explodeBoard=explode('-',$board)[0];
$nickname = isset($_SESSION['nickname']) ? $_SESSION['nickname']:''; // 로그인 확인
$boardType = array(                 // post 타입별 array
    "notice" => 0,
    "free" => 1,
    "market" => 2,
    "suggestions" => 3,
    "qna" => 4
);

if(isset($boardType[$explodeBoard])){
$currentPage = isset($_GET['currentPage']) ? (int)$_GET['currentPage']: 1;       //page 검색
$perPage = 5;
$startPage = ($currentPage > 1) ? ($currentPage * $perPage) - $perPage : 0;
$sql = "SELECT p.postId, p.userId, p.postType, p.title, p.content, p.image, p.timeStamp, u.nickname From post as p
INNER JOIN user AS u ON p.userId = u.userId where p.postType = $boardType[$explodeBoard] order by p.timeStamp desc LIMIT {$startPage}, {$perPage}";
$sqlResult = $conn->query($sql);
$posts = array();
if($sqlResult->num_rows > 0){
    while($row = $sqlResult->fetch_assoc()){
        $posts[] = $row;
    }
}
$total = $conn->query("SELECT COUNT(*) as total FROM post where postType = {$boardType[$explodeBoard]}")->fetch_assoc()['total'];
$totalPage = ceil($total/$perPage);
}

if(substr($board,-4,4) == 'text'){   // 게시물 상세 페이지 렌더링
    $commentItems = [];
    $commentSql = "select u.nickname, c.comment from comment as c, user as u  where u.userId = c.userId and postId = {$_GET['postId']}";
    $commentSqlResult = $conn->query($commentSql);

    if($commentSqlResult->num_rows > 0){
        while($row = $commentSqlResult->fetch_assoc()){
            $commentItems[] = ['nickname' => $row['nickname'], 'comment' => $row['comment']];
        }
    }

echo $twig->render($board . '.html',
    ['nickname' => $nickname,
     'posts' => $posts,
     'currentPage' => $currentPage,
     'perPage' => $perPage,
     'postId' => isset($_GET['postId'])?$_GET['postId']:'',
     'commentItems' => $commentItems
    ]);
}
elseif( substr($board,-5,5) == 'board'){                                   // 게시판 페이지 렌더링
echo $twig->render($board . '.html',
    ['nickname' => $nickname,
     'posts' => $posts,
     'currentPage' => $currentPage,
     'perPage' => $perPage,
     'totalPage' => $totalPage,
     'boardType' => isset($boardType[$explodeBoard])?$boardType[$explodeBoard]:'',
     'board' => $explodeBoard
]);
}
elseif($board == 'pointshop'){
    $point = 0;
    if($nickname){
        $sql = "select point from user where nickname = '{$nickname}'";
        $point = $conn->query($sql)->fetch_assoc()['point'];
    }
    echo $twig->render($board . '.html',
    ['nickname' => $nickname,
     'point' => (int)$point
]);
}
else {            // 그 외 페이지 렌더링
echo $twig->render($board . '.html',
    ['nickname' => $nickname
]);
}
?>