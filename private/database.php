<?php

//create constants variables to interact with database (credentials to login and store information)
define('DB_NAME', 'login_db');
define('DB_USER', 'cameron');
define('DB_PASS', 'Rocketman1');
define('DB_HOST', 'localhost');



//if not able to make a connection to the database throw an error
//creating a PDO connection (PDO is multi-purpose and doesnt have to just be used with mysqli)
$string = "mysql:host=".DB_HOST.";dbname=".DB_NAME."";
//using PDO because I am using prepared statements to send data
if(!$connection = new PDO($string,DB_USER,DB_PASS))
{
    die("Failed to connect");
}
