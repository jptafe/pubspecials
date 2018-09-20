<?php
    class pubSpecial {
        private $conn;
        
        public function __construct() {
            $this->conn = new PDO("mysql:host=127.0.0.1;dbname=pubspecials", 'root','');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
            $stmt = $this->conn->prepare($sql);
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
            $clean_publat = validate($lat, 'GPS');
            $clean_publong = validate($long, 'GPS');
            $clean_pubradius = validate($radius, 'RADIUS');

            if($clean_publat == false || $clean_publong == false ||
                $clean_pubradius == false) {
                return false;
            }
            $clean_pubradius = $clean_pubradius / 100;
            $newersql = "
SELECT count(special.id), pub.name 
    FROM `pub` INNER JOIN special ON pub.id = special.pub_id 
    INNER JOIN rating ON special.id = rating.special_id 
        WHERE (pub.latitude - :radius) <= :lat AND
        (pub.latitude + :radius) >= :lat AND
        (pub.longitude - :radius) <= :long AND
        (pub.longitude + :radius) >= :long
        GROUP BY pub.id";

            $sql = "
SELECT * FROM pub 
    WHERE (pub.latitude - :radius) <= :lat AND
        (pub.latitude + :radius) >= :lat AND
        (pub.longitude - :radius) <= :long AND
        (pub.longitude + :radius) >= :long";
        
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':lat', $clean_publat, PDO::PARAM_STR, 10);
            $stmt->bindParam(':long', $clean_publong, PDO::PARAM_STR, 10);
            $stmt->bindParam(':radius', $clean_pubradius);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                
                $updateviewssql = "
UPDATE pub 
    SET viewcount = viewcount + 1
        WHERE id = :pubid";
                $subupdate = $this->conn->prepare($updateviewssql);
                $subupdate->bindParam(':pubid', $row['id'], PDO::PARAM_INT);
                $subupdate->execute();

                $specialsql = "
SELECT * FROM special
    WHERE pub_id = :pub"; // don't show user/pub IDs...
                $substmt = $this->conn->prepare($specialsql);
                $substmt->bindParam(':pub', $row['id'], PDO::PARAM_INT);
                $substmt->execute();
                $specialresult = $substmt->fetchAll(PDO::FETCH_ASSOC);
                if(is_array($specialresult) && sizeof($specialresult) > 0) {
                    $row['specials'] = array($specialresult);
                }
                $result[] = $row;
            }
            if(is_array($result) && sizeof($result) > 0) {
                return $result;
            } else {
                return false;
            }

        }
        public function specialsNowPubs($lat, $long, $radius) {
            
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
            $stmt = $this->conn->prepare($sql);
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
        private $conn;
        
        public function __construct() {
            $this->conn = new PDO("mysql:host=127.0.0.1;dbname=pubdata", 'root','');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        public function suburbList($postcode) {
            $clean_suburb = validate($postcode, 'SUBURBPOST');
            if($clean_suburb == false) { 
                return false;
            }
            $clean_suburb .= '%';
            $sql = "
SELECT * FROM postcode_db 
    WHERE suburb LIKE :subpost 
        OR postcode LIKE :subpost";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':subpost', $clean_suburb, PDO::PARAM_STR, 8);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(is_array($result) && (sizeof($result) > 0)) {
                return $result;
            } else {
                return false;
            }
        }
        public function getCoordinatesForSuburb($suburb) {
			$clean_suburb = validate($suburb, 'SUBURBPOST');
            if($clean_suburb == false) { 
				return false;
			}
			$sql = "
SELECT * FROM postcode_db
	WHERE suburb = :suburb";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':suburb', $clean_suburb, PDO::PARAM_STR, 32);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(is_array($result) && (sizeof($result) > 0)) {
				return $result;
			}
        }
        public function getCoordinatesForIP($ip) {
            // we might need to call an API to get more accurate locations
			$clean_ip = validate($ip, 'IP');
			if($clean_ip == false) {
                return false;
			}
			$sql = "
SELECT * FROM ip_loc 
	WHERE INET_ATON(:ip) >= INET_ATON(start_ip) 
	AND INET_ATON(:ip) <= INET_ATON(end_ip)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':ip', $clean_ip, PDO::PARAM_STR, 15);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            if(is_array($result) && (sizeof($result) > 0)) {
				$coords = $this->getCoordinatesForSuburb($result[0]['city']);
				if(is_array($coords) && (sizeof($coords) > 0)) {
					return $coords;
				}
			}
			return false;
        }
        public function suburbListByGPS($lat, $long) {
            $clean_lat = validate($lat, 'GPS');
            $clean_long = validate($long, 'GPS');
            $clean_radius = .001; 
			if($clean_lat == false || $clean_long == false || $clean_radius == false) {
                return false;
			}
			$sql = "
SELECT * FROM postcode_db 
    WHERE (lat - :radius) <= :latitude AND (lat + :radius) >= :latitude 
        AND (lon - :radius) <= :longitude AND (lon + :radius) >= :longitude
            LIMIT 10";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':latitude', $clean_lat);
            $stmt->bindParam(':longitude', $clean_long);
            $stmt->bindParam(':radius', $clean_radius);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(is_array($result) && (sizeof($result) > 0)) {
				return $result;
			} else {
			    $clean_radius = .01; 
                $stmt->bindParam(':radius', $clean_radius);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(is_array($result) && (sizeof($result) > 0)) {
                    return $result;
                }
			}
			return false;
        }
        public function isInAustralia($ip) {
            $clean_IP = validate($ip, 'IP');
            if($clean_IP == false) {
//                GPS range - Australia: -10.594079, 113.436668 - -44.576466, 157.212898
                return false;
            }
        }
    }

function validate($value, $type) {
    $safe_value = strip_tags($value);
    $safe_value = trim($safe_value);
    $safe_value = stripslashes($safe_value);
    
    if($type == 'GPS') {
        if(preg_match('/[\d]{2,}+\.[\d]{3,}+$/', $safe_value)) {
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
        if(preg_match('/[\d]{1,}+$/', $safe_value)) {
            if($safe_value <= 100) {
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
        if(preg_match('/[A-Za-z0-9 \-]{3,12}/', $safe_value) > 0) {
            return $safe_value;
        }
    }
    return false;
}
?>
