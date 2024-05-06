<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>essai</title>
   <!-- <link rel="stylesheet" href="styles.css"> -->

    <style type="text/css">
  /*  @media (min-width:300px){  
    
    .tableau{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        color: rgb(0, 0, 0);
        font-family:Arial, Helvetica, sans-serif;
        grid-template-columns: auto;
        max-width: 100%;


    }
    .categories,.francais,.anglais,.notes{
        display: flex;
        flex-grow: 1;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 20px;
        align-items: center;
        justify-content: center;
    
    }

    .categories{
        display: flex;
        color: white;
        justify-content: center;
        flex-wrap: wrap;
        background-color: #674df3;      
        align-items: center;

    }

    .francais{
        text-align: center;
        width: 30%;
    }

    .anglais{
        text-align: center;
        width: 40%;
        
    }

    .notes{
        text-align: center;
        width: 30%;
    }
    
}*/
    
    
    .tableau{
        display: flex;
        flex-direction:row;
        flex-wrap : wrap;
        color: rgb(0, 0, 0);
        font-family:Arial, Helvetica, sans-serif;
        grid-template-columns: auto;
        max-width: 100%;


    }
    .categories,.francais,.anglais,.notes,.date{
        display: flex;
        flex-grow: 1;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 20px;
        align-items: center;
        justify-content: center;
    }

    .categories{
    
        color: white;
        justify-content: center;
        /*flex-wrap: wrap;*/
        background-color: #674df3;      
        align-items: center;

    }

    .francais{

        text-align: center;
        width: 30%;
    }

    .anglais{
        text-align: center;
        width: 30%;
        
    }

    .notes{
        text-align: center;
        width: 20%;
        padding-top: 5px;
        padding-bottom: 5px;

    }  
    .date{
        text-align: center;
        width:20%;
        font-size: 15px;
        padding-top: 2px;
        padding-bottom: 2px;
    }
    .odd{
        background-color: #efefef;
        justify-items: end;
      
        
    }
    .even{
        background-color:rgb(247, 247, 249);
        justify-items: end;
       
    }
    </style>


</head>
<body>
    <main>
<?php
    require 'modele.php';
    $resultats = getBaseDD();
    $rowType="odd";
    //var_dump($vocabulaire); ?>
        <header>
            <div class="tableau">
                    <div class="categories francais"> Mots francais </div>
                    <div class="categories anglais"> Mots anglais </div>
                    <div class="categories notes"> Notes </div>
                    <div class="categories date"> Date </div>
            
                <?php foreach($resultats as $vocabulaire):
                    $rowType = $rowType == "odd" ? "even":"odd";?>
                    <p class="elements francais <?= $rowType?>"><?=$vocabulaire['mot_fr']?><p>
                    <p class="elements anglais <?= $rowType?>"><?=$vocabulaire['mot_en']?></p>
                    <p class="elements notes <?= $rowType?>"><?=$vocabulaire['note']?></p>
                    <time class="elements date <?= $rowType?>"><?=$vocabulaire['created']?></time> 
                    
                <?php endforeach; ?>
            </div>
        </header>    
    </main>
  
</body>
</html>
