<?php
	require_once 'Parent.php';
	
	function start($URI, $requestMethod)
	{
		$explodedURI = explode("/", $URI);
		
		if($requestMethod == 'GET')
		{
			if(preg_match("/^\/parent\/[0-9]{1,6}(\/)?$/", $URI))
			{
				$familyID = (int)$explodedURI[2];
				echo json_encode(getParents($familyID));
			}
			else
				badRequest();
		}
		else if($requestMethod == 'POST')
		{
			if(preg_match("/^\/parent(\/)?$/", $URI))
			{
				$parentObj = json_decode(file_get_contents("php://input"));
				echo json_encode(addParent($parentObj));
			}
			else
			badRequest();
		}
		else if($requestMethod == 'PUT')
		{
			if(preg_match("/^\/parent\/[0-9]{1,6}(\/)?$/", $URI))
			{
				$parentID = (int)$explodedURI[2];
				$parentObj = json_decode(file_get_contents("php://input"));
				echo json_encode(updateParent($parentID, $parentObj));
			}
			else
			badRequest();
		}
		else if($requestMethod == 'DELETE')
		{
			if(preg_match("/^\/parent\/[0-9]{1,6}(\/)?$/", $URI))
			{
				$parentID = (int)$explodedURI[2];
				echo json_encode(deleteParent($parentID));
			}
			else
			badRequest();
		}
		else
			badRequest();
	}
?>
