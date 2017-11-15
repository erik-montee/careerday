<?php 

class DB {
	$servername;
	$username;
	$password;
	$database;

    function __construct()
    {
	    try 
	    {
            return $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
}