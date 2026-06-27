<?php
session_start();
$id = $_SESSION['id'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creer Classe</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>
<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_prof.php">Dashboard</a></li>
        <li><a href="gerer_classe.php">Mes Classes</a></li>
        <li><a href="creer_classe.php" class="active">Ajouter Classes</a></li>
        <li><a href="questions_prof.php">Questions Reçues</a></li>
        <li><a href="poster_annonce.php" >Poster Annonce</a></li>
        <li><a href="upload_cours.php">Ajouter un cours</a></li>
        <li><a href="ajouter_devoir.php">Donner Devoir</a></li>
        <li><a href="parametreP.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Creer une Classe</h1>
    </header>

    <section>
        <form class="form-class" name="creer_class" action="../crud_secondaire/add_class.php" method="POST">
            <input type="hidden" name="id_prof" value="<?php echo "$id"?>">
            <input type="hidden" name="email_prof" value="<?php echo "$email"?>">
            <input type="hidden" name="action" value="creer">
            <label for="nom">Nom de la classe:</label>
            <input type="text" id="nom" name="nom_class" placeholder="Ex: Math" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Description courte..." rows="4" required></textarea>
            <?php
            if(isset($_SESSION['creation_class'])){
                echo "<p style = color:#145503>" .$_SESSION['creation_class'] ." votre code de classe est: " . $_SESSION['cod']."</p>";
                unset($_SESSION['creation_class']);
                unset($_SESSION['cod']);
            }
            ?>
            <button type="submit" class="btn">Creer Classe</button>
        </form>
    </div>
</body>
</html>