function popup(dialog, trigger, dismissTrigger){

  trigger.addEventListener('click',()=>{
    dialog.classList.remove('none');
  })
  dismissTrigger.addEventListener('click',()=>{
    dialog.classList.add('none');
  })
}