<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script
            src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript"
            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCvC1ToQXBS5fGNEY1w0pPOkZb7NUkImVc&sensor=false&libraries=places"></script>
<script>
google.maps.event.addDomListener(window, 'load', function() {
    var places = new google.maps.places.Autocomplete(document
            .getElementById('uniqueaddr'));
    google.maps.event.addListener(places, 'place_changed', function() {
        var place = places.getPlace();
        var address = place.formatted_address;
        var  value = address.split(",");
        count=value.length;
        country=value[count-1];
        state=value[count-2];
        city=value[count-3];
        var z=state.split(" ");
   
        var lati = latitude;
        document.getElementById("latx").value = lati;
        var longi = longitude;
        document.getElementById("longy").value = longi;            
    });
});


        function processForm(formid) {
            $.ajax({
                type: "post",
                url: 'postprocess.php',
                data: $('#' + formid).serialize(),
                dataType: 'json',
                success: function (msg) {
                    $( "#postout" ).html( msg );
                }
            });
     
            return false;
        }
/*
Key TVLYHB3CRU8FJPWAK49Q
Secret 3XQRK8PE9GHAUMBCD6YV
*/
    </script>
</head>
<body>
    <form method="post" action="postprocess.php" id="postpub" target="thisframe" onsubmit="return processForm('postpub')" novalidate>
        <input type="hidden" name="insert" value="addpub">
        <input type="text" name="pub" placeholder="pub" id="" pattern="[0-9A-Za-z ]" class="validate" required>
        <input type="text" name="pubaddr" placeholder="pubaddr" id="uniqueaddr" pattern="[0-9A-Za-z ]" class="validate" required>
        <input type="text" name="pubpost" placeholder="pubpst" id="" pattern="[0-9A-Za-z ]" class="validate" required>
        <input type="text" name="lat" placeholder="latitude" id="" pattern="[0-9A-Za-z ]" class="validate" required>
        <input type="text" name="long" placeholder="longitude" id="" pattern="[0-9\.]" class="validate" required>
        <input type="submit" name="submit">
    </form>
    <form method="post" action="postprocess.php" id="postspec" target="thisframe" onsubmit="return processForm('postspec')" novalidate>
        <input type="hidden" name="insert" value="addspecial">
        <input type="text" name="special" placeholder="Special Text" id="" pattern="[0-9A-Za-z ]" class="validate" required>
        <input type="text" name="dow" placeholder="Day of Week" id="" pattern="[0-9A-Za-z ]" class="validate" required>
        <input type="text" name="tod" placeholder="Time of Day" id="" pattern="[0-9A-Za-z ]" class="validate" required>
        <input type="submit">
    </form>
    <iframe name="thisframe" height="0" width="0"></iframe>
    <div id="postout"></div>
    <div id="latx"></div>
    <div id="longy"></div>
</body>
</html>