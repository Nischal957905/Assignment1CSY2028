<?php
/*
Home page of the system holding latest 10 articles.
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
		<img src="images/banners/randombanner.php" />
		<main>
			<!-- Delete the <nav> element if the sidebar is not required -->
			<nav>
				<?php
					//DEtermining the admin and normal user view through this code.
					if(isset($_SESSION['onBoardUser'])){
						$valStatus = verifyAdmin($_SESSION['onBoardUser']);
							if($valStatus == true){
								echo '<ul>
								<li><a href="normalUserArticle.php">Articles</a></li>
								<li><a href="normalUserCategory.php">Category</a></li>
								<li><a href="adminArticles.php">Admin</a></li>
							</ul>';
							}
							else{
								echo '<ul>
								<li><a href="normalUserArticle.php">Articles</a></li>
								<li><a href="normalUserCategory.php">Category</a></li>
							</ul>';
							}
					}
					else{
						echo '<ul>
						<li><a href="normalUserArticle.php">Articles</a></li>
						<li><a href="normalUserCategory.php">Category</a></li>
					</ul>';
					}
				?>
			</nav>

			<article>
				<h2>All article</h2>
				<?php
				//Codes for projecting required articles in the index page in required format
					$queryArtProject = "SELECT article_id,title,publishDate,author,content
					FROM article 
					ORDER BY publishDate DESC";
					$getProjectArt = $connection->prepare($queryArtProject);
					$getProjectArt->execute();
					$count = 0;
					while($eachArt = $getProjectArt->fetch(PDO::FETCH_ASSOC)){
						echo '<div class="outerConP">
								<div class="headStart">
								<h2><a class="hhk" href="article.php?artId='.$eachArt['article_id'].'">'.$eachArt['title'].'</a></h2>
								</div>
								<div class="dateStart">
									<p>'.$eachArt['publishDate'].'</p>
								</div>
								<div class="contentStart">
									<p>'.$eachArt['content'].'</p>
								</div>
								<div class="authorStart">
									<p>'.$eachArt['author'].'</p>
								</div>';
						echo '</div>';
						$count++;
						if($count >= 10){
							break;
						}
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
			function validReturnVal(){
				return alert('Comment posted!');
			}
		</script>
		<script>
			function logOut(){
				return confirm('Do you really want to logout?');
			}
		</script>
	</body>
</html>
