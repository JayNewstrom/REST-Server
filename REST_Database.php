<?php
class REST_Database
{
      
       //connect to db, returns the connection, default database here, but otherwise you can specify another.
       private function connectToDB($server="localhost", $dbName="", $user="", $password="")
       {
              $dbConnection = mysql_pconnect($server, $user, $password);
              mysql_select_db($dbName, $dbConnection);
              return $dbConnection;
       }
      
       //this is not private because it can be used in child classes to escape specific pieces
       //of strings, in order to send up a pre-escaped string.
       function escapeString($string)
       {
              return mysql_real_escape_string($string, self::connectToDB());
       }
      
       //--------------------- SELECT STATEMENTS --------------------------------------------------------------------------------------------
       function dataRetrieval($SQL, $name, $preEscaped=false, $singleRow=false)
       {
              if($preEscaped == false)
                     $SQL = self::escapeString($SQL);
      
              $mysqlResult = mysql_query($SQL, self::connectToDB());
             
              if($singleRow == true)
                     $output = self::getObjectFromMySQLSingleRow($mysqlResult, $name);
              else
                     $output = self::getObjectFromMySQL($mysqlResult, $name);
             
              return $output;
       }
      
       //simple function to make an object, with a status code and an array out of what MySQL returns.
       private function getObjectFromMySQL($mysql, $title)
       {
              //we will start the status code off as good.
              //if something goes bad, we will set the status code to bad.
              $outputObj->statusCode = 0;
              $outputArray = array();
                    
              //we need to do this just to get the bad status code.
              if($row = mysql_fetch_object($mysql))
                     $outputArray[] = $row;
              else
                     $outputObj->statusCode = -1;
      
              //even though it looks like we are setting the array equal to the new row. this really just appends it to the end.
              //we could use an array_push($outputArray[], $row), but that is not as effecient. and we run through this function a lot.
              while($row = mysql_fetch_object($mysql))
                     $outputArray[] = $row;
      
              if($outputObj->statusCode == -1)
                     $outputObj->message = "There has been an error with the database.";
      
              //we only want to have the array in here if the status code is still good.
              //otherwise we just won't add it to the object.
              else
                     $outputObj->$title = $outputArray;
      
      
              return $outputObj;
       }
      
       //simple function to make an object, with a status code and an object, out of a single row of what MySQL returns.
       private function getObjectFromMySQLSingleRow($mysql, $title)
       {
              //we will start the status code off as good.
              //if something goes bad, we will set the status code to bad.
              $outputObj->statusCode = 0;
                    
              //we need to do this just to get the bad status code.
              if($row = mysql_fetch_object($mysql))
                     $outputObj->$title = $row;
              else
                     $outputObj->statusCode = -1;
      
      
              if($outputObj->statusCode == -1)
              {
                     $outputObj->message = "There has been an error with the database.";
              }
      
              return $outputObj;
       }
      
       //---------------------------------- INSERT STATEMENTS -----------------------------------------------------------------------------
       function dataAdd($SQL, $preEscaped=false)
       {
              if($preEscaped == false)
                     $SQL = self::escapeString($SQL);
      
              mysql_query($SQL, self::connectToDB());
      
              return self::getLastInsertID();
       }
      
       private function getLastInsertID()
       {
              $lastID = -1;
              $lastIDSQL =
                           "SELECT LAST_INSERT_ID() AS lastInsertID ";
      
              $result = self::dataRetrieval($lastIDSQL, 'a', true, true);
             
              if($result->statusCode == 0)
              {
                     $lastID = $result->a->lastInsertID;
              }
      
              return $lastID;
       }
      
       //---------------------------------- UPDATE STATEMENTS --------------------------------------------------------------------------------
       function dataUpdate($SQL, $preEscaped=false)
       {
              if($preEscaped == false)
                     $SQL = self::escapeString($SQL);
      
              mysql_query($SQL, self::connectToDB());
      
              return self::rowsAffected();
       }
      
       private function rowsAffected()
       {
              return mysql_affected_rows();
       }
      
       //----------------------------------- MISCELLANEOUS DATABASE FUNCTIONS ---------------------------------------------------------------
       function addStatementToWhereString($whereString, $incomingString)
       {
              if($whereString == "")
              {
                     $whereString = $incomingString;
              }
              else
              {
                     $whereString .= "AND " . $incomingString . " ";
              }
      
              return $whereString;
       }     
}

?>