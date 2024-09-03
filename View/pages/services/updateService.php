<?php if($_SERVER['REQUEST_URI']=='/View/pages/services/updateService.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
}
else{?>
    <form class="none editServiceForm" method="POST" action="services" enctype = "multipart/form-data">
        <span class="title-form">Modification en cours</span>
        <div class="txt">
            <div class="element">
                <label for="UpdateServiceName<?php echo($service['id_service']);?>">Intitulé :</label>
                <div>
                    <input type="text" class="js-UpdateServiceName" name="UpdateServiceName<?php echo($service['id_service']);?>" id="UpdateServiceName<?php echo($service['id_service']);?>" maxlength="155" value="<?php echo(echapHTML($service['name']));?>" pattern="^([a-zA-Z0-9èéëïç&!?,:;\(\)\- ])+$" required />
                    <p>Max 155 caractères</p>
                </div>
            </div>
            <div class="element">
                <label for="UpdateServiceDescription<?php echo($service['id_service']);?>">Description :</label>
                <div>
                    <textarea class="update-description" name="UpdateServiceDescription<?php echo($service['id_service']);?>" id="UpdateServiceDescription<?php echo($service['id_service']);?>" maxlength="255" required>
                        <?php echo(echapHTML($service['description']));?>
                    </textarea>
                    <p>Max 255 caractères</p>
                </div>
            </div>
        </div>
        <div class="images">
            <div class="image">
                <label class="title-img" for="UpdateServiceIcon<?php echo($service['id_service']);?>">Modifier l'icone</label>
                <div class="image-container">
                    <div class="illu-container">
                        <span>Actuelle</span>
                        <img class="imgForm-service" src="<?php echo($service['icon']['path']);?>" alt="<?php echo($service['icon']['description']); ?>">
                    </div>
                    <div>
                    <input type="file" name="UpdateServiceIcon<?php echo($service['id_service']);?>" id="UpdateServiceIcon<?php echo($service['id_service']);?>">
                    <div class="elementTextarea">
                        <span>Attribution :</span>
                        <textarea class="js-USP-Description" name="USI-Attr<?php echo($service['id_service']);?>" id="USI-Attr<?php echo($service['id_service']);?>">
                            <?php echo($service['icon']['attribution'])?>
                        </textarea>
                    </div>
                    <p>
                        Pour info : l'icone doit être au format png et ne pas dépasser 100ko. <br>
                        Idéalement : l'icone est bleue (#23395B) avec un fond transparent.
                    </p>
                    <a href="https://www.flaticon.com/fr/">Je peux en trouver une ici.</a>
                    </div>
                </div>
            </div>
            <div class="image">
                <label class="title-img" for="UpdateServicePhoto<?php echo($service['id_service']);?>">Modifier la photo</label>
                <div class="image-container">
                    <div class="illu-container">
                        <span>Actuelle</span>
                        <img class="imgForm-service" src="<?php echo($service['photo']['path']);?>" alt="<?php echo($service['photo']['description']); ?>">
                    </div>
                    <div>
                        <input type="file" name="UpdateServicePhoto<?php echo($service['id_service']);?>" id="UpdateServicePhoto<?php echo($service['id_service']);?>" />
                        <div class="elementTextarea">
                            <span>Description de la photo :</span>
                            <textarea class="js-USP-Description" name="USP-Description<?php echo($service['id_service']);?>" id="USP-Description<?php echo($service['id_service']);?>">
                                <?php echo(echapHTML($service['photo']['description']))  ?> 
                            </textarea>
                        </div>
                        <div class="elementTextarea">
                            <span>Attribution :</span>
                            <textarea class="js-USP-Description" name="USP-Attr<?php echo($service['id_service']);?>" id="USP-Attr<?php echo($service['id_service']);?>">
                                <?php echo($service['photo']['attribution'])  ?> 
                            </textarea>
                        </div>
                        <div>
                            <input type="checkbox" name="USP-checkboxPortrait<?php echo($service['id_service']);?>" id="USP-checkboxPortrait<?php echo($service['id_service']);?>" <?php if($service['photo']['portrait']) echo('checked') ?>/>
                            <label for="USP-checkboxPortrait<?php echo($service['id_service']);?>">l'image est en portrait</label>
                        </div>
                            <p>Pour info : la photographie doit être au format jpg ou png et ne pas dépasser 5 Mo.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-submit">
            <div><input type="submit" value="Modifier" name="UpdateReview<?php echo($service['id_service']);?>" class="buttonSubmit btn-brown"/></div>
            <button class="button btn-red">Annuler</button>
        </div>
    </form>
<?php } ?>