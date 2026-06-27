<?php
require_once "../config/connect.php";
function get_prof_ids($id_etudiant){
    $conn = connect_db();//si l'etudiant etudier au same prof dans plusieurs matieres
    $sql = $conn->prepare("
        SELECT DISTINCT c.id_prof, u.username 
        FROM classes c
        INNER JOIN classe_etudiants ce ON c.id = ce.classe_id
        INNER JOIN users u ON c.id_prof = u.id
        WHERE ce.etudiant_id = ?
    ");
    $sql->bind_param("i", $id_etudiant);
    $sql->execute();
    return $sql->get_result();
}
if(!isset($_POST['id'], $_POST['question'])){
    die("Erreur : Veuillez d'abord ecrire une question.");
}

$id_etudiant = (int)$_POST['id'];
$nom = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';
$question = $_POST['question'];

$profs = get_prof_ids($id_etudiant);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir un professeur</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body class="centered-body">

<div class="container-card">
    <h2 style="color: var(--primary);">Confirmer l'envoi</h2>

    <p style="text-align:left; margin-bottom:5px;"><strong>Votre question :</strong></p>

    <blockquote class="quote-box">
        <?= nl2br(htmlspecialchars($question)) ?>
    </blockquote>

    <form action="add_question.php" method="POST" style="text-align:left;">
        <h3 style="margin: 20px 0 10px 0;">A quel professeur souhaitez-vous envoyer cette question ?</h3>

        <?php if($profs->num_rows > 0): ?>
            <?php while($row = $profs->fetch_assoc()): ?>
                <label class="prof-option">
                    <input type="radio" name="id_prof" value="<?= $row['id_prof'] ?>" required>
                    <span style="margin-left:8px;">Prof. <?= htmlspecialchars($row['username']) ?></span>
                </label>
            <?php endwhile; ?>

            <input type="hidden" name="id_etudiant" value="<?= $id_etudiant ?>">
            <input type="hidden" name="question" value="<?= htmlspecialchars($question) ?>">
            <input type="hidden" name="type" value="etudiant">

            <br>
            <input type="submit" class="btn" value="Envoyer definitivement">

        <?php else: ?>
            <p class="error-text">Vous n'etes inscrit a aucune classe ou aucun professeur n'est assigne.</p>
        <?php endif; ?>

        <br><br>
        <div style="text-align:center;">
            <a href="javascript:history.back()" style="color:#666; text-decoration:underline;">Modifier ma question</a>
        </div>
    </form>
</div>

</body>
</html>