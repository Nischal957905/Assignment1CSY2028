<?php
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

//this line of code helps in starting session
session_start();
//required the respective file at least ones in this file
require_once 'dbConnection.php';
require_once 'insertInto.php';
//code to be executed when the register button is clicked
if(isset($_POST['submit'])){
    //siml=ple logic to check if fields are empty
    if(!empty($_POST['registerName']) && !empty($_POST['registerSur']) &&
    !empty($_POST['registerAge']) && !empty($_POST['registerEmail']) &&
    !empty($_POST['registerEmail']) && !empty($_POST['registerUser']) &&
    !empty($_POST['registerPass']) && isset($_POST['registerGender'])){

        makeNewUser($_POST['registerName'],$_POST['registerSur'],$_POST['registerAge'],
        $_POST['registerGender'],$_POST['registerEmail'],$_POST['registerUser'],
        $_POST['registerPass']);
        $_SESSION['newAcc'] = true;
        header('location: login.php');
        die();
    }
    else{
        $echoError = "<script>alert('Input fields are empty!')</script>";
		echo $echoError;
    }
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
            <div class="he">
            <div id="registerPart">
            <h1>Sign up your Account</h1>
            <!-- form to be submitted for registering -->
                <form action="register.php" method="POST" class="registerLa">
                    <div class="inner">
                        <div class="ouIn">
                        <label>First name<label><br><input type="text" name="registerName"/>
                        </div>
                        <div class="ouIn">
                        <label>Last name<label><br><input type="text" name="registerSur"/>
                        </div>
                        <div class="ouIn">
                        <label>Age<label><br><input type="number" name="registerAge"/>
                        </div>
                        <div class="ouIn">
                        <label>Email<label><br><input type="email" name="registerEmail"/>
                        </div>
                        <div class="ouIn">
                        <label>User name<label><br><input type="text" name="registerUser"/>
                        </div>
                        <div class="ouIn">
                        <label>password<label><br><input type="text" name="registerPass"/>
                        </div>
                        <div class="ouIn">
                        <label>Male</label><input type="radio" name="registerGender" value="male"/>
                        <label>Female</label><input type="radio" name="registerGender" value="female"/><br>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="btnRe">
                    <button class="sorat" type="submit" name="submit" value="submit">Register</button>
                    </div>
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

