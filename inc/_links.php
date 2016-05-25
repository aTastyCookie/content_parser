<?php 
$_SESSION['str'] = array();
if(isset($_POST['url'])){
	$name_file = parse_url($_POST['url']);
	$_SESSION['name_file'] = str_replace(".","_",$name_file['host']);
	require_once('inc/simple_html_dom.php');
		$html = file_get_html($_POST['url']);
		$str = array();
		$i=1;
		foreach($html->find('a') as $element){
				$not_a = array("#");
				$link = $element->href;
				if(!in_array($element->href,$not_a) || $link[0]!="#"){
					$str['a']['href'][$i] = $link;
					foreach($element->getAllAttributes() as $key => $cl){
						if(isset($_POST['link_class'])){
							if($key == "class"){
								$str['a']['class'][$i] = $cl;
							}else{
								$str['a']['class'][$i] = "{no class}";
							}
						}
						if(isset($_POST['link_title'])){
							if($key == "title" && strlen($cl) > 1){
								$str['a']['title'][$i] = $cl;
							}else{
								$str['a']['title'][$i] = "{no title}";
							}
						}
						if(isset($_POST['link_id'])){
							if($key == "id"){
								$str['a']['id'][$i] = $cl;
							}else{	
								$str['a']['id'][$i] = "{no ID}";
							}
						}
					}
					if($demo == true && $i>= 5){
						break;
					}
					$i++;
				}
			}
		foreach($str['a']['href'] as $key=>$val){
			if(strlen($val) > 0){
				$_SESSION['str'][$key]['href'] =  $val;
				if(isset($_POST['link_title']) && isset($str['a']['title'][$key]) && strlen($str['a']['title'][$key]) > 0){
					$_SESSION['str'][$key]['title'] = $str['a']['title'][$key];
				}
				if(isset($_POST['link_class']) && isset($str['a']['class'][$key]) && strlen($str['a']['class'][$key]) > 0){
					$_SESSION['str'][$key]['class'] = $str['a']['class'][$key];
				}
				if(isset($_POST['link_id']) && isset($str['a']['id'][$key]) &&  strlen($str['a']['id'][$key]) > 0){
					$_SESSION['str'][$key]['id'] = $str['a']['id'][$key];
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
              <input type="url" class="form-control input-lg" name="url" id="url" placeholder="http://site.com" value="<?php if(isset($_POST['url'])){echo $_POST['url'];}else{echo "https://en.blog.wordpress.com/";}?>" required="required">
          </div>
     </div>     
  </div>
    <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="link_title" class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">
              <input type="checkbox" class="switch" name="link_title" <?php if(isset($_POST['link_title'])){echo 'checked="checked"';}?>>
            </div>
          </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="link_class" class="col-sm-3 control-label">Class</label>
                <div class="col-sm-9">
                  <input type="checkbox" class="switch" name="link_class" <?php if(isset($_POST['link_class'])){echo 'checked="checked"';}?>>
                </div>
            </div>
        </div>
        <div class="col-md-3">
        	<div class="form-group">
            <label for="link_id" class="col-sm-3 control-label">ID</label>
            <div class="col-sm-9">
              <input type="checkbox" class="switch" name="link_id" <?php if(isset($_POST['link_id'])){echo 'checked="checked"';}?>>
            </div>
          </div>
        </div>        
    </div>
  <div class="form-group">
    <div class="col-sm-12">
		<textarea class="form-control" rows="8"><?php 
			if(isset($str)){
				foreach($str['a']['href'] as $key=>$val){
					if(strlen($val) > 0){
						echo $val;
						if(isset($_POST['link_id'])){
							if(isset($str['a']['id'][$key])){
								echo "|".$str['a']['id'][$key];
							}else{
								echo "|{no ID}";
							}
						}
						if(isset($_POST['link_class'])){
							if(isset($str['a']['class'][$key])){
								echo "|".$str['a']['class'][$key];
							}else{
								echo "|{no class}";
							}
						}
						if(isset($_POST['link_title'])){
							if(isset($str['a']['title'][$key])){
								echo "|".$str['a']['title'][$key];
							}else{
								echo "|{no title}";
							}
						}
					echo "\n";
					}
				}		
			}
		?></textarea>
    </div>
  </div>
  <?php $get= 'links'; require_once('inc/_form_footer.php');?></form>  