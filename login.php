<?php
session_start();
setcookie(session_name(),session_id(),strtotime( '+30 days' ));

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// test si l'utilisateur a déjà essayé de se connecter
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 30)) {
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

require 'modele.php';
// Vérifier le nombre de tentatives de connexion
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SESSION['login_attempts'] >= 5) {
    echo "<h1>Vous avez atteint le nombre maximum de tentatives. Veuillez réessayer dans 30 secondes.</h1>";
    exit;
}

$errormsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Se connecter à la base de données
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login_attempts'] = 0; // Réinitialiser les tentatives de connexion
        header('Location: index.php');
    exit;
    } else {
        $_SESSION['login_attempts']++;
        $errormsg = "Nom d'utilisateur ou mot de passe incorrect.";
        // echo "Nom d'utilisateur ou mot de passe incorrect.";
    }

    $bdd = null;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Glossothek</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="login.css" rel="stylesheet">
</head>
<body class="bg" id="bg">
    <div class="container login-container">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <h3 class="card-title text-center">Glossothek Login</h3>
                <div class="card-body">
                    <form method="POST" action="login.php">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <?php if ($errormsg != ""): ?>
                            <div class="form-group text-center">
                                <p class="error-message text-danger"><?= $errormsg ?></p>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var bg = document.getElementById('bg');
            var img = new Image();
            img.src = 'assets/eng_french.webp';
            img.onload = function() {
                bg.style.backgroundImage = 'url(' + img.src + ')';
            };
        });
    </script>
</body>
</html>
