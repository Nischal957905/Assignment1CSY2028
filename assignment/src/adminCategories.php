<?php
/*
This file is used for showing and projecting categories as well as editing and deleteing them from the database
also a link for the new creation is displayed here.
*/
//this line of code helps in starting session
session_start();
//required the respective file at least ones in this file
require_once 'insertInto.php';
require_once 'dbConnection.php';
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
//if the edit button is clicked this logic gets executed to redirect user to edit page.
if(isset($_POST['submit'])){
	$intVal = (int)$_POST['catIdd'];
	header('location: editCategory.php?catId='.$intVal);
	die();
}

if(isset($_POST['delCat'])){
	$intValCat = (int)$_POST['catIdd'];
	delCat($intValCat);
}

//logic that will get executed when the delete button is clicked and a session is set 
//on delete categories file. This code just alerts that the category has been deleted.
if(isset($_SESSION['catDeleted'])){
	if($_SESSION['catDeleted'] == true){
		$echoError = "<script>alert('Category Deleted!')</script>";
    	echo $echoError;
		unset($_SESSION['catDeleted']);
	}
	else{
		$echoError = "<script>alert('This category contains articles!')</script>";
    	echo $echoError;
		unset($_SESSION['catDeleted']);
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
		<title>Northampton News - Catrgory-Admin</title>
	</head>
	<body>
		<header>
			<section>
				<h1>Northampton News</h1>
			</section>
		</header>
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
				<h2>Category utility area.</h2>
				<a href="addCategory.php" class="articleCreateMapper" style="text-decoration:none;display:inline-block;background-color:green;color:white;padding:10px;">New Category</a>
				<br>

				<?php
					//Sql queries and implementation of php design for the categories shown in the admin category page.
					$projectCategories = "SELECT category_id,name FROM category";
					$storeProjection = $connection->prepare($projectCategories);
					$storeProjection->execute();
					while($eachCat = $storeProjection->fetch(PDO::FETCH_ASSOC)){
						echo '<a class="hik" href="categoryPage.php?catId='.$eachCat['category_id'].'"><div class="populate-cat">
						<h3>'.$eachCat['name'].'</h3><br>
						<p>All '.$eachCat['name'].' related articles.</p>
						<form action="adminCategories.php" method="POST">
							<input type="hidden" name="catIdd" value='.$eachCat['category_id'].'/>
							<button class="to" type="submit" name="submit" value="submit">edit</button>
						</form>
						<a class="no" href="deleteCategory.php?delCat='.$eachCat['category_id'].'" onClick="return delArt()">delete</a>
						</div></a>';
					}
				?>

			</article>
		</main>

		<footer>
			&copy; Northampton News 2017
		</footer>
		<!--  Javascript functions that will be used for alerting and 
		confirming while logging out, and other activities -->
		<script>
			function delArt(){
				return confirm('Do you really want to delete this article?');
			}
		</script>
		<script>
			function logOut(){
				return confirm('Do you really want to logout?');
			}
		</script>
	</body>
</html>
