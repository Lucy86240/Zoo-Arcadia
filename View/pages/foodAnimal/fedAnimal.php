
<?php if($_SERVER['REQUEST_URI']=='/View/pages/foodAnimal/fedAnimal.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
}
else{?>
            <form method="POST" action="" class="fedAnimalPage">
            <?php if(substr($_SERVER['REQUEST_URI'],0,6)!='/repas'){ ?>
                <div class="head"></div>
                <?php if($msg != null){
                if($msg == "Success"){ ?>
                    <div class="msg success">
                        <img class="illustrationMsg" src="../View/assets/img/general/good.png" alt="">
                        <p><?php echo('Le repas a été ajouté avec succès!'); ?></p>
                    </div>
                <?php }else{ ?>
                    <div class="msg error">
                        <img class="illustrationMsg" src="../View/assets/img/general/problem.png" alt="">
                        <p><?php echo($msg); ?></p>
                    </div>
                <?php } 
                }?>
                    <h1>Nouvelle alimentation de</h1>
                    <h2><?php echo($animal['name'].' - '.$animal['breed']) ?></h2>
                <?php }?>
                <div class="element">
                    <label for="dateFed">Date : </label>
                    <input type="date" name="dateFed" id="dateFed" value="<?php echo(now());?>">
                </div>
                <div class="element">
                    <label for="hourFed">Heure : </label>
                    <input type="time" name="hourFed" id="hourFed" value="<?php echo(nowHour());?>">
                </div>
                <?php if(substr($_SERVER['REQUEST_URI'],0,6)=='/repas'){ ?>
                    <div class="element">
                        <label for="animalFed">Animal :</label>
                        <input type="text" class="animalFed" id="animalFed" value="<?php if(isset($animal['name'])) echo($animal['name'].' - '.$animal['breed']);?>" placeholder="chercher" autocomplete="off" pattern="^([a-zA-Z0-9èéëïç ])+$">
                        <?php $animalsListUpdate = listAllAnimals();?>
                    </div>
                    <div class="element">
                        <div> </div>
                        <ul class="animals" id="listAnimals">
                            <?php foreach($animalsListUpdate as $animalListUpdate){ ?>
                                <li class="form-check none">
                                    <input class="form-check-input" type="radio" name="searchAnimalFed" id="searchAnimalFed<?php echo($animalListUpdate['id_animal']);?>" value="<?php echo($animalListUpdate['id_animal']);?>" required>
                                    <label class="form-check-label" for="searchAnimalFed<?php echo($animalListUpdate['id_animal']);?>">
                                        <?php echo($animalListUpdate['name'].' - '.$animalListUpdate['label']) ?>
                                    </label>
                                </li>
                            <?php }?>
                            <p class="MessageResult none" id="msgListAnimals">Trop de résultats possibles... veuillez affiner</p>
                        </ul>
                    </div>
                <?php } ?>

                <!--
                    animal -> par défaut get
                    emp -> utilisateur connecté
                -->
                <div class="element">
                    <label for="foodFed">Nourriture donnée :</label>
                    <input type="text" name="foodFed" id="foodFed" pattern="^([a-zA-Z0-9èéëïç&!?,:;\(\)\- ])+$" required />
                </div>
                <div class="element">
                    <label for="weightFed">Quantité :</label>
                    <input type="text" name="weightFed" id="weightFed" pattern="^([a-zA-Z0-9èéëïç&!?,:;\(\)\- ])+$" required />
                </div>
                <div class="form-submit">
                    <input type="submit" value="Soumettre" name="addFood" class="button btn-darkGreen" />
                    <?php if(substr($_SERVER['REQUEST_URI'],0,6)!='/repas'){ ?>
                        <a href="../habitats" class="button btn-blue">Retour aux habitats</a>
                        <a href="../animaux" class="button btn-blue">Retour aux animaux</a>  
                    <?php } ?>
                </div>
            </form>
<?php } ?>