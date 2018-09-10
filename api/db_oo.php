<?php
    class pubSpecial {
        public function __construct() {
            $conn = new PDO("mysql:host=localhost;dbname=pubspecials", 'root','');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        public function recentPubs($lat, $long, $radius) {
            $safe_lat = validate($lat, 'GPS');
            $safe_long = validate($long, 'GPS');
            $safe_radius = validate($radius, 'RADIUS');        
    
            if($safe_lat == false || $safe_long == false || $safe_radus == false) {
                return false;
            }
            $safe_radius = $safe_radius / 100;
            $sql = "
SELECT * FROM pub 
    INNER JOIN special ON special.pub_id = pub.id
        WHERE (pub.latitude - :radius) < :lat AND
            (pub.latitude + :radius) > :lat AND
            (pub.longitude - :radius) < :long AND
            (pub.longitude + :radius) > :long
                ORDER BY special.starts;
        ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':radius', $safe_radius, PDO::PARAM_INT, 3);
            $stmt->bindParam(':lat', $safe_lat);
            $stmt->bindParam(':long', $safe_long);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result) && sizeof($result) > 0) {
                return $result;
            } else {
                return false;
            }
        }
        public function popularPubs($lat, $long, $radius) {
            $sql = "
SELECT count(special_id) AS specialcount, special.special_text,
special.day_of_week, special.time_of_day, special.starts,
pub.name, pub.address, pub.postcode,
pub.latitude, pub.longitude 
    FROM rating 
        INNER JOIN special ON special.id = rating.special_id
            INNER JOIN pub ON pub.id = special.pub_id
            GROUP BY rating.special_id
                ORDER BY specialcount DESC
            ";
            return false;
        }
        public function specialsNowPubs($lat, $long, $radius) {
            $dow = date('l');
        }
        public function newPub($pubArray) {
            $clean_pubname = validate($pubArray['pubname'], 'PUBNAME');
            $clean_pubaddress = validate($pubArray['pubaddress'], 'PUBADDR');
            $clean_publat = validate($pubArray['lat'], 'GPS');
            $clean_publong = validate($pubArray['long'], 'GPS');
            $clean_postcode = validate($pubArray['pcode'], 'POSTCODE');

            if($clean_pubname == false || $clean_pubaddress == false || 
                    $clean_publat == false || $clean_publong == false ||
                    $clean_postcode == false) {
                return false;
            }
            $sql = "
INSERT INTO pub 
    (name, address, postcode, logo, latitude, longitude) 
        VALUES ( :pubname, :pubaddress, :pubpcode, NULL, :publat, :publong);";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pubname', $clean_pubname, PDO::PARAM_STR, 256);
            $stmt->bindParam(':pubaddress', $clean_pubaddress, PDO::PARAM_STR, 128);
            $stmt->bindParam(':pubpcode', $clean_postcode, PDO::PARAM_STR, 10);
            $stmt->bindParam(':publat', $clean_publat, PDO::PARAM_STR, 10);
            $stmt->bindParam(':publong', $clean_publong, PDO::PARAM_STR, 10);
            $res = $stmt->execute();
            if($res == true) {
                return true;
            } else {
                return false;
            }
        }
        public function newSpecial($specialArray) {
        }      
        public function getSpecialsForPub($pubID) {
        }
        public function invalidatePub($pubID) {
        }
        public function invalidateSpecial($specialID) {
        }
        public function thumbsUpPub($pubid) {
        } 
        public function thumbsDownPub($pubid) {
        } 
        public function thumbsUpSpecial($specialID) {
        }
        public function thumbsDownSpecial($specialID) {
        }
    }

    class locData {
        function __construct() {
            $conn = new PDO("mysql:host=localhost;dbname=pubdata", 'root','');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        public function suburbList($postcode) {
            $clean_suburb = validate($suburb_post, 'SUBURBPOST');
            if($clean_suburb == false) { 
                return false;
            }
            $sql = "
SELECT * FROM postcode_db 
    WHERE suburb LIKE :subpost 
        OR postcode LIKE :subpost";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':subpost', $clean_suburb, PDO::PARAM_STR, 8);
            $stmt->execute();
            $result = $stmt->fetchAll();
            if(is_array($result) && sizeof($result) > 0) {
                return $result;
            } else {
                return false;
            }
        }
        public function getCoordinatesForSuburb($suburb) {
            $loc = array('lat'=>-27.478150,'long'=>153.019693); return $loc;
        }
        public function getCoordinatesForIP($IP) {
            $loc = array('lat'=>-27.478150,'long'=>153.019693); return $loc;
        }
        public function getCoordinatesForPostcode() {
            $loc = array('lat'=>-27.478150,'long'=>153.019693); return $loc;
        }
        public function isInAustralia($IP) {
            $clean_IP = validate($IP, 'IP');
            if($clean_IP == false) {
                //database check for IP in subnet range of AU
                return false;
            }
        }
    }

function validate($value, $type) {
    $safe_value = strip_tags($value);
    $safe_value = trim($safe_value);
    $safe_value = stripslashes($safe_value);
    if($type == 'GPS') {
        if(is_float($safe_value)) {
            if($safe_value < 360 && $safe_value > -180) {
                return $safe_value;
            }
        }
    }
    if($type == 'PUBNAME') {
        return $safe_value;
    }
    if($type == 'PUBADDR') {
        return $safe_value;
    }
    if($type == 'RADIUS') {
        if(is_int($safe_value)) {
            if($safe_value < 100) {
                return $safe_value;
            }
        }
    }
    if($type == 'POSTCODE') {
        if(is_int($safe_value)) {
            if($safe_value < 9999) {
                return $safe_value;
            }
        }
    }
    if($type == 'IP') {
        if(ip2long($safe_value)) {
            return $safe_value;
        }
    }
    if($type == 'SUBURBPOST') {
        if(preg_match('/[A-Za-z09 \-]{2,12}/', $safe_value) > 0) {
            return $safe_value;
        }
    }
    return false;
}

?>