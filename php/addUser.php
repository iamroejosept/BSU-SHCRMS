<?php
	require_once 'Database.php';
  require 'centralConnection.php';
	date_default_timezone_set('Asia/Manila');

  $FirstName = $_POST['TxtFirstName'];
	$MiddleName = $_POST['TxtMiddleName'];
	$LastName = $_POST['TxtLastName'];
	$RadPosition = $_POST['RadPosition'];
	$RadAccLevel = $_POST['RadAccLevel'];
	$UserName = $_POST['TxtUsername'];
	$Password = $_POST['TxtPassword'];
  $Error;

	$Message = '';	


  	$ClinicRecordsDB = new Database($Server,$User,$DBPassword);

  	if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
        {     
          CheckAccount();
        }
      else
        {
          $Message = 'Failed to add user!';
          $Error = "1";
        }
    }  
  	else
    {
      $Message = 'Database Offline!';    
      $Error = "1";
    } 

    $XMLData = '';  
    $XMLData .= ' <output ';
    $XMLData .= ' Result = ' . '"'.$Message.'"';
    $XMLData .= ' Error = ' . '"'.$Error.'"';
    $XMLData .= ' />';
    
    //Generate XML output
    header('Content-Type: text/xml');
    //Generate XML header
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<Document>';      
    echo $XMLData;
    echo '</Document>';

    function StoreAccount()
  	{
    //Access Global Variables
    global $FirstName,$MiddleName,$LastName,$RadPosition,$RadAccLevel,$UserName,$Password;
    global $ClinicRecordsDB,$Message,$Error;    

    $UserName = strtolower($UserName);
    $FirstName = strtolower($FirstName);
    $MiddleName = strtolower($MiddleName);
    $LastName = strtolower($LastName);
    $RadPosition = strtolower($RadPosition);
    $RadAccLevel = strtolower($RadAccLevel);
    
    $hashed_password = password_hash($Password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO useraccounts 
              (UserName, Password, FirstName,MiddleName,LastName,Position,AccessLevel) 
              VALUES ('$UserName', '$hashed_password', '$FirstName','$MiddleName','$LastName','$RadPosition','$RadAccLevel')";    

    $Result = $ClinicRecordsDB->Execute($sql);
    $Message = 'Success!';   
    $Error = "0";       
  	}

    function CheckAccount(){
      //Access Global Variables
      global $FirstName,$LastName,$Message,$Error;
      global $ClinicRecordsDB;

      $FirstName = strtolower($FirstName);
      $LastName = strtolower($LastName);

      $sql = "SELECT * FROM USERACCOUNTS WHERE FirstName = '$FirstName' AND LastName = '$LastName'";
      $Result = $ClinicRecordsDB->Execute($sql);
      
      $ClinicRecordQuery = $ClinicRecordsDB->GetRows($sql);                
    
      if($ClinicRecordQuery)
      {            
        $Row = $ClinicRecordQuery->fetch_array();
        if($Row)
          {        
            $Message = "The user has an existing account.";
            $Error = "1";
          }else{
            StoreAccount();
          }           
      }
    }
?>