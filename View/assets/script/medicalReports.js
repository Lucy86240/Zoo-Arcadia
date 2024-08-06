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

//affiche la légende de l'icone au survol

icons = document.querySelectorAll(".icon");
legends = document.querySelectorAll(".legend");

for(let i=0; i<icons.length;i++){
    icons[i].addEventListener("mouseover",()=>{
        legends[i].classList.remove('none');
        legends[i].style='margin-left:'+i*40+'px';
    })
    icons[i].addEventListener("mouseout",()=>{
        legends[i].classList.add('none');
    })
}

//affiche le popup d'un nouveau rapport

const dialogNR = document.getElementById('dialogNewReport');
const triggerNR = document.querySelector('#popupNewReport'); 
const dismissTriggerNR = dialogNR.querySelector('#closeNewReport');
//const dialogNr = document.querySelector("#newReport-JS");
popup(dialogNR,triggerNR,dismissTriggerNR)

//Nouveau rapport : affichage de la liste des animaux
    // Declare variables
    const searchAnimal = document.querySelector('#animalNewReport');
    const list = document.querySelector('#listAnimals');
    const msg = document.querySelector('#msgListAnimals');

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

searchAnimal.addEventListener('input',() => {
    const filter = searchAnimal.value.toUpperCase();
    const li = list.getElementsByTagName('li');
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
        msg.classList.add('none');
    }
    else{
        if(filter != ""){
            msg.classList.remove('none');
        }
        else{
            msg.classList.add('none');
        } 
    }
    if(filter == "" || nbResult(filter,li)>5){
        for(let k=0; k<li.length;k++){
            li[k].classList.add('none');
        }
    }
})