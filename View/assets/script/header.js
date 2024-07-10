//Pour une mise en page différente après le scrool

const container = document.querySelector("#container-fluid")
const dropdown = document.querySelector("#dropdown-menu")

let scroll = false

window.onscroll = function(){
    if (window.scrollY > 1 && scroll===false ){
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

//affiche le sous-menu de l'espace utilisateur
const userMenu = document.querySelector("#dropdown-toggle");
const menuUser = document.querySelector(".dropdown");
const arrowC = document.querySelector("#arrow-close");
const arrowO = document.querySelector("#arrow-open");

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

//image burger centré
const burger = document.querySelector(".menu");
const check = document.getElementById("toggle").checked = true;

if(check){
    burger.classList.add('text-center')
}
else{
    burger.classList.remove('center')
}

//popup de connexion
const triggerCo = document.querySelector('#popup-login'); 
const dialogCo = document.getElementById('login-dialog');
const dismissTriggerCo = dialogCo.querySelector('[data-dismiss]');
popup(dialogCo,triggerCo,dismissTriggerCo)

//validation connexion
