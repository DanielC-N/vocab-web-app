<?php
function getBaseDD()
{
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare('SELECT * FROM vocabulaire ORDER BY mot_fr ');
    $stmt->execute();
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;
}

function getBaseDDLogWords()
{
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare('SELECT * FROM log_words WHERE is_approved IS NULL ORDER BY mot_fr ');
    $stmt->execute();
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;
}


function getWordsByOffset($nbpage)
{
    $offset = $nbpage * 20;
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare('SELECT * FROM vocabulaire  ORDER BY mot_en LIMIT 20 OFFSET :offset');
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;
}

function getWordsByOffsetLogWords($nbpage)
{
    $offset = $nbpage * 10;
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare('SELECT * FROM log_words  WHERE is_approved IS NULL ORDER BY mot_en LIMIT 10 OFFSET :offset');
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;
}

function filterWord($text)
{
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare("SELECT * FROM vocabulaire WHERE mot_en LIKE :en OR mot_fr LIKE :fr ");
    $stmt->execute(['en' => '%' . $text . '%', 'fr' => '%' . $text . '%']);
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt = null;
    return $res;

}

function deleteWord($id)
{
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare('DELETE FROM vocabulaire WHERE id =:id');
    $stmt->execute(['id' => $id]);
}

function insertWord($textfr, $texten, $note, $user)
{
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare('SELECT id FROM vocabulaire WHERE mot_en =:en');
    $stmt->execute(['en' => $texten]);
    $r = $stmt->fetchAll();

    $stmt = $bdd->prepare('SELECT id FROM log_words WHERE mot_en =:en');
    $stmt->execute(['en' => $texten]);
    $verif = $stmt->fetchAll();

    if (count($r) == 0 && count($verif) == 0) {
        $stmt = $bdd->prepare('INSERT INTO log_words (user,mot_en,mot_fr,note,classe) VALUES (:user, :en, :fr, :note, :classe)');
        $stmt->execute(['user' => $user, 'en' => $texten, 'fr' => $textfr, 'note' => $note, 'classe' => 'ajouter']);
    } else {
        return "exists";
    }
    $bdd = null;
    $stmt = null;
}

function insertWordLog($textfr, $texten, $note, $id)
{
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');

    $stmt = $bdd->prepare('INSERT INTO vocabulaire (mot_fr,mot_en,note) VALUES(:fr, :en, :note)');
    $stmt->execute(['fr' => $textfr, 'en' => $texten, 'note' => $note]);

    $stmt = $bdd->prepare('UPDATE log_words SET is_approved ="oui" WHERE id=:id');
    $stmt->execute(['id' => $id]);
    $bdd = null;
    return true;
}

function updateWord($id, $textfr, $note, )
{

    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare('UPDATE vocabulaire SET mot_fr=:fr, note=:note WHERE id=:id');
    $stmt->execute(['fr' => $textfr, 'note' => $note, 'id' => $id]);
}

function refuseWord($id)
{

    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare('UPDATE log_words SET is_approved="non" WHERE id=:id');
    $stmt->execute(['id' => $id]);
    $bdd = null;

}

function checkParams($fields)
{
    foreach ($fields as $field) {
        if ((!array_key_exists($field, $_POST))) {
            return false;
        }
    }
    return true;
}

function getWord($id)
{
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;', 'loise', 'formation');
    $stmt = $bdd->prepare('SELECT * FROM vocabulaire WHERE id=:id');
    $stmt->execute(['id' => $id]);
}