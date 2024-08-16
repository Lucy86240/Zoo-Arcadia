//ouverture / fermeture de la liste de popularité (avec mise en page spéciale des tuiles)

const icon = document.getElementById('statsTile');
const textStat = icon.querySelector('span')
const title = document.getElementById('titleStats')
const ul = document.getElementById('stats').querySelector('ul');
let icons = document.getElementById('tiles')

let tiles = document.querySelectorAll('.js-tile')
const newtiles = document.querySelectorAll('.js-tile')
let deplace = document.querySelector('.js')

actif = false;
icon.addEventListener('click',()=>{
    if(actif==false){
        textStat.innerHTML = "Moins de popularité"
        title.classList.remove('none');
        ul.classList.remove('none');
        actif = true;
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
        textStat.innerHTML = "Plus de popularité"
        title.classList.add('none');
        ul.classList.add('none');
        actif = false;
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

