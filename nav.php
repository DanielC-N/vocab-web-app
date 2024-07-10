<nav aria-label="navigation" class="navbar bg-body-tertiary pagination justify-content-center">
    <?php
    $startPage = max(0, $numeroPageCourante - 5);
    $endPage = min($nbPagesTotales, $numeroPageCourante + 5);
    if ($numeroPageCourante > 0) {
        ?>
        <form method="get" action="" style="width: 40px;">
            <input type="hidden" name="nbpage" value="<?= max($numeroPageCourante - 1, 0) ?>"></input>
            <input type="submit" class="btn btn-outline-success" value="&lsaquo;"></input>
        </form>
        <?php
    }
    if ($startPage > 0) {
        echo '<form method="get" action="" style="width: 40px;">
                <input type="hidden" name="nbpage" value="0"></input>
                <input type="submit" class="btn btn-outline-success" value="1"></input>
            </form>';
        if ($startPage > 1) {
            echo '<span style="width: 40px; display: inline-block;">...</span>';
        }
    }

    for ($numPage = $startPage; $numPage <= $endPage; $numPage++) {
        ?>
        <form method="get" action="" style="width: 40px;">
            <input type="hidden" name="nbpage" value="<?= $numPage ?>"></input>
            <input type="submit" class="btn <?= $numPage == $numeroPageCourante ? 'btn-success' : 'btn-outline-success' ?>"
                value="<?= $numPage + 1 ?>"></input>
        </form>
        <?php
    }
    if ($endPage < $nbPagesTotales) {
        if ($endPage < $nbPagesTotales - 1) {
            echo '<span style="width: 40px; display: inline-block;">...</span>';
        }
        echo '<form method="get" action="" style="width: 40px;">
                <input type="hidden" name="nbpage" value="' . $nbPagesTotales . '"></input>
                <input type="submit" class="btn btn-outline-success" value="' . $nbPagesTotales + 1 . '"></input>
                </form>';
    }
    if ($numeroPageCourante < $nbPagesTotales) { ?>
        <form method="get" action="" style="width: 40px;">
            <input type="hidden" name="nbpage" value="<?= min($numeroPageCourante + 1, $nbPagesTotales) ?>"></input>
            <input type="submit" class="btn btn-outline-success" value="&rsaquo;"></input>
        </form>
        <?php
    }
    ?>
</nav>