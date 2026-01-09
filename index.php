<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: adlogin.php");
    exit;
}
require "config.php";
$files = $conn->query("SELECT * FROM uploads ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Admin</title></head>
<body>

<h2>Dashboard</h2>
<a href="adlogout.php">Déconnexion</a>

<form action="upload.php" method="post" enctype="multipart/form-data">
<input type="file" name="fileToUpload" required>
<select name="type">
<option value="image">Image</option>
<option value="video">Vidéo</option>
<option value="audio">Audio</option>
<option value="document">Document</option>
</select>
<button>Upload</button>
</form>

<table border="1">
<tr><th>ID</th><th>Nom</th><th>Type</th><th>Action</th></tr>
<?php while($f=$files->fetch_assoc()): ?>
<tr>
<td><?= $f['id'] ?></td>
<td><?= htmlspecialchars($f['filename']) ?></td>
<td><?= $f['type'] ?></td>
<td><a href="delete.php?id=<?= $f['id'] ?>">Supprimer</a></td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
