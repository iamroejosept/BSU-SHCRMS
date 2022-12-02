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
        <title>Search Staff</title>
        <link rel="stylesheet" href="../css/searchUser-style.css">
        <link rel = "icon" href = "../images/BSU-Logo.png" type = "image/x-icon">
        <script src="../dist/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="../dist/jquery-confirm.min.css">
        <script src="../dist/jquery-confirm.min.js"></script>
        <script type="text/javascript">
            var Num;

            function logout(){
            sessionStorage.clear();
        }

            function searchUser(form_data)
            {   
                $.ajax(
                {
                    url:"../php/SearchUser.php",
                    method:"POST",
                    data:form_data,
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: "xml",
                    success:function(xml)
                    {
                        $(xml).find('user').each(function()
                        {  
                            Num = $(this).attr('Num');
                            var message = $(this).attr('Message');
                            var firstname = $(this).attr('Firstname');
                            var middlename = $(this).attr('Middlename');
                            var lastname = $(this).attr('Lastname');
                            var position = $(this).attr('Position');
                            var accesslevel = $(this).attr('AccessLevel');
                            var username = $(this).attr('Username');
                            var password = $(this).attr('Password');
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

                            $('#TxtFirstName').val(firstname);
                            $('#TxtMiddleName').val(middlename);
                            $('#TxtLastName').val(lastname);
                            $('#TxtPosition').val(position);
                            $('#TxtAccessLevel').val(accesslevel);
                            $('#TxtUsername').val(username);
                            $('#TxtPassword').val(password);
                        });
                     },
                    error: function (e)
                    {
                        //Display Alert Box
                        $.alert(
                        {theme: 'modern',
                        content:'Failed to search informations due to errors',
                        title:'', 
                        buttons:{
                            Ok:{
                            text:'Ok',
                            btnClass: 'btn-red'
                        }}});
                    }
                });
            }

            function updateUser(form_data)
            {   
                form_data.append('Num',Num);
                $.ajax(
                { 
                    url:"../php/UpdateUser.php",
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
                            $('#TxtPosition').val('');
                            $('#TxtAccessLevel').val('');
                            $('#TxtUsername').val('');
                            $('#TxtPassword').val('');
                        });
                     },
                    error: function (e)
                    {
                        //Display Alert Box
                        $.alert(
                        {theme: 'modern',
                        content:'Failed to update informations due to errors',
                        title:'', 
                        buttons:{
                            Ok:{
                            text:'Ok',
                            btnClass: 'btn-red'
                        }}});
                    }
                });
            }

            function deleteUser(){
                var form_data = new FormData();
                form_data.append("Num", Num);

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
                                    $.ajax(
                                    { 
                                        url:"../php/DeleteUser.php",
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
                                                $('#TxtPosition').val('');
                                                $('#TxtAccessLevel').val('');
                                                $('#TxtUsername').val('');
                                                $('#TxtPassword').val('');
                                            });
                                        },
                                        error: function (e)
                                        {
                                        //Display Alert Box
                                        $.alert(
                                        {theme: 'modern',
                                        content:'Failed to delete the account of the user',
                                        title:'', 
                                        buttons:{
                                            Ok:{
                                            text:'Ok',
                                            btnClass: 'btn-red'
                                        }}});
                                        }
                                    });
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

                $("#search-user").submit(function(event)
                {                
                    /* stop form from submitting normally */
                    event.preventDefault();
                    var form_data = new FormData(this);

                    searchUser(form_data);
                           
                });

                $("#update-user").submit(function(event)
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
                                    updateUser(form_data);
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
            <a href="#" id="nav4" class="nav-pages admin-nav">Search Staff</a>
            <a href="../pages/addRecord.php" id="nav5" class="nav-pages">Add Record</a>
            <a href="#" id="nav6" class="nav-pages">Search Record</a>
            <a href="../php/logout.php" id="nav7" onclick="logout()" class="nav-pages">Logout</a>
            <div id="line" class="animation line"></div>
        </nav>
        <div class="searchContainer">
            <form action="#" method="post" id="search-user">
                <div class="Three-Info">
                    <div class="FirstName">
                        <label for="SearchTxtFirstName">Firstname</label>
                        <input type="text" class="searchField" name="SearchTxtFirstName" id="SearchTxtFirstName" required>
                    </div>
                    <div class="LastName">
                        <label for="SearchTxtLastName">Lastname</label>
                        <input type="text" class="searchField" name="SearchTxtLastName" id="SearchTxtLastName" required>
                    </div>
                    <div class="submit">
                        <button type="Submit" id ="BtnSearch" class="searchButton" name="BtnSearch"><p>Search</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="button__svg" stroke-width="5" stroke="currentColor" fill="none"><circle cx="27.31" cy="25.74" r="18.1"/><line x1="39.58" y1="39.04" x2="56.14" y2="57"/></svg></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container">
            <div class="tabs">
                <div class="tabs-head">
                    <span id="tab1" class="tabs-toggle is-active">&bull;&nbsp;Staff Information&nbsp;&bull;</span>
                </div>
                <div class="tabs-body">
                    <div class="tabs-content is-active">
                        <form action="#" method="post" id="update-user">
                            <div class="Three-Info">
                                <div class="FirstName">
                                    <label for="TxtFirstName">Firstname</label>
                                    <input type="text" name="TxtFirstName" id="TxtFirstName" required>
                                </div>
                                <div class="MiddleName">
                                    <label for="TxtMiddleName">Middlename</label>
                                    <input type="text" name="TxtMiddleName" id="TxtMiddleName" required>
                                </div>
                                <div class="LastName">
                                    <label for="TxtLastName">Lastname</label>
                                    <input type="text" name="TxtLastName" id="TxtLastName" required>
                                </div>
                            </div>
                            <div class="Two-Info">
                                <div class="Position">
                                    <label for="TxtPosition">Position</label>
                                    <input type="text" name="TxtPosition" id="TxtPosition" required>
                                </div>
                                <div class="AccessLevel">
                                    <label for="TxtAccessLevel">Access Level</label>
                                    <input type="text" name="TxtAccessLevel" id="TxtAccessLevel" required>
                                </div>
                            </div>
                            <div class="Two-Info">
                                <div class="Username">
                                    <label for="TxtUsername">Username</label>
                                    <input type="text" name="TxtUsername" id="TxtUsername" required>
                                </div>
                                <div class="Password">
                                    <label for="TxtPassword">Password</label>
                                    <input type="text" name="TxtPassword" id="TxtPassword" required>
                                </div>
                            </div>
                            <div id="twoButton">
                                <div class="submit">
                                    <button type="Submit" id ="BtnUpdate" class=form-button name="BtnUpdate"><p>Update</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="button__svg" stroke-width="5" stroke="currentColor" fill="none"><polyline points="34.48 54.28 11.06 54.28 11.06 18.61 23.02 5.75 48.67 5.75 48.67 39.42"/><polyline points="23.04 5.75 23.02 18.61 11.06 18.61"/><line x1="16.21" y1="45.68" x2="28.22" y2="45.68"/><line x1="16.21" y1="39.15" x2="31.22" y2="39.15"/><line x1="16.21" y1="33.05" x2="43.22" y2="33.05"/><line x1="16.21" y1="26.95" x2="43.22" y2="26.95"/><circle cx="42.92" cy="48.24" r="10.01" stroke-linecap="round"/><line x1="42.92" y1="42.76" x2="42.92" y2="53.72"/><line x1="37.45" y1="48.24" x2="48.4" y2="48.24"/></svg></button>
                                </div>
                                <div class="submit">
                                    <button type="button" id="BtnDelete" class=form-button name="BtnDelete" onclick="deleteUser()"><p>Delete</p><svg xmlns="http://www.w3.org/2000/svg" class="button__svg" stroke-width="40" stroke="currentColor" fill="none" viewBox="0 0 320 512"><!--! Font Awesome Free 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc.--><path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/script-tab.js"></script>
    </body>
</html>

