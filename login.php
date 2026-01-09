<?php
session_start();
require 'config.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hash);
    $stmt->fetch();

    if($stmt->num_rows > 0 && password_verify($password, $hash)){
        $_SESSION['admin_id'] = $id;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion Admin</title>
</head>
<body>
<h2>Connexion Admin</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
<input type="text" name="username" placeholder="Nom d'utilisateur" required><br><br>
<input type="password" name="password" placeholder="Mot de passe" required><br><br>
<button type="submit" name="login">Connexion</button>
</form>
</body>
</html>
