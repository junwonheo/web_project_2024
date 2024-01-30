<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/styles.css">
    <title>CodeSnack</title>
</head>

<body>
    <?php include '../header.php'; ?>

    <nav>
        <div class="search-box">
            <input type="text" placeholder="검색어를 입력하세요">
            <button type="button">검색</button>
        </div>
        <div class="nav-left">
            <a href="index.php">홈</a> | <a href="notice-board.php">공지사항</a> |
            <a href="free-board.php">자유 게시판</a> |
            <a href="market-board.php">장터 게시판</a> |
            <a href="suggestions-board.php">건의 게시판</a> |
            <a href="qna-board.php">QnA 게시판</a> |
            <a href="pointshop.php">포인트샵</a>
        </div>
    </nav>

    <section>
        <a href="notice-board.php">
            <article>
                <h2>
                    공지 사항
                </h2>
                <p>게시물 내용 1</p>
            </article>
        </a>
        <a href="free-board.php">
            <article>
                <h2>
                    자유 게시판
                </h2>
                <p>게시물 내용 2</p>
            </article>
        </a>
        <a href="market-board.php">
            <article>
                <h2>
                    장터 게시판
                </h2>
                <p>게시물 내용 3</p>
            </article>

        </a>
        <a href="suggestions-board.php">
            <article>
                <h2>
                    건의 게시판
                </h2>
                <p>게시물 내용 4</p>
            </article>

        </a>
        <a href="qna-board.php">
            <article>
                <h2>
                    QnA 게시판
                </h2>
                <p>게시물 내용 5</p>
            </article>

        </a>
        <!-- 추가 게시물을 필요에 따라 추가 -->
    </section>

    <footer>
        © 2024 CodeSnack. All rights reserved.
    </footer>

</body>

</html>