<form class="none editServiceForm" method="POST" action="services" enctype = "multipart/form-data">
            <span class="title-form">Modification en cours</span>
            <div class="txt">
                <div class="element">
                    <label for="UpdateServiceName<?php echo($service['id_service']);?>">Intitulé :</label>
                    <div>
                        <input type="text" name="UpdateServiceName<?php echo($service['id_service']);?>" id="UpdateServiceName<?php echo($service['id_service']);?>" maxlength="155" value="<?php echo($service['name']);?>"/>
                        <p>Max 155 caractères</p>
                    </div>
                </div>
                <div class="element">
                    <label for="UpdateServiceDescription<?php echo($service['id_service']);?>">Description :</label>
                    <div>
                        <textarea class="update-description" name="UpdateServiceDescription<?php echo($service['id_service']);?>" id="UpdateServiceDescription<?php echo($service['id_service']);?>" maxlength="255"><?php echo($service['description']);?></textarea>
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
                            <img class="imgForm-service" src="<?php echo($service['icon']->getPath());?>" alt="<?php echo($service['icon']->getDescription()); ?>">
                        </div>
                        <div>
                        <input type="file" name="UpdateServiceIcon<?php echo($service['id_service']);?>" id="UpdateServiceIcon<?php echo($service['id_service']);?>">
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
                            <img class="imgForm-service" src="<?php echo($service['photo']->getPath());?>" alt="<?php echo($service['photo']->getDescription()); ?>">
                        </div>
                        <div>
                            <input type="file" name="UpdateServicePhoto<?php echo($service['id_service']);?>" id="UpdateServicePhoto<?php echo($service['id_service']);?>" >
                            <div>
                                <label for="USP-Description<?php echo($service['id_service']);?>">Description de la photo :</label>
                                <input type="text" name="USP-Description<?php echo($service['id_service']);?>" id="USP-Description<?php echo($service['id_service']);?>">
                            </div>
                            <div>
                                <input type="checkbox" name="USP-checkboxPortrait<?php echo($service['id_service']);?>" id="USP-checkboxPortrait<?php echo($service['id_service']);?>">
                                <label for="USP-checkboxPortrait<?php echo($service['id_service']);?>">l'image est en portrait</label>
                            </div>
                                <p>Pour info : la photographie doit être au format jpg ou png et ne pas dépasser 5 Mo.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-submit">
                <div><input type="submit" value="Modifier" name="UpdateReview" class="buttonSubmit btn-brown"/></div>
                <button class="button btn-red">Annuler</button>
            </div>
</form>