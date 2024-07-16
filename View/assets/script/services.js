const deleteService = document.querySelectorAll(".deleteService");
const popupService = document.querySelectorAll(".dialog-delete-js");

for(let i=0; i<deleteService.length; i++){
    deleteService[i].addEventListener('click',() => {
        popupService[i].classList.remove('none');
    })
}