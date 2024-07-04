<?php
session_start();

// Vérifie si l'utilisateur est connecté et est un administrateur
include 'admin_check.php';

include_once 'modele.php';


$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (checkParams(['username', 'password', 'rights'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $rights = $_POST['rights'];

        // Fonction pour insérer un nouvel utilisateur dans la base de données
        function insertUser($username, $password, $rights) {
            $bdd = getDBConnection();
            $stmt = $bdd->prepare('INSERT INTO users (username, password, rights) VALUES (:username, :password, :rights)');
            $stmt->execute(['username' => $username, 'password' => $password, 'rights' => $rights]);
            $bdd = null;
        }

        insertUser($username, $password, $rights);
        echo "Utilisateur créé avec succès !";
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un utilisateur</title>
</head>
<body>
    <h1>Créer un nouvel utilisateur</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="create_user.php">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="rights">Droits :</label>
        <select id="rights" name="rights" required>
            <option value="user">Utilisateur</option>
            <option value="admin">Administrateur</option>
        </select>
        <br>
        <input type="submit" value="Créer l'utilisateur">
    </form>
</body>
</html>
