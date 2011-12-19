<?php
	require_once 'ComputerRepair.php';

	function start($URI, $requestMethod)
	{
		if($requestMethod == 'GET')
		{
			if(preg_match("/^\/computerRepair\/test(\/)?$/", $URI))
			{
				echo json_encode(test());
			}
			else
				badRequest();
		}
		else 
			badRequest();
	}
?>
