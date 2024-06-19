   // if(!isset($mode)|| $mode=="modification"){
        //     $resultats=getWordsByOffset($numeroPageCourante);
        // }
        // if($mode == "ajouter"){
        //     if (!checkParams(['mot_fr','mot_en','note'])) {

        //         $errormsg=("word not found");
            
        //     } elseif($_POST['mot_fr']== "" || $_POST['mot_en']=="") {
        //         $errormsg=("please don't leave the fields for French and English words empty");
        //         $resultats=getWordsByOffset($numeroPageCourante);

        //     } else {
        //         $doesExist = insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
            
        //     }

        //     $resultats=getWordsByOffset($numeroPageCourante);
            
        // } elseif($mode == "rechercher"){
        //     if (!checkParams(['rechercher'])){

        //         $errormsg=("not found");

        //     } elseif($_POST['rechercher']== "") {

        //     $resultats=getWordsByOffset($numeroPageCourante);
        //     }else{
        //         $resultats=filterWord($_POST['rechercher']);
        //     }
        // } 
        // elseif($mode == "effacer"){
        //     if (!checkParams(['id'])){
        //         $errormsg=("id not found");
        //     } else {
        //         deleteWord($_POST['id']);
        //     }
        //     $resultats=getWordsByOffset($numeroPageCourante);}
        // } elseif($mode == "modifier"){
        //     if(!checkParams(['id','mot_fr','note'])){
        //         $errormsg=('cannot be modified ');
        //     } else {
        //         $resultats=updateWord($_POST['id'],$_POST['mot_fr'],$_POST['note'],$nbPagesCourante);
        //     }
        //     $resultats=getWordsByOffset($numeroPageCourante);
        // } 
        // else {
        //     $resultats=getWordsByOffset($numeroPageCourante);}
    
    //    if($mode=="oui"){
    //     var_dump($_POST);
    //         insertWordLog($_POST['id']);
    //    } 