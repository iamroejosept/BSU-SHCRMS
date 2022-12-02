<?php
  require_once 'Database.php';
  require '../../../php/centralConnection.php';
  date_default_timezone_set('Asia/Manila');

  $TxtStudentIDNumber2 = $_POST['TxtStudentIDNumber2'];
  $TxtFirstName = $_POST['TxtFirstName'];
  $TxtMiddleName = $_POST['TxtMiddleName'];
  $TxtLastName = $_POST['TxtLastName'];
  $TxtExtension = $_POST['TxtExtension'];
  $TxtAge = $_POST['TxtAge'];
  $TxtSex = $_POST['TxtSex'];
  $TxtCourseStrand = $_POST['TxtCourseStrand'];
  $TxtYear = $_POST['TxtYear'];
  $TxtPhysician = $_POST['userFullN'];
  $TxtPhysicianIDNumber = $_POST['userID'];
  $TxtDate = $_POST['TxtDate'];
  $TxtComplaints = $_POST['TxtComplaints'];
  $TxtDiagnosis = $_POST['TxtDiagnosis'];
  $TxtDiagnosticTest = $_POST['TxtDiagnosticTest'];
  $TxtMedicineGiven = $_POST['TxtMedicineGiven'];
  $TxtTemperature = $_POST['TxtTemperature'];
  $TxtBP = $_POST['TxtBP'];
  $TxtPR = $_POST['TxtPR'];
  $RadSmoker = $_POST['RadSmoker'];
  $RadSanger = $_POST['RadSanger'];
  $RadMoma = $_POST['RadMoma'];
  $RadVS = $_POST['RadVS'];
  $TxtBooster = $_POST['TxtBooster'];
  $TxtVaccineBrand = $_POST['TxtVaccineBrand'];
  $TxtNumberOfStick = $_POST['TxtNumberOfStick'];
  $TxtNumberOfYears = $_POST['TxtNumberOfYears'];
  $TxtAgeStarted = $_POST['TxtAgeStarted'];
  $Others = $_POST['TxtOthers'];
  $TxtMomaSpan = $_POST['TxtMomaSpan'];
  $TxtRemarks = $_POST['TxtRemarks'];
  $TxtPhysicalFindings = $_POST['TxtPhysicalFindings'];
  $Error;

  $Message = '';  


    $ClinicRecordsDB = new Database($Server,$User,$DBPassword);

    if ($ClinicRecordsDB->Connect()==true)
    {
      $Result = $ClinicRecordsDB->SelectDatabase($Database);
                          
      if($Result == true)
        {     
          CheckID($TxtStudentIDNumber2);
        }
      else
        {
          $Message = 'Failed to store consultation!';
          $Error = "1";
        }
    }  
    else
    {
      $Message = 'Database offline!';    
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

    function CheckID($tempID){
      global $ClinicRecordsDB, $Message,$Error; 

      $sql = "SELECT StudentIDNumber FROM PersonalMedicalRecord WHERE StudentIDNumber = '$tempID' ";
      $Result = $ClinicRecordsDB->Execute($sql);
      $ClinicRecordQuery = $ClinicRecordsDB->GetRows($sql);  

      if($ClinicRecordQuery)
      {            
        $Row = $ClinicRecordQuery->fetch_array();            
        if($Row)
        {         
          StoreConsultation();   
        }else{
          $Message = 'No student record found. Please make sure to register first at the student page.';
          $Error = "1";
        }       
      }
    }

    function StoreConsultation()
    {
    //Access Global Variables

    global $TxtStudentIDNumber2,$TxtDate,$TxtLastName,$TxtFirstName,$TxtMiddleName,$TxtPhysician,
    $TxtPhysicianIDNumber,$RadSmoker,$RadSanger,$RadMoma,$RadVS,$TxtBooster,$TxtComplaints,$TxtDiagnosis,$TxtDiagnosticTest,$TxtMedicineGiven,$TxtTemperature,$TxtBP,$TxtPR, $TxtNumberOfStick,$TxtNumberOfYears,$TxtAgeStarted,$Others,$TxtMomaSpan,$TxtExtension,$TxtVaccineBrand,$TxtAge,$TxtSex,$TxtCourseStrand,$TxtYear,$TxtRemarks,$TxtPhysicalFindings;

       global $ClinicRecordsDB, $Message,$Error;   
            
        $TxtStudentIDNumber2 = strtolower($TxtStudentIDNumber2);
        $TxtExtension = strtolower($TxtExtension);
        $TxtDate = strtolower($TxtDate);
        $TxtLastName = strtolower($TxtLastName);
        $TxtFirstName = strtolower($TxtFirstName);
        $TxtMiddleName = strtolower($TxtMiddleName);
        $TxtSex = strtolower($TxtSex);
        $TxtCourseStrand = strtolower($TxtCourseStrand);
        $TxtPhysician = strtolower($TxtPhysician);
        $TxtPhysicianIDNumber = strtolower($TxtPhysicianIDNumber);
        $TxtTemperature = strtolower($TxtTemperature);
        $TxtBP = strtolower($TxtBP);
        $TxtPR = strtolower($TxtPR);
        $RadSmoker = strtolower($RadSmoker);
        $RadSanger = strtolower($RadSanger);
        $RadMoma = strtolower($RadMoma);
        $RadVS = strtolower($RadVS);
        $TxtBooster = strtolower($TxtBooster);
        $TxtNumberOfStick = strtolower($TxtNumberOfStick);
        $TxtNumberOfYears = strtolower($TxtNumberOfYears);
        $TxtAgeStarted = strtolower ($TxtAgeStarted);
        $Others = strtolower ($Others);
        $TxtMomaSpan = strtolower ($TxtMomaSpan);
        $TxtVaccineBrand = strtolower ($TxtVaccineBrand);
    
        $sql = "INSERT INTO ConsultationInfo 
                  (IdNumb, Dates, LastN, FirstN, MiddleN, Physician, PhysicianID, Complaints, Diagnosis, DiagnosticTestNeeded, MedicineGiven, Temperature, BloodPressure, PulseRate, Smoker, AlcoholDrinker, Moma, Vaccination, Booster, NumOfStick, NumOfYearAsSmoker, AgeStartedAsDrinker, Others, HowLongAsChewer, Extens, Vaccine, created_at, Ages, Sexs, CourseStrand, Years, PhysicalFindings, Remarks) 
                  VALUES ('$TxtStudentIDNumber2', '$TxtDate', '$TxtLastName', '$TxtFirstName', '$TxtMiddleName', '$TxtPhysician','$TxtPhysicianIDNumber ', '$TxtComplaints','$TxtDiagnosis','$TxtDiagnosticTest','$TxtMedicineGiven', '$TxtTemperature', '$TxtBP', '$TxtPR', '$RadSmoker', '$RadSanger', '$RadMoma', '$RadVS', '$TxtBooster', '$TxtNumberOfStick', '$TxtNumberOfYears', '$TxtAgeStarted', '$Others', '$TxtMomaSpan', '$TxtExtension', '$TxtVaccineBrand',CURRENT_TIMESTAMP, '$TxtAge', '$TxtSex', '$TxtCourseStrand', '$TxtYear', '$TxtPhysicalFindings', '$TxtRemarks')";    
    
        $Result = $ClinicRecordsDB->GetRows($sql);
        if($Result){
            $Message = 'Successfully stored!';   
            $Error = "0";
        }else{
            $Message = 'Database storing error!';   
            $Error = "1";
        }          
    }

   
?>