<?php if($_SERVER['REQUEST_URI']=='/View/pages/animal/addAnimal.php'){
    ?>
    <link rel="stylesheet" href = "../../assets/css/style.css">
    <?php
    require_once '../404.php';
}
else{?>
    <section class="newAnimal">
        <div class="head"> </div>
        <?php $optionPage=true;?>
        <form class="formNewAnimal" method="POST" enctype = "multipart/form-data">
            <h1 class="title">Ajout d'un animal</h1>
            <div class="elements">
                <div class="elements-input">
                    <div class="element">
                        <label for="newAnimalHousing">Habitat :</label>
                        <select name="newAnimalHousing" id="newAnimalHousing" required>
                            <?php $housings = listNameIdAllHousings(); ?>
                            <?php if(isset($_GET['housing'])){ ?>
                                <option value="<?php echo($_GET['housing']); ?>"> <?php echo(findHousingNameById($_GET['housing'])); ?> </option>
                            <?php } ?>
                            <?php foreach($housings as $housing){
                                if(isset($_GET['housing']) && $_GET['housing']!=$housing['id_housing'] || !isset($_GET['housing'])){
                                ?>
                                    <option value="<?php echo($housing['id_housing']) ?>"><?php echo($housing['name']) ?></option>
                                <?php }  
                            }?>
                        </select>
                    </div>
                    <p>Dans le cas où l'habitat n'existe pas veuillez le créer au préalable</p>
                    </br>
                    <div class="element">
                        <label for="newAnimalBreed">Race :</label>
                        <input type="text" class="addBreed" id="newAnimalBreed" autocomplete="off" pattern="^([a-zA-Zèéëïç\- ])+$">
                        <?php $breeds = listAllBreeds(); ?>
                    </div>
                    <div>
                        <ul class="breedsAdd" id="listBreed">
                            <?php foreach($breeds as $breed){?>
                                    <li class="form-check none">
                                        <input class="form-check-input" type="radio" name="newAnimalBreed" id="Breed<?php echo($breed['id_breed']); ?>" value="<?php echo($breed['id_breed']);?>">
                                        <label class="form-check-label" for="Breed<?php echo($breed['id_breed']); ?>">
                                            <?php echo($breed['label']) ?>
                                        </label>
                                    </li>
                                <?php } ?>
                        </ul>
                        <p class="MessageResultNew none">Trop de résultats possibles... veuillez affiner</p>
                        <div class="newBreedAdd none">
                            <p class="notBreed">La race saisie n'a pas de résultat</p>
                            <div class="element">
                                <label for="newBreed">Nouvelle race à créer et à affecter à l'animal :</label>
                                <input type="text" id="newBreed" name="newBreed" pattern="^([a-zA-Zèéëïç\(\)\- ])+$">
                            </div>
                        </div>
                    </div>
                    <div class="element">
                        <label for="newAnimalName">Nom :</label>
                        <input type="text" name="newAnimalName" id="newAnimalName" pattern="^([a-zA-Z0-9èéëïç\- ])+$" required />
                    </div>
                    <div class="element">
                        <div class="addImg">
                            <p class="title">Ajouter une photo</p>

                            <div class="img-element">
                                <input type="file" name="newAnimalPhoto" id="newAnimalPhoto">
                            </div>

                            <div class="img-element">
                                <label for="NAP-Description">Description de la photo :</label>
                                <input type="text" name="NAP-Description" id="NAP-Description" pattern="^([a-zA-Z0-9èéëïç&!?,:;\(\)\- ])+$">
                            </div>

                            <div class="img-element">
                                <label for="NAP-Description">Attribution :</label>
                                <input type="text" name="NAP-attribution" id="NAP-attribution">
                            </div>

                            <div class="img-element">
                                <input type="checkbox" name="NAP-checkboxPortrait" id="checkbox-portrait">
                                <label for="checkbox-portrait">la photo est en portrait</label>
                            </div>
                            <p>Pour info : la photo doit être au format jpg ou png et ne pas dépasser 5 Mo. <br> L'attribution sera visible dans les mentions légales.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-submit">
                <input type="submit" value="Ajouter" name="addAnimal" class="button btn-brown" />
                <button class="button btn-red">Annuler</button>      
                <a href="../habitats" class="button btn-green">Retour aux habitats</a>     
            </div>
        </form>
        <?php if(isset($msg)){
            if($msg == "success"){ ?>
                <div class="msg success">
                    <img class="illustration" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/good.png" alt="">
                    <p><?php echo('L\'animal a été mis à jour avec succès!'); ?></p>
                </div>
            <?php }else{ ?>
                <div class="msg error">
                    <img class="illustration" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/problem.png" alt="">
                    <p><?php echo($msg); ?></p>
                </div>
            <?php } ?>
        <?php }?>
        <script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/script/updateAddAnimal.js"></script>
    </section>
<?php } ?>