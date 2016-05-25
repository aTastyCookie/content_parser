<?php 
$_SESSION['str'] = array();
	if(isset($_POST['url'])){
		$name_file = parse_url($_POST['url']);
		$_SESSION['name_file'] = str_replace(".","_",$name_file['host']);
		require_once('inc/simple_html_dom.php');
		$html = file_get_html($_POST['url']);
		$str = array();
		$i=1;
		
		foreach($html->find('link') as $element){
			if($element->type == "text/css" || strpos($element->href,".css")){
				$str['css']['href'][$i] = $element->href;
				if($demo == true && $i>= 5){
						break;
				}
				$i++;				
			}
		}
		foreach($str['css']['href'] as $key=>$val){
			$_SESSION['str'][$key]['href'] =  $val;
		}
	}
?>	
<form class="form-horizontal" role="form" method="post" action="">
  <div class="form-group">
  	<div class="col-sm-12">
        <div class="input-group">
		      <span class="input-group-addon" id="basic-addon1">URL</span>
              <input type="url" class="form-control input-lg" name="url" id="url" placeholder="http://site.com" value="<?php if(isset($_POST['url'])){echo $_POST['url'];}else{echo "https://en.blog.wordpress.com/";}?>" required="required">
          </div>
     </div>     
  </div>
  <div class="form-group">
    <div class="col-sm-12">
		<textarea class="form-control" rows="8"><?php 
			if(isset($_SESSION['str']) && count($_SESSION['str']) > 0){
				foreach($_SESSION['str'] as $key=>$val){
					echo $key."|".implode("|",$val)."\n";	
				}					
			}
		?></textarea>
    </div>
  </div>
  <?php $get= 'css'; require_once('inc/_form_footer.php');?>
</form>