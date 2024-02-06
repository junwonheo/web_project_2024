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

    if ($result1 && $result1->num_rows > 0) {
      while ($row = $result1->fetch_assoc()) {
        $postType = $row['postType'];

        if ($postType === "4") {
          $query2 = "SELECT * FROM post WHERE postType = 4";
          $result2 = $mysqli->query($query2);

          if ($result2 && $result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
              $postid = $row2['postId'];
              $title = $row2['title'];
              $content = $row2['content'];
              echo '<a href="qna-text.php?postid=' . $postid . '" class="qna-post-link">';
              echo '<article class="qna-post">';
              echo '<h2>' . $title . '</h2>';
              echo '<p>' . $content . '</p>';
              echo '</article>';
              echo '</a>';
            }
          }
          break;
        }
      }
    }
    ?>
  </section>

  <footer>© 2024 CodeSnack. All rights reserved.</footer>
</body>

</html>