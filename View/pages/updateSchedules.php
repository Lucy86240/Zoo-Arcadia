<?php if($_SERVER['REQUEST_URI']=='/View/pages/updateSchedules.php'){
    ?>
    <link rel="stylesheet" href = "../assets/css/style.css">
    <?php
    require_once '404.php';
}
else{?>
    <section id="updateSchedules">
        <div class="head"> </div>
        <form method="POST" action="">
            <h1>Modification des horaires</h1>
            <div class="element">
                <label for="schedules">Votre texte :</label>
                <div id="bodySchedule">            
                    <textarea name="schedules" id="schedules" required> <?php echo($schedules) ?> </textarea>
                    <img src="View/assets/img/general/pages/schedules/fatigue.png" alt="">
                </div>
            </div>
            <div class="form-submit">
            <input type="submit" value="Envoyer" name="submitMsg" class="button btn-brown" />    
            </div>
        </form>
    </section>
<?php } ?>