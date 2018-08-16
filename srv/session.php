<?php
    session_start();

    if(isset($_SESSION['user'])) {
        // This user has visited us before;
        $_SESSION['count'] = $_SESSION['count'] + 1; 
    } else {
        $_SESSION['user'] = 0;
        $_SESSION['priv'] = -1;
        $_SESSION['count'] = 1; 
        $_SESSION['source_ip'] = $_SERVER['REMOTE_ADDR'];
    }

    function rememberGPSLoc($lat, $long) {
        if(is_real($lat) && is_real($long)) {
            $_SESSION['lat'] = $lat;
            $_SESSION['long'] = $long;
        } else {
            getLocByIP();
        }
    }

    function setLocWithPostcode($postcode) {
        if(is_int($postcode)) {
            $loc = dbGetPostCode($postcode);
            if($loc != false) {
                $_SESSION['postcode'] = $postcode;
                $_SESSION['lat'] = $loc['lat'];
                $_SESSION['long'] = $lat['long'];
            }
        }
    }

    function setLocByIP() {
        $url = "https://api.ipstack.com/{$_SERVER['REMOTE_ADDR']}?access_key=c1ac2c2349bb687d690afc9fc50f2070";

        $r = new HttpRequest($url, HttpRequest::METH_GET);
        try {
            $r->send();
            if ($r->getResponseCode() == 200) {
                $json = $r->getResponseBody();
            }
        } catch (HttpException $ex) {
            return false;
        }
        $json_array = json_decode($json, true);
        if(isset($json_array['latitude']) || !is_null($json_array['latitude'])) {
            return array($json_array['latitude'], $json_array['longitude']);
        } else {
            return false;
        }
    }

?>