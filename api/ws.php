<?php

    include('./db_oo.php');
    include('./session_oo.php');
    session_start();

//  RATE LIMITING CODE COULD BE GOOD HERE max 1 per second & 1,000 per day.
//  include(./security_oo.php);

    $pubs = new pubSpecial;
    $locations = new locData;

    if(!isset($_SESSION['session_object'])) {
        $_SESSION['session_object'] = new sessionManager($_SERVER['REMOTE_ADDR']);
        $locArray = $locations->getCoordinatesForIP($_SERVER['REMOTE_ADDR']);
        if(is_array($locArray)) {
            $_SESSION['session_object']->setCoordinates($locArray);
            $_SESSION['session_object']->setIP($_SERVER['REMOTE_ADDR']);
        }
    } else {
        if($_SERVER['REMOTE_ADDR'] != $_SESSION['session_object']->getIP()) {
            $_SESSION['session_object']->setIP($_SERVER['REMOTE_ADDR']);
            $locArray = $locations->getCoordinatesForIP($_SERVER['REMOTE_ADDR']);
            if(is_array($locArray)) {
                $_SESSION['session_object']->setCoordinates($locArray);
            }
        }
    }
    $_SESSION['session_object']->logInteraction();
    if(isset($_GET['catid'])) {
        if($_GET['catid'] == 'locforip') {
            $output = array();
            if($_SESSION['session_object']->getLat() != false) {
                $output['lat'] = $_SESSION['session_object']->getLat();
            }
            if($_SESSION['session_object']->getLong() != false) {
                $output['long'] = $_SESSION['session_object']->getLong();
            }
            if($_SESSION['session_object']->getSuburb() != false) {
                $output['suburb'] = $_SESSION['session_object']->getSuburb();
            }
            if($_SESSION['session_object']->getState() != false) {
                $output['state'] = $_SESSION['session_object']->getState();
            }
            if($_SESSION['session_object']->getPostcode() != false) {
                $output['postcode'] = $_SESSION['session_object']->getPostcode();
            }
            if(sizeof($output) == 0) {
                $output = array(['error'=>'true']);
            }
        }
        if($_GET['catid'] == 'near') { // GPS DATA tendered.
            $goodlat = filter_input(INPUT_GET, 'lat', FILTER_VALIDATE_FLOAT);
            $goodlong = filter_input(INPUT_GET, 'long', FILTER_VALIDATE_FLOAT);        
            $goodrad = filter_input(INPUT_GET, 'radius', FILTER_VALIDATE_INT);        
            $goodorder = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_SPECIAL_CHARS);
            $output = $pubs->popularPubs($goodlat, $goodlong, $goodrad, $goodorder);
            
            if($output == false) {
                $output = array(['error'=>'no data']);
            }
            
            $_SESSION['session_object']->setLat($goodlat);
            $_SESSION['session_object']->setLong($goodlong);
            $_SESSION['session_object']->setRadius($goodrad);
        }
        if($_GET['catid'] == 'postburb') { // 
            $good = filter_input(INPUT_GET, 'locale', FILTER_SANITIZE_SPECIAL_CHARS);
            if($good != false) {
                $output = $locations->suburbList($good);
                if($output == false) {
                    $output = array(['error'=>'No Results']);
                }
            } else {
                $output = array(['error'=>'Input Not Valid']);
            }
        }
        if($_GET['catid'] == 'setradius') {
            $good = filter_input(INPUT_GET, 'radius', FILTER_VALIDATE_INT);
            if($good != false) {
                $output = $pubs->popularPubs($_SESSION['session_object']->getLat(), 
                $_SESSION['session_object']->getLong(), $good);
                if($output == false) {
                    $output = array(['error'=>'true']);
                }
            } else {
                $output = array(['error'=>'true']);
            }
        }
        if($_GET['catid'] == 'listburbgps') { // JSON autocomplete list for suburb;
            $goodlat = filter_input(INPUT_GET, 'lat', FILTER_VALIDATE_FLOAT);
            $goodlong = filter_input(INPUT_GET, 'long', FILTER_VALIDATE_FLOAT);
            if($goodlat != false || $goodlong == false || $$goodradius == false) {
                $output = $locations->suburbListByGPS($goodlat, $goodlong);
                if($output == false) {
                    $output = array(['error'=>'data']);
                }
            } else {
                $output = array(['error'=>'input']);
            }
        }
        if($_GET['catid'] == 'regFBuser') { 
            $goodUID = filter_input(INPUT_GET, 'uid', FILTER_VALIDATE_INT);
            //$goodToken = filter_input(INPUT_GET, 'token', FILTER_VALIDATE_URL);
            $goodToken = $_GET['token'];

            if($goodUID != false || $goodToken != false) {
                $username = $_SESSION['session_object']->checkUIDWithFacebook($goodToken, $goodUID);
                if($username != false) {
                    $uniquekey = $pubs->newUser($username['id'], $username['name']);
                    if($uniquekey != false) {
                        $_SESSION['session_object']->setAuthSession($username['id'], $username['name'], $uniquekey);
                    } else {
                        return false;
                    }
                    $output = array(['auth'=>'true', 'verifiedID'=>$username['id']]);
                } else {
                    $_SESSION['session_object']->unsetAuthSession();
                    $output = array(['auth'=>'false']);
                }
            } else {
                $output = array(['auth'=>'false']);
            }
        }
        
/* Areas Requiring Authentication */
        if($_SESSION['session_object']->isAuthSession()) {
            if($_GET['catid'] == 'endorse') { 
                $userEndorcments = getAllEndorcementsForUser($_SESSION['session_object']->getUID());
            }
            if($_GET['catid'] == 'removeendorse') { 
                $userEndorcments = getAllEndorcementsForUser($_SESSION['session_object']->getUID());
            }
        }

        header('Content-Type: application/json');
        if(isset($output)) {
            echo json_encode($output);
        } else {
            echo json_encode(array('error'=>'true'));
        }
    }
?>