
/**
 * 
 * @param {*} input 
 * @param {*} ul 
 * @param {*} messageResult 
 * @param {*} max 
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
