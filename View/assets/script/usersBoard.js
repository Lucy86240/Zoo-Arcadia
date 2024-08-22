//filtrage des comptes
const rolesCheckbox = document.querySelectorAll('.roleCheckbox');
let rolesChecked = []
for(let j=0; j<rolesCheckbox.length;j++){
    rolesChecked.push(rolesCheckbox[j].getAttribute('value'));
}

let allRoles = []
for(let j=0; j<rolesCheckbox.length;j++){
    allRoles.push(rolesCheckbox[j].getAttribute('value'));
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


//fonctions pour créer / modifier un compte

const iconsUpdate = document.querySelectorAll('.js-edit')

/**
 * Créé une div element d'un formulaire
 * @param {*} id : id qu'aura l'input
 * @param {*} textLabel : le texte du label
 * @param {*} type : le type de 'linpu
 * @param {*} placeholder : le placeholder ('' si aucun)
 * @param {*} displayNone : true s'il faut inclure la classe 'none'
 * @param {*} required : true si l'input est obligatoire
 * @returns 
 */
function createDivElement(id, textLabel, type, placeholder,displayNone,required){
    divElement = document.createElement('div')
    divElement.classList.add('element')
    label = document.createElement('label')
    label.setAttribute('for',id)
    label.textContent = textLabel
    divElement.append(label)

    input = document.createElement('input')
    input.setAttribute('type',type)
    input.setAttribute('name',id)
    input.setAttribute('id',id)
    if(required) input.setAttribute('required','')
    if(placeholder!='') input.setAttribute('placeholder',placeholder)
    if(displayNone) divElement.classList.add('none')
    divElement.append(input)

    return divElement;
}

/**
 * crée un paragraphe pour la légende du mot de passe
 * @param {} text 
 * @param {*} id 
 * @returns 
 */
function textPassword(text,id){
    legPassword = document.createElement('p')
    legPassword.setAttribute('id',id)
    legPassword.textContent = text
    legPassword.style = "color : var(--brown);"
    return legPassword
}
/**
 * Créer le popup de création ou modification d'utilisateur
 * @param {*} mail : mail de l'utilisteur en cas de modification / '' pour création
 * @param {*} myAccount : true s'il s'agit de la modification du compte utilisateur de la personne connectée 

 */
function createPopupAccount(mail, myAccount){
    let divConfirm = document.getElementById("js-confirm");
    divTemp = document.createElement('div')

    divTemp.classList.add('c-dialog')
    
    //on met en place le fond
    divFond = document.createElement('div')
    divFond.classList.add('fond')
    divTemp.append(divFond)

    //on met en place le popup
    divDialogBox = document.createElement('div')
    divDialogBox.classList.add('c-dialog__box')
    divDialogBox.classList.add('themeBeige')
    divDialogBox.classList.add('popup')

    if(mail != ''){ 
        id='updateAccount';
        temp = mail
        mailSubmit=mail.replace('.','');
        while(mailSubmit != temp){
            temp = mailSubmit
            mailSubmit = mailSubmit.replace('.','')
        }
    }
    else id='createAccount'
    divDialogBox.setAttribute('id',id)

    //entete du popup
    divEntete = document.createElement('div')
    divEntete.classList.add('Entete')

    h3 = document.createElement('h3')
    h3.classList.add('dialog-title')
    if(mail != ''){
        if(!myAccount) h3.textContent = "Modifier un compte"
        else h3.textContent = "Modifier mon compte"
    }
    else h3.textContent = "Créer un compte"
    divEntete.append(h3)
    divDialogBox.append(divEntete)

    //formulaire
    form = document.createElement('form')
    form.setAttribute('action','')
    form.setAttribute('method','POST')

    // élément du formulaire

    //introduction
    intro = document.createElement('p')
    if(mail != '') intro.textContent = "Vous pouvez modifier le/les éléments souhaités :"
    else intro.textContent = "Merci de renseigner tous les éléments :"
    intro.style ="font-weight : bold; margin : 0 auto 10px auto !important;"
    form.append(intro)

    //nom
    if(mail != ''){
        id='updateAccountFirstname-'+mailSubmit;
        if(!myAccount){
            nameplaceholder = document.querySelector('.js-firstname[mail=\"'+mail+'\"]')
            placeholder = 'Actuellement : '+nameplaceholder.textContent
        }
        else{
            placeholder = document.getElementById('updateMyAccount').getAttribute('firstName')
        } 

        required = false
    }
    else{
        id='newAccountFistname'
        placeholder = ''
        required = true
    }
    textLabel = "Prénom :";
    type = 'text';
    firstName = document.querySelectorAll('.js-firstname')
    form.append(createDivElement(id,textLabel,type,placeholder,false,required))

    //prénom
    if(mail != ''){
        id='updateAccountLastname-'+mailSubmit;
        if(!myAccount){
            nameplaceholder = '.js-lastname[mail=\"'+mail+'\"]'
            placeholder = 'Actuellement : '+document.querySelector(nameplaceholder).textContent
        }
        else{
            placeholder = document.getElementById('updateMyAccount').getAttribute('lastName')
        }

        required = false
    } 
    else{
        id='newAccountLastname';
        placeholder = '';
        required = true
    } 
    textLabel = "Nom :";
    type = 'text';
    form.append(createDivElement(id,textLabel,type,placeholder,false,required))

    //role
    if(!myAccount){
        if(mail != '') id="updateAccountRole-"+mailSubmit
        else id="newAccountRole"
        
        divElement = document.createElement('div')
        divElement.classList.add('element')
        label = document.createElement('label')
        label.setAttribute('for',id)
        label.textContent = "Rôle :"
        divElement.append(label)
        select = document.createElement('select')
        select.setAttribute('name',id)
        select.setAttribute('id',id)
        
        if(mail != ''){
            option1 = document.createElement('option')
            nameplaceholder = '.js-role[mail=\"'+mail+'\"]'
            option1.textContent = document.querySelector(nameplaceholder).textContent
            option1.value = option1.textContent
            select.append(option1)
            for(let i=0; i < allRoles.length;i++){
                if(option1.textContent != allRoles[i] && allRoles[i]!='Administrateur.rice'){
                    option = document.createElement('option')
                    option.textContent = allRoles[i]
                    option.value = allRoles[i]
                    select.append(option)
                }
            }
        }
        else{
            for(let i=0; i < allRoles.length;i++){
                if(allRoles[i]!='Administrateur.rice'){
                    option = document.createElement('option')
                    option.textContent = allRoles[i]
                    option.value = allRoles[i]
                    select.append(option)
                }
            }
        }
        divElement.append(select)
        form.append(divElement)
    }

    mailDiv = document.createElement('div')
    mailDiv.style = "margin : 20px 0 20px 0;"

    if(mail != ''){
        id='updateAccountMail-'+mailSubmit;
        placeholder = 'Actuellement : '+mail
        required = false
    }
    else{
        id='newAccountMail';
        placeholder = ''
        required = true
    } 
    textLabel = "Mail :";
    type = 'email';
    mailDiv.append(createDivElement(id,textLabel,type,placeholder,false,required))

    legendMail = document.createElement('p')
    legendMail.textContent = "Pour information : Le mail ne doit pas être utilisé par un autre utilisateur."
    legendMail.classList.add('legendAccount')
    mailDiv.append(legendMail)

    if(mail !=''){
        id='updateAccountConfirmMail-'+mailSubmit;
        required = false
    }
    else{
        id='newAccountConfirmMail';
        required = true
    }

    textLabel = "Confirmation mail :";
    type = 'text';
    confirmMail = createDivElement(id,textLabel,type,'',true, required);
    confirmMail.setAttribute('id','confirmMailElement');
    mailDiv.append(confirmMail);

    form.append(mailDiv)

    if(mail != ''){
        id='updateAccountPassword-'+mailSubmit;
        textLabel = "Nouveau mot de passe :";
        required = false
    }
    else{
        id='newAccountPassword';
        textLabel = "Mot de passe :";
        required = true
    }

    type = 'password';
    divElement = document.createElement('div')
    divElement.classList.add('element')
    label = document.createElement('label')
    label.setAttribute('for',id)
    label.textContent = textLabel
    divElement.append(label)

    input = document.createElement('input')
    input.setAttribute('type',type)
    input.setAttribute('name',id)
    input.setAttribute('id',id)
    divElement.append(input)

    form.append(divElement)

    function textPassword(text,id){
        legPassword = document.createElement('p')
        legPassword.setAttribute('id',id)
        legPassword.textContent = text
        legPassword.style = "color : var(--brown);"
        return legPassword
    }
    legendPassword = document.createElement('div')
    legendPassword.classList.add('legendAccount')
    legendPassword.classList.add('none')
    legendPassword.setAttribute('id','legendPassword')
    legendPassword.append(textPassword("Votre mot de passe est valide s'il contient au moins : ",'legPassword'))
    legendPassword.append(textPassword("12 caractères",'caracPassword'))
    legendPassword.append(textPassword("un chiffre",'numPassword'))
    legendPassword.append(textPassword("une majuscule",'majPassword'))
    legendPassword.append(textPassword("une minuscule",'minPassword'))
    legendPassword.append(textPassword("deux caractères spéciaux parmi @ & ~ # $ * + : ; ? ! % ,",'spePassword'))
    form.append(legendPassword)

    if(mail !=''){
        id='updateAccountConfirmPassword-'+mailSubmit;
        required = false
    } 
    else{
        id='newAccountConfirmPassword';
        required = true
    } 
    textLabel = "Confirmation mot de passe :";
    type = 'password';
    confirmPassword = createDivElement(id,textLabel,type,'',true,required)
    confirmPassword.setAttribute('id','confirmPasswordElement');
    form.append(confirmPassword)

    //div de validation du formulaire
    submitDiv = document.createElement('div')
    submitDiv.classList.add('form-submit')

    input = document.createElement('input')
    input.setAttribute('type','submit')
    input.setAttribute('value','Soumettre')
    if(mail != ''){
        input.setAttribute('name','updateAccount-'+mailSubmit)
    }
    else input.setAttribute('name','createAccount')
    input.classList.add('button')
    input.classList.add('btn-green')
    submitDiv.append(input)

    buttonCancel = document.createElement('div')
    buttonCancel.classList.add("button")
    buttonCancel.classList.add("btn-red")
    buttonCancel.textContent = "Annuler"
    buttonCancel.setAttribute('id','cancelFormPopup')
    submitDiv.append(buttonCancel)

    form.append(submitDiv)
    //fin validation formulaire

    divDialogBox.append(form)
    //fin du formulaire

    divTemp.append(divDialogBox);
    divConfirm.append(divTemp)

    buttonCancel.addEventListener('click',()=>{
        divTemp.remove();
    })
}

/**
 * return true si le txt à au moins une majuscule
 * @param {*} txt : mot de passe
 * @returns 
 */
function verifMaj(txt){
    let i=0; 
    let character='';
    maj = false 
    while (i < txt.length && maj==false){ 
        character = txt.charAt(i); 
        if (character == character.toUpperCase()) { 
            maj=true;
        } 
        i++; 
    }
    return maj;
}

/** 
 * return true si le txt à au moins une minuscule
 * @param {*} txt : mot de passe
*/
function verifMin(txt){
    let i=0; 
    let character='';
    min = false 
    while (i < txt.length && min==false){ 
        character = txt.charAt(i); 
        if (character == character.toLowerCase()){ 
            min=true; 
        } 
        i++; 
    } 
    return min;
}

/**
 * return true si le txt inclus au moins un chiffre
 * @param {*} txt : mot de passe
 * @returns 
 */
function verifNum(txt){
    let i=0; 
    let character='';
    num = false 
    while (i < txt.length && num==false){ 
        character = txt.charAt(i); 
        if (!isNaN(character)){ 
            num = true; 
        }
        i++; 
    }
    return num;
}

/**
 * Return true si au moins 12 caractères
 * @param {*} txt : mot de passe
 * @returns 
 */
function verifNbCarac(txt){
    if(txt.length<12) return false
    else return true
}

/**
 * Permet de vérifier si le texte détient au moins 2 caractères spéciaux parmi ['@','&','~','#','$','*','+',':',';','?','!',',','%']
 * @param {*} txt : mot de passe
 * @returns 
 */
function verifCaracSpe(txt){
    caracSpe = ['@','&','~','#','$','*','+',':',';','?','!',',','%']
    res = false;
    count =0;
    i=0;
    while(i<txt.length && res==false){
        if(caracSpe.includes(txt.charAt(i))) count++;
        if(count>1) res = true;
        i++;
    }
    return res;
}

/**
 * Permet de vérifier si un caractère du MDP ne fait pas parti des caractères autorisés
 * @param {*} txt : mot de passe saisi
 * @returns 
 */
function verifCaracPassword(txt){
    let reg = /^([a-zA-Z0-9@&~#$*+:;?!%,])+$/g
    return reg.test(txt)
}

/**
 * Permet de supprimer le dernier caractère d'un texte
 * @param {*} txt : text à diminuer
 * @returns 
 */
function cancelLastCharacter(txt){
    let newTxt = txt.slice(0,txt.length-1)
    return newTxt
}

/**
 * Permet d'afficher l'input de confirmation de mail seulement après une saisie du mail
 * @param {*} inputMail : l'input où est saisi le mail
 */
function displayConfirmMail(inputMail){
    const confirmMail = document.getElementById('confirmMailElement')
    confirmMailInput = confirmMail.querySelector('input')
    confirmMailInput.value='';
    if(inputMail.value != ''){
        confirmMail.classList.remove('none')
        confirmMailInput.setAttribute('required','')
    }
    else{
        confirmMail.classList.add('none')
        confirmMailInput.removeAttribute('required')
    }
}

/**
 * Permet d'afficher le contour du confirmInput en rouge ou vert suivant s'il est équivalent à l'input
 * @param {*} input : saisie initiale
 * @param {*} confirmInput : confirmation de saisie
 */
function verifyEquivalent(input, confirmInput){
    if(input.value != confirmInput.value){
        confirmInput.style = "outline : 1px solid red; color : red;"
    }
    else{
        confirmInput.style = "outline : 1px solid var(--green); color : var(--green);"
    }
}

/**
 * Permet d'afficher la legende seulement au focus de l'input de MDP
 * @param {*} inputPassword : l'input où est saisi le MPD
 */
function displaylegendPassword(inputPassword){
    inputPassword.addEventListener('focus',()=>{
        inputPassword.classList.remove('passwordError')
        inputPassword.classList.add('passwordOk')
        const legendPassword = document.getElementById('legendPassword')
        legendPassword.classList.remove('none')
    })

    inputPassword.addEventListener('blur',()=>{
        const legendPassword = document.getElementById('legendPassword')
        legendPassword.classList.add('none')
    })
}

/**
 * Permet d'afficher les éléments de la légende en vert ou rouge suivant ce qui est saisie
 * @param {*} inputPassword : l'input où est saisi le MPD
 */
function displayRespectPassword(inputPassword){
    const confirmPassword = document.getElementById('confirmPasswordElement')
    let confirmPasswordInput = confirmPassword.querySelector('input')
    confirmPasswordInput.value = '';

    caracElement = document.getElementById('caracPassword')
    numElement = document.getElementById('numPassword')
    majElement = document.getElementById('majPassword')
    minElement = document.getElementById('minPassword')
    speElement = document.getElementById('spePassword')

    let valueInput = inputPassword.value;

    if(valueInput != ''){
        if(verifCaracPassword(valueInput)){
            inputPassword.classList.remove('passwordError')
            inputPassword.classList.add('passwordOk')
            //on met en rouge ou vert chaque élément obligatoire du MDP
            if(verifNbCarac(valueInput)) caracElement.style = "color : var(--dark_green);"
            else caracElement.style = "color : red;"

            if(verifNum(valueInput)) numElement.style = 'color : var(--dark_green);'
            else numElement.style = 'color : red;'

            if(verifMaj(valueInput)) majElement.style = 'color : var(--dark_green);'
            else majElement.style = 'color : red;'

            if(verifMin(valueInput)) minElement.style = 'color : var(--dark_green);'
            else minElement.style = 'color : red;'

            if(verifCaracSpe(valueInput)) speElement.style = 'color : var(--dark_green);'
            else speElement.style = 'color : red;'          

            //quand tous les obligations du MDP sont respectées on affiche la confirmation et enlève la lègende
            if(verifNbCarac(valueInput) && verifNum(valueInput) && verifMaj(valueInput) &&
            verifMin(valueInput) && verifCaracSpe(valueInput)){
                confirmPassword.classList.remove('none')
                confirmPasswordInput.setAttribute('required', '')
                legendPassword.classList.add('none')
            }
            else{
                confirmPasswordInput.removeAttribute('required')
                confirmPassword.classList.add('none')
                legendPassword.classList.remove('none')
            }
        }
        else{
            inputPassword.value = cancelLastCharacter(valueInput)
            inputPassword.classList.add('passwordError')
            inputPassword.classList.remove('passwordOk')
            
        }
    }
    else{
        legendPassword.classList.add('none')
    }
}

//mise à jour des utilisateurs

for(let i=0 ; i<iconsUpdate.length ; i++){
    iconsUpdate[i].addEventListener("click",()=>{
        
        mail = iconsUpdate[i].getAttribute('mail')
        mailSubmit = mail.replace('.','');
        createPopupAccount(mail);

        // la confirmation de mail n'apparait que si un mail est saisi
        const inputMail = document.getElementById('updateAccountMail-'+mailSubmit)
        if(inputMail != null){
            inputMail.addEventListener('input',()=>{
                displayConfirmMail(inputMail)
        })}

        //la confirmation est rouge si le texte est différent de l'input (vert sinon)
        const confirmMail = document.getElementById('confirmMailElement')
        confirmMailInput = confirmMail.querySelector('input')
        confirmMailInput.addEventListener('input',()=>{
            verifyEquivalent(inputMail,confirmMailInput)
        })

        // la légende du mot de passe n'apparait que si le focus est sur le nouveau mot de passe
        const inputPassword = document.getElementById('updateAccountPassword-'+mailSubmit)
        displaylegendPassword(inputPassword)

        //on indique si les critères sont respectés
        inputPassword.addEventListener('input',()=>{
            displayRespectPassword(inputPassword)
        })

        //on met en evidence si la confirmation du mdp est bonne
        const confirmPassword = document.getElementById('confirmPasswordElement')
        const confirmPasswordInput = confirmPassword.querySelector('input')
        confirmPasswordInput.addEventListener('input',()=>{
            verifyEquivalent(inputPassword,confirmPasswordInput)
        })
    })
}

// création d'un nouvel utilisateur
btnCreateAccount = document.getElementById('btnCreateAccount')
btnCreateAccount.addEventListener('click',()=>{
    
    //création de la popup
    createPopupAccount('');

    // la confirmation de mail n'apparait que si un mail est saisi
    const inputMailCreate = document.getElementById('newAccountMail')
    inputMailCreate.addEventListener('input',()=>{
        displayConfirmMail(inputMailCreate)
    })

    //la confirmation est rouge si le texte est différent de l'input (vert sinon)
    const confirmMail = document.getElementById('confirmMailElement')
    confirmMailInput = confirmMail.querySelector('input')
    confirmMailInput.addEventListener('input',()=>{
        verifyEquivalent(inputMail,confirmMailInput)
    })

    // la légende du mot de passe n'apparait que si le focus est sur le nouveau mot de passe
    const inputPasswordCreate = document.getElementById('newAccountPassword')
    displaylegendPassword(inputPasswordCreate)

    //on indique si les critères sont respectés
    inputPasswordCreate.addEventListener('input',()=>{
        displayRespectPassword(inputPasswordCreate)
    })

    //on met en evidence si la confirmation du mdp est bonne
    const confirmPassword = document.getElementById('confirmPasswordElement')
    const confirmPasswordInput = confirmPassword.querySelector('input')
    confirmPasswordInput.addEventListener('input',()=>{
        verifyEquivalent(inputPassword,confirmPasswordInput)
    })

})

/**
 * Créer le popup de création ou modification d'utilisateur
 * @param {*} mail : mail de l'utilisteur en cas de modification / '' pour création

 */
function createPopupUnblocAccount(mail){
    let divConfirm = document.getElementById("js-confirm");
    divTemp = document.createElement('div')

    divTemp.classList.add('c-dialog')
    
    //on met en place le fond
    divFond = document.createElement('div')
    divFond.classList.add('fond')
    divTemp.append(divFond)

    //on met en place le popup
    divDialogBox = document.createElement('div')
    divDialogBox.classList.add('c-dialog__box')
    divDialogBox.classList.add('themeBeige')
    divDialogBox.classList.add('popup')

    divDialogBox.setAttribute('id','deblocAccount')

    //entete du popup
    divEntete = document.createElement('div')
    divEntete.classList.add('Entete')

    h3 = document.createElement('h3')
    h3.classList.add('dialog-title')
    h3.textContent = "Débloquer un compte"
    divEntete.append(h3)
    divDialogBox.append(divEntete)

    //formulaire
    form = document.createElement('form')
    form.setAttribute('action','')
    form.setAttribute('method','POST')

    // élément du formulaire

    intro = document.createElement('p')
    intro.textContent = "Pour débloquer le compte de "+mail+" vous devez changer le mot de passe et le transmettre à l'utilisateur."
    intro.style ="font-weight : bold; margin : 0 auto 10px auto !important;"
    form.append(intro)


    id='unblocAccountPassword';
    textLabel = "Nouveau mot de passe :";
    required = true
    type = 'password';
    divElement = document.createElement('div')
    divElement.classList.add('element')
    label = document.createElement('label')
    label.setAttribute('for',id)
    label.textContent = textLabel
    divElement.append(label)

    input = document.createElement('input')
    input.setAttribute('type',type)
    input.setAttribute('name',id)
    input.setAttribute('id',id)
    divElement.append(input)

    form.append(divElement)

    legendPassword = document.createElement('div')
    legendPassword.classList.add('legendAccount')
    legendPassword.classList.add('none')
    legendPassword.setAttribute('id','legendPassword')
    legendPassword.append(textPassword("Votre mot de passe est valide s'il contient au moins : ",'legPassword'))
    legendPassword.append(textPassword("12 caractères",'caracPassword'))
    legendPassword.append(textPassword("un chiffre",'numPassword'))
    legendPassword.append(textPassword("une majuscule",'majPassword'))
    legendPassword.append(textPassword("une minuscule",'minPassword'))
    legendPassword.append(textPassword("deux caractères spéciaux parmi @ & ~ # $ * + : ; ? ! % ,",'spePassword'))
    form.append(legendPassword)

    id='unblocAccountConfirmPassword';
    textLabel = "Confirmation mot de passe :";
    type = 'password';
    confirmPassword = createDivElement(id,textLabel,type,'',true,true)
    confirmPassword.setAttribute('id','confirmPasswordElement');
    form.append(confirmPassword)

    //div de validation du formulaire
    submitDiv = document.createElement('div')
    submitDiv.classList.add('form-submit')

    input = document.createElement('input')
    input.setAttribute('type','submit')
    input.setAttribute('value','Soumettre')
    mailSubmit=mail.replace('.','')
    input.setAttribute('name','unblocAccount-'+mailSubmit)
    input.classList.add('button')
    input.classList.add('btn-green')
    submitDiv.append(input)

    buttonCancel = document.createElement('div')
    buttonCancel.classList.add("button")
    buttonCancel.classList.add("btn-red")
    buttonCancel.textContent = "Annuler"
    buttonCancel.setAttribute('id','cancelFormPopup')
    submitDiv.append(buttonCancel)

    form.append(submitDiv)
    //fin validation formulaire

    divDialogBox.append(form)
    //fin du formulaire

    divTemp.append(divDialogBox);
    divConfirm.append(divTemp)

    buttonCancel.addEventListener('click',()=>{
        divTemp.remove();
    })

}

// débloquer un compte
const iconsUnbloc = document.querySelectorAll('.js-unbloc')

for(let i=0 ; i<iconsUnbloc.length; i++){
    iconsUnbloc[i].addEventListener('click',()=>{
        mail = iconsUnbloc[i].getAttribute('mail');
        createPopupUnblocAccount(mail)

        // la légende du mot de passe n'apparait que si le focus est sur le nouveau mot de passe
        const inputPasswordUnbloc = document.getElementById('unblocAccountPassword')
        displaylegendPassword(inputPasswordUnbloc)

    //on indique si les critères sont respectés
    inputPasswordUnbloc.addEventListener('input',()=>{
        displayRespectPassword(inputPasswordUnbloc)
        const confirmPassword = document.getElementById('confirmPasswordElement')
        const confirmPasswordInput = confirmPassword.querySelector('input')
        confirmPasswordInput.addEventListener('input',()=>{
            verifyEquivalent(inputPasswordUnbloc,confirmPasswordInput)
        })
    })
    })

     //on met en evidence si la confirmation du mdp est bonne

}

//modifier le compte de l'utilisateur connecté

const updateMyAccount = document.getElementById('updateMyAccount')

updateMyAccount.addEventListener('click',()=>{
    mail = updateMyAccount.getAttribute('mail')
    mailSubmit = mail.replace('@','')
    createPopupAccount(mail,true);
    // la confirmation de mail n'apparait que si un mail est saisi
    const inputMail = document.getElementById('updateAccountMail-'+mailSubmit)
    inputMail.addEventListener('input',()=>{
        displayConfirmMail(inputMail)
    })

    // la légende du mot de passe n'apparait que si le focus est sur le nouveau mot de passe
    const inputPassword = document.getElementById('updateAccountPassword-'+mailSubmit)
    displaylegendPassword(inputPassword)

    //on indique si les critères sont respectés
    inputPassword.addEventListener('input',()=>{
        displayRespectPassword(inputPassword)
    })
})
