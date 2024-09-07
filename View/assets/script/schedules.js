schedules = document.getElementById('schedules')

schedules.addEventListener('input',() =>{
    if(!verifDescriptionRegex(schedules.value) && schedules.value != ''){
        schedules.value = cancelLastCharacter(schedules.value)
        schedules.style = "outline : 1px solid red"
    }
    else
    schedules.style = "outline : 1px solid var(--brown)"

})