<?php
	require_once 'REST_Database.php';
	/*
	 * @param int $familyID the family id
	*
	* @return 	object	with status code, and an array of parents for the specified family id.
	*/
	function getParents($familyID)
	{
		$familyID = (int)REST_Database::escapeString($familyID);
				
		$parentsSQL = "SELECT "
			. "p.parent_id AS parentID, "
			. "p.first_name AS firstName, "
			. "p.last_name AS lastName, "
			. "p.email, "
			. "p.phone, "
			. "p.cell_phone AS cellPhone, "
			. "p.address, "
			. "p.city, "
			. "p.state, "
			. "p.zip "
		. "FROM parent p "
		. "WHERE p.family_id = $familyID ";
	
		return REST_Database::dataRetrieval($parentsSQL, 'parents', true);
	}
	
	/*
	* 
	*
	* @return 	object	with status code
	*/
	function addParent($parentObj)
	{
		$familyID = (int)REST_Database::escapeString($parentObj->familyID);
		$firstName = REST_Database::escapeString($parentObj->firstName);
		$lastName = REST_Database::escapeString($parentObj->lastName);
		
		if(isset($parentObj->email))
			$email = REST_Database::escapeString($parentObj->email);
		else 
			$email = "";
		
		if(isset($parentObj->phone))
			$phone = REST_Database::escapeString($parentObj->phone);
		else
			$phone = "";
		
		if(isset($parentObj->cellPhone))
			$cellPhone = REST_Database::escapeString($parentObj->cellPhone);
		else
			$cellPhone = "";
		
		if(isset($parentObj->address))
			$address = REST_Database::escapeString($parentObj->address);
		else
			$address = "";
		
		if(isset($parentObj->address))
			$address = REST_Database::escapeString($parentObj->address);
		else
			$address = "";
		
		if(isset($parentObj->city))
			$city = REST_Database::escapeString($parentObj->city);
		else
			$city = "";
		
		if(isset($parentObj->state))
			$state = REST_Database::escapeString($parentObj->state);
		else
			$state = "";
		
		if(isset($parentObj->zip))
			$zip = REST_Database::escapeString($parentObj->zip);
		else
			$zip = "";
		
		$addParentSQL = "INSERT INTO parent SET "
			. "family_id = $familyID, "
			. "first_name = '$firstName', "
			. "last_name = '$lastName', "
			. "email = '$email', "
			. "phone = '$phone', "
			. "cell_phone = '$cellPhone', "
			. "address = '$address', "
			. "city = '$city', "
			. "state = '$state', "
			. "zip = '$zip' ";
		
		$parentID = REST_Database::dataAdd($addParentSQL, true);
		if($parentID > 0)
		{
			$returnObj->statusCode = 0;
			$returnObj->parentID = (int)$parentID;
		}
		else
		{
			$returnObj->statusCode = -1;
		}
		
		return $returnObj;
	}
	
	/*
	*
	*
	* @return 	object	with status code
	*/
	function updateParent($parentID, $parentObj)
	{
		$firstName = REST_Database::escapeString($parentObj->firstName);
		$lastName = REST_Database::escapeString($parentObj->lastName);
		
		if(isset($parentObj->email))
			$email = REST_Database::escapeString($parentObj->email);
		else
			$email = "";
		
		if(isset($parentObj->phone))
			$phone = REST_Database::escapeString($parentObj->phone);
		else
			$phone = "";
		
		if(isset($parentObj->cellPhone))
			$cellPhone = REST_Database::escapeString($parentObj->cellPhone);
		else
			$cellPhone = "";
		
		if(isset($parentObj->address))
			$address = REST_Database::escapeString($parentObj->address);
		else
			$address = "";
		
		if(isset($parentObj->address))
			$address = REST_Database::escapeString($parentObj->address);
		else
			$address = "";
		
		if(isset($parentObj->city))
			$city = REST_Database::escapeString($parentObj->city);
		else
			$city = "";
		
		if(isset($parentObj->state))
			$state = REST_Database::escapeString($parentObj->state);
		else
			$state = "";
		
		if(isset($parentObj->zip))
			$zip = REST_Database::escapeString($parentObj->zip);
		else
			$zip = "";
		
		$addParentSQL = "UPDATE parent SET "
			. "first_name = '$firstName', "
			. "last_name = '$lastName', "
			. "email = '$email', "
			. "phone = '$phone', "
			. "cell_phone = '$cellPhone', "
			. "address = '$address', "
			. "city = '$city', "
			. "state = '$state', "
			. "zip = '$zip' "
		. "WHERE parent_id = $parentID ";
		
		$parentID = REST_Database::dataAdd($addParentSQL, true);
		if($parentID > 0)
		{
			$returnObj->statusCode = 0;
			$returnObj->parentID = (int)$parentID;
		}
		else
		{
			$returnObj->statusCode = -1;
		}
		
		return $returnObj;
	}
	
	function deleteParent($parentID)
	{
		$deleteParentSQL = "DELETE FROM parent WHERE parent_id = $parentID";
		$rowsAffected = REST_Database::dataUpdate($deleteParentSQL, true);
		if($rowsAffected == 1)
		{
			$returnObj->statusCode = 0;
			$returnObj->rowsAffected = (int)$rowsAffected;
		}
		else
		{
			$returnObj->statusCode = -1;
		}
		
		return $returnObj;
	}
?>