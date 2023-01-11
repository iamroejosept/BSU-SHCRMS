<?php
    require_once '../php/centralConnection.php';
    session_start();
    if(empty($_SESSION['logged_in'])){
        header('Location: ../../index.html');
    } 

    $message = '';
?>
<!DOCTYPE html>  
<html>  
 <head>  
  <title>Restore</title>  
  <script src="dist/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/restore.css">
  <script src="../dist/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../dist/jquery-confirm.min.css">
  <script src="../dist/jquery-confirm.min.js"></script>
  <script src="../dist/jspdf.debug.js"></script>
  <script src="../dist/jspdf.min.js"></script>
  <script src="../dist/html2pdf.bundle.min.js"></script> 
  <script>
    var globalAL = "";

    // ---------------------------start functions for System Logs---------------------------------------
            var act = "";

            //function called when logout tab pressed
            function logout(){
                act = "Logged out";
                logAction(act);
                /*alert("logs success");*/
                  $.ajax({
                    url:"../php/logout.php",
                    method:"POST",
                    data:"",
                    success:function(xml){
                        sessionStorage.clear();
                        setTimeout(function(){
                            window.location.href = '../index.html';
                        }, 100);
                    }
                  })
            }

            //main function for user activity logging
            function logAction(userAction){
                act = userAction;
                $.ajax({
                    url:"../php/logAction.php",
                    method:"POST",
                    data:jQuery.param({ action: act, isSuccess:"1" }),
                    dataType: "xml",
                    success:function(xml){

                    }
                  })
            }

            //called to log user clicking "logs" tab
            function userCheckLogs(){
                act = "Checked User Activities." 
                logAction(act);
            }

            function userRestore(){
                act = "User Restored from a Backup." 
                logAction(act);
            }
        // ---------------------------end functions for System Logs---------------------------------------
    
    function openManual(){
                if(globalAL == "admin"){
                    window.open("../files/ManualAdmin.pdf");
                }else if(globalAL == "superadmin"){
                    window.open("../files/ManualSuperadmin.pdf");
                }else{
                    window.open("../files/ManualStandard.pdf");                }
            }
  </script>
 </head>  
 <body>  
    <nav>
        <a href="javascript:history.back()" id="back" class="nav-pages">Go Back</a> 
    </nav> 
  <br /><br />  
  <div class="container" style="width:700px;">  
    
   <h3 align="center">Please select a backup file to restore database</h3>  
   <br />
   <div><?php echo $message; ?></div>
   <form method="post" enctype="multipart/form-data">
    <p><label>Select Sql File</label>
    <input type="file" name="database" /></p>
    <br />
    <input type="submit" name="import" class="btn btn-info" onclick="userRestore()" value="Upload" /><br><br>
   </form>
  </div>  
 </body>  
</html>

<?php 

$tempo = $_SESSION['accesslevel'];

    echo "<script type='text/javascript'>
        globalAL = '$tempo';
    </script>";


if(isset($_POST["import"]))
{
 if($_FILES["database"]["name"] != '')
 {
  $array = explode(".", $_FILES["database"]["name"]);
  $extension = end($array);
  if($extension == 'sql')
  {
   $output = '';
   $count = 0;
   $file_data = file($_FILES["database"]["tmp_name"]);
   foreach($file_data as $row)
   {
    $start_character = substr(trim($row), 0, 2);
    if($start_character != '--' || $start_character != '/*' || $start_character != '//' || $row != '')
    {

     $output = $output . $row;
     
     $end_character = substr(trim($row), -1, 1);
     if($end_character == ';')
     {
      if(!mysqli_query($connect, $output))
      {
       $count++;
      }
      $output = '';
     }
    }
   }
   if($count > 0)
   {
    $message = '<label class="text-danger">There is an error in Database Import</label>';
   }
   else
   {
    $message = '<label class="text-success">Database Successfully Imported</label>';
   }
  }
  else
  {
   $message = '<label class="text-danger">Invalid File</label>';
  }
 }
 else
 {
  $message = '<label class="text-danger">Please Select Sql File</label>';
 }
}
?>


