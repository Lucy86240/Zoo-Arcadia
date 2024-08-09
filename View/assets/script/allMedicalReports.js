function passListSearchOfListSelected(checkboxSelectedInput,checkboxSelectedLi,checkboxSearchInput,allText){
    nbSelected=0;
    for(let i=0; i<checkboxSearchInput.length;i++){
        checkboxSearchInput[i].addEventListener('click', ()=>{
            if(checkboxSearchInput[i].checked == true){
                nbSelected++;
                checkboxSelectedInput[i].checked = true;
                checkboxSelectedLi[i].classList.remove('none');
                if(nbSelected>0) allText.classList.add('none');
                else allText.classList.add('none');
            } 

        })
    }
    
    for(let i=0; i<checkboxSelectedInput.length;i++){
        checkboxSelectedInput[i].addEventListener('click', ()=>{
            if(checkboxSelectedInput[i].checked == false){
                nbSelected--;
                checkboxSearchInput[i].checked = false;
                checkboxSelectedLi[i].classList.add('none');
                if(nbSelected>0) allText.classList.add('none');
                else allText.classList.add('none');
            } 
        })
    }
}

// Declare variables
    const input = document.getElementById('filterBreedsSearch');
    const ul = document.getElementById('listBreeds');
    const messageResult = document.getElementById('msgBreedsSearch');
    const max=10;

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