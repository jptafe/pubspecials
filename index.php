<?php
// INCLUDES
    include('srv/database.php');
    include('view.php');
// SESSIONS 
    session_start();
    if(isset($_SESSION['user'])) {
        // This user has visited us before;
        $_SESSION['count'] = $_SESSION['count'] + 1; 
    } else {
        $_SESSION['user'] = 'anon';
        $_SESSION['count'] = 1; 
    }

// FORM ACTIONS
    if(isset($_POST['update'])) {
        updateUser();
    }
    if(isset($_POST['login'])) {
        $_SESSION['user'] = 'user';
        $_SESSION['username'] = $_POST['email'];
    }
    if(isset($_POST['register'])) {
//        $_SESSION['user'] = 'user';
        addUser();
    }
    if(isset($_POST['logout'])) {
        $_SESSION['user'] = 'anon';
        $_SESSION['count'] = 0; 
        echo '<p>loggingout</p>';
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
