  //ouverture du popup de confirmation
  const iconDesktop = document.querySelectorAll(".popupDesktop");
  const popupDesktop = document.querySelectorAll(".dialog-popup-js");
  
  const iconMobile = document.querySelectorAll(".popupMobile");
  const popupMobile = document.querySelectorAll(".dialog-popupMobile-js");
  
  
  for(let i=0; i<iconDesktop.length; i++){
      iconDesktop[i].addEventListener('click',() => {
          popupDesktop[i].classList.remove('none');
      });
  }
  for(let i=0; i<iconMobile.length; i++){
      iconMobile[i].addEventListener('click',() => {
          popupMobile[i].classList.remove('none');
      });
  }