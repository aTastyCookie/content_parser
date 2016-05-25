<?php
$_SESSION['str'] = array();
if(isset($_POST['url'])){
		
				require_once('inc/simple_html_dom.php');
				$html = file_get_html($_POST['url']);
		$name_file = parse_url($_POST['url']);
		$_SESSION['name_file'] = str_replace(".","_",$name_file['host']);
		
		$str = array();	
		$i=1;
		if($_POST['smf_type'] == 'topics'){
			foreach($html->find('.'.$_POST['smf_topic_row']) as $element){
				if($element->find(".info a",0)){
					$str['smf'][$i]['title'] = trim($element->find(".info a",0)->plaintext);
				}
				if($element->find(".info p",0)){
					$str['smf'][$i]['sub_title'] = trim($element->find(".info p",0)->plaintext);
				}
				if($element->find("a .".$_POST['topictitle'],0)){
					$str['smf'][$i]['url'] = trim($element->find("a .".$_POST['topictitle'],0)->href);
				}
				if($element->find(".".$_POST['smf_count_topics'],0)){
					$str['smf'][$i]['count_topics'] = str_replace("\r\n","|",trim($element->find(".".$_POST['smf_count_topics'],0)->plaintext));
				}
				if($demo == true && $i>= 5){
						break;
				}
				$i++;
			}
			if(isset($str['smf']) && count($str['smf']) > 0){
				foreach($str['smf'] as $key=>$val){
					$_SESSION['str'][$key]['title'] =  $str['smf'][$key]['title'];
					$_SESSION['str'][$key]['sub_title'] =  $str['smf'][$key]['sub_title'];
					$_SESSION['str'][$key]['url'] =  $str['smf'][$key]['url'];
					$_SESSION['str'][$key]['count_topics'] =  $str['smf'][$key]['count_topics'];
				}
			}
		}elseif($_POST['smf_type'] == 'posts'){
			foreach($html->find('.'.$_POST['smf_post']) as $element){
				if($element->find(".keyinfo h5",0)){
					$str['smf'][$i]['title'] = trim($element->find(".keyinfo h5",0)->plaintext);
				}
				if($element->find(".".$_POST['smf_username']." h4 a",0)){
					$str['smf'][$i]['username'] = trim($element->find(".".$_POST['smf_username']." h4 a",0)->plaintext);
				}
				if($element->find(".".$_POST['smf_content'],0)){
					$str['smf'][$i]['content'] = str_replace(array("\n","\r"),"<br>",strip_tags(trim($element->find(".".$_POST['smf_content'],0)->plaintext)));
				}
				if($demo == true && $i>= 5){
					break;
				}
				$i++;
			}
			if(isset($str['smf']) && count($str['smf']) > 0){
				foreach($str['smf'] as $key=>$val){
					$_SESSION['str'][$key]['title'] =  $str['smf'][$key]['title'];
					$_SESSION['str'][$key]['username'] =  $str['smf'][$key]['username'];
					$_SESSION['str'][$key]['content'] =  $str['smf'][$key]['content'];
					
				}
			}
		}
}?>
<form class="form-horizontal" role="form" method="post" action="">
  <div class="row">
	<div class="col-md-4">
         <div class="form-group">
            <label for="smf_type" class="col-md-2 control-label">Type</label>
            <div class="col-md-10">
                <select class="form-control" name="smf_type" id="smf_type">
                  <option value="0" <?php if(isset($_POST['smf_type']) && $_POST['smf_type'] == 0){?> selected <?php } ?>>select</option>
                  <option value="topics" <?php if(isset($_POST['smf_type']) && $_POST['smf_type'] == 'topics'){?> selected <?php } ?>>Topics</option>
                  <option value="posts" <?php if(isset($_POST['smf_type']) && $_POST['smf_type'] == 'posts'){?> selected <?php } ?>>Posts</option>
                </select>
             </div>     
          </div>
	  </div>
      <div class="col-md-8">
      		<div class="alert alert-info">
            	e.g.
                <li>Topic URL - http://www.simplemachines.org/community/index.php
                <li>Post URL - http://www.simplemachines.org/community/index.php?topic=26831.0
            </div>
      </div>
  </div>
  <div class="form-group">
  	<div class="col-sm-12">
        <div class="input-group">
		      <span class="input-group-addon" id="basic-addon1">URL</span>
              <input type="url" class="form-control input-lg" name="url" id="url" placeholder="http://site.com" value="<?php if(isset($_POST['url']) ){echo $_POST['url'];}else{echo "http://www.simplemachines.org/community/index.php";}?>" required>
          </div>
     </div>     
  </div>
  <div id="smf_topics" <?php if(isset($_POST['smf_type']) && $_POST['smf_type'] == 'topics'){?>style="display:block"<?php }else{?>style="display:none"<?php }?>>	
  	<div class="row">
    	<div class="col-md-4">
          <div class="form-group">
            <label for="smf_topic_row" class="col-sm-6 control-label">Class topic row</label>
            <div class="col-sm-6">
              <input type="text" class="form-control smf_topics" name="smf_topic_row" value="<?php if(isset($_POST['smf_topic_row'])){echo $_POST['smf_topic_row'];}else{ echo "windowbg2";}?>">
            </div>
          </div>
         </div>
         <div class="col-md-4"> 
          <div class="form-group">
            <label for="smf_topic_title" class="col-sm-6 control-label">Class topic title</label>
            <div class="col-sm-6">
              <input type="text" class="form-control smf_topics" name="smf_topic_title" value="<?php if(isset($_POST['smf_topic_title'])){echo $_POST['smf_topic_title'];}else{ echo "subject";}?>">
            </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
            <label for="smf_count_topics" class="col-sm-6 control-label">Class count topics</label>
            <div class="col-sm-6">
              <input type="text" class="form-control smf_topics" name="smf_count_topics" value="<?php if(isset($_POST['smf_count_topics'])){echo $_POST['smf_count_topics'];}else{ echo "stats";}?>">
            </div>
          </div>
      </div>
    </div>  
  </div>
  <div id="smf_posts" <?php if(isset($_POST['smf_type']) && $_POST['smf_type'] == 'posts'){?>style="display:block"<?php }else{?>style="display:none"<?php }?>>
  	<div class="row">
      <div class="col-md-4">
  		<div class="form-group">
        <label for="smf_post" class="col-sm-6 control-label">Class post</label>
        <div class="col-sm-6">
          <input type="text" class="form-control smf_posts" name="smf_post" value="<?php if(isset($_POST['smf_post'])){echo $_POST['smf_post'];}else{ echo "windowbg";}?>">
        </div>
      </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
        <label for="smf_username" class="col-sm-6 control-label">Class username</label>
        <div class="col-sm-6">
          <input type="text" class="form-control smf_posts" name="smf_username" value="<?php if(isset($_POST['smf_username'])){echo $_POST['smf_username'];}else{ echo "poster";}?>">
        </div>
      </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
        <label for="smf_content" class="col-sm-6 control-label">Class content</label>
        <div class="col-sm-6">
          <input type="text" class="form-control smf_posts" name="smf_content" value="<?php if(isset($_POST['smf_content'])){echo $_POST['smf_content'];}else{ echo "post";}?>">
        </div>
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