//affiche la légende de l'icone au survol

icons = document.querySelectorAll(".js-icon");
legends = document.querySelectorAll(".js-legend");

margin0 = 'width : 90px; margin-left:'+0*40+'px';
margin1 = 'width : 80px; margin-left:'+1*40+'px';
margin2 = 'width : 50px; margin-left:'+2*40+'px';

for(let j=0; j<(icons.length/3);j++){
    for(let i=0; i<3;i++){
        icons[i+j*3].addEventListener("mouseover",()=>{
            legends[i+j*3].classList.remove('none');
            if((i+1)%3==0) legends[i+j*3].style = margin2;
            else if((i+1)%2==0) legends[i+j*3].style = margin1;
            else legends[i+j*3].style = margin0;
        })
        icons[i+j*3].addEventListener("mouseout",()=>{
            legends[i+j*3].classList.add('none');
        })
    }
}

//popup pour bloquer
const blocAccount = document.querySelectorAll('.js-bloc');
for(let i=0; i<blocAccount.length;i++){
    blocAccount[i].addEventListener('click',()=>{
        titleContent = "Bloquer un compte";
        blocAccountMail = blocAccount[i].getAttribute("mail");
        blocAccountMail=blocAccountMail.replace('.','')
        parContent = "Etes vous sûr de vouloir bloquer le compte : "+blocAccount[i].getAttribute("mail")+" ? L'utilisateur ne pourra plus se connecter.";
        submitContent = "Bloc-"+blocAccountMail;
        createConfirm(titleContent,parContent,submitContent);
    })
}

//popup de suppression
const deleteAccount = document.querySelectorAll('.js-delete');
for(let i=0; i<deleteAccount.length;i++){
    deleteAccount[i].addEventListener('click',()=>{
        titleContent = "Supprimer un compte";
        deleteAccountMail = deleteAccount[i].getAttribute("mail");
        parContent = "Etes vous sûr de vouloir supprimer le compte : "+deleteAccountMail+" ? L'utilisateur ne pourra plus se connecter et toutes les données lui étant affectées seront supprimées (repas, rapports médicaux...).";
        deleteAccountMail=deleteAccountMail.replace('.','')
        submitContent = "Delete"+deleteAccountMail;
        createConfirm(titleContent,parContent,submitContent);
    })
}

const unblocAccount = document.querySelectorAll('.js-unbloc');
const editAccount = document.querySelectorAll('.js-edit')



//filtrage des comptes
const rolesCheckbox = document.querySelectorAll('.roleCheckbox');
let rolesChecked = []
for(let j=0; j<rolesCheckbox.length;j++){
    rolesChecked.push(rolesCheckbox[j].getAttribute('value'));
}

let searchMail = document.querySelector('#mailSearch');

const accounts = document.querySelectorAll('.js-account');

function displayAccountRole(){
    for(let i=0; i<accounts.length;i++){
        accounts[i].classList.remove('none')
        role = accounts[i].querySelector('.js-role');
        const txtValue = role.textContent || role.innerText;
        check = false;
        let j=0;
        while(j<rolesChecked.length && !check){
            if(txtValue == rolesChecked[j]) check = true;
            j++
        }
        if(!check) accounts[i].classList.add('none')
    }
}

for(let i=0; i<rolesCheckbox.length;i++){
    rolesCheckbox[i].addEventListener('click',()=>{
        if(rolesCheckbox[i].checked == true){
            //on ajoute la checkbox au tableau
            if(rolesChecked.includes(rolesCheckbox[i].getAttribute('value'))==false){
                rolesChecked.push(rolesCheckbox[i].getAttribute('value'))
            }
        }
        else{
            //on regarde si le role est dans le tableau si oui on l'enlève
            if(rolesChecked.includes(rolesCheckbox[i].getAttribute('value'))==true){
                rolesChecked.splice(rolesChecked.indexOf(rolesCheckbox[i].getAttribute('value')), 1)
            }
        }
        displayAccountRole()
        searchMail.value = "";
    })
}

function searchUsers(searchInput, list, element){
    const filter = searchInput.value.toUpperCase();
    displayAccountRole()
    for (let j = 0; j < list.length; j++) {
        const label = list[j].querySelector(element);
        const txtValue = label.textContent || label.innerText;
        //on vérifie la correspondance entre les boutons radios et la saisie
        if (txtValue.toUpperCase().indexOf(filter) <= -1) {
            if(list[j].classList.contains('none')==false) list[j].classList.add('none');
        }
    }
}

searchMail.addEventListener('input',() => {
    searchUsers(searchMail,accounts,'.js-mail')
})