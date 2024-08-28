const footerDesktop = document.querySelector('.footer-desktop').innerHTML
const footerMobile = document.querySelector('.footer-mobile').innerHTML

let footerD = document.querySelector('.footer-desktop')
let footerM = document.querySelector('.footer-mobile')

if(window.innerWidth < 576){
    footerD.innerHTML = ""
    mobile = true;
}
else{
    footerM.innerHTML = ""
    mobile = false
}


window.addEventListener('resize',()=>{
    if(window.innerWidth < 576 && mobile == false){
        footerD.innerHTML = ""
        footerM.innerHTML = footerMobile
        mobile = true;
    }
    else if (window.innerWidth > 576 && mobile == true){
        footerM.innerHTML = ""
        footerD.innerHTML = footerDesktop
        mobile = false
    }
})