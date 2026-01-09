<?php
session_start();
require "config.php";

if(isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit;
}

$error = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $u = $_POST['username'];
    $p = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->bind_param("s",$u);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows==1){
        $row = $res->fetch_assoc();
        if(password_verify($p,$row['password'])){
            $_SESSION['admin_logged_in']=true;
            $_SESSION['admin_username']=$row['username'];
            header("Location: admin.php");
            exit;
        }
    }
    $error="Identifiants incorrects";
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Login Admin</title></head>
<body>
<h2>Connexion Admin</h2>
<p style="color:red"><?= $error ?></p>
<form method="post">
<input name="username" placeholder="Utilisateur" required><br><br>
<input type="password" name="password" placeholder="Mot de passe" required><br><br>
<button>Connexion</button>
</form>
</body>
</html>
