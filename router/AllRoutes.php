<?php
if($_SERVER['REQUEST_URI']=='/router/allRoutes.php'){
    ?>
    <link rel="stylesheet" href = "../View/assets/css/style.css">
    <?php
    require_once '../View/pages/404.php';
}
else{
        require_once "Route.php";

        // ($url,parametre dans l'url, $title, $pathHtml, $authorize, $pathController)
        $allRoutes = array(
            new Route('',false,'Accueil','View/pages/home.php',[],'Controller/HomeController.php'),
            new Route('avis',true,'Avis','View/pages/reviews/reviews.php',[],'Controller/ManageReview.php'),
            new Route('avis',false,'Avis','View/pages/reviews/reviews.php',[],'Controller/ManageReview.php'),
            new Route('services',false,'Services','View/pages/services/services.php',[],'Controller/ManageService.php'),
            new Route('nouveau_service',false,'Nouveau service','View/pages/services/addService.php',['Administrateur.rice'],'Controller/ManageService.php'),
            new Route('habitats',false,'Habitats','View/pages/housings/housings.php',[],'Controller/ManageHousing.php'),
            new Route('nouvel_habitat',false,'Nouvel habitat','View/pages/housings/addHousing.php',['Administrateur.rice'],'Controller/addHousing.php'),
            new Route('maj_habitat',true,'MAJ habitat','View/pages/housings/updateHousing.php',['Administrateur.rice'],'Controller/updateHousing.php'),
            new Route('commentaires_habitats',false,'Com habitats','View/pages/commentsVetoHousing/allComments.php',['connected'],'Controller/ManageHousing.php'),
            new Route('rapports_medicaux_animal',true,'Rapport Médicaux','View/pages/medicalReports/medicalReportsAnimal.php',['Vétérinaire','Administrateur.rice'],'Controller/ManageMedicalReportsAnimal.php'),
            new Route('rapports_medicaux',true,'Rapport Médicaux','View/pages/medicalReports/allMedicalReports.php',['Vétérinaire','Administrateur.rice'],'Controller/ManageMedicalReports.php'),
            new Route('rapports_medicaux',false,'Rapport Médicaux','View/pages/medicalReports/allMedicalReports.php',['Vétérinaire','Administrateur.rice'],'Controller/ManageMedicalReports.php'),
            new Route('nouveau_rapport',true,'Rapport Médicaux','View/pages/medicalReports/addMedicalReport.php',['Vétérinaire'],'Controller/ManageMedicalReportsAnimal.php'),
            new Route('repas_animal',true,'Repas','View/pages/foodAnimal/foodAnimal.php',['connected'],'Controller/ManageFoodAnimal.php'),
            new Route('repas',false,'Repas','View/pages/foodAnimal/allfood.php',['connected'],'Controller/ManageFood.php'),
            new Route('nourrir',true,'Nourrir','View/pages/foodAnimal/fedAnimal.php',['Employé.e'],'Controller/ManageFoodAnimal.php'),
            new Route('maj_animal',true,'Mise à jour animal','View/pages/animal/updateAnimal.php',['Administrateur.rice'],'Controller/updateAnimal.php'),
            new Route('nouvel_animal',true,'Nouvel animal','View/pages/animal/addAnimal.php',['Administrateur.rice'],'Controller/addAnimal.php'),
            new Route('nouvel_animal',false,'Nouvel animal','View/pages/animal/addAnimal.php',['Administrateur.rice'],'Controller/addAnimal.php'),
            new Route('animaux',false,'Animaux','View/pages/animal/allAnimals.php',[],'Controller/ManageAllAnimals.php'),
            new Route('animaux',true,'Animaux','View/pages/animal/allAnimals.php',[],'Controller/ManageAllAnimals.php'),
            new Route('dashboard',false,'Dashboard','View/pages/dashboard.php',['connected'],'Controller/DashboardController.php'),
            new Route('comptes_utilisateurs',false,'Comptes utilisateur','View/pages/usersBoard.php',['Administrateur.rice'],'Controller/ManageUsers.php'),
            new Route('contact',false,'Contact','View/pages/contact.php',['disconnect'],'Controller/ManageContact.php'),
            new Route('horaires',false,'Mise à jour horaires','View/pages/updateSchedules.php',['Administrateur.rice'],'Controller/updateSchedules.php'),
            new Route('mentions_legales',false,'Mentions légles','View/pages/legalNotice.php',[],'Controller/attributions.php'),
            new Route('politique_confidentialite',false,'Politique de confidentialité','View/pages/privacyPolicy.php',[],'Controller/attributions.php'),
    
        );
    
        define('ALL_ROUTES',$allRoutes);
    
        define('WEBSITE_NAME' ,'Arcadia');
    
        define('ROUTE404',new Route('404',false,'Page introuvable','View/pages/404.php',[],''));
}