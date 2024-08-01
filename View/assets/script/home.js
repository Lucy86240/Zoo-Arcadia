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


/*carroussel en cas de plus de trois habitats pour les desktop*/
const durationSlide = 5_000;

const slidesHousing = document.querySelectorAll(".js-slide");
let slideIndex = 0;
const nbSlideViewHousing = 3;

//rend visible la slide définie et les x suivantes (suivant le nombre à afficher(nbSlideView))
const showSlides = (slides, firstSlide, nbSlideView) => {
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
const changeSlideAuto = (slideIndex, slides, nbSlide) => {
    setInterval( () => {
        slideIndex +=nbSlideViewHousing;
        slideIndex=showSlides(slides,slideIndex,nbSlide);
    },durationSlide)
}
function carrouselHousing(){
    //lancement des fonctions
    if(slidesHousing.length > nbSlideViewHousing){
        slideIndex=showSlides(slidesHousing,slideIndex,nbSlideViewHousing);
        changeSlideAuto(slideIndex,slidesHousing,nbSlideViewHousing);
    }
}
if(window.innerWidth>576){
    carrouselHousing();
}
window.addEventListener("resize", carrouselHousing);


/*carrousel animaux mobile*/
const slidesAnimals = document.querySelectorAll(".js-slideAnimal");
const rounds = document.querySelectorAll(".round");
slideIndex = 0;
const nbSlideViewAnimals = 1;

const showSlidesAnimal = (firstSlide) => {
    let slideIndex = firstSlide;

    //on vérifie que la slide est incluse dans les slides
    if (slideIndex >= slidesAnimals.length) {slideIndex = 0;}
    if (slideIndex < 0) {slideIndex = slidesAnimals.length-1;}

    firstSlide = slideIndex

    //on rend "invisible" tous les habitats
    for (let i = 0; i < slidesAnimals.length; i++) {
        slidesAnimals[i].classList.add("none");
        slidesAnimals[i].classList.remove("animal-selected"); 
    }
    for(let k=0; k<slidesAnimals.length; k++){
        rounds[k].classList.remove("round-selected");
    }
    rounds[slideIndex].classList.add("round-selected");

    //on affiche ceux souhaités
    let index = slideIndex;

    for (let j=0; j<nbSlideViewAnimals ; j++){
        slidesAnimals[index].classList.remove("none");
        slidesAnimals[index].classList.add("animal-selected");       
        index++;
        if (index > slidesAnimals.length-1) {index = 0;}
        if (index < 0) {index= slidesAnimals.length-1;}
    }
    return firstSlide;
}

const changeSlideAutoAnimal = () => {
    setInterval( () => {
        slideIndex ++;
        slideIndex=showSlidesAnimal(slideIndex);
    },durationSlide)
}

if(slidesAnimals.length > nbSlideViewAnimals){
    slideIndex=showSlidesAnimal(slideIndex);
    changeSlideAutoAnimal();
}