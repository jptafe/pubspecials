<?php
    class sessionManager {
        private $lat = -27.478150;
        private $long = 153.019693;
        private $radius = 10;
        private $previousIP;
        private $outOfOzConfirmed;

        public function __construct($IP) {
            $this->IP = $IP;
        }
        public function setCoordinates($data) { 
            if(is_array($data)) {
                $this->lat = $data['lat'];
                $this->long = $data['long'];
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
        public function getLong() {
            return $this->long;
        }
        public function setLat($lat) {
            $this->lat = $lat;
            return true;
        }
        public function setLong($long) {
            $this->long = $long;
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