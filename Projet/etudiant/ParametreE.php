<?php
session_start();
require_once "../config/connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$id_etudiant = $_SESSION['id'];
$conn = connect_db();

// Récupérer les classes où l'étudiant est inscrit pour pouvoir les quitter
$sql_classes = $conn->prepare("
    SELECT c.id, c.nom_classe, u.username as nom_prof 
    FROM classes c
    INNER JOIN classe_etudiants ce ON c.id = ce.classe_id
    INNER JOIN users u ON c.id_prof = u.id
    WHERE ce.etudiant_id = ?
");
$sql_classes->bind_param("i", $id_etudiant);
$sql_classes->execute();
$result_classes = $sql_classes->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paramètres Étudiant</title>
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
        <li><a href="poser_question.php">Poser une question</a></li>
        <li><a href="mes_questions.php">Mes questions</a></li>
        <li><a href="ParametreE.php" class="active">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Paramètres du compte</h1>
    </header>

    <section class="param-section">
        <h2>Modifier mon profil</h2>
        <form action="../crud_principal/remove.php" method="POST">
            <input type="hidden" name="action" value="update_name">
            <input type="hidden" name="redirect" value="../pages/ParametreE.php">

            <label>Nom d'utilisateur :</label>
            <input type="text" name="nouveau_nom" value="<?= htmlspecialchars($_SESSION['username']) ?>" required>
            <button type="submit" class="btn">Enregistrer</button>
        </form>
    </section>

    <section class="param-section">
        <h2>Se désinscrire d'un cours</h2>
        <?php if($result_classes->num_rows > 0): ?>
            <table class="table-manage">
                <?php while($row = $result_classes->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($row['nom_classe']) ?></strong> (Prof. <?= htmlspecialchars($row['nom_prof']) ?>)</td>
                        <td align="right">
                            <form action="../crud_principal/remove.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment quitter ce cours ?');">
                                <input type="hidden" name="action" value="quitter_classe">
                                <input type="hidden" name="id_classe" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn-danger">Quitter</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Vous n'êtes inscrit à aucun cours.</p>
        <?php endif; ?>
    </section>

    <section class="param-section danger-zone">
        <h2 style="color:red;">Supprimer le compte</h2>
        <p>Une fois votre compte supprimé, il n'y a pas de retour en arrière possible.</p>

        <form action="../crud_principal/remove.php" method="POST" onsubmit="return confirm('ÊTES-VOUS SÛR de vouloir supprimer votre compte DÉFINITIVEMENT ?');">
            <input type="hidden" name="action" value="delete_account">
            <button type="submit" class="btn-danger" style="padding: 10px 20px;">Supprimer mon compte</button>
        </form>
    </section>

</div>
</body>
</html>