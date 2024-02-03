<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>장터 게시판</title>
</head>

<body>
    <header>
        <div class="header-top">
            <a href="login.php">로그인</a>
            <a href="register.php">회원가입</a>
        </div>
        <div class="header-main">
            <h1 class="header-title"><a href="index.php">CodeSnack</a></h1>
        </div>
    </header>

    <nav>
        <!-- 검색 창 추가 -->
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
        <button class="write-post-btn" onclick="location.href='../session.php'">글 쓰기</button>
    </nav>

    <section>
        <!-- 자유 게시물만 표시 -->
        <a href="market-text.php">
            <article class="free-post">
                <h2>장터 게시물 1</h2>
                <p>게시물 내용이 여기에 들어갑니다.</p>
            </article>
        </a>

        <a href="market-text.php">
            <article class="free-post">
                <h2>장터 게시물 2</h2>
                <p>게시물 내용이 여기에 들어갑니다.</p>
            </article>
        </a>
        <a href="market-text.php">
            <article class="free-post">
                <h2>장터 게시물 2</h2>
                <p>게시물 내용이 여기에 들어갑니다.</p>
            </article>
        </a>
        <a href="market-text.php">
            <article class="free-post">
                <h2>장터 게시물 2</h2>
                <p>게시물 내용이 여기에 들어갑니다.</p>
            </article>
        </a>
        <a href="market-text.php">
            <article class="free-post">
                <h2>장터 게시물 2</h2>
                <p>게시물 내용이 여기에 들어갑니다.</p>
            </article>
        </a>
        <a href="market-text.php">
            <article class="free-post">
                <h2>장터 게시물 2</h2>
                <p>게시물 내용이 여기에 들어갑니다.</p>
            </article>
        </a>
        <a href="market-text.php">
            <article class="free-post">
                <h2>장터 게시물 2</h2>
                <p>게시물 내용이 여기에 들어갑니다.</p>
            </article>
        </a>

        <!-- 추가적인 자유 게시물들을 동적으로 표시하거나, 페이지를 넘기는 등의 기능을 구현할 수 있습니다. -->
    </section>

    <footer>
        © 2024 CodeSnack. All rights reserved.
    </footer>

</body>

</html>