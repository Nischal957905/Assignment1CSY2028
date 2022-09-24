<?php
//this line of code helps in starting session
session_start();
//required the respective file at least ones in this file
require_once 'dbConnection.php';
require_once 'insertInto.php';
/*
Refrence for various php codes used in the files.
w3Schools(n.d.)PHP Tutorial. w3Schools[online]. Available from: https://www.w3schools.com/php/default.asp[Accessed 10 September 2022]
*/

/*
Refrence for all php date and time codes used in the files.
w3Schools(n.d.)PHP Date and Time. w3Schools[online]. Available from: https://www.w3schools.com/php/php_date.asp[Accessed 10 September 2022]
*/

/*
Refrence for all the php sql and docker compose codes used in the files.
NILE - University of Northampton(n.d.)Module Activities. NILE - University of Northampton[online]. Available from: https://nile.northampton.ac.uk/ultra/courses/_126708_1/cl/outline[Accessed 10 September 2022]
*/

//Code to be executed when the login button is clicked in the login page.
//Check if the user trying to login is valid or not.
if(isset($_POST['submit'])){
    if(!empty($_POST['emailAuthenticator']) && !empty($_POST['passAuthenticator'])){
        $selectCredential = "SELECT email,password FROM users";
        $checkCredential = $connection->prepare($selectCredential);
        $checkCredential->execute();
        $status = false;
        while($valCheck = $checkCredential->fetch(PDO::FETCH_ASSOC)) {
            if($_POST['emailAuthenticator'] == $valCheck['email'] && password_verify($_POST['passAuthenticator'],$valCheck['password'])){
                $status = true;
                break;
            }
            else{
                $status = false;
            }
        }
        if($status == true){
            //setting sessions for future uses
            $_SESSION['onBoard'] = true;
            $_SESSION['onBoardUser'] = $_POST['emailAuthenticator'];

            if(isset($_SESSION['onBoardUser'])){
                $valStatus = verifyAdmin($_SESSION['onBoardUser']);
                    if($valStatus == true){
                        header('location: adminArticles.php');
                        die();
                    }
                    else{
                        header('location: index.php');
                        die();
                    }
            }
        }
        else{
            $echoError = "<script>alert('wrong Credentials!')</script>";
		    echo $echoError;
        }
    }
    else if(!empty($_POST['emailAuthenticator']) && empty($_POST['passAuthenticator'])){
        $echoError = "<script>alert('Empty password!')</script>";
		echo $echoError;
    }
    else if(empty($_POST['emailAuthenticator']) && !empty($_POST['passAuthenticator'])){
        $echoError = "<script>alert('Empty email!')</script>";
		echo $echoError;
    }
    else{
        $echoError = "<script>alert('Input fields are empty!')</script>";
		echo $echoError;
    }
}

?>