<section class="allAnimals">
    <div class="animals">
        <?php foreach($animals as $animal){?>
            <div class="animal <?php echo(colorhousing($animal['housing']))?>">
                <img src="<?php echo($animal["photo"]['path']); ?>" alt="<?php echo($animal["photo"]['description']); ?>">
                <p><?php echo($animal['name'].' - '.$animal['breed']) ?></p>
            </div>
        <?php } ?>
    </div>
</section>