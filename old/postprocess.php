<?php
    include('srv/database.php');
    include('srv/session.php');
    
    $conn = connDb();

    if(isset($_POST['insert'])) {
        if($_POST['insert'] == 'addpub') {

            $prefetchsql = "SELECT * FROM pub WHERE address = :addr";

            $act = $conn->prepare($prefetchsql);
            $act->bindParam(':addr', $_POST['pubaddr']);
            $act->execute();
            $result = $act->fetchAll();

            if(count($result) == 0) {
                $sql = "INSERT INTO pub (name, address, postcode, latitude, longitude) 
                        VALUES (:pubname, :addr, :pcode, :lat, :long);";

                $act = $conn->prepare($sql);
                $act->bindParam(':pubname', $_POST['pub']);
                $act->bindParam(':addr', $_POST['pubaddr']);
                $act->bindParam(':pcode', $_POST['pubpost']);
                $act->bindParam(':lat', $_POST['lat']);
                $act->bindParam(':long', $_POST['long']);

                $act->execute();
                echo $conn->lastInsertId(); 
            }
        }

        if($_POST['insert'] == 'addspecial') {
            $sql = "INSERT INTO special (user_id, pub_id, special_text, day_of_week, time_of_day, starts) 
                    VALUES (1, 1, :speicaltxt, :dow, :tod, '1999/01/01');";
        
            $act = $conn->prepare($sql);

            //$act->bindParam(':uid', $_SESSION['userid']);
            //$act->bindParam(':pubid', $_SESSION['userid']);
            $act->bindParam(':speicaltxt', $_POST['special']);
            $act->bindParam(':dow', $_POST['dow']);
            $act->bindParam(':tod', $_POST['tod']);

            $act->execute();
            echo $conn->lastInsertId();         
        
        }
    }
?>