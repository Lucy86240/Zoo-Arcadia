
/**
 * Permet d'afficher les éléments d'une liste en fonction de la saisie d'un input
 * @param {*} input : barre de recherche
 * @param {*} ul  : liste des éléments
 * @param {*} messageResult : message s'affichant si trop de résultat
 * @param {*} max : nombre max d'éléments pouvant être affiché (si trop affiche le messageResult)
 * @param {*} checkedAlways : booléen true = les checkbox cochées sont toujours affichées
 * @param {*} checkedNever : booléen true = les checkbox cochées ne sont jamais affichées
 */
function search(input, ul, messageResult,max,checkedAlways,checkedNever){
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

    function find(input, li){
        const filter = input.value.toUpperCase();
        if(filter != ""){
            for(let k=0; k<li.length;k++){
                li[k].classList.remove('none');
            }
        }
        if(nbResult(filter,li) <= max){

            for (let j = 0; j < li.length; j++) {
                const label = li[j].getElementsByTagName("label")[0];
                const txtValue = label.textContent || label.innerText;
                const checkbox = li[j].getElementsByTagName("input")[0];
                //on vérifie la correspondance entre les boutons radios et la saisie
                if (txtValue.toUpperCase().indexOf(filter) > -1 && !(checkedNever && checkbox.checked==true)) {
                    li[j].classList.remove('none');
                } else {
                    if(checkbox.checked==false || checkedAlways == false)
                        li[j].classList.add('none');
                }
            }
            messageResult.classList.add('none');
        }
        else{
            if(filter != ""){
                messageResult.classList.remove('none');
            }
            else{
                messageResult.classList.add('none');
            } 
        }
        if(filter == "" || nbResult(filter,li)>max){
            console.log('i')
            for(let k=0; k<li.length;k++){
                const checkbox = li[k].getElementsByTagName("input")[0];
                if(checkbox.checked==false || checkedAlways==false || (checkedNever && checkbox.checked==true))
                    li[k].classList.add('none')
            }
        }
    }

    const li = ul.getElementsByTagName('li');

    if(checkedAlways == true){
        for(let i=0;i<li.length;i++){
            const checkbox = li[i].getElementsByTagName("input")[0];
            checkbox.addEventListener('click',() => {
                if(checkbox.checked == false)
                    find(input,li);
            })
        }
    }

    if(checkedNever == true){
        for(let i=0;i<li.length;i++){
            const checkbox = li[i].getElementsByTagName("input")[0];
            checkbox.addEventListener('click',() => {
                if(checkbox.checked == true)
                    find(input,li);
            })
        }
    }

    input.addEventListener('input',() => {     
        find(input, li);  
    })
}

/**
 * Au clic sur un checkbox (1) disparait de la liste et apparait dans une autre liste (2)
 * @param {*} checkboxSelectedInput : checkbox (2)
 * @param {*} checkboxSelectedLi : li des checkbox (2)
 * @param {*} checkboxSearchInput : checkbox (1)
 * @param {*} allText : texte indiquant que tout est sélectionné
 */
function passListSearchOfListSelected(checkboxSelectedInput,checkboxSelectedLi,checkboxSearchInput,allText){
    function selected(){
        select = 0;
        for(let i=0; i<checkboxSearchInput.length;i++){
            if(checkboxSearchInput[i].checked == true) select++;
        }
        return select;
    }
    nbSelected=0;
    if(selected()==0) allBreed.classList.remove('none')
    for(let i=0; i<checkboxSearchInput.length;i++){
        checkboxSearchInput[i].addEventListener('click', ()=>{
            if(checkboxSearchInput[i].checked == true){
                nbSelected++;
                checkboxSelectedInput[i].checked = true;
                checkboxSelectedLi[i].classList.remove('none');
                if(nbSelected>0) allText.classList.add('none');
                else allText.classList.remove('none');
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
                else allText.classList.remove('none');
            } 
        })
    }
}