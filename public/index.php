<?php

    require "../private/autoload.php";
    //this function will be for checking if the user is logged in
    $user_data = check_login($connection);

    //make sure username variable starts off as empty
    $username = "";
    //if the session is set(or active) set the username so it can be displayed to the user
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <div id = "header">
        <!---displaying users username if they are logged in->
        <?php if ($username != ""): ?>
            <div> Hi <?php $_SESSION['username']?></div>
        <?php endif; ?>

        <div style="float:right"> 
        <!--create a link to the logout page-->
        <a href = "logout.php">Logout</a> 
        </div>
    </div>
    This is the home page
</body>
</html>
    

