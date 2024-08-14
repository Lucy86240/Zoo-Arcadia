<section class="foodAnimal allfood">
    <div class="themeBeige">
        <div class="head"> </div>

            <!-- icons permettant la navigation vers d'autres éléments clés-->
        <div class="icons">
            <a class="icon" href="<?php if($optionPage){echo("../");}?>animaux">
                <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/list.svg" alt="Voir la liste des animaux"></div>
            </a>
            <div class="icon <?php //permission(['Vétérinaire']);?>" id="popupFed">
                <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/note_add.svg" alt="Nourrir un animal"></div>
            </div>
        </div>
        <div class="legends">
            <span class="legend none">Voir la liste de tous les animaux</span>
            <span class="legend none">Nourrir un animal</span>
        </div>
        <div class="none c-dialog" id="dialogFed">
            <div class="fond"></div>
            <div role="document" class="c-dialog__box popup fed themeBeige">
                <div class="entete">
                    <h3 class="dialog-title">Nourrir un animal</h3>
                    <button class="close" id="closeFed" type="button">x</button>
                </div>
                <?php include_once "View/pages/foodAnimal/fedAnimal.php";?>
            </div>
        </div>

        <!-- liste des repas-->

    <!-- tableau des rapports et filtres-->
        <table>
            <caption>
                <div class="entete">
                    <img class="illustration" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/pages/food/monkey.png" alt="">
                    <div class="title">
                        <h1>Repas</h1> 
                    </div>
                </div>
                <!-- filtres -->
                <form class="filter" method="POST" action ="<?php if($optionPage){echo("../");}?>repas">
                    <span class="title">Filtres</span>
                    <div class="bodyFilter">
                        <div class="searchFilter">
                            <div class="titleFilter">
                                <label for="filterBreedSearch">Races :</label>
                                <?php $breeds = listAllBreeds(); ?>
                            </div>
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
                        <div class="element">
                            <span class="titleFilter">Employé.es :</span>
                            <ul>
                                <?php $i=0;
                                foreach($employees as $employee){ ?>
                                    <li class="form-check">
                                        <input class="form-check-input js-vetoCheckbox" type="checkbox" name="employee<?php echo($i);?>" id="employee<?php echo($i);?>" value="<?php echo($veto['mail']) ?>" <?php echo(defaultValueCheckbox('employee'.$i,$employee['mail'])) ?>>
                                        <label class="form-check-label" for="veto<?php echo($i); ?>">
                                            <?php  echo($employee['first_name'].' '.$employee['last_name']) ?>
                                        </label>
                                    </li>
                                <?php $i++;} ?>
                            </ul>
                        </div>
                        <div class="elementDate">
                            <label for="dateStart">De </label>
                            <input type="date" name="dateStart" id="dateStart" value="<?php echo(defaultValueDate('dateStart'));?>">
                            <label for="dateEnd">à </label>
                            <input type="date" name="dateEnd" id="dateEnd" value="<?php  echo(defaultValueDate('dateEnd'));?>">
                        </div>
                    </div>
                    <div class="confirmChoices">
                        <input class="btn-green" type="submit" value="Appliquer" name="choices">
                        <form method="POST" action ="<?php if($optionPage){echo("../");}?>repas"><input class="buttonFilter btn-red" type="submit" id="cancelFilter" value="Annuler filtre" name="cancelFilter"></form>
                    </div>
                </form>
            </caption>
            <thead>
                <tr>
                    <th scope="col"> <h3>Date</h3> </th>
                    <th scope="col"> <h3>Animal</h3> </th>
                    <th scope="col"> <h3>Employé.e</h3> </th>
                    <th scope="col"> <h3>Nourriture</h3> </th>
                </tr>
            </thead>
            <tbody>
                <?php if($foods != null){
                    foreach($foods as $food){ ?>
                        <tr>
                            <th scope="row"><?php echo($food['date'].' '.$food['hour']); ?></th>
                            <td><?php echo($food['animal']['name'].' - '.$food['animal']['breed'] ); ?></td>
                            <td><?php echo($food['employee']['first_name'].' '.$food['employee']['last_name']); ?></td>
                            <td><?php echo($food['food'].' - '.$food['weight']); ?></td>                    
                        </tr>
                <?php }}
                else{ ?>
                    <p id="notFoundFood">Oups nous n'avons pas trouvé de repas...</p>
                <?php } ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <li class=" <?php echo(($currentPage == 1) ? "hidden" : "");?>">
                    <a href="<?php urlOption($currentPage -1, $optionPage) ?>" class="btn-previous bp-green">
                        <img class="previous-img" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/previous_green.png" alt="Bouton précédent">
                        <p class="previous-text">Précédent</p> 
                    </a>   
                </li>

                <li><p class="page-darkGreen">Page <?php echo($currentPage); ?> / <?php echo($pages); ?></p></li>

                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class=" <?php echo(($currentPage == $pages) ? "hidden" : "");?>">
                    <a href="<?php urlOption($currentPage + 1, $optionPage)?>" class="btn-next bn-green">
                        <p class="next-text">Suivant</p> 
                        <img class="next-img" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/next_green.png" alt="Bouton suivant">
                    </a>    
                </li> 
            </ul>
        </nav>
        <script src="../View/assets/script/search.js"></script>
        <script src="../View/assets/script/popup.js"></script>
        <script src="../View/assets/script/medicalReportsANDFood.js"></script>
        <script src="../View/assets/script/allMedicalReportsANDFood.js"></script>
    </div>
</section>
