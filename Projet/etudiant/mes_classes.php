<?php
session_start();
require_once "../crud_secondaire/recherche_class.php";
require_once "../config/connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$id_etudiant = $_SESSION['id'];
$classe_trouvee = null;
$inscri = false;
$conn = connect_db();

if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['code'])){
    $code = $_POST['code'];
    $classe_trouvee = recherche_class($code);

    if($classe_trouvee){
        $id_classe_check = $classe_trouvee['id'];
        $stmt = $conn->prepare("SELECT * FROM classe_etudiants WHERE etudiant_id = ? AND classe_id = ?");
        if ($stmt) {
            $stmt->bind_param("ii", $id_etudiant, $id_classe_check);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                $inscri = true;
            }
            $stmt->close();
        } else {
            die("Erreur SQL : " . $conn->error);
        }
    }
}

$sql_mes_classes = "
    SELECT c.id, c.nom_classe, c.description, u.username as nom_prof 
    FROM classes c
    INNER JOIN classe_etudiants ce ON c.id = ce.classe_id
    INNER JOIN users u ON c.id_prof = u.id
    WHERE ce.etudiant_id = ?
";

$stmt_list = $conn->prepare($sql_mes_classes);
$stmt_list->bind_param("i", $id_etudiant);
$stmt_list->execute();
$result_mes_classes = $stmt_list->get_result();
?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mes Classes</title>
        <link rel="stylesheet" href="../assets/global.css">
    </head>
    <body>
    <div class="sidebar">
        <h2>E-Class</h2>
        <ul>
            <li><a href="dashboard_etudiant.php">Dashboard</a></li>
            <li><a href="annonces.php">Annonces</a></li>
            <li><a href="mes_classes.php" class="active">Mes classes</a></li>
            <li><a href="devoirs.php">Devoirs</a></li>
            <li><a href="poser_question.php">Poser une question</a></li>
            <li><a href="mes_questions.php">Mes questions</a></li>
            <li><a href="ParametreE.php">Parametres</a></li>
        </ul>
    </div>

    <div class="main">
        <header>
            <h1>Gestion de mes cours</h1>
        </header>

        <div style="margin-bottom: 20px;">
            <form action="mes_classes.php" method="POST">
                <input name="code" type="search" placeholder="Rejoindre une classe via son code..." required style="padding: 10px; width: 300px;">
                <button class="btn">Rechercher</button>
            </form>
        </div>

        <?php if(!empty($classe_trouvee)): ?>
            <div class="search-result">
                <h3>Résultat de la recherche :</h3>
                <div class="card">
                    <h3><?php echo htmlspecialchars($classe_trouvee['nom_classe']); ?></h3>
                    <p><strong>Professeur:</strong> <?php echo htmlspecialchars($classe_trouvee['nom_prof']); ?></p>

                    <?php if($inscri): ?>
                        <button class="btn" style="background-color: grey; cursor: not-allowed;">Deja inscrit</button>
                    <?php else: ?>
                        <form action="../crud_secondaire/demander_acc.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $id_etudiant; ?>">
                            <input type="hidden" name="code" value="<?php echo htmlspecialchars($code); ?>">
                            <button class="btn">Demander l'accès</button>

                            <?php
                            if(isset($_SESSION['acces'])){
                                echo "<p style='color:#47c803; margin-top:10px;'>" . $_SESSION['acces'] . "</p>";
                                unset($_SESSION['acces']);
                            }
                            elseif (isset($_SESSION['noacces'])){
                                echo "<p style='color:red; margin-top:10px;'>" . $_SESSION['noacces'] . "</p>";
                                unset($_SESSION['noacces']);
                            }
                            ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php elseif($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p style="color:red;">Aucune classe trouvee avec ce code.</p>
        <?php endif; ?>


        <h2 class="section-title">Mes Classes Actuelles</h2>

        <section class="cards">
            <?php if($result_mes_classes->num_rows > 0): ?>
                <?php while($row = $result_mes_classes->fetch_assoc()): ?>
                    <a href="cours_details.php?id=<?php echo $row['id']; ?>" class="card-link">
                        <div class="card">
                            <h3><?php echo htmlspecialchars($row['nom_classe']); ?></h3>
                            <p><strong>Prof :</strong> <?php echo htmlspecialchars($row['nom_prof']); ?></p>
                            <?php if(!empty($row['description'])): ?>
                                <p style="font-size: 0.9em; color: #666;"><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . '...'; ?></p>
                            <?php endif; ?>
                            <span class="btn" style="display:inline-block; margin-top: 10px;">Acceder au cours</span>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Vous n'etes inscrit a aucune classe pour le moment.</p>
            <?php endif; ?>
        </section>

    </div>
    </body>
    </html>
<?php
$stmt_list->close();
$conn->close();
?>