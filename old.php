<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ancien </title>

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
            border-radius : 5px;
            margin-bottom: 20px;
            margin-right: 10px;
            font-family: Arial,Helvetica,Sans-serif;
       }

       .bouton{
            border: none;
            font-size:20px;
            padding: 10px;
            border-radius: 5px ;
            margin-bottom: 20px;
            font-family: Arial,Helvetica,Sans-serif;
       }
        .text{
           
            padding:10px;
            border-radius : 5px;
            margin-bottom: 20px;
            margin-right: 10px;
            font-family: Arial,Helvetica,Sans-serif;
       } 
       .button{
            border: none;
            font-size:15px;
            padding: 10px;
            border-radius: 0 5px 5px 0;
            margin-bottom: 5px;
            font-family: Arial,Helvetica,Sans-serif;
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

       
        .categories,.francais,.anglais,.notes,.date,.supp,.modifier{
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
            width: 20%;
        }

        .anglais{
            text-align: center;
            width: 20%;
            
        }

        .notes{
            text-align: center;
            width: 20%;
            padding-top: 10px;
            padding-bottom: 10px;
        }  
        .date{
            text-align: center;
            width:15%;
        }
        .supp{
            text-align: center;
            width: 5%;
        }
        .modifier{
            width: 15%;
            text-align: center;
        
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

<script>
    function modification(id){
        console.log(id);
        document.getElementById('fr').value=document.getElementById('fr'+id).innerText;
        document.getElementById('en').value=document.getElementById('en'+id).innerText;
        document.getElementById('boutonmodif').innerText="modifier";
        document.getElementById('inputnote').value=document.getElementById('note'+id).innerText;
    }
</script>
</head>
<body>
    <main>
        <form method="post">
            <div class="site-search">
                <input type="search" name="barre" id="search" placeholder="rechercher..."/>
                <button type="submit" class="bouton"> &#x1F50D; </button>
            </div>
        </form>
        <form method="post">
            <div id="dynamicFields">
                <div class="row">
                    <input id="fr" type="text" class="text" name="mot_fr" placeholder="mot en français">
                    <input id="en" type="text" class="text" name="mot_en" placeholder="mot en anglais">
                    <input id="inputnote" type="text" class="text" name="note" placeholder="note">
                    <button id="boutonmodif" class="button" type="submit">Ajouter</button>
                </div>
            <div>
        </form>
            
            
        
<?php
    require 'modele.php';
    var_dump($_POST);
    if($_POST['mot_fr'][0]!="" && $_POST['mot_en'][0]!="" && $_POST['note'][0]!=""){
        insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
    }
    if($_POST['effacer']!="") {
        deleteWord($_POST['effacer']);
    }
    if($_POST['barre']!="") {
        $resultats = filterWord($_POST['barre']);
    } 
    if($_POST['modifier']!="") {
        $resultats = updateWord($_POST['modifier']);
    }else {
        $resultats = getBaseDD();
    }
    
    
    // var_dump($_POST['mot_fr']);


    $rowType="odd";
    //var_dump($vocabulaire); ?>
        <header>
            <div class="tableau">
                    <div class="categories francais"> Mots français </div>
                    <div class="categories anglais"> Mots anglais </div>
                    <div class="categories notes"> Notes </div>
                    <div class="categories date"> Date de création </div>
                    <div class="categories supp"> Effacer </div>
                    <div class="categories modifier"> Modification </div>

            
                <?php foreach($resultats as $vocabulaire):
                    $rowType = $rowType == "odd" ? "even":"odd";?>
                    <p class="elements francais <?= $rowType?>" id="fr<?=$vocabulaire['id']?>"><?=$vocabulaire['mot_fr']?><p>
                    <p class="elements anglais <?= $rowType?>" id="en<?=$vocabulaire['id']?>"><?=$vocabulaire['mot_en']?></p>
                    <p class="elements notes <?= $rowType?>" id="note<?=$vocabulaire['id']?>"><?=$vocabulaire['note']?></p>
                    <time class="elements date <?= $rowType?>"><?=$vocabulaire['created']?></time>
                    <button class="elements supp" value="<?=$vocabulaire['id']?>" name="effacer" type="submit" id="<?=$vocabulaire['id']?>">&#x274C;</button>
                    <button class="elements modifier" name="modifier" type="button" onclick="modification(<?=$vocabulaire['id']?>)" id="modif<?=$vocabulaire['id']?>">modifier</button>
                    
                <?php endforeach; ?>
            </div>
        </header>    
    </main>
  
</body>
</html>
