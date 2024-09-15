<?php if($_SERVER['REQUEST_URI']=='/View/pages/home.php'){
    ?>
    <link rel="stylesheet" href = "../assets/css/style.css">
    <?php
    require_once '404.php';
}
else{?>
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
                $housings = allHousingsView(false,1,3,1,0);
                foreach($housings as $housing){
                    ?>
                    <div class="home-housing-container js-slide" id_housing="<?php echo($housing["id"]); ?>">
                        <div class="home-img-font"> 
                            <div class="home-title-housing-position">
                                <h3 class="text-brown text-center home-housing-title"><?php echo($housing["name"]); ?></h3>
                            </div>
                            <div>
                                <img class="home-housing-img rounded-circle " src="<?php echo($housing["images"][0]["path"]); ?>" alt="<?php echo($housing["images"][0]["description"]);?>">
                            </div>
                        </div>
                        <?php if(isset($housing["animals"][0])){
                            $animal1 = $housing["animals"][0];?>
                            <div class="home-img-font js-homeAnimal" id_housing="<?php echo($housing["id"]); ?>">
                                <div>
                                    <img class="home-animal-img rounded-circle home-housing-animal1" src="<?php echo($animal1["imagesAnimals"][0]["pathAnimals"]); ?>" alt="<?php echo($animal1["imagesAnimals"][0]["descriptionAnimals"]); ?>">
                                </div>
                                <div class="home-title-animal1-position none">
                                    <span class="text-center home-animal-title"><?php echo($animal1["name"]); ?></span>
                                </div>
                            </div>
                        <?php }
                        if(isset($housing["animals"][1])){
                            $animal2 = $housing["animals"][1];?>
                            <div class="home-img-font js-homeAnimal" id_housing="<?php echo($housing["id"]); ?>">
                                <img class="home-animal-img rounded-circle home-housing-animal2" src="<?php echo($animal2["imagesAnimals"][0]["pathAnimals"]); ?>" alt="<?php echo($animal2["imagesAnimals"][0]["descriptionAnimals"]); ?>">
                                <div class="home-title-animal2-position none"><span class="text-center home-animal-title"><?php echo($animal2["name"]); ?></span></div>
                            </div>
                        <?php }
                        if(isset($housing["animals"][2])){
                        $animal3 = $housing["animals"][2];?>
                            <div class="home-img-font js-homeAnimal" id_housing="<?php echo($housing["id"]); ?>">
                                <img class="home-animal-img rounded-circle home-housing-animal3" src="<?php echo($animal3["imagesAnimals"][0]["pathAnimals"]); ?>" alt="<?php echo($animal3["imagesAnimals"][0]["descriptionAnimals"]); ?>">
                                <div class="home-title-animal3-position none"><span class="text-center home-animal-title"><?php echo($animal3["name"]); ?></span></div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            
        </div>
        <a href="habitats"  class="button"><button type="button" class="btn btn-green">En voir plus...</button></a>
    </section>

    <!-- animals for mobile -->
    <section class="animals-mobile">
    </section>

    <section class = "home-services">
        <h2 class="text-white text-center mb-5">Un parc à votre service</h2>
        <?php
        $services = AllServices(false);

        foreach($services as $service){?>
            <div class = "home-service">
                <img class="" src="<?php echo($service["icon"]["path"]);?>" alt="<?php echo($service["icon"]["description"]);?>">
                <h3 class = "cb"><?php echo($service["name"]); ?></h3>
            </div>
        <?php } ?>
        <a href="services" class="button"><button type="button" class="btn btn-green mt-5">En savoir plus...</button></a>
    </section>

    <section class = "home-reviews">
        <h2 class="text-center text-white">Vous parlez de nous</h2>
        <div class="home-reviews-container-desktop">
            <?php
            $reviews = reviews(4,0,1,"","",0,0,0);
            foreach($reviews as $review){ ?>
                <div class="home-review">
                <h3><?php echo($review["pseudo"]);?></h3>
                <p class="h-review-date">visite du <?php echo($review["dateVisite"]);?></p>
                <div class="home-review-stars">
                <?php for($i=0;$i<$review["note"];$i++){ ?>
                    <img class="start" src="View/assets/img/general/pages/reviews/Star-gold.png" alt="Etoile">
                <?php } 
                if($review["note"]<NOTE_MAX){
                    $notStart=NOTE_MAX-$review["note"];
                    for($i=0;$i<$notStart;$i++){ ?>
                        <img class="start" src="View/assets/img/general/pages/reviews/Star-white.png" alt="">
                    <?php }
                } ?>
                </div>
                <p>“<?php echo($review["comment"]);?>”</p>
            </div>           
            <?php }?>
        </div>
        <div class="home-reviews-container-mobile">
            <?php
            $review = Reviews(1,0,1,"","",0,0,0)[0];?>
            <div class="home-review">
                <h3><?php echo($review["pseudo"]);?></h3>
                <p class="h-review-date">visite du <?php echo($review["dateVisite"]);?></p>
                <div class="home-review-stars">
                    <?php for($i=0;$i<$review["note"];$i++){ ?>
                        <img class="start" src="View/assets/img/general/pages/reviews/Star-gold.png" alt="Etoile">
                    <?php } 
                    if($review["note"]<NOTE_MAX){
                        $notStart=NOTE_MAX-$review["note"];
                        for($i=0;$i<$notStart;$i++){ ?>
                            <img class="start" src="View/assets/img/general/pages/reviews/Star-white.png" alt="">
                        <?php }
                    } ?>
                </div>
                <p>“<?php echo($review["comment"]);?>”</p>        
            </div>
        </div>
        <div class="buttons">
            <div class="button"><a href="/avis"><button type="button" class="btn btn-blue">
                En voir plus...
            </button></a></div> 
            <?php if(authorize(['disconnect'])){ ?>
            <div class="home-button-review">
                <?php include_once ('Reviews/addReview.php') ?>
            </button></div>
            <?php }  ?>
        </div>
    </section>
<?php } ?>