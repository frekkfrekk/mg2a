<?php
session_start();
require "config.php";

$msg="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST['password'] !== $_POST['confirm']){
        $msg="Mots de passe différents";
    } else {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO admin(username,password) VALUES (?,?)");
        $stmt->bind_param("ss",$_POST['username'],$hash);
        $stmt->execute();
        $msg="Admin créé";
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Register Admin</title></head>
<body>
<h2>Créer Admin</h2>
<p><?= $msg ?></p>
<form method="post">
<input name="username" required><br><br>
<input type="password" name="password" required><br><br>
<input type="password" name="confirm" required><br><br>
<button>Créer</button>
</form>
</body>
</html>
