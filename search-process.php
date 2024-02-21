<?php
$search = $_GET['search'];

include "connect-db.php";

$request_uri = $_SERVER['REQUEST_URI'];
$post_type = "";
if (strpos($request_uri, 'notice-board.php') !== false) {
    $post_type = 0;
} elseif (strpos($request_uri, 'free-board.php') !== false) {
    $post_type = 1;
} elseif (strpos($request_uri, 'market-board.php') !== false) {
    $post_type = 2;
} elseif (strpos($request_uri, 'suggestions-board.php') !== false) {
    $post_type = 3;
} elseif (strpos($request_uri, 'qna-board.php') !== false) {
    $post_type = 4;
} else {
    $post_type = "";
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$list_num = 5;
$start = ($page - 1) * $list_num;

if ($post_type == "") {
    $query = "SELECT post.*, user.nickname
          FROM post 
          INNER JOIN user ON post.userId = user.userId
          WHERE post.title LIKE '%$search%' OR post.content LIKE '%$search%'
          ORDER BY timeStamp DESC
          LIMIT $start, $list_num";
    $total_query = "SELECT COUNT(*) AS total_count FROM post WHERE post.title LIKE '%$search%' OR post.content LIKE '%$search%'";
} else {
    $query = "SELECT post.*, user.nickname
          FROM post 
          INNER JOIN user ON post.userId = user.userId
          WHERE (post.title LIKE '%$search%' OR post.content LIKE '%$search%') AND post.postType = $post_type
          ORDER BY timeStamp DESC
          LIMIT $start, $list_num";
    $total_query = "SELECT COUNT(*) AS total_count FROM post WHERE postType = $post_type AND (post.title LIKE '%$search%' OR post.content LIKE '%$search%')";
}

$total_result = $mysqli->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_posts = $total_row['total_count'];
$total_page = ceil($total_posts / $list_num);

$result = $mysqli->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $post_type = $row['postType'];
        $post_id = $row['postId'];
        $timestamp = $row['timeStamp'];
        $nickname = $row['nickname'];
        $title_summary = mb_substr($row['title'], 0, 20);
        $content_summary = mb_substr($row['content'], 0, 40);
        if (mb_strlen($row['title']) > 20) {
            $title_summary .= "...";
        }
        if (mb_strlen($row['content']) > 40) {
            $content_summary .= "...";
        }
        $content_summary = str_ireplace($search, "<strong>$search</strong>", $content_summary);

        switch ($post_type) {
            case "":
                $post_type = "index.php";
                break;
            case 0:
                $post_type = "notice-board.php";
                $post = "공지사항";
                break;
            case 1:
                $post_type = "free-board.php";
                $post = "자유 게시판";
                break;
            case 2:
                $post_type = "market-board.php";
                $post = "장터 게시판";
                break;
            case 3:
                $post_type = "suggestions-board.php";
                $post = "건의 게시판";
                break;
            case 4:
                $post_type = "qna-board.php";
                $post = "QnA 게시판";
                break;
            default:
                break;
        }

        echo '<a href="' . $post_type . '?postid=' . $post_id . '">';
        if (strpos($request_uri, 'index.php') !== false) {
            echo "<article><h3>[ " . $post . " ]ㅤ" . $title_summary . "</h3>";
        } else {
            echo "<article><h3>" . $title_summary . "</h3>";
        }
        echo '<p id="nick">' . $nickname . '</p><br>';
        echo "<h4>" . $content_summary . "</h4>";
        echo '<p id="time">' . $timestamp . '</p>';
        echo "</article></a>";
    }
} else {
    echo "<article><h2>검색 결과가 없습니다.</h2></article>";
}

$uri_parts = parse_url($_SERVER['REQUEST_URI']);
$request_uri = $uri_parts['path'];

echo '<div class="pagination"><br>';
if ($page > 1) {
    echo '<a class="pre" href="' . $request_uri . '?search=' . $search . '&page=' . ($page - 1) . '">이전</a>';
}
for ($i = 1; $i <= $total_page; $i++) {
    echo '<a class="num" href="' . $request_uri . '?search=' . $search . '&page=' . $i . '">' . $i . '</a>';
}
if ($page < $total_page) {
    echo '<a class="next" href="' . $request_uri . '?search=' . $search . '&page=' . ($page + 1) . '">다음</a>';
}
echo '<br><br><br></div>';

