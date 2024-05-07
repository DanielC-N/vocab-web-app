<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>essai</title>
   <!-- <link rel="stylesheet" href="styles.css"> -->

    <style type="text/css">
    @media (min-width:300px){  

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
            padding-top: 2px;
            padding-bottom: 2px;
            font-size: 20px;
            align-items: center;
            justify-content: center;
        }

        .categories{
        
            color: white;
            justify-content: center;
            flex-wrap: wrap;
            background-color: #674df3;      
            align-items: center;

        }

        .francais{
            text-align: center;
            width: 30%;
            font-size:15px;
        }

        .anglais{
            text-align: center;
            width: 30%;
            font-size:15px;
        }

        .notes{
            text-align: center;
            width: 20%;
            font-size:15px;
        }  
        .date{
            text-align: center;
            width:20%;
            font-size:15px;
        }
        .odd{
            background-color: #efefef;
            justify-items: end;
            margin: 0;    
        }
        .even{
            background-color:rgb(247, 247, 249);
            justify-items: end;
            margin:0;
        
        }
    }

    @media (min-width:1025px){  
       .site-search {
        
        display :flex;
        justify-content: center;
        align-items:center;
        height: 10px;
        margin-top:40px;
        margin-bottom: 20px;
       }

       #search{
        width:300px;
        padding:10px;
        border : 1px solid;
        border-radius : 5px 0 0 5px;
        margin-bottom: 20px;
        margin-right: 10px;
       }

       .bouton{
        border: none;
        font-size:20px;
        padding: 10px;
        border-radius: 0 5px 5px 0;
        margin-bottom: 20px;
       }
        .row{
        border: none;
        font-size:20px;
        padding: 10px;
        border-radius: 0 5px 5px 0;
        margin-bottom: 20px;
    
       }
        .tableau{
            display: flex;
            flex-direction:row;
            flex-wrap : wrap;
            color: rgb(0, 0, 0);
            font-family:Arial, Helvetica, sans-serif;
            grid-template-columns: auto;
            max-width: 100%;
            border: 1px solid;
            border-radius : 5px;

        }

        .button{
        border: none;
        font-size:15px;
        padding: 5px;
        border-radius: 0 5px 5px 0;
        margin-bottom: 20px;
        }
        .categories,.francais,.anglais,.notes,.date,{
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
            width: 30%;
            
        }

        .notes{
            text-align: center;
            width: 20%;
            padding-top: 10px;
            padding-bottom: 10px;
        }  
        .date{
            text-align: center;
            width:20%;
        }
        .odd{
            background-color: #efefef;
            justify-items: end;
            margin: 0;
        
            
        }
        .even{
            background-color:rgb(247, 247, 249);
            justify-items: end;
            margin:0;
        
        }
    }

            </style>


</head>
<body>
    <main>
        <form action="traitement.php" method="post">
            <div class="site-search">
                <input type="search" id="search" placeholder="rechercher..."/>
                <button type="submit" class="bouton"> &#x1F50D; </button>
            </div>
        </form>
        <from action="traitement.php" method="post">
        <div id="dynamicFields">
            <div class="row">
                <input type="text" name="mot_fr[]" placeholder="mot en français">
                <input type="text" name="mot_en[]" placeholder="mot en anglais">
                <input type="text" name="note[]" placeholder="note">
            </div>
        <div>
            <button class="button" type="submit" onclick="ajouterLigne()">Envoyez</button>
            
        
<?php
    require 'modele.php';
    $resultats = getBaseDD();
    $rowType="odd";
    //var_dump($vocabulaire); ?>
        <header>
            <div class="tableau">
                    <div class="categories francais"> Mots français </div>
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
