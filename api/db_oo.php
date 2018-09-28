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
        public function popularPubs($lat, $long, $radius, $order) {
            $clean_publat = validate($lat, 'GPS');
            $clean_publong = validate($long, 'GPS');
            $clean_pubradius = validate($radius, 'RADIUS');
            $clean_order = validate($order, 'ORDER');

            if($clean_publat == false || $clean_publong == false ||
                $clean_pubradius == false || $clean_order == false) {
                return false;
            }
            $clean_pubradius = $clean_pubradius / 100;
            if($clean_order == 'recent') {
// We also want to know who added the pub!

                $sqlpubs = "
SELECT pub.id, name, description, address, suburb, state, postcode, logo, viewcount
    FROM pub 
    WHERE (pub.latitude - :radius) <= :lat AND
        (pub.latitude + :radius) >= :lat AND
        (pub.longitude - :radius) <= :long AND
        (pub.longitude + :radius) >= :long
        ORDER BY last_updated DESC
        LIMIT 10";
            } else if ($clean_order == 'views') {
                $sqlpubs = "
SELECT pub.id, name, description, address, suburb, state, postcode, logo, viewcount 
    FROM pub 
    WHERE (pub.latitude - :radius) <= :lat AND
        (pub.latitude + :radius) >= :lat AND
        (pub.longitude - :radius) <= :long AND
        (pub.longitude + :radius) >= :long
        ORDER BY viewcount DESC
        LIMIT 10";
            } else if ($clean_order == 'rated') {
                $sqlpubs = "
SELECT pub.id, name, description, address, suburb, state, postcode, logo, viewcount
    FROM pub 
        INNER JOIN rating ON pub.id = rating.pub_id
        WHERE (pub.latitude - :radius) <= :lat AND
            (pub.latitude + :radius) >= :lat AND
            (pub.longitude - :radius) <= :long AND
            (pub.longitude + :radius) >= :long AND
            rating.rating = 'UP' 
            GROUP BY pub.id
            ORDER BY count(rating.rating) DESC
            LIMIT 10";
            }
            $stmt = $this->conn->prepare($sqlpubs);
            $stmt->bindParam(':lat', $clean_publat, PDO::PARAM_STR, 10);
            $stmt->bindParam(':long', $clean_publong, PDO::PARAM_STR, 10);
            $stmt->bindParam(':radius', $clean_pubradius);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                $updateviewssql = "
UPDATE pub 
    SET viewcount = viewcount + 1
        WHERE id = :pubid";
                $subupdate = $this->conn->prepare($updateviewssql);
                $subupdate->bindParam(':pubid', $row['id'], PDO::PARAM_INT);
                $row['viewcount'] = $row['viewcount'] + 1;
                $subupdate->execute();
// We also want to know who added the special!

                $specialsql = "
SELECT id, pub_id, special_text, day_of_week, time_of_day, starts, expires
    FROM special
        WHERE pub_id = :pub AND expires >= curdate()";
                $substmt = $this->conn->prepare($specialsql);
                $substmt->bindParam(':pub', $row['id'], PDO::PARAM_INT);
                $substmt->execute();
                unset($specialresult);
                while($specialrow = $substmt->fetch(PDO::FETCH_ASSOC)) { 
                    $ratinguponspecialsql = "SELECT count(*) AS upcount FROM `rating` WHERE special_id = {$specialrow['id']} AND rating = 'UP'";
                    $uponstmt = $this->conn->prepare($ratinguponspecialsql);
                    $uponstmt->execute();
                    $upcount = $uponstmt->fetch(PDO::FETCH_ASSOC);
                    $specialrow['upcount'] = $upcount['upcount'];

                    $ratingdownspecialsql = "SELECT count(*) AS downcount FROM `rating` WHERE special_id = {$specialrow['id']} AND rating = 'DOWN';";
                    $downstmt = $this->conn->prepare($ratingdownspecialsql);
                    $downstmt->execute();
                    $downcount = $downstmt->fetch(PDO::FETCH_ASSOC);
                    $specialrow['downcount'] = $downcount['downcount'];
// Who made the comment
                    $commentspecialsql = "
SELECT * 
    FROM comment 
        WHERE special_id = :thespecial";
                    $subsubstmt = $this->conn->prepare($commentspecialsql);
                    $subsubstmt->bindParam(':thespecial', $specialrow['id'], PDO::PARAM_INT);
                    $subsubstmt->execute();
                    unset($specialcommentresult);
                    while($specialcommentrow = $subsubstmt->fetch(PDO::FETCH_ASSOC)) { 
                        $specialcommentresult[] = $specialcommentrow;
                    }
                    if(isset($specialcommentresult)) {
                        if(is_array($specialcommentresult) && sizeof($specialcommentresult) > 0) {
                            $specialrow['comments'] = $specialcommentresult;
                        }
                    }
                    $specialresult[] = $specialrow;                   
                }
                if(isset($specialresult)) {
                    if(is_array($specialresult) && sizeof($specialresult) > 0) {
                        $row['specials'] = $specialresult;
                    }
                }
                $result[] = $row;
            }
            if(isset($result)) {
                if(is_array($result) && sizeof($result) > 0) {
                    return $result;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        
/* Authenticated users */
        
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
        public function commentOnSpecial($specialID, $comment) {
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
    if($type == 'ORDER') {
        if($safe_value == 'recent' || $safe_value == 'views' || $safe_value == 'rated') {
            return $safe_value;
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
