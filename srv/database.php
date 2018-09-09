<?php

function connDb() {
    $conn = new PDO("mysql:host=localhost;dbname=pubspecials", 'root','');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
function delUser($rowid) {
    $conn = connDb();
    $del_query = "DELETE FROM user WHERE id = '" . $rowid . "';";
    $stmt = $conn->prepare($del_query);
    $stmt->execute();
    if($stmt->rowCount() == 0) {
        return false;
    } else {
        return true;
    }
}
function addUser() {
    $conn = connDb();
    $ins_query = "INSERT INTO user (username, password, email, dob) 
        VALUES ('{$_POST['username']}', '{$_POST['email']}', '{$_POST['password']}', 
        '{$_POST['dob']}')"; 
    $stmt = $conn->prepare($ins_query);
    $stmt->execute();
    if($stmt->rowCount() == 0) {
        return false;
    } else {
        return true;
    }
}
function updateUser() {
    $conn = connDb();
    $update_query = "UPDATE user SET 
        username = '{$_POST['username']}',
        password = '{$_POST['password']}', email = '{$_POST['email']}' 
        WHERE id = " . $_POST['id']; 
    $stmt = $conn->prepare($update_query);
    $stmt->execute();
    if($stmt->rowCount() == 0) {
        return false;
    } else {
        return true;
    }
}
function loginCheck() {
    $conn = connDb();
    $login_query = "SELECT * FROM user WHERE 
        (username = '{$_POST['email']}' OR email = '{$_POST['email']}') 
        AND password = '{$_POST['password']}';";
    $stmt = $conn->prepare($login_query);
    $stmt->execute();
    $result = $stmt->fetch();

    if(is_array($result)) {
        return $result;
    } else {
        return false;
    }
}
function getOneUser($uid) {
    $conn = connDb();
    $sel_query = "SELECT * FROM user WHERE id = " . $uid;
    $stmt = $conn->prepare($sel_query);
    $stmt->execute();
    $result = $stmt->fetch();

    if($stmt->rowCount() > 0) {
        return $result;
    } else {
        return false;
    }
}
function selectAllUsers() {
    $conn = connDb();
    $sel_query = "SELECT * FROM user";
    $stmt = $conn->prepare($sel_query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    echo '<a href="index.php?pageid=register">ADD</a>';
    foreach($result as $row) {
        echo '<p>';
        echo '<aside>' . $row['username'] . '</aside>';
        echo '<aside>' . $row['email'] . '</aside>';
        echo '<aside><a href="index.php?pageid=edit&rowid=' . $row['id'] . '">edit</a></aside>';
        echo '<aside><a href="index.php?pageid=del&rowid='. $row['id'] . '">del</a></aside>';
        echo '</p>';
    }
}
function getLocale($suburb_post) {
    $conn = connDb();
    $clean_suburb_post = validate($suburb_post);
    $sql = "
SELECT * FROM postcode_db 
    WHERE suburb LIKE :subpost 
        OR postcode LIKE :subpost";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':subpost', $clean_suburb_post, PDO::PARAM_STR, 8);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if(is_array($result) && sizeof($count) > 0) {
        return $result;
    } else {
        return false;
    }
}
function validate($string) {
    $new_string = stripslashes($string);
    $new_string = strip_tags($new_string);
    $new_string = trim($new_string);
    return $new_string;
}
?>
