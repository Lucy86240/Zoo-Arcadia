<section class="allComments">
    <div class="head"> </div>
    <div class="icons">
        <a class="icon js-iconComments" href="habitats">
            <div class="bgc-img-box"><img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/housing.svg" alt="Voir les habitats"></div>
        </a>
        <div class="<?php permission(['vétérinaire']);?> icon js-iconComments js-iconAddComments" id_housing="<?php echo($housing['id']) ?>">
            <img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/note_add.svg" alt="Ajouter un commentaire">
        </div>       
    </div>
    <div class="legendsComments">
        <span class="js-legendComments none">Voir les habitats</span>
        <span class="js-legendComments none">Ajouter un commentaire</span>
    </div>
    <div id="addComment" class="none c-dialog">
        <div class="fond"></div>
        <div role="document" class="c-dialog__box popup">
            <div class="Entete">
                <h3 class="dialog-title">Nouveau commentaire</h3>
                <button class="close" type="button" aria-label="Fermer" title="Fermer nouveau commentaire" data-dismiss="dialog">x</button>
            </div>
        <?php include_once "View/pages/commentsVetoHousing/addComments.php"?>
        </div>
    </div>
    <h1>Commentaires des vétérinaires</h1>
    <form method="POST" id="filter" action="">
        <div class="titleFilter"><span>Filtres </span></div>
        <div class="bodyFilter">
            <div class="element">
                <span>Habitats : </span>
                <div>
                    <?php $housings = listNameIdAllHousings();
                    $count=0;
                    foreach($housings as $housing){ ?>
                        <div>
                            <input type="checkbox" name="housing<?php echo($count) ?>" id="housing<?php echo($count) ?>" value="<?php echo($housing['id_housing']) ?>">
                            <label for="housing<?php echo($count) ?>"> <?php echo($housing['name']);?> </label>
                        </div>
                    <?php $count++; } ?>
                </div>
            </div>
            <div class="element">
                <span>Statut : </span>
                <div>
                    <div>
                        <input type="checkbox" name="archive" id="archive">
                        <label for="archive">Archivé </label>
                    </div>
                    <div>
                        <input type="checkbox" name="unarchive" id="unarchive">
                        <label for="unarchive">Actif </label>
                    </div>
                </div>
            </div>
            <div class="elementDate">
                <label for="dateStart">De </label>
                <input type="date" name="dateStart" id="dateStart" >
                <label for="dateEnd">à </label>
                <input type="date" name="dateEnd" id="dateEnd">
            </div>
        </div>
        <div class="confirmChoices">
            <input class="btn-DarkGreen" type="submit" value="Appliquer" name="filter">
            <button class="buttonFilter btn-red" id="cancelFilter">Annuler le filtre</button>
        </div>
    </form>
    <div class="commentsVeto">
        <?php foreach($comments as $comment){ ?>
            <div class="comment">
                <div class="headComment">
                    <div><span class="housingComment">Pour : <?php echo($comment['housing']);?></span></div>
                    <div class="icons">
                        
                            <div class="icon">
                                <?php if($comment['archive']==0){ ?>
                                    <img class="img-box js-iconArchive" id_comment="<?php echo($comment['idComment']) ?>" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/archive.svg" alt="Archiver le commentaire">
                                <?php } else{ ?>
                                    <img class="img-box js-iconUnarchive" id_comment="<?php echo($comment['idComment']) ?>" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/unarchive.svg" alt="Désarchiver le commentaire">
                                <?php } ?>
                            </div>
                        
                        <div class="<?php //permission(['vétérinaire']);?> icon deleteIcon popupDesktop" id_comment="<?php echo($comment['idComment']) ?>">
                            <img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/delete.svg" alt="Supprimer le commentaire">
                        </div>
                    </div>
                </div>
                    
                        <span><?php echo("\"".$comment['comment']."\"");?></span>
                        <div class="footerComment">
                            <span>le <?php echo($comment['date']);?></span>
                            <span>de <?php echo($comment['veterinarian']);?></span>
                        </div>
                    </div>     
        <?php } ?>
    </div>
    <div id="js-confirm"> </div>

    <script src="View/assets/script/commentVetoHousing.js"></script>
</section>