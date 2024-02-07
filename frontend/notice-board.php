<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css">
  <title>공지사항</title>
</head>

<body>
  <?php include '../header.php' ?>

  <nav>
    <div class="search-box">
      <input type="text" placeholder="검색어를 입력하세요" />
      <button type="button">검색</button>
    </div>
    <div class="nav-left">
      <a href="index.php">홈</a> |
      <a href="notice-board.php">공지사항</a> |
      <a href="free-board.php">자유 게시판</a> |
      <a href="market-board.php">장터 게시판</a> |
      <a href="suggestions-board.php">건의 게시판</a> |
      <a href="qna-board.php">QnA 게시판</a> |
      <a href="pointshop.php">포인트샵</a>
    </div>
    <?php if (isset($_SESSION['id']) && $_SESSION['id'] === "admin") { ?>
      <button class="write-post-btn" onclick="location.href='../session.php'">글 쓰기</button>
    <?php } ?>
  </nav>

  <section>
    <?php
    include '../connect-data.php';

    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 1;
    }
    $list_num = 9;
    $start = ($page - 1) * $list_num;

    $query = "SELECT post.postId, post.title, post.timeStamp, user.nickname
          FROM post
          INNER JOIN user ON post.userId = user.userId
          WHERE post.postType = 0
          ORDER BY post.timeStamp DESC
          LIMIT $start, $list_num";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $postid = $row['postId'];
        $title = $row['title'];
        $timestamp = $row['timeStamp'];
        $nickname = $row['nickname'];

        echo '<a href="notice-text.php?postid=' . $postid . '" class="notice-post-link">';
        echo '<article class="notice-post">';
        echo '<h3>' . $title . '</h3>';
        echo '<p>' . $timestamp . '</p>';
        echo '<p>' . $nickname . '</p>';
        echo '</article>';
        echo '</a>';
      }
    }

    $total_query = "SELECT COUNT(*) AS total_count FROM post WHERE postType = 0";
    $total_result = $mysqli->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total_posts = $total_row['total_count'];
    $total_page = ceil($total_posts / $list_num);

    echo '<div class="pagination">';
    if ($page > 1) {
      echo '<a class="pre" href="notice-board.php?page=' . ($page - 1) . '">이전</a>';
    }
    for ($i = 1; $i <= $total_page; $i++) {
      echo '<a class="num" href="notice-board.php?page=' . $i . '">' . $i . '</a>';
    }
    if ($page < $total_page) {
      echo '<a class="next" href="notice-board.php?page=' . ($page + 1) . '">다음</a>';
    }
    echo '</div>';
    ?>
  </section>

  <footer>© 2024 CodeSnack. All rights reserved.</footer>
</body>

</html>