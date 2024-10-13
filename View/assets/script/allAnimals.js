/*Page animaux*/

/* mise en évidence de l'animal survolé */
const animals = document.querySelectorAll('.animal')

for(let i=0;i<animals.length;i++){
    animals[i].addEventListener('mouseover',()=>{
        //on diminu l'animal non survolé et on l'éclaireci
        for(let j=0;j<animals.length;j++){
            if(i!=j) animals[j].style = 'filter: brightness(50%);; -webkit-transform: scale(0.8);transform: scale(0.8);'
        }
    })
    //on reviens à la normale
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
const max=20;
function existInLabels(nameBreed,labels){
    if(labels!=null){
        for(let i=0; i<labels.length;i++){
            if(labels[i].innerHTML==nameBreed)
                return true
        }
    }
    return false;
}
function manageSelected(selected){
    if(selected!=null){
        inputs = selected.querySelectorAll('input')
        if(inputs!=null){
            for(let b=0; b<inputs.length;b++){
                inputs[b].addEventListener('click',()=>{

                })
            }
        }
    }
}
function listBreedsSelected(){
    const sBreed = document.getElementById('listBreedsSelected')
    let breeds = []
    if(sBreed!=null)
    {
        const labels = sBreed.querySelectorAll('label')
        if(labels!=null){
            for(let c=0; c<labels.length;c++){
                breeds.push(labels[c].innerHTML)
            }
        }
    }
    return breeds;
}

let selected = document.getElementById('listBreedsSelected')
function manageCheckboxs(checkboxs, lis){
    for(let i=0; i<checkboxs.length;i++){
        checkboxs[i].addEventListener('click',()=>{
            if(checkboxs[i].checked){
                labelsSelected = selected.querySelectorAll('label')
                if(!existInLabels(checkboxs[i].getAttribute('label'),labelsSelected))
                    selected.append(lis[i])
            }
            else{
                let selectTemp = document.createElement('ul')
                selectTemp.setAttribute('id','listBreedsSelected')
                selectTemp.classList.add("breeds")
                if(selected!=null){
                    const lis = selected.querySelectorAll('.form-check')
                    if(lis!=null){
                        for(let j=0; j<lis.length;j++){
                            if(lis[j].getAttribute('id').substring(3)!=checkboxs[i].getAttribute('label')){
                                lis[j].checked=true
                                selectTemp.append(lis[j])
                            }
                        }
                    }
                }
                selected.innerHTML = selectTemp.innerHTML
                inputsNewSelect = selected.querySelectorAll('input')
                if(inputsNewSelect!=null)
                    for(let a=0; a<inputsNewSelect.length;a++){
                        inputsNewSelect[a].checked=true
                    }
                manageSelected(selected)
            }
        })
    }
}

if(input!=null){
    input.addEventListener('keyup',()=>{
        breeds = listBreedsSelected()
        if (input.value.length == 0) {
            ul.innerHTML = "";
            return;
        } 
        else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                ul.innerHTML = this.responseText;
                checkboxs = ul.querySelectorAll('.js-checkboxBreedsSearch')
                lis = ul.querySelectorAll('.form-check')
                if(checkboxs!=null)
                    manageCheckboxs(checkboxs,lis)
            }
            };
            xmlhttp.open("GET", "../../../Controller/ajaxSearchBreeds.php?value=" + input.value+"&max="+max+"&breeds="+breeds, true);
            xmlhttp.send();
        }
    })
}


const checkboxSelectedInput = document.querySelectorAll(".js-checkboxBreedsSelected");
const checkboxSelectedLi = document.querySelectorAll(".js-liBreedsSelected");
const checkboxSearchInput = document.querySelectorAll(".js-checkboxBreedsSearch");
const allBreed = document.getElementById('breedsSelectedAll');
passListSearchOfListSelected(checkboxSelectedInput,checkboxSelectedLi,checkboxSearchInput,allBreed);

//on valide automatique le formulaire lors du clique sur un animal
$('.animalButton').on('click', function() {
    $(this).closest(".animals").submit();
})