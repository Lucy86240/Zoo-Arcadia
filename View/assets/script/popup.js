//plusieurs pages

/**
 * Affiche / ferme un popup avec une croix existant dans le HTML
 * @param {*} dialog : popup
 * @param {*} trigger : icone
 * @param {*} dismissTrigger : croix
 */
function popup(dialog, trigger, dismissTrigger){

  trigger.addEventListener('click',()=>{
    dialog.classList.remove('none');
  })
  dismissTrigger.addEventListener('click',()=>{
    dialog.classList.add('none');
  })
}

/**
 * Affiche un popup existant dans le HTML
 * @param {*} icon 
 * @param {*} popup 
 */
function popupConfirm(icon,popup){
  for(let i=0; i<icon.length; i++){
    icon[i].addEventListener('click',() => {
        popup[i].classList.remove('none');
    });
  }
}

//création d'une popup de confirmation
/**
 * créer une popup de confirmation (attention nécessite une div avec pour id "js-confirm")
 * @param {*} titleContent : titre du popup
 * @param {*} parContent : texte du popup
 * @param {*} submitContent : nom du bouton de validation 
 */
function createConfirm(titleContent,parContent,submitContent){
  const divConfirm = document.getElementById("js-confirm");
  divConfirm.classList.add('c-dialog')
  divConfirm.classList.add('dialog-popup-js')

  divFond = document.createElement('div')
  divFond.classList.add('fond')
  divConfirm.append(divFond)

  form = document.createElement('form')
  form.classList.add('popup-confirm')
  form.setAttribute('action','')
  form.setAttribute('method','POST')

  title = document.createElement('p')
  title.classList.add("entete")
  title.textContent = titleContent
  form.append(title)

  content = document.createElement('p')
  content.textContent = parContent
  form.append(content)

  divButtons = document.createElement('div')
  divButtons.classList.add('confirm-choice')

  submit = document.createElement('input')
  submit.classList.add('button-confirm')
  submit.setAttribute('type','submit')
  $confirm = submitContent
  submit.setAttribute('name',$confirm)
  submit.setAttribute('value','oui')
  divButtons.append(submit)

  cancel = document.createElement('button')
  cancel.classList.add('button')
  cancel.classList.add('btn-green')
  cancel.textContent = 'Non'
  divButtons.append(cancel)

  form.append(divButtons)

  divConfirm.append(form)
}
