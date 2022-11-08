let getId = document.querySelectorAll('#tracks');
let trackIndex;
let homebutton= document.getElementById('homeButton');
let searchbutton= document.getElementById('searchButton');
let playlistbutton= document.getElementById('playlistButton');
let searchbar= document.getElementById('search-bar');
let addButton = document.querySelectorAll('#add-button');
let header = document.querySelector('header');

homebutton.addEventListener('click',deleteCookie);
searchbutton.addEventListener('click',deleteCookie);
playlistbutton.addEventListener('click',deleteCookie);
window.addEventListener("scroll", getScrollY);
if(!(searchbar == null)){
    searchbar.addEventListener('click',deleteCookie);
}

Array.from(getId).forEach(element => {
    element.addEventListener('click', () => executeAction(element), true);
    // a flag true é para utilizar a fase de capturing e nao de bubbling (padrao);
});
Array.from(addButton).forEach(element => {
    element.addEventListener('click', deleteCookie, true);
    // a flag true é para utilizar a fase de capturing e nao de bubbling (padrao);
});

// todas as funções utilizadas estão abaixo
    // GET TRACK ID OF THE SELECTED LINE
function executeAction(e){
    trackIndex = e.getAttribute('value');
    document.cookie = "selectedIndex=" + trackIndex;
    document.location.reload();  
}

    // DELETE COOKIE INFO THAT IS NO MORE USEFUL AT THE MOMENT
function deleteCookie(){
    document.cookie = "selectedIndex= ; expires=Thu, 01 Jan 1970 00:00:00 UTC;";   
}

    // GET Y AXIS VALUE ACCORDING TO THE WINDOW
function getScrollY(){
    let scrollY = window.scrollY;
    
    if(scrollY > 60){
        header.style.cssText = "background-color: rgba(0, 0, 0, 0.9); transition: background-color 0.3s ease";
    }
    else {
        header.style.cssText = "background-color: none; transition: background-color 0.3s ease";
    }
}

