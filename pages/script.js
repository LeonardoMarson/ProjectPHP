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

