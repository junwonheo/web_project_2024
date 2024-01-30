<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/styles.css">
    <title>글쓰기</title>
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

    <section id="upload_content">
        <form enctype="multipart/form-data" action="your-upload-handler.php" method="post">
            <div id="write-post-top">
                <select id="board-select" name="board">
                    <option value="free-board">자유게시판</option>
                    <option value="information_board">정보게시판</option>
                </select>
                <input type="text" id="title" name="title" placeholder="제목을 입력하세요" required>
            </div>
            <label for="content">내용:</label>
            <textarea id="content_area" name="content" rows="8" required></textarea>
            <div id="upload_container">
                <div>
                    <label for="image">이미지 첨부:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>

                <button id="upload_content_button" type="submit">글 올리기</button>
            </div>
        </form>
    </section>

    <footer>
        © 2024 CodeSnack. All rights reserved.
    </footer>

</body>

</html>