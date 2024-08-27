// Declare variables
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

const cancelFilter = document.getElementById('cancelFilter')
const vetoCheckbox = document.querySelectorAll('.js-vetocheckbox')
const dateStart = document.getElementById('dateStart')
const dateEnd = document.getElementById('dateEnd')

dateStart.addEventListener('blur',()=>{
    if(!verifDateRegex(dateStart.value)) dateStart.value = '';
})

dateEnd.addEventListener('blur',()=>{
    if(!verifDateRegex(dateEnd.value)) dateEnd.value = '';
})

cancelFilter.addEventListener('click',()=>{
    for(i=0;i<checkboxSearchInput.length;i++){
        checkboxSearchInput[i].checked = false;
        checkboxSelectedInput[i].checked = false;
        checkboxSelectedLi[i].classList.add('none');
    }
    for(i=0;i<vetoCheckbox.length;i++){
        vetoCheckbox.checked = true;
    }
    dateStart.value='';
    dateEnd.value='';
})

//supprimer les filtres
const form = document.querySelector('.filter')
const submit = form.querySelector('.btn-DarkGreen')

cancelFilter.addEventListener('click', ()=> {
    for(let m=0; m<checkboxSelectedInput.length; m++){
        checkboxSelectedInput[m].checked = false;
        checkboxSearchInput[m].checked = false;
        checkboxSelectedInput[m].classList.add('none');
    }
    for(let n=0; n<vetoCheckbox.length;n++){
        vetoCheckbox[n].checked=true;
    }
    dateStart.value='';
    dateEnd.value='';
});