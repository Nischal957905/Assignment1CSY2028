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
	<link rel="stylesheet" href="styles.css?v=<?php echo time();?>"/>
		<title>Northampton News - Home</title>
	</head>
	<body>
		<header>
			<section>
				<h1>Northampton News</h1>
			</section>
		</header>
		<nav>
			<ul>
				<li><a href="index.php">Latest Articles</a></li>
				<li><a href="#">Select Category</a>
					<ul>
					<?php
					//Logic that handles the projection of all categories in the drop down menu.
					$projectCategories = "SELECT category_id,name,description FROM category";
					$storeProjection = $connection->prepare($projectCategories);
					$storeProjection->execute();
					while($eachCat = $storeProjection->fetch(PDO::FETCH_ASSOC)){
						echo '<li><a href="categoryPage.php?catId='.$eachCat['category_id'].'">'.$eachCat['name'].'</a></li>';
					}
				?>
					</ul>
				</li>
			</ul>
		</nav>
		<img src="images/banners/randombanner.php" />
		<main>
			<article>
            <div class="logDiv">
            <div class="picHold">
                <img src="uni2.png">
            </div>
            <div class="formLog">
            <a href="register.php" class="buttonSign">Sign up</a><br><br><br>
                <h3 class="storo">Northampton</h3>
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
                <form action="login.php" method="POST" class="newp">
                    <label class="storePie" for="emailStore">Email&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label><br>
                    <input name="emailAuthenticator" id="emailStore" type="text"/><br><br>
                    <label class="storePie" for="passStore">Password</label><br>
                    <input name="passAuthenticator" id="passStore" type="text"/><br><br><br>
                    <button class="sora" type="submit" name="submit">Login</button>
                </form>
            </div>
        </div>
			</article>
		</main>

		<footer>
			&copy; Northampton News 2017
		</footer>
	</body>
</html>
