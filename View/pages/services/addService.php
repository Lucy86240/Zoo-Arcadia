<section class="newService">
            <div class="head"> </div>
                <h3>Ajouter un service</h3>
            <form method="POST" action="" enctype = "multipart/form-data">
                <div class="txt">
                    <div class="element">
                        <label for="NewServiceName">Intitulé :</label>
                        <input type="text" name="NewServiceName" id="NewServiceName" required />
                    </div>
                    <div class="element">
                        <label for="NewServiceDescription">Description :</label>
                        <textarea name="NewServiceDescription" id="NewServiceDescription" required></textarea>
                    </div>
                </div>
                <div class="images">
                    <div class="image">
                            <label class="title-img" for="NewServiceIcon">L'icone</label>
                            <input type="file" name="NewServiceIcon" id="NewServiceIcon" required>
                            <p>Pour info : l'icone doit être au format png et ne pas dépasser 100ko.</p>
                    </div>
                    <div class="image">
                            <label class="title-img" for="NewServicePhoto">La photo</label>
                            <input type="file" name="NewServicePhoto" id="NewServicePhoto" required>

                            <div><label for="NSP-Description">Description de la photo :</label>
                            <input type="text" name="NSP-Description" id="NSP-Description"></div>

                            <div><input type="checkbox" name="NSP-checkboxPortrait" id="checkbox-portrait">
                            <label for="checkbox-portrait">l'image est en portrait</label></div>
                            <p>Pour info : la photographie doit être au format jpg ou png et ne pas dépasser 5 Mo.</p>
                    </div>
                </div>
                <div class="form-submit">
                    <input type="submit" value="Ajouter" name="addReview" class="button btn-green" />
                    <?php addService(); ?>
                </div>
            </form>
    <script src="View/assets/script/popup.js"></script>
    <script src="View/assets/script/addService.js"></script>
</section>