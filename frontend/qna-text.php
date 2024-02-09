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
    <?php include '../board-text.php' ?>

    <div class="comment_form">
      <h2>댓글 작성</h2>
      <form method="post">
        <label for="comment">댓글 내용</label>
        <textarea id="comment" name="comment" rows="4"></textarea>
        <button type="submit">등록</button>
      </form>
    </div>

    <div class="comment_list">
      <h2>댓글 목록</h2>
      <ul>
          <?php include '../comment-list.php' ?>
      </ul>
    </div>
  </section>

  <footer>© 2024 CodeSnack. All rights reserved.</footer>
</body>

</html>