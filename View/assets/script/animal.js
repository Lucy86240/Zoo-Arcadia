/*carrousel photo de l'animal*/

// initialisation des variables
const slides = document.querySelectorAll(".js-slideAnimal");
const buttonPrev = document.querySelector(".js-carousel__prev")
const buttonNext = document.querySelector(".js-carousel__next")
let slideIndex = 1;
const durationSlide = 4_000
let resetIntervalSlide = null
let resetIntervalButton = null

//rend visible la slide définie
const showSlides = (slideIndex) => {
    var i;
    // fait en sorte que le numéro de slide soit contenu dans le nombre de slide dispo
    if (slideIndex > slides.length) {slideIndex = 1}
    if (slideIndex < 1) {slideIndex = slides.length}

    //rend invisible tout le monde
    for (i = 0; i < slides.length; i++) {
        slides[i].classList.add("none")
    }

    //rend visible la bonne slide
    slides[slideIndex-1].classList.remove("none")

    //retourne l'indice de la slide affichée
    return slideIndex
}

// au click sur le bouton précédent
const clickButtonPrev = () => {
    buttonPrev.addEventListener('click', () => {
        slideIndex --
        slideIndex = showSlides(slideIndex)
        retryChangeAuto()
})}

// au click sur le bouton next
const clickButtonNext = () => {
    buttonNext.addEventListener('click', () => {
    slideIndex ++
    slideIndex = showSlides(slideIndex)
    retryChangeAuto()
    })
}

//change la slide sans intervention
const changeSlideAuto = () => {
    //réinitialise le temps entre deux slides
    resetIntervalSlide = setInterval( () => {
        slideIndex ++
        slideIndex=showSlides(slideIndex)
    },durationSlide)
}

// reprend le changement automatique
const retryChangeAuto = () => {
    clearInterval(resetIntervalSlide)
    changeSlideAuto()
}

/*lancement des fonctions*/

if(slides != null && buttonPrev != null){
    slideIndex=showSlides(slideIndex)
    clickButtonPrev()
    clickButtonNext()
    changeSlideAuto()
}


/*FIN PARTIE CAROUSSEL*/ 