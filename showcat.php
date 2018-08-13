<?php

echo $_SERVER['REMOTE_ADDR'];

if(isset($_GET['catid'])) {
    if($_GET['catid'] == 'recent') {
        $sql = "
SELECT * FROM `special`
    INNER JOIN pub ON pub.id = special.pub_id
        ORDER BY starts DESC
";
    }
    if($_GET['catid'] == 'popular') {
        $sql = "
SELECT count(special_id) AS specialcount, special.special_text,
special.day_of_week, special.time_of_day, special.starts,
pub.name, pub.address, pub.postcode,
pub.latitude, pub.longitude 
    FROM rating 
        INNER JOIN special ON special.id = rating.special_id
            INNER JOIN pub ON pub.id = special.pub_id
            GROUP BY rating.special_id
                ORDER BY specialcount DESC
";
    }
    if($_GET['catid'] == 'near') {
        $range = $_GET['range'] / 100;
        $sql = "
SELECT * FROM special
    INNER JOIN pub ON pub.id = special.pub_id
        WHERE (pub.latitude - {$range}) < {$_GET['currentlat']} AND
            (pub.latitude + {$range}) > {$_GET['currentlat']} AND
            (pub.longitude - {$range}) < {$_GET['currentlong']} AND
            (pub.longitude + {$range}) > {$_GET['currentlong']}
";
    }
    if($_GET['catid'] == 'postcode') {
        $sql = "
SELECT * FROM special
    INNER JOIN pub ON pub.id = special.pub_id
        WHERE pub.postcode = {$_GET['postcode']}";
    }
    // render output
    $conn = new PDO("mysql:host=localhost;dbname=pubspecials", 'root','');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row) {
        echo $row['specialcount'];
        echo $row['special_text'];
        echo $row['day_of_week'];
        echo $row['time_of_day'];
        echo $row['starts'];
        echo $row['name'];
        echo $row['address']; 
        echo $row['postcode'];
        echo $row['latitude'];
        echo $row['longitude'];
    }
}
?>
