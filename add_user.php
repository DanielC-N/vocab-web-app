<?php
if ($argc < 3) {
    echo "Usage: php add_user.php <username> <password>\n";
    exit(1);
}

$username = $argv[1];
$password = password_hash($argv[2], PASSWORD_DEFAULT);
$rights = 'user';
if(isset($argv[3]) && ($argv[3] == 'admin' || $argv[3] == 'user')) {
    $rights = $argv[3];
}

// Se connecter à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
if($bdd) {
    $stmt = $bdd->prepare('INSERT INTO users (username, password, rights) VALUES (:username, :password, :rights)');
    $stmt->execute(['username' => $username, 'password' => $password, 'rights' => $rights]);
    
    echo "Utilisateur ajouté avec succès !\n";
} else {
    echo "Erreur : impossible de se connecter à la BDD\n";
}
