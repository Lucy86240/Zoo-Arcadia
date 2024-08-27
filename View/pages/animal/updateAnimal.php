<?php if($_SERVER['REQUEST_URI']=='/View/pages/animal/updateAnimal.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
    <section class="updateAnimal">
        <div class="head"> </div>
        <?php $optionPage=true;?>
        <form class="formUpdateAnimal" method="POST" enctype = "multipart/form-data">
            <h1 class="title">Modification de l'animal en cours</h1>
            <div class="elements">
                <div class="elements-input">
                    <div class="element">
                        <label for="updateAnimalHousing<?php echo($animal['id']); ?>">Habitat :</label>
                        <select name="updateAnimalHousing<?php echo($animal['id']); ?>" id="updateAnimalHousing<?php echo($animal['id']); ?>">
                            <?php $housings = listNameIdAllHousings(); ?>
                            <option value=""> <?php echo($animal['housing']); ?> </option>
                            <?php foreach($housings as $housing){ 
                                if($housing['name'] !=$animal['housing']){?>
                                    <option value="<?php echo($housing['id_housing']) ?>"><?php echo($housing['name']) ?></option>
                                <?php }} ?>
                        </select>
                    </div>
                    <p>Dans le cas où l'habitat n'existe pas veuillez le créer au préalable</p>
                    </br>
                    <div class="element">
                        <label for="updateAnimalBreed<?php echo($animal['id']); ?>">Race :</label>
                        <input type="text" class="updateBreed" id="updateAnimalBreed<?php echo($animal['id']); ?>" placeholder="<?php echo($animal['breed']) ?>" autocomplete="off" pattern="^([a-zA-Z0-9èéëïç\-\(\) ])+$"/>
                        <?php $breeds = listAllBreeds(); ?>
                    </div>
                    <div>
                        <ul class="breeds" id="listBreed<?php echo($animal['id']); ?>">
                            <?php foreach($breeds as $breed){
                                if($breed['label'] !=$animal['breed']){?>
                                    <li class="form-check none">
                                        <input class="form-check-input" type="radio" name="updateAnimalBreed<?php echo($animal['id']); ?>" id="Breed<?php echo($breed['id_breed'].'for'.$animal['id']); ?>" value="<?php echo($breed['id_breed']);?>"/>
                                        <label class="form-check-label" for="Breed<?php echo($breed['id_breed'].'for'.$animal['id']); ?>">
                                            <?php echo($breed['label']) ?>
                                        </label>
                                    </li>
                                <?php }} ?>
                        </ul>
                        <p class="MessageResult none">Trop de résultats possibles... veuillez affiner</p>
                        <div class="newBreed none">
                            <p>La race saisie n'a pas de résultat</p>
                            <label for="newBreed<?php echo($animal['id']); ?>">Nouvelle race à créer et à affecter à l'animal :</label>
                            <input type="text" class="js-newBreed" id="newBreed<?php echo($animal['id']); ?>" name="newBreed<?php echo($animal['id']); ?>" pattern="^([a-zA-Z0-9èéëïç\(\)\- ])+$"/>
                        </div>
                    </div>
                    <div class="element">
                        <label for="updateAnimalName<?php echo($animal['id']); ?>">Nom :</label>
                        <input type="text" class="js-updateAnimalName" name="updateAnimalName<?php echo($animal['id']); ?>" id="updateAnimalName<?php echo($animal['id']); ?>" required value = "<?php echo($animal['name']); ?>" pattern="^([a-zA-Z0-9èéëïç\- ])+$"/>
                    </div>
                    <div class="element">
                        <div class="addImg">
                            <p class="title">Ajouter une photo</p>

                            <div class="img-element"><input type="file" name="UpdateAnimalPhoto<?php echo($animal['id']); ?>" id="UpdateAnimalPhoto<?php echo($animal['id']); ?>"></div>

                            <div class="img-element"><label for="UAP-Description<?php echo($animal['id']); ?>">Description de la photo :</label>
                            <input type="text" class="js-UAPDescription" name="UAP-Description<?php echo($animal['id']); ?>" id="UAP-Description<?php echo($animal['id']); ?>" pattern="^([a-zA-Z0-9èéëïç&.!?,:;\(\)\- ])+$"/></div>

                            <div class="img-element"><input type="checkbox" name="UAP-checkboxPortrait<?php echo($animal['id']); ?>" id="checkbox-portrait<?php echo($animal['id']); ?>">
                            <label for="checkbox-portrait<?php echo($animal['id']); ?>">la photo est en portrait</label></div>
                            <p>Pour info : la photo doit être au format jpg ou png et ne pas dépasser 5 Mo.</p>
                        </div>
                    </div>
                </div>
                <div class="imgs">
                    <h2>Photos de l'animal</h2>
                    <?php if($animal['images'][0]['id']==0) { ?> 
                        <p>l'animal n'a aucune photo</p>
                    <?php } else{
                        for($i=0; $i<count($animal['images']); $i++){?>
                            <div class="img-container">
                                <label class="bgc-icon" for="checkbox<?php echo($i)?>">
                                    <input type="checkbox" name="checkbox<?php echo($i)?>" id="checkbox<?php echo($i)?>" class="checkbox" value="<?php echo($animal['images'][$i]['id']) ?>">
                                    <img class="iconDelete" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/delete.svg" alt="Supprimer l'animal">
                                </label>
                                <img class="imgUpdateAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");} echo($animal['images'][$i]['path']);?>" alt="<?php echo($animal['images'][$i]['description']);?>">
                            </div>
                        <?php } ?>
                        <p class="attention">Attention toutes les photos avec une icone rouge seront supprimées après "Modifier".</p>
                    <?php } ?>
                </div>
            </div>
            <div class="form-submit">
                <input type="submit" value="Modifier" name="UpdateAnimal<?php echo($animal['id']) ?>" class="button btn-brown" />
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
<?php }?>