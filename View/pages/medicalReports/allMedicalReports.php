<?php if($_SERVER['REQUEST_URI']=='/View/pages/medicalReports/allMedicalReports.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
    <section class="medicalReports allMedicalReports">
        <div class="themeBlue">
            <div class="head"> </div>
                <!-- icons permettant la navigation vers d'autres éléments clés-->
            <div class="icons">
                <a class="icon js-icon" href="<?php if($optionPage){echo("../");}?>animaux">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/list.svg" alt="Voir la liste des animaux"></div>
                </a>
                <?php if(authorize(['Vétérinaire'])){?>
                <div class="icon js-icon" id="popupNewReport">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/note_add.svg" alt="Ajouter un compte rendu"></div>
                </div>
                <?php } ?>
            </div>
            <div class="legends">
                <span class="legend js-legend none">Voir la liste de tous les animaux</span>
                <?php if(authorize(['Vétérinaire'])){?>
                    <span class="legend js-legend none">Ajouter un compte rendu</span>
                <?php } ?>
            </div>
            <?php if(authorize(['Vétérinaire'])){?>
                <div class="none c-dialog" id="dialogNewReport">
                    <div class="fond"></div>
                    <div role="document" class="c-dialog__box popup themeBlue newReport">
                        <div class="entete">
                            <h3 class="dialog-title">Nouveau rapport médical</h3>
                            <button class="close" id="closeNewReport" type="button">x</button>
                        </div>
                        <?php include_once "View/pages/medicalReports/addMedicalReport.php";?>
                    </div>
                </div>
            <?php } ?>

            <!-- liste des rapports et rapports détaillés-->
        <!-- rapport détaillé-->
            <?php if($reports != null){
            foreach($reports as $report){ ?>
                <div class="none c-dialog reportView">
                    <div class="fond"> </div>
                    <div class="popup c-dialog__box reportViewContainer">
                        <div class="Entete">
                            <h3 class="dialog-title">Rapport de <?php echo($report['animal']['name'].' - '.$report['animal']['breed'] ); ?></h3>
                            <button class="close buttonCloseReport" type="button" aria-label="Fermer" title="Fermer rapport">x</button>
                        </div>
                        <div class="body">
                            <div class="element">
                                <span>Date : </span>
                                <p><?php echo($report['date']); ?></p>
                            </div>
                            <div class="element">
                                <span>Vétérinaire : </span>
                                <p><?php echo($report['veterinarian']['first_name'].' '.$report['veterinarian']['last_name'].' - '.$report['veterinarian']['mail']); ?></p>
                            </div>
                            <div class="element">
                                <span>Etat de santé : </span>
                                <p><?php echo($report['health']); ?></p>
                            </div>
                            <div class="element">
                                <span>Détail : </span>
                                <p><?php echo($report['comment']); ?></p>
                            </div>
                            <div class="element">
                                <span>Nourriture proposée : </span>
                                <p><?php echo($report['food']); ?></p>
                            </div>
                            <div class="element">
                                <span>Grammage : </span>
                                <p><?php echo($report['weight_of_food']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }}
        else{ ?>
        <p>Oups nous n'avons pas trouvé de rapport</p>
        <?php } ?>

        <!-- tableau des rapports et filtres-->
            <table>
                <caption>
                    <div class="entete">
                        <img class="illustration" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/pages/medicalReports/veterinaire.png" alt="">
                        <div class="title">
                            <h1>Rapports médicaux</h1> 
                        </div>
                    </div>
                    <!-- filtres -->
                    <form class="filter" method="POST" action ="<?php if($optionPage){echo("../");}?>rapports_medicaux">
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
                                <span class="titleFilter">Vétérinaires :</span>
                                <ul>
                                    <?php $i=0;
                                    foreach($veterinarians as $veto){ ?>
                                        <li class="form-check">
                                            <input class="form-check-input js-vetoCheckbox" type="checkbox" name="veto<?php echo($i);?>" id="veto<?php echo($i);?>" value="<?php echo($veto['mail']) ?>" <?php echo(defaultValueCheckbox('veto'.$i,$veto['mail'])) ?>>
                                            <label class="form-check-label" for="veto<?php echo($i); ?>">
                                                <?php  echo($veto['first_name'].' '.$veto['last_name']) ?>
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
                            <input class="btn-DarkGreen" type="submit" value="Appliquer" name="choices">
                            <form method="POST" action ="<?php if($optionPage){echo("../");}?>rapports_medicaux"><input class="buttonFilter btn-red" type="submit" id="cancelFilter" value="Annuler filtre" name="cancelFilter"></form>
                        </div>
                    </form>
                </caption>
                <thead>
                    <tr>
                        <th scope="col"> <h3>Date</h3> </th>
                        <th scope="col"> <h3>Animal</h3> </th>
                        <th scope="col"> <h3>Vétérinaire</h3> </th>
                        <th scope="col" class="health"> <h3>Santé</h3> </th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($reports != null) {
                    foreach($reports as $report){ ?>
                        <tr>
                            <th scope="row"><?php echo($report['date']); ?></th>
                            <td><?php echo($report['animal']['name'].' - '.$report['animal']['breed'] ); ?></td>
                            <td><?php echo($report['veterinarian']['first_name'].' '.$report['veterinarian']['last_name']); ?></td>
                            <td class="health"><?php echo($report['health']); ?></td>
                            <td class="reportLink">
                                <span>En savoir plus</span> 
                                <img src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/content_paste_search.svg" alt="En savoir plus">
                            </td>
                        </tr>
                    <?php } }?>
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

                    <li><p class="page-green">Page <?php echo($currentPage); ?> / <?php echo($pages); ?></p></li>

                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                    <li class=" <?php echo(($currentPage == $pages) ? "hidden" : "");?>">
                        <a href="<?php urlOption($currentPage + 1, $optionPage)?>" class="btn-next bn-green">
                            <p class="next-text">Suivant</p> 
                            <img class="next-img" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/next_green.png" alt="Bouton suivant">
                        </a>    
                    </li> 
                </ul>
            </nav>
        </div>
        <script src="../View/assets/script/search.js"></script>
        <script src="../View/assets/script/popup.js"></script>
        <script src="../View/assets/script/medicalReportsANDFood.js"></script>
        <script src="../View/assets/script/allMedicalReportsANDFood.js"></script>
    </section>
<?php } ?>