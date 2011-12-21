<?php
	$URI = $_SERVER['REQUEST_URI'];
	$requestMethod = $_SERVER['REQUEST_METHOD'];
	$explodedURI = explode("/", $URI);
	
	$slimURI = "";
	$URILength = count($explodedURI);
	for($i = 2; $i < $URILength; $i++)
		$slimURI .= "/" . $explodedURI[$i];
	
	$APIclass = $explodedURI[2];
	$file = $APIclass . "Control.php";
	
	if(!file_exists($file))
	{
		badRequest();
		exit;
	}
	
	require_once $file;
	
	start($slimURI, $requestMethod);
	
	function badRequest()
	{
		header('HTTP/1.0 404 Not Found');
		$obj->statusCode = -1;
		$obj->errorMessage = "There is no REST method associated with that URI and Method";
	
		echo json_encode($obj);
	}
?>
