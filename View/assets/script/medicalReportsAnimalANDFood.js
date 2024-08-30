
//PAGES : rapports_medicaux et repas (avec un GET)

//ouvre et ferme la fiche de l'animal
fiche = document.querySelector(".js-animal-popup")
icon = document.querySelector(".js-animal")
closeAnimal = document.querySelector('.buttonCloseAnimal');

icon.addEventListener('click', () => {
    fiche.classList.remove("none")
})
closeAnimal.addEventListener('click',()=>{
    fiche.classList.add('none');
})

