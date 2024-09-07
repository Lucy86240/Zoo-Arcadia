<?php if($_SERVER['REQUEST_URI']=='/View/pages/animal/allAnimals.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
}
else{?>
    <section class="allAnimals">
        <div class="head"></div>
        <h1>Nos animaux</h1>
        <form id="choices" method="POST" action ="<?php if($optionPage){echo("../");}?>animaux">
            <div class="choices">
                <div id="filter">
                    <h2>filtres</h2>
                    <div class="searchFilter element">
                            <div class="titleFilter">
                                <label for="filterBreedSearch"><h3>Races :</h3></label>
                                <?php $breeds = listAllBreeds(); ?>
                            </div>
                            <div class="breedsForm">
                                <div class="selected">
                                    <span>Sélectionnées :</span>
                                    <p id="breedsSelectedAll">Toutes</p>
                                    <ul class="breeds" id="listBreedsSelected">
                                        <?php $i=0;
                                        foreach($breeds as $breed){ ?>
                                            <li class="form-check <?php if(defaultValueCheckbox('breedSelected'.$i,$breed['id_breed'])!='checked') echo('none'); ?> js-liBreedsSelected">
                                                <input class="form-check-input js-checkboxBreedsSelected" type="checkbox" name="breedSelected<?php echo($i);?>" id="breedSelected<?php echo($i);?>" value="<?php echo($breed['id_breed']) ?>" <?php echo(defaultValueCheckbox('breedSelected'.$i,$breed['id_breed'])); ?>>
                                                <label class="form-check-label" for="breedSelect<?php echo($i); ?>">
                                                    <?php echo($breed['label']) ?>
                                                </label>
                                            </li>
                                        <?php $i++;} ?>
                                    </ul>
                                </div>
                                <div class="searchElements">
                                    <input type="text" class="filterSearch" name="filterBreedsSearch" id="filterBreedsSearch" placeholder="chercher" autocomplete="off" pattern="^([a-zA-Zèéëïç ])+$">
                                    <ul class="Breeds" id="listBreeds">
                                        <?php $i=0;
                                        foreach($breeds as $breed){ ?>
                                            <li class="form-check none">
                                                <input class="form-check-input js-checkboxBreedsSearch" type="checkbox" name="breed<?php echo($i);?>" id="breed<?php echo($i);?>" <?php echo(defaultValueCheckbox('breedSelected'.$i,$breed['id_breed'])); ?>>
                                                <label class="form-check-label" for="breed<?php echo($i); ?>">
                                                    <?php  echo($breed['label']) ?>
                                                </label>
                                            </li>
                                        <?php $i++;} ?>
                                    </ul>
                                    <p class="MessageResult none" id="msgBreedsSearch">Trop de résultats possibles... veuillez affiner</p>
                                </div>
                            </div>
                        </div>
                    <div class="element">
                        <h3>Habitats :</h3>
                        <div>
                            <?php $housings = listNameIdAllHousings();
                            $count=0;
                            foreach($housings as $housing){ ?>
                                <div class="checkbox">
                                    <input type="checkbox" name="housing<?php echo($count);?>" id="housing<?php echo($count);?>" value="<?php echo($housing['id_housing']) ?>" <?php echo(defaultValueCheckbox('housing'.$count,$housing['id_housing'])); ?>>
                                    <label for="housing<?php echo($count);?>">
                                        <?php echo($housing['name']);?>
                                    </label>
                                </div>
                                <?php $count++; 
                            }?>
                        </div>
                    </div>
                    <?php if(authorize(['connected'])) {?>
                    <div class="element">
                        <h3>Statut :</h3>
                        <ul>
                            <li>
                                <input type="checkbox" name="visible" id="visible" value="1" <?php echo(defaultValueCheckbox('visible',1)); ?>>
                                <label for="visible">Visible</label>
                            </li>
                            <li>
                                <input type="checkbox" name="archive" id="archive" value="0" <?php echo(defaultValueCheckbox('archive',1)); ?>>
                                <label for="archive">Archivé</label>
                            </li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
                <div id="sort">
                    <h2>Trie</h2>
                    <ul>
                        <li>
                            <input type="radio" name="sort" id="breed" value="breed" <?php echo(defaultValueCheckbox('sort','breed')); ?>>
                            <label for="breed">Races</label>
                        </li>
                        <li>
                            <input type="radio" name="sort" id="housing" value="housing" <?php echo(defaultValueCheckbox('sort','housing')); ?>>
                            <label for="housing">Habitats</label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="confirmChoices">
                <input class="btn-green" type="submit" value="Appliquer" name="choices">
                <form method="POST" action ="<?php if($optionPage){echo("../");}?>animaux"><input class="buttonFilter btn-red" type="submit" id="cancelFilter" value="Annuler filtre" name="cancelFilter"></form>
            </div>
        </form>
        <section id="animalSelected">
            <?php 
            if(isset($_POST['animalSelected']) || isset($_SESSION['allAnimals_animalSelected'])){
                include_once "Controller/ManageAnimal.php";
                if(isset($_POST['animalSelected'])) $id=$_POST['animalSelected'];
                else $id=$_SESSION['allAnimals_animalSelected'];
                //on affiche l'animal
                if(!isset($_POST["ValidationDeleteAnimal".$id]))
                    echoAnimal($id,'allAnimals',$temp);
            }?>
        </section>
        <form class="animals" action="#animalSelected" method="POST">
            <?php $i=0;
            foreach($animals as $animal){?>
                <input class="animalButton" type="radio" name="animalSelected" id="animal<?php echo($i);?>" value="<?php echo($animal['id']);?>"> 
                <label for="animal<?php echo($i);?>" class="animal <?php if($animal['isVisible']==0) echo('Archive'); else echo('beige'); ?>">
                    <span><?php if($animal['isVisible']==0) echo('Archivé') ?></span>
                    <img src="<?php if($optionPage){echo("../");}echo($animal["photo"]['path']); ?>" alt="<?php if($optionPage){echo("../");} echo($animal["photo"]['description']); ?>">
                    <p><?php echo($animal['name'].' - '.$animal['breed']) ?></p>
                </label>
                <?php $i++;
            } ?>
        </form>
        <div class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <div class=" <?php echo(($currentPage == 1) ? "hidden" : "");?>">
                    <a href="<?php urlOption($currentPage -1, $optionPage) ?>" class="btn-previous bp-green">
                        <img class="previous-img" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/previous_green.png" alt="Bouton précédent">
                        <p class="previous-text">Précédent</p> 
                    </a>   
            </div>

                <div><p class="page-green">Page<?php if($pages>1)echo('s')?> <?php echo($currentPage); ?> / <?php echo($pages); ?></p></div>

                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <div class=" <?php echo(($currentPage == $pages) ? "hidden" : "");?>">
                    <a href="<?php urlOption($currentPage + 1, $optionPage)?>" class="btn-next bn-green">
                        <p class="next-text">Suivant</p> 
                        <img class="next-img" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/next_green.png" alt="Bouton suivant">
                    </a>    
            </div> 
        </div>
        <script src="View/assets/script/search.js"></script>
        <script src="View/assets/script/allAnimals.js"></script>
        <script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/script/popup.js"></script>
        <script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/script/animal.js"></script>
    </section>
<?php } ?>