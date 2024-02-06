<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$db_host = "localhost";
$db_user = "codesnack";
$db_password = "";
$db_name = "codesnack";

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
