<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"href="../css/style.css" />
   
</head>

</html>
<?php

// $conn = mysqli_connect("localhost","root","","phpsamples");
require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');

if(isset($_FILES['file']))

{
    $file=($_FILES['file']);
    $file_name=$file['name'];
    $file_error=$file['error'];
    $file_size=$file['size'];
    $file_tmp=$file['tmp_name'];
    $file_ext=explode(".",$file_name);
    $file_ext=strtolower(end($file_ext));
    $allowedFileType =array("xls","xlsx",);
//   $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
if(in_array($file_ext,$allowedFileType ))
{
//   if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
        //   first_name	second_name	last_name	sex	registration_number	email	address	department	course	level	semister	continuation	code	password
                $first_name = "";
                if(isset($Row[0])) {
                    $name = mysqli_real_escape_string($conn,$Row[0]);
                }
                
                $second_name = "";
                if(isset($Row[1])) {
                    $second_name = mysqli_real_escape_string($conn,$Row[1]);
                }

                $last_name = "";
                if(isset($Row[2])) {
                    $last_name = mysqli_real_escape_string($conn,$Row[1]);
                }
                $sex = "";
                if(isset($Row[3])) {
                    $sex = mysqli_real_escape_string($conn,$Row[1]);
                }
                $registration_number= "";
                if(isset($Row[4])) {
                    $registration_number = mysqli_real_escape_string($conn,$Row[1]);
                }
                $email = "";
                if(isset($Row[5])) {
                    $email = mysqli_real_escape_string($conn,$Row[1]);
                }
                $address= "";
                if(isset($Row[6])) {
                    $address= mysqli_real_escape_string($conn,$Row[1]);
                }
                $department= "";
                if(isset($Row[7])) {
                    $department= mysqli_real_escape_string($conn,$Row[1]);
                }
                $course= "";
                if(isset($Row[8])) {
                    $course = mysqli_real_escape_string($conn,$Row[1]);
                }
                $level = "";
                if(isset($Row[9])) {
                    $level = mysqli_real_escape_string($conn,$Row[1]);
                }
                $semister = "";
                if(isset($Row[10])) {
                    $semister= mysqli_real_escape_string($conn,$Row[1]);
                }
                if (!empty($first_name) && !empty($second_name)) {
                    $query = "INSERT INTO students( first_name,second_name,last_name,sex,registration_number,email,address,department,course,level,semister)
                     values('".$first_name."','".$second_name."','".$last_name."','".$sex."','".$registration_number."','".$email."','".$address."','".$department."','".$course."','".$level."','".$semister."' )";
                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
?>

    <h5>Import Excel File into System.</h5>
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" class="" name="file"id="file" accept=".xls,.xlsx">
                    <!-- <div class="col-md-6"> -->
                   <!-- <center> <h3><b>...</b></h3></center> -->
                <button type="submit" id="submit" name="import" class="btn btn-block btn-primary">Import</button>
                <!-- </div> -->
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>

</body>
</html>