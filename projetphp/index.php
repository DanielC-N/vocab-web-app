<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>essai</title>

    <style type="text/css">
    @media (min-width:300px){  

        a{
            text-decoration:none;
            color:black;
        }
        .tableau{
            display: flex;
            flex-direction:row;
            flex-wrap : wrap;
            color: rgb(0, 0, 0);
            font-family:Arial, Helvetica, sans-serif;
            grid-template-columns: auto;
            max-width: 100%;
            justify-content: center;


        }
        .categories,.francais,.anglais,.notes,.date.supp.modifier{
            display: flex;
            flex-direction:row;
            flex-wrap: wrap;
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
            width: 25%;
            font-size:15px;
        }

        .anglais{
            text-align: center;
            width: 25%;
            font-size:15px;
        }

        .notes{
            text-align: center;
            width: 25%;
            font-size:15px;
        }  
        .date{
            text-align: center;
            width:12%;
            font-size:15px;
        }
        .supp{
            text-align: center;
            width: 5%;
        }
        .modifier{
            width: 8%;
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

    @media (min-width:1025px){

       .site-search {
            display :flex;
            display: row;
            justify-content: center;
            align-items:center;
            height: 10px;
            margin-top:40px;
            margin-bottom: 20px;
       }

       #search{
            display: flex;
            display: row;
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
            
           
        }

        .categories{

            color: white;
            justify-content: center;
            flex-wrap: wrap;
            background-color: #674df3;      
            align-items: center;
            justify-content: center;

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
        }  
        .date{
            text-align: center;
            width:15%;
        }
        .supp{
            text-align: center;
            width: 15%;
        }
        .modifier{
            width: 10%;
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
    
        .elements{
            justify-content:center;

        }
    }
            </style>


</head>
<body>
    <main>

        <?php $accueil=$_POST['barre']; ?> 
        
        <form method="post">
            <div class="site-search">
                <input type="search" name="barre" id="search" placeholder="rechercher..."/>
                <input type="submit" name="mode" value="barre" class="bouton"></input>
            </div>
        </form>
        <?php    $errormsg ="";
                $mode=$_POST['mode'];
        ?>
        <?php if($mode== "modifier"):?>

        <form method="post">
        <div id="dynamicFields">
                <div class="row">
                    <input id="fr" type="text" class="text" value="<?=($_POST['fr'])?>" name="mot_fr" placeholder="mot en français">
                    <input id="en" type="text" class="text"  value="<?=($_POST['en'])?>" name="mot_en" placeholder="mot en anglais"disabled>
                    <input id="inputnote" type="text" class="text"  value="<?=($_POST['note'])?>" name="note" placeholder="note">
                    <input type="hidden" name="id" value="<?=($_POST['id'])?>"> </input>
                    <input id="boutonmodif" class="button" name="mode" value="modifier" type="submit"></input>
                </div>
            <div>
        </form>
        <?php else: ?>
        <form method="post">
            <div id="dynamicFields">
                <div class="row">
                    <input id="fr" type="text" class="text" name="mot_fr" placeholder="mot en français">
                    <input id="en" type="text" class="text" name="mot_en" placeholder="mot en anglais">
                    <input id="inputnote" type="text" class="text" name="note" placeholder="note">
                    <input id="ajouter" class="button" name="mode" value="ajouter" type="submit"></input>
                </div>
            <div>
        </form>
        <?php endif; ?>     
<?php
    function checkParams($fields){
        foreach($fields as $field){
            if ((!$_POST[$field])){
                return false;
            }
        }
        return true;
    }

    require 'modele.php';

    if(!isset($mode)|| $mode=="modifier"){

        $resultats=getBaseDD();
    }
    elseif($mode == "effacer"){
        
        if (!checkParams(['id'])){

            $errormsg=("id not found");
        }
        else{
             deleteWord($_POST['id']);
           
        }
        $resultats=getBaseDD();
    }
    elseif($mode == "modifier"){
        
        if(!checkParams(['id']['mot_fr'],['note'])){
          
            $errormsg=('cannot be modified '); 
        }
        else{
            $resultats=updateWord($_POST['id'],$_POST['mot_fr'],$_POST['note']);
            // var_dump($_POST);
        }
    }    
    elseif($mode == "ajouter"){

        if (!checkParams(['mot_fr'],['mot-en'],['note'])){

            $errormsg=("word not found");
        }
        else{
              insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
            
        }
        $resultats=getBaseDD();
    }
    elseif($mode == "barre"){

        if (!checkParams(['barre'])){

            $errormsg=("not found");}
        else{
            $resultats=filterWord($_POST['barre']);}        
            
    } else {
        $resultats=getBaseDD();
    }

     

    
        
   
    // if($_POST['mot_fr']&& $_POST['mot_en']){
    //     insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
    // }
    
    // if($_POST['effacer']!="") {
    //     deleteWord($_POST['effacer']);
    // }
    // if($_POST['barre']!="") {
    //     $resultats = filterWord($_POST['barre']);
    // } else {
    //     $resultats = getBaseDD();
    // }

    $rowType="odd";
?>

<?php if ($errormsg): ?> 
    <h1>error : <?=$errormsg?></h1>
    <?php endif; ?>
        <header>
    
            <div class="tableau">
                    <div class="categories francais"> Mots français </div>
                    <div class="categories anglais"> Mots anglais </div>
                    <div class="categories notes"> Notes </div>
                    <div class="categories date"> Date de création </div>
                    <div class="categories supp"> Effacer </div>
                    <div class="categories modifier"> Modification </div>

            
                <?php foreach($resultats as $vocabulaire):
                    $rowType = $rowType == "odd" ? "even":"odd";
                    ?>
                    <p class="elements francais <?= $rowType?>" id="fr<?=$vocabulaire['id']?>"><?=$vocabulaire['mot_fr']?><p>
                    <p class="elements anglais <?= $rowType?>" id="en<?=$vocabulaire['id']?>"><?=$vocabulaire['mot_en']?></p>
                    <p class="elements notes <?= $rowType?>" id="note<?=$vocabulaire['id']?>"><?=$vocabulaire['note']?></p>
                    <time class="elements date <?= $rowType?>"><?=$vocabulaire['created']?></time>

                    <form action="" method="post" class="elements modifier">
                        <input type="hidden" name="id" value="<?=$vocabulaire['id']?>"></input>
                        <input type="submit" name="mode" value="effacer"  id="<?=$vocabulaire['id']?>"></input> 
                    </form>

                    <form method="post" action="" class="elements modifier">
                        <input type="hidden" name="id" value="<?=$vocabulaire['id']?>"></input>
                        <input type="hidden" name="fr" value="<?=$vocabulaire['mot_fr']?>"></input>
                        <input type="hidden" name="en" value="<?=$vocabulaire['mot_en']?>"></input>
                        <input type="hidden" name="inputnote" value="<?=$vocabulaire['note']?>"></input>
                        <input type="submit" name="mode" value="modifier"></input>
                    </form>
                    
                <?php endforeach; ?>
            </div>
            </div>
            <?php if (!$accueil=="barre"):?>
            
            <?php else: ?>
                <button><a href="index.php"> Retour à la page d'accueil </a></button> 
            <?php endif;?>
        </header>    
    </main>
  
</body>
</html>
