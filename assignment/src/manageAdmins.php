<?php
/*
This file is used for showing and projecting admins as well as editing and deleteing them from the database
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
//Logic that lets us delete the admin when the delete button is clicked
if(isset($_GET['delAdminId'])){
	if($_GET['delAdminEmail'] != $_SESSION['onBoardUser']){
		delAdmin($_GET['delAdminId']);
		header('location: manageAdmins.php');
		die();
	}
	//code to prevent self deletion of admin
	else{
		$echoError = "<script>alert('Cannot process Self deletion!')</script>";
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
		<title>Northampton News - Admins</title>
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
				<h2>Manage admin accounts.</h2>
				<a href="addAdmin.php" class="articleCreateMapper" style="text-decoration:none;display:inline-block;background-color:green;color:white;padding:10px;">New Admin</a>
				<br>

				<?php
				//Code to project admin accounts in the page along with edit and delete buttons
					$projectAdmin = "SELECT email,username,user_id FROM users WHERE role_id=1";
					$storeProjection = $connection->prepare($projectAdmin);
					$storeProjection->execute();
					while($eachAdmin = $storeProjection->fetch(PDO::FETCH_ASSOC)){
						echo '<div class="populate-cat">
						<h3>'.$eachAdmin['username'].'</h3><br>
						<p>'.$eachAdmin['email'].'</p>
						<a class="to" href="editAdmin.php?adminId='.$eachAdmin['user_id'].'">edit</a>
						<a class="no" onClick="return delArt()" href="manageAdmins.php?delAdminId='.$eachAdmin['user_id'].'&delAdminEmail='.$eachAdmin['email'].'">delete</a>
						</div>';
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
				return confirm('Do you really want to delete this admin?');
			}
		</script>
		<script>
			function logOut(){
				return confirm('Do you really want to logout?');
			}
		</script>
	</body>
</html>
