<?php
/*
One of the major files that is responsible for buildinf connection of our system with the database.
The codes below here will be used at most of the classes for creating the connection with the database.
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

$server = 'db';
$username = 'root';
$passwordDb = 'kirito';
$dbName = 'assignment1';

$connection = new PDO("mysql:host=$server; dbname=$dbName;",$username,$passwordDb);
?>