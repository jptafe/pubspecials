window.onload = function() {
    window.addEventListener("resize", unCheck);
    document.getElementById('contentstuff').addEventListener('click', unCheck);
    
    var forms = document.getElementsByTagName('form');
    for(var loop = 0;loop<forms.length;loop++) {
        forms[loop].addEventListener('submit', function(evt) {
            console.log(evt);
            if(checkSubmit(this, evt.target.lastElementChild)) {
                evt.submit(); // Going to do AJAX, but pass submit button to turn off loading...
            } else {
                evt.preventDefault();
            }
        });
    }    
} 

function checkSubmit(form, submitButton) {
    submitButton.value = 'Loading...';
    return false;
}

function unCheck() {
    document.getElementById('hamburgercheck').checked = false;
}