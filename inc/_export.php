<?php
if($_GET['export'] == 'txt' && isset($_SESSION['str'])){
	header("Content-Type: plain/text");
	header("Content-Disposition: Attachment; filename=".$_SESSION['name_file'].".txt");
	header("Pragma: no-cache");
	foreach($_SESSION['str'] as $key =>$val){
		$val['class'] = implode(",",$val['class']);
		echo  implode("|",$val)."\r\n";
	}
}elseif($_GET['export'] == 'json' && isset($_SESSION['str'])){
	header("Content-Type: text/csv");
	header("Content-Disposition: Attachment; filename=".$_SESSION['name_file'].".js");
	header("Pragma: no-cache");
	echo '{"'.$_SESSION['page'].'":['."\r\n";
	foreach($_SESSION['str'] as $key =>$val){
		echo "\t"."{\"ObjectID\":".$key,","."\r\n";
		echo "\t"." \"Attributes\":[{"."\r\n";
		foreach($val as $k=>$v){
			if(count($v)>1){
				echo "\t\t\t\"".$k."\": [{\"".implode("\",\"",$v)."\"}],\r\n";
			}else{
				echo "\t\t\t\"".$k."\":\"".$v."\",\r\n";				
			}
		}
		echo "\t\t\t}]"."\r\n";		
		echo "\t"."},\r\n";
	//	echo "\t".$key."\t\n";
	}
	echo ']}';
}elseif($_GET['export'] == 'xml' && isset($_SESSION['str'])){
	header("Content-Type: text/xml");
	header("Content-Disposition: Attachment; filename=".$_SESSION['name_file'].".xml");
	header("Pragma: no-cache");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<".$_SESSION['page'].">\r\n";
	foreach($_SESSION['str'] as $val){
		echo "\t<object>\r\n";
		foreach($val as $k=>$v){
			if(count($v)>1){
				echo "\t\t<".$k.">".implode(",",$v)."</".$k.">\r\n";
			}else{
				echo "\t\t<".$k.">".$v."</".$k.">\r\n";				
			}
		}	
		echo "\t</object>\r\n";		
	}
	echo  '</'.$_SESSION['page'].'>';
}
?>