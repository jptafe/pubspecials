/* EVENTS */
window.addEventListener("resize", unCheck);
document.getElementById('contentstuff').addEventListener('click', unCheck);

document.getElementById('suburbpost').addEventListener('keyup', function(evt) {
    if(document.getElementById('suburbpost').checkValidity()) {
        if(evt.srcElement.value.indexOf(',') > -1) {
            var dataFieldArray = evt.srcElement.value.split(',');
            document.getElementById('suburbpostlist').innerHTML = '';
            document.getElementById('suburbpost').value = dataFieldArray[1];
            document.getElementById('suburbpost_post').value = dataFieldArray[0];
            document.getElementById('suburbpost_state').value = dataFieldArray[2];
            document.getElementById('suburbpost_lat').value = dataFieldArray[3];
            document.getElementById('suburbpost_long').value = dataFieldArray[4];
            var result = AJAXpubsWithGPS(document.getElementById('suburbpost_lat').value, 
                                         document.getElementById('suburbpost_long').value);
        } else {
            document.getElementById('suburbpost_post').value = '';
            document.getElementById('suburbpost_state').value = '';
            document.getElementById('suburbpost_lat').value = '';
            document.getElementById('suburbpost_long').value = '';
            var result = AJAXsearchSuburb(evt.srcElement.value);
        }
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
document.getElementById('specialneverexpires').addEventListener('change', disableSpecialExpires);
document.getElementById('pubgps').addEventListener('click', getAddressFromGPS);

var alertBoxes = document.getElementsByClassName('alert');
for(var loop = 0;loop<alertBoxes.length;loop++) {
    alertBoxes[loop].firstElementChild.addEventListener('click', function(evt) {
        hideMessage(evt.target.parentElement);
    });
}

function unCheck() {
    document.getElementById('hamburgercheck').checked = false;
}

/* GMAPS */

var places = new google.maps.places.Autocomplete(document
    .getElementById('pubaddress'));
places.setComponentRestrictions(
    {'country': ['au']});
google.maps.event.addListener(places, 'place_changed', function() {
    var place = places.getPlace();
    var address = place.formatted_address;
    var addr_pieces = address.split(',');

    var count=addr_pieces.length;
    document.getElementById('pubnostreet').value = addr_pieces[count-3]; 
    
    var sub_state = addr_pieces[count-2].trim();
    var sub_stage_pieces = sub_state.split(' ');
    var subcount=sub_stage_pieces.length;

    var sub_concat_string;
    if(subcount-2 == 3) {
        sub_concat_string = sub_stage_pieces[0].toUpperCase() + ' ' + sub_stage_pieces[1].toUpperCase() + ' ' + sub_stage_pieces[2].toUpperCase();
    } else if(subcount-2 == 2) {
        sub_concat_string = sub_stage_pieces[0].toUpperCase() + ' ' + sub_stage_pieces[1].toUpperCase();
    } else {
        sub_concat_string = sub_stage_pieces[0].toUpperCase();
    }
    document.getElementById('pubsuburb').value = sub_concat_string;

    document.getElementById('pubstate').value = sub_stage_pieces[subcount-2];
    document.getElementById("pubpcode").value = sub_stage_pieces[subcount-1];

    document.getElementById('publat').value = place.geometry.location.lat();
    document.getElementById('publong').value = place.geometry.location.lng();

    document.getElementById("pubaddress").value = address;
});


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
    if(document.getElementById('password1').value.length > 0 && 
       document.getElementById('password2').value.length > 0) {
        if(document.getElementById('password1').value != document.getElementById('password2').value) {
            document.getElementById('password1').setCustomValidity('Passwords don\'t match');
            document.getElementById('password2').setCustomValidity('Passwords don\'t match');
        } else {
            document.getElementById('password1').setCustomValidity('');
            document.getElementById('password2').setCustomValidity('');
        }
    }
}
document.getElementById('specialneverexpires').checked = true;
function disableSpecialExpires() {
    if(document.getElementById('specialneverexpires').checked) {
        document.getElementById('specialexpires').disabled = true;
        document.getElementById('specialexpires').value = '2030-01-01';

    } else {
        document.getElementById('specialexpires').disabled = false;
        document.getElementById('specialexpires').value = '';

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

/* AJAX */
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
                        var attValue = data[loop].postcode + ',' + data[loop].suburb + ',' + 
                            data[loop].state + ',' + data[loop].lat + ',' + data[loop].lon;
                        newElem.setAttribute('value', attValue);
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
    });
    return false;
}

function AJAXpubsWithGPS(lat, long) {

}
/* 3rd Party Components */
var dateFormat = "yy-mm-dd",
    from = $('#specialbegins').datepicker({
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        minDate: '+0D',
        maxDate: '+10Y',
        numberOfMonths: 1
    })
    .on('change', function() {
        to.datepicker( "option", "minDate", this.value);
    })
    to = $('#specialexpires').datepicker({
        changeMonth: true,
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        minDate: '+0D',
        maxDate: '+10Y',
        numberOfMonths: 1
    })
    .on('change', function() {
        from.datepicker('option', 'maxDate', this.value)
        console.log('foo');
    });
    document.getElementById('specialbegins').value = new Date().toISOString().substr(0, 10);
/* Location */

function getAddressFromGPS() {
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var GPSlink = 'location=' + position.coords.latitude + ',' + position.coords.longitude;
            var locationURL = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?' + GPSlink +'&radius=40&key=AIzaSyCvC1ToQXBS5fGNEY1w0pPOkZb7NUkImVc';
            
            fetch(locationURL)
            .then(
                function(response) {
                    if (response.status !== 200) {
                        console.log('Looks like there was a problem. Status Code: ' + response.status);
                    }
                    response.json().then(function(data) {
                        console.log(data);
                    });
                }
            )
            .catch(function(err) {
                console.log('Fetch Error :-S', err);
            });
        });
    } else {
        return false;
    }
}