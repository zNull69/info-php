<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Iscriviti o accedi tramite il modulo.");
    }
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username === 'admin' && $password === 'Adm1n') {
        echo "Accesso riuscito. Benvenuto, admin!";
    } else {
        echo "Credenziali non valide.";
    }

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

    
    mysqli_select_db($conn, $MYSQL_DATABASE);

    $sql = "CREATE TABLE IF NOT EXISTS utenti (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        cognome VARCHAR(50) NOT NULL,
        pwd VARCHAR(255) NOT NULL,
        data_registrazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    mysqli_query($conn, $sql);

    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM utenti");
    $row = mysqli_fetch_assoc($result);

    if ($row['total'] == 0) {
        //utenti di esempio
        $utenti_esempio = [
            ['Mario', 'Rossi', password_hash('password123', PASSWORD_DEFAULT)],
            ['Laura', 'Bianchi', password_hash('laura2024', PASSWORD_DEFAULT)],
            ['Giuseppe', 'Verdi', password_hash('giuseppe99', PASSWORD_DEFAULT)],
            ['Anna', 'Neri', password_hash('anna456', PASSWORD_DEFAULT)],
            ['Francesco', 'Romano', password_hash('franco789', PASSWORD_DEFAULT)]
        ];
        
        foreach ($utenti_esempio as $utente) {
            $nome = mysqli_real_escape_string($conn, $utente[0]);
            $cognome = mysqli_real_escape_string($conn, $utente[1]);
            $pwd = mysqli_real_escape_string($conn, $utente[2]);
            
            $sql = "INSERT INTO utenti (nome, cognome, pwd) VALUES ('$nome', '$cognome', '$pwd')";
            mysqli_query($conn, $sql);
        }
    }

    if (isset($_POST['aggiungi_utente'])) {
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
        $pwd_utente = mysqli_real_escape_string($conn, $_POST['pwd']);
        
        if (!empty($nome) && !empty($cognome) && !empty($pwd_utente)) {
            $pwd_hash = password_hash($pwd_utente, PASSWORD_DEFAULT);
            $sql = "INSERT INTO utenti (nome, cognome, pwd) VALUES ('$nome', '$cognome', '$pwd_hash')";
            
            if (mysqli_query($conn, $sql)) {
                $success = "Utente aggiunto con successo!";
            } else {
                $error_insert = "Errore nell'inserimento: " . mysqli_error($conn);
            }
        } else {
            $error_insert = "Tutti i campi sono obbligatori!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>
    <div class="form-inserimento">
        <h2 class="title">Aggiungi Utente</h2>
        
        <form method="POST" class="mb-4">
            <div class="form-row mb-3">
                <div class="form-group">
                    <label class="form-label" for="nome">Nome *</label>
                    <input class="form-control" type="text" id="nome" name="nome" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="cognome">Cognome *</label>
                    <input class="form-control" type="text" id="cognome" name="cognome" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="pwd">Password *</label>
                    <input class="form-control" type="password" id="pwd" name="pwd" required>
                </div>
            </div>
            
            <button type="submit" name="aggiungi_utente" class="btn btn-primary">Aggiungi Utente</button>
        </form>
    </div>
    <h2 class="title" style="margin-top: 3rem;">Lista Utenti</h2>
    
    <?php
    
    $sql = "SELECT id, nome, cognome, data_registrazione FROM utenti ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    $utenti = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $utenti[] = $row;
    }
    ?>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Data Registrazione</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($utenti) > 0): ?>
                <?php foreach ($utenti as $utente): ?>
                    <tr>
                        <td><?= $utente['id'] ?></td>
                        <td><?= $utente['nome'] ?></td>
                        <td><?= $utente['cognome'] ?></td>
                        <td><?= $utente['data_registrazione'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: #999;">
                        Nessun utente presente nel database
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <p style="margin-top: 20px; color: #666;">
        Totale utenti registrati: <strong><?= count($utenti) ?></strong>
    </p>
</body>
</html>
<?php
// Chiudi la connessione
mysqli_close($conn);
?>  
