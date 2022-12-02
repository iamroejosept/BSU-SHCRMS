<?php
    session_start();

    if(empty($_SESSION['logged_in'])){
        header('Location: ../index.html');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Record</title>
        <link rel="stylesheet" href="../css/addRecord-style.css">
        <link rel = "icon" href = "../images/BSU-Logo.png" type = "image/x-icon">
        <script src="../dist/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="../dist/jquery-confirm.min.css">
        <script src="../dist/jquery-confirm.min.js"></script>
        <script type="text/javascript">

            function logout(){
            sessionStorage.clear();
            }

            function addRecords(form_data)
            {   
                $.ajax(
                {
                    url:"../php/addRecords.php",
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
                            var Result = $(this).attr('Result');
                            var Error = $(this).attr('Error');

                            if(Error == "1"){
                                //Display Alert Box
                                 $.alert({
                                    theme: 'modern',
                                    content:Result,
                                    title:"", 
                                    buttons:{
                                    Ok:{
                                        text:'Ok',
                                        btnClass: 'btn-red'
                                }}});
                            }else{
                                //Display Alert Box
                                $.alert({
                                    theme: 'modern',
                                    content:Result,
                                    title:"", 
                                    buttons:{
                                    Ok:{
                                        text:'Ok',
                                        btnClass: 'btn-green'
                                    }}});
                            }

                            //Clear textboxes
                            if(form_data.get("tab")=="0"){
                                $('#TxtPerIDNumForm').val('');
                                $('#TxtFirstName').val('');
                                $('#TxtMiddleName').val('');
                                $('#TxtLastName').val('');
                                $('#TxtContNumStudent').val('');
                                $('#TxtAddress').val('');
                                $('#TxtAge').val('');
                                $('#TxtBirthday').val('');
                                $('#RadMale').prop('checked', false);
                                $('#RadFemale').prop('checked', false);
                                $('#TxtHeight').val('');
                                $('#TxtWeight').val('');
                                $('#TxtContPer').val('');
                                $('#TxtContNumGuardian').val('');
                                $('#TxtCourse').val('');
                            }else{
                                $('#TxtMedIDNumForm').val('');
                                $('#TxtPhysician').val('');
                                $('#TxtDate').val('');
                                $('#TxtTemperature').val('');
                                $('#TxtPR').val('');
                                $('#TxtBP').val('');
                                $('#TxtComplaints').val('');
                                $('#TxtDiagnosis').val('');
                                $('#TxtReferredTo').val('');
                                $('#TxtDiagnosticTestNeeded').val('');
                                $('#TxtMedicineGiven').val('');
                                $('#TxtLicenseNumber').val('');
                                $('#TxtLMP').val('');
                                $('#TxtPregnancy').val('');
                                $('#TxtAllergies').val('');
                                $('#TxtSurgeries').val('');
                                $('#TxtInjuries').val('');
                                $('#TxtIllness').val('');
                                $('#TxtHearingDistance').val('');
                                $('#TxtSpeech').val('');
                                $('#TxtHead').val('');
                                $('#TxtEyes').val('');
                                $('#TxtEars').val('');
                                $('#TxtNose').val('');
                                $('#TxtAbdomen').val('');
                                $('#TxtGenitoUrinary').val('');
                                $('#TxtLymphGlands').val('');
                                $('#TxtSkin').val('');
                                $('#TxtExtremities').val('');
                                $('#TxtDeformities').val('');
                                $('#TxtCavityAndThroat').val('');
                                $('#TxtLungs').val('');
                                $('#TxtHeart').val('');
                                $('#TxtBreast').val('');
                                $('#TxtWOGOD').val('');
                                $('#TxtWOGOS').val('');
                                $('#TxtWGOD').val('');
                                $('#TxtWGOS').val('');
                            }
                        });
                     },
                    error: function (e)
                    {
                        //Display Alert Box
                        $.alert(
                        {theme: 'modern',
                        content:'Failed to store informations due to errors',
                        title:'', 
                        buttons:{
                            Ok:{
                            text:'Ok',
                            btnClass: 'btn-red'
                        }}});
                    }
                });
            }

            $(document).ready(function() 
            {
                var acclvl = sessionStorage.getItem('isStandard');

                if(acclvl == "true"){
                    $(".admin-nav").hide();
                    document.getElementById("nav1").style.width = "64%";
                    document.getElementById("nav2").style.width = "8%";
                    document.getElementById("nav5").style.width = "8%";
                    document.getElementById("nav6").style.width = "14%";
                    document.getElementById("nav7").style.width = "5%";
                    document.getElementById("line").style.width = "7.5%";
                    document.getElementById("line").style.left = "72%";

                    document.getElementById("nav5").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "7.5%";
                        document.getElementById("line").style.left = "72%";
                    });
                    document.getElementById("nav5").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "7.5%";
                        document.getElementById("line").style.left = "72%";
                    });

                    document.getElementById("nav2").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "3.8%";
                        document.getElementById("line").style.left = "66%";
                    });
                    document.getElementById("nav2").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "7.5%";
                        document.getElementById("line").style.left = "72%";
                    });

                    document.getElementById("nav6").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "9%";
                        document.getElementById("line").style.left = "82.3%";
                    });
                    document.getElementById("nav6").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "7.5%";
                        document.getElementById("line").style.left = "72%";
                    });

                    document.getElementById("nav7").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "4.3%";
                        document.getElementById("line").style.left = "93.9%";
                    });

                    document.getElementById("nav7").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "7.5%";
                        document.getElementById("line").style.left = "72%";
                    });
                }

                $("#add-personal-information").submit(function(event)
                {                
                    /* stop form from submitting normally */
                    event.preventDefault();
                    var form_data = new FormData(this);
                    form_data.append("tab", "0");

                    //Displays Confirm Box
                    $.confirm({
                        title: 'Hello',
                        content: 'Are you sure to continue?',
                        theme: 'modern',
                        buttons: 
                        {
                            Yes:{ 
                                text: 'Yes',                          
                                btnClass: 'btn-green',
                                action:function () 
                                {
                                    addRecords(form_data);
                                }
                            },
                        No:{
                            text: 'No',
                            btnClass: 'btn-green',
                            action:function () 
                            {                          
                            }
                        }
                        }
                    });   
                });

                $("#add-medical-information").submit(function(event)
                {                
                    /* stop form from submitting normally */
                    event.preventDefault();
                    var form_data = new FormData(this);
                    form_data.append("tab", "1");

                    //Displays Confirm Box
                    $.confirm({
                        title: 'Hello',
                        content: 'Are you sure to continue?',
                        theme: 'modern',
                        buttons: 
                        {
                            Yes:{ 
                                text: 'Yes',                          
                                btnClass: 'btn-green',
                                action:function () 
                                {
                                    addRecords(form_data);
                                }
                            },
                        No:{
                            text: 'No',
                            btnClass: 'btn-green',
                            action:function () 
                            {                          
                            }
                        }
                        }
                    });   
                });
            }); 
        </script>
    </head>
    <body>
        <nav>
            <a href="../pages/homepage.php" id="nav1" class="nav-logo"><img src="../images/nav-logo.png" alt="Logo"></a>
            <a href="../pages/homepage.php" id="nav2" class="nav-pages">Home</a>
            <a href="../pages/addUser.php" id="nav3" class="nav-pages admin-nav">Add Staff</a>
            <a href="../pages/searchUser.php" id="nav4" class="nav-pages admin-nav">Search Staff</a>
            <a href="#" id="nav5" class="nav-pages">Add Record</a>
            <a href="#" id="nav6" class="nav-pages">Search Record</a>
            <a href="../php/logout.php" id="nav7" onclick="logout()" class="nav-pages">Logout</a>
            <div id="line" class="animation line"></div>
        </nav>
        <div class="container">
            <div class="tabs">
                <div class="tabs-head">
                    <span id="tab1" class="tabs-toggle is-active">&bull;&nbsp;Personal Information&nbsp;&bull;</span>
                    <span id="tab2" class="tabs-toggle">&bull;&nbsp;Medical Information&nbsp;&bull;</span>
                </div>
                <div class="tabs-body">
                    <div class="tabs-content is-active">
                        <form action="#" method="post" id="add-personal-information">
                            <div class="Two-Info">
                                <div class="IDNumForm">
                                    <label for="TxtPerIDNumForm">ID Number</label>
                                    <input name="TxtPerIDNumForm" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="Number" id="TxtPerIDNumForm" maxlength="7" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                                <div class="Course">
                                    <label for="TxtCourse">Course</label>
                                    <input name="TxtCourse" type="text" id="TxtCourse" required>
                                </div>
                            </div>
                            <div class="Three-Info">
                                <div class="FirstName">
                                    <label for="TxtFirstName">First Name</label>
                                    <input type="text" name="TxtFirstName" id="TxtFirstName" required>
                                </div>
                                <div class="MiddleName">
                                    <label for="TxtMiddleName">Middle Name</label>
                                    <input type="text" name="TxtMiddleName" id="TxtMiddleName" required>
                                </div>
                                <div class="LastName">
                                    <label for="TxtLastName">Last Name</label>
                                    <input type="text" name="TxtLastName" id="TxtLastName" required>
                                </div>
                            </div>
                            <div class="Two-Info">
                                <div class="ContNumStudent">
                                    <label for="TxtContNumStudent">Contact Number</label>
                                    <input type="text" name="TxtContNumStudent" id="TxtContNumStudent" value="+639" onkeypress="return isNumberKey(this,event)"  required>
                                    <!-- onkeypress wull restrict the input values to be number only -->
                                </div>
                                <div class="Address">
                                    <label for="TxtAddress">Address</label>
                                    <input type="text" name="TxtAddress" id="TxtAddress" required>
                                </div>
                            </div>
                            <div class="Three-Info">
                                <div class="Age">
                                    <label for="TxtAge">Age</label>
                                    <input type="number" name="TxtAge" id="TxtAge" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                                <div class="Birthday">
                                    <label for="TxtBirthday">Birthday</label>
                                    <input type="date" name="TxtBirthday" id="TxtBirthday" required>
                                </div>
                                <div class="Sex">
                                    <label for="RadSex">Sex</label><br>
                                    <!-- <input type="text" name="TxtSex" id="TxtSex" required> -->
                                    <label class="SecSex">
                                        <input type="radio" class="RadSex" id="RadMale" name="RadSex" value="Male">
                                        <span class="RadDesign"></span>
                                        <span class="RadText">MALE</span>
                                    </label>
                                    <label class="SecSex">
                                        <input type="radio" class="RadSex" id="RadFemale" name="RadSex" value="Female">
                                        <span class="RadDesign"></span>
                                        <span class="RadText">FEMALE</span>
                                    </label>
                                </div>
                            </div>
                            <div class="Two-Info">
                                <div class="Height">
                                    <label for="TxtHeight">Height in Cms.</label>
                                    <input type="number" name="TxtHeight" id="TxtHeight" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                                <div class="Weight">
                                    <label for="TxtWeight">Weight in Kgs.</label>
                                    <input type="number" name="TxtWeight" id="TxtWeight" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                            </div>
                            <div class="Two-Info">
                                <div class="ContPer">
                                    <label for="TxtContPer">Contact Person</label>
                                    <input type="text" name="TxtContPer" id="TxtContPer" required>
                                </div>
                                <div class="ContNumGuardian">
                                    <label for="TxtContNumGuardian">Contact Number of Parent/Guardian</label>
                                    <input type="text" name="TxtContNumGuardian" id="TxtContNumGuardian" value="+639" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                            </div>
                            <div class="submit">
                                <button type="Submit" id ="BtnAdd" class=form-button name="BtnAdd"><p>Add Record</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="button__svg" stroke-width="5" stroke="currentColor" fill="none"><polyline points="34.48 54.28 11.06 54.28 11.06 18.61 23.02 5.75 48.67 5.75 48.67 39.42"/><polyline points="23.04 5.75 23.02 18.61 11.06 18.61"/><line x1="16.21" y1="45.68" x2="28.22" y2="45.68"/><line x1="16.21" y1="39.15" x2="31.22" y2="39.15"/><line x1="16.21" y1="33.05" x2="43.22" y2="33.05"/><line x1="16.21" y1="26.95" x2="43.22" y2="26.95"/><circle cx="42.92" cy="48.24" r="10.01" stroke-linecap="round"/><line x1="42.92" y1="42.76" x2="42.92" y2="53.72"/><line x1="37.45" y1="48.24" x2="48.4" y2="48.24"/></svg></button>
                            </div>
                        </form>
                    </div>
                    <div class="tabs-content">
                        <form action="#" method="post" id="add-medical-information">
                            <div class="Two-Info">
                                <div class="IDNumForm">
                                    <label for="TxtMedIDNumForm">ID Number</label>
                                    <input name="TxtMedIDNumForm" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="Number" id="TxtMedIDNumForm" maxlength="7" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                                <div class="Date">
                                    <label for="TxtDate">Date</label>
                                    <input type="date" name="TxtDate" id="TxtDate" required>
                                </div>
                            </div>
                            <div class="Two-Info">
                                <div class="Physician">
                                    <label for="TxtPhysician">Physician</label>
                                    <input type="text" name="TxtPhysician" id="TxtPhysician" required>
                                </div>
                                <div class="LicenseNumber">
                                    <label for="TxtLicenseNumber">License Number</label>
                                    <input type="text" name="TxtLicenseNumber" id="TxtLicenseNumber" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                            </div>
                            <div class="One-Info">
                                <legend>Past Medical History</legend>
                            </div>
                            <div class="Three-Info">
                                <div class="LMP">
                                    <label for="TxtLMP">LMP</label>
                                    <input type="text" name="TxtLMP" id="TxtLMP" >
                                </div>
                                <div class="Pregnancy">
                                    <label for="TxtPregnancy">Pregnancy</label>
                                    <input type="text" name="TxtPregnancy" id="TxtPregnancy" >
                                </div>
                                <div class="Allergies">
                                    <label for="TxtAllergies">Allergies</label>
                                    <input type="text" name="TxtAllergies" id="TxtAllergies" required>
                                </div>
                            </div>
                            <div class="Three-Info">
                                <div class="Surgeries">
                                    <label for="TxtSurgeries">Surgeries</label>
                                    <input type="text" name="TxtSurgeries" id="TxtSurgeries" >
                                </div>
                                <div class="Injuries">
                                    <label for="TxtInjuries">Injuries</label>
                                    <input type="text" name="TxtInjuries" id="TxtInjuries" required>
                                </div>
                                <div class="Illness">
                                    <label for="TxtIllness">Illness</label>
                                    <input type="text" name="TxtIllness" id="TxtIllness" required>
                                </div>
                            </div>
                            <div class="One-Info">
                                <legend>Physical Examination</legend>
                            </div>
                            <div class="Three-Info">
                                <div class="HearingDistance">
                                    <label for="TxtHearingDistance">Hearing Distance</label>
                                    <input type="text" name="TxtHearingDistance" id="TxtHearingDistance" >
                                </div>
                                <div class="Speech">
                                    <label for="TxtSpeech">Speech</label>
                                    <input type="text" name="TxtSpeech" id="TxtSpeech" >
                                </div>
                                <div class="Head">
                                    <label for="TxtHead">Head</label>
                                    <input type="text" name="TxtHead" id="TxtHead" >
                                </div>
                            </div>
                            <div class="Three-Info">
                                <div class="Eyes">
                                    <label for="TxtEyes">Eyes (Conjunctiva)</label>
                                    <input type="text" name="TxtEyes" id="TxtEyes" >
                                </div>
                                <div class="Ears">
                                    <label for="TxtEars">Ears</label>
                                    <input type="text" name="TxtEars" id="TxtEars" >
                                </div>
                                <div class="Nose">
                                    <label for="TxtNose">Nose</label>
                                    <input type="text" name="TxtNose" id="TxtNose" >
                                </div>
                            </div>
                            <div class="Three-Info">
                                <div class="Abdomen">
                                    <label for="TxtAbdomen">Abdomen</label>
                                    <input type="text" name="TxtAbdomen" id="TxtAbdomen" >
                                </div>
                                <div class="GenitoUrinary">
                                    <label for="TxtGenitoUrinary">Genito-urinary</label>
                                    <input type="text" name="TxtGenitoUrinary" id="TxtGenitoUrinary" >
                                </div>
                                <div class="LymphGlands">
                                    <label for="TxtLymphGlands">Lymph glands</label>
                                    <input type="text" name="TxtLymphGlands" id="TxtLymphGlands" >
                                </div>
                            </div>
                            <div class="Three-Info">
                                <div class="Skin">
                                    <label for="TxtSkin">Skin</label>
                                    <input type="text" name="TxtSkin" id="TxtSkin" >
                                </div>
                                <div class="Extremities">
                                    <label for="TxtExtremities">Extremities</label>
                                    <input type="text" name="TxtExtremities" id="TxtExtremities" >
                                </div>
                                <div class="Deformities">
                                    <label for="TxtDeformities">Deformities</label>
                                    <input type="text" name="TxtDeformities" id="TxtDeformities" >
                                </div>
                            </div>
                            <div class="Three-Info">
                                <div class="CavityAndThroat">
                                    <label for="TxtCavityAndThroat">Buccal Cavity and Throat</label>
                                    <input type="text" name="TxtCavityAndThroat" id="TxtCavityAndThroat"  >
                                </div>
                            </div>
                            <div class="One-Info">
                                <legend>Thorax</legend>
                            </div>
                            <div class="Three-Info">
                                <div class="Lungs">
                                    <label for="TxtLungs">Lungs</label>
                                    <input type="text" name="TxtLungs" id="TxtLungs" >
                                </div>
                                <div class="Heart">
                                    <label for="TxtHeart">Heart</label>
                                    <input type="text" name="TxtHeart" id="TxtHeart" >
                                </div>
                                <div class="Breast">
                                    <label for="TxtBreast">Breast</label>
                                    <input type="text" name="TxtBreast" id="TxtBreast" >
                                </div>
                            </div>
                            <div class="One-Info">
                                <legend>Vision (Snellen's)</legend>
                            </div>
                            <div id="space1" class="One-Info">
                                <legend>Without glasses</legend>
                            </div>
                            <div class="Two-Info">
                                <div class="OD">
                                    <label for="TxtWOGOD">OD</label>
                                    <input type="text" name="TxtWOGOD" id="TxtWOGOD" required>
                                </div>
                                <div class="OS">
                                    <label for="TxtWOGOS">OS</label>
                                    <input type="text" name="TxtWOGOS" id="TxtWOGOS" required>
                                </div>
                            </div>
                            <div id="space1" class="One-Info">
                                <legend>With glasses</legend>
                            </div>
                            <div class="Two-Info">
                                <div class="OD">
                                    <label for="TxtWGOD">OD</label>
                                    <input type="text" name="TxtWGOD" id="TxtWGOD" required>
                                </div>
                                <div class="OS">
                                    <label for="TxtWGOS">OS</label>
                                    <input type="text" name="TxtWGOS" id="TxtWGOS" required>
                                </div>
                            </div>
                            <div class="One-Info">
                                <legend>Vital Signs</legend>
                            </div>
                            <div class="Three-Info">
                                <div class="Temperature">
                                    <label for="TxtTemperature">Temperature</label>
                                    <input type="number" name="TxtTemperature" id="TxtTemperature" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                                <div class="PR">
                                    <label for="TxtPR">Pulse Rate</label>
                                    <input type="number" name="TxtPR" id="TxtPR" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                                <div class="BP">
                                    <label for="TxtBP">Blood Pressure</label>
                                    <input type="number" name="TxtBP" id="TxtBP" onkeypress="return isNumberKey(this,event)" required>
                                </div>
                            </div>
                            <div class="One-Info">
                                <div class="Complaints">
                                    <label for="TxtComplaints">Complaints</label>
                                    <textarea type="text" name="TxtComplaints" id="TxtComplaints" cols="105" rows="10" required ></textarea>
                                </div>
                            </div>
                            <div class="One-Info">
                                <div class="Diagnosis">
                                    <label for="TxtDiagnosis">Diagnosis</label>
                                    <textarea type="text" name="TxtDiagnosis" id="TxtDiagnosis" cols="105" rows="10" required ></textarea>
                                </div>
                            </div>
                            <div class="One-Info">
                                <legend>Treatment</legend>
                            </div>
                            <div class="One-Info">
                                <div class="ReferredTo">
                                    <label for="TxtReferredTo">Referred To</label>
                                    <input type="text" name="TxtReferredTo" id="TxtReferredTo" >
                                </div>
                            </div>
                            <div class="One-Info">
                                <div class="DiagnosticTestNeeded">
                                    <label for="TxtDiagnosticTestNeeded">Diagnostic Test Needed</label>
                                    <textarea type="text" name="TxtDiagnosticTestNeeded" id="TxtDiagnosticTestNeeded" cols="105" rows="10" required ></textarea>
                                </div>
                            </div>
                            <div class="One-Info">
                                <div class="MedicineGiven">
                                    <label for="TxtMedicineGiven">Medicine Given</label>
                                    <textarea type="text" name="TxtMedicineGiven" id="TxtMedicineGiven" cols="105" rows="10" required ></textarea>
                                </div>
                            </div>
                            <div class="submit">
                                <button type="Submit" id ="BtnAdd" class=form-button name="BtnAdd"><p>Add Record</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="button__svg" stroke-width="5" stroke="currentColor" fill="none"><polyline points="34.48 54.28 11.06 54.28 11.06 18.61 23.02 5.75 48.67 5.75 48.67 39.42"/><polyline points="23.04 5.75 23.02 18.61 11.06 18.61"/><line x1="16.21" y1="45.68" x2="28.22" y2="45.68"/><line x1="16.21" y1="39.15" x2="31.22" y2="39.15"/><line x1="16.21" y1="33.05" x2="43.22" y2="33.05"/><line x1="16.21" y1="26.95" x2="43.22" y2="26.95"/><circle cx="42.92" cy="48.24" r="10.01" stroke-linecap="round"/><line x1="42.92" y1="42.76" x2="42.92" y2="53.72"/><line x1="37.45" y1="48.24" x2="48.4" y2="48.24"/></svg></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/script-tab.js"></script>
    </body>
</html>

