<section class = "reviews">
    <div class="top"></div>
    <h1>Les avis des visiteurs</h1>
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
        <button type="button" class="btn btn-blue">
            <img class="edit-review" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/edit_square.png" alt="">
            Donner mon avis
        </button>
    </div>
    <div class="choices">
        <div class="filter">
            <label class="title-filter" for="toggleFilter">                
                <img class="icon-filter" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/filter.svg" alt="filtrer">
                <span>filtrer</span>
            </label>
            <input type="checkbox" id="toggleFilter">
            <ul class="dropdown-menu">
                <label class="dropdown-item" for="toggleNote">                
                    <span>Note</span>
                </label>
                <input type="checkbox" id="toggleNote">
                <li class="checkNote">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheck5" checked>
                        <label class="form-check-label" for="flexCheck5">
                            5
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheck4" checked>
                        <label class="form-check-label" for="flexCheck4">
                            4
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheck3" checked>
                        <label class="form-check-label" for="flexCheck3">
                            3
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheck2" checked>
                        <label class="form-check-label" for="flexCheck2">
                            2
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheck1" checked>
                        <label class="form-check-label" for="flexCheck1">
                            1
                        </label>
                    </div>
                </li>
                <label class="dropdown-item" for="toggleDateV">                
                    <span>Date de visite</span>
                </label>
                <input type="checkbox" id="toggleDateV">
                <li class="checkDateV">
                    <div>
                        <label for="StartDateCheck" class="form-label">Du </label>
                        <input type="date" class="form-control" id="StartDateCheck" placeholder="<?php echo("01/01/2020");?>">
                    </div>
                    <div>
                        <label for="EndDateCheck" class="form-label"> au</label>
                        <input type="date" class="form-control" id="EndDateCheck" placeholder="<?php echo("date du jour");?>">
                    </div>
                </li>
                <label class="dropdown-item" for="toggleDateVerif">                
                    <span>Date de vérification</span>
                </label>
                <input type="checkbox" id="toggleDateVerif">
                <li class="checkDateVerif">
                    <div>
                        <label for="StartDateCheck" class="form-label">Du </label>
                        <input type="date" class="form-control" id="StartDateCheck" placeholder="<?php echo("01/01/2020");?>">
                    </div>
                    <div>
                        <label for="EndDateCheck" class="form-label"> au</label>
                        <input type="date" class="form-control" id="EndDateCheck" placeholder="<?php echo("date du jour");?>">
                    </div>
                </li>
                <label class="dropdown-item" for="toggleVerif">                
                    <span>Vérificateur</span>
                </label>
                <input type="checkbox" id="toggleVerif">
                <li class="checkBy">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckUsername" checked>
                    <label class="form-check-label" for="flexCheckUsername">
                        <?php echo("nom employé");?>
                    </label>
                </li>
                <label class="dropdown-item" for="toggleState">                
                    <span>Etat</span>
                </label>
                <input type="checkbox" id="toggleState">
                <li class="checkState">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckValidate" checked>
                        <label class="form-check-label" for="flexCheckValidate">
                            Validé
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckToValidate" checked>
                        <label class="form-check-label" for="flexCheckToValidate">
                            A vérifier
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckModerate" checked>
                        <label class="form-check-label" for="flexCheckModerate">
                            Modéré
                        </label>
                    </div>
                </li>
            </ul>
        </div>
        <div class="sort">
            <label class="title-sort" for="toggleSort">                
                <span>Trier par</span>
            </label>
            <input type="checkbox" id="toggleSort">
            <ul class="sort-menu">
                <li class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="SortDateVisite" checked>
                    <label class="form-check-label" for="SortDateVisite">
                    Date de visite
                    </label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="SortNote">
                    <label class="form-check-label" for="SortNote">
                    Note
                    </label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="sortDateCheck">
                    <label class="form-check-label" for="sortDateCheck">
                    Date de vérification
                    </label>
                </li>
            </ul>
        </div>
    </div>
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
    </div>
    <nav>
    <ul class="pagination">

        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class=" <?php echo(($currentPage == 1) ? "hidden" : "");?>">
            <a href="<?php if(!$optionPage){echo("avis/");};?>?page=<?= $currentPage - 1 ?>" class="btn-previous bp-blue">
                <img class="previous-img" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/previous_blue.png" alt="Bouton précédent">
                <p class="previous-text">Précédent</p> 
            </a>   
        </li>

        <li><p class="page-blue">Page <?php echo($currentPage); ?> / <?php echo($pages); ?></p></li>

        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
        <li class=" <?php echo(($currentPage == $pages) ? "hidden" : "");?>">
            <a href="<?php if(!$optionPage){echo("avis/");};?>?page=<?= $currentPage + 1 ?>" class="btn-next bn-blue">
                <p class="next-text">Suivant</p> 
                <img class="next-img" src="<?php if($optionPage){echo("../");}?>View/assets/img/general/buttons/next_blue.png" alt="Bouton suivant">
            </a>    
        </li> 
    </ul>
</nav>
</section>