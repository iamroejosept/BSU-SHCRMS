<?php 
require '../../../php/centralConnection.php';
 session_start();
 if(empty($_SESSION['logged_in'])){
 header('Location: ../../../index.html');
}
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Consultation</title>
        <link rel="stylesheet" href="../css/addConsultation-style.css">
        <link rel = "icon" href = "../images/BSU-Logo.png" type = "image/x-icon">
        <script src="../dist/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="../dist/jquery-confirm.min.css">
        <script src="../dist/jquery-confirm.min.js"></script>
        <script src="../js/script-tab.js"></script>
        <script src="../dist/jspdf.debug.js"></script>
        <script src="../dist/jspdf.min.js"></script>
        <script src="../dist/html2pdf.bundle.min.js"></script>
        <style>
        @media print{
            #wholetab{
                display: none;
            }

            #twoButton, #exportButton, nav, #tab1{
                display: none;
            }

            .container{
                margin-top: 0;
                padding-top: 0;
            }

            #bsuLogo{
                width: 0.60in;
                height: 0.60in;
            }

            #topHeader{
                margin-bottom: -7.5%;
            }

            textarea{
                font-size: 1.75vw;
            }
        }
        </style>
        <script type="text/javascript">

        // ---------------------------start functions for System Logs---------------------------------------
            var act = "";
            var getType ="";
            var globalAL = "";

            async function clickedPDF(){
                const element = document.getElementById('toDownloadPDF');

                $.confirm({
                        title: '',
                        content: 'Exporting file. Please wait.',
                        theme: 'supervan',
                        buttons: 
                        {
                            Yes:{ 
                                text: ' ',                          
                                btnClass: 'btn-red'
                            }
                        }
                    }); 

                const nodeList= document.querySelectorAll("input");
                for (let i = 0; i < nodeList.length; i++) {
                    nodeList[i].style.fontSize = "10px";
                } 
                const nodeList1= document.querySelectorAll("label");
                for (let i = 0; i < nodeList1.length; i++) {
                    nodeList1[i].style.fontSize = "10px";
                } 
                const nodeList2= document.querySelectorAll("select");
                for (let i = 0; i < nodeList2.length; i++) {
                    nodeList2[i].style.fontSize = "10px";
                    nodeList2[i].style.height = "3vh";
                } 
                const nodeList3= document.querySelectorAll("span");
                for (let i = 0; i < nodeList3.length; i++) {
                    nodeList3[i].style.fontSize = "10px";
                } 
                const nodeList4= document.querySelectorAll("legend");
                for (let i = 0; i < nodeList4.length; i++) {
                    nodeList4[i].style.fontSize = "11px";
                } 
                const nodeList5= document.querySelectorAll("h3");
                for (let i = 0; i < nodeList5.length; i++) {
                    nodeList5[i].style.fontSize = "12px";
                } 
                const nodeList6= document.querySelectorAll("div");
                for (let i = 0; i < nodeList6.length; i++) {
                    nodeList6[i].style.marginTop = "-2.5px";
                } toDownloadPDF
                
                document.getElementById('bsuLogo').style.width = "75px";
                document.getElementById('bsuLogo').style.height = "75px";
                document.getElementById('bsuCon').style.paddingTop = "5%";
                document.getElementById('tabs-bodyID').style.backgroundColor = "white";
                document.getElementById('toDownloadPDF').style.marginTop = "0";
                document.getElementById('toDownloadPDF').style.paddingTop = "0";
                document.getElementById('tab1').style.display = "none";
                document.getElementById('wholetab').style.display = "none";
				
                var opt = {
                    margin: 0.5,
                    filename: 'Consultation.pdf',
                    jsPDF:{
                        orientation: 'p', 
                        unit: 'in',
                        format: 'legal'
                    }
                };

				html2pdf().set(opt).from(element).save().then(
                    function(){
                        setTimeout(function(){
                            location.reload();
                        }, 5000);
                    }
                );
            }

            function openManual(){
                if(globalAL == "admin"){
                    window.open("../../../files/ManualAdmin.pdf");
                }else if(globalAL == "superadmin"){
                    window.open("../../../files/ManualSuperadmin.pdf");
                }else{
                    window.open("../../../files/ManualStandard.pdf");                }
            }

            function clickedPrint(printID){
                const printBTN = document.getElementById(printID);

                printBTN.addEventListener('click', function(){
                    print();
                });
            }

            function fetchName(){
                var temp = document.getElementById('TxtStudentIDNumber2').value;
                
                var form_data = new FormData();
                form_data.append("temp", temp);

                $.ajax(
                { 
                    url:"../php/FetchName.php",
                    method:"POST",
                    data:form_data, 
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: "xml",
                    success:function(xml)
                    {
                        $(xml).find('output').each(function()
                        {
                            var message = $(this).attr('Message');
                            var error = $(this).attr('Error');
                            var FirstName = $(this).attr('FirstName');
                            var MiddleName = $(this).attr('MiddleName');
                            var LastName = $(this).attr('LastName');
                            var Extension = $(this).attr('Extension');
                            var Age = $(this).attr('Age');
                            var Sex = $(this).attr('Sex');
                            var CourseStrand = $(this).attr('CourseStrand');
                            var Year = $(this).attr('Year');
                        
                            if(error == "1"){
                            //Display Alert Box
                                $.alert(
                                {theme: 'modern',
                                    content: message,
                                    title:'', 
                                    buttons:{
                                    Ok:{
                                        text:'Ok',
                                        btnClass: 'btn-red'
                                    }}});

                                    $('#TxtFirstName').val('');
                                    $('#TxtMiddleName').val('');
                                    $('#TxtLastName').val('');
                                    $('#TxtExtension').val('');
                                    $('#TxtAge').val('');
                                    $('#TxtSex').val('');
                                    $('#TxtCourseStrand').val('');
                                    $('#TxtYear').val('');

                                   
                            }else{
                                    $('#TxtFirstName').val(FirstName);
                                    $('#TxtMiddleName').val(MiddleName);
                                    $('#TxtLastName').val(LastName);
                                    $('#TxtExtension').val(Extension);
                                    $('#TxtAge').val(Age);
                                    $('#TxtSex').val(Sex);
                                    $('#TxtCourseStrand').val(CourseStrand);
                                    $('#TxtYear').val(Year);

                                /* //Display Alert Box
                                $.alert(
                                {theme: 'modern',
                                content: message,
                                title:'', 
                                buttons:{
                                    Ok:{
                                    text:'Ok',
                                    btnClass: 'btn-green'
                                }}}); */
                            }

                                
                        });
                    },  
                    error: function (e)
                    {
                        //Display Alert Box
                        $.alert(
                        {theme: 'modern',
                        content:'Failed to fetch information due to error',
                        title:'', 
                        useBootstrap: false,
                        buttons:{
                            Ok:{
                            text:'Ok',
                            btnClass: 'btn-red'
                        }}});
                    }
                });
            }

            function alphaName(event){
                var key = event.keyCode;
                return ((key >= 65 && key <= 90) || key == 8 || key == 32 || key == 189);
            }

            //function called when logout tab pressed
            function logout(){
                act = "Logged out";
                logAction(act);
                  $.ajax({
                    url:"../../../php/logout.php",
                    method:"POST",
                    data:"",
                    success:function(xml){
                        sessionStorage.clear();
                        setTimeout(function(){
                            window.location.href = '../../../index.html';
                        }, 100);
                    }
                  })
            }

            //main function for user activity logging
            function logAction(userAction){
                act = userAction;
                $.ajax({
                    url:"../../../php/logAction.php",
                    method:"POST",
                    data:jQuery.param({ action: act, isSuccess:"1" }),
                    dataType: "xml",
                    success:function(xml){

                    }
                  })
            }

            function editTableNav(y){
                if(y == "checkArchived"){
                    document.getElementById('tab1').innerHTML = '&bull;&nbsp;Archived Consultation&nbsp;&bull;';
                    document.getElementById('nav5').classList.remove("active");
                    document.getElementById('nav6').classList.add("active");
                    document.getElementById('maint').classList.add("active");
                    document.getElementById('maint').style.color = "white";
                }else{
                    document.getElementById('tab1').innerHTML = '&bull;&nbsp;Consultation&nbsp;&bull;';
                }
            }

            //called to log user clicking "logs" tab
            function userCheckLogs(){
                act = "Checked user activities." 
                logAction(act);
            }
        // ---------------------------end functions for System Logs---------------------------------------

            var TempSmoker;
            var TempSanger;
            var TempMoma;
            var TempVaccination;
            var TempBtnValue;
            var TempNum;

            function styleInput(idnum){
                document.getElementById(idnum).style.background = "none";  
                document.getElementById(idnum).style.borderBottom = "solid 2px black";    
                document.getElementById(idnum).style.borderTop = "solid 1px gray"; 
                document.getElementById(idnum).style.borderRight = "solid 1px gray"; 
                document.getElementById(idnum).style.borderLeft = "solid 1px gray";  
            }

            function hideButton(){
                document.getElementById("twoButton").style.display = "none";
                document.getElementById('exportButton').style.display = 'none';
                
            }

            function passIDPHP(x){
                var form_data = new FormData();
                var Num = x;
                TempNum = x;
                form_data.append("numb", Num);
                form_data.append("temp", "1");
                form_data.append("type", getType);

                $.ajax(
                { 
                    url:"../php/FetchRecords.php",
                    method:"POST",
                    data:form_data, 
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: "xml",
                    success:function(xml)
                    {
                        $(xml).find('output').each(function()
                        {
                            var message = $(this).attr('Message');
                            var error = $(this).attr('Error');
                            var StudentIDNumber = $(this).attr('StudentIDNumber');
                            var FirstName = $(this).attr('FirstName');
                            var MiddleName = $(this).attr('MiddleName');
                            var LastName = $(this).attr('LastName');
                            var Extension = $(this).attr('Extension');
                            var Age = $(this).attr('Age');
                            var Sex = $(this).attr('Sex');
                            var CourseStrand = $(this).attr('CourseStrand');
                            var Year = $(this).attr('Year');
                            var Physician = $(this).attr('Physician');
                            var PhysicianIDNumber = $(this).attr('PhysicianIDNumber');
                            var Date = $(this).attr('Date');
                            var Complaints = $(this).attr('Complaints');
                            var Diagnosis = $(this).attr('Diagnosis');
                            var DiagnosticTest = $(this).attr('DiagnosticTest');
                            var MedicineGiven = $(this).attr('MedicineGiven');
                            var Remarks = $(this).attr('Remarks');
                            var PhysicalFindings = $(this).attr('PhysicalFindings');

                            var Temperature = $(this).attr('Temperature');
                            var BP = $(this).attr('BP');
                            var PR = $(this).attr('PR');
                            var Smoker = $(this).attr('Smoker');
                            var Sanger = $(this).attr('Sanger');
                            var Moma = $(this).attr('Moma');
                            var VS = $(this).attr('VS');
                            var NumOfStick = $(this).attr('NumOfStick');
                            var NumOfYearAsSmoker = $(this).attr('NumOfYearAsSmoker');
                            var AgeStartedAsDrinker = $(this).attr('AgeStartedAsDrinker');
                            var Others = $(this).attr('Others');
                            var HowLongAsChewer = $(this).attr('HowLongAsChewer');
                            var Booster = $(this).attr('Booster');
                            var VaccineBrand = $(this).attr('VaccineBrand');
                        
                            if(error == "1"){
                            //Display Alert Box
                                /* $.alert(
                                {theme: 'modern',
                                    content: message,
                                    title:'', 
                                    buttons:{
                                    Ok:{
                                        text:'Ok',
                                        btnClass: 'btn-red'
                                    }}}); */

                                   
                                    $('#TxtStudentIDNumber2').val('');
                                    $('#TxtFirstName').val('');
                                    $('#TxtMiddleName').val('');
                                    $('#TxtLastName').val('');
                                    $('#TxtExtension').val('');
                                    $('#TxtAge').val('');
                                    $('#TxtSex').val('');
                                    $('#TxtCourseStrand').val('');
                                    $('#TxtYear').val('');
                                    document.getElementById('TxtMSIDNumber1').innerHTML = 'ID Number:';
                                    document.getElementById('TxtMSFullName').innerHTML = 'Charted By:';
                                    $('#TxtDate').val('');
                                    $('#TxtComplaints').val('');
                                    $('#TxtDiagnosis').val('');
                                    $('#TxtDiagnosticTest').val('');
                                    $('#TxtMedicineGiven').val('');
                                    $('#TxtRemarks').val('');
                                    $('#TxtPhysicalFindings').val('');

                                    $('#TxtTemperature').val('');
                                    $('#TxtBP').val('');
                                    $('#TxtPR').val('');
                                    $('#RadSmoker').val('');
                                    $('#RadSanger').val('');
                                    $('#RadMoma').val('');
                                    $('#RadVS').val('');
                                    $('#TxtBooster').val('');
                                    $('#TxtVaccineBrand').val('');
                                    $('#TxtNumberOfStick').val('');
                                    $('#TxtNumberOfYears').val('');
                                    $('#TxtAgeStarted').val('');
                                    $('#TxtOthers').val('');
                                    $('#TxtMomaSpan').val('');
                            }else{
                                    
                                    $('#TxtStudentIDNumber2').val(StudentIDNumber);
                                    $('#TxtFirstName').val(FirstName);
                                    $('#TxtMiddleName').val(MiddleName);
                                    $('#TxtLastName').val(LastName);
                                    $('#TxtExtension').val(Extension);
                                    $('#TxtAge').val(Age);
                                    $('#TxtSex').val(Sex);
                                    $('#TxtCourseStrand').val(CourseStrand);
                                    $('#TxtYear').val(Year);
                                    document.getElementById('TxtMSIDNumber1').innerHTML = 'ID Number: ' + PhysicianIDNumber;
                                    document.getElementById('TxtMSFullName').innerHTML = 'Charted By: ' + Physician.toUpperCase();
                                    $('#TxtDate').val(Date);
                                    $('#TxtComplaints').val(Complaints);
                                    $('#TxtDiagnosis').val(Diagnosis);
                                    $('#TxtDiagnosticTest').val(DiagnosticTest);
                                    $('#TxtMedicineGiven').val(MedicineGiven);
                                    $('#TxtRemarks').val(Remarks);
                                    $('#TxtPhysicalFindings').val(PhysicalFindings);

                                    $('#TxtTemperature').val(Temperature);
                                    $('#TxtBP').val(BP);
                                    $('#TxtPR').val(PR);
                                    if(Smoker == "yes"){
                                        $('#RadSmokerYes').prop('checked', true);
                                        clickedSmokingYes();
                                    }else{
                                        $('#RadSmokerNo').prop('checked', true);
                                    }
                                    if(Sanger == "yes"){
                                        $('#RadSangerYes').prop('checked', true);
                                        clickedDrinkerYes();
                                    }else{
                                        $('#RadSangerNo').prop('checked', true);
                                    }
                                    if(Moma == "yes"){
                                        $('#RadMomaYes').prop('checked', true);
                                        clickedChewerYes();
                                    }else{
                                        $('#RadMomaNo').prop('checked', true);
                                    }
                                    if(VS == "fully vaccinated"){
                                        $('#RadFully').prop('checked', true);
                                        clickedVaccinated();
                                    }else{
                                        $('#RadNot').prop('checked', true);
                                    }
                                    if(Booster == "without booster"){
                                        document.getElementById("WOBooster").setAttribute('selected','selected');
                                    }else if(Booster == "booster 1"){
                                        document.getElementById("Booster1").setAttribute('selected','selected');
                                    }else if(Booster == "booster 2"){
                                        document.getElementById("Booster2").setAttribute('selected','selected');
                                    } 

                                     if(VaccineBrand == "aztrazeneca pharmaceuticals"){
                                        document.getElementById("AP").setAttribute('selected','selected');
                                    }else if(VaccineBrand == "bharat biotechs covaxin"){
                                        document.getElementById("BBC").setAttribute('selected','selected');
                                    }else if(VaccineBrand == "janssen vaccine"){
                                        document.getElementById("Janssen").setAttribute('selected','selected');
                                    }else if(VaccineBrand == "johnson and johnsons"){
                                        document.getElementById("JnJ").setAttribute('selected','selected');
                                    }else if(VaccineBrand == "moderna vaccine"){
                                        document.getElementById("Moderna").setAttribute('selected','selected');
                                    }else if(VaccineBrand == "pfizer-biontech"){
                                        document.getElementById("PB").setAttribute('selected','selected');
                                    }else if(VaccineBrand == "sinovac vaccine"){
                                        document.getElementById("Sinovac").setAttribute('selected','selected');
                                    }else if(VaccineBrand == "sputnik vaccine"){
                                        document.getElementById("Sputnik").setAttribute('selected','selected');
                                    }

                                    $('#TxtNumberOfStick').val(NumOfStick);
                                    $('#TxtNumberOfYears').val(NumOfYearAsSmoker);
                                    $('#TxtAgeStarted').val(AgeStartedAsDrinker);
                                    $('#TxtOthers').val(Others);
                                    $('#TxtMomaSpan').val(HowLongAsChewer);

                                    

                                /* //Display Alert Box
                                $.alert(
                                {theme: 'modern',
                                content: message,
                                title:'', 
                                buttons:{
                                    Ok:{
                                    text:'Ok',
                                    btnClass: 'btn-green'
                                }}}); */
                            }

                                
                                styleInput('TxtStudentIDNumber2');
                                styleInput('TxtFirstName');
                                styleInput('TxtMiddleName');
                                styleInput('TxtLastName');
                                styleInput('TxtExtension');
                                styleInput('TxtAge');
                                styleInput('TxtSex');
                                styleInput('TxtCourseStrand');
                                styleInput('TxtYear');
                                styleInput('TxtDate');
                                styleInput('TxtComplaints');
                                styleInput('TxtDiagnosis');
                                styleInput('TxtDiagnosticTest');
                                styleInput('TxtRemarks');
                                styleInput('TxtPhysicalFindings');

                                styleInput('TxtMedicineGiven');
                                styleInput('TxtTemperature');
                                styleInput('TxtBP');
                                styleInput('TxtPR');
                                styleInput('TxtBooster');
                                styleInput('TxtVaccineBrand');
                                styleInput('TxtNumberOfStick');
                                styleInput('TxtNumberOfYears');
                                styleInput('TxtAgeStarted');
                                styleInput('TxtOthers');
                                styleInput('TxtMomaSpan');
                        });
                    },  
                    error: function (e)
                    {
                        //Display Alert Box
                        $.alert(
                        {theme: 'modern',
                        content:'Failed to fetch information due to error',
                        title:'', 
                        useBootstrap: false,
                        buttons:{
                            Ok:{
                            text:'Ok',
                            btnClass: 'btn-red'
                        }}});
                    }
                });
            }

            function saveRecords(form_data)
            {   
                $.ajax(
                { 
                    url:"../php/SaveUser.php",
                    method:"POST",
                    data:form_data, 
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: "xml",
                    success:function(xml)
                    {
                        $(xml).find('output').each(function()
                        {
                            var message = $(this).attr('Message');
                            var error = $(this).attr('Error');

                            if(error == "1"){
                                //Display Alert Box
                                $.alert(
                                {theme: 'modern',
                                content: message,
                                title:'', 
                                buttons:{
                                    Ok:{
                                    text:'Ok',
                                    btnClass: 'btn-red'
                                }}});
                                logAction(message);
                            }else{
                                //Display Alert Box
                                message = "Successfully saved student consultation record";
                                $.alert(
                                {theme: 'modern',
                                content: message,
                                title:'', 
                                buttons:{
                                    Ok:{
                                    text:'Ok',
                                    btnClass: 'btn-green'
                                }}});

                                logAction(message);

                                setTimeout(function(){
                                    window.location="../index.php?type=checkRecords";
                                }, 5000);

                            }
                            
                        });
                     },
                    error: function (e)
                    {
                        //Display Alert Box
                        $.alert(
                        {theme: 'modern',
                        content:'Failed to save information due to error',
                        title:'', 
                        buttons:{
                            Ok:{
                            text:'Ok',
                            btnClass: 'btn-red'
                        }}});
                    }
                });
            }

            function clearInfo(){
                $('#TxtStudentIDNumber2').val('');
                $('#TxtFirstName').val('');
                $('#TxtMiddleName').val('');
                $('#TxtLastName').val('');
                $('#TxtExtension').val('');
                $('#TxtAge').val('');
                $('#TxtSex').val('');
                $('#TxtCourseStrand').val('');
                $('#TxtYear').val('');
                $('#TxtComplaints').val('');
                $('#TxtDiagnosis').val('');
                $('#TxtDiagnosticTest').val('');
                $('#TxtMedicineGiven').val('');
                $('#TxtRemarks').val('');
                $('#TxtPhysicalFindings').val('');

                $('#TxtTemperature').val('');
                $('#TxtBP').val('');
                $('#TxtPR').val('');
                $('#RadSmokerYes').prop('checked', false);
                $('#RadSmokerNo').prop('checked', false);
                $('#RadSangerYes').prop('checked', false);
                $('#RadSangerNo').prop('checked', false);
                $('#RadMomaYes').prop('checked', false);
                $('#RadMomaNo').prop('checked', false);
                $('#RadFully').prop('checked', false);
                $('#RadNot').prop('checked', false);

                $('#TxtNumberOfStick').val('');
                $('#TxtNumberOfYears').val('');
                $('#TxtAgeStarted').val('');
                $('#TxtOthers').val('');
                $('#TxtMomaSpan').val('');
                $('#TxtBooster').val('');
                $('#TxtVaccineBrand').val('');

            }

            function clickEdit(){
                document.getElementById("TxtStudentIDNumber2").removeAttribute("readonly");
                document.getElementById("TxtComplaints").removeAttribute("readonly");
                document.getElementById("TxtDiagnosis").removeAttribute("readonly");
                document.getElementById("TxtDiagnosticTest").removeAttribute("readonly");
                document.getElementById("TxtRemarks").removeAttribute("readonly");
                document.getElementById("TxtPhysicalFindings").removeAttribute("readonly");
                document.getElementById("TxtMedicineGiven").removeAttribute("readonly");
                document.getElementById("BtnAdd").removeAttribute("disabled");
                document.getElementById("BtnClear").removeAttribute("disabled");
                document.getElementById("BtnSave").removeAttribute("disabled");

                document.getElementById("TxtNumberOfStick").removeAttribute("readonly");
                document.getElementById("TxtNumberOfYears").removeAttribute("readonly");
                document.getElementById("TxtAgeStarted").removeAttribute("readonly");
                document.getElementById("TxtOthers").removeAttribute("readonly");
                document.getElementById("TxtMomaSpan").removeAttribute("readonly");
                document.getElementById("TxtBooster").removeAttribute("disabled");
                document.getElementById("TxtVaccineBrand").removeAttribute("disabled");
                document.getElementById("TxtTemperature").removeAttribute("readonly");
                document.getElementById("TxtBP").removeAttribute("readonly");
                document.getElementById("TxtPR").removeAttribute("readonly");
                document.getElementById("TxtDate").removeAttribute("readonly");
                document.getElementById("RadSmokerYes").removeAttribute("disabled");
                document.getElementById("RadSmokerNo").removeAttribute("disabled");
                document.getElementById("RadSangerYes").removeAttribute("disabled");
                document.getElementById("RadSangerNo").removeAttribute("disabled");
                document.getElementById("RadMomaYes").removeAttribute("disabled");
                document.getElementById("RadMomaNo").removeAttribute("disabled");
                document.getElementById("RadFully").removeAttribute("disabled");
                document.getElementById("RadNot").removeAttribute("disabled");

                document.getElementById('TxtStudentIDNumber2').style.backgroundColor = "white";    
                document.getElementById('TxtDate').style.backgroundColor = "white"; 
                document.getElementById('TxtComplaints').style.backgroundColor = "white"; 
                document.getElementById('TxtDiagnosis').style.backgroundColor = "white"; 
                document.getElementById('TxtDiagnosticTest').style.backgroundColor = "white"; 
                document.getElementById('TxtRemarks').style.backgroundColor = "white"; 
                document.getElementById('TxtPhysicalFindings').style.backgroundColor = "white"; 

                document.getElementById('TxtMedicineGiven').style.backgroundColor = "white";    
                document.getElementById('TxtTemperature').style.backgroundColor = "white"; 
                document.getElementById('TxtBP').style.backgroundColor = "white"; 
                document.getElementById('TxtPR').style.backgroundColor = "white"; 
                document.getElementById('TxtBooster').style.backgroundColor = "white"; 
                document.getElementById('TxtVaccineBrand').style.backgroundColor = "white"; 
                document.getElementById('TxtNumberOfStick').style.backgroundColor = "white"; 
                document.getElementById('TxtNumberOfYears').style.backgroundColor = "white"; 
                document.getElementById('TxtAgeStarted').style.backgroundColor = "white"; 
                document.getElementById('TxtOthers').style.backgroundColor = "white"; 
                document.getElementById('TxtMomaSpan').style.backgroundColor = "white"; 

            }

            function alphaOnly(event){
                var key = event.keyCode;
                return ((key >= 65 && key <= 90) || key == 8 || key == 32);
            }
            
            function btnValue(valu){
                TempBtnValue = valu;
            }
            
            function clickedSmokingYes(){
                document.getElementById("NumOfStick").removeAttribute("hidden");
                document.getElementById("NumOfYear").removeAttribute("hidden");
                document.getElementById("TxtNumberOfStick").removeAttribute("hidden");
                document.getElementById("TxtNumberOfYears").removeAttribute("hidden");
            }
            
            function clickedDrinkerYes(){
                document.getElementById("AgeStarted").removeAttribute("hidden");
                document.getElementById("others").removeAttribute("hidden");
                document.getElementById("TxtAgeStarted").removeAttribute("hidden");
                document.getElementById("TxtOthers").removeAttribute("hidden");
            }
            
            function clickedChewerYes(){
                document.getElementById("MomaSpan").removeAttribute("hidden");
                document.getElementById("TxtMomaSpan").removeAttribute("hidden");
            }
            
            function clickedVaccinated(){
                document.getElementById("VaccineBrand" , "Booster").removeAttribute("hidden");
                document.getElementById("TxtVaccineBrand" , "TxtBooster" ).removeAttribute("hidden");
                document.getElementById("Booster", "VaccineBrand" ).removeAttribute("hidden");
                document.getElementById("TxtBooster" , "TxtVaccineBrand"  ).removeAttribute("hidden");
            }
            
            function clickedSmokingNo(){

                document.getElementById("NumOfStick").setAttribute('hidden', 'hidden');
                document.getElementById("NumOfYear").setAttribute('hidden', 'hidden');
                document.getElementById("TxtNumberOfStick").setAttribute('hidden', 'hidden');
                document.getElementById("TxtNumberOfYears").setAttribute('hidden', 'hidden');
            }
            
            function clickedDrinkerNo(){
                document.getElementById("AgeStarted").setAttribute('hidden', 'hidden');
                document.getElementById("others").setAttribute('hidden', 'hidden');
                document.getElementById("TxtAgeStarted").setAttribute('hidden', 'hidden');
                document.getElementById("TxtOthers").setAttribute('hidden', 'hidden');
            }
            
            function clickedChewerNo(){
                document.getElementById("MomaSpan").setAttribute('hidden', 'hidden');
                document.getElementById("TxtMomaSpan").setAttribute('hidden', 'hidden');
            }
            
            function clickedNotVaccinated(){
                document.getElementById("VaccineBrand").setAttribute('hidden', 'hidden');
                document.getElementById("TxtVaccineBrand").setAttribute('hidden', 'hidden');
                document.getElementById("Booster").setAttribute('hidden', 'hidden');
                document.getElementById("TxtBooster").setAttribute('hidden', 'hidden');
            }
            
            
            function addRecords(form_data)
            {  
                $.ajax(
                {
                    url:"../php/addConsultation.php",
                    method:"POST",
                    data:form_data,
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: "xml",
                    success:function(xml)
                    {
                        $(xml).find('output').each(function()
                        {
                            var message = $(this).attr('Result');
                            var error = $(this).attr('Error');

                            if(error == "1"){
                                //Display Alert Box
                                $.alert(
                                {theme: 'modern',
                                content: message,
                                title:'', 
                                buttons:{
                                    Ok:{
                                    text:'Ok',
                                    btnClass: 'btn-red'
                                }}});    
                            }else{
                                //Display Alert Box
                                message = "Successfully added new student consultation record";
                                $.alert(
                                {theme: 'modern',
                                content: message,
                                title:'', 
                                buttons:{
                                    Ok:{
                                    text:'Ok',
                                    btnClass: 'btn-green'
                                }}});

                                setTimeout(function(){
                                    window.location="../index.php?type=checkRecords";
                                }, 5000);
                            }

                            logAction(message);

                            $('#TxtStudentIDNumber2').val('');
                            $('#TxtFirstName').val('');
                            $('#TxtMiddleName').val('');
                            $('#TxtLastName').val('');
                            $('#TxtExtension').val('');
                            $('#TxtAge').val('');
                            $('#TxtSex').val('');
                            $('#TxtCourseStrand').val('');
                            $('#TxtYear').val('');
                            $('#TxtComplaints').val('');
                            $('#TxtDiagnosis').val('');
                            $('#TxtDiagnosticTest').val('');
                            $('#TxtRemarks').val('');
                            $('#TxtPhysicalFindings').val('');
                            $('#TxtMedicineGiven').val('');
                            $('#TxtTemperature').val('');
                            $('#TxtBP').val('');
                            $('#TxtPR').val('');
                            $('#TxtNumberOfStick').val('');
                            $('#TxtNumberOfYears').val('');
                            $('#TxtAgeStarted').val('');
                            $('#TxtOthers').val('');
                            $('#TxtMomaSpan').val('');
                            $('#TxtBooster').val('');
                            $('#TxtVaccineBrand').val('');
                            $('#RadSmokerYes').prop('checked', false);
                            $('#RadSmokerNo').prop('checked', false);
                            $('#RadSangerNo').prop('checked', false);
                            $('#RadSangerYes').prop('checked', false);
                            $('#RadMomaYes').prop('checked', false);
                            $('#RadMomaNo').prop('checked', false);
                            $('#RadFully').prop('checked', false);  
                            $('#RadNot').prop('checked', false);
                            
                            if(TempSex == "Yes"){
                                $('#RadSmokerYes').prop('checked', true);
                            }else{
                                $('#RadSmokerNo').prop('checked', true);
                            }
                            if(TempSanger == "Yes"){
                                $('#RadSangerYes').prop('checked', true);
                            }else{
                                $('#RadSangerNo').prop('checked', true);
                            }    
                            if(TempMoma == "Yes"){
                                $('#RadMomaYes').prop('checked', true);
                            }else{
                                $('#RadMomaNo').prop('checked', true);
                            }                          
                            if(TempVaccination == "Fully Vaccinated"){
                                $('#RadFully').prop('checked', true);
                            }else{
                                $('#RadNot').prop('checked', true);
                            }
                        });
                     },
                    error: function (e)
                    {
                        //Display Alert Box
                        $.alert(
                        {theme: 'modern',
                        content:'Failed to store consultation due to error',
                        title:'', 
                        buttons:{
                            Ok:{
                            text:'Ok',
                            btnClass: 'btn-red'
                        }}});
                    }
                });
            }

            function checkDate(){
                var currentDate = new Date();
                var dateInput = new Date(document.getElementById('TxtDate').value);

                if(currentDate.getTime() > dateInput) {

                }else{
                    message = "Date input is invalid";
                    $.alert({
                        theme: 'modern',
                        content: message,
                        title: '',
                        buttons:{
                            Ok:{
                            text:'Ok',
                            btnClass:'btn-green'
                        }}});
                    $('#TxtDate').val('');
                }

                
            }
            $(document).ready(function() 
            {
                var userFullname = "<?php echo $_SESSION['fullname'] ?>";
                var physicianID = "<?php echo $_SESSION['userID'] ?>";

                //remove comment to enable autofill date based on system date
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;

                document.getElementById('TxtMSIDNumber1').innerHTML = 'ID Number: ' + physicianID;
                document.getElementById('TxtMSFullName').innerHTML = 'Charted By: ' + userFullname.toUpperCase();

                $('#TxtDate').val(today);

                const input = document.getElementById('TxtBP');

                input.oninput = (e) => {  
                    const cursorPosition = input.selectionStart - 1;
                    const hasInvalidCharacters = input.value.match(/[^0-9/]/);

                    if (!hasInvalidCharacters) return;
  
                    // Replace all non-digits:
                    input.value = input.value.replace(/[^0-9/]/g, '');
  
                    // Keep cursor position:
                    input.setSelectionRange(cursorPosition, cursorPosition);
                };

                $("#add-record").submit(function(event)
                {                
                    /* stop form from submitting normally */
                    event.preventDefault();
                    var form_data = new FormData(this);
                    form_data.append("userID", physicianID);
                    form_data.append("userFullN", userFullname);

                    if(TempBtnValue == "save"){
                        form_data.append("numb", TempNum);
                        saveRecords(form_data);
                    }else{
                        addRecords(form_data);
                    }       
                           
                });

                //hide Nav Items From Staff Account
                var acclvl = sessionStorage.getItem('isStandard');

                if(acclvl == "true"){
                    $(".admin-nav").hide();
                    document.getElementById("userFullname").style.width = "52%";
                    document.getElementById("nav2").style.width = "9.33%";
                    document.getElementById("nav3").style.width = "9.33%";
                    document.getElementById("nav4").style.width = "9.33%";
                    document.getElementById("nav5").style.width = "9.33%";
                    document.getElementById("nav7").style.width = "9.33%";
                    document.getElementById("nav8").style.width = "9.33%";
                }

            });
                
     
        </script>
 
    </head>
    <body>
    <nav id = "nv">
              
      <span id="userFullname"><b><?php echo ucwords($_SESSION['homePosDisp']) . " ";
      $tempNAME = strtolower($_SESSION['fullname']);
      echo ucwords($tempNAME); 
      ?></b></span>
      <a href="../../Homepage/index.php" id="nav2" class="nav-pages">Home</a>
      <a href="../../userList.php?type=checkRecords" id="nav3" class="nav-pages admin-nav">User List</a>
      <a href="../../Student/index.php?type=checkRecords" id="nav4" class="nav-pages">Student</a>
      <a href="../../Consultation/index.php?type=checkRecords" id="nav5" class="nav-pages active">Consultation</a>
      
      <div class="dropdown nav-pages admin-nav" id="nav6">
          <button id="maint" class="dropbtn">Maintenance</button>
                <div class="dropdown-content">
                    <a class="dropA" href="../../logs.php?type=checkRecords" onclick="userCheckLogs()">Logs</a>
                    <a class="dropA" href="../../Student/index.php?type=checkArchivedStudent">Archived Student Records</a>
                    <a class="dropA" href="../../Consultation/index.php?type=checkArchivedConsultation">Archived Consultation Records</a>
                    <a class="dropA" href="../../userList.php?type=checkArchivedStaff">Archived Staff Accounts</a>
                    <a class="dropA" href="../../logs.php?type=checkArchivedLogs">Archived System Logs</a>
                    
                    <a class="dropA" href="../../backup.php">Backup</a>
                    <a class="dropA" href="../../restore.php">Restore</a>
                </div>
      </div>
      <a href="#" onclick="openManual()" id="nav8" class="nav-pages">Help</a>
      <a href="#" id="nav7" onclick="logout()" class="nav-pages">Logout</a>
    </nav>
        <div class="container" id="toDownloadPDF">
            <div class="tabs">
                <div class="tabs-head">
                    <span id="tab1" class="tabs-toggle is-active" style="margin:auto";>&bull;&nbsp;Consultation&nbsp;&bull;</span>
                    <span id="wholetab" class="tabs-toggle">&bull;&nbsp;Consultation&nbsp;&bull;</span>
            </div>
            <div class="tabs-body" id="tabs-bodyID">
                <div id="ConsultationHeader">
                    <img id="bsuLogo" alt="BSU Logo" src="../images/BSULogo.png"/>
                    <h3 id="bsuCon">Consultation</h3>
                </div>
                <div class="tabs-content is-active">
                    <form action="#" method="post" id="add-record" autocomplete="off">
                        <div class="Two-Info">
                                <div class="IDNumForm">
                                    <label for="TxtStudentIDNumber2">ID Number</label> <span id="req">*</span>
                                    <input name="TxtStudentIDNumber2" type="Number" id="TxtStudentIDNumber2" maxlength="7" onchange="fetchName()" onkeypress="return isNumberKey(this,event)" style="background-color: white;" readonly required>
                                </div>
                                <div class="Date">
                                    <label for="TxtDate">Date</label> <span id="req">*</span>
                                    <input type="date" name="TxtDate" id="TxtDate" onchange="checkDate()" style="background-color: white;" readonly required>
                                </div>
                            </div>
                            <div class="Four-Info">
                                <div class="LastName">
                                    <label for="TxtLastName">Last Name</label> <span id="req">*</span>
                                    <input type="text" name="TxtLastName" id="TxtLastName" onkeydown="return alphaName(event);" readonly minlength="2" required>
                                </div>
                                <div class="FirstName">
                                    <label for="TxtFirstName">First Name</label> <span id="req">*</span>
                                    <input type="text" name="TxtFirstName" id="TxtFirstName" onkeydown="return alphaName(event);" readonly minlength="2" required>
                                </div>
                                <div class="MiddleName">
                                    <label for="TxtMiddleName">Middle Name</label> <span id="req">*</span>
                                    <input type="text" name="TxtMiddleName" id="TxtMiddleName" onkeydown="return alphaName(event);" readonly minlength="2" required>
                                </div>
                                <div class="Extension">
                                    <label for="TxtExtension">Extension</label>
                                    <input type="text" name="TxtExtension" id="TxtExtension" onkeydown="return alphaName(event);" readonly maxlength="3">
                                </div>
                            </div>
                            <div class="Two-Info">
                                <div class="Age">
                                    <label for="TxtAge">Age</label> 
                                    <input type="number" name="TxtAge" id="TxtAge" readonly >
                                </div>
                                <div class="Sex">
                                    <label for="TxtSex">Sex</label> 
                                    <input type="text" name="TxtSex" id="TxtSex" readonly>
                                </div>
                            </div>
                            <div class="Two-Info">
                                <div class="CourseStrand">
                                    <label for="TxtCourseStrand">Course / Strand</label>
                                    <input type="text" name="TxtCourseStrand" id="TxtCourseStrand" readonly minlength="2">
                                </div>
                                <div class="Year">
                                    <label for="TxtYear">Year</label>
                                    <input type="text" name="TxtYear" id="TxtYear" readonly maxlength="3">
                                </div>
                            </div>
                            <!-- <div class="Three-Info">
                                <div class="Physician">
                                    <label for="Physician">Physician Name</label>
                                    <input type="text" name="TxtPhysician" id="TxtPhysician" onkeydown="return alphaOnly(event);" readonly required>
                                </div>
                                <div class="PhysicianIDNumber">
                                    <label for="TxtPhysicianIDNumber">Physician ID Number</label>
                                    <input type="text" name="TxtPhysicianIDNumber" id="TxtPhysicianIDNumber" onkeypress="return isNumberKey(this,event)" readonly required>
                                </div>
                            </div> -->
                        
                        <div class="Three-Info">
                                <div class="Temperature">
                                    <label for="TxtTemperature">Temperature in °C</label> 
                                    <input type="text" name="TxtTemperature" id="TxtTemperature" onkeypress="return isNumberKey(this,event)" style="background-color: white;" readonly >
                                </div>
                                <div class="BP">
                                    <label for="TxtBP">Blood Pressure</label>
                                    <input type="text" name="TxtBP" id="TxtBP" style="background-color: white;" readonly>
                                </div>
                                <div class="PR">
                                    <label for="TxtPR">Pulse Rate</label> 
                                    <input type="text" name="TxtPR" id="TxtPR" style="background-color: white;" onkeypress="return isNumberKey(this,event)" readonly >
                                </div>
                            </div>
                        
                            <div class="One-Info">
                                <legend>Past Medical History</legend>
                         </div>
                            <div class="Three-Info">
                                    <div class="Smoker">
                                        <label for="RadSmoker">Smoker?</label><span id="req">*</span><br>
                                        <label class="SecSmoker">
                                            <input type="radio" class="RadSmoker" id="RadSmokerYes" name="RadSmoker" onclick="clickedSmokingYes()" value="Yes" required disabled>
                                            <span class="RadDesign"></span>
                                            <span class="RadText">Yes</span>
                                        </label>
                                        &nbsp;
                                        <label class="SecSmoker">
                                            <input type="radio" class="RadSmoker" id="RadSmokerNo" name="RadSmoker" onclick="clickedSmokingNo()" value="No" required disabled>
                                            <span class="RadDesign"></span>
                                            <span class="RadText">No</span>
                                        </label>
                                    </div>
                                    <div class = "NumOfStick" >
                                        <label id="NumOfStick" hidden>If Yes, How many Sticks per day:</label>
                                        <input type="text" id="TxtNumberOfStick" name="TxtNumberOfStick" onkeypress="return isNumberKey(this,event)" style="background-color: white;" hidden readonly>
                                    </div>                             
                                    <div class ="NumOfYear" >
                                        <label id="NumOfYear" hidden>Number of Years as Smoker:</label>
                                        <input type="text" id="TxtNumberOfYears" name="TxtNumberOfYears" onkeypress="return isNumberKey(this,event)" style="background-color: white;" hidden readonly>
                                    </div>
                            </div><br/>
                            <div class="Three-Info">
                                    <div class="Sanger">
                                        <label for="RadSanger">Alcohol Drinker?</label><span id="req">*</span><br>
                                        <label class="SecSanger">
                                            <input type="radio" class="RadSanger" id="RadSangerYes" name="RadSanger" onclick="clickedDrinkerYes()" value="Yes" required disabled>
                                            <span class="RadDesign"></span>
                                            <span class="RadText">Yes</span>
                                        </label>
                                        &nbsp;
                                        <label class="SecSanger">
                                            <input type="radio" class="RadSanger" id="RadSangerNo" name="RadSanger" onclick="clickedDrinkerNo()" value="No" required disabled>
                                            <span class="RadDesign"></span>
                                            <span class="RadText">No</span>
                                        </label>
                                    </div>            
                                    <div class = "AgeStarted">
                                        <label id="AgeStarted" hidden>If Yes, age started:</label>
                                        <input type="text" id="TxtAgeStarted" name="TxtAgeStarted" onkeypress="return isNumberKey(this,event)" style="background-color: white;" hidden readonly>
                                    </div>
                                    <div class = "Others">
                                        <label id="others" hidden>Others:</label>
                                        <input type="text" id="TxtOthers" name="TxtOthers" style="background-color: white;" hidden readonly>
                                    </div>
                            </div><br/>
                            <div class="Two-Info">
                                    <div class="Moma">
                                        <label for="RadMoma">Betel Nut Chewer?</label><span id="req">*</span><br>
                                        <label class="SecMoma">
                                            <input type="radio" class="RadMoma" id="RadMomaYes" name="RadMoma" onclick="clickedChewerYes()" value="Yes" required disabled>
                                            <span class="RadDesign"></span>
                                            <span class="RadText">Yes</span>
                                        </label>
                                        &nbsp;
                                        <label class="SecMoma">
                                            <input type="radio" class="RadMoma" id="RadMomaNo" name="RadMoma" onclick="clickedChewerNo()" value="No" required disabled>
                                            <span class="RadDesign"></span>
                                            <span class="RadText">No</span>
                                        </label>
                                    </div>
                                    <div class="MomaYes">
                                        <label id="MomaSpan" hidden>If Yes, for how long (Months):</label>
                                        <input onkeypress="return isNumberKey(this,event)" type="text" id="TxtMomaSpan" name="TxtMomaSpan" style="background-color: white;" hidden readonly>
                                    </div>
                            </div><br/>
                            <div class="Three-Info">
                                    <div class="VS">
                                        <label for="RadVS">Vaccination Status</label><span id="req">*</span><br>
                                        <label class="SecVS">
                                            <input type="radio" class="RadVS" id="RadFully" name="RadVS" onclick="clickedVaccinated()" value="Fully Vaccinated" required disabled>
                                            <span class="RadDesign"></span>
                                            <span class="RadText">Fully Vaccinated</span>
                                        </label>
                                        <br>
                                        <label class="SecVS">
                                            <input type="radio" class="RadVS" id="RadNot" name="RadVS" onclick="clickedNotVaccinated()" value="Not Vaccinated" required disabled>
                                            <span class="RadDesign"></span>
                                            <span class="RadText">Not Vaccinated</span>
                                        </label>
                                    </div>                           

                                    &nbsp;                           
                                <div class="VaccineBrand">
                                    <label for="VaccineBrand" id="VaccineBrand" hidden>Vaccine</label><br>
                                    <select id="TxtVaccineBrand" name="TxtVaccineBrand" disabled hidden>
                                        <option style="display:none"></option>
                                        <option id="AP" value="AztraZeneca Pharmaceuticals">AztraZeneca Pharmaceuticals</option>
                                        <option id="BBC" value="Bharat BioTechs Covaxin">Bharat BioTech's Covaxin</option>
                                        <option id="Janssen" value="Janssen Vaccine">Janssen</option>
                                        <option id="JnJ" value="Johnson and Johnsons">Johnson and Johnson's</option>
                                        <option id="Moderna" value="Moderna Vaccine">Moderna</option>
                                        <option id="PB" value="Pfizer-BioNTech">Pfizer-BioNTech</option>
                                        <option id="Sinovac" value="Sinovac Vaccine">Sinovac</option>
                                        <option id="Sputnik" value="Sputnik Vaccine">Gamaleya Sputnik V</option>
                                    </select>
                                </div>


                                <div class="Booster">
                                    <label for="Booster" id="Booster" hidden>Booster</label><br>
                                    <select id="TxtBooster" name="TxtBooster" style="background-color: white;" disabled hidden>
                                        <option style="display:none"></option>
                                        <option id="WOBooster" value="Without Booster">Without Booster</option>
                                        <option id="Booster1" value="Booster 1">Booster 1</option>
                                        <option id="Booster2" value="Booster 2">Booster 2</option>
                                    </select>
                                </div>                              
                            </div><br/>    
                             <div class="One-Info">
                                <div class="Complaints">
                                    <label for="TxtComplaints">Complaints</label>
                                    <textarea type="text" name="TxtComplaints" id="TxtComplaints" cols="105" rows="10" style="background-color: white;" readonly></textarea>
                                </div>
                            </div>
                            <div class="One-Info">
                                <div class="PhysicalFindings">
                                    <label for="TxtPhysicalFindings">Physical Findings</label>
                                    <textarea type="text" name="TxtPhysicalFindings" id="TxtPhysicalFindings" cols="105" rows="10" style="background-color: white;" readonly></textarea>
                                </div>
                            </div>
                            <div class="One-Info">
                                <div class="Diagnosis">
                                    <label for="TxtDiagnosis">Diagnosis</label>
                                    <textarea type="text" name="TxtDiagnosis" id="TxtDiagnosis" cols="105" rows="10" style="background-color: white;" readonly></textarea>
                                </div>
                            </div>
                            <div class="One-Info">
                                <div class="DiagnosticTestNeeded">
                                    <label for="TxtDiagnosticTestNeeded">Treatment</label>
                                    <textarea type="text" name="TxtDiagnosticTest" id="TxtDiagnosticTest" cols="105" rows="10" style="background-color: white;" readonly></textarea>
                                </div>
                            </div>
                            <div class="One-Info">
                                <div class="MedicineGiven">
                                    <label for="TxtMedicineGiven">Medicine Given</label>
                                    <textarea type="text" name="TxtMedicineGiven" id="TxtMedicineGiven" cols="105" rows="10" style="background-color: white;" readonly></textarea>
                                </div>
                            </div>
                            <div class="One-Info">
                                <div class="Remarks">
                                    <label for="TxtRemarks">Remarks</label>
                                    <textarea type="text" name="TxtRemarks" id="TxtRemarks" cols="105" rows="10" style="background-color: white;" readonly></textarea>
                                </div>
                            </div>
                            <div class="One-Info">
                                <div id="MedicalStaffInfo">
                                    <legend>Medical Staff</legend>
                                    <span id="TxtMSIDNumber1">ID Number:</span><br>
                                    <span id="TxtMSFullName">Charted By:</span>
                                </div>
                                <div id="ExaminedBy">
                                    <span id="TxtExaminedBy">Examined By:</span><br>
                                </div>
                            </div>
                            <div id="exportButton" data-html2canvas-ignore="true">
                                <div class="submit">
                                    <button type="button" id ="BtnPrint" class=form-button onclick="clickedPrint('BtnPrint')"><p>Print</p><svg xmlns="http://www.w3.org/2000/svg" class="button__svg" viewBox="0 0 64 64" stroke-width="5" stroke="currentColor" fill="none"><path d="M17.34,39.37H14a3.31,3.31,0,0,1-3.31-3.3V20.77A3.31,3.31,0,0,1,14,17.47H50a3.31,3.31,0,0,1,3.31,3.3v15.3A3.31,3.31,0,0,1,50,39.37H47.18" stroke-linecap="round"/><polyline points="17.34 17.47 17.34 10.59 47.18 10.59 47.18 17.47" stroke-linecap="round"/><rect x="17.34" y="32.02" width="29.84" height="21.39" stroke-linecap="round"/><line x1="21.63" y1="37.93" x2="42.1" y2="37.93" stroke-linecap="round"/><line x1="15.54" y1="32.02" x2="49.15" y2="32.02" stroke-linecap="round"/><line x1="21.76" y1="42.72" x2="42.24" y2="42.72" stroke-linecap="round"/><line x1="22.03" y1="47.76" x2="35.93" y2="47.76" stroke-linecap="round"/><circle cx="46.76" cy="24.04" r="1.75" stroke-linecap="round"/></svg></button>
                                </div>
                                <div class="submit">
                                    <button type="button" id ="BtnPDF" class=form-button onclick="clickedPDF()"><p>Export to PDF</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="button__svg" stroke-width="5" stroke="currentColor" fill="none"><path d="M53.5,34.06V53.33a2.11,2.11,0,0,1-2.12,2.09H12.62a2.11,2.11,0,0,1-2.12-2.09V34.06"/><polyline points="42.61 35.79 32 46.39 21.39 35.79"/><line x1="32" y1="46.39" x2="32" y2="7.5"/></svg></button>
                                </div>
                            </div>
                            <div id="twoButton" data-html2canvas-ignore="true">
                                <div class="submit">
                                    <button type="Submit" id ="BtnAdd" class=form-button name="BtnAdd" onclick="btnValue('add')" disabled><p>Add</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" stroke-width="5" class="button__svg" stroke="currentColor" fill="none"><circle cx="29.22" cy="16.28" r="11.14"/><path d="M41.32,35.69c-2.69-1.95-8.34-3.25-12.1-3.25h0A22.55,22.55,0,0,0,6.67,55h29.9"/><circle cx="45.38" cy="46.92" r="11.94"/><line x1="45.98" y1="39.8" x2="45.98" y2="53.8"/><line x1="38.98" y1="46.8" x2="52.98" y2="46.8"/></svg></button>
                                </div>
                                <div class="submit">
                                    <button type="button" id="BtnEdit" class=form-button onclick="clickEdit()"><p>Edit</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" stroke-width="5" class="button__svg" stroke="currentColor" fill="none"><polyline points="45.56 46.83 45.56 56.26 7.94 56.26 7.94 20.6 19.9 7.74 45.56 7.74 45.56 21.29"/><polyline points="19.92 7.74 19.9 20.6 7.94 20.6"/><line x1="13.09" y1="47.67" x2="31.1" y2="47.67"/><line x1="13.09" y1="41.14" x2="29.1" y2="41.14"/><line x1="13.09" y1="35.04" x2="33.1" y2="35.04"/><line x1="13.09" y1="28.94" x2="39.1" y2="28.94"/><path d="M34.45,43.23l.15,4.3a.49.49,0,0,0,.62.46l4.13-1.11a.54.54,0,0,0,.34-.23L57.76,22.21a1.23,1.23,0,0,0-.26-1.72l-3.14-2.34a1.22,1.22,0,0,0-1.72.26L34.57,42.84A.67.67,0,0,0,34.45,43.23Z"/><line x1="50.2" y1="21.7" x2="55.27" y2="25.57"/></svg></button>
                                </div>
                                <div class="submit">
                                    <button type="Submit" id="BtnSave" class=form-button name="BTN" onclick="btnValue('save')" disabled><p>Save</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" stroke-width="5" class="button__svg" stroke="currentColor" fill="none"><path d="M51,53.48H10.52V13A2.48,2.48,0,0,1,13,10.52H46.07l7.41,6.4V51A2.48,2.48,0,0,1,51,53.48Z" stroke-linecap="round"/><rect x="21.5" y="10.52" width="21.01" height="15.5" stroke-linecap="round"/><rect x="17.86" y="36.46" width="28.28" height="17.02" stroke-linecap="round"/></svg></button>
                                </div>
                                <div class="submit">
                                    <button type="button" id="BtnClear" class=form-button onclick="clearInfo()" disabled><p>Clear</p><svg xmlns="http://www.w3.org/2000/svg" class="button__svg" viewBox="0 0 64 64" stroke-width="5" stroke="currentColor" fill="none"><line x1="8.06" y1="8.06" x2="55.41" y2="55.94"/><line x1="55.94" y1="8.06" x2="8.59" y2="55.94"/></svg></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "clinicRecord";

    //Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    $id = "";

    $tempo = $_SESSION['accesslevel'];
    $tempor =  "";

    if($_SESSION["typed"] == 'checkArchivedConsultation'){
        $tempor = "checkArchived";
    }else{
        $tempor = "checkRecord";
    }

     echo "<script type='text/javascript'>
        globalAL = '$tempo';
        editTableNav('$tempor');
    </script>";

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if($_GET["type"] == "newCons"){
            echo "<script type='text/javascript'>
            clickEdit();
            document.getElementById('BtnSave').style.display = 'none';
            document.getElementById('BtnPDF').style.display = 'none';
            document.getElementById('BtnPrint').style.display = 'none';
            document.getElementById('BtnEdit').style.display = 'none';
            document.getElementById('MedicalStaffInfo').style.display = 'none';
            document.getElementById('ExaminedBy').style.display = 'none';
            </script>";
        }else if($_GET["type"] == "viewCons"){
            if(!isset($_GET["num"])){
                header("location: ../index.php");
                exit;
            }

            $num = $_GET["num"];

            $sql = "SELECT * FROM ConsultationInfo WHERE Num='$num'";
            $result = $connection->query($sql);
            $Row = $result->fetch_assoc();

            /*if(!$Row){
                header("location: ../index.php");
                exit;
            }*/

            echo "<script type='text/javascript'>
            document.getElementById('MedicalStaffInfo').style.display = 'inline-block';
            document.getElementById('ExaminedBy').style.display = 'inline-block';
            document.getElementById('BtnAdd').style.display = 'none';
            document.getElementById('BtnClear').style.display = 'none';
            getType = 'viewCons';
            passIDPHP($num);
            </script>";
        }else if($_GET["type"] == "viewArchivedCons"){
            if(!isset($_GET["num"])){
                header("location: ../index.php");
                exit;
            }

            $num = $_GET["num"];

            $sql = "SELECT * FROM archivedconsultation WHERE Num='$num'";
            $result = $connection->query($sql);
            $Row = $result->fetch_assoc();

            if(!$Row){
                header("location: ../index.php");
                exit;
            }

            echo "<script type='text/javascript'>
            document.getElementById('MedicalStaffInfo').style.display = 'inline-block';
            document.getElementById('ExaminedBy').style.display = 'inline-block';
            document.getElementById('BtnAdd').style.display = 'none';
            getType = 'viewArchivedCons';
            passIDPHP($num);
            hideButton();
            </script>";
        }  
    }
?>

