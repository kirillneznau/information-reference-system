<?php  
	$dbhost = 'localhost';
	$dbname = 'shuher';
	$dbuser = 'root';
	$dbpass = 'root';

	$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($connection->connect_error) die("Fatal Error2");

	function createTable($name, $query){
		queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
		echo "Таблица '$name' создана или уже существовала<br>";
	}


	function queryMysql($query){
		global $connection;
		$result = $connection->query($query);
		if (!$result) die("Fatal Error1");
		return $result;
	}

	function destroySession(){
		$_SESSION = array();
		if (session_id() != "" || isset($_COOKIE[session_name()]))
			setcookie(session_name(), '', time()-2592000, '/');
		session_destroy();
	}

	function sanitizeString($var){
		global $connection;
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return $connection->real_escape_string($var);
	}

?>