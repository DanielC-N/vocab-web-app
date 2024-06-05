<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
<?php
    require 'modele.php';
    
        if(isset($_POST['mot_en']) && isset($_POST['mot_fr']) && isset($_POST['note'])){
            var_dump($_POST);
            updateWord($_POST['id'],$_POST['mot_fr'],$_POST['note']);
        }

        if($_POST['id']!=""){
            $id=$_POST['id'];
            $resultats = getWord($id);
            foreach($resultats as $vocabulaire);
        }
        ?>

    <div class="container-fuide overflow-x-hidden text-black">
                <div class="row-gap d-flex align-items-center p-1 bg-success bg-opacity-50 text-wrap" >
                    
                    <!-- <div class="col-2 p-0">  
                        <h6 class="text-center"> User </h6>
                    </div> -->
                    <!-- <div class="col-2 p-0">
                        <h6 class="text-center"> Type</h6>
                    </div> -->
                    <div class="col-3 pe-1"> 
                        <h6 class="text-center"> Mot anglais</h6>
                        <p class="col-3 text-center p-0 m-0 text-break" type="text" id="en"id="en <?=$vocabulaire['id']?>"><?=$vocabulaire['mot_en']?></p>
                    </div>
                    <div class="col-3 pe-1"> 
                        <h6 class="text-center"> Mot français</h6>
                        <p class="col-3 text-center p-0 m-0 text-break" type="text" id="fr" id="fr <?=$vocabulaire['id']?>"><?=$vocabulaire['mot_fr']?></p>
                    </div>
                    <div class="col-3 pe-1"> 
                        <h6 class="text-center"> Notes</h6>
                        <p class="col-3 text-center p-0 m-0 text-break" type="text" id="fr" id="note <?=$vocabulaire['id']?>"><?=$vocabulaire['note']?></p>
                    </div>
                    <div class="col-2 p-0"> 
                        <h6 class="text-center"> Date </h6>
                        <time class=" col-2 text-center"><?=$vocabulaire['created']?></time>
                    </div>
                    <!-- <div class="col-2 ">
                        <h6 class="text-center"> Date de création</h6>
                    </div> -->
                </div>
                
                        <!-- <div class=" d-flex align-items-center p-1 row m-0 ?=$rowType?>">
                             <p class="col-2 text-center p-0 m-0 text-break" type="text" id="user" value="?=$vocabulaire['note']?>"></p>
                            <p class="col-2 text-center p-0 m-0 text-break" type="text" id="type" value="?=$vocabulaire['note']?>"></p> 
                        </div> -->
            
        
              
</body>
</html>