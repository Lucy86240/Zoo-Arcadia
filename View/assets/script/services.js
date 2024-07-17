
//ouverture du popup de confirmation de suppression
const deleteServiceDesktop = document.querySelectorAll(".deleteServiceD");
const popupServiceDesktop = document.querySelectorAll(".dialog-delete-js");

const deleteServiceMobile = document.querySelectorAll(".deleteServiceM");
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


//apparition du formulaire de modification
const editServiceDesktop = document.querySelectorAll('.editServiceD');
const editServiceMobile = document.querySelectorAll('.editServiceM');
const editServiceForm = document.querySelectorAll('.editServiceForm');

for(let i=0; i<editServiceDesktop.length; i++){
    editServiceDesktop[i].addEventListener('click',() => {
        editServiceForm[i].classList.remove('none');
    });
}
for(let i=0; i<editServiceMobile.length; i++){
    editServiceMobile[i].addEventListener('click',() => {
        editServiceForm[i].classList.remove('none');
    });
}