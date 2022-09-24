<?php
/*
This page is used for projection of a single article and its details form the database.
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
//Whenever a user tries to post the comment this code gets executed and posts the comment in the database
if(isset($_POST['submit'])){
	if(!empty($_POST['commentR'])){
		$intVal = (int)$_POST['artIdd'];
		insertComment($_SESSION['onBoardUser'],$_POST['artIdd'],$_POST['commentR']);
		$_SESSION['postedComment'] = true;
		header('location: article.php?artId='.$intVal);
	}
	else{
		$intVal = (int)$_POST['artIdd'];
		header('location: article.php?artId='.$intVal);
	}
}
//Session logic to show alert message when successfully inserting a comment.
if(isset($_SESSION['postedComment'])){
	$echoError = "<script>alert('Successfully Posted a comment!')</script>";
	echo $echoError;
	unset($_SESSION['postedComment']);
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
                $val = returnTitleArticle($_GET['artId']);
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
		<main style="width:98.7vw;">
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
				<h2 style="padding-bottom:10px;border-bottom : 2px solid black;">
                    <?php
					//function calling for returning the title of the article.
                         $val = returnTitleArticle($_GET['artId']);
                         echo $val;
                     ?>
                </h2>
                <?php
					//SQL queries and php codes for projecting articles details in the page.
                    $article_id = (int)$_GET['artId'];                
                    $artSelection = "SELECT * FROM article WHERE article_id=:article_id"; 
                    $getArtId = $connection->prepare($artSelection);
                    $getArtId->execute(['article_id'=>$article_id]);
                    while($artVal = $getArtId->fetch(PDO::FETCH_ASSOC)){
                        echo '<label>Written on</label><br><br><em>'.$artVal['publishDate'].'</em><br><br><br>
						<p>'.$artVal['content'].'</p><br>
                        <h4>Written by '.$artVal['author'].'</h4><br>
						<em>Last edited: '.$artVal['latest_edit_date'].'</em>';
						if(isset($_SESSION['onBoardUser'])){
							echo '<form action="article.php" method="POST">
							<div>
							<label>Comment: </label> <textarea name="commentR"></textarea>
						<input type="submit" name="submit" value="Submit" />
						<input type="hidden" name="artIdd" value='.$artVal['article_id'].'/>
							</div>
							</form>';
						};
						echo '<div class="newwer"><h5>All comments</h5></div>';
							$artCommentId = "SELECT * FROM comment WHERE article_id=:article_id";
					$projectComment = $connection->prepare($artCommentId);
					$projectComment->execute(['article_id'=>$article_id]);
					while($comArt = $projectComment->fetch(PDO::FETCH_ASSOC)){
						$selUserId = (int)$comArt['user_id'];
						$findUserNick = "SELECT username FROM users WHERE user_id=:user_id";
						$newUserNick = $connection->prepare($findUserNick);
						$newUserNick->execute(['user_id'=>$selUserId]);
						echo '<div class="newStyo">';
						while($comUser = $newUserNick->fetch(PDO::FETCH_ASSOC)){
							echo '<a class="hoverMe" style="text-decoration:none;" href="userComments.php?userID='.$comArt['user_id'].'&articleId='.$article_id.'"><p>'.$comUser['username'].'</p></a>';
							echo '<p>'.$comArt['date_of_creation'].'</p>';
							echo '<p>'.$comArt['comment_desc'].'</p>';
						}
						echo '</div>';
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
			function logOut(){
				return confirm('Do you really want to logout?');
			}
		</script>
	</body>
</html>
