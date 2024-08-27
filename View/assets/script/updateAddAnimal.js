/*update animal*/

//affichage des races suivant une saisie

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

function searchBreed(input, ul, newBreed, messageResult){
    nbMax = 20;
    for(let i=0; i<input.length;i++){
        input[i].addEventListener('input',() => {
            
            const filter = input[i].value.toUpperCase();
            const li = ul[i].getElementsByTagName('li');
            if(filter != ""){
                for(let k=0; k<li.length;k++){
                    li[k].classList.remove('none');
                }
            }
            if(nbResult(filter,li) <= nbMax){
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
                messageResult[i].classList.add('none');
            }
            else{
                if(filter != ""){
                    messageResult[i].classList.remove('none');
                }
                else{
                    messageResult[i].classList.add('none');
                } 
            }
            if(filter == "" || nbResult(filter,li)>nbMax){
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
}

// Declare variables
const inputUpdate = document.querySelectorAll('.updateBreed');
const ulUpdate = document.querySelectorAll('.breeds');
const newBreedUpdate = document.querySelectorAll('.newBreed');
const messageResultUpdate = document.querySelectorAll('.messageResult');

if(inputUpdate != null) searchBreed(inputUpdate, ulUpdate, newBreedUpdate, messageResultUpdate)

const inputAdd = document.querySelectorAll('#newAnimalBreed');
const ulAdd = document.querySelectorAll('.breedsAdd');
const newBreedAdd = document.querySelectorAll('.newBreedAdd');
const messageResultAdd = document.querySelectorAll('.messageResultNew');
if(inputAdd != null) searchBreed(inputAdd, ulAdd, newBreedAdd, messageResultAdd)


    let newBreed = document.getElementById('newBreed')
    if(newBreed != null)
    newBreed.addEventListener('input',()=>{
        if(verifAnimalNameRegex(newBreed.value) || newBreed.value==''){
            newBreed.style = 'outline : 1px solid black'
        }
        else{
            newBreed.style = 'outline : 1px solid red'
            newBreed.value = cancelLastCharacter(newBreed.value)
        }
    })

    let newAnimalName = document.getElementById('newAnimalName')
    if(newAnimalName != null)
    newAnimalName.addEventListener('input',()=>{
        if(verifAnimalNameRegex(newAnimalName.value) || newAnimalName.value==''){
            newAnimalName.style = 'outline : 1px solid black'
        }
        else{
            newAnimalName.style = 'outline : 1px solid red'
            newAnimalName.value = cancelLastCharacter(newAnimalName.value)
        }
    })

    let NAPDescription = document.getElementById('NAP-Description')
    if(NAPDescription != null)
    NAPDescription.addEventListener('input',()=>{
        if(verifDescriptionRegex(NAPDescription.value) || NAPDescription.value==''){
            NAPDescription.style = 'outline : 1px solid black'
        }
        else{
            NAPDescription.style = 'outline : 1px solid red'
            NAPDescription.value = cancelLastCharacter(NAPDescription.value)
        }
    })

    let newAnimalBreed = document.getElementById('NAP-Description')
    if(newAnimalBreed != null)
    newAnimalBreed.addEventListener('input',()=>{
        if(verifAnimalNameRegex(newAnimalBreed.value) || newAnimalBreed.value==''){
            newAnimalBreed.style = 'outline : 1px solid black'
        }
        else{
            newAnimalBreed.style = 'outline : 1px solid red'
            newAnimalBreed.value = cancelLastCharacter(newAnimalBreed.value)
        }
    })

    let newBreedUpd = document.querySelectorAll('.js-newBreed')
    if(newBreedUpd != null)
        for(let i=0; i<newBreedUpd.length; i++)
    {
        newBreedUpd[i].addEventListener('input',()=>{
            if(verifAnimalNameRegex(newBreedUpd[i].value) || newBreedUpd[i].value==''){
                newBreedUpd[i].style = 'outline : 1px solid black'
            }
            else{
                newBreedUpd[i].style = 'outline : 1px solid red'
                newBreedUpd[i].value = cancelLastCharacter(newBreedUpd[i].value)
            }
        })
    }

    let updateAnimalName = document.querySelectorAll('.js-updateAnimalName')
    if(updateAnimalName != null)
        for(let i=0; i<updateAnimalName.length; i++)
    {
        updateAnimalName[i].addEventListener('input',()=>{
            if(verifAnimalNameRegex(updateAnimalName[i].value) || updateAnimalName[i].value==''){
                updateAnimalName[i].style = 'outline : 1px solid black'
            }
            else{
                updateAnimalName[i].style = 'outline : 1px solid red'
                updateAnimalName[i].value = cancelLastCharacter(updateAnimalName[i].value)
            }
        })
    }

    let UAPDescription = document.querySelectorAll('.js-UAPDescription')
    if(UAPDescription != null)
        for(let i=0; i<UAPDescription.length; i++)
    {
        UAPDescription[i].addEventListener('input',()=>{
            if(verifAnimalNameRegex(UAPDescription[i].value) || UAPDescription[i].value==''){
                UAPDescription[i].style = 'outline : 1px solid black'
            }
            else{
                UAPDescription[i].style = 'outline : 1px solid red'
                UAPDescription[i].value = cancelLastCharacter(UAPDescription[i].value)
            }
        })
    }