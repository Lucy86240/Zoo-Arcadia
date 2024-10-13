<?php 
require_once "../config.php";
    function listAllBreeds(){
        try{
            $pdo = new PDO(DATA_BASE,USERNAME_DB,PASSEWORD_DB);
            $stmt = $pdo->prepare('SELECT * FROM breeds');
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        catch(Error $e){
            return '';
        }
    }
    $breeds = listAllBreeds();
    $value = $_REQUEST['value'];
    $breedsS = explode(',',$_REQUEST['breeds']);
    $max = $_REQUEST['max'];
    $hint = [];

    // lookup all hints from array if $q is different from ""
    if ($value !== "") {
    $value = strtolower($value);
    $len=strlen($value);
        foreach($breeds as $breed) {
            if (str_contains(strtolower($breed['label']),$value)) {
                array_push($hint,$breed);
            }
        }
    }
    // Output "no suggestion" if no hint was found or output correct values
    if(count($hint)>$max)
        echo "<span> trop de résultats possibles <span>";
    else if(count($hint)==0)
        echo "<span> il n'existe pas de races dans notre base avec ces éléments... <span>";
    else{
        $i=0;
        function defaultValueCheckbox(string $filter, $value){
            if(isset($_POST[$filter]) && $filter !='sort' && !isset($_POST['cancelFilter'])) return 'checked';
            elseif($filter=='sort'){
                if((!isset($_POST['sort']) || isset($_POST['cancelFilter'])) && $value=='popular') return 'checked';
                elseif(isset($_POST['sort']) && $_POST['sort']==$value && !isset($_POST['cancelFilter'])) return 'checked';
                elseif(isset ($_SESSION['allAnimals_sort']) && $_SESSION['allAnimals_sort']==$value) return 'checked';
                else return '';
            }
            else{
                if(!isset($_POST['choices'])){
                    if(substr($filter,0,13)=="breedSelected"){
                        if(isset($_SESSION['allAnimals_filterBreeds'])){
                            $ind = array_search($value,$_SESSION['allAnimals_filterBreeds'],false);
                            if(isset($_SESSION['allAnimals_filterBreeds'][$ind]) && $_SESSION['allAnimals_filterBreeds'][$ind]==$value) return 'checked';
                            else return '';
                        } 
                        else return '';
                    }
                    elseif(substr($filter,0,7)=="housing"){
                        if(isset($_SESSION['allAnimals_filterhousings']) && $_SESSION['allAnimals_filterhousings']!=[]){
                            $ind = array_search($value,$_SESSION['allAnimals_filterhousings'],false);
                            if(isset($_SESSION['allAnimals_filterhousings'][$ind]) && $_SESSION['allAnimals_filterhousings'][$ind]==$value) return 'checked';
                            else return '';
                        } 
                        else return 'checked';
                    }
                    elseif($filter == 'archive'){
                        if(isset($_SESSION['allAnimals_filterIsVisible']) && 
                        ($_SESSION['allAnimals_filterIsVisible'] == 0 || $_SESSION['allAnimals_filterIsVisible']==2)) return 'checked';
                        elseif(isset($_SESSION['allAnimals_filterIsVisible']) && ($_SESSION['allAnimals_filterIsVisible'] == 1)) return '';
                        else return 'checked';
                    }
                    elseif($filter == 'visible'){
                        if(isset($_SESSION['allAnimals_filterIsVisible']) && 
                        ($_SESSION['allAnimals_filterIsVisible'] == 1 || $_SESSION['allAnimals_filterIsVisible']==2)) return 'checked';
                        elseif(isset($_SESSION['allAnimals_filterIsVisible']) && ($_SESSION['allAnimals_filterIsVisible'] == 0)) return '';
                        else return 'checked';
                    }
                    else return '';
                }
                else return '';
            }
        }
        foreach($hint as $breed)
        {   
            if( !in_array($breed['label'],$breedsS))
            echo 
            "<li class=\"form-check\" id=\"BS_".$breed['label']."\">
            <input label=\"".$breed['label']."\" class=\"form-check-input js-checkboxBreedsSearch\" type=\"checkbox\" name=\"breeds".$breed['id_breed']."\" id=\"breed".$i."\"".defaultValueCheckbox('breedSelected'.$i,$breed['id_breed']).">
            <label class=\"form-check-label\" for=\"breed".$i."\">"
                .$breed['label'].
            "</label>
        </li>";
        $i++;
        }
    }