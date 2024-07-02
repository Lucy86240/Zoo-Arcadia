<script src = "View/assets/script/home.js" defer></script>

<!--HERO-->

<section class="home-hero background">
    <h1>Zoo Arcadia</h1>
    <p class="text-center">Niché au coeur d'une forêt de pins de 20 hectares, 
        le Zoo Arcadia est l'un des sites touristiques les 
        plus fréquentés de Bretagne. Aujourd’hui c’est plus
        de 1200 animaux qui peuvent être observés dans un 
        lieu en total indépendance énergétique.</p>
</section>

<section class="home-housings">
    <h2 class="text-center text-white home-housings-title-desktop">Soyez au plus proche de la nature en visitant nos habitats</p>
    <h2 class="text-center text-white home-housings-title-mobile">Nos habitats</h2>
    <div class="home-housings-container">
        <?php
            $housings = AllHousingsView(false,true,1,3,1,0);
            foreach($housings as $housing){
                $animal1 = $housing["animals"][0];
                $animal2 = $housing["animals"][1];
                $animal3 = $housing["animals"][2];
                ?>
                <div class="home-housing-container">
                    <div class="home-img-font js-slide"> 
                        <div class="home-title-housing-position"><h3 class="text-brown text-center home-housing-title"><?php echo($housing["name"]); ?></h3></div>
                        <div><img class="home-housing-img rounded-circle " src="<?php echo($housing["images"][0]["path"]); ?>" alt="<?php echo($housing["images"][0]["description"]);?>"></div>
                    </div>

                    <div class="home-img-font js-slide">
                        <div><img class="home-animal-img rounded-circle home-housing-animal1" src="<?php echo($animal1["imagesAnimals"][0]["pathAnimals"]); ?>" alt="<?php echo($animal1["imagesAnimals"][0]["descriptionAnimals"]); ?>"></div>
                        <div class="home-title-animal1-position none"><span class="text-center home-animal-title"><?php echo($animal1["name"]); ?></span></div>
                    </div>
                    <div class="home-img-font js-slide">
                        <img class="home-animal-img rounded-circle home-housing-animal2" src="<?php echo($animal2["imagesAnimals"][0]["pathAnimals"]); ?>" alt="<?php echo($animal2["imagesAnimals"][0]["descriptionAnimals"]); ?>">
                        <div class="home-title-animal2-position none"><span class="text-center home-animal-title"><?php echo($animal2["name"]); ?></span></div>
                    </div>
                    <div class="home-img-font js-slide">
                        <img class="home-animal-img rounded-circle home-housing-animal3" src="<?php echo($animal3["imagesAnimals"][0]["pathAnimals"]); ?>" alt="<?php echo($animal3["imagesAnimals"][0]["descriptionAnimals"]); ?>">
                        <div class="home-title-animal3-position none"><span class="text-center home-animal-title"><?php echo($animal3["name"]); ?></span></div>
                    </div>
                </div>
            <?php } ?>
        
    </div>
    <div class="button"><button type="button" class="btn btn-green mt-5">En voir plus...</button></div>
</section>

<section class = "home-services">
    <h2 class="text-white text-center mb-5">Un parc à votre service</h2>
    <?php
    $services = AllServicesView(false,false,1,0,1);

    foreach($services as $service){?>
        <div class = "home-service">
            <img class="" src="<?php echo($service["images"][0]["path"]);?>" alt="<?php echo($service["images"][0]["description"]);?>">
            <h3 class = "cb"><?php echo($service["name"]); ?></h3>
        </div>
    <?php } ?>
    <div class="button"><button type="button" class="btn btn-green mt-5">En savoir plus...</button></div>
</section>

<section class = "home-reviews">
    <h2 class="text-center text-white">Vous parlez de nous</h2>
    <div class="home-reviews-container-desktop">
        <?php
        $reviews = reviews(4,0,1,0,0,0);
        foreach($reviews as $review){ ?>
            <div class="home-review">
            <h3><?php echo($review["pseudo"]);?></h3>
            <p class="h-review-date">visite du <?php echo($review["dateVisite"]);?></p>
            <div class="home-review-stars">
            <?php for($i=0;$i<$review["note"];$i++){ ?>
                <img class="start" src="View/assets/img/general/review/Star-gold.png" alt="Etoile">
            <?php } 
            if($review["note"]<NOTE_MAX){
                $notStart=NOTE_MAX-$review["note"];
                for($i=0;$i<$notStart;$i++){ ?>
                    <img class="start" src="View/assets/img/general/review/Star-white.png" alt="">
                <?php }
            } ?>
            </div>
            <p>“<?php echo($review["comment"]);?>”</p>
        </div>           
        <?php }?>
    </div>
    <div class="home-reviews-container-mobile">
        <?php
        $review = Reviews(1,0,1,0,0,0)[0];?>
        <div class="home-review">
            <h3><?php echo($review["pseudo"]);?></h3>
            <p class="h-review-date">visite du <?php echo($review["dateVisite"]);?></p>
            <div class="home-review-stars">
                <?php for($i=0;$i<$review["note"];$i++){ ?>
                    <img class="start" src="View/assets/img/general/review/Star-gold.png" alt="Etoile">
                <?php } 
                if($review["note"]<NOTE_MAX){
                    $notStart=NOTE_MAX-$review["note"];
                    for($i=0;$i<$notStart;$i++){ ?>
                        <img class="start" src="View/assets/img/general/review/Star-white.png" alt="">
                    <?php }
                } ?>
            </div>
            <p>“<?php echo($review["comment"]);?>”</p>        
        </div>
    </div>
    <div class="buttons">
        <div class="button"><button type="button" class="btn btn-blue mt-5">
            En voir plus...
        </button></div> 
        <div class="button"><button type="button" class="btn btn-blue mt-5">
            <img class="edit-review" src="View/assets/img/general/buttons/edit_square.png" alt="">
            Mon avis
        </button></div>
    </div>
</section>
