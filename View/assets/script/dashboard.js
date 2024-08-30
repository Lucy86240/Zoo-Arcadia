/** Page dashboard */

//ouverture / fermeture de la liste de popularité (avec mise en page spéciale des tuiles)

//initialisation des variables
const icon = document.getElementById('statsTile');
const textStat = icon.querySelector('span')
const title = document.getElementById('titleStats')
const ul = document.getElementById('stats').querySelector('ul');
let icons = document.getElementById('tiles')

let tiles = document.querySelectorAll('.js-tile')
const newtiles = document.querySelectorAll('.js-tile')
let deplace = document.querySelector('.js')

actif = false;

//au clic sur l'icon de popularité
icon.addEventListener('click',()=>{
    //si la popularité des animaux n'est pas affichée
    if(actif==false){
        //modification du titre de la tuile
        textStat.innerHTML = "Moins de popularité"
        //affichage le titre 
        title.classList.remove('none');
        //affichage de la liste
        ul.classList.remove('none');
        //indication de l'affichage de la popularité
        actif = true;
        //on déplace les tuiles pour une présentation plus sympathique
        let deplace;
        if(window.innerWidth > 808)
            deplace = document.querySelector('.jsDesktop')
        else
            deplace = document.querySelector('.jsMobile')
        for(let i=0; i<tiles.length;i++){
            deplace.append(tiles[i])
            tiles[i]=null;
        }
        deplace.classList.add('tiles')
        deplace.classList.add('displayTiles')
        deplace.classList.add('tilesTemp')
    }
    else{
        //modification du titre de la tuile
        textStat.innerHTML = "Plus de popularité"
        //disparition des éléments affichés
        title.classList.add('none');
        ul.classList.add('none');
        //indication que la popularité n'est pas affichée
        actif = false;
        //remise en place des tuiles
        if(window.innerWidth > 808)
            deplace = document.querySelector('.jsDesktop')
        else
            deplace = document.querySelector('.jsMobile')
        deplace=null;
        if(window.innerWidth > 808)
            deplace = document.querySelector('.jsDesktop')
        else
            deplace = document.querySelector('.jsMobile')
        deplace.classList.remove('tiles')
        deplace.classList.remove('displayTiles')
        deplace.classList.remove('tilesTemp')
        for(let i=0; i<tiles.length;i++){
            icons.append(newtiles[i]);
        }
    }

})

