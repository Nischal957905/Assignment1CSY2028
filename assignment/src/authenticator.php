<?php
//this line of code helps in starting session
session_start();
//required the respective file at least ones in this file
require_once 'dbConnection.php';
require_once 'insertInto.php';

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