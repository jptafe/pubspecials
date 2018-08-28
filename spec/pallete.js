window.onload = function() {
    window.addEventListener("resize", unCheck);
} 

function unCheck() {
    document.getElementById('hamburgercheck').checked = false;
}