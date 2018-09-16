<?php

    include('./db_oo.php');
    include('./session_oo.php');
    session_start();

//  include(./security_oo.php);
//  RATE LIMITING CODE COULD BE GOOD HERE min 1 per second & 1,000 per day.

    $pubs = new pubSpecial;
    $locations = new locData;

    if(!isset($_SESSION['session_object'])) {
        $_SESSION['session_object'] = new sessionManager($_SERVER['REMOTE_ADDR']);
        $locArray = $locations->getCoordinatesForIP($_SERVER['REMOTE_ADDR']);
        if(is_array($locArray)) {
            $_SESSION['session_object']->setCoordinates($locArray);
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
        if($_GET['catid'] == 'recent') {
            $output = $pubs->recentPubs($_SESSION['session_object']->getLat(), 
                $_SESSION['session_object']->getLong(),
                $_SESSION['session_object']->getRadius());
            if($output == false) {
                $output = array(['error'=>'true']);
            }
        }
        if($_GET['catid'] == 'popular') { 
            $output = $pubs->popularPubs($_SESSION['session_object']->getLat(), 
                $_SESSION['session_object']->getLong(),
                $_SESSION['session_object']->getRadius());
            if($output == false) {
                $output = array(['error'=>'true']);
            }
        }
        if($_GET['catid'] == 'near') { // GPS DATA tendered.
            $output = $pubs->popularPubs($_SESSION['session_object']->getLat(), 
                $_SESSION['session_object']->getLong(),
                $_SESSION['session_object']->getRadius());
            if($output == false) {
                $output = array(['error'=>'true']);
            }
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
            $good = filter_input(INPUT_GET, $_GET['radius'], FILTER_VALIDATE_INT); // wrong?
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
            if($goodlat != false || $goodlong == false) {
                $output = $locations->suburbListByGPS($goodlat, $goodlong);
                if($output == false) {
                    $output = array(['error'=>'data']);
                }
            } else {
                $output = array(['error'=>'input']);
            }
        }
        if($_GET['catid'] == 'listburbs') { // JSON autocomplete list for suburb;
            $good = filter_input(INPUT_GET, $_GET['locale'], FILTER_SANITIZE_ENCODED);
            if($good != false) {
                $output = $locations->suburbList($good);
                if($output == false) {
                    $output = array(['error'=>'true']);
                }
            } else {
                $output = array(['error'=>'true']);
            }
        }

        header('Content-Type: application/json');
        if(isset($output)) {
            echo json_encode($output);
        } else {
            echo json_encode(array('error'=>'Function Not Implemented'));
        }
    }
?>
