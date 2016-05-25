<?php
$_SESSION['str'] = array();
if(isset($_POST['url'])){
		
				require_once('inc/simple_html_dom.php');
				$html = file_get_html($_POST['url']);
		$name_file = parse_url($_POST['url']);
		$_SESSION['name_file'] = str_replace(".","_",$name_file['host']);
		
		$str = array();	
		$i=1;
		if($_POST['phpbb_type'] == 'topics'){
			foreach($html->find('.'.$_POST['phpbb_topic_row']) as $element){
				if($element->find("a .".$_POST['topictitle'],0)){
					$str['phpbb'][$i]['title'] = trim($element->find("a .".$_POST['topictitle'],0)->plaintext);
				}
				if($element->find("a .".$_POST['topictitle'],0)){
					$str['phpbb'][$i]['url'] = trim($element->find("a .".$_POST['topictitle'],0)->href);
				}
				if($element->find(".".$_POST['phpbb_count_topics'],0)){
					$str['phpbb'][$i]['count_topics'] = trim($element->find(".".$_POST['phpbb_count_topics'],0)->plaintext);
				}
				if($element->find(".".$_POST['phpbb_count_posts'],0)){
					$str['phpbb'][$i]['count_posts'] = trim($element->find(".".$_POST['phpbb_count_posts'],0)->plaintext);
				}
				if($demo == true && $i>= 5){
						break;
				}
				$i++;
			}
			if(isset($str['phpbb']) && count($str['phpbb']) > 0){
				foreach($str['phpbb'] as $key=>$val){
					$_SESSION['str'][$key]['title'] =  $str['phpbb'][$key]['title'];
					$_SESSION['str'][$key]['url'] =  $str['phpbb'][$key]['url'];
					$_SESSION['str'][$key]['count_topics'] =  $str['phpbb'][$key]['count_topics'];
					$_SESSION['str'][$key]['count_posts'] =  $str['phpbb'][$key]['count_posts'];
				}
			}
		}elseif($_POST['phpbb_type'] == 'posts'){
			foreach($html->find('.'.$_POST['phpbb_post']) as $element){
				if($element->find("h3 a",0)){
					$str['phpbb'][$i]['title'] = trim($element->find("h3 a",0)->plaintext);
				}
				if($element->find("a.".$_POST['phpbb_username'],0)){
					$str['phpbb'][$i]['username'] = trim($element->find("a.".$_POST['phpbb_username'],0)->plaintext);
				}elseif($element->find("a.".$_POST['phpbb_username']."-coloured",0)){
					$str['phpbb'][$i]['username'] = trim($element->find("a.".$_POST['phpbb_username']."-coloured",0)->plaintext);
				}
				if($element->find(".".$_POST['phpbb_content'],0)){
					$str['phpbb'][$i]['content'] = str_replace(array("\n","\r"),"<br>",strip_tags(trim($element->find(".".$_POST['phpbb_content'],0)->plaintext)));
				}
				if($demo == true && $i>= 5){
					break;
				}
				$i++;
			}
			if(isset($str['phpbb']) && count($str['phpbb']) > 0){
				foreach($str['phpbb'] as $key=>$val){
					$_SESSION['str'][$key]['title'] =  $str['phpbb'][$key]['title'];
					$_SESSION['str'][$key]['username'] =  $str['phpbb'][$key]['username'];
					$_SESSION['str'][$key]['content'] =  $str['phpbb'][$key]['content'];
					
				}
			}
		}
}?>
<form class="form-horizontal" role="form" method="post" action="">
  <div class="row">
	<div class="col-md-4">
         <div class="form-group">
            <label for="phpbb_type" class="col-md-2 control-label">Type</label>
            <div class="col-md-10">
                <select class="form-control" name="phpbb_type" id="phpbb_type">
                  <option value="0" <?php if(isset($_POST['phpbb_type']) && $_POST['phpbb_type'] == 0){?> selected <?php } ?>>select</option>
                  <option value="topics" <?php if(isset($_POST['phpbb_type']) && $_POST['phpbb_type'] == 'topics'){?> selected <?php } ?>>Topics</option>
                  <option value="posts" <?php if(isset($_POST['phpbb_type']) && $_POST['phpbb_type'] == 'posts'){?> selected <?php } ?>>Posts</option>
                </select>
             </div>     
          </div>
	  </div>
      <div class="col-md-8">
      		<div class="alert alert-info">
            	e.g.
                <li>Topic URL - https://www.phpbb.com/community/
                <li>Post URL - http://area51.phpbb.com/phpBB/viewtopic.php?f=99&t=30432
            </div>
      </div>
  </div>
  <div class="form-group">
  	<div class="col-sm-12">
        <div class="input-group">
		      <span class="input-group-addon" id="basic-addon1">URL</span>
              <input type="url" class="form-control input-lg" name="url" id="url" placeholder="http://site.com" value="<?php if(isset($_POST['url']) ){echo $_POST['url'];}else{echo "https://www.phpbb.com/community/";}?>" required>
          </div>
     </div>     
  </div>
  <div id="phpbb_topics" <?php if(isset($_POST['phpbb_type']) && $_POST['phpbb_type'] == 'topics'){?>style="display:block"<?php }else{?>style="display:none"<?php }?>>	
  	<div class="row">
    	<div class="col-md-6">
	  <div class="form-group">
        <label for="phpbb_topic_row" class="col-sm-6 control-label">Class topic row</label>
        <div class="col-sm-6">
          <input type="text" class="form-control phpbb_topics" name="phpbb_topic_row" value="<?php if(isset($_POST['phpbb_topic_row'])){echo $_POST['phpbb_topic_row'];}else{ echo "row";}?>">
        </div>
      </div>
      <div class="form-group">
        <label for="phpbb_topic_title" class="col-sm-6 control-label">Class topic title</label>
        <div class="col-sm-6">
          <input type="text" class="form-control phpbb_topics" name="phpbb_topic_title" value="<?php if(isset($_POST['phpbb_topic_title'])){echo $_POST['phpbb_topic_title'];}else{ echo "topictitle";}?>">
        </div>
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">
        <label for="phpbb_count_topics" class="col-sm-6 control-label">Class count topics</label>
        <div class="col-sm-6">
          <input type="text" class="form-control phpbb_topics" name="phpbb_count_topics" value="<?php if(isset($_POST['phpbb_count_topics'])){echo $_POST['phpbb_count_topics'];}else{ echo "topics";}?>">
        </div>
      </div>
      <div class="form-group">
        <label for="phpbb_count_posts" class="col-sm-6 control-label">Class count posts</label>
        <div class="col-sm-6">
          <input type="text" class="form-control phpbb_topics" name="phpbb_count_posts" value="<?php if(isset($_POST['phpbb_count_posts'])){echo $_POST['phpbb_count_posts'];}else{ echo "posts";}?>">
        </div>
      </div>
      </div>
    </div>  
  </div>
  <div id="phpbb_posts" <?php if(isset($_POST['phpbb_type']) && $_POST['phpbb_type'] == 'posts'){?>style="display:block"<?php }else{?>style="display:none"<?php }?>>
  	<div class="row">
      <div class="col-md-4">
  		<div class="form-group">
        <label for="phpbb_post" class="col-sm-6 control-label">Class post</label>
        <div class="col-sm-6">
          <input type="text" class="form-control phpbb_posts" name="phpbb_post" value="<?php if(isset($_POST['phpbb_post'])){echo $_POST['phpbb_post'];}else{ echo "post";}?>">
        </div>
      </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
        <label for="phpbb_username" class="col-sm-6 control-label">Class username</label>
        <div class="col-sm-6">
          <input type="text" class="form-control phpbb_posts" name="phpbb_username" value="<?php if(isset($_POST['phpbb_username'])){echo $_POST['phpbb_username'];}else{ echo "username";}?>">
        </div>
      </div>
      </div>
      <div class="col-md-4">
      <div class="form-group">
        <label for="phpbb_content" class="col-sm-6 control-label">Class content</label>
        <div class="col-sm-6">
          <input type="text" class="form-control phpbb_posts" name="phpbb_content" value="<?php if(isset($_POST['phpbb_content'])){echo $_POST['phpbb_content'];}else{ echo "content";}?>">
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