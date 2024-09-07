<?php
//on execute le programme seulement si l'url est différent du chemin du fichier
if($_SERVER['REQUEST_URI']!='/Controller/ManageAnimal.php'){
    try{
        require_once "Model/ManageAnimalModel.php";
        require_once 'Model/ManageHousingModel.php';
        /**
         * Summary of changeAnimalObjectToAssociatif : prend un objet animal et le change en tableau asso
         * @param Animal $animalObject : l'animal objet a transformé en tableau associatif
         * @param bool $allReport : true si l'on souhaite que le tableau contienne tous les rapports médicaux
         * @param bool $foods : true si l'on souhaite que le tableau contienne tous les repas de l'animal
         * @param bool $popularity : true si l'on souhaite que le tableau contienne les infos sur la popularité de l'animal
         * @return array
         */
        function changeAnimalObjectToAssociatif(Animal $animalObject, bool $allReport, bool $foods, bool $popularity){
            //on vérifie d'abord que l'animal existe dans la base de données
            if(animalExistById(($animalObject->getId()))){
                //on crée le tableau avec les infos essentielles
                $animal = array(
                    "id" => $animalObject->getId(),
                    "name" => $animalObject->getName(),
                    "housing" => $animalObject->getHousing(),
                    "breed" => $animalObject->getBreed(),
                    "isVisible" => $animalObject->getIsVisible(),
                    "numberReports" => $animalObject->countMedicalReports(),
                    "numberFoods" => $animalObject->countFoods()
                );
                //on indique les infos sur le dernier compte rendu médical s'il existe
                if($animalObject->getLastMedicalReport() != null){
                    $animal['LastMedicalReport'] = array(
                        "date" => date("d/m/Y",strtotime($animalObject->getLastMedicalReport()->getDate())), //on affiche la date de manière plus lisible
                        "health" => $animalObject->getLastMedicalReport()->getHealth(),
                        "food" => $animalObject->getLastMedicalReport()->getFood(),
                        "weight_of_food" => $animalObject->getLastMedicalReport()->getWeightOfFood(),
                        "comment" => $animalObject->getLastMedicalReport()->getComment(),
                    );
                    // on récupère le nom prénom du vétérinaire
                    $animal['LastMedicalReport']["veterinarian"] = findNameofUser($animalObject->getLastMedicalReport()->getIdVeterinarian());
                }
                //on récupère tous les comptes rendus si on le souhaite
                if($allReport == true && $animalObject->getLastMedicalReport() != null){
                    $animal['reports'] = [];
                    for($i=0; $i<$animalObject->countMedicalReports();$i++){
                        $report = array(
                            "date" => $animalObject->getMedicalReport($i)->getDate(),
                            "health" => $animalObject->getMedicalReport($i)->getHealth(),
                            "food" => $animalObject->getMedicalReport($i)->getFood(),
                            "weight_of_food" => $animalObject->getMedicalReport($i)->getWeightOfFood(),
                            "comment" => $animalObject->getMedicalReport($i)->getComment(),
                        );
                        $report['veterinarian']= findNameofUser($animalObject->getMedicalReport($i)->getIdVeterinarian());
                        array_push($animal['reports'],$report);
                    }
                }
    
                // on récupère les infos des photos
                $animal['images'] = [];
                for($i=0 ; $i<$animalObject->countImages(); $i++){
                    $img= array(
                        "path" => $animalObject->getImage($i)->getPath(),
                        "description" => $animalObject->getImage($i)->getDescription(),
                        "id" => $animalObject->getImage($i)->getId(),
                    );
                    array_push($animal['images'],$img);
                }
                //si pas de photo on en met une par défaut
                if($animal['images']==[]){
                    $img= array(
                        "path" => IMG_DEFAULT_ANIMAL,
                        "description" => 'pas de photo disponible',
                        "id" => 0,
                    );
                    array_push($animal['images'],$img);
                }
                //on récupère les repas si on le souhaite
                if($foods){
                    $animal['foods'] = [];
                    for($i=0; $i<$animalObject->countFoods();$i++){
                        $food = array(
                            "date" => $animalObject->getFoods($i)->getDate(),
                            "hour" => $animalObject->getFoods($i)->getHour(),
                            "food" => $animalObject->getFoods($i)->getFood(),
                            "weight" => $animalObject->getFoods($i)->getWeight(),
                        );
                        //on récupère les nom prénom de l'employé ayant donné le repas
                        $food['employee']= findNameofUser($animalObject->getFoods($i)->getIdEmployee());
                        array_push($animal['foods'],$food);
                    }
                }
                // dans le cas on où souhaite les infos sur la popularité
                if($popularity==true){
                    $animal['popularityRange'] = $animalObject->getPopularityRange();
                    $animal['numberClics'] = $animalObject->getNumberOfClics();
                }
                return $animal;
            }
            else return [];
        }
    
        /**
         * Summary of animalsWithPopularity : transmet un tableau de tous les animaux triés par popularité
         * @return array tableau associatif d'animaux avec les infos sur la popularité (popularityRange, numberClics)
         */
        function animalsWithPopularity(){
            //on récupère les animaux par ordre de popularité
            $animalsObject = animalsOrderByPopularity();
            $animals = [];
            //on crée le tableau associatif
            foreach($animalsObject as $animalObject){
                $animal = changeAnimalObjectToAssociatif($animalObject,false,false,true);
                array_push($animals,$animal);
            }
            return $animals;
        }
    
        /**
         * Summary of animalsView retourne un tableaux associatifs avec des informations d'animaux
         * @param int $justVisibleAnimal : indiquer si les animaux doivent être visibles (2 si peut importe)
         * @param int $nbAnimals : nombre d'animaux souhaité (-1 si tous)
         * @param bool $medicalDetail : true si on veut le détail des avis médicaux
         * @return array
         */
        function animalsView(int $justVisibleAnimal, int $nbAnimals, bool $medicalDetail){
            $animalsObject = animalsExtract($justVisibleAnimal,$nbAnimals,$medicalDetail);
            $animals = [];
            foreach($animalsObject as $animalObject){
                if($animalObject != null) $animal = changeAnimalObjectToAssociatif($animalObject, false,false,false);
                else $animal=null;
                array_push($animals,$animal);
            }
            
            return $animals;
        }
    
        /**
         * Summary of animalById: retourne un tableau associatif avec les infos de l'animal ayant l'id entré en paramétre
         * @param int $id : id de l'animal souhaité
         * @param bool $allReport : true si l'on souhaite avoir les avis médicaux
         * @param bool $food : true si l'on souhaite avoir les repas
         * @return array|null : return null si l'animal n'existe pas
         */
        function animalById(int $id,bool $allReport,bool $foods){
            $animalObject=findAnimalById($id);
            //var_dump($animalObject);
            if($animalObject!=null) $animal = changeAnimalObjectToAssociatif($animalObject, $allReport, $foods,false);
            else $animal = null;
            return $animal;
        }
    
        /**
         * Summary of deleteAnimal : permet de supprimer un animal en fonction d'un formulaire
         * @param int $id : id de l'animal à supprimer
         * @param string $name : nom de l'animal à supprimer
         * @param int $id_housing : id de l'habitat de l'animal à supprimer
         * @return void
         */
        function deleteAnimal(int $id, string $name, int $id_housing, &$elements){
            //on recupère le nom du bouton à cliquer pour supprimer l'animal
            $nameButton = "ValidationDeleteAnimal".$id;
            //si on a cliqué sur le bouton
            if(isset($_POST[$nameButton]) && $_POST[$nameButton]!=null){
                //suppression dans la base de données
                deleteAnimalRequest($id);
                //suppression des images
                $path = "View/assets/img/animals/".$id.'-'.$name.'/';
                rrmdir($path);
                //si on est sur la page habitat on enlève son affichage
                if($elements != null){
                    $_SESSION['animal'.$id_housing] = null;
                    $elements = allHousingsView(true,-1,-1,1,1);
                }
                else{
                    $elements = null;
                }
                $_POST[$nameButton]=null;
            } 
            
        }
    
        /**
         * Summary of deleteAnimalWithoutForm : permet de supprimer un animal sans formulaire
         * @param Animal $animal : l'objet de l'animal à supprimer
         * @return void
         */
        function deleteAnimalWithoutForm(Animal $animal){
                //suppression dans la base de données
                deleteAnimalRequest($animal->getId());
                //suppression des images
                $path = "View/assets/img/animals/".$animal->getId().'-'.$animal->getname().'/';
                rrmdir($path);
                $_SESSION['animal'.$animal->getIdHousing()] = null;
        }
    
        /**
         * Summary of archiveAnimal : permet d'archive un animal (nécessite un formulaire)
         * @param mixed $animal : tableau asso de l'animal à archiver (va modifier le isVisible)
         * @param mixed $housings : tableau asso d'habitats, va enlever l'animal (null si pas utile)
         * @return void
         */
        function archiveAnimal(&$animal,&$housings){
            //on recupère le nom du bouton à cliquer pour archiver l'animal
            $nameButton = "ValidationArchiveAnimal".$animal['id'];
            //si on a cliqué sur le bouton
            if(isset($_POST[$nameButton]) && $_POST[$nameButton]!=null){
                //modif de isVisible dans la base de données
                archiveAnimalRequest($animal['id']);
                $_POST[$nameButton]=null; 
                //mise à jour de l'animal entrée en paramètre
                $animal = changeAnimalObjectToAssociatif(findAnimalById($animal['id']), true, true,false);
                //mise à jour du tableau d'habitats entré en paramètre
                if($housings != null){
                    $housing=FindHousingByName($animal['housing']);
                    $_SESSION['animal'.$housing["id_housing"]] = null;
                    $housings = allHousingsView(true,-1,-1,1,1);
                }
            } 
            
        }
    
        /**
         * Summary of unarchiveAnimal permet de désarchiver un animal
         * @param mixed $animal : tableau asso de l'animal à désarchiver (va changer le isVisible)
         * @return void
         */
        function unarchiveAnimal(&$animal){
            //on recupère le nom du bouton à cliquer pour supprimer l'animal
            $nameButton = "ValidationUnarchiveAnimal".$animal['id'];
            //si on a cliqué sur le bouton
            if(isset($_POST[$nameButton]) && $_POST[$nameButton]!=null){
                //suppression dans la base de données
                unarchiveAnimalRequest($animal['id']);
                $_POST[$nameButton]=null;
                $animal = changeAnimalObjectToAssociatif(findAnimalById($animal['id']), true,true,false);
            } 
            
        }
    
        /**
         * Summary of echoAnimal permet de réaliser toutes les actions lié à une fiche animal (affichage, archivage, désarchivage, suppression)
         * @param mixed $id : id de l'animal à afficher
         * @param mixed $page : sur quelle page on se trouve ('housings','allAnimals','') pour mise à jour des $_SESSION
         * @param mixed $elements : tableaux d'habitats si on se trouve sur la page habitats (pour mise à jour)
         * @return void
         */
        function echoAnimal($id,$page,&$elements){
            //on cherche mes info de l'animal
            $animal = animalById($id,false,false);
            //var_dump($animal);
            //on trouve l'id de son habitat et on sauve l'animal via une variable de session (pour pages habitats)
            $housing=FindHousingByName($animal['housing']);
            if($page=='housings'){
                if($animal['isVisible']==1){
                    // on ajoute un clic à l'animal
                    if((!isset($_SESSION['role']) OR $_SESSION['role']=='') AND 
                    (!isset($_SESSION['animal'.$housing["id_housing"]]) OR 
                    $_SESSION['animal'.$housing["id_housing"]]==null OR
                    (isset($_SESSION['animal'.$housing["id_housing"]]) AND $_SESSION['animal'.$housing["id_housing"]]!=$animal['id']))){
                        animalClic($animal['id']);
                    } 
                    $_SESSION['animal'.$housing["id_housing"]] = $animal['id'];
                    //on permet la suppression / l'archivage / le désarchivage
                    deleteAnimal($animal['id'],$animal['name'],$housing["id_housing"],$elements);
                    archiveAnimal($animal,$elements);
                    unarchiveAnimal($animal);
                    //on affiche les infos
                    include "View/elements/animal.php";
                }
                else {
                    $_SESSION['animal'.$housing["id_housing"]] = null;
                }
            }
    
            if($page=='allAnimals'){
                // on ajoute un clic à l'animal
                if((!isset($_SESSION['role']) OR $_SESSION['role']=='') AND 
                (!isset($_SESSION['allAnimals_animalSelected']) OR 
                $_SESSION['allAnimals_animalSelected']==null OR
                (isset($_SESSION['allAnimals_animalSelected']) AND $_SESSION['allAnimals_animalSelected']!=$animal['id']))){
                    animalClic($animal['id']);
                } 
                $_SESSION['allAnimals_animalSelected'] = $animal['id'];
                    //on permet la suppression / l'archivage / le désarchivage
                $elements = null;
                deleteAnimal($animal['id'],$animal['name'],$housing["id_housing"],$elements);
                archiveAnimal($animal,$elements);
                unarchiveAnimal($animal);
    
                //on affiche les infos
                include "View/elements/animal.php";
            } 
        }
    }
    catch(error $e){
        echo('Oups nous ne trouvons pas les informations nécessaires à la page...');
    }

}
else{
    // on affiche la page 404
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
