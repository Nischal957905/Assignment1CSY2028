<?php
/*
This page is used for projection of a single category and its details form the database.
*/
//this line of code helps in starting session
session_start();
//required the respective file at least ones in this file
require_once 'dbConnection.php';
require_once 'insertInto.php';
if(isset($_GET['loginStatus'])){
	$_SESSION['loggedOut'] = true;
	unset($_SESSION['onBoard']);
	unset($_SESSION['onBoardUser']);
	header('location: login.php');
	die();
}
?>
<!--
Structure designs that would be added in the front end page that this file refers to.
-->
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="styles.css?v=<?php echo time();?>"/>
		<title>
            <?php
                $val = returnTitle($_GET['catId']);
                echo $val;
            ?>
        </title>
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
		<main style="min-height:40vw;">
			<!-- Delete the <nav> element if the sidebar is not required -->
			<nav>
				<?php
					//DEtermining the admin and normal user view through this code.
					if(isset($_SESSION['onBoardUser'])){
						$valStatus = verifyAdmin($_SESSION['onBoardUser']);
							if($valStatus == true){
								echo '<ul>
								<li><a href="adminArticles.php">Articles</a></li>
								<li><a href="adminCategories.php">Categories</a></li>
								<li><a href="users.php">Users</a></li>
								<li><a href="manageAdmins.php">Manage Admin</a></li>
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
				<h2>
					<!--Function calling for returning the title of the category-->
                    <?php
                         $val = returnTitle($_GET['catId']);
                         echo $val;
                     ?>
                </h2>
				<?php
				//All SQL and php code implementation for showing the category informations in the page.
					$reCatDetails = "SELECT * FROM category WHERE category_id=:category_id";
					$reCatDetailsP = $connection->prepare($reCatDetails);
					$reCatDetailsP->execute(['category_id'=>$_GET['catId']]);
					while($cartVal = $reCatDetailsP->fetch(PDO::FETCH_ASSOC)){
						echo '<p>'.$cartVal['description'].'</p>';
					}
				?>
                <?php
				//codes of php and sql for displaying the articles associated with the category.
                    $category_id = (int)$_GET['catId'];                
                    $catArtSelection = "SELECT article_id,title,author,content,publishDate
                    FROM article
                    WHERE categoryId=:categoryId";
					$count = 0;
                    $getArtId = $connection->prepare($catArtSelection);
                    $getArtId->execute(['categoryId'=>$category_id]);
                    while($artVal = $getArtId->fetch(PDO::FETCH_ASSOC)){
						$count++;
						echo '<div class="outerConP">
						<div class="headStart">
						<h2><a class="hhk" href="article.php?artId='.$artVal['article_id'].'">'.$artVal['title'].'</a></h2>
						</div>
						<div class="dateStart">
									<em>'.$artVal['publishDate'].'</em><br><br>
								</div>
						<div class="contentStart">
							<p>'.$artVal['content'].'</p>
						</div>
						<div class="authorStart">
							<p>'.$artVal['author'].'</p>
						</div>';
				echo '</div>';
                    }
					//logic to handle situation when no article are assigned in the category
					if($count == 0){
						echo '<h2>There are no artciles assigned here.</h2>';
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
			function logOut(){
				return confirm('Do you really want to logout?');
			}
		</script>
	</body>
</html>
