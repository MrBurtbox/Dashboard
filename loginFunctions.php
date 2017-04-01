<?php
require('coreFunctions.php');
$userID = tokenChecker();
if(isset($_POST['username']) && isset($_POST['password'])){
	$conn = connDatabase($username = "root", $password = "", $database = "user", $ipaddress = "");	
	$SqlChecker = "SELECT * FROM account WHERE username = '".$_POST['username']."'";
	$result = $conn->query($SqlChecker);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fetchedSalt = $row["salt"];
			loginRequest($usrnme = $_POST['username'], $psswrd = $_POST['password'], $salt = $fetchedSalt);
		}
	}
}

if(!empty($userID)){
	$conn = connDatabase($username = "root", $password = "", $database = "user", $ipaddress = "");	
	$SqlChecker = "SELECT * FROM account WHERE userID = '".$userID."'";
	$result = $conn->query($SqlChecker);
	if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$fetchedUsername = $row["username"];
		$fetchedHashed = $row["hashedpassword"];
	}
	} else {
		echo "Token is invalid..";
	}	
} else {
	$userID = 'Randomer!';
}

//Token checker will check to see if the cookie is correct or not.
function tokenChecker(){
	if(isset($_COOKIE["LoginToken"])){
		if(!empty($_COOKIE["LoginToken"])){
			$LoginToken = $_COOKIE["LoginToken"];
			$conn = connDatabase($username = "root", $password = "", $database = "user", $ipaddress = "");	
			$SqlChecker = "SELECT userID, LoginToken FROM account WHERE LoginToken = '".$LoginToken."'";
			$result = $conn->query($SqlChecker);
			
			
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					return $row["userID"];
				}
			} 	
			
		}
	}
}
//How i create the passwords used for account creation, 
function createPassword($psswrd, $salt){
	if(isset($psswrd)){
		if(!empty($psswrd)){
			$hashed = crypt($psswrd, $salt);
			return $hashed;
		}
	}
}

//Requests a LoginToken
function loginRequest($usrnme, $psswrd, $salt){
	if(isset($usrnme) && isset($psswrd) && isset($salt)){
		if(!empty($usrnme) && !empty($psswrd) && !empty($salt)){
			$hashed = crypt($psswrd, $salt);
			echo $hashed;
			$continue = true;
		}
	}		
	
	if($continue == true){
		$conn = connDatabase($username = "root", $password = "", $database = "user", $ipaddress = "");	
		$checkPassword = "SELECT userID, username, hashedpassword FROM account WHERE hashedpassword = '".$hashed."' AND username = '".$usrnme."'";
		$result = $conn->query($checkPassword);

		echo $checkPassword;
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
			$value = generateRandomString($length = 16);
			createLoginCookie($value);
			$insertToken = "UPDATE account SET LoginToken= '".$value."' WHERE username = '".$usrnme."'";
			$insertedTkn = $conn->query($insertToken);
			if ($conn->query($insertedTkn) === TRUE) {echo "New record created successfully";}
			header('Location: /');
			}
		} else {
			header('Location: /');
		}		
	}
}

function createLoginCookie($value){
	if(isset($value)){
		if(!empty($value)){
			setcookie("LoginToken", $value , time() + (86400 * 30), "/");
		}
	}
}

function createUsername($user = 'mrburtbox', $psswrd = 'burt'){
	$conn = connDatabase($username = "root", $password = "", $database = "user", $ipaddress = "");	
	$user = "mrburtbox";

	$salt = generateRandomString($length = 15);
	$userID = generateRandomString($length = 25);

	$hash = createPassword($psswrd = "mrburtbox", $salt);
	
	$sql = "INSERT INTO account (userID, username, hashedpassword, salt) VALUES ('".$userID."', '".$user."', '".$hash."', '".$salt."')";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

//Connects to the Database
function connDatabase($username, $password, $database, $ipAddress){
	if(!empty($username) || $username == ""){
		$servername = "localhost";
		$conn = mysqli_connect($servername, $username, $password, $database);
		if(!$conn){
			die("Connection failed: " . mysqli_connect_error());
		} else {
			return $conn; 
		}
	}else {
		echo "No username specified";
	}
}

//Grabs all records from the database
function connectTable($tableName, $conn, $row, $filter){
	if(!empty($conn)){
		if(!empty($tableName)){
			$sql = "SELECT * from ".$tableName." WHERE ".$row." = ".$filter."";
			$result = $conn->query($sql);
			return $result;
		}
	} else {
		die("Table not specified, connection aborted");
	}
}


function passwordCreate($user_input, $username){
	if(!empty($user_input)){
		$Cryptpassword = crypt($user_input, $username);
		return $Cryptpassword;
	}
}

//Drop database
function dropDB($databaseName, $conn){
	if(!empty($conn)){
		if(!empty($databaseName)){
			$sql = "DROP DATABASE ".$databaseName."";
			if ($conn->query($sql) === TRUE) {
				echo "Database ' ".$databaseName." ' dropped successfully <br>";
			} else {
				echo "Error creating database: " . $conn->error;
			}
		} else {
			die("Database not specified");
		}
	} else {
		die("Connection to server wasn't defined");
	}
}

//Create a Database
function createDB($databaseName, $conn){
	if(!empty($conn)){
		if(!empty($databaseName)){
			$sql = "CREATE DATABASE ".$databaseName."";
			if ($conn->query($sql) === TRUE) {
				echo "Database ' ".$databaseName." ' created successfully <br>";
			} else {
				echo "Error creating database: " . $conn->error;
			}
		} else {
			die("Database not specified");
		}
	} else {
		die("Connection to server wasn't defined");
	}
}



function getCookie(){
	if(isset($_COOKIE["LoginToken"])){
		return $_COOKIE["LoginToken"];
	}
}


?>