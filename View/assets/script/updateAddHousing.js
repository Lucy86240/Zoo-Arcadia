/*Page ajout d'un habitat*/ 

housingName = document.getElementById('newHousingName')
if(housingName == null) housingName = document.getElementById('updateHousingName')

housingDescription = document.getElementById('newHousingDescription')
if(housingDescription == null ) housingDescription = document.getElementById('updateHousingDescription')

PDescription = document.getElementById('NHP-Description')
if(PDescription == null) document.getElementById('UHP-Description')

//on bloque la saisie en cas de caractères non autorisés
if(housingName != null)
    housingName.addEventListener('input',()=>{
        if(verifAnimalNameRegex(housingName.value) || housingName.value==''){
            housingName.style = 'outline : 1px solid black'
        }
        else{
            housingName.style = 'outline : 1px solid red'
            housingName.value = cancelLastCharacter(housingName.value)
        }
    })

//on bloque la saisie en cas de caractères non autorisés
if(housingDescription != null)
    housingDescription.addEventListener('input',()=>{
        if(verifDescriptionRegex(housingDescription.value) || housingDescription.value==''){
            housingDescription.style = 'outline : 1px solid black'
        }
        else{
            housingDescription.style = 'outline : 1px solid red'
            housingDescription.value = cancelLastCharacter(housingDescription.value)
        }
    })

//on bloque la saisie en cas de caractères non autorisés
if(PDescription != null)
    PDescription.addEventListener('input',()=>{
        if(verifDescriptionRegex(PDescription.value) || PDescription.value==''){
            PDescription.style = 'outline : 1px solid black'
        }
        else{
            PDescription.style = 'outline : 1px solid red'
            PDescription.value = cancelLastCharacter(PDescription.value)
        }
    })
