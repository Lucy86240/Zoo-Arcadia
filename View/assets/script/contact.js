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

function verifCaracMsg(txt){
    let reg = /^([a-zA-Z0-9'èéëïçñ ,!;:?()-])+$/g
    return reg.test(txt)
}

function cancelLastCharacter(txt){
    let newTxt = txt.slice(0,txt.length-1)
    return newTxt
}

msg.addEventListener('input',()=>{
    if(!verifCaracMsg(msg.value) && msg.value != ''){
        msg.value = cancelLastCharacter(msg.value)
        msg.style = "outline : 1px solid red"
    }
    else
        msg.style = "outline : 1px solid var(--brown)"
})