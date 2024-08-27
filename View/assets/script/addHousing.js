newHousingName = document.getElementById('newHousingName')
newHousingDescription = document.getElementById('newHousingDescription')
NHPDescription = document.getElementById('NHP-Description')

newHousingName.addEventListener('input',()=>{
    if(verifAnimalNameRegex(newHousingName.value) || newHousingName.value==''){
        newHousingName.style = 'outline : 1px solid black'
    }
    else{
        newHousingName.style = 'outline : 1px solid red'
        newHousingName.value = cancelLastCharacter(newHousingName.value)
    }
})

newHousingDescription.addEventListener('input',()=>{
    if(verifAnimalNameRegex(newHousingDescription.value) || newHousingDescription.value==''){
        newHousingDescription.style = 'outline : 1px solid black'
    }
    else{
        newHousingDescription.style = 'outline : 1px solid red'
        newHousingDescription.value = cancelLastCharacter(newHousingDescription.value)
    }
})

NHPDescription.addEventListener('input',()=>{
    if(verifAnimalNameRegex(NHPDescription.value) || NHPDescription.value==''){
        NHPDescription.style = 'outline : 1px solid black'
    }
    else{
        NHPDescription.style = 'outline : 1px solid red'
        NHPDescription.value = cancelLastCharacter(NHPDescription.value)
    }
})