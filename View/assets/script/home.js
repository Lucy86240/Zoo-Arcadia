/*Au passage de la souris le nom de l'animal apparait*/

const animals1 = document.querySelectorAll(".home-housing-animal1 ");
const titleAnimals1 = document.querySelectorAll(".home-title-animal1-position");
const animals2 = document.querySelectorAll(".home-housing-animal2 ");
const titleAnimals2 = document.querySelectorAll(".home-title-animal2-position");
const animals3 = document.querySelectorAll(".home-housing-animal3 ");
const titleAnimals3 = document.querySelectorAll(".home-title-animal3-position");

let onImg = false;
for(let i=0;i<animals1.length;i++){
    animals1[i].addEventListener("mouseover", () => {
        //ajoute le titre à la sélection
        titleAnimals1[i].classList.remove("none")
    })
    animals1[i].addEventListener("mouseout", () => {
        //enlève le titre
        titleAnimals1[i].classList.add("none")
    })
}


for(let i=0;i<animals2.length;i++){
    animals2[i].addEventListener("mouseover", () => {
        titleAnimals2[i].classList.remove("none")
    })
    animals2[i].addEventListener("mouseout", () => {
        titleAnimals2[i].classList.add("none")
    })
}
for(let i=0;i<animals3.length;i++){
    animals3[i].addEventListener("mouseover", () => {
        titleAnimals3[i].classList.remove("none")
    })
    animals3[i].addEventListener("mouseout", () => {
        titleAnimals3[i].classList.add("none")
    })
}


/*au passage de la souris sur un animal son nom s'affiche et les autres animaux deviennent plus petits et transparents

imgAnimals = document.querySelectorAll(".home-animal-img");

/*imgAnimals.array.forEach(element => {
    element.addEventlistener("mouseover", ()=>{

    })
});*/

