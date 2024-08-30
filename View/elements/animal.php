<?php if($_SERVER['REQUEST_URI']=='/View/elements/animal.php'){
    ?>
    <link rel="stylesheet" href = "../assets/css/style.css">
    <?php
    require_once '../pages/404.php';
}
else{?>
    <section class="animal">
        <div class="<?php if(isset($theme) && $theme!=null) echo($theme); else echo("theme-beige"); if(isset($reverse) && $reverse) echo(' reverse');?> layout">
        <?php if(authorize(['connected'])){ ?>
            <div class="barre-backoffice">
                <div class="box-backoffice">
                        <!-- Boite à outil de l'animal
                            - éditer l'animal v
                            - supprimer l'animal v
                            - l'archiver
                        -->
                    <?php if(authorize(['Administrateur.rice'])){ ?>
                        <div class="box-general">
                            <!-- icon pour modifier l'animal-->
                            <a class="icon UpdateAnimalIcon" href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>maj_animal/?id=<?php echo($animal['id'])?>">
                                <div class="bgc-img-box"><img class="img-box editAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/edit.svg" alt="Modifier l'animal"></div>                                <span class="legendAnimal">Modifier</span>
                            </a>
                            <!-- icon archivage (seulement si l'animal est visible-->
                            <div class="icon iconArchive <?php if($animal['isVisible']==0) echo('none');?>" id="<?php echo($animal['id'])?>" nameAnimal = "<?php echo($animal['name'])?>" breedAnimal="<?php echo($animal['breed'])?>">
                                <div class="bgc-img-box"><img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/archive.svg" alt="Archiver l'animal"></div>
                                <span class="legendAnimal">Archiver</span>
                            </div>
                            <!-- le popup d'archivage s'affichant quand l'icone est cliquée-->
                            <div class="none c-dialog popupArchive dialog-popup-js">
                                <div class="fond"> </div>
                                <form class="popup-confirm" method="POST">
                                        <p class="entete">Archivage</p>
                                        <p>Etes vous sûr de vouloir archiver l'animal : "<?php echo($animal['name'].'" de race "'.$animal['breed']);?>" ?</p>
                                        <span>L'animal ne sera plus visible auprès des visiteurs et ne sera plus accessible depuis les habitats.</span>
                                        <span>Vous pourrez toujours le consulter depuis la liste des animaux.</span>
                                        <div class="confirm-choice">
                                            <input type="submit" name="ValidationArchiveAnimal<?php echo($animal['id']);?>" value="Oui" class="button-confirm js-archive">
                                            <button class="button btn-green">Non</button>
                                        </div>
                                </form>
                            </div>
                            <!-- icon désarchivage (seulement si l'animal est non-visible-->
                            <div class="icon iconUnarchive <?php if($animal['isVisible']==1) echo('none');?>" id="<?php echo($animal['id'])?>" nameAnimal = "<?php echo($animal['name'])?>" breedAnimal="<?php echo($animal['breed'])?>">
                                <div class="bgc-img-box"><img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/unarchive.svg" alt="Désrchiver l'animal"></div>
                                <span class="legendAnimal">Désarchiver</span>
                            </div>
                            <!-- le popup d'archivage s'affichant quand l'icone est cliquée-->
                            <div class="none c-dialog popupUnarchive">
                                <div class="fond"> </div>
                                <form class="popup-confirm" method="POST">
                                        <p class="entete">Désarchivage</p>
                                        <p>Etes vous sûr de vouloir désarchiver l'animal : "<?php echo($animal['name'].'" de race "'.$animal['breed']);?>" ?</p>
                                        <span>L'animal sera à nouveau visible auprès des visiteurs et accessible depuis les habitats.</span>
                                        <div class="confirm-choice">
                                            <input type="submit" name="ValidationUnarchiveAnimal<?php echo($animal['id']);?>" value="Oui" class="button-confirm js-archive">
                                            <button class="button btn-green">Non</button>
                                        </div>
                                </form>
                            </div>
                            <div class="icon iconDeleteAnimal" id="<?php echo($animal['id'])?>" nameAnimal = "<?php echo($animal['name'])?>" breedAnimal="<?php echo($animal['breed'])?>">
                                <div class="bgc-img-box"><img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/delete.svg" alt="Supprimer l'animal"></div>
                                <span class="legendAnimal">Supprimer</span>
                            </div>
                        </div>
                    <?php } ?>
                        <!-- Boite à outil des repas
                            - donner à manger
                            - voir ses repas
                        -->
                    <div class="box-feed">
                        <div class="icon">
                            <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>repas_animal/?animal=<?php echo($animal['id']); ?>">
                                <div class="bgc-img-box"><img class="img-box mealsAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/meals.svg" alt="Visualiser les repas"></div>
                                <span class="legendAnimal">Repas</span>
                            </a>
                        </div>
                        <?php if(authorize(['Employé.e'])){ ?>
                            <div class="icon">
                                <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>nourrir/?animal=<?php echo($animal['id']); ?>">
                                    <div class="bgc-img-box"><img class="img-box feedAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/feed.svg" alt="Nourrir"></div>
                                        <span class="legendAnimal">Nourrir</span>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Boite à outil pour les comptes rendus médicaux
                            - rédiger un compte rendu
                            - voir les comptes rendus
                        -->
                    <?php if(authorize(['Administrateur.rice','Vétérinaire'])){ ?>
                        <div class="box-cure">
                            <div class="icon">
                                <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>rapports_medicaux_animal/?animal=<?php echo($animal['id']); ?>">
                                    <div class="bgc-img-box"><img class="img-box reportMedicalAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/description.svg" alt="Visualiser les rapports médicaux"></div>
                                    <span class="legendAnimal">Rapport médicaux</span>
                                </a>
                            </div>
                            <?php if(authorize(['Vétérinaire'])){ ?>
                            <div class="icon">
                                <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>nouveau_rapport/?animal=<?php echo($animal['id']); ?>">
                                    <div class="bgc-img-box"><img class="img-box newReportAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/note_add.svg" alt="Ajouter un rapport médical"></div>
                                    <span class="legendAnimal">Nouveau rapport</span>
                                </a>
                            </div>
                            <?php }?>
                        </div>
                    <?php }?>
                </div>
                <div class="<?php if($animal['isVisible']==1) echo('none') ?>">
                    <span class=" notVisible">Archivé</span>
                </div>
            </div>
        <?php }?>

            <div class="title">
                <h2><?php echo($animal['name']); ?></h2>
                <h3><?php echo($animal['breed']); ?></h3>
            </div>
            <div class="body">
                <div class="images" id_animal="<?php echo($animal['id']); ?>">
                    <?php for($i=0; $i<count($animal['images']); $i++){?>
                        <div class="img-container js-slideAnimal">
                            <img class="imgAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");} echo($animal['images'][$i]['path']);?>" alt="<?php echo($animal['images'][$i]['description']);?>">
                        </div>
                    <?php } 
                    
                    if (count($animal['images']) >1){ ?>
                        <div class ="pagination">
                            <?php $color = "brown";
                                if(isset($btn) && $btn != null) $color = $btn; ?>
                            <!-- image précédente -->
                                <div class="btn-previous bp-<?php echo($color);?> js-carousel__prev">
                                    <img class="previous-img" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/buttons/previous_<?php echo($color);?>.png" alt="Bouton précédent">
                                    <p class="previous-text txt-pagination">Précédent</p> 
                                </div>   
                            <!-- image suivante -->
                                <div class="btn-next bn-<?php echo($color);?> js-carousel__next">
                                    <p class="next-text txt-pagination">Suivant</p> 
                                    <img class="next-img" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/buttons/next_<?php echo($color);?>.png" alt="Bouton suivant">
                                </div>    
                        </div>
                    <?php } ?>
                </div>
                <div class="description">
                    <div class="element">
                        <p><span>Son habitat :</span>
                        <?php echo($animal['housing']); ?></p>
                    </div>
                    <?php if(isset($animal['LastMedicalReport'])){?>
                        <div class="element">
                            <p> <span>Son état :</span> 
                            <?php echo($animal['LastMedicalReport']['health']); ?></p>
                        </div>
                        <div class="element"> 
                            <p> <span>Sa nourriture :</span>
                            <?php echo($animal['LastMedicalReport']['food']); ?></p>
                        </div>
                        <div class="element"> 
                            <p> <span>Son grammage :</span> 
                            <?php echo($animal['LastMedicalReport']['weight_of_food']); ?></p>
                        </div>
                        <div class="element">
                            <p> <span>Détail de son état :</span>
                            <?php echo($animal['LastMedicalReport']['comment']); ?></p>
                        </div>
                        <div class="element">
                            <p> <span>Dernière visite du vétérinaire :</span>
                            <?php echo($animal['LastMedicalReport']['date']); ?></p>
                        </div>
                    <?php }
                    else { ?>
                        <div class="element">
                            <p> <span>L'animal va bientot recevoir la visite du vétérinaire.</span>
                            Vous pourrez ensuite voir son avis.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div id="js-confirm"> </div>
    </section>
<?php } ?>