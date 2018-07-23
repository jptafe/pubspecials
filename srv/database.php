<?php
function do_not_do_this() {

// Connect String
  $conn = new PDO("mysql:host=localhost;dbname=pubspecials", 'root','');
// Debug ON
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// SQL
  $query = "INSERT INTO users (username, password)
            VALUES ('{$_POST['username']}', '{$_POST['password']}')";
// INVALID QUERY
  $del_query = "DELETE FROM users WHERE username = '{$_POST['username']}'";
// Load Query
  $stmt = $conn->prepare($query);
// Execute Query
  $result = $stmt->execute();
// Check Query was successful
  if($result == 1) {
    echo "yay guys success";
  } else {
    echo " sad bad luck buddy";
  }
// for delete if nothing was changed
  if($stmt->rowCount() == 0) {
    echo " sad bad luck buddy";
  } else {
    echo "yay guys success";
  }

}

?>
