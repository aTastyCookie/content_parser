<?php
$_SESSION['str'] = array();
if(isset($_POST['url'])){
		
				require_once('inc/simple_html_dom.php');
				$html = file_get_html($_POST['url']);
		$name_file = parse_url($_POST['url']);
		$_SESSION['name_file'] = str_replace(".","_",$name_file['host']);
		
		$str = array();
		$i=1;
		if(!isset($_POST['wp_date'])) $_POST['wp_date'] = 'post-date';
		if(!isset($_POST['wp_title'])) $_POST['wp_title'] = 'post-focus';
		if(!isset($_POST['wp_short'])) $_POST['wp_short'] = 'entry';
		if(!isset($_POST['wp_full'])) $_POST['wp_full'] = 'entrytext';
		if(!isset($_POST['wp_class'])) $_POST['wp_class'] = 'post';	
		if(!isset($str['wp_post'])) $str['wp_post'] = array();	
		foreach($html->find('.'.$_POST['wp_class']) as $element){
			if($element->find(".".$_POST['wp_date'],0)){
				$str['wp_post'][$i]['date'] = trim($element->find(".".$_POST['wp_date'],0)->plaintext);
			}else{
				$str['wp_post'][$i]['date'] = "no date";
			}
			if($element->find(".".$_POST['wp_title'],0)){
				$str['wp_post'][$i]['title'] = trim($element->find(".".$_POST['wp_title'],0)->plaintext);
			}else{
				$str['wp_post'][$i]['title'] = "no title";
			}
			if($element->find(".".$_POST['wp_title']." a",0)){
				$str['wp_post'][$i]['title_link'] = trim($element->find(".".$_POST['wp_title']." a",0)->href);
			}else{
				$error[] = 'title';
			}
			if(isset($str['wp_post'][$i]['title_link'])){
				$full_text = file_get_html($str['wp_post'][$i]['title_link']);
				if(isset($_POST['wp_html'])){
					if($element->find(".".$_POST['wp_short'],0)){
						$str['wp_post'][$i]['short'] = trim(htmlspecialchars($element->find(".".$_POST['wp_short'],0)->plaintext));
					}else{
						$str['wp_post'][$i]['short'] = "";
					}
					if($full_text->find(".".$_POST['wp_full'],0)){
					$str['wp_post'][$i]['full'] = trim(htmlspecialchars($full_text->find(".".$_POST['wp_full'],0)->outertext));
					}else{
						$str['wp_post'][$i]['full'] = "";
					}
				}else{
					if($element->find(".".$_POST['wp_short'],0)){
						$str['wp_post'][$i]['short'] = str_replace("  "," ",strip_tags(trim($element->find(".".$_POST['wp_short'],0)->plaintext)));
					}else{
						$str['wp_post'][$i]['short'] = "";
					}
					if($full_text->find(".".$_POST['wp_full'],0)){
						$str['wp_post'][$i]['full'] = str_replace("  "," ",strip_tags(trim($full_text->find(".".$_POST['wp_full'],0)->outertext)));				
					}else{
						$str['wp_post'][$i]['full'] = "";
					}
				}
			}
			if($demo == true && $i>= 5){
					break;
			}
			$i++;
		}

		if(isset($str['wp_post']) && count($str['wp_post']) > 0){
			foreach($str['wp_post'] as $key=>$val){
				$_SESSION['str'][$key]['date'] =  $str['wp_post'][$key]['date'];
				$_SESSION['str'][$key]['title'] =  $str['wp_post'][$key]['title'];
				$_SESSION['str'][$key]['title_link'] =  $str['wp_post'][$key]['title_link'];
				$_SESSION['str'][$key]['short'] =  $str['wp_post'][$key]['short'];
				$_SESSION['str'][$key]['full'] =  $str['wp_post'][$key]['full'];
			}
			foreach($str['wp_post'] as $key=>$val){
				if(count($val) > 0){
					if(isset($_POST['wp_date']) && isset($str['wp_post']['wp_date'][$key]) && strlen($str['wp_post']['wp_date'][$key]) > 0){
						$_SESSION['str'][$key]['wp_date'] = $str['wp_post']['wp_date'][$key];
					}
					if(isset($str['wp_post']['title_link'][$key]) && strlen($str['wp_post']['title_link'][$key]) > 0){
						$_SESSION['str'][$key]['title_link'] = $str['wp_post']['title_link'][$key];
					}
					if(isset($_POST['wp_title']) && isset($str['wp_post']['wp_title'][$key]) && strlen($str['wp_post']['wp_title'][$key]) > 0){
						$_SESSION['str'][$key]['wp_title'] = $str['wp_post']['wp_title'][$key];
					}
					if(isset($_POST['wp_short']) && isset($str['wp_post']['wp_short'][$key]) && strlen($str['wp_post']['wp_short'][$key]) > 0){
						$_SESSION['str'][$key]['wp_short'] = $str['wp_post']['wp_short'][$key];
					}
					if(isset($_POST['wp_full']) && isset($str['wp_post']['wp_full'][$key]) && strlen($str['wp_post']['wp_full'][$key]) > 0){
						$_SESSION['str'][$key]['wp_full'] = $str['wp_post']['wp_full'][$key];
					}	
				}
				
			}
		}
}
?>
<form class="form-horizontal" role="form" method="post" action="">
  <div class="form-group">
  	<div class="col-sm-12">
        <div class="input-group">
		      <span class="input-group-addon" id="basic-addon1">URL</span>
              <input type="url" class="form-control input-lg" name="url" id="url" placeholder="http://site.com" value="<?php if(isset($_POST['url'])){echo $_POST['url'];}else{echo "https://en.blog.wordpress.com/";}?>" required>
          </div>
     </div>     
  </div>
  <div class="row">
  	<div class="col-md-4">
     <div class="form-group">
        <label for="wp_class" class="col-sm-6 control-label">Class block post</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="wp_class" value="<?php if(isset($_POST['wp_class'])){echo $_POST['wp_class'];}else{ echo "post";}?>">
        </div>
      </div>
      <div class="form-group">
        <label for="wp_date" class="col-sm-6 control-label">Class post date</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="wp_date" value="<?php if(isset($_POST['wp_date'])){echo $_POST['wp_date'];}else{ echo "post-date";}?>">
        </div>
      </div>
    </div>
   	<div class="col-md-4">
        <div class="form-group">
        <label for="wp_title" class="col-sm-6 control-label">Class post title</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="wp_title" value="<?php if(isset($_POST['wp_title'])){echo $_POST['wp_title'];}else{ echo "post-focus";}?>">
        </div>
      </div>
      <div class="form-group">
        <label for="wp_short" class="col-sm-6 control-label">Class short text</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="wp_short" value="<?php if(isset($_POST['wp_short'])){echo $_POST['wp_short'];}else{ echo "entry";}?>">
        </div>
      </div>
    </div>
  	<div class="col-md-4">
        <div class="form-group">
        <label for="wp_full" class="col-sm-6 control-label">Class full text</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="wp_full" value="<?php if(isset($_POST['wp_full'])){echo $_POST['wp_full'];}else{ echo "entrytext";}?>">
        </div>
      </div>
      <div class="form-group">
        <label for="wp_html" class="col-sm-6 control-label">HTML</label>
            <div class="col-sm-6">
              <input type="checkbox" class="switch" name="wp_html" checked="checked" <?php if(isset($_POST['wp_html'])){echo 'checked="checked"';}?>>
            </div>
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
  <?php $get= 'wp'; require_once('inc/_form_footer.php');?>
</form>