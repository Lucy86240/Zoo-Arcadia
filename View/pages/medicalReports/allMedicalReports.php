<section class="medicalReports allMedicalReports">
    <?php $optionPage = false ?>
    <div class="head"> </div>

        <!-- icons permettant la navigation vers d'autres éléments clés-->
    <div class="icons">
        <div class="icon">
            <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/list.svg" alt="Voir la liste des animaux"></div>
        </div>
        <div class="icon <?php //permission(['Vétérinaire']);?>" id="popupNewReport">
            <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/note_add.svg" alt="Ajouter un compte rendu"></div>
        </div>
    </div>
    <div class="legends">
        <span class="legend none">Voir la liste de tous les animaux</span>
        <span class="legend none">Ajouter un compte rendu</span>
    </div>
    <div id="newReport-JS">
        <?php include_once "View/pages/medicalReports/addMedicalReport.php";?>
    </div>

    <!-- liste des rapports et rapports détaillés-->
<!-- rapport détaillé-->
    <?php foreach($reports as $report){ ?>
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
            <form class="filter" method="POST">
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
                                    <li class="form-check <?php if(defaultValueCheckbox('breedSelected'.$i)!='checked') echo('none'); ?> js-liBreedsSelected">
                                        <input class="form-check-input js-checkboxBreedsSelected" type="checkbox" name="breedSelected<?php echo($i);?>" id="breedSelected<?php echo($i);?>" value="<?php echo($breed['id_breed']) ?>" <?php echo(defaultValueCheckbox('breedSelected'.$i)); ?>>
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
                                        <input class="form-check-input js-checkboxBreedsSearch" type="checkbox" name="breed<?php echo($i);?>" id="breed<?php echo($i);?>" <?php echo(defaultValueCheckbox('breedSelected'.$i)); ?>>
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
                                    <input class="form-check-input js-vetoCheckbox" type="checkbox" name="veto<?php echo($i);?>" id="veto<?php echo($i);?>" value="<?php echo($veto['mail']) ?>" <?php echo(defaultValueCheckbox('veto'.$i)) ?>>
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
                    <button class="buttonFilter btn-red" id="cancelFilter">Annuler le filtre</button>
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
            <?php foreach($reports as $report){ ?>
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
            <?php } ?>
        </tbody>
    </table>
    <script src="../View/assets/script/search.js"></script>
    <script src="../View/assets/script/popup.js"></script>
    <script src="../View/assets/script/medicalReports.js"></script>
    <script src="../View/assets/script/allMedicalReports.js"></script>
</section>
