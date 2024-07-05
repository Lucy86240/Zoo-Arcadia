document.addEventListener('DOMContentLoaded', () => {  
  
  const triggers = document.querySelectorAll('[aria-haspopup="dialog"]');
    const doc = document.querySelector('.NewReview');
  
    const open = function (dialog) {
      dialog.setAttribute('aria-hidden', false);
      doc.setAttribute('aria-hidden', true);
    };
  
    const close = function (dialog) {
      dialog.setAttribute('aria-hidden', true);
      doc.setAttribute('aria-hidden', false);
    };
  
    triggers.forEach((trigger) => {
      const dialog = document.getElementById(trigger.getAttribute('aria-controls'));
      const dismissTriggers = dialog.querySelectorAll('[data-dismiss]');
  
      // open dialog
      trigger.addEventListener('click', (event) => {
        event.preventDefault();
  
        open(dialog);
      });
  
      // close dialog
      dismissTriggers.forEach((dismissTrigger) => {
        const dismissDialog = document.getElementById(dismissTrigger.dataset.dismiss);
  
        dismissTrigger.addEventListener('click', (event) => {
          event.preventDefault();
  
          close(dismissDialog);
        });
      });
  
      window.addEventListener('click', (event) => {
        if (event.target === dialog) {
          close(dialog);
        }
      });
    });
  });

  //change stars
  const starsInput = document.querySelectorAll(".check-stars-input");
  const starsImg = document.querySelectorAll(".NewReview-star");

  for(let i=0; i<starsInput.length;i++){
    starsInput[i].addEventListener('click', ()=> {
      for(let j=0; j<starsInput.length;j++){
        if(window.location.href==(SITE_URL+'/avis')){
          starsImg[j].src="View/assets/img/general/review/Star-white.png";
        }else{
          starsImg[j].src="../View/assets/img/general/review/Star-white.png";
        }
      }
      for(let j=0; j<=i; j++){
        if(window.location.href==(SITE_URL+'/avis')){
          starsImg[j].src="View/assets/img/general/review/Star-gold.png";
        }else{
          starsImg[j].src="../View/assets/img/general/review/Star-gold.png";
        }
      }
    })
  }

