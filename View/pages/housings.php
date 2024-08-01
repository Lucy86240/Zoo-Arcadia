<section class="housings theme-brown">
    <div class="head"></div>
    <?php $housings = allHousingsView(false,true,-1,-1,1,1); ?>
    <div class="hero">
        <div class="title">
            <h2>Respectueux de leur écosystème naturel nous permettons à nos animaux de s’épanouir au coeur de </h2>
            <h1>Nos différents habitats</h1>
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
                    $width_div = 68/count($housings).'vw';
                    $height_div = (68/count($housings)/3*4).'vw';
                    $width_img = (68/count($housings)-1).'vw';
                    $height_img = ((68/count($housings))/3*2).'vw';
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
    foreach($housings as $housing){
        if($count%2 != 0) $reverse=true;
        else $reverse=false; ?>
        <section id="housing-<?php echo($housing['id']) ?>" class = "housing <?php if($reverse==true) echo('reverse'); ?>">
            <h2><?php echo($housing['name']) ?></h2>
            <div class="housing-detail">
                <div class="images-container">
                    <?php for($i=0; $i<count($housing['images']); $i++){?>
                        <div class="<?php if($i>0) echo('none') ?> img-container js-slideHousing<?php echo($count) ?>">
                            <img class="imgHousing" src="<?php if(isset($optionPage) && $optionPage){echo("../");} echo($housing['images'][$i]['path']);?>" alt="<?php echo($housing['images'][$i]['description']);?>">
                        </div>
                    <?php } ?>
                    <div class="rounds rounds-white">
                        <?php $lenght = count($housing['images']);
                        if($lenght > 1){
                        for($i=0;$i<$lenght;$i++){ ?>
                            <div class="round round<?php echo($count) ?> <?php if($i==0) echo('round-selected') ?>"> </div>  
                        <?php } }
                        ?>
                    </div>
                </div>
                <div class="description">
                    <p><?php echo($housing['description']); ?></p>
                </div>
            </div>
            <div class="comments">
                <div class="comment">
                    <p>ici commentaires du veto</p>
                </div>
            </div>
            <div class="list-animals">
                <h3>Vous pouvez m'y retrouver :</h3>
                <div class="search">
                    <input type="text" class="searchAnimal" placeholder="Lion">
                    <img class="searchIcon" src="View/assets/img/general/icons/search.svg">
                </div>
                <form method="POST" action="#animal<?php echo($housing['id'])?>">
                    <ul class="animalList">
                        <?php 
                        foreach($housing['animals'] as $animal){ ?>
                        <li> 
                            <input type="radio" name="animal<?php echo($housing['id'])?>" id="animal<?php echo($housing['id'].'-'.$i);?>" value="<?php echo($animal['id']);?>"> 
                            <label for="animal<?php echo($housing['id'].'-'.$i);?>">
                                <?php echo($animal['name'].' - '.$animal['breed']) ?>
                            </label>
                        </li>
                        <?php $i++; } ?>
                    </ul>
                </form>
                <script>
                $('input[type=radio]').on('change', function() {
                    $(this).closest("form").submit();
                })
                </script>
                <div class="none messageNoResult"></div>
            </div>
            <section class="animal" id="animal<?php echo($housing['id'])?>">
                <?php 
                if(isset($_POST['animal'.$housing['id']])){
                    include "Controller/ManageAnimal.php";
                    $animal = animalById($_POST['animal'.$housing['id']],false);
                    deleteAnimal($animal['id'],$animal['name']);
                    archiveAnimal($animal);
                    unarchiveAnimal($animal);
                    include "View/elements/animal.php";
                }?>
        </section>
        <a href="habitats" class="button back"><button type="button" class="btn btn-beige">
            <img src="View/assets/img/general/icons/arrow_upward.svg">
            Retour aux habitats
        </button></a>
        </section>
    <?php   $count++;
    } ?>
    <script src="View/assets/script/housings.js"></script>
</section>