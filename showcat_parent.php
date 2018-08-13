<html>
    <head>
        <style>
            #altdiv {
                width: 100%;
                background: lightblue; 
                border: 0;
            }
            li {
                display: inline-block;
                list-style: none;
            }
        </style>
        <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            function getLoc(range) {
                if(navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var link = 'showcat.php?catid=near&range=' + range + '&currentlat=' + position.coords.latitude + '&currentlong=' + position.coords.longitude;
                        $('#altdiv').html('loading...');
                        $('#altdiv').load(link);
                    });
                }
            }
            function postcode(pcode) {
                if(pcode.length == 4 && !isNaN(pcode)) {
                    var link = 'showcat.php?catid=postcode&postcode=' + pcode;
                    $('#altdiv').html('loading...');
                    $('#altdiv').load(link);
                }
            }
            function doAjax(urlval) {
                $('#altdiv').html('loading...');
                $('#altdiv').load('showcat.php?catid=' + urlval);
            }
        </script>
    </head>
    <body>
        <ul>
            <li>
                <li><a href="#" onclick="getLoc(1)">Search Radius</a></li>
                <select onchange="getLoc(this.value)">
                    <option value="1">1km</option>
                    <option value="5">5km</option>
                    <option value="10">10km</option>
                </select>
            </li>
            <li><input type="number" placeholder="pcode" size="4" width="4" max="9999" min="1000" maxlength="4" onchange="postcode(this.value)"></li>
            <li><a href="#" onclick="doAjax('recent')">recent</a></li>
            <li><a href="#" onclick="doAjax('popular')">popular</a></li>
        </ul>
        <div id="altdiv"></div>
    </body>
</html>
