<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>비밀번호 찾기</title>
</head>

<body>
  <?php include '../header.php' ?>

    <nav>
        <div class="nav-left">
            <a href="index.php">홈</a> |
            <a href="notice-board.php">공지사항</a> |
            <a href="free-board.php">자유 게시판</a> |
            <a href="market-board.php">장터 게시판</a> |
            <a href="suggestions-board.php">건의 게시판</a> |
            <a href="qna-board.php">QnA 게시판</a> |
            <a href="pointshop.php">포인트샵</a>
        </div>
        <div class="search-box">
            <input type="text" placeholder="검색어를 입력하세요">
            <button type="button">검색</button>
        </div>

    </nav>

    <section id="login-section">
        <h2>비밀번호 변경</h2>

        <form action="" method="post">
            <label for="username">아이디:</label>
            <input type="text" id="username" name="username" required>

            <label for="name">이름:</label>
            <input type="text" id="name" name="name" required>

            <label for="qna">질문 및 답변:</label>
            <select name="question">
                <option value="1" selected>출생지는 어디인가요?</option>
                <option value="2">가장 친한 친구의 이름은 무엇인가요?</option>
                <option value="3">좋아하는 동물은 무엇인가요?</option>
            </select><br>
            <input type="text" id="answer" name="answer" required><br>

            <label for="nickname">비밀번호 변경:</label>
            <input type="password" id="password" name="password" required>

            <label for="nickname">비밀번호 변경 확인:</label>
            <input type="password" id="password_re" name="password_re" required>

            <button type="submit">비밀번호 변경</button>
        </form>

    </section>

    <footer>
        © 2024 CodeSnack. All rights reserved.
    </footer>
</body>

</html>