<?php
/**
 * Created by PhpStorm.
 * User: damaha
 * Date: 20.12.2016
 * Time: 16:46
 */
IncludeModuleLangFile(__FILE__);
$htassess = "/.htaccess";
if($ht_handle = fopen($_SERVER['DOCUMENT_ROOT'].$htassess,"r")){
	fclose($ht_handle);
	$ht_handle = fopen($_SERVER['DOCUMENT_ROOT'].$htassess,"a");

}else{
	echo CAdminMessage::ShowMessage(
		Array(
			"TYPE"=>"ERROR", 
			"MESSAGE" =>GetMessage("HTACCESS_ERROR"), 
			"DETAILS"=>GetMessage("HTACCESS_ERROR_DESCRIPTION"),
			"HTML"=>true)
	);
}
?>
