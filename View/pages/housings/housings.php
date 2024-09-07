<?php if($_SERVER['REQUEST_URI']=='/View/pages/housings/housings.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
}
else{?>
    <section class="housings theme-brown">
        <div class="head"></div>
        <div class="hero">
            <div class="title">
                <h2>Respectueux de leur écosystème naturel nous permettons à nos animaux de s’épanouir au coeur de </h2>
                <h1>Nos différents habitats</h1>
            </div>
            <div class="hero-housings">
                <?php $count=0; 
                foreach($housings as $housing){ 

                    //style adaptable pour le desktop

                    // rotation du 1er et dernier élément d'une ligne
                    $option = '';
                    if($count==0 || $count%6==0) $option="hero-housing__left";
                    else if(($count%5-4)==0 || $count==(count($housings)-1)) $option="hero-housing__right"; 
                    
                    //taille adaptable suivant nombre d'habitats
                    if(count($housings)<3){
                        $width_div = '21vw';
                        $height_div = '30vw';
                        $width_img = '20vw';
                        $height_img = '13vw';
                    } else if(count($housings)>5){
                        $width_div = '12vw';
                        $height_div = '16vw';
                        $width_img = '11vw';
                        $height_img = '7vw';
                    }
                    else{
                        $width_div = 68/count($housings).'vw';
                        $height_div = (68/count($housings)/3*4).'vw';
                        $width_img = (68/count($housings)-1).'vw';
                        $height_img = ((68/count($housings))/3*2).'vw';
                    }
                    // @media only screen and (min-width: 576px){ 
                    ?>
                    <!-- habitat type polaroïde -->
                    <div class="heroHousingWithBox <?php echo($option); ?>" >
                        <?php if(authorize(['Administrateur.rice'])){ ?>
                            <div class="icons">
                                <a class="icon UpdateHousingIcon" href="<?php if(isset($optionPage) && $optionPage){echo("../");}?>maj_habitat/?id=<?php echo($housing['id'])?>">
                                    <div class="bgc-img-box"><img class="img-box editHousing" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/edit.svg" alt="Modifier l'habitat"></div>
                                </a>
                                <div class="icon deleteIconHousing" id_housing="<?php echo($housing['id'])?>" name_housing="<?php echo($housing['name'])?>" nb_animal="<?php echo(count($housing['animals'])) ?>">
                                    <div class="bgc-img-box"><img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/delete.svg" alt="Supprimer l'habitat"></div>
                                </div>
                            </div>
                        <?php } ?>
                        <a href="#<?php echo("housing-".$housing['id'])?>" style = "width : <?php echo($width_div) ?>; height : <?php echo($height_div) ?>;}" class="hero-housing">
                            <img style = "max-width : <?php echo($width_img) ?>; max-height : <?php echo($height_img) ?>;" src="<?php echo($housing['images'][0]['path'])?>" alt="<?php echo($housing['images'][0]['description'])?>">
                            <h3><?php echo($housing['name'])?></h3>
                        </a>
                    </div>
                    <?php $count++; 
                } ?>
                <div id="js-confirm"></div>
            </div>
            <?php if(authorize(['Administrateur.rice'])){ ?>
            <a href="nouvel_habitat" class="back add"><button type="button" class="btn btn-beige">
                <img src="View/assets/img/general/icons/emoji_nature.svg">
                Ajouter un habitat
            </button></a>
            <?php } ?>

        </div>
        <!-- habitats détaillés-->
        <?php $count=0;
        foreach($housings as $housing){
            if($count%2 != 0) $reverse=true;
            else $reverse=false; ?>
            <section id="housing-<?php echo($housing['id']) ?>" class = "housing <?php if($reverse==true) echo('reverse'); ?>">
                <h2><?php echo($housing['name']) ?></h2>
                <div class="housing-detail">
                    <div class="images-container">
                        <?php for($i=0; $i<count($housing['images']); $i++){?>
                            <div class="<?php if($i>0) echo('none') ?> img-container js-slideHousing<?php echo($count) ?>">
                                <img class="imgHousing" src="<?php if(isset($optionPage) && $optionPage){echo("../");} echo($housing['images'][$i]['path']);?>" alt="<?php echo($housing['images'][$i]['description']);?>">
                            </div>
                        <?php } ?>
                        <div class="rounds rounds-white">
                            <?php $lenght = count($housing['images']);
                            if($lenght > 1){
                            for($i=0;$i<$lenght;$i++){ ?>
                                <div class="round round<?php echo($count) ?> <?php if($i==0) echo('round-selected') ?>"> </div>  
                            <?php } }
                            ?>
                        </div>
                    </div>
                    <div class="description">
                        <p><?php echo($housing['description']); ?></p>
                    </div>
                </div>
                <!-- Commentaires du vétérinaire-->
                <?php if(authorize(['connected'])){ ?>
                    <div class="commentsVeto">
                        <div class="headerComments">
                            <div class="icons">
                                <a class="icon js-iconComments" href="commentaires_habitats">
                                    <div class="bgc-img-box"><img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/description.svg" alt="Voir la liste de tous les commentaires"></div>
                                </a>
                                <?php if(authorize(['Vétérinaire'])){ ?>
                                <div class="icon js-iconComments js-iconAddComments" id_housing="<?php echo($housing['id']) ?>">
                                    <img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/note_add.svg" alt="Ajouter un commentaire">
                                </div>
                                <?php } ?>
                            </div>
                            <div class="title"><h3>Commentaires des vétérinaires</h3></div>
                        </div>
                        <div class="legendsComments">
                            <span class="js-legendComments none">Voir tous les commentaires</span>
                            <?php if(authorize(['Vétérinaire'])){ ?>
                                <span class="js-legendComments none">Ajouter un commentaire</span>
                            <?php } ?>
                        </div>
                        <?php if((count($housing['comments']) ==0)) {?>
                            <div class="comment">
                                <span>Les vétérinaires n'ont déposé aucun commentaire actif.</span>
                            </div>
                        <?php } else{ ?>
                        <?php foreach($housing['comments'] as $comment){ ?>
                            <div class="comment">
                                <div class="icons">

                                    <div class="icon js-iconArchive" id_comment="<?php echo($comment['idComment']) ?>">
                                        <img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/archive.svg" alt="Archiver le commentaire">
                                    </div>
                                    <?php if(authorize(['Vétérinaire'])){ ?>
                                        <div class="icon popupDesktop deleteIcon" id_comment="<?php echo($comment['idComment']) ?>">
                                            <img class="img-box" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/delete.svg" alt="Supprimer le commentaire">
                                        </div>
                                    <?php } ?>
                                </div>
                                <span><?php echo("\"".$comment['comment']."\"");?></span>
                                <div class="footerComment">
                                    <span>le <?php echo($comment['date']);?></span>
                                    <span>de <?php echo($comment['veterinarian']);?></span>
                                </div>
                            </div>
                        <?php } }?>
                        <div id="js-confirm"> </div>
                    </div>
                <?php } ?>
                <!-- les animaux -->
                <div class="list-animals">
                    <h3>Vous pouvez m'y retrouver :</h3>
                    <div class="search">
                        <input type="text" class="searchAnimal" placeholder="chercher">
                        <img class="searchIcon" src="View/assets/img/general/icons/search.svg">
                    </div>
                    <form method="POST" action="#animal<?php echo($housing['id'])?>">
                        <ul class="animalList">
                            <?php 
                            foreach($housing['animals'] as $animalList){ ?>
                            <li> 
                                <input type="radio" name="animal<?php echo($housing['id'])?>" id="animal<?php echo($housing['id'].'-'.$i);?>" value="<?php echo($animalList['id']);?>"> 
                                <label for="animal<?php echo($housing['id'].'-'.$i);?>">
                                    <?php echo($animalList['name'].' - '.$animalList['breed']) ?>
                                </label>
                            </li>
                            <?php $i++; } ?>
                        </ul>
                    </form>
                <div class="none messageNoResult"></div>
                </div>
                <?php if(authorize(['Administrateur.rice'])){ ?>
                    <a href="nouvel_animal/?housing=<?php echo($housing['id']) ?>" class="back add"><button type="button" class="btn btn-beige">
                        <img src="View/assets/img/general/icons/emoji_nature.svg">
                        Ajouter un animal
                    </button></a>
                <?php } ?>
                <!-- animal sélectionné-->
                <section class="animal" id="animal<?php echo($housing['id'])?>">
                    <?php 
                    if(isset($_POST['animal'.$housing['id']]) || isset($_SESSION['animal'.$housing['id']])){
                        include_once "Controller/ManageAnimal.php";
                        //si on a cliqué sur un animal
                        if(isset($_POST['animal'.$housing['id']])) $id=$_POST['animal'.$housing['id']];
                        // si on avait cliqué sur un animal
                        else $id=$_SESSION['animal'.$housing['id']];
                        //on affiche l'animal
                        if(!isset($_POST["ValidationDeleteAnimal".$id]))
                            echoAnimal($id,'housings',$housings);
                    }?>
            </section>
            <a href="habitats" class="button back "><button type="button" class="btn btn-beige">
                <img src="View/assets/img/general/icons/arrow_upward.svg">
                Retour aux habitats
            </button></a>
            </section>
        <?php   $count++;
        } ?>

        <?php if(authorize(['Vétérinaire'])){ ?>
        <div id="addComment" class="none c-dialog">
            <div class="fond"></div>
            <div role="document" class="c-dialog__box popup themeBeige">
                <div class="Entete">
                    <h3 class="dialog-title">Nouveau commentaire</h3>
                    <button class="close" type="button" aria-label="Fermer" title="Fermer nouveau commentaire" data-dismiss="dialog">x</button>
                </div>
            <?php include_once "View/pages/commentsVetoHousing/addComments.php"?>
        </div>
        <?php } ?>
        <script src="View/assets/script/popup.js"></script>
        <script src="View/assets/script/housings.js"></script>
        <script src="View/assets/script/commentVetoHousing.js"></script>
        <script src="View/assets/script/animal.js"></script>

    </section>
<?php } ?>