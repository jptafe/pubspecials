window.onload = function(e) {

    // register Search events:
    document.getElementById("search_radius").addEventListener("click", function() {getLoc(1)});
    document.getElementById("search_radius_distance").addEventListener("change", function() {getLoc(this.value)});
    document.getElementById("search_postcode").addEventListener("change", function() {searchPostcode(this.value)});
    document.getElementById("search_recent").addEventListener("click", function() {searchOrderBy('recent')});
    document.getElementById("search_popular").addEventListener("click", function() {searchOrderBy('popular')});

    $('#dob').datepicker({
        format: 'yyyy/mm/dd',
        startDate: '-110y',
        endDate: '-18y'
    });
};

function getLoc(range) {
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var link = 'index_ws.php?catid=near&range=' + range + '&currentlat=' + position.coords.latitude + '&currentlong=' + position.coords.longitude;
            $('#altdiv').html('loading...');
            $('#altdiv').load(link);
            console.log('lat:' + position.coords.latitude + ' long:' + position.coords.longitude);
        });
    }
}
function searchPostcode(pcode) {
    if(pcode.length == 4 && !isNaN(pcode)) {
        var link = 'index_ws.php?catid=postcode&postcode=' + pcode;
        $('#altdiv').html('loading...');
        $('#altdiv').load(link);
    }
}
function searchOrderBy(urlval) {
    $('#altdiv').html('loading...');
    $('#altdiv').load('index_ws.php?catid=' + urlval);
}
