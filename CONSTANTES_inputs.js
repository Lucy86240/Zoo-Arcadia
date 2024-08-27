const SITE_URL = 'http://localhost:3000/';

function verifMailRegex(mail){
    let regex = /^[a-zA-Z0-9_.±]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/g
    return regex.test(mail)
}

function verifPseudoRegex(pseudo){
    let reg = /^([a-zA-Z0-9èéëïç@#$*+:;?! _\-])+$/g
    return reg.test(pseudo)
}

function verifAnimalNameRegex(name){
    let reg = /^([a-zA-Z0-9 èéëïç\-])+$/g
    return reg.test(name)
}

function verifHumanNameRegex(name){
    let reg = /^([a-zA-Zèéëïç\-])+$/g
    return reg.test(name)
}

function verifDescriptionRegex(txt){
    let reg = /^([a-zA-Z0-9èéëïç&.!?,:\);\( \-])+$/g
    return reg.test(txt)
}

function verifDateRegex(date){
    let reg = /[1-9][0-9][0-9]{2}-([0][1-9]|[1][0-2])-([1-2][0-9]|[0][1-9]|[3][0-1])/g
    return reg.test(date)
}

/**
 * Permet de supprimer le dernier caractère d'un texte
 * @param {*} txt : text à diminuer
 * @returns 
 */
function cancelLastCharacter(txt){
    let newTxt = txt.slice(0,txt.length-1)
    return newTxt
}