<?php 
if(isset($_POST['url'])){
	$name_file = parse_url($_POST['url']);
	$_SESSION['name_file'] = str_replace(".","_",$name_file['host']);
	require_once('inc/simple_html_dom.php');
		$html = file_get_html($_POST['url']);
		$str = $path_tmp= array();
		$i=1;
			foreach($html->find('img') as $element){
			   	$str['img']['src'][$i] = $element->src;
				if($str['img']['src'][$i][0] == "/" && $str['img']['src'][$i][1] == "/"){
			   		$str['img']['src'][$i] = str_replace("//",'http://',$str['img']['src'][$i]);
				}
			   
				$src_tmp = parse_url($str['img']['src'][$i]);
				
			   if(!isset($src_tmp['scheme']) && !isset($src_tmp['host'])){
				   
				   if(isset($name_file['path'])){
					   $path_tmp = explode("/",$name_file['path']);
					   unset($path_tmp[count($path_tmp)-1]);
					   $path_tmp = array_filter($path_tmp);
				   }
				   if(count($path_tmp) > 0){
				   		$path = "/".implode("/",$path_tmp)."/";
				   }else {$path = '/';}
				   	$str['img']['src'][$i] = $name_file['scheme']."://".$name_file['host'].$path.$str['img']['src'][$i];
			   }
			   if(isset($_POST['img_alt'])){
				   $str['img']['alt'][$i] = $element->alt;
			   }
				foreach($element->getAllAttributes() as $key => $cl){
					if($key == "class"){
						$str['img']['class'][$i] = explode(" ",$cl);
					}
					if($key == "width"){
						$str['img']['width'][$i] = $cl;
					}
					if($key == "height"){
						$str['img']['height'][$i] = $cl;
					}
				}
				if($demo == true && $i>= 5){
						//break;
				}
				$i++;
			}
			if(isset($str['img']['src']) && count($str['img']['src']) > 0){
				foreach($str['img']['src'] as $key=>$val){
					$_SESSION['str'][$key]['src'] =  $val;
					if(isset($_POST['img_alt'])){
						$_SESSION['str'][$key]['alt'] = $str['img']['alt'][$key];
					}
					if(isset($str['img']['class'][$key]) && count($str['img']['class'][$key])>0){
						foreach($str['img']['class'][$key] as $k=>$v){
							$_SESSION['str'][$key]['class'][$k] = $v;
						}
					}
					if(isset($_POST['img_alt'])){
						if(isset($str['img']['alt'][$key]) && strlen($str['img']['alt'][$key]) > 0){
							$_SESSION['str'][$key]['alt'] = $str['img']['alt'][$key];
						}else{
							$_SESSION['str'][$key]['alt']  = "not found";
						}
					}
					if(isset($_POST['img_height'])){
						if(isset($str['img']['height'][$key])){
							$_SESSION['str'][$key]['height'] = $str['img']['height'][$key];
						}else{
							$_SESSION['str'][$key]['height'] = "not found";
						}
					}
					if(isset($_POST['img_width'])){
						if(isset($str['img']['width'][$key])){
							$_SESSION['str'][$key]['width'] = $str['img']['width'][$key];
						}else{
							$_SESSION['str'][$key]['width'] = "not found";
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
              <input type="url" class="form-control input-lg" name="url" id="url" placeholder="http://site.com" value="<?php if(isset($_POST['url'])){echo $_POST['url'];}else{echo "https://en.blog.wordpress.com/";}?>" required="required">
          </div>
     </div>     
  </div>
  <div class="row">
	<div class="col-md-3">
      <div class="form-group">
        <label for="img_preview" class="col-md-3 control-label">Preview</label>
        <div class="col-md-9">
          <input type="checkbox" class="switch" name="img_preview" <?php if(isset($_POST['img_preview'])){echo 'checked="checked"';}?>>
        </div>
      </div>
       <div class="form-group">
        <label for="img_alt" class="col-md-3 control-label">Alt</label>
        <div class="col-md-9">
          <input type="checkbox" class="switch" name="img_alt" <?php if(isset($_POST['img_alt'])){echo 'checked="checked"';}?>>
        </div>
      </div>
	</div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="img_height" class="col-md-3 control-label">Height</label>
        <div class="col-md-9">
          <input type="checkbox" class="switch" name="img_height" <?php if(isset($_POST['img_height'])){echo 'checked="checked"';}?>>
        </div>
      </div>
       <div class="form-group">
        <label for="img_width" class="col-md-3 control-label">Width</label>
        <div class="col-md-9">
          <input type="checkbox" class="switch" name="img_width" <?php if(isset($_POST['img_width'])){echo 'checked="checked"';}?>>
        </div>
      </div>
	</div>
    
    <div class="col-md-4">
     <div class="form-group">
        <label for="img_alt" class="col-md-3 control-label">Class</label>
        <div class="col-md-9">
            <select class="form-control" name="class[]" multiple="multiple">
                <?php foreach($str['img']['class'] as $v){
                        foreach($v as $vv){
                            $class[] = $vv;
                        }
                }
                $class = array_filter(array_unique($class));
                asort($class);
                echo "<option value='0'";
                if(isset($_POST['class']) && in_array("0",$_POST['class'])) echo ' selected="selected"';
                echo ">All</option>";
                foreach($class as $val){
                    echo "<option value='$val'";
                    if(isset($_POST['class']) && in_array($val,$_POST['class'])) echo ' selected="selected"';
                    echo ">$val</option>";
                }
                ?>
            </select>
        </div>
      </div>
  </div>
  </div>
  <div class="form-group">
    <div class="col-sm-12">
		<textarea class="form-control" rows="8"><?php 
			if(isset($_SESSION['str']) && count($_SESSION['str']) > 0){
				foreach($_SESSION['str'] as $key=>$val){
					if(isset($val['class'])){
						$val['class'] = implode(",",$val['class']);
					}
					echo $key."|".implode("|",$val)."\n";	
				}					
			}
		?></textarea>
    </div>
  </div>
  <?php $get= 'images'; require_once('inc/_form_footer.php');?>
</form>
<?php 
if(count($_POST) > 0 && isset($str['img']['src']) && count($str['img']['src']) > 0){
	echo "<hr>";
	echo '<form action="" method="post">';
    echo '<input type="hidden" name="url" value="'.$_POST['url'].'" />';
	echo "<table class='table table-striped table-hover table-bordered'>";
	echo "<thead>";
	echo "	<tr>";
	echo "		<th>##</th>";
	echo "      <td class='center'><input type='checkbox' class='cheackall'></td>";
	if(isset($_POST['img_preview'])){
		echo "		<th  class='col-md-1'>Preview</th>";
	}
	echo "		<th>SRC</th>";
	if(isset($_POST['img_alt'])){
	echo "		<th  class='col-md-2'>Alt</th>";
	}
	if(isset($str['img']['class']) && count($str['img']['class'])>0){
	echo "		<th  class='col-md-2'>Class</th>";
	}
	if(isset($_POST['img_width'])){
	echo "		<th  class='col-md-1'>Width</th>";					
	}
	if(isset($_POST['img_height'])){
	echo "		<th  class='col-md-1'>Height</th>";						
	}
	echo "	<th   class='col-md-1 text-center'>Download</th></tr>";
	echo "</thead>";
	foreach($str['img']['src'] as $key=>$val){
		echo "<tr>";
		echo "<td class='center'>$key</td>";
		echo "<td class='center'><input type='checkbox' id='tab".$key."' name='table[".$key."]' value='".$key."'></td>";
		if(isset($_POST['img_preview'])){	
		echo "<td><img src='".$val."' class='img-responsive img-thumbnail'></td>";
		}
		echo "<td style='word-wrap:break-word; word-break:break-all'>$val</td>";
		if(isset($_POST['img_alt'])){
			echo "<td>";
			if(isset($str['img']['alt'][$key]) && strlen($str['img']['alt'][$key]) > 0){
				echo $str['img']['alt'][$key];
			}else{
				echo "not found";
			}
			echo "</td>";
		}
		if(isset($str['img']['class']) && count($str['img']['class'])>0){
		echo "<td>";
		if(isset($str['img']['class'][$key]) && count($str['img']['class'][$key])>0){
		$str['img']['class'][$key] = array_filter($str['img']['class'][$key]);
		foreach($str['img']['class'][$key] as $vv){
			echo $vv.'<br>';
		}}else{
			echo "not found";
		}
		echo "</td>";
		}
		if(isset($_POST['img_width'])){
			echo "<td>";
			if(isset($str['img']['width'][$key])){
				echo $str['img']['width'][$key];
			}else{
				echo "not found";
			}
			echo "</td>";
		}
		if(isset($_POST['img_height'])){
			echo "<td>";
			if(isset($str['img']['height'][$key])){
				echo $str['img']['height'][$key];
			}else{
				echo "not found";
			}
			echo "</td>";
		}
		echo "<td><center><a href='?img_download=".$key."' class='btn btn-primary btn-sm'><i class='fa fa-download'></i></a></center></td>";

		echo "</tr>";
	}
	echo '<tfoot>';
	echo '	<tr>';
	echo '		<td colspan="2" class="center"><button type="submit" class="btn btn-sm btn-primary download_count" id="download'.(count($str['img'])+1).'"><i class="fa fa-archive fa-fw"></i> Download Selected</button></td>';
	echo '		<td colspan="9"></td>';
	echo '	</tr>';
	echo '</tfoot>';
	echo "</table>";
	echo "</form>";
}
?>