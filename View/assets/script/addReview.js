/*Popup d'ajout d'un avis*/

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
          starsImg[j].src="View/assets/img/general/pages/reviews/Star-white.png";
        }else{
          starsImg[j].src="../View/assets/img/general/pages/reviews/Star-white.png";
        }
      }
      for(let j=0; j<=i; j++){
        if(window.location.href==(SITE_URL+'/avis')){
          starsImg[j].src="View/assets/img/general/pages/reviews/Star-gold.png";
        }else{
          starsImg[j].src="../View/assets/img/general/pages/reviews/Star-gold.png";
        }
      }
    })
  }

//inputs : on bloc la saisie en cas de caractères non autorisés

newReviewPseudo = document.getElementById('NewReviewPseudo')
newReviewComment = document.getElementById('NewReviewComment')

newReviewPseudo.addEventListener('input',()=>{
  console.log(verifPseudoRegex(newReviewPseudo.value));
  if(!verifPseudoRegex(newReviewPseudo.value)){
    newReviewPseudo.value = cancelLastCharacter(newReviewPseudo.value);
    newReviewPseudo.style = "outline : 1px solid red;"
  }
  else newReviewPseudo.style = "outline : 1px solid black;"
})

newReviewComment.addEventListener('input',()=>{
  if(!verifDescriptionRegex(newReviewComment.value)){
    newReviewComment.value = cancelLastCharacter(newReviewComment.value);
    newReviewComment.style = "outline : 1px solid red;"
  }
  else newReviewComment.style = "outline : 1px solid black;"
})


