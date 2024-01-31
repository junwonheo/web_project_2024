<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>로그인</title>
</head>

<body>
    <?php include '../header.php'; ?>

    <nav>
        <div class="search-box">
            <input type="text" placeholder="검색어를 입력하세요">
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

    </nav>

    <section id="login-section">
        <h2>로그인</h2>

        <form action="../login-process.php" method="post">
            <label for="username">아이디:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">비밀번호:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">로그인</button>
        </form>

        <p>아직 계정이 없으신가요? <a href="register.php">회원가입</a></p>
        <p>아이디 혹은 비밀번호를 잊어버리셨나요? <br> <a href="find-id.php">아이디 찾기</a> <a href="find-pw.php">비밀번호 찾기</a></p>
    </section>

    <footer>
        © 2024 CodeSnack. All rights reserved.
    </footer>

</body>

</html>