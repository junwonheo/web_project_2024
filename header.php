<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="frontend/styles.css">
    <title>CodeSnack</title>
</head>

<body>
    <header>
        <?php if (isset($_SESSION['id'])) { ?>
            <div class="header-top">
                <?php echo "<p>" . $_SESSION['id']  . "</p>"; ?>
                <a href="../logout.php">로그아웃</a>
            </div>
        <?php } else { ?>
            <div class="header-top">
                <a href="login.php">로그인</a>
                <a href="register.php">회원가입</a>
            </div>
        <?php } ?>
        <div class="header-main">
            <h1 class="header-title"><a href="index.php">CodeSnack</a></h1>
        </div>
    </header>
</body>

</html>