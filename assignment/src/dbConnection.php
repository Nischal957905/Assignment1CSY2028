<?php
/*
One of the major files that is responsible for buildinf connection of our system with the database.
The codes below here will be used at most of the classes for creating the connection with the database.
*/   

$server = 'db';
$username = 'root';
$passwordDb = 'kirito';
$dbName = 'assignment1';

$connection = new PDO("mysql:host=$server; dbname=$dbName;",$username,$passwordDb);
?>