<section id="updateAccount">
    <div id="updateAccountdialog" class="c-dialog none">
        <div class="fond"></div>
        <div role="document" class="c-dialog__box themeBlue popup">
            <div class="Entete">
                <h3 class="dialog-title">Modifier un compte</h3>
                <button class="close" type="button" aria-label="Fermer" title="Fermer nouvel avis">x</button>
            </div>
            <form method="POST" action="">
                <div class="element">
                    <label for="updateAccountMail">Mail :</label>
                    <input type="text" name="updateAccountMail" id="updateAccountMail" />
                </div>
                <div class="element">
                    <label for="updateAccountConfirmMail">Confirmation mail :</label>
                    <input type="text" name="updateAccountConfirmMail" id="updateAccountConfirmMail" />
                </div>
                <div class="element">
                    <label for="updateAccountFirstname">Nom :</label>
                    <input type="text" name="updateAccountFirstname" id="updateAccountFirstname" />
                </div>
                <div class="element">
                    <label for="updateAccountLastname">Prénom :</label>
                    <input type="text" name="updateAccountLastname" id="updateAccountLastname" />
                </div>
                <div class="element">
                    <label for="updateAccountPassword">Nouveau mot de passe :</label>
                    <input type="password" name="updateAccountPassword" id="updateAccountPassword" />
                </div>
                <div class="element">
                    <label for="updateAccountPassword">Confirmation nouveau mot de passe :</label>
                    <input type="password" name="updateAccountPassword" id="updateAccountPassword" />
                </div>
                <div class="form-submit">
                    <input type="submit" value="Soumettre" name="updateAccountdialog" class="button btn-green" />
                </div>
            </form>
        </div>
    </div>
    <script src="<?php if($optionPage){echo("../");}?>View/assets/script/popup.js"></script>
    <script src="<?php if($optionPage){echo("../");}?>View/assets/script/addReview.js"></script>
</section>