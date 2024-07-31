<section class="housings">
    <div class="head"></div>
    <?php $housings = allHousingsView(false,true,-1,-1,1,1); ?>
    <div class="hero">
        <div class="title">
            <h2>Respectueux de leur écosystème naturel nous permettons à nos animaux de s’épanouir au coeur de </h2>
            <h1>nos différents habitats</h1>
        </div>
        <div class="hero-housings">
            <?php $count=0; 
            foreach($housings as $housing){ 

                //style adaptable pour le desktop

                // rotation du 1er et dernier élément d'une ligne
                $option = '';
                if($count==0 || $count%6==0) $option="hero-housing__left";
                else if(($count%5-4)==0 || $count==(count($housings)-1)) $option="hero-housing__right"; 
                
                //taille adaptable suivant nombre d'habitats
                if(count($housings)<3){
                    $width_div = '21vw';
                    $height_div = '30vw';
                    $width_img = '20vw';
                    $height_img = '13vw';
                } else if(count($housings)>5){
                    $width_div = '12vw';
                    $height_div = '16vw';
                    $width_img = '11vw';
                    $height_img = '7vw';
                }
                else{
                    $width_div = 70/count($housings).'vw';
                    $height_div = (70/count($housings)/3*4).'vw';
                    $width_img = (70/count($housings)-1).'vw';
                    $height_img = ((70/count($housings))/3*2).'vw';
                }
                // @media only screen and (min-width: 576px){ 
                ?>
                <!-- habitat type polaroïde -->
                <a href="#<?php echo("housing-".$housing['id'])?>" style = "width : <?php echo($width_div) ?>; height : <?php echo($height_div) ?>;}"class="hero-housing <?php echo($option); ?>">
                    <img style = "max-width : <?php echo($width_img) ?>; max-height : <?php echo($height_img) ?>;" src="<?php echo($housing['images'][0]['path'])?>" alt="<?php echo($housing['images'][0]['description'])?>">
                    <h3><?php echo($housing['name'])?></h3>
                </a>
                <?php $count++; 
            } ?>
        </div>
    </div>
    <!-- habitats détaillés-->
    <?php $count=0;
    foreach($housings as $housing){ ?>
        <section id="housing-<?php echo($housing['id']) ?>" class = "housing">
            <h3><?php echo($housing['name']) ?></h3>
            <div>
                <div class="img-container">

                </div>
                <div class="description">
                    <p><?php echo($housing['description']); ?></p>
                </div>
            </div>
            <div class="list-animals">
                <h4>Vous pouvez m'y retrouver :</h4>
                <input type="search">
                <ul>
                    <li>Nom - Race</li>
                </ul>
                <div class="pagination">

                </div>
            </div>
            <div animal>

            </div>
            <button>Retour aux habitats</button>
        </section>

    <?php   $count++;
    } ?>
    <script src="View/assets/script/housings.js"></script>
</section>