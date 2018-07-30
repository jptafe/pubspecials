<?php function viewLoginForm() { ?>
    <form method="POST" action="index.php">
        <input type="hidden" name="login" value="login">
        <input name="email" type="text" placeholder="E-Mail Address" 
              value="<?php if(isset($_SESSION['usernmae'])) { echo $_SESSION['username'];} ?>" class="form-control">
        <input name="password" type="password" placeholder="Password" class="form-control"> 
        <input name="submit" value="submit" type="submit" class="newclass btn btn-lg btn-block btn-primary"> 
    </form> 
<?php }

function viewRegisterForm() { ?>
    <form method="POST" action="index.php">
        <input type="hidden" name="register" value="register">
        <input name="username" type="text" placeholder="User Name" class="form-control">
        <input name="email" type="text" placeholder="E-Mail Address" class="form-control">
        <input name="password" type="password" placeholder="Password" class="form-control">
        <input name="dob" type="text" placeholder="Date of Birth" id="dob" class="form-control">
        <input name="submit" value="submit" type="submit" class="newclass btn btn-lg btn-block btn-primary">
    </form>
<?php }

function editRegisterForm($rowid) {   
    $result = getOneUser($rowid);
?>

    <form method="POST" action="index.php">
        <input type="hidden" name="update" value="update">
        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        <input name="username" type="text" value="<?php echo $result['username']; ?>" class="form-control">
        <input name="email" type="text" value="<?php echo $result['email']; ?>" class="form-control">
        <input name="password" type="password" value="<?php echo $result['password']; ?>" class="form-control">
        <input name="dob" type="text" value="<?php echo $result['created']; ?>" id="dob" class="form-control">
        <input name="submit" value="submit" type="submit" class="newclass btn btn-lg btn-block btn-primary">
    </form>
<?php }

function viewLogoutForm() { ?>
    <form method="POST" action="index.php">
        <label>Are you Sure</label>
        <input type="hidden" name="logout" value="logout">
        <input name="submit" value="yes" type="submit" class="newclass btn btn-lg btn-block btn-primary">
        <input name="button" value="no" type="submit" class="newclass btn btn-lg btn-block btn-primary">
    </form>
<?php }
?>
