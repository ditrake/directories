<?php
/**
 * Created by PhpStorm.
 * User: damaha
 * Date: 20.12.2016
 * Time: 16:25
 */
IncludeModuleLangFile(__FILE__);
class damaha_directories extends CModule
{
	var $MODULE_ID = "damaha.directories";
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $PARTNER_NAME;
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;

	function damaha_directories(){
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}
		else
		{
			$this->MODULE_VERSION = IBLOCK_VERSION;
			$this->MODULE_VERSION_DATE = IBLOCK_VERSION_DATE;
		}

		$this->MODULE_NAME = GetMessage("IBLOCK_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("IBLOCK_INSTALL_DESCRIPTION");
		$this->PARTNER_NAME = GetMessage("PARTNER_NAME");
	}

	function DoInstall()
	{
		global $DB, $APPLICATION, $step;
		if (!IsModuleInstalled("damaha.directories")) {
			if ($this->InstallHtaccess()) {
				$this->InstallDB();
				$this->InstallFiles();
			}
		}
		//$APPLICATION->IncludeAdminFile(GetMessage("FORM_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/damaha.directories/install/step1.php");
	}
	function DoUninstall()
	{
		$this->UnInstallDB();
		$this->UnInstallFiles();
		$this->UnInstallHtaccess();
	}
	function InstallDB()
	{
		RegisterModule("damaha.directories");
		//RegisterModuleDependences("search", "OnReindex", "alexey.mycar", "CMyCarSearch", "OnSearchReindex");
		return true;
	}
	function UnInstallDB()
	{
		//UnRegisterModuleDependences("search", "OnReindex", "alexey.mycar", "CMyCarSearch", "OnSearchReindex");
		UnRegisterModule("damaha.directories");
		return true;
	}
	function InstallFiles(){
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/damaha.directories/install/bitrix/",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix",
			true, true
		);
		return true;
	}
	function UnInstallFiles(){
		DeleteDirFilesEx("/bitrix/urlrewrite_directories.php");
		return true;
	}
	function InstallHtaccess(){
		global $APPLICATION;
		$error = "";
		$htassess = "/.htaccess";
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$htassess)){
			if(is_writable($_SERVER['DOCUMENT_ROOT'].$htassess)){
				$file = file($_SERVER['DOCUMENT_ROOT'].$htassess);
				$find = false;
				foreach ($file as $key => $line){
					if(strpos($line,"RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite.php$")){
						$find = true;
						$file[$key] = "#".$line."RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite_directories.php$\n";
						break;
					}
				}
				if(!$find){
					$error = GetMessage("HTACCESS_ERROR_STRING_DESCRIPTION");
				}else{
					file_put_contents($_SERVER['DOCUMENT_ROOT'].$htassess,$file);
				}
			}else{
				$error = GetMessage("HTACCESS_ACCESS_DENIED");
			}
		}else{
			$error = GetMessage("HTACCESS_ERROR_DESCRIPTION");
		}
		if($error != "") {
			$exception = new CAdminException();
			$exception->AddMessage(
				Array(
					"id" => 0,
					"text" => $error,
				)
			);
			$APPLICATION->ThrowException($exception);
			return false;
		}
		return true;
	}
	function UnInstallHtaccess(){
		global $APPLICATION;
		$error = "";
		$htassess = "/.htaccess";
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$htassess)){
			if(is_writable($_SERVER['DOCUMENT_ROOT'].$htassess)){
				$file = file($_SERVER['DOCUMENT_ROOT'].$htassess);
				$find = false;
				foreach ($file as $key => $line){
					if(strpos($line,"RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite_directories.php$")){
						$find = true;
						$file[$key] = "RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite.php$\n";
						break;
					}
				}
				if(!$find){
					$error = GetMessage("HTACCESS_ERROR_STRING_DESCRIPTION");
				}else{
					file_put_contents($_SERVER['DOCUMENT_ROOT'].$htassess,$file);
				}
			}else{
				$error = GetMessage("HTACCESS_ACCESS_DENIED");
			}
		}else{
			$error = GetMessage("HTACCESS_ERROR_DESCRIPTION");
		}
		if($error != "") {
			$exception = new CAdminException();
			$exception->AddMessage(
				Array(
					"id" => 0,
					"text" => $error,
				)
			);
			$APPLICATION->ThrowException($exception);
			return false;
		}
		return true;
	}
	
}