<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>essai</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
<?php
    require 'modele.php';
    $resultats = getBaseDD();
    //var_dump($resultat); ?>

    <?php foreach($resultats as $vocabulaire): ?>
    <article> 
        <header>
            <h1> Tableau </h1>  
            <time><?=$vocabulaire['created']?></time> 
            <p class=""><?=$vocabulaire['mot_fr']?><p>
            <p class=""><?=$vocabulaire['mot_en']?></p>
            <p class=""><?=$vocabulaire['note']?></p>
        <header>
    </article>
    <?php endforeach; ?>
    </main>
  
</body>
</html>
