//affiche le détail d'un rapport
links = document.querySelectorAll('.reportLink');
reports = document.querySelectorAll('.reportView');
closes = document.querySelectorAll('.buttonCloseReport');

for(let i=0; i<links.length; i++){
    links[i].addEventListener('click', ()=>{
        for(let j=0; j<reports.length;j++){
            reports[j].classList.add('none');
        }
        reports[i].classList.remove('none');
    })
}

//ferme le détail d'un rapport
for(let i=0; i<closes.length;i++){
    closes[i].addEventListener('click',()=>{
        reports[i].classList.add('none');
    })
}

//ouvrir la fiche de l'animal
fiche = document.querySelector(".js-animal-popup")
icon = document.querySelector(".js-animal")
closeAnimal = document.querySelector('.buttonCloseAnimal');

icon.addEventListener('click', () => {
    fiche.classList.remove("none")
})
closeAnimal.addEventListener('click',()=>{
    fiche.classList.add('none');
})