<section class="allAnimals">
    <div class="head"></div>
    <h1>Nos animaux</h1>
    <form id="choices" method="POST" action="">
        <div class="choices">
            <div id="filter">
                <h2>filtres</h2>
                <div class="searchFilter element">
                        <div class="titleFilter">
                            <label for="filterBreedSearch"><h3>Races :</h3></label>
                            <?php $breeds = listAllBreeds(); ?>
                        </div>
                        <div class="housings">
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
                                <input type="text" class="filterSearch" name="filterBreedsSearch" id="filterBreedsSearch" placeholder="chercher" autocomplete="off">
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
                                <input type="checkbox" name="housing<?php echo($count);?>" id="housing<?php echo($count);?>" value="<?php echo($housing['id_housing']) ?>">
                                <label for="housing<?php echo($count);?>">
                                    <?php echo($housing['name']);?>
                                </label>
                            </div>
                            <?php $count++; 
                        }?>
                    </div>
                </div>
                <div class="element">
                    <h3>Statut :</h3>
                    <ul>
                        <li>
                            <input type="checkbox" name="visible" id="visible" value="1" >
                            <label for="visible">Visible</label>
                        </li>
                        <li>
                            <input type="checkbox" name="archive" id="archive" value="0" >
                            <label for="archive">Archivé</label>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="sort">
                <h2>Trie</h2>
                <ul>
                    <li>
                        <input type="radio" name="sort" id="popular" value="popular">
                        <label for="popular">Popularité</label>
                    </li>
                    <li>
                        <input type="radio" name="sort" id="breed" value="breed">
                        <label for="breed">Races</label>
                    </li>
                    <li>
                        <input type="radio" name="sort" id="housing" value="housing">
                        <label for="housing">Habitats</label>
                    </li>
                </ul>
            </div>
        </div>
        <div class="confirmChoices">
            <input class="btn-green" type="submit" value="Appliquer" name="choices">
            <form method="POST" action ="<?php if($optionPage){echo("../");}?>"><input class="buttonFilter btn-red" type="submit" id="cancelFilter" value="Annuler filtre" name="cancelFilter"></form>
        </div>
    </form>
    <div class="animals">
        <?php foreach($animals as $animal){?>
            <div class="animal beige">
                <img src="<?php echo($animal["photo"]['path']); ?>" alt="<?php echo($animal["photo"]['description']); ?>">
                <p><?php echo($animal['name'].' - '.$animal['breed']) ?></p>
            </div>
        <?php } ?>
    </div>
    <script src="View/assets/script/search.js"></script>
    <script src="View/assets/script/allAnimals.js"></script>
</section>