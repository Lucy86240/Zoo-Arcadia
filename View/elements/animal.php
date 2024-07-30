<section class="animal">
    <div class="<?php if(isset($theme) && $theme!=null) echo($theme); else echo("theme-beige");?> layout">
        <div class="box-backoffice">
            <!-- Boite à outil de l'animal
                - éditer l'animal v
                - supprimer l'animal v
                - l'archiver
            -->
            <div class="box-general">
                <!-- icon pour modifier l'animal-->
                <a class="icon UpdateAnimal" href="maj_animal/?id=<?php echo($animal['id'])?>">
                    <div class="bgc-img-box"><img class="img-box editAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/edit.svg" alt="Modifier l'animal"></div>
                    <span class="legend">Modifier</span>
                </a>
                <div class="icon">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/archive.svg" alt="Archiver l'animal"></div>
                    <span class="legend">Archiver</span>
                </div>
                <div class="icon deleteDesktop">
                    <div class="bgc-img-box"><img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/delete.svg" alt="Supprimer l'animal"></div>
                    <span class="legend">Supprimer</span>
                </div>
                <!-- le popup de suppression s'affichant quand la poubelle est cliquée-->
                <div class="none c-dialog dialog-delete-js">
                    <div class="fond"> </div>
                    <form class="popup popup-delete" method="POST">
                            <span class="Entete">Suppression</span>
                            <p>Etes vous sûr de vouloir supprimer l'animal : "<?php echo($animal['name'].'" de race "'.$animal['breed']);?>" ?</p>
                            <div class="delete-choice">
                                <input type="submit" name="ValidationDeleteAnimal<?php echo($animal['id']);?>" value="Oui" class="button-delete">
                                <button class="button btn-green">Non</button>
                            </div>
                    </form>
                </div>
            </div>
            <!-- Boite à outil des repas
                - donner à manger
                - voir ses repas
            -->
            <div class="box-feed">
                <div class="icon">
                    <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>repas_animal/?animal=<?php echo($animal['id']); ?>">
                        <div class="bgc-img-box"><img class="img-box mealsAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/meals.svg" alt="Visualiser les repas"></div>
                        <span class="legend">Repas</span>
                    </a>
                </div>
                <div class="icon">
                    <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>nourrir/?animal=<?php echo($animal['id']); ?>">
                        <div class="bgc-img-box"><img class="img-box feedAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/feed.svg" alt="Nourrir"></div>
                        <span class="legend">Nourrir</span>
                    </a>
                </div>
            </div>
            <!-- Boite à outil pour les comptes rendus médicaux
                - rédiger un compte rendu
                - voir les comptes rendus
            -->
            <div class="box-cure">
                <div class="icon">
                    <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>rapport_medicaux_animal/?animal=<?php echo($animal['id']); ?>">
                        <div class="bgc-img-box"><img class="img-box reportMedicalAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/description.svg" alt="Visualiser les rapports médicaux"></div>
                        <span class="legend">Rapport médicaux</span>
                    </a>
                </div>
                <div class="icon">
                    <a href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>nouveau_rapport/?animal=<?php echo($animal['id']); ?>">
                        <div class="bgc-img-box"><img class="img-box newReportAnimal" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/note_add.svg" alt="Ajouter un rapport médical"></div>
                        <span class="legend">Nouveau rapport</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="title">
            <h2><?php echo($animal['name']); ?></h2>
            <h3><?php echo($animal['breed']); ?></h3>
        </div>
        <div class="body">
            <div class="images">
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
                        <?php echo($animal['LastMedicalReport']['weightFood']); ?></p>
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
</section>
<script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/script/animal.js"></script>
<script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/script/delete.js"></script>