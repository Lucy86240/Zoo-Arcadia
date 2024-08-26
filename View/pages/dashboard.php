<section id="dashboard">
    <div class="head"> </div>
    <h1>Tableau de bord : <br> <?php echo($_SESSION['role']) ?></h1>
    <div class="container">
        <div>
            <div id="popular">
                <h2>Popularité</h2>
                <?php $i=1;
                foreach($housings as $housing){ ?>
                    <div class="housing" id="number<?php echo($i) ?>">
                    <div class="bgc-numberClics"><span class="numberClics"><?php echo($housing['numberClics']) ?> </br> clics</span></div>
                        <div class="bgc-name"><span class="name"><?php echo($housing['name']) ?></span></div>
                        <img src ="<?php echo($housing['pathImg']) ?>">
                    </div>
                <?php $i++; } ?>
                <img id="podium" src ="View/assets/img/general/pages/dashboard/podium.png">
            </div>
            <div class="jsDesktop"></div>
        </div>
        <div id="tiles" class="tiles displayTiles">
            <div id="stats">
                <div id="headStatsTile">
                    <div class="tile" id="statsTile">
                        <img src ="View/assets/img/general/pages/dashboard/stats.svg">
                        <span>Plus de popularité</span>
                    </div>
                    <div><h2 id="titleStats" class="none">Popularité des animaux</h2></div>
                </div>
                <ul class="none">
                    <ol id="headerUl">
                        <div class="order">
                            <span>clics</span>
                            <img src="View/assets/img/general/pages/dashboard/star.png">
                        </div>
                        <div class="text">
                            <span>Nom</span>
                            <span class="breed">Race</span>
                            <span>- habitat</span>
                        </div>
                    </ol>
                    <?php foreach($animals as $animal){?>
                        <ol>
                            <div class="order">
                                <span><?php echo($animal['numberClics']) ?></span>
                                <img src="View/assets/img/general/pages/dashboard/star.png">
                            </div>
                            <div class="text">
                                <span><?php echo($animal['name']) ?></span>
                                <span class="breed"><?php echo($animal['breed']) ?></span>
                                <span><?php echo(' - '.$animal['housing']) ?></span>
                            </div>
                        </ol>
                    <?php } ?>
                </ul>

            </div>
            <a class="tile js-tile" id="usersTile" href="comptes_utilisateurs">
                <img src ="View/assets/img/general/pages/dashboard/users.svg">
                <span>Comptes utilisateurs</span>
            </a>
            <a class="tile js-tile" id="timeTile" href="horaires">
                <img src ="View/assets/img/general/pages/dashboard/time.svg">
                <span>Modifier les horaires</span>
            </a>
            <a class="tile js-tile" id="animalsTile" href="animaux">
                <img src ="View/assets/img/general/pages/dashboard/empreinte.png">
                <span>Animaux</span>
            </a>
            <a class="tile js-tile" id="reviewsTile" href="avis">
                <img src ="View/assets/img/general/pages/dashboard/star.svg">
                <span>Valider les avis</span>
            </a>
            <a class="tile js-tile" id="fedTile" href="repas">
                <img src ="View/assets/img/general/pages/dashboard/feed.svg">
                <span>Repas des animaux</span>
            </a>
            <a class="tile js-tile" id="reportsTile" href="rapports_medicaux">
                <img src ="View/assets/img/general/pages/dashboard/veterinaire.png">
                <span>Comptes-rendus vétérinaires</span>
            </a>
            <a class="tile js-tile" id="commentsTile" href="commentaires_habitats">
                <img src ="View/assets/img/general/pages/dashboard/housing.svg">
                <span>Commentaires des habitats</span>
            </a>
        </div>
        <div class="jsMobile"></div>
    </div>
    <script src="View/assets/script/dashboard.js"></script>
</section>