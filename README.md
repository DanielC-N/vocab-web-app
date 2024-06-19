 <?php foreach($res as $log_words):
                    ?>
                    <div class=" d-flex align-items-center p-1 row m-0">

                            <p class="col-1 text-center p-0 m-0 text-break" id="user <?=$log_words['id']?>"><?=$log_words['user']?></p>
                            <p class="col-1 text-center p-0 m-0 text-break" id="classe <?=$log_words['id']?>"><?=$log_words['classe']?></p>
                            <p class="col-2 text-center p-0 m-0 text-break" id="mot_en <?=$log_words['id']?>"><?=$log_words['mot_en']?></p>
                            <p class="col-2 text-center p-0 m-0 text-break" id="mot_fr <?=$log_words['id']?>"><?=$log_words['mot_fr']?></p>
                            <p class="col-2 text-center p-0 m-0 text-break" id="note <?=$log_words['id']?>"><?=$log_words['note']?></p>
                            <time class=" col-2 text-center"><?=$log_words['created']?></time>

                            <form method="post">
                                <input type="hidden" name="is_approved" value="<?=$log_words['id']?>"></input>
                                <input type="hidden" name="mode" value="oui"></input>
                                <input type="submit" name="txt" class="col-1 text-center p-0 m-0 text-break" value="approuver"></input>
                            </form>

                    </div>
                <?php endforeach; ?>
            </div>


                     <div  clas="d-flex align-items-center p-1 row m-0">

                           <p class="col-1 text-center p-0 m-0 text-break" id="user <?=$log_words['id']?>"><?=$log_words['user']?></p>
                           <p class="col-1 text-center p-0 m-0 text-break" id="classe <?=$log_words['id']?>"><?=$log_words['classe']?></p>
                           <p class="col-2 text-center p-0 m-0 text-break" name="mot_en" id="mot_en <?=$log_words['id']?>"><?=$log_words['mot_en']?></p>
                           <p class="col-2 text-center p-0 m-0 text-break" name="mot_fr" id="mot_fr <?=$log_words['id']?>"><?=$log_words['mot_fr']?></p>
                           <p class="col-2 text-center p-0 m-0 text-break" name="note" id="note <?=$log_words['id']?>"><?=$log_words['note']?></p>

                            <time class="col-2 text-center"><?=$log_words['created']?></time>

                            <form method="post" >
                                <input type ="hidden" id="user <//?=$log_words['id']?>" value="<?=$log_words['user']?>" ></input>
                                <input type ="hidden" id="classe <//?=$log_words['id']?>" value="<?=$log_words['classe']?>" ></input> 
                                <input type="hidden" name="mot_en" id="mot_en <?=$log_words['id']?>" value="<?=$log_words['mot_en']?>"></input>
                                <input type ="hidden" name="mot_fr" id="mot_fr <?=$log_words['id']?>" value="<?=$log_words['mot_fr']?>" ></input>
                                <input type ="hidden" name="note" id="note <?=$log_words['id']?>" value="<?=$log_words['note']?>" ></input>
                                <input type="hidden" name="id" value="<?=$log_words['id']?>"></input>
                                <input type="hidden" name="mode" value="oui"></input>
                                <input type="submit" name="txt" class="col-2 text-center p-0 m-0" value="ok"></input>
                            </form>  

                        </div>


WHERE is_approved=""