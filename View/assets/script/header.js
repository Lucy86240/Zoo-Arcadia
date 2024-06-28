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
userMenu.addEventListener("click", ()=>{
    if(document.querySelector('#dropdown-menu.none') !== null){
        dropdown.classList.remove("none");
    }
    else{
        dropdown.classList.add("none");
    }
})


const MenuMobile = document.querySelector(".navbar-toggler");
if(window.width < 556){
    if(document.querySelector('.navbar-toggler.none') !== null){
        MenuMobile.classList.remove("none");
    }
}
else{
    if(document.querySelector('.navbar-toggler.none') == null){
        MenuMobile.classList.add("none");
    }
}
