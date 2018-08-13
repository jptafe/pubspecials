# show specials by location
SELECT * FROM special 
    INNER JOIN pub ON pub.id = special.pub_id
    WHERE (pub.latitude - .01) < $currentlat AND
    (pub.latitude + .01) > $currentlat AND
    (pub.longitude - .01) < $currentlong AND
    (pub.longitude + .01) > $currentlong

# show specials by most recent
SELECT * FROM `special` 
    INNER JOIN pub ON pub.id = special.pub_id
    ORDER BY starts DESC


# show specials by popularity
SELECT count(special_id) AS specialcount, special_id 
    FROM `rating` 
    INNER JOIN pub ON pub.id = special.pub_id
    GROUP BY rating.special_id 
    ORDER BY specialcount DESC

# new special 
INSERT INTO pub (name, address, postcode, latitude, longitude) 
    VALUES ('asdf', 'asdf', '1234', '-27.474230', '153.027105');

INSERT INTO special (user_id, pub_id, special_text, day_of_week, time_of_day, starts)  
    VALUES ($_SESSION['user'], '4', 'asdf', 'Sunday', 'sadf', '2018-08-13');

INSERT INTO rating (rating, user_id, special_id) 
    VALUES ('up', $_SESSION['user'], '2');






# 
