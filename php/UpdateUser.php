<?php
  require_once 'Database.php';
  require 'centralConnection.php';
	date_default_timezone_set('Asia/Manila');

  $Message = '';

  $Error;

    // Receive Data from Client
    $TxtFirstName = $_POST['TxtFirstName'];
    $TxtMiddleName = $_POST['TxtMiddleName'];
    $TxtLastName = $_POST['TxtLastName'];
    $TxtPosition = $_POST['TxtPosition'];
    $TxtAccessLevel = $_POST['TxtAccessLevel'];
    $TxtUsername = $_POST['TxtUsername'];
    $TxtPassword = $_POST['TxtPassword'];
    $Num = $_POST['Num'];
    
    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
      {   
        UpdateUser();
      }
      else
      {
        $Message = 'Failed to update information!';
        $Error = "1";
      }
    }  
    else
    {
      $Message = 'The database is offline!';   
      $Error = "1"; 
    }

    $XMLData = '';	
    $XMLData .= ' <output ';
    $XMLData .= ' Message = ' . '"'.$Message.'"';
    $XMLData .= ' Error = ' . '"'.$Error.'"';
    $XMLData .= ' />';
    
    //Generate XML output
    header('Content-Type: text/xml');
    //Generate XML header
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    echo '<Document>';    	
    echo $XMLData;
    echo '</Document>';

    function UpdateUser(){
    $sql;

    //Access Global Variables
    global $Error, $ClinicRecordsDB, $Message, $TxtFirstName, $TxtMiddleName, $TxtLastName, $TxtPosition, $TxtAccessLevel, $TxtUsername, $TxtPassword, $Num;  

    $TxtUsername = strtolower($TxtUsername);
    $TxtFirstName = strtolower($TxtFirstName);
    $TxtMiddleName = strtolower($TxtMiddleName);
    $TxtLastName = strtolower($TxtLastName);
    $TxtPosition = strtolower($TxtPosition);
    $TxtAccessLevel = strtolower($TxtAccessLevel);

    $hashedPass = password_hash($TxtPassword, PASSWORD_DEFAULT);
    
      $sql = "UPDATE USERACCOUNTS SET UserName='$TxtUsername', Password='$hashedPass', FirstName='$TxtFirstName', MiddleName='$TxtMiddleName', LastName='$TxtLastName', Position='$TxtPosition', AccessLevel='$TxtAccessLevel' WHERE Num='$Num'";

      $Result = $ClinicRecordsDB->Execute($sql);
      
      $Message = 'The user information is updated successfully!'; 
      $Error = "0"; 
    }
?>
