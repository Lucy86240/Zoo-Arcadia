
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


updateServiceName = document.querySelectorAll('.js-UpdateServiceName')
if(updateServiceName != null)
    for(let i = 0 ; i<updateServiceName .length;i++){
        updateServiceName[i].addEventListener('input',()=>{
            if(verifDescriptionRegex(updateServiceName[i].value) || updateServiceName[i].value==''){
                updateServiceName[i].style = 'outline : 1px solid grey'
            }
            else{
                updateServiceName[i].style = 'outline : 1px solid red'
                updateServiceName[i].value = cancelLastCharacter(updateServiceName[i].value)
            }
        })
    }

USPDescription = document.querySelectorAll('.js-USP-Description')
if(USPDescription != null)
    for(let i = 0 ; i<USPDescription .length;i++){
        USPDescription[i].addEventListener('input',()=>{
            console.log('coucou')
            if(verifDescriptionRegex(USPDescription[i].value) || USPDescription[i].value==''){
                USPDescription[i].style = 'outline : 1px solid grey'
            }
            else{
                USPDescription[i].style = 'outline : 1px solid red'
                USPDescription[i].value = cancelLastCharacter(USPDescription[i].value)
            }
        })
    }

    UpdateDescription = document.querySelectorAll('.update-description')
    if(UpdateDescription != null)
        for(let i = 0 ; i<UpdateDescription .length;i++){
            UpdateDescription[i].addEventListener('input',()=>{
                console.log('coucou')
                if(verifDescriptionRegex(UpdateDescription[i].value) || UpdateDescription[i].value==''){
                    UpdateDescription[i].style = 'outline : 1px solid grey'
                }
                else{
                    UpdateDescription[i].style = 'outline : 1px solid red'
                    UpdateDescription[i].value = cancelLastCharacter(UpdateDescription[i].value)
                }
            })
        }

    