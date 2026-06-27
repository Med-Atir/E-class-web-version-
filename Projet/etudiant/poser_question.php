<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$nom = $_SESSION['username'];
$email = $_SESSION['email'];
$id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poser une Question</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>
<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_etudiant.php">Dashboard</a></li>
        <li><a href="annonces.php">Annonces</a></li>
        <li><a href="mes_classes.php">Mes classes</a></li>
        <li><a href="devoirs.php">Devoirs</a></li>
        <li><a href="poser_question.php" class="active">Poser une question</a></li>
        <li><a href="mes_questions.php">Mes questions</a></li>
        <li><a href="ParametreE.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Poser une Question</h1>
    </header>

    <section>
        <form class="form-class" method="POST" action="../crud_secondaire/confirmer_question.php">

            <label for="question">Votre question:</label>
            <textarea id="question" name="question" placeholder="Ecrivez votre question ici..." rows="8" required></textarea>

            <input type="hidden" name="nom" value="<?= htmlspecialchars($nom) ?>">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

            <button type="submit" class="btn">Suivant : Choisir un professeur</button>
        </form>
    </section>
</div>
</body>
</html>