<section class = "reviews">
    <div class="top"></div>
    <h1>Les avis des visiteurs</h1>
    <img class="illustration" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/review/panda.png" alt="">

    <div class="summary">
        <h2>Résumé des avis</h2>
        <div class="summary-block">
            <div class = "notations">
                <div class="note">
                    <p>5 : </p>
                    <div class="note-bar">
                        <div class="porcent" style="width:<?php echo(porcentNote(5));?>%"></div>
                    </div>
                </div>
                <div class="note">
                    <p>4 : </p>
                    <div class="note-bar">
                        <div class="porcent" style="width:<?php echo(porcentNote(4));?>%"></div>
                    </div>
                </div>
                <div class="note">
                    <p>3 : </p>
                    <div class="note-bar">
                        <div class="porcent" style="width:<?php echo(porcentNote(3));?>%"></div>
                    </div>
                </div>
                <div class="note">
                    <p>2 : </p>
                    <div class="note-bar">
                        <div class="porcent" style="width:<?php echo(porcentNote(2));?>%"></div>
                    </div>
                </div>
                <div class='note'>
                    <p>1 : </p>
                    <div class="note-bar">
                        <div class="porcent" style="width:<?php echo(porcentNote(1));?>%"></div>
                    </div>
                </div>
            </div>
            <div class="reviews-stats">
                <h3>Avis vérifiés</h3>
                <p class="data"> <?php echo(avgReviewsVisible())?>/5</p>
                <p><?php echo(countReviews(1, 1))?> avis</p>
            </div>
            <div class="reviews-stats">
                <h3>Avis à vérifier</h3>
                <div class="block-nb">
                    <p class="data"><?php echo(countReviews(0,0))?></p>
                    <p>avis</p>
                </div>
                <div> </div>
            </div>
            <div class="reviews-stats">
                <h3>Avis modérés</h3>
                <div class="block-nb">
                    <p class="data"><?php echo(countReviews(0,1))?></p>
                    <p>avis</p>
                </div>
                <div> </div>
            </div>
        </div>
    </div>
    <div class="button-give">
        <?php include_once ('addReview.php') ?>
    </div>
    <div class="body-reviews">
        <form  class="choices" method="POST" action="../avis">
            <div class="choice">
                <div class="title-choice">                
                    <img class="icon-filter" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/filter.svg" alt="filtrer">
                    <span>filtrer</span>
                </div>
                <div class="check-choices">
                    <li class="form-check">
                        <input class="form-check-input" type="checkbox" name="CheckValidateReviews" value="true" id="CheckValidateReviews" <?php filterInit("Validate", "CheckValidateReviews"); ?>>
                        <label class="form-check-label" for="CheckValidateReviews">
                            Validé
                        </label>
                    </li>
                    <li class="form-check">
                        <input class="form-check-input" type="checkbox" name="CheckToValidateReviews" value="true" id="CheckToValidateReviews" <?php filterInit("ToValidate","CheckToValidateReviews"); ?>>
                        <label class="form-check-label" for="CheckToValidateReviews">
                            A vérifier
                        </label>
                    </li>
                    <li class="form-check">
                        <input class="form-check-input" type="checkbox" name="CheckModerateReviews" value="true" id="CheckModerateReviews" <?php filterInit("Moderate","CheckModerateReviews"); ?>>
                        <label class="form-check-label" for="CheckModerateReviews">
                            Modéré
                        </label>
                    </li>
                </div>
            </div>
            <div class="choice">            
                <div class="title-choice"><span>Trier par</span></div>
                <div class="check-choices" method="POST" action="../avis">
                    <li class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="DvD" id="SortDateVisiteD" <?php sortInit("DvD"); ?>>
                        <label class="form-check-label" for="SortDateVisiteD">
                            Dernières visites
                        </label>
                    </li>
                    <li class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="DvC" id="SortDateVisiteP" <?php sortInit("DvC"); ?>>
                        <label class="form-check-label" for="SortDateVisiteP">
                            Premières visites
                        </label>
                    </li>
                    <li class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="ND" id="SortNoteD" <?php sortInit("ND"); ?>>
                        <label class="form-check-label" for="SortNoteD">
                            Notes décroissantes
                        </label>
                    </li>
                    <li class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="NC" id="SortNoteC" <?php sortInit("NC"); ?>>
                        <label class="form-check-label" for="SortNoteC">
                            Notes croissantes
                        </label>
                    </li>
                </div>
            </div>
            <div class="valid-choices"><input class="btn-DarkGreen" type="submit" value="Appliquer" name="choices"></div>
                <?php $urlFilter=urlFilter();?>
                <?php $urlSort= urlSort();?>
        </form>
        <div class="reviews-list">
            <?php 
                $index=0;
                foreach($reviews as $review){ ?>
                    <div class="reviews-review">
                        <div class="heading-review-Employee">
                            <div class="heading-review">
                                <h3><?php echo($review["pseudo"]);?></h3>
                                <div class="block">
                                    <p class="r-review-date">visite du <?php echo($review["dateVisite"]);?></p>
                                    <div class="r-review-stars">
                                        <?php for($i=0;$i<$review["note"];$i++){ 
                                            ?>
                                            <img class="start" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/review/Star-gold.png" alt="Etoile">
                                        <?php } 
                                        if($review["note"]<NOTE_MAX){
                                            $notStart=NOTE_MAX-$review["note"];
                                            for($i=0;$i<$notStart;$i++){ ?>
                                                <img class="start" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/review/Star-white.png" alt="">
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="box-backOffice">
                                <li class="form-check">
                                    <input class="form-check-input" type="radio" name="State<?php echo($index);?>" id="Validate<?php echo($index);?>" <?php if(validateReview($review['id'])){echo('checked');}?>>
                                    <label class="form-check-label" for="Validate<?php echo($index);?>">
                                        <span>Validé</span> 
                                    </label>
                                </li>
                                <li class="form-check">
                                    <input class="form-check-input" type="radio" name="State<?php echo($index);?>" id="Refuse<?php echo($index);?>" <?php if(moderateReview($review['id'])){echo('checked');}?>>
                                    <label class="form-check-label" for="Refuse<?php echo($index);?>">
                                        <span>Modéré</span>
                                    </label>
                                </li>
                            </div>
                        </div>
                        <p>“<?php echo($review["comment"]);?>”</p>        
                        <div class="check">
                            <p>Vérifié le 
                                <?php   
                                    if($review['dateCheck']!=null){
                                        echo($review['dateCheck'].' ');?>
                                        par <?php 
                                        if($review['CheckBy']!=null){
                                            echo($review['CheckBy']);
                                        } 
                                    } ?></p>
                        </div>
                    </div>
                <?php
                $index++; 
                } 
            ?>
                <nav>
        <ul class="pagination">

            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class=" <?php echo(($currentPage == 1) ? "hidden" : "");?>">
                <a href="<?php urlOption($currentPage -1, $optionPage,$urlFilter,$urlSort) ?>" class="btn-previous bp-blue">
                    <img class="previous-img" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/previous_blue.png" alt="Bouton précédent">
                    <p class="previous-text">Précédent</p> 
                </a>   
            </li>

            <li><p class="page-blue">Page <?php echo($currentPage); ?> / <?php echo($pages); ?></p></li>

            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class=" <?php echo(($currentPage == $pages) ? "hidden" : "");?>">
                <a href="<?php urlOption($currentPage + 1, $optionPage,$urlFilter,$urlSort)?>" class="btn-next bn-blue">
                    <p class="next-text">Suivant</p> 
                    <img class="next-img" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/next_blue.png" alt="Bouton suivant">
                </a>    
            </li> 
        </ul>
    </nav>
        </div>

    </div>
</section>