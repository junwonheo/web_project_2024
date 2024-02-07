<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css">
  <title>QnA 게시판</title>
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
    <button class="write-post-btn" onclick="location.href='../session.php'">글 쓰기</button>
  </nav>

  <section>
    <?php include '../connect-data.php' ?>
    <?php
    $query1 = "SELECT postType FROM post";
    $result1 = $mysqli->query($query1);

    $query = "SELECT post.postId, post.title, post.timeStamp, user.nickname
          FROM post
          INNER JOIN user ON post.userId = user.userId
          WHERE post.postType = 4
          ORDER BY post.timeStamp DESC";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $postid = $row['postId'];
        $title = $row['title'];
        $timestamp = $row['timeStamp'];
        $nickname = $row['nickname'];

        echo '<a href="qna-text.php?postid=' . $postid . '" class="qna-post-link">';
        echo '<article class="qna-post">';
        echo '<h3>' . $title . '</h3>';
        echo '<p>' . $timestamp . '</p>';
        echo '<p>' . $nickname . '</p>';
        echo '</article>';
        echo '</a>';
      }
    }
    ?>
  </section>

  <footer>© 2024 CodeSnack. All rights reserved.</footer>
</body>

</html>