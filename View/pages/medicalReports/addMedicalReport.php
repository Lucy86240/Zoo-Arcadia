<?php if($_SERVER['REQUEST_URI']=='/View/pages/medicalReports/addMedicalReport.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
            <form method="POST" action="" class="newReportPage">
                <?php if(substr($_SERVER['REQUEST_URI'],0,18)!='/rapports_medicaux'){ ?>
                <div class="head"></div>
                    <h1>Nouveau rapport médical de </h1>
                    <h2><?php echo($animal['name'].' - '.$animal['breed']) ?></h2>
                <?php }?>
                <div class="element">
                    <label for="dateNewReport">Date : </label>
                    <input type="date" name="dateNewReport" id="dateNewReport" value="<?php echo(now());?>">
                </div>
                <?php if(substr($_SERVER['REQUEST_URI'],0,18)=='/rapports_medicaux'){ ?>
                    <div class="element">
                        <label for="animalNewReport">Animal :</label>
                        <input type="text" class="animalNewReport" id="animalNewReport" value="<?php if(isset($animal['name'])) echo($animal['name'].' - '.$animal['breed']);?>" placeholder="par défaut : <?php if(isset($animal['name'])) echo($animal['name'].' - '.$animal['breed']);?>"autocomplete="off" pattern="^([a-zA-Z0-9èéëïç\- ])+$" />
                        <?php $animalsListUpdate = listAllAnimals();?>
                    </div>
                    <div class="element">
                        <div> </div>
                        <ul class="animals" id="listAnimals">
                            <?php foreach($animalsListUpdate as $animalListUpdate){ ?>
                                <li class="form-check none">
                                    <input class="form-check-input" type="radio" name="searchAnimalNewReport" id="searchAnimalNewReport<?php echo($animalListUpdate['id_animal']);?>" value="<?php echo($animalListUpdate['id_animal']);?>" required>
                                    <label class="form-check-label" for="searchAnimalNewReport<?php echo($animalListUpdate['id_animal']);?>">
                                        <?php echo($animalListUpdate['name'].' - '.$animalListUpdate['label']) ?>
                                    </label>
                                </li>
                            <?php }?>
                            <p class="MessageResult none" id="msgListAnimals">Trop de résultats possibles... veuillez affiner</p>
                        </ul>
                    </div>
                <?php } ?>

                <div class="element">
                    <label for="healthNewReport">Etat de santé :</label>
                    <input type="text" name="healthNewReport" id="healthNewReport" pattern="^([a-zA-Z0-9èéëïç\)&!?,:;\(.\- ])+$" required />
                </div>
                <div class="element">
                    <label for="commentNewReport">Détail :</label>
                    <textarea name="commentNewReport" id="commentNewReport" maxlength="255"></textarea>
                </div>
                <div class="element">
                    <label for="foodNewReport">Nourriture proposée :</label>
                    <input type="text" name="foodNewReport" id="foodNewReport" pattern="^([a-zA-Z0-9èéëïç&!?,:;\(\) ])+$" required />
                </div>
                <div class="element">
                    <label for="weightFoodNewReport">Grammage :</label>
                    <input type="text" name="weightFoodNewReport" id="weightFoodNewReport" pattern="^([a-zA-Z0-9èéëïç&!?,\):;\( \-])+$" required />
                </div>
                <div class="form-submit">
                    <input type="submit" value="Soumettre" name="addReport" class="button btn-green" />
                    <?php if(substr($_SERVER['REQUEST_URI'],0,18)!='/rapports_medicaux'){ ?>
                        <a href="../habitats" class="button btn-beige">Retour aux habitats</a>
                        <a href="../animaux" class="button btn-beige">Retour aux animaux</a>  
                    <?php } ?>
                </div>
            </form>
<?php } ?>