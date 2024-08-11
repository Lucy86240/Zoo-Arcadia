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
