<section class="NewReview">
    <button type="button" id="popup-review" aria-haspopup="dialog" aria-controls="dialog" class="btn btn-blue">
        <img class="edit-review" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/edit_square.png" alt="">
        Donner mon avis
    </button>
    <div id="new-review-dialog" role="dialog" aria-labelledby="dialog-title" aria-describedby="dialog-desc" aria-modal="true" aria-hidden="true" tabindex="-1" class="c-dialog">
        <div class="fond"></div>
        <div role="document" class="c-dialog__box popup">
            <div class="Entete">
                <h3 class="dialog-title">Mon avis</h3>
                <button type="button" aria-label="Fermer" title="Fermer nouvel avis" data-dismiss="dialog">x</button>
            </div>
            <form method="POST" action="">
                <div class="element">
                    <label for="NewReviewPseudo">Votre pseudo :</label>
                    <input type="text" name="NewReviewPseudo" id="NewReviewPseudo" required />
                </div>
                <div class = "element">
                    <label>Votre note :</label>
                    <div class="stars">
                    <?php for($i=1;$i<6;$i++){?>
                        <div class="star">
                            <input class="check-stars-input" type="radio" name="stars" value="<?php echo($i)?>" id="star<?php echo($i)?>" required>
                            <label class="form-check-label" for="star<?php echo($i)?>">
                                <img class="NewReview-star" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/pages/reviews/Star-white.png" alt="" id="startImg<?php echo($i)?>">
                            </label>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                <div class="element">
                    <label for="NewReviewComment">Votre avis :</label>
                    <textarea name="NewReviewComment" id="NewReviewComment" required></textarea>
                </div>
                <div class="form-submit">
                    <input type="submit" value="Soumettre" name="addReview" class="button btn-green" />
                </div>
            </form>
        </div>
    </div>
    <script src="<?php if($optionPage){echo("../");}?>View/assets/script/popup.js"></script>
    <script src="<?php if($optionPage){echo("../");}?>View/assets/script/addReview.js"></script>
</section>