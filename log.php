<?php
// seuls les admins ont accès à cette page
include 'admin_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mots ajoutés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="index.php">
                    <button type="submit" class="btn btn-outline-success">Retour aux glossaires</button>
                </form>
            </div>
            <div class="col-auto ml-auto">
                <form action="logout.php">
                    <button type="submit" class="btn btn-outline-success">D&eacute;connexion</button>
                </form>
            </div>
        </div>
    </div>
    <?php

    $nbPagesTotales = floor(count(getBaseDDLogWords()) / 10);
    $numeroPageCourante = 0;
    if (array_key_exists('nbpage', $_GET) && $_GET['nbpage'] >= $nbPagesTotales) {
        $_GET['nbpage'] = $nbPagesTotales;
        $numeroPageCourante = $_GET['nbpage'];
    }

    $errormsg = "";
    $mode = $_POST['mode'];

    if (array_key_exists('nbpage', $_GET) && $_GET['nbpage'] < 0) {
        $_GET['nbpage'] = 0;
    }

    if ($mode == "oui") {
        if (!checkParams(['mot_fr', 'mot_en', 'note', 'id'])) {
            $errormsg = ("word not found");
        } else {
            insertWordLog($_POST['mot_fr'], $_POST['mot_en'], $_POST['note'], $_POST['id'], $_POST['glossary'],$_POST['classe']);
        }
        $res = getWordsByOffsetLogWords($numeroPageCourante);
    } elseif ($mode == "non") {
        if (!checkParams(['mot_fr', 'mot_en', 'note', 'id'])) {
            $errormsg = "word not found";
        } else {
            refuseWord($_POST['id']);
        }
        $res = getWordsByOffsetLogWords($numeroPageCourante);
    } else {
        $res = getWordsByOffsetLogWords($numeroPageCourante);
    }
    ?>

    <header>
        <div class="container-fuide overflow-x-hidden text-black">
            <div class="row-gap d-flex align-items-center p-1 bg-success bg-opacity-50 text-wrap">

                <div class="col-1 p-0">
                    <h6 class="text-center">Utilisateur</h6>
                </div>
                <div class="col-1 pe-1">
                    <h6 class="text-center">Glossaire</h6>
                </div>
                <div class="col-2 p-0">
                    <h6 class="text-center">Mots anglais</h6>
                </div>
                <div class="col-2 p-0">
                    <h6 class="text-center">Mots français</h6>
                </div>
                <div class="col-1 pe-1">
                    <h6 class="text-center">Notes</h6>
                </div>
                <div class="col-1 pe-1">
                    <h6 class="text-center">Date</h6>
                </div>
                <div class="col-4 p-0">
                    <h6 class="text-center">Approbation</h6>
                </div>
            </div>

            <?php foreach ($res as $log_words):
                ?>
                <div class="d-flex align-items-center p-1 row m-0">
                    <p class="col-1 text-center p-0 m-0 text-break" id="user <?= $log_words['id'] ?>">
                        <?= $log_words['user'] ?>
                    </p>
                    <p class="col-1 text-center p-0 m-0 text-break" name="glossary" id="glossary <?= $log_words['id'] ?>">
                        <?= getRealGlossaryName($log_words['glossary']) ?>
                    </p>
                    <p class="col-2 text-center p-0 m-0 text-break" name="mot_en" id="mot_en <?= $log_words['id'] ?>">
                        <?= $log_words['mot_en'] ?>
                    </p>
                    <p class="col-2 text-center p-0 m-0 text-break" name="mot_fr" id="mot_fr <?= $log_words['id'] ?>">
                        <?= $log_words['mot_fr'] ?>
                    </p>
                    <p class="col-1 text-center p-0 m-0 text-break" name="note" id="note <?= $log_words['id'] ?>">
                        <?= $log_words['note'] ?>
                    </p>

                    <time class="col-1 text-center"><?= $log_words['created'] ?></time>

                    <form method="post" class="col-2 text-center text-break">
                        <input type="hidden" id="user <?= $log_words['id'] ?>" value="<?= $log_words['user'] ?>"></input>
                        <input type="hidden" name="glossary" id="glossary <?= $log_words['id'] ?>"
                            value="<?= $log_words['glossary'] ?>"></input>
                        <input type="hidden" name="mot_en" id="mot_en <?= $log_words['id'] ?>"
                            value="<?= $log_words['mot_en'] ?>"></input>
                        <input type="hidden" name="mot_fr" id="mot_fr <?= $log_words['id'] ?>"
                            value="<?= $log_words['mot_fr'] ?>"></input>
                        <input type="hidden" name="note" id="note <?= $log_words['id'] ?>"
                            value="<?= $log_words['note'] ?>"></input>

                        <input type="hidden" name="id" value="<?= $log_words['id'] ?>"></input>
                        <input type="hidden" name="classe" value="<?= $log_words['classe'] ?>"></input>
                        <input type="hidden" name="mode" value="oui"></input>
                        <input type="submit" name="txt" class="btn btn-outline-success" value="Approuver"></input>
                    </form>

                    <form method="post" class="col-2 text-center text-break">
                        <input type="hidden" id="user <?= $log_words['id'] ?>" value="<?= $log_words['user'] ?>"></input>
                        <input type="hidden" id="glossary <?= $log_words['id'] ?>"
                            value="<?= $log_words['glossary'] ?>"></input>
                        <input type="hidden" name="mot_en" id="mot_en <?= $log_words['id'] ?>"
                            value="<?= $log_words['mot_en'] ?>"></input>
                        <input type="hidden" name="mot_fr" id="mot_fr <?= $log_words['id'] ?>"
                            value="<?= $log_words['mot_fr'] ?>"></input>
                        <input type="hidden" name="note" id="note <?= $log_words['id'] ?>"
                            value="<?= $log_words['note'] ?>"></input>

                        <input type="hidden" name="id" value="<?= $log_words['id'] ?>"></input>
                        <input type="hidden" name="mode" value="non"></input>
                        <input type="submit" name="text" class="btn btn-outline-danger" value="Refuser"></input>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <?php $nbPagesTotales > 1 ? include 'nav.php' : "" ?>;

    </header>
</body>

</html>