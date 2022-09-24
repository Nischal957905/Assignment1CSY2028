/*
This file will be executed everytime the system gets composed. This file consists fo sql queries 
that are responsible for inserting into below mentioned tables in the database.
*/

INSERT INTO category(name,description)
VALUES('Sports','All articles on sports.');

INSERT INTO category(name,description)
VALUES('Anime','All articles on anime.');

INSERT INTO category(name,description)
VALUES('Music','All articles on music.');

INSERT INTO category(name,description)
VALUES('Fashion','All articles on fashion.');

INSERT INTO category(name,description)
VALUES('Technology','All articles on technology.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('Upcoming World Cup','2022-08-07','2022-08-07','Anynomous Mr.',1,'Upcoming world cup is seen to 
become one of the most fascinating thing happening out there. Also many visitors are expected to be 
seen in the stadium.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('Major retirement','2022-08-09','2022-08-09','Hikari tsubaki.',1,'Major talks has been going on recently on the
retirement of two major football players. Considered to be legends in their respective fields ronaldo and messi 
are discussed here.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('Overhype anticipation','2022-08-10','2022-08-10','Kokomi Subaru',2,'Upcoming anime chainsaw man is currently 
on the top at the charts prediciting the popularity. It has been able to grab the attention of most of viewers 
this season.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('Downfall on rising','2022-08-13','2022-08-13','Kokomi Subaru',2,'Popular anime which was successful on grabbing 
huge fan attention and love on season one has been on their downfall in new season. This matter is similar to the 
prevoius falls.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('Trending As it Was','2022-08-15','2022-08-15','Tyler John',3,'Popular artist Harry styles new music "As it was" 
has been on the global charts for a long period of time. After the break of the band this has been on of the most 
amazing moments for fans.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('Music taste on fall','2022-08-17','2022-08-17','Angel angelina',3,'As time has been moving on change on music has 
been seen throughout the time. But nowadays some of the so called artists has been destroying the concept behind the 
true music.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('Trends all the way','2022-08-19','2022-08-19','Clark remark',4,'Trendy airforces has been the dreams of every 
youngsters nowadays. The true versio of these goods are hard to be discovered in the stores. And teh genuine ones costs 
a lot.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('Ripped And Torned','2022-08-19','2022-08-19','Clark remark',4,'Weird taste of fashion involving ripped shirts and 
torned pants has been seen lately. Questionable sense for fashion in these people has been emerging lately. Cheap and 
kinda trendy.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('New Apples Iphone 14','2022-08-23','2022-08-23','Tech app',5,'With the new release of apples product apple is seeing 
a massive growth within the past 10 days of the launch of iphone 14. A lot of income has been generated for the company
with the launch.');

INSERT INTO article(title,publishDate,latest_edit_date,author,categoryId,content)
VALUES('Lenovo new gen laptop','2022-08-25','2022-08-25','New gen tech',5,'A remarkable feat that no one has been able to 
achieve till this date has been recently acquired by the tech giants lenovo. It has been achieved with the creation of 
new model v6Lap.');

INSERT INTO users(firstname,lastname,age,gender,email,username,password,role_id)
VALUES ('Kirigaya','Kazuto',19,'MALE','kirito@gmail.com','Kirito','$2y$10$fHE9mzxd.rpUi7Wb87eXmO0zSkVe6G4xiBXazF3bSpBmtoDM3Q6Du',2);

INSERT INTO users(firstname,lastname,age,gender,email,username,password,role_id)
VALUES ('Kiyotaka','Ayanokoji',19,'MALE','ayano@gmail.com','Ayanokouji','$2y$10$EXgwxVdzIv7VeJwHzUXoHueqbdJMHsX0G34lzMzSTaxVCwijgmLuS',2);

INSERT INTO users(firstname,lastname,age,gender,email,username,password,role_id)
VALUES ('Pekora','Usada',111,'FEMALE','pekora@gmail.com','Pekora','$2y$10$MSFI8ZlV86aXwpXUaz9cWOIHl4zFzShd4gXmASw8kgNio4sTA8ufG',2);

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (1,2,'Yeah kinda looking forward for!','2022-08-23','2022-08-23');

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (2,3,'Ahh I will use all the pawns!','2022-08-24','2022-08-24');

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (3,4,'I am quite excited for it.','2022-08-25','2022-08-25');

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (4,2,'They really did bad in this.','2022-08-26','2022-08-26');

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (5,3,'I kinda like this. I mean its good!','2022-08-27','2022-08-27');

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (6,4,'Yeah you are right! Come listen my music instead.','2022-08-28','2022-08-28');

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (7,2,'Ohh seems quite informative!','2022-08-23','2022-08-23');

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (8,3,'Ughh. Just gonna use them as pawns','2022-08-28','2022-08-28');

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (9,4,'I am gonna buy it today!','2022-08-29','2022-08-29');

INSERT INTO comment(article_id,user_id,comment_desc,date_of_creation,latest_edit_date)
VALUES (10,2,'Hoh! can they bring out the full dives?','2022-08-27','2022-08-27');





