<?php if($_SERVER['REQUEST_URI']=='/View/pages/services/addService.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{?>
    <section class="newService">
        <div class="head"> </div>
        <h3>Ajouter un service</h3>
        <?php $message=null;
        $submit = addService($message); ?>
        <form method="POST" action="" enctype = "multipart/form-data">
            <div class="txt">
                <div class="element">
                    <label for="NewServiceName">Intitulé :</label>
                    <div><input type="text" name="NewServiceName" id="NewServiceName" maxlength="155" required />
                    <p>Max 155 caractères</p>
                    </div>
                </div>
                <div class="element">
                    <label for="NewServiceDescription">Description :</label>
                    <div><textarea name="NewServiceDescription" id="NewServiceDescription" maxlength="255" required></textarea>
                    <p>Max 255 caractères</p></div>
                </div>
            </div>
            <div class="images">
                <div class="image">
                        <label class="title-img" for="NewServiceIcon">L'icone</label>
                        <input type="file" name="NewServiceIcon" id="NewServiceIcon" required>
                        <p>Pour info : l'icone doit être au format png et ne pas dépasser 100ko.</p>
                </div>
                <div class="image">
                        <label class="title-img" for="NewServicePhoto">La photo</label>
                        <input type="file" name="NewServicePhoto" id="NewServicePhoto" required>
                        
                        <div><label for="NSP-Description">Description de la photo :</label>
                        <input type="text" name="NSP-Description" id="NSP-Description"></div>
                        <div><input type="checkbox" name="NSP-checkboxPortrait" id="checkbox-portrait">
                        
                        <label for="checkbox-portrait">l'image est en portrait</label></div>
                        <p>Pour info : la photographie doit être au format jpg ou png et ne pas dépasser 5 Mo.</p>
                </div>
            </div>
            <div class="form-submit">
                <input type="submit" value="Ajouter" name="addReview" class="button btn-green"/>
                <p class="messageOfSubmit<?php if($submit) echo("__good"); else if($submit == false && $message !=null) echo("__bad");?>">
                    <?php
                        if($submit == false && $message != null){
                            ?><img class="illustration" src="View/assets/img/general/problem.png" alt=""> <?php
                            echo("Le service n'a pas pu être ajouté :"); ?>
                            <br> <br><?php
                        } 
                        if($message != null && $submit){ ?>
                            <img class="illustration" src="View/assets/img/general/good.png" alt="">
                        <?php } 
                        echo($message); 
                ?></p>
            </div>
        </form>
        <a href="services"><button class="button btn-beige">Retour aux services</button></a>
    </section>
<?php } ?>