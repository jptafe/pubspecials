/* EVENTS */
window.addEventListener("resize", unCheck);
document.getElementById('contentstuff').addEventListener('click', unCheck);

var forms = document.getElementsByTagName('form');
for(var loop = 0;loop<forms.length;loop++) {
    forms[loop].addEventListener('submit', function(evt) {
        var errorCode = checkSubmit(this);
        if(errorCode == true) {
            evt.target.lastElementChild.value = 'Loading...';
            doSubmit(evt);
        } else {
            evt.target.lastElementChild.value = 'Error';
            document.getElementById('error').innerHTML = errorCode;
            evt.preventDefault();
        }
    });
}

var requiredFields = document.getElementsByTagName('input');
for(var loop = 0;loop<requiredFields.length;loop++) {
    if(requiredFields[loop].hasAttribute('required')) {
        requiredFields[loop].addEventListener('change', function(evt) {
            if(checkAllFields(evt.target.parentElement) == true) {
                evt.target.parentElement.lastElementChild.value = 'Submit';
            } else {
                evt.target.parentElement.lastElementChild.value = 'Error';
            }
        });
    }
}

var alertBoxes = document.getElementsByClassName('alert');
for(var loop = 0;loop<alertBoxes.length;loop++) {
    alertBoxes[loop].firstElementChild.addEventListener('click', function(evt) {
        clearMessage(evt.target.parentElement);
    });
}

function unCheck() {
    document.getElementById('hamburgercheck').checked = false;
}

/* FORM VALIDATION */
function checkSubmit(thisForm) {
    var checkFields = thisForm.childNodes;
    for(loop = 0;loop < checkFields.length;loop++) {
        if(checkFields[loop].nodeName == 'INPUT') {
            if(checkFields[loop].hasAttribute('required')) {    
                if(checkFields[loop].value == '') {
                    checkFields[loop].focus();
                    return checkFields[loop].getAttribute('title');
                } else {
                    return checkAllFields(thisForm);
                }
            }
        }
    }
}
function checkAllFields(thisForm) {
    var checkFields = thisForm.childNodes;
    for(loop = 0;loop < checkFields.length;loop++) {
        if(checkFields[loop].nodeName == 'INPUT') {
            if(checkFields[loop].hasAttribute('required')) {                
                if(checkInputElement(checkFields[loop]) == false) {
                    checkFields[loop].focus();
                    return false;
                }
            }
        }
    }
    return true;
}
function checkInputElement(inputField) {
    if(inputField.checkValidity() || inputField.value == '') {
        return true;
    } else {
        return false;
    }
}
function doSubmit(submitForm) {
    submitForm.preventDefault(); 
    return false;
}
function clearForm() {
    
}
function clearMessage(targetElement) {
    targetElement.style.display = 'none';
}
function showMessage(targetElement) {
    targetElement.style.display = 'block';
}
