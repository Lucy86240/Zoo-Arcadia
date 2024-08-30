<?php
//si l'url correspond au chemin du fichier on affiche la page 404
if($_SERVER['REQUEST_URI']=='/Model/ManageReviewModel.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
    try{
        require_once "Model/Review.php";
        require_once "Model/User.php";
    
        /**
         * @Param $nbReviews nombre d'avis retournés souhaités
         * @Param $startList premier avis à retourner
         * @Param $orderBy : "idC" = id_review croissants, "idD" = id_review decroissants, 
         * "DvC" = dates de visite croissantes, "DvD" = dates de visite décroissantes, 
         * "NC" = notes croissantes, "ND" = notes décroissantes
         * @Param $JustVisible true = ne retourne que des avis acceptés
         * @Param $showDateCheck : false = l'avis n'inclus pas la date d'acceptation
         * @Param $showCheckBy : false = l'avis n'inclus pas l'employé qui l'a validé
         */
        function reviewsExtract(int $nbReviews,int $startList=0, string $orderBy, bool $JustVisible=true,string $filter){
            switch ($orderBy){
                case "idC": 
                    $order="id_review ASC";
                    break;
                case "idD":
                    $order="id_review DESC";
                    break;
                case "DvC":
                    $order="date_visite ASC";
                    break;
                case "NC":
                    $order="note ASC";
                    break;
                case "ND":
                    $order="note ASC";
                    break;
    
                default:
                    $order="date_visite DESC";
                    break;
            }
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            if($nbReviews<1 && $JustVisible==false){
                $stmt = $pdo->prepare('SELECT * FROM reviews');
                echo("1");
            }
            else if($JustVisible){
                $request = 'SELECT * FROM reviews WHERE isVisible=1 ORDER BY '.$order .' LIMIT '.$nbReviews.' OFFSET '.$startList;
                $stmt = $pdo->prepare($request);
            }
            else{
                if($filter !=""){
                    $request = 'SELECT * FROM reviews WHERE '.$filter.' ORDER BY '.$order .' LIMIT '.$nbReviews.' OFFSET '.$startList;
                    $stmt = $pdo->prepare($request);
                }
                else{
                    $request = 'SELECT * FROM reviews ORDER BY '.$order .' LIMIT '.$nbReviews.' OFFSET '.$startList;
                    $stmt = $pdo->prepare($request);
                }
            }
            $stmt->setFetchMode(PDO::FETCH_CLASS,'Review');
            if($stmt->execute()){
                return $stmt->fetchAll();
            }
            else{
                return new Review();
            }
        }
    
        /**
         * Summary of countReviews : compte le nombre d'avis
         * @param int $isVisible : 1 pour les avis visibles, 0 pour les avis non visibles, 2 pour tous
         * @param int $check : 1 pour les avis vérifiés, 0 pour les avis non vérifiés, 2 pour tous
         * @return int : retourne le nombre d'avis existant en fonction des paramétres indiqués (0 en cas de bug)
         */
        function countReviews(int $isVisible=2, int $check=2):int{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
    
            //adapte la requete en fonction des paramètres entrés
            if(($isVisible!=0 && $isVisible!=1) && ($check!=0 && $check!=1)){
                $stmt = $pdo->prepare('SELECT count(*) FROM reviews');
            }
            else if($isVisible ==1){
                $stmt = $pdo->prepare('SELECT count(*) FROM reviews WHERE isVisible=1 ');
            }
            else{
                if($check==1){
                    $stmt = $pdo->prepare('SELECT count(*) FROM reviews WHERE isVisible=0 and check_by is not null');
                }
                else{
                    $stmt = $pdo->prepare('SELECT count(*) FROM reviews WHERE isVisible=0 and date_check is null');
                }
                
            }
    
            if($stmt->execute()){
                $res = $stmt->fetch();
                return $res[0];
            }
            else{
                return 0;
            }
        }
    
        /**
         * Summary of countReviewsFilter : compte le nombre d'avis en fonction d'un filtre
         * @param string $filter : extrait de la requete permettant le filtre
         * @return int : retourne le nombre d'avis ou 0 en cas de bug
         */
        function countReviewsFilter(string $filter) : int{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            if($filter==""){
                $stmt = $pdo->prepare('SELECT count(*) FROM reviews');
            }
            else {
                $request = 'SELECT count(*) FROM reviews WHERE '.$filter;
                $stmt = $pdo->prepare($request);
            }
    
            if($stmt->execute()){
                $res = $stmt->fetch();
                return $res[0];
            }
            else{
                return 0;
            }
        }
    
        /**
         * Summary of avgReviewsVisible : fait la moyenne des avis validés
         * @return mixed
         */
        function avgReviewsVisible(){
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT round(avg(note),2) FROM reviews WHERE isVisible = 1');
            if($stmt->execute()){
                $res = $stmt->fetch();
                return $res[0];
            }
            else{
                return "oups les calculs sont pas bons";
            }
        }
    
        /**
         * Summary of porcentNote : calcul le pourcentage d'avis avec cette note
         * @param int $note : la note pour laquelle on souhaite avoir le pourcentage
         * @return float|int|string : retourne la moyenne ou un message d'erreur
         */
        function porcentNote(int $note){
    
            if($note<0 || $note>5){
                echo("improbable");
                return 0;
            }
            else{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT count(*) FROM reviews WHERE note=:note and isVisible=1');
                $stmt->bindParam(":note", $note, PDO::PARAM_INT);
                if($stmt->execute()){
                    $res = $stmt->fetch();
                    $r= $res[0]/countReviews(1,1)*100;
                    return $r;
                }
                else{
                    return "oups les calculs sont pas bons";
                }
            }
        }
    
        /** Permet de savoir si un commentaire a été vérifié
         * @param $review id de l'avis
         * @return bool : true si l'avis est vérifié, false sinon
         */
        function ValidateReview(int $review){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT isVisible FROM reviews WHERE id_review=:id');
                $stmt->bindParam(":id", $review, PDO::PARAM_INT);
                if($stmt->execute())
                {
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($res['isVisible']==1){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            catch(error $e){
                echo("problème avec les données");
                return false;
            }
        }
    
        /**
         * Summary of ModerateReview : permet de savoir si un avis a été modéré
         * @param int $review : l'id de l'avis
         * @return bool : retourne true si l'avis est modéré, false sinon
         */
        function ModerateReview(int $review){
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('SELECT isVisible, date_check FROM reviews WHERE id_review=:id');
                $stmt->bindParam(":id", $review, PDO::PARAM_INT);
                if($stmt->execute())
                {
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($res['isVisible']==0 && $res['date_check']!=null){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            catch(error $e){
                echo("problème avec les données");
                return false;
            }
        }
    
        /**
         * Summary of addReviewRequest : permet d'ajouter un avis à la base de données
         * @param Review $review : avis à ajouter
         * @return bool : retourne false si l'avis n'a pas été ajouté
         */
        function addReviewRequest(Review $review){
            try{
                $pseudo = $review->getPseudo();
                $visite = now();
                $note = $review->getNote();
                $comment = $review->getComment();
    
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare('insert into reviews (pseudo, date_visite,note,comment,isVisible) VALUES (:pseudo, :dateVisite, :note,:comment, 0)');
                $stmt->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
                $stmt->bindParam(":dateVisite", $visite, PDO::PARAM_STR);
                $stmt->bindParam(":note", $note, PDO::PARAM_INT);
                $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
                $stmt->execute();
                return true;
            }
            catch(error $e){
                echo("problème avec les données");
                return false;
            }
    
        }
    
        /**
         * Summary of updateReview : met à jour l'avis dans la base de données
         * @param mixed $id : l'id de l'avis
         * @param mixed $status : delete, moderate ou validate
         * @return void
         */
        function updateReview($id,$status){
            if($status == 'delete'){
                $request = 'DELETE FROM reviews WHERE id_review='.$id;
            }
            else{
                $date_check = now();
                $check_by = $_SESSION['mail'];
                $request= 'UPDATE reviews SET date_check ="'.$date_check.'", check_by="'.$check_by.'"';
                if($status =='validate'){
                    $isVisible = 'isVisible = 1';
                }
                if($status == 'moderate'){
                    $isVisible = 'isVisible = 0';
                }
                $request.=', '.$isVisible.' WHERE id_review='.$id;
            }
            echo($request);
            try{
                $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
                $stmt = $pdo->prepare($request);
                $stmt->execute();
            }
            catch(error $e){
                echo('erreur bd');
            }
        }
    }
    catch(error $e){
        echo('oups une ou plusieurs classes ont disparu...');
    }
}