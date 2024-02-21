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
    <form class="search-box" action="" method="get">
      <input type="text" name="search" placeholder="검색어를 입력하세요">
      <button type="submit">검색</button>
    </form>
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
    <?php if (isset($_GET['search'])) {
      include '../search-process.php';
    } else { ?>
      <?php include "../board-list.php"; ?>
    <?php } ?>
  </section>

  <footer>© 2024 CodeSnack. All rights reserved.</footer>
</body>

</html>