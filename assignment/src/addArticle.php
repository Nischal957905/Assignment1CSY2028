<?php
/*
This file is responsible for all the activities that gets executed while adding a new article into the
system. Necessary required codes for adding article into the database is located here.
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
//Whenever the form below is submitted this logic get executed and a new article is added into the database.
if(isset($_POST['submit'])){
    if(!empty($_POST['titleArticle']) && !empty($_POST['nameAuthor']) && isset($_POST['categories'])){
		$catIdVal = $_POST['categories'];
        dataInsertionArticle($_POST['titleArticle'],$catIdVal,$_POST['conArticle'],$_POST['nameAuthor']);
		$echoError = "<script>alert('New Article created!')</script>";
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
		<title>Northampton News - New Article</title>
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
							echo '<li><a onClick="return logOut()"  href="logout.php?loginStatus=true">Logout</a></li>';
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
				<h2>Create new Article.</h2>
                <p>Text goes in paragraphs</p>
				<!-- Form for adding article into the database  -->
				<form action="addArticle.php" method="POST">
					<p>Compose your article here:</p>

					<label>Title:</label> <input type="text" name="titleArticle"/>
                    <label>Author name:</label> <input type="text" name="nameAuthor"/>

                    <?php
						//logics for selecting available categories into the input field
                        $returnCatName = "SELECT category_id,name FROM category";
                        $valCatName = $connection->prepare($returnCatName);
                        $valCatName->execute();
						echo '<label>Category: </label><select name="categories">';
                        while($eachData = $valCatName->fetch(PDO::FETCH_ASSOC)) {
                           echo '<option value='.$eachData['category_id'].'>'.$eachData['name'].'</option>';
                        }
						echo '</select>';
                    ?>
					<label>Content:</label> <textarea name="conArticle"></textarea>

					<input type="submit" name="submit" value="Submit"/>
				</form>
			</article>
		</main>

		<footer>
			&copy; Northampton News 2017
		</footer>
		<script>
			function validReturnVal(){
				return alert('New Article created!');
			}
		</script>
	</body>
	<!--  Javascript functions that will be used for alerting and 
	confirming while logging out, and other activities -->
	<script>
			function logOut(){
				return confirm('Do you really want to logout?');
			}
		</script>
</html>
