<?php

//this file is for all the php functions

//this is a function for generating a string of random numbers and letters
//the function randomly grabs numbers and letters from an aray of values and stores them in a string
function get_random_string($inputtedLength)
{
    //array of all possible values that i want in the randomly generated string
    $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t'
    ,'u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    //start off wit hempty text
    $text = "";

    //get a radnom number from 4 and  the inputted length of the function and store it in variable $length
    $length = rand(4, $inputtedLength);

    for($i=0;$i<$inputtedLength;$i++)
    {
        //generate a random number from 0 to 61 for grabbing values from the array
        $random = rand(0,61);

        //add on to the string the random value grabbed from the array
        $text .= $array[$random];
    }

    return $text;
}

//this function will be used for sanatizing user input so users cant try and type in malicous code
function esc($word)
{
    //add slashes sanatizes input and allows users to input words like "hand's" with apasostrhe
    return addslashes($word);
}

function check_login($connection)
{
    //check if the user is logged in by seeing the session data exists
    if(isset($_SESSION['url_address']))
    {
        //setting values in array equal to user inputted data for prepared statments
        //storing the url address in the array
        $arr['url_address'] = $_SESSION['url_address'];
      
        //create a query to interact with database and insert information (: -> means full column) & (limit 1 means we just want 1 result)
        $query = "select * from users where url_address = :url_address limit 1";
        //prepare for the query to be sent
        $stmt = $connection->prepare($query);
        //check the eexecute statement if a result is returned, if a result is returned it will be true
        $check = $stmt->execute($arr);

        //if check is true then a return a record and log the user in
        if($check)
        {
            //get data from the prepared query statment
            $data = $stmt->fetchALL(PDO::FETCH_OBJ);
            //check if the data returned is an array
            if(is_array($data) && count($data) > 0)
            {
                //the user is now logged in if we have reached this point

                ///return the first entry of the array
                return $data[0];
        

            }
        
            
        }
    }

    //if their is no session data then take user back to the homepage
    header("Location: login.php");
    die;
}
