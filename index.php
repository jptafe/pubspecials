<?php
// INCLUDES
    include('srv/database.php');
    include('srv/session.php');
    include('view.php');

// FORM ACTIONS
    if(isset($_POST['update'])) {
        updateUser();
    }
    if(isset($_POST['login'])) {
        $res = loginCheck();
        if($res != false) {
            $_SESSION['user'] = $res['id'];
            $_SESSION['priv'] = $res['privilege'];
        } else {
            $_SESSION['user'] = 0; 
            $_SESSION['priv'] = -1; 
            $_SESSION['count'] = $_SESSION['count'] + 1;
        }
    }
    if(isset($_POST['register'])) {
// $_SESSION['user'] = 'user';
        addUser();
    }
    if(isset($_POST['logout'])) {
        if($_POST['logoutyes'] == 'yes') {
            $_SESSION['user'] = 0;
            $_SESSION['priv'] = -1;
            $_SESSION['count'] = 0; 
        }
    }
// HEADER
    include('header.php');

////debug
    echo '<p>' . $_SESSION['count'] . '</p>';

// DISPLAY
    if(isset($_GET['pageid'])) {
        if($_GET['pageid'] == 'login') {
            viewLoginForm(); 
        }
        if($_GET['pageid'] == 'logout') {
            viewLogoutForm();
        }
        if($_GET['pageid'] == 'register') {
            viewRegisterForm();
        }
        if($_GET['pageid'] == 'location') {
            selectAllUsers();
        }
        if($_GET['pageid'] == 'recent') {
            selectAllUsers();
        }
        if($_GET['pageid'] == 'popular') {
            selectAllUsers();
        }
        if($_GET['pageid'] == 'del') {
            delUser($_GET['rowid']);
            selectAllUsers();
        }
        if($_GET['pageid'] == 'edit') {
            editRegisterForm($_GET['rowid']);
        }
    } else {
        selectAllUsers();
    }
// FOOTER
    include('footer.php');
?>
