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
        titleAnimals1[i].classList.remove("none");
    })
    animals1[i].addEventListener("mouseout", () => {
        //enlève le titre
        titleAnimals1[i].classList.add("none");
    })
}

for(let i=0;i<animals2.length;i++){
    animals2[i].addEventListener("mouseover", () => {
        titleAnimals2[i].classList.remove("none");
    })
    animals2[i].addEventListener("mouseout", () => {
        titleAnimals2[i].classList.add("none");
    })
}
for(let i=0;i<animals3.length;i++){
    animals3[i].addEventListener("mouseover", () => {
        titleAnimals3[i].classList.remove("none");
    })
    animals3[i].addEventListener("mouseout", () => {
        titleAnimals3[i].classList.add("none");
    })
}


/*carroussel en cas de plus de trois habitats*/

const slides = document.querySelectorAll(".js-slide");
let slideIndex = 0;;
const imagesPerHousing=4;
const nbSlideView = 3*imagesPerHousing;
const durationSlide = 5_000;

//rend visible la slide définie et les x suivantes (suivant le nombre à afficher(nbSlideView))
const showSlides = (firstSlide) => {
    let slideIndex = firstSlide;

    //on vérifie que la slide est incluse dans dans slides
    if (slideIndex >= slides.length) {slideIndex = 0;}
    if (slideIndex < 0) {slideIndex = slides.length-1;}

    firstSlide = slideIndex

    //on rend "invisible" tous les habitats
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.add("none");
    }

    //on affiche ceux souhaités
    let index = slideIndex;
    for (let j=0; j<nbSlideView ; j++){
        slides[index].classList.remove("none");
        index++
        if (index > slides.length-1) {index = 0;}
        if (index < 0) {index= slides.length-1;}
    }
    return firstSlide
}

//change la slide automatiquement
const changeSlideAuto = () => {
    setInterval( () => {
        slideIndex +=imagesPerHousing;
        console.log(slideIndex);
        slideIndex=showSlides(slideIndex);
    },durationSlide)
}

//lancement des fonctions
if(slides.length > nbSlideView){
    slideIndex=showSlides(slideIndex);
    changeSlideAuto();
}
