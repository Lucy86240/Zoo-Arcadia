
<?php if($_SERVER['REQUEST_URI']=='/View/pages/foodAnimal/fedAnimal.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
            <form method="POST" action="" class="fedAnimalPage">
            <?php if(substr($_SERVER['REQUEST_URI'],0,6)!='/repas'){ ?>
                <div class="head"></div>
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
                        <input type="text" class="animalFed" id="animalFed" value="<?php if(isset($animal['name'])) echo($animal['name'].' - '.$animal['breed']);?>" placeholder="chercher" autocomplete="off">
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
                    <input type="text" name="foodFed" id="foodFed" required />
                </div>
                <div class="element">
                    <label for="weightFed">Quantité :</label>
                    <input type="text" name="weightFed" id="weightFed" required />
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