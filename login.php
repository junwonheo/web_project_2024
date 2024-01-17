<?php
session_start();
$host = "localhost";
$user = "codesnack";
$password = "codesnack";
$dbname = "codesnack";

$mysqli = new mysqli($host, $user, $password, $dbname);

$username = $_POST['username'];
$username = $_POST['password'];

?>