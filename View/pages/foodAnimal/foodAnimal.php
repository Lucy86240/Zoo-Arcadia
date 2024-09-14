<?php if($_SERVER['REQUEST_URI']=='/View/pages/foodAnimal/foodAnimal.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
}
else{?>
    <section class="foodAnimal foodsForAnAnimal">
        <div class="themeBeige">
            <?php $optionPage = true ?>
            <div class="head"> </div>

            <!-- icons permettant la navigation vers d'autres éléments clés-->
            <div class="icons">
                <div class="icon js-icon js-animal <?php if($animal==null) echo("none"); ?>">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/article.svg" alt="Voir la fiche de l'animal"></div>
                </div>
                <a class="icon js-icon" href="../animaux">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/list.svg" alt="Voir la liste des animaux"></div>
                </a>
                <?php  if(authorize(['Employé.e'])){?>
                <div class="icon js-icon" id="popupFed">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/feed.svg" alt="Ajouter un repas"></div>
                </div>
                <?php } ?>
                <a class="icon js-icon" href="../repas">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/icons/meals.svg" alt="Voir la liste de tous les repas"></div>
                </a>
            </div>
            <div class="legends">
                <span class="legend js-legend none">Voir la fiche de l'animal</span>
                <span class="legend js-legend none">Voir la liste de tous les animaux</span>
                <?php  if(authorize(['Employé.e'])){?>
                <span class="legend js-legend none">Nourrir l'animal</span>
                <?php } ?>
                <span class="legend js-legend none">Voir la liste de tous les repas confondus</span>
            </div>
            <?php  if(authorize(['Employé.e'])){?>
            <div class="none c-dialog" id="dialogFed">
                <div class="fond"></div>
                <div role="document" class="c-dialog__box themeBeige popup Fed">
                    <div class="entete">
                        <h3 class="dialog-title">Nourrir l'animal</h3>
                        <button class="close" id="closeFed" type="button">x</button>
                    </div>
                <?php include_once "View/pages/foodAnimal/fedAnimal.php";?>
                </div>
            </div>
            <?php } ?>

            <!-- fiche de l'animal lié aux rapports-->
            <div class="none c-dialog js-animal-popup">
                <div class="fond"> </div>
                <div class="popup c-dialog__box themeBeige animalContainer">
                    <div class="Entete">
                        <h3 class="dialog-title">Fiche détaillée de l'animal</h3>
                        <button class="close buttonCloseAnimal" type="button" aria-label="Fermer" title="Fermer rapport">x</button>
                    </div>
                <?php 
                    $theme = "theme-beige";
                    $btn = "white";
                    include_once "View/elements/animal.php"; ?>
                </div>
            </div>
            <!-- tableau des repas et filtres-->
            <?php if($animal != null && isset($animal['foods'])){?>
                <table>
                    <caption>
                        <div class="entete">
                            <img class="illustration" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/pages/food/monkey.png" alt="">
                            <div class="title">
                                <h1>Repas :</h1> 
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
                                        <?php   if(defaultValue('dateStart')=='') $default = count($animal['foods']);
                                                else $default = defaultValue('dateStart'); ?>
                                        <input type="number" name="limit" min="1" max="<?php echo($animal['numberFoods']) ?>" placeholder="<?php echo($default);?>">
                                        <span> derniers comptes rendus / <?php echo($animal['numberFoods']) ?>  </span>
                                    </div>
                                    <div>
                                        <label for="dateStart">De </label>
                                        <input type="date" name="dateStart" id="dateStart" value="<?php echo(defaultValue('dateStart'));?>">
                                        <label for="dateEnd">à </label>
                                        <input type="date" name="dateEnd" id="dateEnd" value="<?php echo(defaultValue('dateEnd'));?>">
                                    </div>
                                </div>
                                <div class="confirmChoices">
                                    <input class="btn-green" type="submit" value="Appliquer" name="choices">
                                    <button class="buttonFilter btn-red">Annuler le filtre</button>
                                </div>
                        </form>
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col"> <h3>Date</h3> </th>
                            <th scope="col"> <h3>Employé.e</h3> </th>
                            <th scope="col"> <h3>Nourriture</h3> </th>
                            <th scope="col"> <h3>Quantité</h3> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0; $i<count($animal['foods']);$i++){ ?>
                            <tr>
                                <th scope="row"><?php echo(date("d/m/Y",strtotime($animal['foods'][$i]['date'])).' '.$animal['foods'][$i]['hour']); ?></th>
                                <td><?php echo($animal['foods'][$i]['employee']); ?></td>
                                <td><?php echo($animal['foods'][$i]['food']); ?></td>
                                <td><?php echo($animal['foods'][$i]['weight']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php }
            //cas où l'animal n'a pas encore de compte rendu
            else if(!isset($animal['foods']) && $animal!=null){
                ?><p class="error"> <?php echo($animal['name'].' ('.$animal['breed'].") n'a pas encore reçu de repas."); ?> </p> <?php
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