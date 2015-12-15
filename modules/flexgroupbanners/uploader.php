<?php
require_once(dirname(__FILE__).'../../../config/config.inc.php');
require_once(dirname(__FILE__).'../../../init.php');
require_once(dirname(__FILE__).'/flexgroupbanners.php');
$module = new FlexGroupBanners();
$response = new stdClass();
if (!Tools::isSubmit('secure_key') || Tools::getValue('secure_key') != $module->secure_key){
	$response->status = 0;
	$response->fileName = "";		
	$response->msg =  $module->l("you need to login with the admin account.");
}else{	
	$fileType = strtolower(pathinfo($_FILES["uploader"]["name"], PATHINFO_EXTENSION));
	$fileName = time().'.'.$fileType;
	$fileTemp = $module->pathImage.'temps/'.$fileName;
	
	if(isset($_REQUEST['width']) && intval($_REQUEST['width']) >0) $width = intval($_REQUEST['width']);
	else $width = null;
	
	if(isset($_REQUEST['height']) && intval($_REQUEST['height']) >0) $height = intval($_REQUEST['height']);
	else $height = null;
	
	if(isset($_REQUEST['maxFileSize']) && $_REQUEST['maxFileSize']) $maxFileSize = $_REQUEST['maxFileSize'];
	else $maxFileSize = 1; // MB
	
	if(isset($_REQUEST['uploadType']) && $_REQUEST['uploadType']) $uploadType = $_REQUEST['uploadType'];
	else $uploadType = 'image';
	
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
						include(dirname(__FILE__).'/flexGroupBannersThumb.php');					
						$img = new FlexGroupBannersThumb();
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