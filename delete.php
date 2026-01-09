<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) exit;
require "config.php";

$id=(int)$_GET['id'];

$res=$conn->query("SELECT filename FROM uploads WHERE id=$id");
$row=$res->fetch_assoc();

unlink("uploads/".$row['filename']);
$conn->query("DELETE FROM uploads WHERE id=$id");

header("Location: admin.php");
