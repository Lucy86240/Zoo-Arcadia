img = document.getElementById('illustration')
function choicePanda(){
    if(window.innerWidth > 576){
        img.src="View/assets/img/general/pages/contact/panda-desktop.png"
    }
    else{
            img.src="View/assets/img/general/pages/contact/panda-mobile.png"
    }
}

window.addEventListener("resize", ()=>{
    choicePanda()
})

choicePanda()

msg = document.querySelector('textarea')
company = document.getElementById('company')
firstName = document.getElementById('firstName')
lastName = document.getElementById('lastName')
mail = document.getElementById('mail')
object = document.getElementById('object')

msg.addEventListener('input',()=>{
    if(!verifDescriptionRegex(msg.value) && msg.value != ''){
        msg.value = cancelLastCharacter(msg.value)
        msg.style = "outline : 1px solid red"
    }
    else
        msg.style = "outline : 1px solid var(--brown)"
})

company.addEventListener('input',()=>{
    if(verifAnimalNameRegex(company.value) || company.value == ''){
        company.style = "outline : 1px solid var(--brown)"
    }
    else{
        company.value = cancelLastCharacter(company.value)
        company.style = "outline : 1px solid red"
    }
})

firstName.addEventListener('input',()=>{
    if(verifHumanNameRegex(firstName.value) || firstName.value == ''){
        firstName.style = "outline : 1px solid var(--brown)"
    }
    else{
        firstName.value = cancelLastCharacter(firstName.value)
        firstName.style = "outline : 1px solid red"
    }
})

lastName.addEventListener('input',()=>{
    if(verifHumanNameRegex(lastName.value) || lastName.value == ''){
        lastName.style = "outline : 1px solid var(--brown)"
    }
    else{
        lastName.value = cancelLastCharacter(lastName.value)
        lastName.style = "outline : 1px solid red"
    }
})

mail.addEventListener('input',()=>{
    if(verifMailRegex(mail.value) || mail.value == ''){
        mail.style = "outline : 1px solid var(--brown)"
    }
    else{
        mail.value = cancelLastCharacter(mail.value)
        mail.style = "outline : 1px solid red"
    }
})

object.addEventListener('input',()=>{
    if(!verifDescriptionRegex(object.value) && object.value != ''){
        object.value = cancelLastCharacter(object.value)
        object.style = "outline : 1px solid red"
    }
    else
        object.style = "outline : 1px solid var(--brown)"
})