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
    if(isset($_POST['login'])) {
        $_SESSION['user'] = 'user';
        $_SESSION['username'] = $_POST['email'];
    }
    if(isset($_POST['register'])) {
        $_SESSION['user'] = 'user';
        echo '<p>registering</p>';
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
            echo '<p>location</p>';
        }
        if($_GET['pageid'] == 'recent') {
            echo '<p>recent</p>';
        }
        if($_GET['pageid'] == 'popular') {
            echo '<p>popular</p>';
        }
    } else {
        echo '<p>popular</p>';
    }
// FOOTER
    include('footer.php');
?>
