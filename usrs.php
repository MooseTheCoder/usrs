<?php

/* SRT CONNECTION STUFF */

$username 	= "root";
$password 	= "";
$database 	= "usrs";
$host 		= "localhost";
$userTable 	= "users";
$db		= mysqli_connect($host,$username,$password,$database);

/* END CONNECTION STUFF */

function dumpAllUserData(){
	/*
	
		DUMPS ALL INFO FOR EVERY USER IN DATABASE
	
	*/
	global $db;
	global $userTable;
	$q = mysqli_query($db,"SELECT * FROM $userTable");
	$u = [];
	while($y = mysqli_fetch_assoc($q)){
		$u[]=$y;
	}
	return pretty(json_encode($u));
}

function dumpUserData($id){
	/*
	
		DUMPS ALL INFO FOR GIVEN USER
	
	*/
	global $db;
	global $userTable;
	$q = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM $userTable WHERE id=$id"));
	return pretty(json_encode($q));
}

function createUser($o){
	/*
	
		CREATES NEW USER IN DATABASE
	
	*/
	if(!isset($o['username'])){
		return false;
	}
	if(!isset($o['password'])){
		return false;
	}
	$username = strval($o['username']);
	$password = strval($o['password']);
	global $db;
	global $userTable;
	if(mysqli_query($db,"INSERT INTO $userTable (username,password) VALUES ('$username','$password')")){
		return true;
	}else{
		return false;
	}
}

function updateUserPassword($o){
	/*
	
		UPDATES PASSWORD OF A GIVEN USER
	
	*/
	global $db;
	global $userTable;
	$id = intval($o['id']);
	if(!isset($o['password'])){
		return "No password given";
	}
	$password = addslashes($o['password']);
	if(mysqli_query($db,"UPDATE $userTable SET password='$password' WHERE id=$id")){
		return true;
	}else{
		return false;
	}
}

function updateUserMeta($o){
	/*
	
		UPDATES META OF A GIVEN USER
	
	*/
	global $db;
	global $userTable;
	$id = intval($o['id']);
		if(!isset($o['meta'])){
		return "No meta given";
	}
	$meta = addslashes($o['meta']);
	if(mysqli_query($db,"UPDATE $userTable SET meta='$meta' WHERE id=$id")){
		return true;
	}else{
		return false;
	}
}

function auth($o){
	/*
	
		MATCH A USERNAME AND PASSWORD
	
	*/
	global $db;
	global $userTable;
	if(!isset($o['username'])){
		return false;
	}
	if(!isset($o['password'])){
		return false;
	}
	$username = strval($o['username']);
	$password = $o['password'];
	$u = mysqli_fetch_array(mysqli_query($db,"SELECT password FROM $userTable WHERE username='$username'"));
	$dap = $u['password'];
	if(!$password == $dap){
		return false;
	}else{
		return true;
	}
}

function getUserMeta($id){
	/*
	
		RETURN USER META
	
	*/
	$id=intval($id);
	global $db;
	global $userTable;
	$q = mysqli_fetch_array(mysqli_query($db,"SELECT meta FROM users WHERE id='$id'"));
	return json_encode($q['meta']);
}

function deleteUser($id){
	/*
	
		DELETES USER OF GIVEN ID
	
	*/
	$id = intval($id);
	global $db;
	global $userTable;
	if(mysqli_query($db,"DELETE FROM $userTable WHERE id=$id")){
		return true;
	}else{
		return false;
	}
}

function s($in){
	return sha1($in);
}
/* JSON PRETTY PRITNING -> THANK YOU STACKOVERFLOW */

function pretty($json) {
 
    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '<span style="margin-left:1em;"></span>';
    $newLine     = "<br>";
    $prevChar    = '';
    $outOfQuotes = true;
 
    for ($i=0; $i<=$strLen; $i++) {
 
        // Grab the next character in the string.
        $char = substr($json, $i, 1);
 
        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;
 
        // If this character is the end of an element, 
        // output a new line and indent the next line.
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }
 
        // Add the character to the result string.
        $result .= $char;
 
        // If the last character was the beginning of an element, 
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }
 
            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }
 
        $prevChar = $char;
    }
 
    return $result;
}
