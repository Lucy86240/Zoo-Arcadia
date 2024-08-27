<?php if($_SERVER['REQUEST_URI']=='/View/pages/housings/addHousing.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
    < class="newHousing">
        <div class="head"> </div>
        <?php $optionPage=true;?>
        <form class="formNewHousing" method="POST" enctype = "multipart/form-data">
            <h1 class="title">Ajout d'un habitat</h1>
            <div class="elements">
                <div class="elements-input">
                    <div class="element">
                        <label for="newHousingName">Nom :</label>
                        <input type="text" name="newHousingName" id="newHousingName" pattern="^([a-zA-Z0-9èéëïç ])+$" required />
                    </div>
                    <div class="element">
                        <label for="newHousingDescription">Description :</label>
                        <textarea name="newHousingDescription" id="newHousingDescription" maxlength="255" required></textarea>
                    </div>
                    <div class="element">
                        <div class="addImg">
                            <p class="title">Ajouter une photo</p>

                            <div class="img-element"><input type="file" name="newHousingPhoto" id="newHousingPhoto"></div>

                            <div class="img-element"><label for="NHP-Description">Description de la photo :</label>
                            <input type="text" name="NHP-Description" id="NHP-Description" pattern="^([a-zA-Z0-9èéëïç&!?,:;() ])+$"/></div>

                            <div class="img-element"><input type="checkbox" name="NHP-checkboxPortrait" id="checkbox-portrait">
                            <label for="checkbox-portrait<?php echo($Housing['id']); ?>">la photo est en portrait</label></div>
                            <p>Pour info : la photo doit être au format jpg ou png et ne pas dépasser 5 Mo.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-submit">
                <input type="submit" value="Ajouter" name="addHousing" class="button btn-brown" />
                <button class="button btn-red">Annuler</button>      
                <a href="../habitats" class="button btn-green">Retour aux habitats</a>     
            </div>
        </form>
        <?php if(isset($msg)){
            if($msg == "success"){ ?>
                <div class="msg success">
                    <img class="illustration" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/good.png" alt="">
                    <p><?php echo('L\'Habitat a été mis à jour avec succès!'); ?></p>
                </div>
            <?php }else{ ?>
                <div class="msg error">
                    <img class="illustration" src="<?php if(isset($optionPage) && $optionPage){echo("../");}?>View/assets/img/general/problem.png" alt="">
                    <p><?php echo($msg); ?></p>
                </div>
            <?php } ?>
        <?php }?>
        <script src="View/assets/script/addHousing.js"></script>
    </section>
<?php } ?>