//HEADER

//Pour une mise en page différente de la page d'accueil avant le scroll

const container = document.querySelector("#container-fluid")
const dropdown = document.querySelector("#dropdown-menu")

let scroll = false

//si on est sur la page d'accueil
if(window.location.href==(SITE_URL)){
    //au scroll au change de class
    window.onscroll = function(){
        if (window.scrollY > 1 && scroll===false){
            container.classList.add("scroll");
            container.classList.remove("top");
            if(dropdown != null){
                dropdown.classList.add("scroll");
                dropdown.classList.remove("top");
            }
            
            scroll = true
        }
        else if (window.scrollY <= 1){
            container.classList.add("top");
            container.classList.remove("scroll");
            if(dropdown != null){
                dropdown.classList.add("top");
                dropdown.classList.remove("scroll");
            }
            scroll = false
        }
    }
}else{
    container.classList.add("scroll");
    if(dropdown != null) dropdown.classList.add("scroll");
    container.classList.remove("top");
    if(dropdown != null) dropdown.classList.remove("top");
}


//affiche le sous-menu de l'espace utilisateur
const userMenu = document.querySelector("#dropdown-toggle");
const menuUser = document.querySelector(".dropdown");
const arrowC = document.querySelector("#arrow-close");
const arrowO = document.querySelector("#arrow-open");

if (userMenu != null){
    userMenu.addEventListener("click", ()=>{
        if(document.querySelector('#dropdown-menu.none') !== null){
            dropdown.classList.remove('none');
            dropdown.classList.add('bgc-dropdown')
            userMenu.classList.add('dropdown-selected')
            arrowO.classList.remove('none');
            arrowC.classList.add('none');
        }
        else{
            dropdown.classList.add('none');
            arrowO.classList.add('none');
            arrowC.classList.remove('none');
            dropdown.classList.remove('bgc-dropdown')
            userMenu.classList.remove('dropdown-selected')
        }
    })
}

//popup de connexion
const triggerCo = document.querySelector('#popup-login'); 
const dialogCo = document.getElementById('login-dialog');

if(triggerCo != null){
    triggerCo.addEventListener('click',()=>{
    dialogCo.classList.remove('none');
    })
}

//déconnexion
const accountConnected = document.querySelector('.account-connected');
const text = document.querySelector('.logoutText');

/**
 * urlWithoutParameters : indique si l'url n'a pas de paramètre
 * @returns 
 */
function urlWithoutParameters(){

    switch(window.location.href){
        case SITE_URL+'/avis': return true;
        case SITE_URL+'/': return true;
        case SITE_URL+'/habitats' : return true;
        case SITE_URL+'/services' : return true;
        case SITE_URL+'/nouveau_service' : return true;
        case SITE_URL+'/nouvel_habitat' : return true;
        case SITE_URL+'/commentaires_habitats' : return true;
        case SITE_URL+'/rapports_medicaux' : return true;
        case SITE_URL+'/repas' : return true;
        case SITE_URL+'/nouvel_animal' : return true;
        case SITE_URL+'/animaux' : return true;
        case SITE_URL+'/dashboard' : return true;
        case SITE_URL+'/comptes_utilisateurs' : return true;
        case SITE_URL+'/contact' : return true;
        case SITE_URL+'/horaires' : return true;
        case SITE_URL+'/mentions_legales' : return true;
        case SITE_URL+'/politique_confidentialite' : return true;
    }
    return false;
}

//modification de l'affichage au survol de la partie connexion
const nameLog = document.querySelector('.js-nameLog')
accountConnected.addEventListener('mouseover', ()=>{
    //affichage de l'image de déconnexion
    if (urlWithoutParameters()){
        accountConnected.src = "View/assets/img/general/header/logout.svg";
    }
    else{
        accountConnected.src = "../View/assets/img/general/header/logout.svg";
    }
    //modification couleur du texte
    if(nameLog.innertHTML != 'Me connecter'){
        text.classList.remove('none');
        text.style = 'color: red; font-size: 12px;';
        nameLog.classList.add('nameLogHover');
        nameLog.classList.remove('nameLog');
    }
})
accountConnected.addEventListener('mouseout', ()=>{
    //affichage de l'icone connecté
    if (urlWithoutParameters()){
        accountConnected.src = "View/assets/img/general/header/connected.png";
    }
    else{
        accountConnected.src = "../View/assets/img/general/header/connected.png";
    }

    text.classList.add('none');
    nameLog.classList.add('nameLog')
    nameLog.classList.remove('nameLogHover');
})
