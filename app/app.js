/* EVENTS */
window.addEventListener("resize", unCheck);
document.getElementById('contentstuff').addEventListener('click', unCheck);

document.getElementById('suburbpost').addEventListener('keyup', function(evt) {
    console.log(evt.srcElement.value);
    if(document.getElementById('suburbpost').checkValidity()) {
        var result = AJAXsearchSuburb(evt.srcElement.value);
    }
});

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

document.getElementById('password1').addEventListener('change', checkPasswordsMatch);
document.getElementById('password2').addEventListener('change', checkPasswordsMatch);

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
        if(checkFields[loop].nodeName == 'SELECT') {
            if(checkFields[loop].hasAttribute('required')) {    
                if(checkFields[loop].value == 'choose') {
                    checkFields[loop].focus();
                    checkFields[loop].setCustomValidity('must choose one');
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
function checkPasswordsMatch() {
    if(document.getElementById('password1').value != document.getElementById('password2').value) {
        document.getElementById('password1').setCustomValidity('Passwords don\'t match');
        document.getElementById('password2').setCustomValidity('Passwords don\'t match');
    } else {
        document.getElementById('password1').setCustomValidity('');
        document.getElementById('password2').setCustomValidity('');
    }
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
function AJAXsearchSuburb(dataField) {
    fetch('../api/ws.php?catid=postburb&locale=' + dataField)
        .then(
            function(response) {
                if (response.status !== 200) {
                    console.log('Looks like there was a problem. Status Code: ' + response.status);
                }
                response.json().then(function(data) {
                    if(data.length > 0) {
                        document.getElementById('suburbpostlist').innerHTML = '';
                        for(loop = 0;loop<data.length;loop++) {
                            var newElem = document.createElement('option');
                            newElem.setAttribute('value', data[loop].suburb);
                            newElem.innerHTML = data[loop].postcode + ' ' + data[loop].suburb;
                            document.getElementById('suburbpostlist').appendChild(newElem);
                        }
                    } else {
                        document.getElementById('suburbpostlist').innerHTML = '';
                    }
                });
            }
        )
        .catch(function(err) {
            console.log('Fetch Error :-S', err);
        }
    );
    return false;
}