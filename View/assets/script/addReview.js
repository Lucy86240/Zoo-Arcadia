const triggerNR = document.querySelector('#popup-review'); 
const dialogNR = document.getElementById('new-review-dialog');
const dismissTriggerNR = dialogNR.querySelector('[data-dismiss]');
popup(dialogNR,triggerNR,dismissTriggerNR)

  //change stars
  const starsInput = document.querySelectorAll(".check-stars-input");
  const starsImg = document.querySelectorAll(".NewReview-star");

  for(let i=0; i<starsInput.length;i++){
    starsInput[i].addEventListener('click', ()=> {
      for(let j=0; j<starsInput.length;j++){
        if(window.location.href==(SITE_URL+'/avis') ||window.location.href==(SITE_URL+'/') ){
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

