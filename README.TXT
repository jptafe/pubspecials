pubspecials is a social network documenting all the weekly specials of any pub 
in Australia

Anybody can sign up to the network, and publish specials, but the best specials 
will have thumbs up from 3rd party users

Business Rules:
One must be authentaced to comment of endorse? May have anonymous cowards
They must also be logged in to add a special? May have anonymous cowards
In mobile mode, search can be done by ones' location
A users' IP will be used to find the city they are in
A session stores the latitude and longitude of any location input the user wishes to divulge
You have to be 18 or above to register, just like a pub.
There should be three attempts and then a 20m cooling off period
IPs found to be outside Australia will have limited access, 100 API calls per hour, 1000 API calls per day.

INSTALL:
create two databases: 
pubspecials - Sql that holds pubs/specials/users/votes
pubdata - SQL that contains suburb/IP Lat & Long information lookup tables
No users
No logins
Just public browsing of canned data to confirm UX issues.

Todo:
Login with Facebook/Google
Get Address to autocomplete from Maps DONE
Image validator/uploader JS - https://www.dropzonejs.com
Get a styled datepicker - Validate it so only future dates can be chosen + Start date can't exceed end date

https://publocation.com.au/
