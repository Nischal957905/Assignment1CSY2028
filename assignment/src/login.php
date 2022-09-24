<?php
/*
Page that holds all the codes for validating and authorizing a user into the system
*/
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

//required the respective file at least ones in this file
include_once 'authenticator.php';
include_once 'dbConnection.php';
if(isset($_SESSION['newAcc'])){
    $echoError = "<script>alert('New Account created!')</script>";
    echo $echoError;
    unset($_SESSION['newAcc']);
}
?>
<!--
Structure designs that would be added in the front end page that this file refers to.
-->
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="login.css?v=<?php echo time();?>"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
		<title>Northampton News - Login</title>
	</head>
	<body>
        <div class="logDiv">
            <div class="picHold">
                <img src="uni2.png">
            </div>
            <div class="formLog">
            <a href="register.php" class="buttonSign">Sign up</a><br><br><br>
                <h1>Northampton</h1>
                    <?php
                        if(isset($_SESSION['loggedOut'])){
                            if($_SESSION['loggedOut'] == true){
                                if(isset($_SESSION['outMessage'])){
                                    echo '<p>'.$_SESSION['outMessage'].'</p>';
                                    unset($_SESSION['outMessage']);
                                }
                                else{
                                    echo '<p>Login to continue inside the portal</p><br>';
                                }
                            }
                            else{
                                echo '<p>Login to continue inside the portal</p><br>';
                            }
                        }
                        else{
                            echo '<p>Login to continue inside the portal</p><br>';
                        }
                    ?>
                <!-- from to be submitted when a user tries to login-->
                <form action="login.php" method="POST">
                    <label for="emailStore">Email&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label><br>
                    <input name="emailAuthenticator" id="emailStore" type="text"/><br><br>
                    <label for="passStore">Password</label><br>
                    <input name="passAuthenticator" id="passStore" type="text"/><br><br><br>
                    <button type="submit" name="submit">Login</button>
                </form>
            </div>
        </div>
</body>
</html>

