<?php
require_once(dirname(__FILE__).'../../../config/config.inc.php');
require_once(dirname(__FILE__).'../../../init.php');
require_once(dirname(__FILE__).'/pagelink.php');
$module = new PageLink();
$response = new stdClass();
if (!Tools::isSubmit('secure_key') || Tools::getValue('secure_key') != $module->secure_key){
	$response->status = 0;
	$response->fileName = "";		
	$response->msg =  $module->l("you need to login with the admin account.");
}else{	
	$fileType = strtolower(pathinfo($_FILES["uploader"]["name"], PATHINFO_EXTENSION));
	$fileName = time().'.'.$fileType;
	$fileTemp = $module->pathImage.'temps/'.$fileName;
	
	if(isset($_POST['width']) && intval($_POST['width']) >0) $width = intval($_POST['width']);
	else $width = null;
	
	if(isset($_POST['height']) && intval($_POST['height']) >0) $height = intval($_POST['height']);
	else $height = null;
	
	if(isset($_POST['maxFileSize']) && $_POST['maxFileSize']) $maxFileSize = $_POST['maxFileSize'];
	$maxFileSize = 1; // MB
	
	if(isset($_POST['uploadType']) && $_POST['uploadType']) $uploadType = $_POST['uploadType'];
	$uploadType = 'image';
	
	if($uploadType == 'document') $fileTypes = array('doc', 'docx', 'xls', 'xlsx', 'pdf');
	elseif($uploadType == 'zip')  $fileTypes = array('zip', 'rar');
	else $fileTypes = array('jpg', 'jpeg', 'png', 'gif');
	
	
	
	if(in_array($fileType, $fileTypes)){
		$fileSize = $_FILES["uploader"]["size"]/1048576; //MB	
		if($fileSize <= $maxFileSize){
			if($uploadType == 'image'){
				if($width == null && $height == null){
					if (@move_uploaded_file($_FILES['uploader']['tmp_name'], $fileTemp)) {						
						$response->status = 1;
						$response->msg = $module->l("Upload file success!");
						$response->fileName = $fileName;
					} else {
						$response->status = 0;
						$response->msg = $module->l("Upload file not success!");
						$response->fileName = "";
					}
				}else{
					if (@move_uploaded_file($_FILES['uploader']['tmp_name'], $fileTemp)) {					
						$imageSize = getimagesize($fileTemp);	
						include(dirname(__FILE__).'/flexSimpleMenusThumb.php');					
						$img = new FlexSimpleMenusThumb();
						@$img->pCreate($fileTemp, $width, $height, 100, true);	
						@$img->pSave($fileTemp);
					  	$response->status = 1;
						$response->msg = $module->l("Upload file success!");
						$response->fileName = $fileName;						
					} else {
						$response->status = 0;
						$response->msg = $module->l("Upload file not success!");
						$response->fileName = "";
					}	
				}
			}else{
				if (@move_uploaded_file($_FILES['uploader']['tmp_name'], $fileTemp)) {
					$response->status = 1;
					$response->msg = $module->l("Upload file success!");
					$response->fileName = $fileName;
					
				} else {
					$response->status = 0;
					$response->msg = $module->l("Upload file success!");
					$response->fileName = "";
				}
			}
		}else{
			$response->status = 0;			
			$response->msg = $module->l("File size is greater than ".$maxFileSize." MB");
			$response->fileName = "";
		}
			
	}else{
		$response->status = 0;
		$response->msg = $module->l("Not support file ".$fileType);
		$response->fileName = "";
	}
	die(Tools::jsonEncode($response));
}

?>