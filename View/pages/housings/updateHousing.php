<?php if($_SERVER['REQUEST_URI']=='/View/pages/housings/updateHousing.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
}
else{?>
    <section class="updateHousing">
        <div class="head"> </div>
        <?php $optionPage=true;?>
        <form class="formUpdateHousing" method="POST" enctype = "multipart/form-data">
            <h1 class="title">Modification de l'habitat en cours</h1>
            <div class="elements">
                <div class="elements-input">
                    <div class="element">
                        <label for="updateHousingName">Nom :</label>
                        <input type="text" name="updateHousingName" id="updateHousingName" value="<?php echo($housing['name']) ?>" pattern="^([a-zA-Z0-9èéëïç ])+$" required />
                    </div>
                    <div class="element">
                        <label for="updateHousingDescription">Description :</label>
                        <textarea name="updateHousingDescription" id="updateHousingDescription" maxlength="255" required><?php echo($housing['description']) ?></textarea>
                    </div>
                    <div class="element">
                        <div class="addImg">
                            <p class="title">Ajouter une photo</p>

                            <div class="img-element"><input type="file" name="UpdateHousingPhoto<?php echo($housing['id']); ?>" id="UpdateHousingPhoto<?php echo($housing['id']); ?>"></div>

                            <div class="img-element">
                                <label for="UAP-Description<?php echo($Housing['id']); ?>">Description de la photo :</label>
                                <textarea name="UAP-Description<?php echo($Housing['id']); ?>" id="UHP-Description<?php echo($housing['id']); ?>"> </textarea>
                            </div>
                            <div class="img-element">
                                <label for="UAP-attribution<?php echo($Housing['id']); ?>">Attribution :</label>
                                <textarea name="UAP-attribution<?php echo($Housing['id']); ?>" id="UHP-attribution<?php echo($housing['id']); ?>"> </textarea>
                            </div>

                            <div class="img-element">
                                <input type="checkbox" name="UHP-checkboxPortrait<?php echo($housing['id']); ?>" id="checkbox-portrait<?php echo($housing['id']); ?>">
                                <label for="checkbox-portrait<?php echo($housing['id']); ?>">la photo est en portrait</label>
                            </div>
                            <p>Pour info : la photo doit être au format jpg ou png et ne pas dépasser 5 Mo.</p>
                        </div>
                    </div>
                </div>
                <div class="imgs">
                    <h2>Photos de l'habitat</h2>
                    <?php if($housing['images'][0]['id']==0) { ?> 
                        <p>l'habitat n'a aucune photo</p>
                    <?php } else{
                        for($i=0; $i<count($housing['images']); $i++){?>
                            <div class="img-container">
                                <label class="bgc-icon" for="checkbox<?php echo($i)?>">
                                    <input type="checkbox" name="checkbox<?php echo($i)?>" id="checkbox<?php echo($i)?>" class="checkbox" value="<?php echo($housing['images'][$i]['id']) ?>">
                                    <img class="iconDelete" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/icons/delete.svg" alt="Supprimer l'Housing">
                                </label>
                                <img class="imgUpdateHousing" src="<?php if(isset($optionPage) && $optionPage){echo("../");} echo($housing['images'][$i]['path']);?>" alt="<?php echo($housing['images'][$i]['description']);?>">
                            </div>
                        <?php } ?>
                        <p class="attention">Attention toutes les photos avec une icone rouge seront supprimées après "Modifier".</p>
                <?php } ?>
                </div>
            </div>
            <div class="form-submit">
                <input type="submit" value="Modifier" name="updateHousing" class="button btn-brown" />
                <button class="button btn-red">Annuler</button>      
                <a href="../habitats" class="button btn-green">Retour aux habitats</a>     
            </div>
        </form>
        <?php if(isset($msg)){
            if($msg == "success"){ ?>
                <div class="msg success">
                    <img class="illustration" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/good.png" alt="">
                    <p><?php echo('L\'habitat a été mis à jour avec succès!'); ?></p>
                </div>
            <?php }else{ ?>
                <div class="msg error">
                    <img class="illustration" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/problem.png" alt="">
                    <p><?php echo($msg); ?></p>
                </div>
            <?php } ?>
        <?php }?>
        <script src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/script/updateAddHousing.js"></script>
    </section>
<?php }?>