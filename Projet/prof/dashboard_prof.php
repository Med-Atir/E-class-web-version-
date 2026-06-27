<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../login.php");
}
$nom = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Professeur</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>
<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_prof.php" class="active">Dashboard</a></li>
        <li><a href="gerer_classe.php">Mes Classes</a></li>
        <li><a href="creer_classe.php">Ajouter Classes</a></li>
        <li><a href="questions_prof.php">Questions Reçues</a></li>
        <li><a href="poster_annonce.php" >Poster Annonce</a></li>
        <li><a href="upload_cours.php">Ajouter un cours</a></li>
        <li><a href="ajouter_devoir.php">Donner Devoir</a></li>
        <li><a href="parametreP.php">Parametres</a></li>
    </ul>
</div>
<div class="main">
    <header>
        <h1>Salut <?php echo "$nom" ?></h1>
        <form action="../crud_principal/logout.php" method="POST">
            <button class="logout-btn" type="submit" name="deconnection">Deconnexion</button>
        </form>
    </header>
    <section class="cards">
        <div class="card">
            <h3>Mes Classes</h3>
            <p>Gerer vos classes et etudiants.</p>
            <a href="gerer_classe.php" class="btn">Gerer</a>
        </div>

        <div class="card">
            <h3>Ajouter Classes</h3>
            <p>Creer des nouveaux classe.</p>
            <a href="creer_classe.php" class="btn">Creer</a>
        </div>

        <div class="card">
            <h3>Repondre aux questions</h3>
            <p>Consulter et repondre aux questions des etudiants.</p>
            <a href="questions_prof.php" class="btn">Repondre</a>
        </div>

        <div class="card">
            <h3>Annonces</h3>
            <p>Publier les annonces importantes.</p>
            <a href="poster_annonce.php" class="btn">Publier</a>
        </div>

        <div class="card">
            <h3>Ajouter de contenu cours</h3>
            <p>Ajouter des ressources cours.</p>
            <a href="poster_annonce.php" class="btn">Ajouter</a>
        </div>

        <div class="card">
            <h3>Devoirs</h3>
            <p>Ajouter ou modifier des devoirs.</p>
            <a href="ajouter_devoir.php" class="btn">Ajouter / Modifier</a>
        </div>

        <div class="card">
            <h3>Parametres</h3>
            <p>Gerer votre compte.</p>
            <a href="parametreP.php" class="btn">Parametres</a>
        </div>

    </section>
</div>
</body>
</html>