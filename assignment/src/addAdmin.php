<?php
/*
This file is responsible for all the activities that gets executed while adding a new admin into the
system. Necessary required codes for adding admin into the database is located here.
*/
//this line of code helps in starting session
session_start();
//required the respective file at least ones in this file
require_once 'dbConnection.php';
require_once 'insertInto.php';
//logic on if statement that controls the authorization in this page.
//Allows only users with permissions to access this pages protected content.
if(!isset($_SESSION['onBoard']) && !isset($_SESSION['onBoardUser'])){
	header('location: noAccess.php');
	die();
}
//logic to identify if the logged in user is admin or not.
//Only allows admin users to access the protected content in this page
if(isset($_SESSION['onBoardUser'])){
	$valStatus = verifyAdmin($_SESSION['onBoardUser']);
	if($valStatus == false){
		header('location: noAccess.php');
	    die();
	}
}			
//Whenever the form below is submitted this logic get executed and a new admin is added into the database.
if(isset($_POST['submit'])){
    if(!empty($_POST['adminEmail']) && !empty($_POST['adminUser']) && !empty($_POST['adminPass'])){
        createNewAdmin($_POST['adminEmail'],$_POST['adminUser'],$_POST['adminPass']);
		$echoError = "<script>alert('New Admin created!')</script>";
		echo $echoError;
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
		<link rel="stylesheet" href="styles.css"/>
		<title>Northampton News - NewAdmin</title>
	</head>
	<body>
		<header>
			<section>
				<h1 style="font-size=20px;">Northampton News</h1>
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
				<?php
					//Logic that will check if user is logged in or not. Then if user is logged in shows logout 
					//in navigation bar else shows login.
					if(isset($_SESSION['onBoard'])){
						if($_SESSION['onBoard'] == false){
							echo '<li><a href="login.php">Login</a></li>';
						}
						else{
							echo '<li><a onClick="return logOut()" href="logout.php?loginStatus=true">Logout</a></li>';
						}
					}
					else{
						echo '<li><a href="login.php">Login</a></li>';
					}
				?>
			</ul>
		</nav>
		<main style="width:98.7vw;">
			<!-- Delete the <nav> element if the sidebar is not required -->
			<nav>
				<ul>
					<li><a href="adminArticles.php">Articles</a></li>
					<li><a href="adminCategories.php">Categories</a></li>
					<li><a href="users.php">Users</a></li>
					<li><a href="manageAdmins.php">Manage Admin</a></li>
				</ul>
			</nav>

			<article>
				<h2>Create new Admin</h2>
                <p>Text goes in paragraphs</p>
				<!-- Form for adding admin into the database  -->
				<form action="addAdmin.php" method="POST">
					<p>Compose your article here:</p>

					<label>Email:</label> <input type="email" name="adminEmail"/>
                    <label>Username:</label> <input type="text" name="adminUser"/>
					<label>Password:</label> <input type="text" name="adminPass"/>
					<input type="submit" name="submit" value="Submit"/>
				</form>
			</article>
		</main>

		<footer>
			&copy; Northampton News 2017
		</footer>
	</body>
	<!--  Javascript functions that will be used for alerting and 
	confirming while logging out, and other activities -->
	<script>
			function logOut(){
				return confirm('Do you really want to logout?');
			}
		</script>
</html>
