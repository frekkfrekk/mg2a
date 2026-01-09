<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) exit;

require "config.php";

$dir="uploads/";
if(!is_dir($dir)) mkdir($dir,0777,true);

$name=basename($_FILES['fileToUpload']['name']);
$type=$_POST['type'];

move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$dir.$name);

$stmt=$conn->prepare("INSERT INTO uploads(type,filename) VALUES (?,?)");
$stmt->bind_param("ss",$type,$name);
$stmt->execute();

header("Location: admin.php");
