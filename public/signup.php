<?php
    //in oder to use functions fror signup file we must import autload.php
     require "../private/autoload.php";
     $Error = "";
     //set variables so user does not get an error when echoing information
     $email = "";
     $username = "";

     //check if something is posted from user input
     if($_SERVER['REQUEST_METHOD'] == "POST")
     {
        print_r($_POST);
        //white list expressions for email
        $email = $_POST['email'];
        //how to match input using regular expressions (or called sanatizing the email)
        //the symbol created makes sure that the user is inputting a valid email
        //'^' stands for beggining '$' stand for end \w\ stands for all capital letters and numbers
        //if the email is an actual email we will get true if not false
        if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/",$email))
        {
            $Error = "Please enter a valid email";
        }

        //store user input from login form into global variables
        //create date variable by using the date function
        $date = date("Y-m-d H:i:s");
        //url address and use function that we created to generate the address(function will generate a string with 60 characters of length)
        $url_address = get_random_string(60); //add slashes sanatizes input and allows users to input words like "hand's" with apasostrhe
        // double check that the user inputted a valid username
        //implement escaping for characters so apostrephes can be implemented into the databse
       //remove spaces from word
        $username = trim($_POST['username']);
        if(!preg_match("/^[a-zA-Z]+$/", $username))
        {
            $Error = "Please enter a valid username";
        }

        //implement escaping for characters so apostrephes can be implemented into the databse
        //add slashes sanatizes input and allows users to input words like "hand's" with apasostrhe
        $username = esc($username);
        //can also check that the user entered a valid password as well (WORK ON LATER)
        $password = esc($_POST['password']);

        //checking if the email is already in the database and if it is throw an error
        //create a query to interact with database and insert information (: -> means full column) & (limit 1 means we just want 1 result)
        //set $arr to empty so we are not adding to an existing array
        $arr = false;
        $arr['email'] = $email;
        $query = "select * from users where email = :email limit 1";
        //prepare for the query to be sent
        $stmt = $connection->prepare($query);
        //check the eexecute statement if a result is returned, if a result is returned it will be true
        $check = $stmt->execute($arr);

        //if check is true then a return a record and log the user in
        if($check)
        {
            //get data from the prepared query statment
            $data = $stmt->fetchALL(PDO::FETCH_OBJ);
            //check if the data returned is an array and if the email entered is in the database then execute the statment
            if(is_array($data) && count($data) > 0)
            {
                $Error = "This email is already in use. Please use another email.";

            }
        
            
        }


        //if the are no erros with program above
        if($Error == "")
        {

            //setting values in array equal to user inputted data for prepared statments
            $arr['url_address'] = $url_address;
            $arr['date'] = $date;
            $arr['username'] = $username;
            $arr['password'] = $password;
            $arr['email'] = $email;

            //create a query to interact with database and insert information
            $query = "insert into users(url_address, username, password, email, date) values(:url_address, :username, :password, :email, :date)";
            //prepare for the query to be sent
            $stmt = $connection->prepare($query);
            //execute the statment
            $stmt->execute($arr);

            //after everything has compiled successfu;ly above send the user to the login page
            header("Location: login.php");
            //properly end program
            die;
        } 
        

     }
     //white list certain expressions for password

?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<!--give the body a custom font-->
<body style = "font-family: verdana" >
    <style type = "text/css">
        form{
            /* makes sign up box sit in the middle of screen*/
            margin:auto;
            /* solid thin border so user can see it /#aaa is gray color*/
            border: solid thin #aaa;
            padding: 6px;
             /* set a max width of the box*/
             max-width: 200px;

        }
        #title {
             /* give background color blue*/
            background-color: #39b799;
            padding: 1em;
             /* allign in middle of screen*/
            text-align: center;
             /* change tezt color*/
             color: white;

        }
        /*for style text input boxes*/
        #textbox{
             /* give boxes a solin thin border with the color #aaa*/
            border: solid thin #aaa;
             /* give the text boxes spacing*/
            margin-top:6px;
            width: 98%;
        }
    </style>
    <form method = "post" >
        <!--want to echo errors under the title -->
        <div> 
            <?php 
            //if the error is set and not empty thn echo what is in the error
            if(isset($Error) && $Error != "")
            {
                echo $Error;
            }
            ?>
        </div>
        <div id = "title"> Signup</div>
        <!--required  makes sure the user cannot signup without filling in both of email and password fields-->
        <!--value will echo the php variable to the user-->
        Username:
        <input id = "textbox" type = "username" name = "username"  value = "<?=$username?>" required> <br>
        Email:
        <input id = "textbox" type = "email" name = "email" value = "<?=$email?>" required> <br>
        Password:
        <input id = "textbox" type = "password" name = "password" required> <br><br>
        <input type = "submit" value = "Signup">
    </form>
</html>
