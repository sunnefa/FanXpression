<?php
/***********************
    FanXpression
    ********************
    Copyright 2011 Sunnefa Lind
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    ********************
    FanXpression version: Version 1.0.3 Beta
    Current file: fanx_admin/js/tinyupload.php
    Originally created by hudlin <http://sourceforge.net/tracker/index.php?func=detail&aid=2042964&group_id=103281&atid=738747>
    Edited by Sunnefa Lind

 *********************/

/**
 * Handles the actual uploading of files from TinyUpload
*/

define('FANX', true);
include '../../fanx_config/init.php';

//###### Config ######
$absPthToSlf = URL . 'fanx_admin/js/tinyupload.php'; //The Absolute path (from the clients POV) to this file.
$absPthToDst = URL . 'fanx_uploads/'; //The Absolute path (from the clients POV) to the destination folder.
$absPthToDstSvr = UPLOADS; 
//The Absolute path (from the servers POV) to the destination folder. 
//You will need to set permissions for this dir 0777 worked ok for me.

function hasAccess(){
	/**
	If you need to do a securty check on your user here is where you should put the code.
	*/
	return true;
}
//###### You should not need to edit past this point ######
if(isset($_GET["poll"])){
	$dh  = opendir($absPthToDstSvr);
	while (false !== ($filename = readdir($dh))) {
	  $files[] = $filename;
	}
        //$files = scandir($absPthToDstSvr);
	sort($files);
	
	//Filter out html files and directories.
	function filterHTML($var) {
                global $absPthToDstSvr;
		if(is_dir($absPthToDstSvr . $var) or substr_count($var, '.html') > 0 or $var == '.DS_Store'){
			return false;
		}
		else{
			return true;
		}
	}
	$files = array_filter($files, 'filterHTML');
	$str = '[';
	foreach ($files as $file){
		$str .= '{';
		$str .= '"url":"'. $absPthToDst . $file .'",';
		$str .= '"file":"'. $file .'"';
		$str .= '}, ';
	}
        $str = substr($str, 0, -2);
	$str .= ']';
	echo $str;
}
elseif (hasAccess()){
    if(isset($_FILES['tuUploadFile'])) {
        $_FILES['tuUploadFile']['name'] = $absPthToDstSvr . $_FILES['tuUploadFile']['name'];
        $images = Images::get_instance();
        $success = $images->upload_image($_FILES['tuUploadFile']);
        if(!$success) {
            die('Could not upload image');
        }
    }
?>
<html>
<head>
<style type="text/css">
	body{
		font-size:10px;
		margin:0px;
		padding:0px;
		height:20px;
		overflow:hidden;
	}
</style>
<script type="text/javascript">
	window.onload = function(){
		parent.tuIframeLoaded();
	}
	function tuSmt(){
		filePath = '<?php echo $absPthToDst; ?>' +
(document.getElementById('tuUploadFile').value).replace(/^.*[\/\\]/g, '');
		if(parent.tuFileUploadStarted(filePath, document.getElementById('tuUploadFile').value)){
			window.document.body.style.cssText = 'border:none;padding-top:100px';
			document.getElementById('tuUploadFrm').submit();
		}
	}
</script>
</head>
<body style="border:none;">
	<form enctype="multipart/form-data" method="post" action="<?php echo $absPthToSlf; ?>" id="tuUploadFrm">
		<div style="height:22px;vertical-align:top;">
			<input type="file" size="24" style="height:22px;" id="tuUploadFile" name="tuUploadFile" />
			<input type="button" value="Go" onclick="javascript:tuSmt();" style="margin:0px 0px 20px 2px;border:1px solid #808080;background:#fff;height:20px;"/>
		</div>
	</form>
</body>
</html>
<?php
}
?>