pubspecials is a social network documenting all the weekly specials of any pub 
in Australia

Anybody can sign up to the network, and publish specials, but the best specials 
will have thumbs up from 3rd party users

Business Rules:
One must be authentaced to comment of endorse
They must also be logged in to add a special
In mobile mode, search can be done by ones' location
A users' IP will be used to find the city they are in
A session stores the latitude and longitude of any location input the user wishes to divulge
You have to be 18 or above to register, just like a pub.


Todo:
login/Register - 
1. Create two web forms for login.php
2. Create a loginprocessing.php where login.php actions
3. loginprocessing will SELECT from users to see if user/pass exists in database
4. If there is set $_SESSION['user'] to the ID of the user in the database
5. Go to success.php file if there is a success. this has one link - 'logout'
6. If there is a fail: $_SESSION['error'] tells loginform.php there was an error in login

NOTE
success.php needs to check and see if the user is logged in, if not it should 
header('Location:login.php');
likewise if people are logged in the login.php should
header('Location:success.php');

EXTRA 
There should be three attempts and then a 20m cooling off period
