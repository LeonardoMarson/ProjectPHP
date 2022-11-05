// GET TRACK ID OF THE SELECTED LINE
let getId = document.querySelectorAll('#tracks');
let trackIndex;

Array.from(getId).forEach(element => {
    element.addEventListener('click', () => executeAction(element));
});

function executeAction(e){
    trackIndex = e.getAttribute('value');
    document.cookie = "selectedIndex=" + trackIndex;

    document.location.reload(); 
}

let startbutton= document.getElementById('startButton');
startbutton.addEventListener('click',deleteCookie);
function deleteCookie(){
    console.log('entrou');
    document.cookie = "selectedIndex= ; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    document.location.reload();
}
// GET Y AXIS VALUE ACCORDING TO THE WINDOW
let header = document.querySelector('header');
window.addEventListener("scroll", getScrollY);

function getScrollY(){
    let scrollY = window.scrollY;
    
    if(scrollY > 60){
        header.style.cssText = "background-color: rgba(0, 0, 0, 0.9); transition: background-color 0.3s ease";
    }
    else {
        header.style.cssText = "background-color: none; transition: background-color 0.3s ease";
    }
}

