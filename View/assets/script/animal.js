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

/*update animal*/

//affichage des races suivant une saisie
    // Declare variables
    const input = document.querySelectorAll('.updateBreed');
    const ul = document.querySelectorAll('.breeds');
    const newBreed = document.querySelectorAll('.newBreed');
    const messageResult = document.querySelectorAll('.messageResult');

function nbResult(filter, list){
    count = 0;
    for (let j = 0; j < list.length; j++) {
        const label = list[j].getElementsByTagName("label")[0];
        const txtValue = label.textContent || label.innerText;
        //on vérifie la correspondance entre les boutons radios et la saisie
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            count++;
        }
    }
    return count;
}

for(let i=0; i<input.length;i++){
    input[i].addEventListener('input',() => {
        
        const filter = input[i].value.toUpperCase();
        const li = ul[i].getElementsByTagName('li');
        if(filter != ""){
            for(let k=0; k<li.length;k++){
                li[k].classList.remove('none');
            }
        }
        if(nbResult(filter,li) <= 5){
            for (let j = 0; j < li.length; j++) {
                const label = li[j].getElementsByTagName("label")[0];
                const txtValue = label.textContent || label.innerText;
                //on vérifie la correspondance entre les boutons radios et la saisie
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[j].classList.remove('none');
                } else {
                    li[j].classList.add('none');
                }
            }
            console.log('moins 5')
            messageResult[i].classList.add('none');
        }
        else{
            if(filter != ""){
                console.log('+5 if')
                messageResult[i].classList.remove('none');
            }
            else{
                console.log('+5 else')
                messageResult[i].classList.add('none');
            } 
        }
        if(filter == "" || nbResult(filter,li)>5){
            for(let k=0; k<li.length;k++){
                li[k].classList.add('none');
            }
        }
        if(nbResult(filter,li)==0 && filter !=""){
            newBreed[i].classList.remove('none');
        } 
        else{
            newBreed[i].classList.add('none');}
    })
}
