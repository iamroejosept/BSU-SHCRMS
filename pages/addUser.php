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
        <title>Add Staff</title>
        <link rel="stylesheet" href="../css/addUser-style.css">
        <link rel = "icon" href = "../images/BSU-Logo.png" type = "image/x-icon"> <!-- ???? -->
        <script src="../dist/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="../dist/jquery-confirm.min.css">
        <script src="../dist/jquery-confirm.min.js"></script>
        <script type="text/javascript">

        function logout(){
            sessionStorage.clear();
        }

        function addUser(form_data)
            {  
                $.ajax(
                {
                    url:"../php/addUser.php",
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
                                $.alert(
                                {theme: 'modern',
                                content: message,
                                title:'', 
                                buttons:{
                                    Ok:{
                                    text:'Ok',
                                    btnClass: 'btn-green'
                                }}});
                            }

                            $('#TxtFirstName').val('');
                            $('#TxtMiddleName').val('');
                            $('#TxtLastName').val('');
                            $('#RadPosition').val('');
                            $('#RadAccLevel').val('');
                            $('#TxtUsername').val('');
                            $('#TxtPassword').val('');
                            //changes made for radio buttons 
                            $('#RadDoctor').prop('checked', false);
                            $('#RadNurse').prop('checked', false);
                            $('#RadClinicAid').prop('checked', false);
                            $('#RadAdmin').prop('checked', false);
                            $('#RadStaff').prop('checked', false);
                        });
                     },
                    error: function (e)
                    {
                        //Display Alert Box
                        $.alert(
                        {theme: 'modern',
                        content:'Failed to add user due to errors',
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
                $("#add-user").submit(function(event)
                {                
                    /* stop form from submitting normally */
                    event.preventDefault();
                    var form_data = new FormData(this);

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
                                    addUser(form_data);
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

                var acclvl = sessionStorage.getItem('isStandard');

                if(acclvl == "true"){
                    $(".admin-nav").hide();
                    document.getElementById("nav1").style.width = "64%";
                    document.getElementById("nav2").style.width = "8%";
                    document.getElementById("nav5").style.width = "8%";
                    document.getElementById("nav6").style.width = "14%";
                    document.getElementById("nav7").style.width = "5%";
                    document.getElementById("line").style.width = "4.5%";
                    document.getElementById("line").style.left = "66%";

                    document.getElementById("nav5").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "7.8%";
                        document.getElementById("line").style.left = "72.3%";
                    });
                    document.getElementById("nav5").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "4.5%";
                        document.getElementById("line").style.left = "66%";
                    });

                    document.getElementById("nav6").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "9.5%";
                        document.getElementById("line").style.left = "82.3%";
                    });
                    document.getElementById("nav6").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "4.5%";
                        document.getElementById("line").style.left = "66%";
                    });

                    document.getElementById("nav7").addEventListener("mouseover", function(){
                        document.getElementById("line").style.width = "4.3%";
                        document.getElementById("line").style.left = "94.5%";
                    });

                    document.getElementById("nav7").addEventListener("mouseout", function(){
                        document.getElementById("line").style.width = "4.5%";
                        document.getElementById("line").style.left = "66%";
                    });
                }
            }); 
        </script>
    </head>
    <body>
        <nav>
            <a href="../pages/homepage.php" id="nav1" class="nav-logo"><img src="../images/nav-logo.png" alt="Logo"></a>
            <a href="../pages/homepage.php" id="nav2" class="nav-pages">Home</a>
            <a href="#" id="nav3" class="nav-pages admin-nav">Add Staff</a>
            <a href="../pages/searchUser.php" id="nav4" class="nav-pages admin-nav">Search Staff</a>
            <a href="../pages/addRecord.php" id="nav5" class="nav-pages">Add Record</a>
            <a href="#" id="nav6" class="nav-pages">Search Record</a>
            <a href="../php/logout.php" id="nav7" onclick="logout()" class="nav-pages">Logout</a>
            <div id="line" class="animation line"></div>
        </nav>
        <div class="container">
            <div class="tabs">
                <div class="tabs-head">
                    <span id="tab1" class="tabs-toggle is-active" style="margin:auto";>&bull;&nbsp;Add Staff&nbsp;&bull;</span>
            </div>
            <div class="tabs-body">
                <div class="tabs-content is-active">
                    <form action="#" method="post" id="add-user">

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
                            <div class="Position">
                                <label for="RadPosition">Position</label><br>
                                <!-- additional code for readio button -->
                                <label class="CSPosition">
                                        <input type="radio" class="RadPosition" id="RadDoctor" name="RadPosition" value="Doctor">
                                        <span class="RadDesign"></span>
                                        <span class="RadText">Doctor</span>
                                </label>
                                <label class="CSPosition">
                                        <input type="radio" class="RadPosition" id="RadNurse" name="RadPosition" value="Nurse">
                                        <span class="RadDesign"></span>
                                        <span class="RadText">Nurse</span>
                                </label>
                                <label class="CSPosition">
                                        <input type="radio" class="RadPosition" id="RadClinicAid" name="RadPosition" value="Clinic Aid">
                                        <span class="RadDesign"></span>
                                        <span class="RadText">Clinic Aid</span>
                                </label>
                            </div>
                            <div class="AccessLevel">
                                <label for="RadAccLevel">Access Level</label><br>
                                 <label class="CSAcc">
                                        <input type="radio" class="RadAccLevel" id="RadAdmin" name="RadAccLevel" value="Admin">
                                        <span class="RadDesign"></span>
                                        <span class="RadText">Admin</span>
                                </label>
                                <label class="CSPosition">
                                        <input type="radio" class="RadAccLevel" id="RadStaff" name="RadAccLevel" value="Standard">
                                        <span class="RadDesign"></span>
                                        <span class="RadText">Staff</span>
                                </label>
                            </div>
                        </div>
                         <!-- end of additional code for readio button -->
                        <div class="Two-Info">
                            <div class="Username">
                                <label for="TxtUsername">Username</label>
                                <input type="text" name="TxtUsername" id="TxtUsername" required>
                            </div>
                            <div class="Password">
                                <label for="TxtPassword">Password</label>
                                <input type="password" name="TxtPassword" id="TxtPassword" required>
                            </div>
                        </div>
                        
                        <div class="submit">
                            <button type="Submit" id ="BtnAdd" class=form-button name="BtnAdd"><p>Add</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" stroke-width="5" class="button__svg" stroke="currentColor" fill="none"><circle cx="29.22" cy="16.28" r="11.14"/><path d="M41.32,35.69c-2.69-1.95-8.34-3.25-12.1-3.25h0A22.55,22.55,0,0,0,6.67,55h29.9"/><circle cx="45.38" cy="46.92" r="11.94"/><line x1="45.98" y1="39.8" x2="45.98" y2="53.8"/><line x1="38.98" y1="46.8" x2="52.98" y2="46.8"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <script src="../js/script-tab.js"></script>
</body>
</html>

