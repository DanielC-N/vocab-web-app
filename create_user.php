<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un utilisateur</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(to right, #a8e6cf, #dcedc1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            font-size: 2em;
            color: #4f4f4f;
            text-shadow: 2px 2px #fff;
        }

        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="password"], select {
            width: 90%;
            padding: 8px;
            margin: 5px 0;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus, select:focus {
            border-color: #6c9d8e;
        }

        input[type="submit"] {
            background: #6c9d8e;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #4c7a69;
        }

        .error-message {
            color: red;
            font-size: 1.1em;
        }

        .success-message {
            color: green;
            font-size: 1.1em;
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            display: none;
        }

        @keyframes slideIn {
            from {
                top: -100px;
                opacity: 0;
            }
            to {
                top: 10%;
                opacity: 1;
            }
        }

        .success-message.show {
            display: block;
            animation: slideIn 0.5s forwards;
        }

        /* Puppy CSS Animation */
        .puppy {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #6c9d8e;
            position: relative;
            display: inline-block;
            margin-left: 10px;
            animation: wagTail 1s infinite;
        }

        .puppy::before, .puppy::after {
            content: '';
            position: absolute;
            background: #6c9d8e;
            border-radius: 50%;
        }

        .puppy::before {
            width: 20px;
            height: 20px;
            top: 0;
            left: -15px;
        }

        .puppy::after {
            width: 12px;
            height: 12px;
            top: 15px;
            right: -15px;
            background: #fff;
        }

        @keyframes wagTail {
            0%, 100% {
                transform: rotate(0deg);
            }
            50% {
                transform: rotate(20deg);
            }
        }
    </style>
</head>
<?php
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
<body>
    <div>
        <h1>Créer un nouvel utilisateur</h1>
        <?php if ($error): ?>
            <p class="error-message"><?php echo $error; ?></p>
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
    </div>
    <div class="success-message" id="success-message">
        Utilisateur créé avec succès ! <div class="puppy"></div>
    </div>
    <script>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($error)): ?>
            document.getElementById('success-message').classList.add('show');
            setTimeout(() => {
                document.getElementById('success-message').classList.remove('show');
            }, 4000);
        <?php endif; ?>
    </script>
</body>
</html>
