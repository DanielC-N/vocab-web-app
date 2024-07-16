<?php

// Fonction pour se connecter à la base de données
function getDBConnection() {
    return new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
}

function getBaseDD() {
    $bdd = getDBConnection();
    $gloss = 'biblica key terms';
    if(isset($_SESSION['gloss'])) {
        $gloss = $_SESSION['gloss'];
    }
    $stmt = $bdd->prepare('SELECT * FROM vocabulaire WHERE glossary = :gloss ORDER BY mot_fr ');
    $stmt->execute(['gloss' => $gloss]);
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;
}

function getBaseDDLogWords() {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT * FROM log_words WHERE is_approved IS NULL ORDER BY mot_fr ');
    $stmt->execute();
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;
}


function getWordsByOffset($nbpage) {
    $offset = $nbpage * 20;
    $gloss = 'biblica key terms';
    if(isset($_SESSION['gloss'])) {
        $gloss = $_SESSION['gloss'];
    }
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT * FROM vocabulaire WHERE glossary = :gloss ORDER BY mot_en LIMIT 20 OFFSET :offset');
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue('gloss', $gloss, PDO::PARAM_STR);
    $stmt->execute();
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;
}

function getWordsByOffsetLogWords($nbpage) {
    $offset = $nbpage * 10;
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT * FROM log_words WHERE is_approved IS NULL OR is_approved = \'\' ORDER BY mot_en LIMIT 10 OFFSET :offset');
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;
}

function filterWord($text, $gloss = '') {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare("SELECT * FROM vocabulaire WHERE (mot_en LIKE :en OR mot_fr LIKE :fr) AND glossary LIKE :gloss");
    $stmt->execute(['en' => '%' . $text . '%', 'fr' => '%' . $text . '%', 'gloss' => '%' . $gloss . '%']);
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;
}

function deleteWord($id) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('DELETE FROM vocabulaire WHERE id =:id');
    $stmt->execute(['id' => $id]);
}

function suggestWord($textfr, $texten, $note, $user_id, $gloss) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT id FROM vocabulaire WHERE mot_en =:en AND glossary=:gloss');
    $stmt->execute(['en' => $texten, 'gloss' => $gloss]);
    $r = $stmt->fetchAll();

    $stmt = $bdd->prepare('SELECT id FROM log_words WHERE mot_en =:en AND glossary=:gloss');
    $stmt->execute(['en' => $texten, 'gloss' => $gloss]);
    $verif = $stmt->fetchAll();

    if (count($r) == 0 && count($verif) == 0) {
        $stmt = $bdd->prepare('INSERT INTO log_words (user,mot_en,mot_fr,note,classe,glossary) VALUES (:user, :en, :fr, :note, :classe, :gloss)');
        $stmt->execute(['user' => getUsername($user_id), 'en' => $texten, 'fr' => $textfr, 'note' => $note, 'classe' => 'ajouter', 'gloss' => $gloss]);
        $bdd = null;
        $stmt = null;
        return false;
    } else {
        $bdd = null;
        $stmt = null;
        return true;
    }
}

function suggestTranslation($textfr, $texten, $note, $user_id, $gloss) {
    $bdd = getDBConnection();

    $stmt = $bdd->prepare('SELECT id FROM log_words WHERE mot_en = :en AND mot_fr = :fr AND glossary=:gloss');
    $stmt->execute(['en' => $texten, 'fr' => $textfr, 'gloss' => $gloss]);
    $verif = $stmt->fetchAll();

    if (count($verif) == 0) {
        $stmt = $bdd->prepare('INSERT INTO log_words (user,mot_en,mot_fr,note,classe,glossary) VALUES (:user, :en, :fr, :note, :classe, :gloss)');
        $stmt->execute(['user' => getUsername($user_id), 'en' => $texten, 'fr' => $textfr, 'note' => $note, 'classe' => 'suggerer', 'gloss' => $gloss]);
        $bdd = null;
        $stmt = null;
        return false;
    } else {
        $bdd = null;
        $stmt = null;
        return true;
    }
}

function insertWordAdmin($textfr, $texten, $note, $gloss) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT id FROM vocabulaire WHERE mot_en =:en and glossary = :gloss');
    $stmt->execute(['en' => $texten, 'gloss' => $gloss]);
    $r = $stmt->fetchAll();

    if (count($r) == 0) {
        $stmt = $bdd->prepare('INSERT INTO vocabulaire (mot_fr,mot_en,note,glossary) VALUES(:fr, :en, :note, :gloss)');
        $stmt->execute(['fr' => $textfr, 'en' => $texten, 'note' => $note, 'gloss' => $gloss]);
        $bdd = null;
        $stmt = null;
        return false;
    } else {
        $bdd = null;
        $stmt = null;
        return true;
    }
}

function insertWordLog($textfr, $texten, $note, $id, $gloss, $classe) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT id FROM vocabulaire WHERE mot_en =:en AND mot_fr =:fr AND glossary=:gloss');
    $stmt->execute(['fr' => $textfr, 'en' => $texten, 'gloss' => $gloss]);
    $verif = $stmt->fetchAll();

    if(count($verif) === 0) {
        if($classe === 'ajouter') {
            $stmt = $bdd->prepare('INSERT INTO vocabulaire (mot_fr,mot_en,note, glossary) VALUES(:fr, :en, :note, :gloss)');
            $stmt->execute(['fr' => $textfr, 'en' => $texten, 'note' => $note, 'gloss' => $gloss]);
        } else {
            $stmtGetId = $bdd->prepare('SELECT id FROM vocabulaire WHERE mot_en =:en AND glossary=:gloss');
            $stmtGetId->execute(['en' => $texten, 'gloss' => $gloss]);
            $verif = $stmtGetId->fetch();
            $stmt = $bdd->prepare('UPDATE vocabulaire SET mot_fr=:fr, note=:note WHERE id=:id');
            $stmt->execute(['fr' => $textfr, 'note' => $note, 'id' => $verif['id']]);
        }
    }
    $stmt = $bdd->prepare('UPDATE log_words SET is_approved ="oui" WHERE id=:id');
    $stmt->execute(['id' => $id]);
    $bdd = null;
}

function updateWord($id, $textfr, $note, ) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('UPDATE vocabulaire SET mot_fr=:fr, note=:note WHERE id=:id');
    $stmt->execute(['fr' => $textfr, 'note' => $note, 'id' => $id]);
    $bdd = null;
}

function refuseWord($id) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('UPDATE log_words SET is_approved="non" WHERE id=:id');
    $stmt->execute(['id' => $id]);
    $bdd = null;
}

function checkParams($fields) {
    foreach ($fields as $field) {
        if (!array_key_exists($field, $_POST)) {
            return false;
        }
    }
    return true;
}

function getGlossaryNames() {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT * FROM glossNames');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getRealGlossaryName($nameId) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT real_name FROM glossNames where name_id LIKE :nameId');
    $stmt->execute(['nameId' => $nameId]);
    return $stmt->fetch()['real_name'];
}

function getUserRights($user_id) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT rights FROM users WHERE id = :user_id');
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();
    $bdd = null;
    return $user ? $user['rights'] : null;
}

function getUsername($user_id) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('SELECT username FROM users WHERE id = :user_id');
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();
    $bdd = null;
    return $user ? $user['username'] : null;
}

function getLoggedInUserId() {
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    }
    return null;
}

function isAdmin() {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $user_id = $_SESSION['user_id'];
    $rights = getUserRights($user_id);

    return $rights === 'admin';
}

// Fonction pour insérer un nouvel utilisateur dans la base de données
function insertUser($username, $password, $rights) {
    $bdd = getDBConnection();
    $stmt = $bdd->prepare('INSERT INTO users (username, password, rights) VALUES (:username, :password, :rights)');
    $stmt->execute(['username' => $username, 'password' => $password, 'rights' => $rights]);
    $bdd = null;
}