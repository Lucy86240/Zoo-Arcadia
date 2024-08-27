//affiche le détail d'un rapport
links = document.querySelectorAll('.reportLink');
reports = document.querySelectorAll('.reportView');
closes = document.querySelectorAll('.buttonCloseReport');

if(links != null){
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
}

//affiche la légende de l'icone au survol

icons = document.querySelectorAll(".js-icon");
legends = document.querySelectorAll(".js-legend");

for(let i=0; i<icons.length;i++){
    icons[i].addEventListener("mouseover",()=>{
        legends[i].classList.remove('none');
        legends[i].style='margin-left:'+i*40+'px';
    })
    icons[i].addEventListener("mouseout",()=>{
        legends[i].classList.add('none');
    })
}

//affiche le popup d'un nouveau rapport / nourrir

let dialogNR = document.getElementById('dialogNewReport');
if(dialogNR != null){
    const triggerNR = document.querySelector('#popupNewReport'); 
    const dismissTriggerNR = dialogNR.querySelector('#closeNewReport');
    popup(dialogNR,triggerNR,dismissTriggerNR)
} 
else{
    dialogNR = document.getElementById('dialogFed');
    const triggerNR = document.querySelector('#popupFed'); 
    const dismissTriggerNR = dialogNR.querySelector('#closeFed');
    popup(dialogNR,triggerNR,dismissTriggerNR)
}


//Nouveau rapport : affichage de la liste des animaux
    // Declare variables
    let searchAnimal = document.querySelector('#animalNewReport');
    if(searchAnimal == null) searchAnimal = document.querySelector('#animalFed');
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

let dateNewReport = document.getElementById('dateNewReport')
if(dateNewReport !=null){
    dateNewReport.addEventListener('blur',()=>{
        if(!verifDateRegex(dateNewReport.value)){
            dateNewReport.value = '';
        }
    })
}

let healthNewReport = document.getElementById('healthNewReport')
if(healthNewReport !=null){
    healthNewReport.addEventListener('input',()=>{
        if(!verifDescriptionRegex(healthNewReport.value)){
            healthNewReport.value = cancelLastCharacter(healthNewReport.value)
            healthNewReport.style = 'outline : 1px solid red'
        }
        else healthNewReport.style = 'outline : 1px solid grey'
    })
}

let commentNewReport = document.getElementById('commentNewReport')
if(commentNewReport !=null){
    commentNewReport.addEventListener('input',()=>{
        if(!verifDescriptionRegex(commentNewReport.value)){
            commentNewReport.value = cancelLastCharacter(commentNewReport.value)
            commentNewReport.style = 'outline : 1px solid red'
        }
        else commentNewReport.style = 'outline : 1px solid grey'
    })
}

let foodNewReport = document.getElementById('foodNewReport')
if(foodNewReport !=null){
    foodNewReport.addEventListener('input',()=>{
        if(!verifDescriptionRegex(foodNewReport.value)){
            foodNewReport.value = cancelLastCharacter(foodNewReport.value)
            foodNewReport.style = 'outline : 1px solid red'
        }
        else foodNewReport.style = 'outline : 1px solid grey'
    })
}

let weightFoodNewReport = document.getElementById('weightFoodNewReport')
if(weightFoodNewReport !=null){
    weightFoodNewReport.addEventListener('input',()=>{
        if(!verifDescriptionRegex(weightFoodNewReport.value)){
            weightFoodNewReport.value = cancelLastCharacter(weightFoodNewReport.value)
            weightFoodNewReport.style = 'outline : 1px solid red'
        }
        else weightFoodNewReport.style = 'outline : 1px solid grey'
    })
}

let dateFed = document.getElementById('dateFed')
if(dateFed !=null){
    dateFed.addEventListener('blur',()=>{
        if(!verifDateRegex(dateFed.value)){
            dateFed.value = '';
        }
    })
}

let foodFed = document.getElementById('foodFed')
if(foodFed !=null){
    foodFed.addEventListener('input',()=>{
        if(!verifDescriptionRegex(foodFed.value)){
            foodFed.value = cancelLastCharacter(foodFed.value)
            foodFed.style = 'outline : 1px solid red'
        }
        else foodFed.style = 'outline : 1px solid var(--brown)'
    })
}

let weightFed = document.getElementById('weightFed')
if(weightFed !=null){
    weightFed.addEventListener('input',()=>{
        if(!verifDescriptionRegex(weightFed.value)){
            weightFed.value = cancelLastCharacter(weightFed.value)
            weightFed.style = 'outline : 1px solid red'
        }
        else fooweightFeddFed.style = 'outline : 1px solid var(--brown)'
    })
}