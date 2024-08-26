//Pour une mise en page différente de la page d'accueil après le scroll

const container = document.querySelector("#container-fluid")
const dropdown = document.querySelector("#dropdown-menu")

let scroll = false

if(window.location.href==(SITE_URL)){
    window.onscroll = function(){
        if (window.scrollY > 1 && scroll===false){
            container.classList.add("scroll");
            dropdown.classList.add("scroll");
            container.classList.remove("top");
            dropdown.classList.remove("top");
            
            scroll = true
        }
        else if (window.scrollY <= 1){
            container.classList.add("top");
            dropdown.classList.add("top");
            container.classList.remove("scroll");
            dropdown.classList.remove("scroll");
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

function urlWithoutParameters(){

    switch(window.location.href){
        case SITE_URL+'/avis': return true;
        case SITE_URL+'/': return true;
    }
    return false;
}

const nameLog = document.querySelector('.js-nameLog')
accountConnected.addEventListener('mouseover', ()=>{
    if (urlWithoutParameters()){
        accountConnected.src = "View/assets/img/general/header/logout.svg";
    }
    else{
        accountConnected.src = "../View/assets/img/general/header/logout.svg";
    }
    if(nameLog.innertHTML != 'Me connecter'){
        text.classList.remove('none');
        text.style = 'color: red; font-size: 12px;';
        nameLog.style = 'color: red;';
    }
})
accountConnected.addEventListener('mouseout', ()=>{
    if (urlWithoutParameters()){
        accountConnected.src = "View/assets/img/general/header/connected.png";
    }
    else{
        accountConnected.src = "../View/assets/img/general/header/connected.png";
    }

    text.classList.add('none');
    nameLog.style = 'color: var(--brown)';
})
