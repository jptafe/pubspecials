/* EVENTS */
window.addEventListener("resize", unCheck);
document.getElementById('contentstuff').addEventListener('click', unCheck);

var forms = document.getElementsByTagName('form');
for(var loop = 0;loop<forms.length;loop++) {
    forms[loop].addEventListener('submit', function(evt) {
        var errorCode = checkSubmit(evt.target);
        if(errorCode == true) {
            evt.target.lastElementChild.value = 'Loading...';
            disableFields(evt.target.children);
            hideMessage(document.getElementById('error').parentElement);
            doSubmit(evt);
            clearForm(evt.target.children); // Make Sure you do this AFTER AJAX is done
            enableFields(evt.target.children);  // Make Sure you do this AFTER AJAX is done
            evt.target.lastElementChild.value = 'Submit';  //          This goes into AJAX...
        } else {
            evt.target.lastElementChild.value = 'Error';
            document.getElementById('error').innerHTML = errorCode;
            showMessage(document.getElementById('error').parentElement);
            evt.preventDefault();
        }
    });
}

var requiredFields = document.getElementsByTagName('input');
for(var loop = 0;loop<requiredFields.length;loop++) {
    if(requiredFields[loop].hasAttribute('required')) {
        requiredFields[loop].addEventListener('change', function(evt) {
            if(evt.target.parentElement.lastElementChild.value != 'Loading...') {
                if(checkAllFields(evt.target.parentElement) == true) {
                    evt.target.parentElement.lastElementChild.value = 'Submit';
                } else {
                    evt.target.parentElement.lastElementChild.value = 'Error';
                }
            }
        });
    }
}

var alertBoxes = document.getElementsByClassName('alert');
for(var loop = 0;loop<alertBoxes.length;loop++) {
    alertBoxes[loop].firstElementChild.addEventListener('click', function(evt) {
        hideMessage(evt.target.parentElement);
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
                    var returnVal = checkFields[loop].name + ': ' + checkFields[loop].title;
                    return returnVal;
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
function clearForm(submittedForm) {
    for(loop = 0;loop < submittedForm.length;loop++) {
        if(submittedForm[loop].nodeName == 'INPUT') {
            if(submittedForm[loop].hasAttribute('required')) {    
                submittedForm[loop].value = '';
            }
        }
    }
}
function disableFields(fieldsToDisable) {
    for(loop = 0;loop < fieldsToDisable.length;loop++) {
        if(fieldsToDisable[loop].nodeName == 'INPUT') {
            fieldsToDisable[loop].setAttribute('disabled', '');
        }
    }
}
function enableFields(fieldsToEable) {
    // ARE WE Re-Enabling TOO MUCH?
    for(loop = 0;loop < fieldsToEable.length;loop++) {
        if(fieldsToEable[loop].nodeName == 'INPUT') {
            fieldsToEable[loop].removeAttribute('disabled');
        }
    }
}
function hideMessage(targetElement) {
    targetElement.style.display = 'none';
}
function showMessage(targetElement) {
    targetElement.style.display = 'block';
}