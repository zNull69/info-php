<?php
    $MYSQL_ROOT_PASSWORD = "infoPhpRootPass";
    $MYSQL_DATABASE = "infoPhp";
    $MYSQL_PASSWORD = "infoPhpRootPass";
    $MYSQL_USER = "root";

    $conn = new mysqli("db", $MYSQL_USER, $MYSQL_PASSWORD, $MYSQL_DATABASE);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    
    $sql = "UPDATE utenti SET nome='" . mysqli_real_escape_string($conn, $_POST['nome']) . "', cognome='" . mysqli_real_escape_string($conn, $_POST['cognome']) . "' WHERE id=" . intval($_GET['id']);
?>