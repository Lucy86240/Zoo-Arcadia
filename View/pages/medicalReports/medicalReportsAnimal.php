<?php if($_SERVER['REQUEST_URI']=='/View/pages/medicalReports/medicalReportsAnimal.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
}
else{?>
    <section class="medicalReports medicalReportsAnimal">
        <?php $optionPage = true ?>
        <div class="themeBlue">
            <div class="head"> </div>

            <!-- icons permettant la navigation vers d'autres éléments clés-->
            <div class="icons">
                <div class="icon js-icon js-animal <?php if($animal==null) echo("none"); ?>">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/article.svg" alt="Voir la fiche de l'animal"></div>
                </div>
                <a class="icon js-icon" href="../animaux">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/list.svg" alt="Voir la liste des animaux"></div>
                </a>
                <?php if(authorize(['Vétérinaire'])){ ?>
                <div class="icon js-icon" id="popupNewReport">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/note_add.svg" alt="Ajouter un compte rendu"></div>
                </div>
                <?php } ?>
                <a class="icon js-icon" href="../rapports_medicaux">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/description.svg" alt="Voir la liste de tous les comptes rendus"></div>
                </a>
            </div>
            <div class="legends">
                <span class="legend js-legend none">Voir la fiche de l'animal</span>
                <span class="legend js-legend none">Voir la liste de tous les animaux</span>
                <?php if(authorize(['Vétérinaire'])){ ?>
                    <span class="legend js-legend none">Ajouter un compte rendu</span>
                <?php } ?>
                <span class="legend js-legend none">Voir la liste de tous les comptes rendus confondus</span>
            </div>
            <?php if(authorize(['Vétérinaire'])){ ?>
                <div class="none c-dialog" id="dialogNewReport">
                    <div class="fond"></div>
                    <div role="document" class="c-dialog__box themeBlue popup newReport">
                        <div class="entete">
                            <h3 class="dialog-title">Nouveau rapport médical</h3>
                            <button class="close" id="closeNewReport" type="button">x</button>
                        </div>
                    <?php include_once "View/pages/medicalReports/addMedicalReport.php";?>
                    </div>
                </div>
                <?php } ?>
            <!-- fiche de l'animal lié aux rapports-->
            <div class="none c-dialog js-animal-popup">
                <div class="fond"> </div>
                <div class="popup c-dialog__box animalContainer themeBlue">
                    <div class="Entete">
                        <h3 class="dialog-title">Fiche détaillée de l'animal</h3>
                        <button class="close buttonCloseAnimal" type="button" aria-label="Fermer" title="Fermer rapport">x</button>
                    </div>
                <?php 
                    $theme = "theme-blue";
                    $btn = "white";
                    include_once "View/elements/animal.php"; ?>
                </div>
            </div>

            <!-- liste des rapports et rapports détaillés-->
            <?php if($animal != null && isset($animal['reports'])){?>

                <!-- rapport détaillé-->
                <?php for($i=0; $i<count($animal['reports']);$i++){ ?>
                    <div class="none c-dialog reportView">
                        <div class="fond"> </div>
                        <div class="popup c-dialog__box reportViewContainer themeBlue">
                            <div class="Entete">
                                <h3 class="dialog-title">Rapport du <?php echo($animal['reports'][$i]['date']); ?></h3>
                                <button class="close buttonCloseReport" type="button" aria-label="Fermer" title="Fermer rapport">x</button>
                            </div>
                            <div class="body">
                                <div class="element">
                                    <span>Nom du vétérinaire : </span>
                                    <p><?php echo($animal['reports'][$i]['veterinarian']); ?></p>
                                </div>
                                <div class="element">
                                    <span>Etat de santé : </span>
                                    <p><?php echo($animal['reports'][$i]['health']); ?></p>
                                </div>
                                <div class="element">
                                    <span>Détail : </span>
                                    <p><?php echo($animal['reports'][$i]['comment']); ?></p>
                                </div>
                                <div class="element">
                                    <span>Nourriture proposée : </span>
                                    <p><?php echo($animal['reports'][$i]['food']); ?></p>
                                </div>
                                <div class="element">
                                    <span>Grammage : </span>
                                    <p><?php echo($animal['reports'][$i]['weight_of_food']); ?></p>
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
                                <h1>Rapports médicaux :</h1> 
                                </br>
                                <h2><?php echo('['.$animal['id'].'] '.$animal['name'].' - '.$animal['breed']); ?></h2>
                            </div>
                        </div>
                        <!-- filtres -->
                        <form class="filter" method="POST">
                                <span class="title">Filtre :</span>
                                <div>
                                    <div>
                                        <label for="limit">Limité aux </label>
                                        <input type="number" name="limit" min="1" max="<?php echo($animal['numberReports']) ?>" placeholder="<?php echo(count($animal['reports']));?>">
                                        <span> derniers comptes rendus / <?php echo($animal['numberReports']) ?>  </span>
                                    </div>
                                    <div>
                                        <label for="dateStart">De </label>
                                        <input type="date" name="dateStart" id="dateStart" value="<?php echo(defaultValue('dateStart'));?>">
                                        <label for="dateEnd">à </label>
                                        <input type="date" name="dateEnd" id="dateEnd" value="<?php echo(defaultValue('dateEnd'));?>">
                                    </div>
                                </div>
                                <div class="confirmChoices">
                                    <input class="btn-DarkGreen" type="submit" value="Appliquer" name="choices">
                                    <button class="buttonFilter btn-red">Annuler le filtre</button>
                                </div>
                        </form>
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col"> <h3>Date</h3> </th>
                            <th scope="col"> <h3>Vétérinaire</h> </th>
                            <th scope="col"> <h3>Santé</h3> </th>
                            <th scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0; $i<count($animal['reports']);$i++){ ?>
                            <tr>
                                <th scope="row"><?php echo(date("d/m/Y",strtotime($animal['reports'][$i]['date']))); ?></th>
                                <td><?php echo($animal['reports'][$i]['veterinarian']); ?></td>
                                <td><?php echo($animal['reports'][$i]['health']); ?></td>
                                <td class="reportLink">En savoir plus</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php }

            //cas où l'animal n'a pas encore de compte rendu
            else if(!isset($animal['reports']) && $animal!=null){
                ?><p class="error"> <?php echo($animal['name'].' ('.$animal['breed'].") n'a pas encore de compte rendu médical."); ?> </p> <?php
            }

            //cas où l'id de l'animal n'existe pas
            else{
                ?><p class="error"> <?php echo("Une erreur s'est produite : nous ne trouvons pas l'animal"); ?> </p> <?php
            } ?>
        </div>
        <script src="../View/assets/script/popup.js"></script>
        <script src="../View/assets/script/medicalReportsANDFood.js"></script>
        <script src="../View/assets/script/medicalReportsAnimalANDFood.js"></script>
        <script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/script/animal.js"></script>
    </section>
<?php } ?>