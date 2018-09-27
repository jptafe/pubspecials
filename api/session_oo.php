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
        public function checkUIDWithFacebook($fbid) {
            // FragSpawn's UID: 531077201
            
            

            $app_id = "YOUR_APP_ID";
            $app_secret = "YOUR_APP_SECRET"; 
            $my_url = "YOUR_POST_LOGIN_URL";
               
            // known valid access token stored in a database 
            $access_token = "YOUR_STORED_ACCESS_TOKEN";
          
            $code = $_REQUEST["code"];
              
            // If we get a code, it means that we have re-authed the user 
            //and can get a valid access_token. 
            if (isset($code)) {
              $token_url="https://graph.facebook.com/oauth/access_token?client_id="
                . $app_id . "&redirect_uri=" . urlencode($my_url) 
                . "&client_secret=" . $app_secret 
                . "&code=" . $code . "&display=popup";
              $response = file_get_contents($token_url);
              $params = null;
              parse_str($response, $params);
              $access_token = $params['access_token'];
            }
          
                  
            // Attempt to query the graph:
            $graph_url = "https://graph.facebook.com/me?"
              . "access_token=" . $access_token;
            $response = curl_get_file_contents($graph_url);
            $decoded_response = json_decode($response);
              
            //Check for errors 
            if ($decoded_response->error) {
            // check to see if this is an oAuth error:
              if ($decoded_response->error->type== "OAuthException") {
                // Retrieving a valid access token. 
                $dialog_url= "https://www.facebook.com/dialog/oauth?"
                  . "client_id=" . $app_id 
                  . "&redirect_uri=" . urlencode($my_url);
                echo("&lt;script> top.location.href='" . $dialog_url 
                . "'&lt;/script>");
              }
              else {
                echo "other error has happened";
              }
            } 
            else {
            // success
              echo("success" . $decoded_response->name);
              echo($access_token);
            }
          
            // note this wrapper function exists in order to circumvent PHP’s 
            //strict obeying of HTTP error codes.  In this case, Facebook 
            //returns error code 400 which PHP obeys and wipes out 
            //the response.
            function curl_get_file_contents($URL) {
              $c = curl_init();
              curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($c, CURLOPT_URL, $URL);
              $contents = curl_exec($c);
              $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
              curl_close($c);
              if ($contents) return $contents;
              else return FALSE;
            }
            
            // Take you to the profile page 
            $url0 = 'https://facebook.com/profile.php?id=10155400463042202'; // Does not work
            $url1 = 'https://facebook.com/profile.php?id=531077201'; // This does work

            // FragSpawn's UID: 

            $url = 'https://graph.facebook.com/v2.11/10155400463042202/?fields=link&access_token=335876946985539';
            $url15 = 'https://graph.facebook.com/debug_token?input_token=EAAExenIdAkMBAJ8zDcz8Gk9j7sZCxgN22zpBavv9WriYg2CrrEbIwuKGL8ckCjYzxLPktZA61DWchCRWwSKXFAcVrZAxqEbTW0URcfdV9bj1iuxKskhlPtJuzFsrsrk3OYfDUGaT7FzYI9eAXdiIq5Jf5IXBkHDed1FAquzVoavWLxLOLjSLV0C3se6RZBb22iQHPo0jAQZDZD&access_token=335876946985539';
        }
    }
?>