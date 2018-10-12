pubspecials is a croudsourced interface, documenting all the weekly specials of any pub 
in Australia. People sign up to the network through Facebook to publish pubs and specials. 
Authenticated users can also vote or comment on specials. Search is largely location based,
with the app storing latitude and longitude information about each pub, and coordinates of the 
users that search for pub specials. 

Business Rules:
One must be authentacated to comment or endorse
They must also be logged in to add a special
Search is done by ones' location, based on IP or GPS, or search terms
A session stores the latitude and longitude of any location input the user wishes to divulge
IPs found to be outside Australia will have limited access, 100 API calls per hour, 1000 API calls per day.

INSTALL:
Place archive on a server with PHP 7/MySQL or Mariadb pre-installed.
create two databases: 
pubspecials - Sql that holds pubs/specials/users/votes
pubdata - SQL that contains suburb/IP Lat & Long information lookup tables
point browser at root folder of this package
Press F12 and ensure there are no errors
Both FB & Google APIs are locked to dev.fragspawn.com, and will not work anywhere else.
Priority is given to developing the public user experience.

Todo:
Log all interactions with the Web Service.
Implement google maps on click of Pub Address.
send a client SSID to google for all requests (mitigate cost)
Confirm authentic Google account on Server Side
Implement all the Authenticated actions (POST)
Implement Rate limiting for non .au IPs
Image validator/uploader in JS - https://www.dropzonejs.com
Research benign endpoint for images.
style the datepicker 
Login with Google

Annoynaces that need fixing (low priority)
dropdowns don't work in FireFox should use alternative 
Login with google
Add unique pubspecial events to the timeline inside FaceBook!

Code stored at
http://github.com/jptafe/pubspecials

Alternative Site:
https://publocation.com.au/
