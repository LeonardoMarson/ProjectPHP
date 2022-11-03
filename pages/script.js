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

