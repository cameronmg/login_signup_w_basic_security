<?php

    //starting the session so we can use the global $_SESSION variable for use data
    session_start();

    //make sure to not displays errors when when website is live this is only for dev purposes (1 = show errors; 0 = dont show errors)
    ini_set("display_erros", 1);

    //this file is for autoloading functions into a new file
    require "../private/connection.inc.php";
    require "../private/functions.php";
    require "../private/database.php";

