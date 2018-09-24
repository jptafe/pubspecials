<html>
    <head>
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
        <script src="js/core.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">

    </head>
    <body>
<?php
if(isset($_GET['pageid'])) {
    $highlight = $_GET['pageid'];
} else {
    $highlight = 'home';

}

if($_SESSION['priv'] > 0) {
?>
        <div class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand"><img src="img/ozpubspecials.svg" height="60" width="240"></a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if($highlight == 'home') { echo 'active'; } ?>"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item <?php if($highlight == 'about') { echo 'active'; } ?>"><a class="nav-link" href="index.php?pageid=about">About</a></li>
                <li class="nav-item <?php if($highlight == 'contact') { echo 'active'; } ?>"><a class="nav-link" href="index.php?pageid=contact">Contact</a></li>
                <li class="nav-item <?php if($highlight == 'logout') { echo 'active'; } ?>"><a class="nav-link" href="index.php?pageid=logout">Logout</a></li>
            </ul>
        </div>
<?php } else { ?>
        <div class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand"><img src="img/ozpubspecials.svg" height="60" width="240"></a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if($highlight == 'home') { echo 'active'; } ?>"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item <?php if($highlight == 'about') { echo 'active'; } ?>"><a class="nav-link" href="index.php?pageid=about">About</a></li>
                <li class="nav-item <?php if($highlight == 'contact') { echo 'active'; } ?>"><a class="nav-link" href="index.php?pageid=contact">Contact</a></li>
                <li class="nav-item <?php if($highlight == 'register') { echo 'active'; } ?>"><a class="nav-link" href="index.php?pageid=register">Register</a></li>
                <li class="nav-item <?php if($highlight == 'login') { echo 'active'; } ?>"><a class="nav-link" href="index.php?pageid=login">Login</a></li>
            </ul>
        </div>
<?php } ?>

<!-- Search Bar -->
<div class="navbar navbar-expand-md">
    <ul>
        <li><a href="#" id="search_radius">Search Radius</a></li>
        <li>
            <select id="search_radius_distance">
                <option value="1">1km</option>
                <option value="5">5km</option>
                <option value="10">10km</option>
            </select>
        </li>
        <li><input id="search_postcode" type="number" placeholder="pcode" size="4" width="4" max="9999" min="1000" maxlength="4"></li>
        <li><a href="#" id="search_recent">recent</a></li>
        <li><a href="#" id="search_popular">popular</a></li>
    </ul>
</div>
<!-- Move this elsewhere -->
<div id="altdiv"></div>

<!-- Not sure I want this <link rel="import" href="footer.php"> -->
