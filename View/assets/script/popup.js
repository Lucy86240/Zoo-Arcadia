function popup(dialog, trigger, dismissTrigger){

  trigger.addEventListener('click',()=>{
    dialog.classList.remove('none');
  })
  dismissTrigger.addEventListener('click',()=>{
    dialog.classList.add('none');
  })
}

function popupConfirm(icon,popup){
  for(let i=0; i<icon.length; i++){
    icon[i].addEventListener('click',() => {
        popup[i].classList.remove('none');
    });
  }
}

//création d'une popup de confirmation
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
