<?php

$host="localhost";
$user="root";
$pw="";
$dbname="codesnack";
$conn=mysqli_connect($host,$user,$pw,$dbname) or die("can't access DB");

$comment = $_POST['comment'];
$result = mysqli_connect($conn, 'insert into (userId, postType, title, content, image, timeStamp) values ()')

?>