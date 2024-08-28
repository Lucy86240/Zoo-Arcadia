<?php if($_SERVER['REQUEST_URI']=='/View/pages/commentsVetoHousing/addComments.php'){
    ?><link rel="stylesheet" href = "../../assets/css/style.css"> <?php
    require_once '../404.php';
}
else{?>
    <div>
        <form action="" method="POST">
            <div class="element">
                <span>Date : </span>
                <span> <?php echo(date("d/m/Y",strtotime(now()))) ?></span>
            </div>
            <div class="element">
                <span>Vétérinaire : </span>
                <span><?php echo($_SESSION['firstName'].' '.$_SESSION['lastName']) ?></span>
            </div>
            <div class="element">
                <label for="addCommentHousing">Habitat concerné : </label>
                <select name="addCommentsHousing" id="addCommentsHousing" required>
                    <?php foreach($housings as $housing){ ?>
                    <option value="<?php echo($housing['id']) ?>"><?php echo($housing['name']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="element">
                <span>Commentaire : </span>
                <textarea name="addCommentComment" id="addCommentComment" required></textarea>
            </div>
            <div class="form-submit">
                <input type="submit" value="Soumettre" name="addComment" class="button btn-green" />
            </div>
        </form>
    </div>
<?php } ?>