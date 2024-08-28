/*Section habitat / animaux*/

// on récupère les infos des animaux
const housings = document.querySelectorAll(".home-housing-container")
imgSrc = [];
imgAlt = [];
nameAnimal = [];
nbAnimalPerHousing=[]
for(let i=0; i<housings.length;i++){
    imgAnimalHousingDesktop = housings[i].querySelectorAll(".js-homeAnimal")
    nbAnimalPerHousing.push(imgAnimalHousingDesktop.length)
    for(let j=0; j<imgAnimalHousingDesktop.length; j++){
        img=imgAnimalHousingDesktop[j].querySelector('img');
        imgSrc.push(img.getAttribute('src'));
        imgAlt.push(img.alt);
        nameA = imgAnimalHousingDesktop[j].querySelector('span');
        nameAnimal.push(nameA.innerHTML)
    }
}
const animalsMobile = document.querySelector('.animals-mobile')
function versionMobileHousing(){
    //on efface la partie des animaux des habitats
    for(let j=0; j<housings.length; j++){
        let imgAnimalHousingDesktop = housings[j].querySelectorAll(".js-homeAnimal")
        for(let i=0; i<imgAnimalHousingDesktop.length ;i++){
            for(let k=0; k<imgAnimalHousingDesktop[i].children.length; k++)
            imgAnimalHousingDesktop[i].innerHTML='';
        }
    }
    //on crée la partie animaux mobile
    h2 = document.createElement('h2')
    h2.innerHTML = "Plus de 1200 animaux à découvrir";
    animalsMobile.append(h2);

    for(let k=0; k<imgSrc.length;k++){
        div = document.createElement('div')
        div.classList.add('animal-mobile')
        div.classList.add('js-slideAnimal')

        h3 = document.createElement('h3')
        h3.innerHTML = nameAnimal[k]
        div.append(h3)

        img = document.createElement('img')
        img.classList.add('img-animal-mobile')
        img.setAttribute("src",imgSrc[k])
        img.setAttribute("alt",imgAlt[k])
        div.append(img)

        animalsMobile.append(div)
    }

    divParent = document.createElement('div')
    divParent.classList.add('rounds')
    divParent.classList.add('rounds-beige')

    for(let k=0 ;k<imgSrc.length;k++){
        div = document.createElement('div')
        div.classList.add("round")
        div.innerHTML = ' ';
        divParent.append(div)
    }
    animalsMobile.append(divParent)

    div = document.createElement('div')
    div.classList.add('button')

    a = document.createElement('a')
    a.setAttribute("href","animaux");
    button = document.createElement('button')
    button.setAttribute('type','button')
    button.classList.add('btn')
    button.classList.add('btn-DarkGreen')
    button.innerHTML = 'En voir plus...'
    a.append(button)
    div.append(a)
    animalsMobile.append(div)

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
}
    
function versionDesktopHousing(){
    //on enlève la partie animaux mobile
    animalsMobile.innerHTML ='';
    
    //on remet la partie animaux dans les habitats
    let imgAnimalHousingDesktop = document.querySelectorAll(".js-homeAnimal")
    for(let i=0; i<imgAnimalHousingDesktop.length; i++){
        imgAnimalHousingDesktop[i].innerHTML = ""
        img = document.createElement('img')
        img.classList.add('home-animal-img')
        img.classList.add('rounded-circle')
        img.setAttribute("src",imgSrc[i])
        img.setAttribute("alt",imgAlt[i])
        imgAnimalHousingDesktop[i].append(img)

        div = document.createElement('div')
        div.classList.add('none')
        span = document.createElement('span')
        span.classList.add('text-center')
        span.classList.add('home-animal-title')
        span.innerHTML = nameAnimal[i]
        div.append(span)
        imgAnimalHousingDesktop[i].append(div)
    }

    for(let j=0; j<housings.length;j++){
        let imgAnimalHousingDesktop = housings[j].querySelectorAll(".js-homeAnimal")
        if(imgAnimalHousingDesktop.length != null){
            for(let k=0; k<imgAnimalHousingDesktop.length;k++){
                img = imgAnimalHousingDesktop[k].querySelector('img')
                nameClass = "home-housing-animal"+(k+1)
                img.classList.add(nameClass)
                div = imgAnimalHousingDesktop[k].querySelector('div')
                nameClass = "home-title-animal"+(k+1)+"-position"
                div.classList.add(nameClass)
            }
        }
    }
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
}

if(window.innerWidth < 576){
    versionMobileHousing()
    mobile = true;
}
else if(window.innerWidth > 576){
    versionDesktopHousing()
    mobile = false;
}
window.addEventListener('resize',()=>{
    if(window.innerWidth < 576 && mobile==false){
        versionMobileHousing()
        mobile = true;
    }
    else if(window.innerWidth > 576 && mobile==true){
        versionDesktopHousing()
        mobile = false;
    }
})


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
    timer = setInterval( () => {
        slideIndex +=nbSlideViewHousing;
        slideIndex=showSlides(slides,slideIndex,nbSlide);
    },durationSlide)

    return timer;

}

function stopCarrouselHousing(){
    for(i=0; i<slidesHousing.length;i++){
        slidesHousing[i].classList.remove('none');
    }
}

let actif = false;
if(slidesHousing.length > nbSlideViewHousing && window.innerWidth > 576){
    slideIndex=showSlides(slidesHousing,slideIndex,nbSlideViewHousing);
    timer = changeSlideAuto(slideIndex,slidesHousing,nbSlideViewHousing);
    actif = true
}

window.addEventListener("resize", ()=>{
    if(actif==false && slidesHousing.length > nbSlideViewHousing && window.innerWidth > 576){       
        slideIndex=showSlides(slidesHousing,slideIndex,nbSlideViewHousing);
        timer = changeSlideAuto(slideIndex,slidesHousing,nbSlideViewHousing);
        actif = true
    }
    else{
        if(actif==true && window.innerWidth < 576){
            clearInterval(timer);
            stopCarrouselHousing();
            actif = false
        }
    }
});


