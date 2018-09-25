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
    }
?>