/*Plusieurs pages : rapports_medicaux, repas*/

// Declare variables

//recherche d'une race
    const input = document.getElementById('filterBreedsSearch');
    const ul = document.getElementById('listBreeds');
    const messageResult = document.getElementById('msgBreedsSearch');
    const max=15;

search(input, ul, messageResult,max,false,true);

const checkboxSelectedInput = document.querySelectorAll(".js-checkboxBreedsSelected");
const checkboxSelectedLi = document.querySelectorAll(".js-liBreedsSelected");
const checkboxSearchInput = document.querySelectorAll(".js-checkboxBreedsSearch");
const allBreed = document.getElementById('breedsSelectedAll');
passListSearchOfListSelected(checkboxSelectedInput,checkboxSelectedLi,checkboxSearchInput,allBreed);

//vérification saisie des dates

const dateStart = document.getElementById('dateStart')
const dateEnd = document.getElementById('dateEnd')

dateStart.addEventListener('blur',()=>{
    if(!verifDateRegex(dateStart.value)) dateStart.value = '';
})

dateEnd.addEventListener('blur',()=>{
    if(!verifDateRegex(dateEnd.value)) dateEnd.value = '';
})

//supprimer les filtres
const cancelFilter = document.getElementById('cancelFilter')
const vetoCheckbox = document.querySelectorAll('.js-vetocheckbox')

cancelFilter.addEventListener('click', ()=> {
    //on réinitialise les races
    for(let m=0; m<checkboxSelectedInput.length; m++){
        checkboxSelectedInput[m].checked = false;
        checkboxSearchInput[m].checked = false;
        checkboxSelectedInput[m].classList.add('none');
    }
    //on réinitialise les vétérinaires
    for(let n=0; n<vetoCheckbox.length;n++){
        vetoCheckbox[n].checked=true;
    }
    //on réinitiale les dates
    dateStart.value='';
    dateEnd.value='';
});