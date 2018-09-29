<?php
    class sessionManager {
        private $previousIP = false;
        private $lat = false;
        private $long = false;
        private $suburb = false;
        private $state = false;
        private $postcode = false;
        private $radius = 0;
        private $outOfOzConfirmed = false;
        private $authUser = false;
        private $uid;
        private $uname;
        
        public function __construct($IP) {
            $this->IP = $IP;
        }
        public function setCoordinates($data) { 
            if(is_array($data)) {
                $this->lat = $data['lat'];
                $this->long = $data['lon'];
                $this->suburb = $data['suburb'];
                $this->state = $data['state'];
                $this->postcode = $data['postcode'];
            } else {
                return false;
            }
        }
        public function getLocation() {
            return array('lat'=>$this->lat, 'long'=>$this.long, 'radius'=>$this.radius);
        }
        public function getLat() {
            return $this->lat;
        }
        public function setLat($lat) {
            $this->lat = $lat;
            return true;
        }
        public function getLong() {
            return $this->long;
        }
        public function setLong($long) {
            $this->long = $long;
            return true;
        }
        public function getSuburb() {
            return $this->suburb;
        }
        public function setSuburb($suburb) {
            $this->suburb = $suburb;
            return true;
        }        
        public function getState() {
            return $this->state;
        }
        public function setState($state) {
            $this->state = $state;
            return true;
        }    
        public function getPostcode() {
            return $this->postcode;
        }
        public function setPostcode($postcode) {
            $this->postcode = $postcode;
            return true;
        }    
        public function setRadius($radius) {
            $this->radius = $radius;
            return true;
        }
        public function getRadius() {
            return $this->radius;
        }
        public function getIP() {
            return $this->previousIP;
        }
        public function setIP($IP) {
            $this->previousIP = $IP;
            return true;
        }
        public function logInteraction() {
            //Log source IP, session_id, request URL
            return false;
        }
        public function setAuthSession($uid, $uname) {
            $this->authUser = true;
            $this->uid = $uid;
            $this->uname = $uname;
            // insert this sucker into the database
        }
        public function unSetAuthSession($uid) {
            $this->authUser = false;
            unset($this->uid);
            unset($this->uname);
        }
        public function isAuthSession() {
            return $this->authUser;
        }
        public function getUID() {
            return $this->uid;
        }
        
        public function checkUIDWithFacebook($fbid, $sessKey) {
            $graph_url = "https://graph.facebook.com/me?access_token=" . $sessKey;

            $ch = curl_init($graph_url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            if($response === false) {
                print_r(curl_getinfo($ch));
            } 
            curl_close($ch);
/*
            $req = new HttpRequest($graph_url, HttpRequest::METH_GET);
            $req->send();
            if ($req->getResponseCode() == 200) {
                $response = $req->getResponseBody();
            }
*/
            die();
            $decoded_response = json_decode($response);

            if ($decoded_response['error']) {
                return false;
            } else {
                if($decoded_response->id == $fbid) {
                    return $decoded_response->name;
                }
            }
            return false;
        }
    }
?>