<?php

require "../private/autoload.php";

//if the session is active 
if(isset($_SESSION['url_address']))
{
    //unset the session and the user will be loged out
    unset($_SESSION['url_address']);

}

if(isset($_SESSION['username']))
{
    //unset the session and the user will be loged out
    unset($_SESSION['username']);

}

//take the user to a new page after logged out

header("Location: index.php");
die;
