    // Declare variables
    const input = document.getElementById('filterBreedSearch');
    const ul = document.getElementById('listBreed');
    const messageResult = document.getElementById('msgBreedSearch');
    const max=10;

search(input, ul, messageResult,max,false,true)

function passListSearchOfListSelected(checkboxSelectedInput,checkboxSelectedLi,checkboxSearchInput,allText){
    function allSelected(checkboxSelectedLi,allText){
        selected = false;
        let i=0;
        while(i<checkboxSelectedLi.length || selected == false){
            if(checkboxSelectedLi[i].classList.contains('none') == false) selected=true;
            i++;
        }
        if(selected) allText.classList.add('none')
        else allText.classList.remove('none')
    }
    nbSelected=0;

    for(let i=0; i<checkboxSearchInput.length;i++){
        checkboxSearchInput[i].addEventListener('click', ()=>{
            if(checkboxSearchInput[i].checked == true){
                nbSelected++;
                checkboxSelectedInput[i].checked = true;
                checkboxSelectedLi[i].classList.remove('none');
                if(nbSelected>0) allText.classList.add('none')
                else allText.classList.remove('none')
            } 

        })
    }
    
    for(let i=0; i<checkboxSelectedInput.length;i++){
        checkboxSelectedInput[i].addEventListener('click', ()=>{
            if(checkboxSelectedInput[i].checked == false){
                nbSelected--;
                checkboxSearchInput[i].checked = false;
                checkboxSelectedLi[i].classList.add('none');
                if(nbSelected>0) allText.classList.add('none')
                else allText.classList.remove('none')
            } 
        })
    }
}


const checkboxSelectedInput = document.querySelectorAll(".js-checkboxBreedSelected");
const checkboxSelectedLi = document.querySelectorAll(".js-liBreedsSelected");
const checkboxSearchInput = document.querySelectorAll(".js-checkboxBreedSearch");
const allBreed = document.getElementById('breedSelectedAll')
passListSearchOfListSelected(checkboxSelectedInput,checkboxSelectedLi,checkboxSearchInput,allBreed)






    // Declare variables
    const inputA = document.getElementById('filterAnimalSearch');
    const ulA = document.getElementById('listAnimal');
    const messageResultA = document.getElementById('msgAnimalSearch');
    const maxA=10;
    
search(inputA, ulA, messageResultA,maxA,true,false)

