<?php
session_start();
require 'config.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}

// Ajouter un contenu
if(isset($_POST['submit'])){
    $type = $_POST['type'];
    $title = $_POST['title'];

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $upload_dir = "uploads/" . $file_name;

    if(move_uploaded_file($file_tmp, $upload_dir)){
        $stmt = $conn->prepare("INSERT INTO contents (type, title, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $type, $title, $upload_dir);
        $stmt->execute();
        $message = "Contenu ajouté avec succès !";
    } else {
        $message = "Erreur lors de l'upload du fichier.";
    }
}

// Récupérer tous les contenus
$result = $conn->query("SELECT * FROM contents");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin</title>
</head>
<body>
<h2>Page Admin</h2>
<p><a href="logout.php">Déconnexion</a></p>

<?php if(isset($message)) echo "<p>$message</p>"; ?>

<h3>Ajouter un contenu</h3>
<form method="post" enctype="multipart/form-data">
<select name="type" required>
<option value="video">Vidéo</option>
<option value="audio">Audio</option>
<option value="photo">Photo</option>
<option value="document">Document</option>
</select><br><br>
<input type="text" name="title" placeholder="Titre" required><br><br>
<input type="file" name="file" required><br><br>
<button type="submit" name="submit">Ajouter</button>
</form>

<h3>Contenus existants</h3>
<ul>
<?php while($row = $result->fetch_assoc()): ?>
<li><?php echo $row['type'] . " - " . $row['title']; ?></li>
<?php endwhile; ?>
</ul>
</body>
</html>
