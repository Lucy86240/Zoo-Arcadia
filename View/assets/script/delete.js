//ouverture du popup de confirmation de suppression
const deleteServiceDesktop = document.querySelectorAll(".deleteDesktop");
const popupServiceDesktop = document.querySelectorAll(".dialog-delete-js");

const deleteServiceMobile = document.querySelectorAll(".deleteMobile");
const popupServiceMobile = document.querySelectorAll(".dialog-deleteMobile-js");


for(let i=0; i<deleteServiceDesktop.length; i++){
    deleteServiceDesktop[i].addEventListener('click',() => {
        popupServiceDesktop[i].classList.remove('none');
    });
}
for(let i=0; i<deleteServiceMobile.length; i++){
    deleteServiceMobile[i].addEventListener('click',() => {
        popupServiceMobile[i].classList.remove('none');
    });
}