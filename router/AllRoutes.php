<?php

require_once "Route.php";

// ($url,parametre dans l'url, $title, $pathHtml, $authorize, $pathController)
$allRoutes = array(
    new Route('',false,'Accueil','View/pages/home.php',[],'Controller/HomeController.php'),
    new Route('avis',true,'Avis','View/pages/reviews/reviews.php',[],'Controller/ManageReview.php'),
    new Route('avis',false,'Avis','View/pages/reviews/reviews.php',[],'Controller/ManageReview.php'),
    new Route('services',false,'Services','View/pages/services/services.php',[],'Controller/ManageService.php'),
    new Route('nouveau_service',false,'Nouveau service','View/pages/services/addService.php',['administrateur.trice'],'Controller/ManageService.php'),
    new Route('animal',false,'Habitats','View/elements/animal.php',[],'Controller/ManageAnimal.php'),
    new Route('habitats',false,'Habitats','View/pages/housings/housings.php',[],'Controller/ManageHousing.php'),
    new Route('nouvel_habitat',false,'Nouvel habitat','View/pages/housings/addHousing.php',['administrateur.trice'],'Controller/addHousing.php'),
    new Route('maj_habitat',true,'MAJ habitat','View/pages/housings/updateHousing.php',['administrateur.trice'],'Controller/updateHousing.php'),
    new Route('commentaires_habitats',false,'Com habitats','View/pages/commentsVetoHousing/allComments.php',['Connected'],'Controller/ManageHousing.php'),
    new Route('rapports_medicaux_animal',true,'Rapport Médicaux','View/pages/medicalReports/medicalReportsAnimal.php',['Vétérinaire','administrateur.trice'],'Controller/ManageMedicalReportsAnimal.php'),
    new Route('rapports_medicaux',true,'Rapport Médicaux','View/pages/medicalReports/allMedicalReports.php',['Vétérinaire','administrateur.trice'],'Controller/ManageMedicalReports.php'),
    new Route('rapports_medicaux',false,'Rapport Médicaux','View/pages/medicalReports/allMedicalReports.php',['Vétérinaire','administrateur.trice'],'Controller/ManageMedicalReports.php'),
    new Route('nouveau_rapport',true,'Nouveau rapport','View/pages/medicalReports/addMedicalReport.php',['Vétérinaire','administrateur.trice'],'Controller/ManageMedicalReports.php'),
    new Route('repas',true,'Repas','View/pages/food/foodAnimal.php',['connected'],'Controller/ManageFood.php'),
    new Route('nourrir',true,'Nourrir','View/pages/food/addFood.php',['administrateur.trice','Employé.e'],'Controller/ManageFood.php'),
    new Route('maj_animal',true,'Mise à jour animal','View/pages/animal/updateAnimal.php',['administrateur.trice'],'Controller/updateAnimal.php'),
    new Route('nouvel_animal',true,'Nouvel animal','View/pages/animal/addAnimal.php',['administrateur.trice'],'Controller/addAnimal.php'),
    new Route('nouvel_animal',false,'Nouvel animal','View/pages/animal/addAnimal.php',['administrateur.trice'],'Controller/addAnimal.php'),
    new Route('animaux',false,'Animaux','View/pages/animal/allAnimals.php',[],'Controller/ManageAllAnimals.php'),
);

define('ALL_ROUTES',$allRoutes);

define('WEBSITE_NAME' ,'Arcadia');

define('ROUTE404',new Route('404',false,'Page introuvable','View/pages/404.php',[],''));