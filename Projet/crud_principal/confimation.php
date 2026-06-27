<?php
$nom = $_POST['nom'];
$email = $_POST['email'];
$password = $_POST['password'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inscrition</title>
    <link rel="stylesheet" type="text/css" href="../assets/confirm.css">
</head>
<body>
<form action="signup.php" method="POST">
    <h2>Veuillez selectioner votre role:</h2>
    <input type="hidden" name="nom" value="<?php echo"$nom"?>">
    <input type="hidden" name="email" value="<?php echo"$email"?>">
    <input type="hidden" name="password" value="<?php echo"$password"?>">
    <label>Continuer comme Etudiant</label>
    <input type="radio" name="type" value="etudiant" required>
    <label>Continuer comme Professeur</label>
    <input type="radio" name="type" value="professeur" required>
    <input type="submit" placeholder="Confirmer l'inscription">
</form>
</body>
</html>