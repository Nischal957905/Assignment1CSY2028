<?php
/*
Important file that holds many reusable functions.
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
require_once 'dbConnection.php';

//function for inserting a new category
function dataInsertionCategory($catName,$catDesc){

    global $connection;
    $insertQuery = "INSERT INTO category(name,description) VALUES(:name,:description)";
    $implement = $connection->prepare($insertQuery);
    $implement->bindParam(':name',$name);
    $name = $catName;
    $implement->bindParam(':description',$description);
    $description = $catDesc;
    $implement->execute();
}

//function for inserting a new article
function dataInsertionArticle($artName,$catId,$conArt,$authorName){
    global $connection;
    $currentDate = date("Y/m/d");

    $insertQuery = "INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content) 
    VALUES(:title,:publishDate,:latest_edit_date,:author,:categoryId,:content)";
    $implement = $connection->prepare($insertQuery);
    $implement->bindParam(':title',$title);
    $title = $artName;
    $implement->bindParam(':publishDate',$publishDate);
    $publishDate = $currentDate;
    $implement->bindParam(':latest_edit_date',$latest_edit_date);
    $latest_edit_date = $currentDate;
    $implement->bindParam(':author',$author);
    $author = $authorName;
    $implement->bindParam(':categoryId',$categoryId);
    $categoryId = $catId;
    $implement->bindParam(':content',$content);
    $content = $conArt;
    $implement->execute();
}

//function for making a new user
function makeNewUser($registerName,$registerSur,$registerAge,$registerGender,$registerEmail,$registerUser,$registerPass){

    global $connection;
    $cryptEnPass = password_hash($registerPass,PASSWORD_DEFAULT);

    $preapredQueryUser = "INSERT INTO users(firstname,lastname,age,gender,email,username,password,role_id)
    VALUES (:firstname,:lastname,:age,:gender,:email,:username,:password,:role_id)";
    $implementUser = $connection->prepare($preapredQueryUser);
    $implementUser->bindParam(':firstname',$firstname);
    $firstname = $registerName;
    $implementUser->bindParam(':lastname',$lastname);
    $lastname = $registerSur;
    $implementUser->bindParam(':age',$age);
    $age = $registerAge;
    $implementUser->bindParam(':gender',$gender);
    $gender = $registerGender;
    $implementUser->bindParam(':email',$email);
    $email = $registerEmail;
    $implementUser->bindParam(':username',$username);
    $username = $registerUser;
    $implementUser->bindParam(':password',$password);
    $password = $cryptEnPass;
    $implementUser->bindParam(':role_id',$role_id);
    $role_id = 2;
    $implementUser->execute();

}

//function that returns the name of the category
function returnTitle($catId){
    
    $category_id = (int)$catId;
    global $connection;
    $titleSelection = "SELECT name FROM category WHERE category_id=:category_id";
    $getCatId = $connection->prepare($titleSelection);
    $getCatId->execute(['category_id'=>$category_id]);
    while($unVal = $getCatId->fetch(PDO::FETCH_ASSOC)){
        $valGot = $unVal['name'];
    }
    return $valGot;
}

//function that returns the title of the article
function returnTitleArticle($artId){
    
    $article_id = (int)$artId;
    global $connection;
    $titleSelection = "SELECT title FROM article WHERE article_id=:article_id";
    $getArtId = $connection->prepare($titleSelection);
    $getArtId->execute(['article_id'=>$article_id]);
    while($unVal = $getArtId->fetch(PDO::FETCH_ASSOC)){
        $valGot = $unVal['title'];
    }
    return $valGot;
}

//function for posting the comment
function insertComment($userEmail,$articleId,$textComment){

    global $connection;
    $currentDate = date("Y/m/d");

    $projectUserId = "SELECT user_id FROM users WHERE email=:email";
    $gainUserId = $connection->prepare($projectUserId);
    $gainUserId->execute(['email'=>$userEmail]);
    while($unUser = $gainUserId->fetch(PDO::FETCH_ASSOC)) {
        $re = $unUser['user_id'] ;
    }

    $insertCommentQuery = "INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
    VALUES(:article_id,:user_id,:comment_desc,:date_of_creation,:latest_edit_date)";
    $gainComment = $connection->prepare($insertCommentQuery);
    $gainComment->bindParam(':article_id',$article_id);
    $article_id = (int)$articleId;
    $gainComment->bindParam(':user_id',$user_id);
    $user_id = $re;
    $gainComment->bindParam(':comment_desc',$comment_desc);
    $comment_desc = $textComment;
    $gainComment->bindParam(':date_of_creation',$date_of_creation);
    $date_of_creation = $currentDate;
    $gainComment->bindParam(':latest_edit_date',$latest_edit_date);
    $latest_edit_date = $currentDate;
    $gainComment->execute();
}

//function that edits the category
function updateCat($catId,$catName,$catDesc){
    
    global $connection;
    $catInt = (int)$catId;
    $upQuery = "UPDATE category 
    SET name=:name,
    description=:description
    WHERE category_id=:category_id";

    $projectUp = $connection->prepare($upQuery);
    $projectUp->bindParam(':name',$name);
    $name = $catName;
    $projectUp->bindParam(':description',$description);
    $description = $catDesc;
    $projectUp->bindParam(':category_id',$category_id);
    $category_id = $catInt;
    $projectUp->execute();

}

//function that edits the admin
function updateAdmin($idAdmin,$userAdmin,$emailAdmin){

    global $connection;
    $adminInt = (int)$idAdmin;
    $upQueryAdmin = "UPDATE users SET email=:email,username=:username WHERE user_id=:user_id";
    $upAdmin = $connection->prepare($upQueryAdmin);
    $upAdmin->bindParam(':email',$email);
    $email = $emailAdmin;
    $upAdmin->bindParam(':username',$username);
    $username = $userAdmin;
    $upAdmin->bindParam(':user_id',$user_id);
    $user_id = $adminInt;
    $upAdmin->execute();
}

//function to edit the article
function updateArt($artId,$artTitle,$authorName,$artContent){

    global $connection;
    $artInt = (int)$artId;
    $currentDate = date("Y/m/d");

    $selQ = "UPDATE article
    SET title=:title,
    author=:author,
    content=:content,
    publishDate=:publishDate
    WHERE article_id=:article_id";

    $compileArt = $connection->prepare($selQ);
    $compileArt->bindParam(':title',$title);
    $title = $artTitle;
    $compileArt->bindParam(':author',$author);
    $author = $authorName;
    $compileArt->bindParam(':content',$content);
    $content = $artContent;
    $compileArt->bindParam(':publishDate',$publishDate);
    $publishDate = $currentDate;
    $compileArt->bindParam(':article_id',$article_id);
    $article_id = $artId;
    $compileArt->execute();
}

//function for deleting the article
function delArt($artId){

    global $connection;
    $artInt = (int)$artId;

    $delCatCOmment = "DELETE FROM comment WHERE article_id=:article_id";
    $projectExecutionnl = $connection->prepare($delCatCOmment);
    $projectExecutionnl->execute(['article_id'=>$artInt]);

    $delQuery = "DELETE FROM article WHERE article_id=:article_id";
    $projectExec = $connection->prepare($delQuery);
    $projectExec->execute(['article_id'=>$artInt]);
}

//function for deleting the admin
function delAdmin($adminId){

    global $connection;
    $adminInt = (int)$adminId;

    $delCommentAdmin = "DELETE FROM comment WHERE user_id=:user_id";
    $projectExecution = $connection->prepare($delCommentAdmin);
    $projectExecution->execute(['user_id'=>$adminInt]);

    $delQuery = "DELETE FROM users WHERE user_id=:user_id";
    $projectExec = $connection->prepare($delQuery);
    $projectExec->execute(['user_id'=>$adminInt]);
}

//function for deleting category
function delCat($catId){

    global $connection;
    $catInt = (int)$catId;

    $checkCatArt = "SELECT COUNT(categoryId) FROM article WHERE categoryId=:categoryId";
    $projectCheckCat = $connection->prepare($checkCatArt);
    $projectCheckCat->execute(['categoryId'=>$catInt]);

    while($slVal = $projectCheckCat->fetch(PDO::FETCH_ASSOC)){
        $countArtOnCat = $slVal['COUNT(categoryId)'];
    }
    
    if($countArtOnCat >= 1){
        return false;
    }
    else{
        $delCatId = "DELETE FROM category WHERE category_id=:category_id";
        $projectDelCat = $connection->prepare($delCatId);
        $projectDelCat->execute(['category_id'=>$catInt]);
        return true;
    }
}

//function for creating a new admin
function createNewAdmin($emailAdmin,$userAdmin,$passAdmin){

    global $connection;
    $cryptEnPass = password_hash($passAdmin,PASSWORD_DEFAULT);

    $qrNewAdmin = "INSERT INTO users(email,username,password,role_id)
    VALUES(:email,:username,:password,:role_id)";
    $prNewAdmin = $connection->prepare($qrNewAdmin);
    $prNewAdmin->bindParam(':email',$email);
    $email = $emailAdmin;
    $prNewAdmin->bindParam(':username',$username);
    $username = $userAdmin;
    $prNewAdmin->bindParam(':password',$password);
    $password = $cryptEnPass; 
    $prNewAdmin->bindParam(':role_id',$role_id);
    $role_id = 1;
    $prNewAdmin->execute();
}

//function that verifies whether the user is admin or not
function verifyAdmin($emailGet){

    global $connection;
    $verAdmin = "SELECT role_id FROM users WHERE email=:email";
    $projectAdminer = $connection->prepare($verAdmin);
    $projectAdminer->execute(['email'=>$emailGet]);
    while($unVal = $projectAdminer->fetch(PDO::FETCH_ASSOC)){
        $valGot = (int)$unVal['role_id'];
    }
    if($valGot == 1){
        return true;
    }
    else{
        return false;
    }
}

?>