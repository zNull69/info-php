<?php
    $MYSQL_ROOT_PASSWORD = "infoPhpRootPass";
    $MYSQL_DATABASE = "infoPhp";
    $MYSQL_PASSWORD = "infoPhpRootPass";
    $MYSQL_USER = "root";

    $conn = new mysqli("db", $MYSQL_USER, $MYSQL_PASSWORD, $MYSQL_DATABASE);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    
    $sql = "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE";
    mysqli_query($conn, $sql);


    $sql = "DELETE FROM utenti WHERE id=" . intval($_GET['id']);
    header("Location: index.php");

?>