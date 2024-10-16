/* pages : habitats, commentaires_veterinaire */

//icons commentaires : affichage de la légende au survol

const iconComments = document.querySelectorAll('.js-iconComments');
const legendComments = document.querySelectorAll('.js-legendComments');

for(let i=0; i<iconComments.length;i++){
    iconComments[i].addEventListener("mouseover",()=>{
        legendComments[i].classList.remove('none');
    })
    iconComments[i].addEventListener("mouseout",()=>{
        legendComments[i].classList.add('none');
    })
}

//nouveau commentaire : affichage au clic de l'icone
const iconsAddComment = document.querySelectorAll('.js-iconAddComments')
const addComment = document.getElementById('addComment')
if(addComment != null){
    //fermeture de l'ajout au clic sur la croix
    const close = addComment.querySelector('.close')
    close.addEventListener('click',()=>{
        addComment.classList.add('none')
    })

    //détermination de la 1ere option du select des habitats
    const select = addComment.querySelector('#addCommentsHousing')
    for(let j=0;j<iconsAddComment.length;j++){
        iconsAddComment[j].addEventListener('click',()=>{
            addComment.classList.remove('none');
            id=iconsAddComment[j].getAttribute('id_housing')
            for (let i=0; i < select.options.length; i++){
                if (select.options[i].value == id){
                    select.options[i].selected = true;
                }
            }
        })
    }
} 

//bloc la saisie lors de caractères non autorisés
addCommentComment = document.getElementById('addCommentComment')
if(addCommentComment != null)
{
    addCommentComment.addEventListener('input',()=>{
        if(!verifDescriptionRegex(addCommentComment.value)){
            addCommentComment.style = "outline : 1px solid red"
            addCommentComment.value = cancelLastCharacter(addCommentComment.value)
        }
        else{
            addCommentComment.style = "outline : 1px solid grey"
        }
    })
}

// suppression commentaire : popup au clic sur l'icone
const deleteIcon = document.querySelectorAll(".deleteIcon");
for(let k=0;k<deleteIcon.length;k++){
    deleteIcon[k].addEventListener('click',()=>{
        
        id=deleteIcon[k].getAttribute('id_comment')
        submitContent = 'ValidationDeleteComment'+id
        titleContent = 'Suppression'
        parContent = "Etes vous sûr de vouloir supprimer ce commentaire ?"
        createConfirm(titleContent,parContent,submitContent)
    })
}

//archivage : popup au clic sur l'icone

const archiveIcon = document.querySelectorAll('.js-iconArchive')
for(let l=0;l<archiveIcon.length;l++){
    archiveIcon[l].addEventListener('click',()=>{
        id=archiveIcon[l].getAttribute('id_comment')
        submitContent = 'ValidationArchiveComment'+id
        titleContent = 'Archivage'
        parContent = "Etes vous sûr de vouloir archiver ce commentaire ? Il ne sera plus visible dans les habitats."
        createConfirm(titleContent,parContent,submitContent)
    })
}

//désarchivage : popup au clic sur l'icone

const unarchiveIcon = document.querySelectorAll('.js-iconUnarchive')
for(let m=0;m<unarchiveIcon.length;m++){
    unarchiveIcon[m].addEventListener('click',()=>{
        
        id=unarchiveIcon[m].getAttribute('id_comment')
        submitContent = 'ValidationUnarchiveComment'+id
        titleContent = 'Désarchivage'
        parContent = "Etes vous sûr de vouloir rendre le commentaire de nouveau actif ? Il sera visible dans les habitats."
        createConfirm(titleContent,parContent,submitContent)
    })
}

