/*
This file will be executed everytime the system gets composed. This file consists fo sql queries 
that are responsible for creating tables in the database.
*/

/*
Creating user_roles table to handle the authority provided to the user.
*/
CREATE TABLE user_roles(role_id int NOT NULL AUTO_INCREMENT,
role_name VARCHAR(20),PRIMARY KEY (role_id));

/*
Creating users table for storing any users that are registered
*/
CREATE TABLE users(user_id int NOT NULL AUTO_INCREMENT,firstname VARCHAR(20),
lastname VARCHAR(20),age int,gender VARCHAR(20),email VARCHAR(20) UNIQUE,
username VARCHAR(20) UNIQUE,password VARCHAR(200),role_id int,
PRIMARY KEY (user_id),
FOREIGN KEY (role_id) REFERENCES user_roles(role_id));

CREATE TABLE category(category_id int NOT NULL AUTO_INCREMENT,name VARCHAR(30),description VARCHAR(200),PRIMARY KEY (category_id));

CREATE TABLE article(article_id int NOT NULL AUTO_INCREMENT,title VARCHAR(100),publishDate DATE,latest_edit_date DATE,
author VARCHAR(20),categoryId int,content VARCHAR(5000),PRIMARY KEY (article_id),
FOREIGN KEY (categoryId) REFERENCES category(category_id));

CREATE TABLE comment(comment_id int NOT NULL AUTO_INCREMENT,article_id int,user_id int,comment_desc VARCHAR(100),
date_of_creation DATE,latest_edit_date DATE,PRIMARY KEY (comment_id),
FOREIGN KEY (article_id) REFERENCES article(article_id),
FOREIGN KEY (user_id) REFERENCES users(user_id));

/*
Data insertion into respective tables.
*/
INSERT INTO user_roles(role_name)
VALUES ('ADMIN');
INSERT INTO user_roles(role_name)
VALUES ('GUEST');

INSERT INTO users(firstname,lastname,age,gender,email,username,password,role_id)
VALUES ('CREATOR','CREATOR',100,'MALE','admin@gmail.com','ADMIN','$2y$10$fHE9mzxd.rpUi7Wb87eXmO0zSkVe6G4xiBXazF3bSpBmtoDM3Q6Du',1);