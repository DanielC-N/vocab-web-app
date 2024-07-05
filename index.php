<?php
include 'auth_check.php';
require 'modele.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Vocabulaire </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <?php
    $nbPagesTotales = floor(count(getBaseDD()) / 20);
    if (isset($_GET['nbpage']) && $_GET['nbpage'] >= $nbPagesTotales) {
        $_GET['nbpage'] = $nbPagesTotales;
    }
    if (isset($_GET['nbpage'])) {
        $numeroPageCourante = $_GET['nbpage'];
    } else {
        $numeroPageCourante = 0;
    }

    if (isset($_GET['gloss'])) {
        $_SESSION['gloss'] = $_GET['gloss'];
    } else {
        $_SESSION['gloss'] = 'biblica key terms';
    }

    $errormsg = "";
    $mode = $_POST['mode'] ?? null;
    $rowType = 'odd';
    $doesExist = false;

    if (array_key_exists('nbpage', $_GET) && $_GET['nbpage'] < 0) {
        $_GET['nbpage'] = 0;
    }
    if (!isset($mode) || $mode == "modification") {
        $resultats = getWordsByOffset($numeroPageCourante);
    }
    if ($mode == "ajouter") {
        if (!checkParams(['mot_fr', 'mot_en', 'note']) || $_POST['mot_fr'] == "" || $_POST['mot_en'] == "") {
            $errormsg = "Veuillez renseigner les champs 'mot anglais' et 'mot fran&ccedil;ais'";
            $resultats = getWordsByOffset($numeroPageCourante);
        } else {
            if(isAdmin()) {
                $doesExist = insertWordAdmin($_POST['mot_fr'], $_POST['mot_en'], $_POST['note'], $_SESSION['gloss']);
            } else {
                $doesExist = suggestWord($_POST['mot_fr'], $_POST['mot_en'], $_POST['note'], $_SESSION['user_id'], $_SESSION['gloss']);
            }
        }
        $resultats = getWordsByOffset($numeroPageCourante);
    } elseif ($mode == "rechercher") {
        if (!checkParams(['rechercher'])) {
            $errormsg = "Non trouv&eacute;";
        } elseif ($_POST['rechercher'] == "") {
            $resultats = getWordsByOffset($numeroPageCourante);
        } else {
            $resultats = filterWord($_POST['rechercher'], $_SESSION['gloss']);
        }
    } elseif ($mode == "effacer" && isAdmin()) {
        if (!checkParams(['id']['user'])) {
            $errormsg = "id non trouv&eacute;";
        } else {
            deleteWord($_POST['id']);
        }
        $resultats = getWordsByOffset($numeroPageCourante);
    } elseif ($mode == "modifier" && isAdmin()) {
        if (!checkParams(['id', 'mot_fr', 'note'])) {
            $errormsg = 'Impossible de modifier';
        } else {
            updateWord($_POST['id'], $_POST['mot_fr'], $_POST['note']);
        }
        $resultats = getWordsByOffset($numeroPageCourante);
    } else {
        $resultats = getWordsByOffset($numeroPageCourante);
    }

    ?>

</head>

<body class="bg-body-tertiary">
    <?php if (isAdmin()) { ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="log.php">
                        <button type="submit" class="btn btn-outline-success"> Log </button>
                    </form>
                </div>
                <div class="col-auto ml-auto">
                    <form action="logout.php">
                        <button type="submit" class="btn btn-outline-success">D&eacute;connexion</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <form action="logout.php" style="position: left">
            <button type="submit" class="btn btn-outline-success"> D&eacute;connexion </button>
        </form>
    <?php } ?>
    <nav class="navbar bg-body-tertiary">
        <div class="container justify-content-center">
            <form class="d-flex" method="post">
                <input class="form-control me-1" value="<?= $_POST['rechercher'] ?? "" ?>" type="search" name="rechercher"
                    id="search" placeholder="rechercher..." />
                <input class="btn btn-outline-success" type="hidden" name="mode" value="rechercher"></input>
                <input class="btn btn-outline-success" type="submit" name="txt" value=" &#128269;"></input>
            </form>
        </div>
    </nav>

    <?php if ($mode == "modification"): ?>
        <nav class="navbar bg-body-tertiary">
            <div class="container justify-content-center">
                <form class="d-flex" method="post">
                    <input class="form-control me-1" id="en" type="text" class="text" value="<?= ($_POST['en']) ?>"
                        name="mot_en" placeholder="mot en anglais" disabled />
                    <input class="form-control me-1" id="fr" type="text" class="text" value="<?= ($_POST['fr']) ?>"
                        name="mot_fr" placeholder="mot en français" />
                    <input class="form-control me-1" id="inputnote" type="text" class="text"
                        value="<?= ($_POST['inputnote']) ?>" name="note" placeholder="note" />
                    <input class="form-control me-1" type="hidden" name="id" value="<?= ($_POST['id']) ?>"> </input>
                    <input class="btn btn-outline-success" name="mode" value="modifier" type="submit"></input>
                </form>
            </div>
        </nav>

    <?php else: ?>
        <nav class="navbar bg-body-tertiary">
            <div class="container justify-content-center">
                <form class="d-flex" method="post">
                    <input class="form-control me-1" id="en" type="text" class="text" name="mot_en" maxlength="70"
                        placeholder="mot anglais" />
                    <input class="form-control me-1" id="fr" type="text" class="text" name="mot_fr" maxlength="70"
                        placeholder="mot français" />
                    <input class="form-control me-1" id="inputnote" type="text" class="text" name="note" maxlength="70"
                        placeholder="note" />
                    <input class="btn btn-outline-success" id="ajouter" name="mode" value="ajouter" type="submit"></input>
                </form>
            </div>
        </nav>
    <?php endif ?>
    <div class="container">
        <div class="fancy-selector">
            <div class="option" onclick="updateGloss('biblica key terms')">Biblica Key Terms</div>
            <div class="option" onclick="updateGloss('glossaire unfoldingword')">Glossaire unfoldingWord</div>
        </div>
    </div>

    <?php
    if ($doesExist):
        $errormsg = "Ce mot existe d&eacute;j&agrave; ou a d&eacute;j&agrave; &eacute;t&eacute; sugg&eacute;r&eacute;" ?>
    <?php endif; ?>

    <?php if (!checkParams(['rechercher'])): ?>
        <nav aria-label="Page navigation example" class="navbar bg-body-tertiary pagination justify-content-center">
            <form method="get" action="">
                <input type="hidden" name="nbpage" value="<?= max($numeroPageCourante - 1, 0) ?>"></input>
                <input type="submit" class="btn btn-outline-success" value="&lsaquo;"></input>
            </form>

            <?php
            $startPage = max(0, $numeroPageCourante - 4);
            $endPage = min($nbPagesTotales, $numeroPageCourante + 4);

            if ($startPage > 0) {
                echo '<form method="get" action="">
                        <input type="hidden" name="nbpage" value="0"></input>
                        <input type="submit" class="btn btn-outline-success" value="1"></input>
                    </form>';
                if ($startPage > 1) {
                    echo '<span>...</span>';
                }
            }

            for ($numPage = $startPage; $numPage <= $endPage; $numPage++):
                ?>
                <?php if ($numPage == $numeroPageCourante): ?>
                    <form method="get" action="">
                        <input type="hidden" name="nbpage" value="<?= $numPage ?>"></input>
                        <input type="submit" class="btn btn-success" value="<?= $numPage + 1 ?>"></input>
                    </form>
                <?php else: ?>
                    <form method="get" action="">
                        <input type="hidden" name="nbpage" value="<?= $numPage ?>"></input>
                        <input type="submit" class="btn btn-outline-success" value="<?= $numPage + 1 ?>"></input>
                    </form>
                <?php endif; ?>
            <?php endfor; ?>

            <form method="get" action="">
                <input type="hidden" name="nbpage" value="<?= min($numeroPageCourante + 1, $nbPagesTotales) ?>"></input>
                <input type="submit" class="btn btn-outline-success" value="&rsaquo;"></input>
            </form>
            <?php
            if ($endPage < $nbPagesTotales) {
                if ($endPage < $nbPagesTotales - 1) {
                    echo '<span>...</span>';
                }
                echo '<form method="get" action="">
                    <input type="hidden" name="nbpage" value="' . $nbPagesTotales . '"></input>
                    <input type="submit" class="btn btn-outline-success" value="&raquo;"></input>
                    </form>';
            }
            ?>


        </nav>
    <?php endif; ?>


    <?php if (isset($_POST['rechercher'])) { ?>
        <ul class="pagination justify-content-left m-2">
            <li><a class="btn btn-outline-success" href="index.php"> Retour à la page d'accueil </a></li>
        </ul>
    <?php } ?>

    <?php if ($errormsg): ?>
        <h1 class="error-message">Erreur : <?= $errormsg ?></h1>
    <?php endif; ?>
    <?php if ($mode == "ajouter" && !$errormsg): ?>
        <h1 class="success-message">Le mot a correctement été soumis</h1>
    <?php endif; ?>
    
    <header>
        <div class="container-fuide overflow-x-hidden text-black">
            <div class="row-gap d-flex align-items-center p-1 bg-success bg-opacity-50 text-wrap">
                <div class="col-1 p-0">
                    <h6 class="text-center">Catégorie</h6>
                </div>
                <div class="col-3 p-0">
                    <h6 class="text-center">Mots anglais</h6>
                </div>
                <div class="col-3 p-0">
                    <h6 class="text-center">Mots français</h6>
                </div>
                <?php if (!isAdmin()) { ?>

                    <div class="col-2 pe-1">
                        <h6 class="text-center">Notes</h6>
                    </div>
                <?php } 
                if (isAdmin()) { ?>
                    <div class="col-2 pe-1">
                        <h6 class="text-center">Notes</h6>
                    </div>
                    <div class="col-1 pe-1">
                        <h6 class="text-center">Effacer</h6>
                    </div>

                    <div class="col-1 p-0">
                        <h6 class="text-center">Modifier</h6>
                    </div>
                <?php } ?>
            </div>
        </div>


        <?php foreach ($resultats as $vocabulaire):
            $rowType = $rowType == "odd" ? "even" : "odd";
        ?>
            <div class=" d-flex align-items-center p-1 row m-0 <?= $rowType ?>">

                <p class="col-1 text-center p-0 m-0 text-break" id="en <?= $vocabulaire['id'] ?>">
                    <?= $vocabulaire['glossary'] ?>
                </p>
                <p class="col-3 text-center p-0 m-0 text-break" id="en <?= $vocabulaire['id'] ?>">
                    <?= $vocabulaire['mot_en'] ?>
                </p>
                <p class="col-3 text-center p-0 m-0 text-break" id="fr <?= $vocabulaire['id'] ?>">
                    <?= $vocabulaire['mot_fr'] ?>
                </p>
                <!-- <p class="col-1 text-center p-0 m-0 text-break" id="note <?= $vocabulaire['id'] ?>">
                    <?= $vocabulaire['note'] ?>
                </p> -->
                <?php if (!isAdmin()) { ?>
                    <p class="col-2 text-center pe-1 m-0 text-break" id="note <?= $vocabulaire['id'] ?>">
                        <?= $vocabulaire['note'] ?>
                    </p>
                <?php } else { ?>
                    <p class="col-2 text-center pe-1 m-0 text-break" id="note <?= $vocabulaire['id'] ?>">
                        <?= $vocabulaire['note'] ?>
                    </p>
                <?php }
                if (isAdmin()) { ?>

                    <form action="" method="post" class="col-1 pe-1 p-0 text-center">
                        <input type="hidden" name="id" value="<?= $vocabulaire['id'] ?>"></input>
                        <input type="hidden" name="mode" value="effacer"></input>
                        <input class="btn btn-outline-success" type="submit" name="txt" value="&#128465;"
                            id="<?= $vocabulaire['id'] ?>"></input>
                    </form>
                    <form method="post" action="" class="col-1 text-center p-0">
                        <input type="hidden" name="id" value="<?= $vocabulaire['id'] ?>"></input>
                        <input type="hidden" name="en" value="<?= $vocabulaire['mot_en'] ?>"></input>
                        <input type="hidden" name="fr" value="<?= $vocabulaire['mot_fr'] ?>"></input>
                        <input type="hidden" name="inputnote" value="<?= $vocabulaire['note'] ?>"></input>
                        <input type="hidden" name="mode" value="modification"></input>
                        <input class="btn btn-outline-success" type="submit" name="txte" value="&#128394;"></input>
                    </form>
                <?php } ?>
                <!-- <time class=" col-2 text-center">?=$vocabulaire['created']?></time>  -->
            </div>
        <?php endforeach; ?>
        </div>

    </header>

    <?php if (!checkParams(['rechercher'])): ?>
        <nav aria-label="Page navigation example" class="navbar bg-body-tertiary pagination justify-content-center">
            <form method="get" action="">
                <input type="hidden" name="nbpage" value="<?= max($numeroPageCourante - 1, 0) ?>"></input>
                <input type="submit" class="btn btn-outline-success" value="&lsaquo;"></input>
            </form>

            <?php

            if ($startPage > 0) {
                echo '<form method="get" action="">
                        <input type="hidden" name="nbpage" value="0"></input>
                        <input type="submit" class="btn btn-outline-success" value="1"></input>
                    </form>';
                if ($startPage > 1) {
                    echo '<span>...</span>';
                }
            }

            for ($numPage = $startPage; $numPage <= $endPage; $numPage++):
                ?>
                <?php if ($numPage == $numeroPageCourante): ?>
                    <form method="get" action="">
                        <input type="hidden" name="nbpage" value="<?= $numPage ?>"></input>
                        <input type="submit" class="btn btn-success" value="<?= $numPage + 1 ?>"></input>
                    </form>
                <?php else: ?>
                    <form method="get" action="">
                        <input type="hidden" name="nbpage" value="<?= $numPage ?>"></input>
                        <input type="submit" class="btn btn-outline-success" value="<?= $numPage + 1 ?>"></input>
                    </form>
                <?php endif; ?>
            <?php endfor; ?>

            <form method="get" action="">
                <input type="hidden" name="nbpage" value="<?= min($numeroPageCourante + 1, $nbPagesTotales) ?>"></input>
                <input type="submit" class="btn btn-outline-success" value="&rsaquo;"></input>
            </form>
            <?php
            if ($endPage < $nbPagesTotales) {
                if ($endPage < $nbPagesTotales - 1) {
                    echo '<span>...</span>';
                }
                echo '<form method="get" action="">
                    <input type="hidden" name="nbpage" value="' . $nbPagesTotales . '"></input>
                    <input type="submit" class="btn btn-outline-success" value="&raquo;"></input>
                </form>';
            }
            ?>
        </nav>
    <?php endif; ?>
</body>

<script>
    let collectionOfText = document.getElementsByClassName('text-break');

    for (let i = 0; i < collectionOfText.length; i++) {
        collectionOfText[i].addEventListener('dblclick', (e) => {
            let textToCopy = e.target.innerText;
            navigator.clipboard.writeText(textToCopy).then(() => {
                showTooltip(e.target, "Copié !");
            });
        });
    }

    function showTooltip(element, message) {
        let tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.innerText = message;
        document.body.appendChild(tooltip);

        let rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';

        setTimeout(() => {
            tooltip.classList.add('fade-out');
            setTimeout(() => tooltip.remove(), 500);
        }, 2000);
    }

    function updateGloss(value) {
        // Clear active class from all options
        document.querySelectorAll('.fancy-selector .option').forEach(option => {
            option.classList.remove('active');
        });

        // Add active class to the clicked option
        event.target.classList.add('active');

        // Update the URL with the selected value
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('gloss', value);
        window.location.search = urlParams.toString();
    }
</script>

</html>