/* popup */
// suppression habitat
const deleteIconHousing = document.querySelectorAll(".deleteIconHousing");
for(let k=0;k<deleteIconHousing.length;k++){
    deleteIconHousing[k].addEventListener('click',()=>{
        
        id=deleteIconHousing[k].getAttribute('id_housing')
        nameHousing=deleteIconHousing[k].getAttribute('name_housing')
        nbAnimal=deleteIconHousing[k].getAttribute('nb_animal')
        submitContent = 'ValidationDeleteHousing'+id
        titleContent = 'Suppression'
        parContent = "Etes vous sûr de vouloir supprimer l'habitat : \""+nameHousing+"\" ? Cela supprimera également les "+nbAnimal+" animaux qui y sont présents."
        createConfirm(titleContent,parContent,submitContent)
    })
}

/*carrousel photos d'un habitant*/
count=0;
housingExist = false
do {
    const elementPhoto = ".js-slideHousing"+count;
    const elementRound = ".round"+count;
    const slidesPhotos = document.querySelectorAll(elementPhoto);
    if(slidesPhotos.length > 0){
        housingExist = true;
        const rounds = document.querySelectorAll(elementRound);
        for(let i=0;i<rounds.length;i++){
            rounds[i].addEventListener('click',()=>{
                for(let j=0;j<rounds.length;j++){
                    slidesPhotos[j].classList.add("none"); 
                    rounds[j].classList.remove("round-selected");
                }
                slidesPhotos[i].classList.remove('none');
                rounds[i].classList.add("round-selected");                
            })
        }
    count++;
    }
    else{
        housingExist = false;
    }
    
} while (housingExist==true);

//recherche d'un animal suivant la saisie

    // Declare variables
    const inputSearch = document.querySelectorAll('.searchAnimal');
    const ulSearch = document.querySelectorAll('.animalList');
    const messageNoResult = document.querySelectorAll('.messageNoResult');

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

for(let i=0; i<inputSearch.length;i++){
    inputSearch[i].addEventListener('input',() => {
        messageNoResult[i].innerHTML='';
        const filter = inputSearch[i].value.toUpperCase();
        const liSearch = ulSearch[i].getElementsByTagName('li');
            for (let j = 0; j < liSearch.length; j++) {
                const label = liSearch[j].getElementsByTagName("label")[0];
                const txtValue = label.textContent || label.innerText;
                //on vérifie la correspondance entre les boutons radios et la saisie
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    liSearch[j].classList.remove('none');
                } else {
                    liSearch[j].classList.add('none');
                }
            }
        if(nbResult(filter,liSearch)==0){
            messageNoResult[i].classList.remove('none');
            title=document.createElement('span')
            title.textContent = 'Oups'
            messageNoResult[i].append(title)
            img=document.createElement('img')
            img.src="View/assets/img/general/error.png"
            messageNoResult[i].append(img)
            msg=document.createElement('span')
            msg.textContent = 'L\'animal recherché n\'a pas été trouvé dans cet habitat'
            messageNoResult[i].append(msg)
        }
        else{
            messageNoResult[i].classList.add('none');
        }
    })
}


//on valide automatique lors du clique sur un animal
$('input[type=radio]').on('change', function() {
    $(this).closest("form").submit();
})