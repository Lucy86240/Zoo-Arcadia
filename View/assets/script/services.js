
// popup
const iconDelete = document.querySelectorAll('.iconDelete')
const popupDelete = document.querySelectorAll('.popupDelete')
popupConfirm(iconDelete,popupDelete)


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