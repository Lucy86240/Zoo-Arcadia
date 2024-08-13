
/* mise en évidence de l'animal survolé */
const animals = document.querySelectorAll('.animal')

for(let i=0;i<animals.length;i++){
    animals[i].addEventListener('mouseover',()=>{
        for(let j=0;j<animals.length;j++){
            if(i!=j) animals[j].style = 'filter: brightness(50%);; -webkit-transform: scale(0.8);transform: scale(0.8);'
        }
    })
    animals[i].addEventListener('mouseout',()=>{
        for(j=0;j<animals.length;j++){
            animals[j].style = 'opacity:1;'
        }
    })
}

/*recherche de races*/
// Declare variables
const input = document.getElementById('filterBreedsSearch');
const ul = document.getElementById('listBreeds');
const messageResult = document.getElementById('msgBreedsSearch');
const max=20;

search(input, ul, messageResult,max,false,true);

const checkboxSelectedInput = document.querySelectorAll(".js-checkboxBreedsSelected");
const checkboxSelectedLi = document.querySelectorAll(".js-liBreedsSelected");
const checkboxSearchInput = document.querySelectorAll(".js-checkboxBreedsSearch");
const allBreed = document.getElementById('breedsSelectedAll');
passListSearchOfListSelected(checkboxSelectedInput,checkboxSelectedLi,checkboxSearchInput,allBreed);

//on valide automatique lors du clique sur un animal
$('.animalButton').on('click', function() {
    $(this).closest(".animals").submit();
})