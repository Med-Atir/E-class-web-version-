<?php
require_once "../config/connect.php";

function recherche_class($code){
    $conn = connect_db();
    $sql = $conn->prepare("
        SELECT 
            c.id, 
            c.code_classe,
            c.nom_classe,
            u.username AS nom_prof
        FROM classes c
        INNER JOIN users u ON c.id_prof = u.id
        WHERE c.code_classe = ?
        LIMIT 1
    ");
    $sql->bind_param("s", $code);
    $sql->execute();
    $result = $sql->get_result();
    if($result->num_rows > 0){
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
?>