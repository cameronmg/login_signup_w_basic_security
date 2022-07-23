<?php
    //in oder to use functions fror signup file we must import autload.php
     require "../private/autoload.php";
     $Error = "";


     //check if something is posted from user input and check if the tken of the session is equal to whatever is in the token at the post (also check if it set and posted)
     if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] == $_POST['token'])
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

        //can also check that the user entered a valid password as well (WORK ON LATER)
        $password = $_POST['password'];

        //if the are no erros with program above
        if($Error == "")
        {

            //setting values in array equal to user inputted data for prepared statments
            $arr['password'] = $password;
            $arr['email'] = $email;

            //create a query to interact with database and insert information (: -> means full column) & (limit 1 means we just want 1 result)
            $query = "select * from users where email = :email && password = :password limit 1";
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
                    //if it is an array we can bring the URL and the username into the session

                    //set $data equal to the first value in the array
                    $data = $data[0];
                    //set $_SESSION equal to the URL adress assigned to the selected user in the database
                    //using $_SESSION b/c it is a global variable and it available on every page but you must activate 
                    //the session before you use the varaible
                    $_SESSION['username'] = $data->username;
                    $_SESSION['url_address'] = $data->url_address;

                    //after everything has compiled successfu;ly above send the user to the login page
                    header("Location: index.php");
                    //properly end program
                    die;

                }
            
                
            }
        } 
        
        //as long as something was psted and we werent redirected to a new page then the email was wrong
        //make sure to be vague with error messages
        $Error = "Wrong email or password.";

     }
     
     //creating token using rnadom string function
     $_SESSION['token'] = get_random_string(60); 

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        <div id = "title"> Login</div>
        <!--required  makes sure the user cannot signup without filling in both of email and password fields-->
        Email:
        <input id = "textbox" type = "email" name = "email" required> <br>
        Password:
        <input id = "textbox" type = "password" name = "password" required> <br><br>
        <!--creating a token to prevent cross site forgery(token was created at the top of page using generate random strinf function)-->
        <input type = "hidden" name = "token" value = "<?php $_SESSION['token']?>">
        <input type = "submit" value = "Login">
    </form>
</html>
