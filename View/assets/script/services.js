
//responsive
let services = document.querySelectorAll('.service')
servicesMobile = []
for(let i=0; i<services.length;i++){
    servicesMobile.push(services.innerHTML)
}

function versionMobile(){
    for(let i=0; i<services.length; i++){
        services[i].classList.remove('service-desktop')
        services[i].classList.add('service-mobile')
        let containerD = services[i].querySelector('.container-service')
        img = containerD.querySelector('img')
        h2 = containerD.querySelector('h2')
        p = containerD.querySelector('p')
        containerMobile = document.createElement('div')

        containerMobile.append(h2)
        containerMobile.append(img)
        containerMobile.append(p)

        containerD.innerHTML = containerMobile.innerHTML;

    }
}

function versionDesktop(){
    for(let i=0; i<services.length; i++){
        services[i].classList.remove('service-mobile')
        services[i].classList.add('service-desktop')
        let containerM = services[i].querySelector('.container-service')
        img = containerM.querySelector('img')
        h2 = containerM.querySelector('h2')
        p = containerM.querySelector('p')
        containerDesktop = document.createElement('div')
        if(i%2==0){
            containerDesktop.append(img)
        }
        div = document.createElement('div')
        div.classList.add("text-service")
        div.append(h2)
        div.append(p)
        containerDesktop.append(div)
        if(i%2!=0){
            containerDesktop.append(img)
        }
        containerM.innerHTML = containerDesktop.innerHTML;

    }
}

if(window.innerWidth < 576){
    mobile = true
}
else{
    versionDesktop()
    mobile = false
}

window.addEventListener('resize',()=>{
    if(window.innerWidth < 576 && mobile == false){
        versionMobile()
        mobile = true
    }
    else if(window.innerWidth > 576 && mobile == true){
        versionDesktop()
        mobile = false
    }
})


// popup
const iconDelete = document.querySelectorAll('.iconDelete')
if(iconDelete != null)
    for(let i = 0; i<iconDelete.length; i++){
        iconDelete[i].addEventListener('click',()=>{
            titleContent = "Suppression";
            parContent = "Etes vous sûr de vouloir supprimer le service : \""+iconDelete[i].getAttribute("nameService")+"\" ?"
            submitContent = "ValidationDeleteService"+iconDelete[i].getAttribute("id")
            createConfirm(titleContent,parContent,submitContent)
        })
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

    