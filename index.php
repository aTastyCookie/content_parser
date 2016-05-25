<?php
if (!isset($_SESSION)) session_start();
if(isset($_POST['table'])){	
		$error = "";
		$post = $_POST;
		$file_folder = "inc/files/"; 
		function copyFile($url,$dirname){ 
			@$file = fopen ($url, "rb"); 
			if (!$file) { 
			}else { 
				$filename = basename($url); 
				$fc = fopen($dirname."$filename", "wb"); 
				while (!feof ($file)) { 
				   $line = fread ($file, 1028); 
				   fwrite($fc,$line); 
				} 
				fclose($fc); 
			} 
		} 
		function create_zip($files = array(),$destination = '',$overwrite = false) {
			if(file_exists($destination) && !$overwrite) { return false; }
			$valid_files = array();
			if(is_array($files)) {
				foreach($files as $file) {
					if(file_exists($file)) {
						$valid_files[] = $file;
					}
				}
			}
			if(count($valid_files)) {
				$zip = new ZipArchive();
				if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
					return false;
				}
		
				foreach($valid_files as $file) {
					$zip->addFile($file,$file);
				}
				$zip->close();
				return file_exists($destination);
			}
			else
			{
				return false;
			}
		}
		
	if(extension_loaded('zip')){
		if(isset($post['table']) and count($post['table']) > 0)
		{
			$name_file = parse_url($_POST['url']);
			foreach($post['table'] as $key=>$val){
				copyFile($_SESSION['str'][$key]['src'],$file_folder);
			}
			$files_to_zip = scandir($file_folder);
			$files = array();
			foreach($files_to_zip as $key=>$val){
				if($val != '.' && $val != '..'){
					if(file_exists('inc/files/'.$val)){
						$files[] = 'inc/files/'.$val;
					}
				}
			}
			$zip_name = str_replace(".","_",$name_file['host']).'.zip';
			create_zip($files,$zip_name);
			
			foreach($files as $key=>$val){
				unlink($val);
			}
			
			if(file_exists($zip_name))
			{
				header('Content-type: application/zip');
				header('Content-Disposition: attachment; filename="'.$zip_name.'"');
				readfile($zip_name);
				unlink($zip_name);
			}
			
		
		}else{
			$error .= "* Please select file to zip ";
		}
	}else{
		$error .= "* You dont have ZIP extension";
	}
}
if(isset($_GET['export'])){
	require_once('inc/_export.php');
}elseif(isset($_GET['img_download'])){
	require_once('inc/_img_download.php');
}else{
	require_once('inc/_header.php');
	if(!count($_GET) || isset($_GET['main'])){$_SESSION['page']= 'images'; require_once('inc/_main.php');}
	elseif(isset($_GET['change_log'])){require_once('change_log.php');}
	elseif(isset($_GET['images'])){$_SESSION['page']= 'images';require_once('inc/_imgs.php');}
	elseif(isset($_GET['links'])){$_SESSION['page']= 'links';require_once('inc/_links.php');}
	elseif(isset($_GET['css'])){$_SESSION['page']= 'css';require_once('inc/_css.php');}
	elseif(isset($_GET['js'])){$_SESSION['page']= 'js';require_once('inc/_js.php');}
	elseif(isset($_GET['emails'])){$_SESSION['page']= 'emails';require_once('inc/_emails.php');}	
	elseif(isset($_GET['wp'])){$_SESSION['page']= 'wp';require_once('inc/_wp.php');}
	elseif(isset($_GET['phpbb'])){$_SESSION['page']= 'phpbb';require_once('inc/_phpbb.php');}
	elseif(isset($_GET['smf'])){$_SESSION['page']= 'smf';require_once('inc/_smf.php');}
	elseif(isset($_GET['works'])){require_once('inc/_works.php');}			
	require_once('inc/_footer.php');
}
?>    