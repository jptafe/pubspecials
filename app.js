/* CONSTANTS */
var d = new Date();
var weekday = new Array(7);
weekday[0] =  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";
console.log(weekday[d.getDay()]);

/* FACEBOOK */
window.fbAsyncInit = function() {
    FB.init({
        appId      : '335876946985539',
        cookie     : true,
        xfbml      : true,
        version    : 'v3.1'
    });

    FB.getLoginStatus(function(response) {
        if(response.status == 'not_authorized') {
            localStorage.setItem('authenticated', 'false');
            disableButtons();
        }
        if(response.status == 'connected') {
            AJAXVerifyFBAuthentication(response.authResponse.accessToken, response.authResponse.userID);
        }
    });
};
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
function checkLoginState() {
    FB.getLoginStatus(function(response) {
        console.log(response);
    });
}



/* PERSISTENT STORAGE */
if(localStorage.getItem('authenticated') === null) {
    localStorage.setItem('authenticated', 'false');
}
if(localStorage.getItem('currentRadius') === null) {
    localStorage.setItem('currentRadius', 1);
}
document.getElementById('suburbpost_radius').value = localStorage.getItem('currentRadius');
if(localStorage.getItem('currentSuburb') === null) {
    localStorage.setItem('currentSuburb', '');
} else {
    document.getElementById('suburbpost').value = localStorage.getItem('currentSuburb');
}
if (localStorage.getItem('currentState') === null) {
    localStorage.setItem('currentState', '');
} else {
    document.getElementById('suburbpost_state').value = localStorage.getItem('currentState');
}
if (localStorage.getItem('currentPostcode') === null) {
    localStorage.setItem('currentPostcode', '');
} else {
    document.getElementById('suburbpost_post').value = localStorage.getItem('currentPostcode');
}
if (localStorage.getItem('currentLat') === null) {
    localStorage.setItem('currentLat', '');
} else {
    document.getElementById('suburbpost_lat').value = localStorage.getItem('currentLat');
}
if (localStorage.getItem('currentLong') === null) {
    localStorage.setItem('currentLong', '');
} else {
    document.getElementById('suburbpost_long').value = localStorage.getItem('currentLong');
}
if (localStorage.getItem('currentSearchOrder') === null) {
    localStorage.setItem('currentSearchOrder', 'recent');
    document.getElementById('suburbpost_recent').classList.add('btnsel');
} else {
    if(localStorage.getItem('currentSearchOrder') == 'recent') {
        document.getElementById('suburbpost_recent').classList.add('btnsel');
    }
    if(localStorage.getItem('currentSearchOrder') == 'views') {
        document.getElementById('suburbpost_viewed').classList.add('btnsel');
    }
    if(localStorage.getItem('currentSearchOrder') == 'rated') {
        document.getElementById('suburbpost_popular').classList.add('btnsel'); 
    }
}
if(localStorage.getItem('currentLong') == '' && localStorage.getItem('currentLat') == '') {
    fetch('api/ws.php?catid=locforip')
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                console.log(data);
                if(data.hasOwnProperty('suburb')){
                    if(localStorage.getItem('currentSuburb') == '') {
                        localStorage.setItem('currentSuburb', data.suburb);
                        document.getElementById('suburbpost').value = data.suburb;
                    }
                }
                if(data.hasOwnProperty('state')){
                    if(localStorage.getItem('currentState') == '') {
                        localStorage.setItem('currentState', data.state);
                        document.getElementById('suburbpost_state').value = data.state;
                    }
                }
                if(data.hasOwnProperty('postcode')){
                    if(localStorage.getItem('currentPostcode') == '') {
                        localStorage.setItem('currentPostcode', data.postcode);
                        document.getElementById('suburbpost_post').value = data.postcode;
                    }            
                }
                if(data.hasOwnProperty('lat') && data.hasOwnProperty('long')){
                    if(localStorage.getItem('currentLat') == '') {
                        localStorage.setItem('currentLat', data.lat);
                        document.getElementById('suburbpost_lat').value = data.lat;
                    }
                    if(localStorage.getItem('currentLong') == '') {
                        localStorage.setItem('currentLong', data.long);
                        document.getElementById('suburbpost_long').value = data.long;
                    }
                }
                if(localStorage.getItem('currentLat') == '' && localStorage.getItem('currentLong') == '') {
                    showMessage('We don\'t know where you are, please search for a pub');
                } else {
                    AJAXpubsWithGPS();
                }
            });
        }
    )
    .catch(function(err) {
        console.log('Fetch Error :-S', err);
    });
} else {
    AJAXpubsWithGPS();
}


/* EVENTS */
document.getElementById('suburbpost').addEventListener('keyup', function(evt) {
    if(document.getElementById('suburbpost').checkValidity()) {
        document.getElementById('suburbgps').removeAttribute('class');
        if(evt.srcElement.value.indexOf(',') > -1) {
            var dataFieldArray = evt.srcElement.value.split(',');
            document.getElementById('suburbpostlist').innerHTML = '';
            document.getElementById('suburbpost').value = dataFieldArray[1];
            document.getElementById('suburbpost_post').value = dataFieldArray[0];
            document.getElementById('suburbpost_state').value = dataFieldArray[2];
            document.getElementById('suburbpost_lat').value = dataFieldArray[3];
            document.getElementById('suburbpost_long').value = dataFieldArray[4];
            rememberSuburbPostState(dataFieldArray[1], dataFieldArray[0], dataFieldArray[2]);
            rememberLatLong(dataFieldArray[3], dataFieldArray[4]);
            AJAXpubsWithGPS();
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
            showError(errorCode);
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
document.getElementById('suburbpost_radius').addEventListener('change', rememberRadius);
document.getElementById('suburbgps').addEventListener('click', AJAXgetSuburbFromGPS);
document.getElementById('suburbpost_recent').addEventListener('click', setSearchOrderRecent);
document.getElementById('suburbpost_viewed').addEventListener('click', setSearchOrderViewed);
document.getElementById('suburbpost_popular').addEventListener('click', setSearchOrderPopular);

var alertBoxes = document.getElementsByClassName('alert');
for(var loop = 0;loop<alertBoxes.length;loop++) {
    alertBoxes[loop].firstElementChild.addEventListener('click', function(evt) {
        hideMessage(evt.target.parentElement);
    });
}


/* GMAPS */
var geocoder = new google.maps.Geocoder;
function getAddressFromGPS() {
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
              //radius: position.coords.accuracy
            var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
            geocoder.geocode({'location': latlng}, function(results, status) {
                if(status === 'OK') {
                    if(results[0]) {
                        document.getElementById('pubaddress').value = results[0].formatted_address;

                        var addr_pieces = results[0].formatted_address.split(',');

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

                        document.getElementById('publat').value = position.coords.latitude;
                        document.getElementById('publong').value = position.coords.longitude;

                        rememberLatLong(position.coords.latitude, position.coords.longitude);
                    }
                }
            });
        });
    }
}
var places = new google.maps.places.Autocomplete(document.getElementById('pubaddress'));
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
    // All POSTs need unique AJAX functions 
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
function enableButtons() {
    document.getElementById('FBButton').style.display = 'none';
    document.getElementById('addpub_button').removeAttribute('disabled');
}
function disableButtons() {
    document.getElementById('FBButton').style.display = 'inline';
    document.getElementById('addpub_button').setAttribute('disabled', '');
}
/* PERSISTENCE EVENTS */
function rememberRadius() {
    localStorage.setItem('currentRadius', document.getElementById('suburbpost_radius').value); 
    AJAXpubsWithGPS();
}
function rememberSuburbPostState(suburb, postcode, state) {
    localStorage.setItem('currentSuburb', suburb);
    localStorage.setItem('currentState', postcode);
    localStorage.setItem('currentPostcode', state);
}
function rememberLatLong(latitude, longitude) {
    localStorage.setItem('currentLat', latitude);
    localStorage.setItem('currentLong', longitude);
}
function setSearchOrderRecent() {
    localStorage.setItem('currentSearchOrder','recent');
    document.getElementById('suburbpost_recent').classList.add('btnsel');
    document.getElementById('suburbpost_viewed').removeAttribute('class');
    document.getElementById('suburbpost_popular').removeAttribute('class');
    AJAXpubsWithGPS();

}
function setSearchOrderViewed() {
    localStorage.setItem('currentSearchOrder', 'views');
    document.getElementById('suburbpost_viewed').classList.add('btnsel');
    document.getElementById('suburbpost_recent').removeAttribute('class');
    document.getElementById('suburbpost_popular').removeAttribute('class');
    AJAXpubsWithGPS();
}
function setSearchOrderPopular() {
    localStorage.setItem('currentSearchOrder', 'rated');
    document.getElementById('suburbpost_popular').classList.add('btnsel'); 
    document.getElementById('suburbpost_viewed').removeAttribute('class');
    document.getElementById('suburbpost_recent').removeAttribute('class');
    AJAXpubsWithGPS();
}


/* AJAX */
function AJAXVerifyFBAuthentication(FBToken, FBUID) {
    fetch('api/ws.php?catid=regFBuser&token=' + FBToken + '&uid=' + FBUID)
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                if(data.length > 0) {
                    if(data[0].auth == 'true') {
                        localStorage.setItem('authenticated', data[0].verifiedToken);
                        enableButtons();
                        return true;
                    } else {
                        localStorage.setItem('authenticated', 'false');
                        disableButtons();
                        showMessage('Login to Facebook to be able to Add Pubs, Specials or comments');
                        return false;
                    }
                } else {
                    localStorage.setItem('authenticated', 'false');
                    disableButtons();
                    return false;
                }
            });
        }
    )
    .catch(function(err) {
        console.log('Fetch Error :-S', err);
    });
    return false;
}
function AJAXsetAllThumbsForUser(ajaxedPubs) {
    // all the thumbbed checkboxes for all the displayed 
    // specials need to be set to whatever the user has already touched
    var haystack = [];
    for(var pub in ajaxedPubs) {
        if(typeof ajaxedPubs[pub].specials != 'undefined') {
            for(var special in ajaxedPubs[pub].specials) {
                haystack.push(ajaxedPubs[pub].specials[special].id);
            }
        }
    }
    if(haystack.length > 0) {
        var url = 'api/ws.php?catid=userthumbs&uid=' + localStorage.getItem('authenticated');
        fetch(url)
       .then(
            function(response) {
                if (response.status !== 200) {
                    console.log('Looks like there was a problem. Status Code: ' + response.status);
                }
                response.json().then(function(data) {
                    if(data.length > 0) {
                        for(var loop = 0;loop < data.length;loop++) {
                            if(haystack.includes(data[loop].special_id)) {
                                if(data[loop].rating == 'UP') {
                                    document.getElementById('unfavourite' + data[loop].special_id).checked = false;
                                    document.getElementById('makefavourite' + data[loop].special_id).checked = true;
                                } 
                                if(data[loop].rating == 'DOWN') {
                                    document.getElementById('makefavourite' + data[loop].special_id).checked = false;
                                    document.getElementById('unfavourite' + data[loop].special_id).checked = true;
                                }
                            }
                        }
                        return true;
                    } else {
                        return false;
                    }
                });
            }
        )
        .catch(function(err) {
            console.log('Fetch Error :-S', err);
        });
    }
    return false;
}
function AJAXThumbbing(theCheckbox, specialID, direction) {
    var allUp = parseInt(document.getElementById('allthumbsup' + specialID).innerHTML);
    var allDown = parseInt(document.getElementById('allthumbsdown' + specialID).innerHTML)
    if(direction == 'UP') {
        if(theCheckbox.checked == true) {
            var url = 'api/ws.php?catid=endorse&specialid=' + specialID + '&direction=' + 'UP';
            allUp++;
            if(document.getElementById('unfavourite' + specialID).checked == true) {
                document.getElementById('unfavourite' + specialID).checked = false;
                allDown--;
            }
        } else {
            var url = 'api/ws.php?catid=removeendorse&specialid=' + specialID + '&direction=' + 'UP';
            allUp--;
        }
    }
    if(direction == 'DOWN') {
        if(theCheckbox.checked == true) {
            var url = 'api/ws.php?catid=endorse&specialid=' + specialID + '&direction=' + 'DOWN';
            allDown++;
            if(document.getElementById('makefavourite' + specialID).checked == true) {
                allUp--;
                document.getElementById('makefavourite' + specialID).checked = false;
            }
        } else {
            var url = 'api/ws.php?catid=removeendorse&specialid=' + specialID + '&direction=' + 'DOWN';
            allDown--;
        }
    }
    document.getElementById('allthumbsup' + specialID).innerHTML = allUp;
    document.getElementById('allthumbsdown' + specialID).innerHTML = allDown;
    
    fetch(url)
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                if(data.length > 0) {
                    if(data.error == 'true') {
                        console.log(data);
                    }
                    return true;
                } else {
                    return false;
                }
            });
        }
    )
    .catch(function(err) {
        console.log('Fetch Error :-S', err);
    });
    return false;
}
function AJAXgetSuburbFromGPS() {
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            if(parseFloat(position.coords.latitude) && parseFloat(position.coords.longitude)) {
                var url = 'api/ws.php?catid=listburbgps&lat=' + position.coords.latitude +
                          '&long=' + position.coords.longitude;
                document.getElementById('suburbpost_lat').value = position.coords.latitude;
                localStorage.setItem('currentLat', position.coords.latitude);
                document.getElementById('suburbpost_long').value = position.coords.longitude;
                localStorage.setItem('currentLong', position.coords.longitude);
                localStorage.setItem('GPSAccess', 'true');
                document.getElementById('suburbgps').classList.add('btnsel');
                fetch(url)
                .then(
                    function(response) {
                        if (response.status !== 200) {
                            console.log('Looks like there was a problem. Status Code: ' + response.status);
                        }
                        response.json().then(function(data) {
                            if(data.length > 0) {
                                if(data.length > 0) {
                                    document.getElementById('suburbpost').value = data[0].suburb;
                                    localStorage.setItem('currentSuburb', data[0].suburb);
                                    document.getElementById('suburbpost_post').value = data[0].postcode;
                                    localStorage.setItem('currentPostcode', data[0].postcode);
                                    document.getElementById('suburbpost_state').value = data[0].state;
                                    localStorage.setItem('currentState', data[0].state);
                                    AJAXpubsWithGPS();
                                }
                            } else {
                                document.getElementById('suburbpost').value = 'not found. Increase Area';
                                document.getElementById('suburbpost_post').value = '';
                                document.getElementById('suburbpost_state').value = '';
                            }
                        });
                    }
                )
                .catch(function(err) {
                    console.log('Fetch Error :-S', err);
                });
            } /* if */
        });
    }
}
function AJAXsearchSuburb(dataField) {
    fetch('api/ws.php?catid=postburb&locale=' + dataField)
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
function AJAXpubsWithGPS() {
    var url = 'api/ws.php?catid=near&lat=' + localStorage.getItem('currentLat') + 
                '&long=' + localStorage.getItem('currentLong') + '&radius=' + 
                localStorage.getItem('currentRadius') + '&order=' +
                localStorage.getItem('currentSearchOrder');
    fetch(url)
    .then(
        function(response) {
            if (response.status !== 200) {
                console.log('Looks like there was a problem. Status Code: ' + response.status);
            }
            response.json().then(function(data) {
                if(data[0].error == 'no data') {
                    document.getElementById("publist").innerHTML = '<h1>No Pubs Found!</h1>';
                    showWarning('No Pubs Found, Consider searching again OR widening radius');
                } else {
                    var pubTemplateHTML = document.getElementById("template-pub").innerHTML;
                    var specialTemplateHTML = document.getElementById("template-special").innerHTML;
                    var secialCommentTemplateHTML = document.getElementById("template-special-comments").innerHTML;
                    var pubHtml = '';
                    for(var key in data) {
                        pubHtml += pubTemplateHTML.replace(/{{views}}/g, data[key]['viewcount'])
                                                .replace(/{{name}}/g, data[key]['name'])
                                                .replace(/{{calc_score_id}}/g, 'calcscore' + data[key]['id'])
                                                .replace(/{{desc}}/g, data[key]['description'])
                                                .replace(/{{addr}}/g, data[key]['address'])
                                                .replace(/{{img}}/g, data[key]['postcode'])
                                                .replace(/{{id}}/g, data[key]['id']);
                        if (typeof data[key].specials !== 'undefined') {
                            for(var special in data[key].specials) {
                                pubHtml += specialTemplateHTML.replace(/{{up}}/g, data[key].specials[special]['upcount'])
                                                              .replace(/{{id}}/g, data[key].specials[special]['id'])
                                                              .replace(/{{dow}}/g, data[key].specials[special]['day_of_week'])
                                                              .replace(/{{down}}/g, data[key].specials[special]['downcount'])
                                                              .replace(/{{spec_title}}/g, data[key].specials[special]['special_text'])
                                                              .replace(/{{tod}}/g, data[key].specials[special]['time_of_day'])
                                                              .replace(/{{pubid}}/g, data[key]['id']);
                                if(typeof data[key].specials[special].comments !== 'undefined') {
                                    for(var comment in data[key].specials[special].comments) {
                                        pubHtml += secialCommentTemplateHTML.replace(/{{msg}}/g, data[key].specials[special].comments[comment].comment);
                                    }
                                }
                                pubHtml +=  document.getElementById('template-special-footer').innerHTML;
                            }
                        }
                        pubHtml +=  document.getElementById('template-special-footer').innerHTML;
                        pubHtml +=  document.getElementById('template-pub-footer').innerHTML;
                    }
                    document.getElementById("publist").innerHTML = pubHtml;
    
                    for(var key in data) {
                        if(typeof data[key].specials == 'undefined') {
                            document.getElementById('calcscore' + data[key]['id']).innerHTML = '0';
                        } else {
                            var calc_score = 0;
                            for(var special in data[key].specials) {
                                calc_score = calc_score + parseInt(data[key].specials[special].upcount);
                                calc_score = calc_score - parseInt(data[key].specials[special].downcount);
                            }
                            document.getElementById('calcscore' + data[key]["id"]).innerHTML = calc_score;
                        }
                    }
                    if(localStorage.getItem('authenticated') != 'false') {
                        var thumbsUp = document.getElementsByClassName('makefavourite');
                        var thumbsDown = document.getElementsByClassName('unfavourite');
                        var specialComment = document.getElementsByClassName('addspecialcomment_button');
                        var specialButton = document.getElementsByClassName('addspecial_button');
                        
                        for(loop = 0;loop<thumbsUp.length;loop++) {
                            thumbsUp[loop].removeAttribute('disabled');
                        }
                        for(loop = 0;loop<thumbsDown.length;loop++) {
                            thumbsDown[loop].removeAttribute('disabled');
                        }
                        for(loop = 0;loop<specialButton.length;loop++) {
                            specialButton[loop].removeAttribute('disabled');
                        }
                        for(loop = 0;loop<specialComment.length;loop++) {
                            specialComment[loop].removeAttribute('disabled');
                            specialComment[loop].setAttribute('placeholder', 'Comment on this');
                        }
                        
                        AJAXsetAllThumbsForUser(data);
                    }
                }
            });
        }
    )
    .catch(function(err) {
        console.log('Fetch Error :-S', err);
    })
}
/* ALERTS */
function hideMessage(targetElement) {
    targetElement.style.display = 'none';
}
function showError(error) {
    document.getElementById('error').innerHTML = error;
    document.getElementById('error').parentElement.style.display = 'block';
    setTimeout(hideAlerts, 8000);
}
function showMessage(message) {
    document.getElementById('message').innerHTML = message;
    document.getElementById('message').parentElement.style.display = 'block';
    setTimeout(hideAlerts, 8000);
}
function showWarning(warning) {
    document.getElementById('notice').innerHTML = warning;
    document.getElementById('notice').parentElement.style.display = 'block';
    setTimeout(hideAlerts, 8000);
}
function hideAlerts() {
    var allAlerts = document.getElementsByClassName('alert');                    
    for(loop = 0;loop<allAlerts.length;loop++) {
        allAlerts[loop].removeAttribute('style');
    }
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