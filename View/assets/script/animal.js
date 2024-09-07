/* affichage d'un animal */

/* gestion des popup*/

//suppression
const iconDeleteAnimal = document.querySelectorAll('.iconDeleteAnimal')

if(iconDeleteAnimal != null){
    for(let i=0; i<iconDeleteAnimal.length;i++){
        iconDeleteAnimal[i].addEventListener('click',()=>{
            titleContent = "Suppression"
            parContent = "Etes vous sûr de vouloir supprimer l'animal : \""+iconDeleteAnimal[i].getAttribute('nameAnimal')+"\" de race \""+iconDeleteAnimal[i].getAttribute('breedAnimal')+"\" ?"
            submitContent="ValidationDeleteAnimal"+iconDeleteAnimal[i].getAttribute('id')
            createConfirm(titleContent,parContent,submitContent)
        })
    }
}

buttonValidate = document.querySelectorAll('.button-confirm');
if(buttonValidate != null)
    for(let i=0; i<buttonValidate.length;i++)
    {
        buttonValidate[i].addEventListener('click',()=>{
            console.log('helo')
            location.reload();
        })
    }

//archivage
const iconArchive = document.querySelectorAll('.iconArchive')
const popupArchive = document.querySelectorAll('.popupArchive')

if(iconArchive != null){
    popupConfirm(iconArchive,popupArchive)
}

//désarchivage

const iconUnarchive = document.querySelectorAll('.iconUnarchive')
const popupUnarchive = document.querySelectorAll('.popupUnarchive')

if(iconUnarchive != null){
    popupConfirm(iconUnarchive,popupUnarchive)
}

const archive = document.querySelectorAll('.js-archive') 
for(let g=0; g<archive.length;g++){
    archive[g].addEventListener('click',location.reload);
}


/*carrousel photo de l'animal*/

const id_animals = document.querySelectorAll('[id_animal]')
id=[]
for(let i=0; i<id_animals.length;i++){
    temp = id_animals[i].getAttribute('id_animal')
    if(id.find((element) => element == temp) == undefined) id.push(temp)
    }

    for(let j=0; j<id.length;j++){
        // initialisation des variables
        temp = "[id_animal=\'"+id[j]+"\']"
        const id_animal = document.querySelector(temp)
        const slides = id_animal.querySelectorAll(".js-slideAnimal");
        const buttonPrev = id_animal.querySelector(".js-carousel__prev")
        const buttonNext = id_animal.querySelector(".js-carousel__next")
        let slideIndex = 1;
        const durationSlide = 4_000
        let resetIntervalSlide = null

        if(buttonPrev != null){
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
        }
        /*FIN PARTIE CAROUSSEL*/ 
}


