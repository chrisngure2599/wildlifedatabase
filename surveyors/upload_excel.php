<title>Upload Data via Excell</title>
<?php 
	require_once '../includes/main.php';
	require_once '../includes/db.php';
	require_once '../includes/import_excel/vendor/php-excel-reader/excel_reader2.php';
	require_once '../includes/import_excel/vendor/SpreadsheetReader.php';
	
	require_once 'nav.php';
	require_once 'gaurd.php';
?>	
<form method="post" class="w3-container" enctype="multipart/form-data" >
	<label class=" w3-xlarge" >File</label>
	<input required="" type="file" class="w3-input" name="exel"><br>
	<input type="submit" name="go" accept=".xls,.xlsx" class="w3-btn w3-blue w3-block" value="Import" >
</form>
<?php 
 //prosessing ze data
  if (isset($_POST['go']) && !empty($_FILES['exel']['name']) ) {
 	//Starting the uploading process
 	$file=($_FILES['exel']);
    $file_name=$file['name'];
    $file_error=$file['error'];
    $file_size=$file['size'];
    $file_tmp=$file['tmp_name'];
    $file_ext=explode(".",$file_name);
    $file_ext=strtolower(end($file_ext));
    $allowedFileType =array("xls","xlsx",);
    //Checkin the size
    $asize=10*1024*1024;
    if ($file_size<=$asize) {
    	//then checking if the file is allowed
    	if (in_array($file_ext,$allowedFileType)) {
    		//then uploading
    		//#The final name
    		$fname=uniqid().'.'.$file_ext;
    		if (move_uploaded_file($file_tmp,$fname)) {
    			//then reading the file
    			$Reader = new SpreadsheetReader($fname);
    			//After All we delete the file
        		$sheetCount = count($Reader->sheets());
    			//Going through sheets
    			for ($i = 0; $i <$sheetCount ; $i++) {
    				//going to the current sheet
    				$Reader->changesheet($i);
    				//Going to rows
    				foreach ($Reader as $row) {
    					//here its when we take one data at a time
    					
    				}
    			}
    			unlink($fname);
    		}else{
    		echo 'Failed the file failed to upload!';
    		}
    	}
    }else {
    	echo 'Failed the file size is not allowed!';
    }

 }

 ?>
