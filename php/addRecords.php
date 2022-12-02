<?php
  require_once 'Database.php';
  require 'centralConnection.php';
	date_default_timezone_set('Asia/Manila');

  $tab = $_POST['tab'];
  $Message = '';
  $Error;

  // Receive Data from Client
  if($tab=="0"){
    $TxtPerIDNumForm = $_POST['TxtPerIDNumForm'];
    $TxtFirstName = $_POST['TxtFirstName'];
    $TxtMiddleName = $_POST['TxtMiddleName'];
    $TxtLastName = $_POST['TxtLastName'];
    $TxtContNumStudent = $_POST['TxtContNumStudent'];
    $TxtAddress = $_POST['TxtAddress'];
    $TxtAge = $_POST['TxtAge'];
    $TxtBirthday = $_POST['TxtBirthday'];
    $RadSex = $_POST['RadSex'];
    $TxtHeight = $_POST['TxtHeight'];
    $TxtWeight = $_POST['TxtWeight'];
    $TxtContPer = $_POST['TxtContPer'];
    $TxtContNumGuardian = $_POST['TxtContNumGuardian'];
    $TxtCourse = $_POST['TxtCourse'];
    
    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
      {   
        CheckRecord($TxtPerIDNumForm);
      }
      else
      {
        $Message = 'Failed to add information!';
        $Error = "1";
      }
    }  
    else
    {
      $Message = 'The database is offline!';    
      $Error = "1";
    }
  }else{
    $TxtMedIDNumForm = $_POST['TxtMedIDNumForm'];
    $TxtPhysician = $_POST['TxtPhysician'];
    $TxtDate = $_POST['TxtDate'];
    $TxtTemperature = $_POST['TxtTemperature'];
    $TxtPR = $_POST['TxtPR'];
    $TxtBP = $_POST['TxtBP'];
    $TxtComplaints = $_POST['TxtComplaints'];
    $TxtDiagnosis = $_POST['TxtDiagnosis'];
    $TxtReferredTo = $_POST['TxtReferredTo'];
    $TxtDiagnosticTestNeeded = $_POST['TxtDiagnosticTestNeeded'];
    $TxtMedicineGiven = $_POST['TxtMedicineGiven'];
    $TxtLicenseNumber = $_POST['TxtLicenseNumber'];
    $TxtLMP = $_POST['TxtLMP'];
    $TxtPregnancy = $_POST['TxtPregnancy'];
    $TxtAllergies = $_POST['TxtAllergies'];
    $TxtSurgeries = $_POST['TxtSurgeries'];
    $TxtInjuries = $_POST['TxtInjuries'];
    $TxtIllness = $_POST['TxtIllness'];
    $TxtHearingDistance = $_POST['TxtHearingDistance'];
    $TxtSpeech = $_POST['TxtSpeech'];
    $TxtHead = $_POST['TxtHead'];
    $TxtEyes = $_POST['TxtEyes'];
    $TxtEars = $_POST['TxtEars'];
    $TxtNose = $_POST['TxtNose'];
    $TxtAbdomen = $_POST['TxtAbdomen'];
    $TxtGenitoUrinary = $_POST['TxtGenitoUrinary'];
    $TxtLymphGlands = $_POST['TxtLymphGlands'];
    $TxtSkin = $_POST['TxtSkin'];
    $TxtExtremities = $_POST['TxtExtremities'];
    $TxtDeformities = $_POST['TxtDeformities'];
    $TxtCavityAndThroat = $_POST['TxtCavityAndThroat'];
    $TxtLungs = $_POST['TxtLungs'];
    $TxtHeart = $_POST['TxtHeart'];
    $TxtBreast = $_POST['TxtBreast'];
    $TxtWOGOD = $_POST['TxtWOGOD'];
    $TxtWOGOS = $_POST['TxtWOGOS'];
    $TxtWGOD = $_POST['TxtWGOD'];
    $TxtWGOS = $_POST['TxtWGOS'];

    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
      {   
        CheckRecord($TxtMedIDNumForm);
      }
      else
      {
        $Message = 'Failed to add information!';
        $Error = "1";
      }
    }  
    else
    {
      $Message = 'The database is offline!';   
      $Error = "1"; 
    }
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

  function CheckRecord($IDNum){
    $IDNumber = $IDNum;
    $sql;

    //Access Global Variables
    global $ClinicRecordsDB, $Message, $tab, $Error;  
    
      $sql = "SELECT PerIDNum FROM PersonalInformation WHERE PerIDNum = '$IDNumber' ";

      $Result = $ClinicRecordsDB->Execute($sql);
      
      $ClinicRecordQuery = $ClinicRecordsDB->GetRows($sql);                
    
      if($ClinicRecordQuery)
      {            
        $Row = $ClinicRecordQuery->fetch_array();            
        if($Row)
        {         
          if($tab == "0"){
            $Message = 'The record already exist. If you want to make changes to the record, go to the update page.';
            $Error = "1";
          }else{
            StoreData();
          }             
        }else{
          if($tab == "0"){
            StoreData();
          }else{
            $Message = 'There was no personal information discovered. First, register the student personal information.';
            $Error = "1";
          } 
        }       
      }
  }

  function StoreData()
  {
    global $tab,$ClinicRecordsDB,$Message,$Error;

    if($tab=="0"){
      global $TxtPerIDNumForm,$TxtFirstName,$TxtMiddleName,$TxtLastName,$TxtContNumStudent,$TxtAddress,$TxtAge,$TxtBirthday,$RadSex,$TxtHeight,$TxtWeight,$TxtContPer,$TxtContNumGuardian,$TxtCourse;

      $TxtFirstName = strtolower($TxtFirstName);
      $TxtMiddleName = strtolower($TxtMiddleName);
      $TxtLastName = strtolower($TxtLastName);
      $TxtAddress = strtolower($TxtAddress);
      $RadSex = strtolower($RadSex);
      $TxtContPer = strtolower($TxtContPer);
      $TxtCourse = strtolower($TxtCourse);

      $sql = "INSERT INTO PersonalInformation 
              (PerIDNum,Course,FirstName,MiddleName,LastName,ContNumStudent,Address,Age,Birthday,Sex,Height,Weight,ContPer,ContNumGuardian) 
              VALUES ('$TxtPerIDNumForm','$TxtCourse','$TxtFirstName','$TxtMiddleName','$TxtLastName','$TxtContNumStudent','$TxtAddress','$TxtAge','$TxtBirthday','$RadSex','$TxtHeight','$TxtWeight','$TxtContPer','$TxtContNumGuardian')";  

      $Result = $ClinicRecordsDB->Execute($sql);
      $Message = 'Successfully added the information!'; 
      $Error = "0";
    }else{
      global $TxtMedIDNumForm,$TxtPhysician,$TxtDate,$TxtTemperature,$TxtPR,$TxtBP,$TxtComplaints,$TxtDiagnosis,$TxtReferredTo,$TxtDiagnosticTestNeeded,$TxtMedicineGiven,$TxtLicenseNumber,$TxtLMP,$TxtPregnancy,$TxtAllergies,$TxtSurgeries,$TxtInjuries,$TxtIllness,$TxtHearingDistance,$TxtSpeech,$TxtHead,$TxtEyes,$TxtEars,$TxtNose,$TxtAbdomen,$TxtGenitoUrinary,$TxtLymphGlands,$TxtSkin,$TxtExtremities,$TxtDeformities,$TxtCavityAndThroat,$TxtLungs,$TxtHeart,$TxtBreast,$TxtWOGOD,$TxtWOGOS,$TxtWGOD,$TxtWGOS;

      $TxtPhysician = strtolower($TxtPhysician);
      $TxtComplaints = strtolower($TxtComplaints);
      $TxtDiagnosis = strtolower($TxtDiagnosis);
      $TxtReferredTo = strtolower($TxtReferredTo);
      $TxtDiagnosticTestNeeded = strtolower($TxtDiagnosticTestNeeded);
      $TxtMedicineGiven = strtolower($TxtMedicineGiven);
      $TxtLMP = strtolower($TxtLMP);
      $TxtPregnancy = strtolower($TxtPregnancy);
      $TxtAllergies = strtolower($TxtAllergies);
      $TxtSurgeries = strtolower($TxtSurgeries);
      $TxtInjuries = strtolower($TxtInjuries);
      $TxtIllness = strtolower($TxtIllness);
      $TxtHearingDistance = strtolower($TxtHearingDistance);
      $TxtSpeech = strtolower($TxtSpeech);
      $TxtHead = strtolower($TxtHead);
      $TxtEyes = strtolower($TxtEyes);
      $TxtEars = strtolower($TxtEars);
      $TxtNose = strtolower($TxtNose);
      $TxtAbdomen = strtolower($TxtAbdomen);
      $TxtGenitoUrinary = strtolower($TxtGenitoUrinary);
      $TxtLymphGlands = strtolower($TxtLymphGlands);
      $TxtSkin = strtolower($TxtSkin);
      $TxtExtremities = strtolower($TxtExtremities);
      $TxtDeformities = strtolower($TxtDeformities);
      $TxtCavityAndThroat = strtolower($TxtCavityAndThroat);
      $TxtLungs = strtolower($TxtLungs);
      $TxtHeart = strtolower($TxtHeart);
      $TxtBreast = strtolower($TxtBreast);
      $TxtWOGOD = strtolower($TxtWOGOD);
      $TxtWOGOS = strtolower($TxtWOGOS);
      $TxtWGOD = strtolower($TxtWGOD);
      $TxtWGOS = strtolower($TxtWGOS);

      $sql = "INSERT INTO MedicalInformation 
              (MedIDNum,Physician,LicenseNumber,ConsultDate,LMP,Pregnancy,Allergies,Surgeries,Injuries,Illness,HearingDistance,Speech,Head,Eyes,Ears,Nose,Abdomen,GenitoUrinary,LymphGlands,Skin,Extremities,Deformities,CavityAndThroat,Lungs,Heart,Breast,WOGOD,WOGOS,WGOD,WGOS,Temperature,PR,BP,Complaints,Diagnosis,ReferredTo,DiagnosticTest,MedsGiven) 
              VALUES ('$TxtMedIDNumForm','$TxtPhysician','$TxtLicenseNumber','$TxtDate','$TxtLMP','$TxtPregnancy','$TxtAllergies','$TxtSurgeries','$TxtInjuries','$TxtIllness','$TxtHearingDistance','$TxtSpeech','$TxtHead','$TxtEyes','$TxtEars','$TxtNose','$TxtAbdomen','$TxtGenitoUrinary','$TxtLymphGlands','$TxtSkin','$TxtExtremities','$TxtDeformities','$TxtCavityAndThroat','$TxtLungs','$TxtHeart','$TxtBreast','$TxtWOGOD','$TxtWOGOS','$TxtWGOD','$TxtWGOS','$TxtTemperature','$TxtPR','$TxtBP','$TxtComplaints','$TxtDiagnosis','$TxtReferredTo','$TxtDiagnosticTestNeeded','$TxtMedicineGiven')";

      $Result = $ClinicRecordsDB->Execute($sql);
      $Message = 'Successfully added the information!'; 
      $Error = "0";
    }            
  }  
?>
