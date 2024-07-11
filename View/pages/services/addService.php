<section class="NewService">
    <button type="button" id="popup-service" aria-haspopup="dialog" aria-controls="dialog" class="btn btn-green">
        Ajouter un service
    </button>
    <div id="new-service-dialog" role="dialog" aria-labelledby="dialog-title" aria-describedby="dialog-desc" aria-modal="true" aria-hidden="true" tabindex="-1" class="c-dialog">
        <div class="fond"></div>
        <div role="document" class="c-dialog__box">
            <div class="Entete">
                <h3 class="dialog-title">Mon nouveau service</h3>
                <button type="button" aria-label="Fermer" title="Fermer nouveau service" data-dismiss="dialog">x</button>
            </div>
            <form method="POST" action="">
                <div class="element">
                    <label for="NewServiceName">L'intitulé du service :</label>
                    <input type="text" name="NewReviewPseudo" id="NewServiceName" required />
                </div>
                <div class="element">
                    <label for="NewServiceDescription">La description :</label>
                    <textarea name="NewServiceDescription" id="NewServiceDescription" required></textarea>
                </div>
                <div class="element">
                    <label for="NewServiceIcon">L'icone :</label>
                    <input type="text" name="NewServiceIcon" id="NewServiceIcon" required></inpu>
                </div>
                <div class="element">
                    <label for="NewServicePhoto">La photo :</label>
                    <input type="text" name="NewServicePhoto" id="NewServicePhoto" required></textarea>
                </div>
                <div class="form-submit">
                    <input type="submit" value="Ajouter" name="addReview" class="button btn-green" />
                </div>
            </form>
        </div>
    </div>
    <script src="View/assets/script/popup.js"></script>
    <script src="View/assets/script/addService.js"></script>
</section>