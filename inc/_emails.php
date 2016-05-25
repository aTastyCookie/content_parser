<?php
//$_SESSION['str'] = array();
if(isset($_POST['url'])){
		$name_file = parse_url($_POST['url']);
		$_SESSION['name_file'] = str_replace(".","_",$name_file['host']);
		require_once('inc/simple_html_dom.php');
		$html = file_get_html($_POST['url']);
		$str = array();
		$i=1;
		$body = $html->find('body',0)->plaintext;
		$matches = array();
		$pattern = '/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
		preg_match_all($pattern,$body,$matches);
		foreach($matches[0] as $element){
			$str['email']['text'][$i] = $element;
			if($demo == true && $i>= 5){
					break;
			}
			$i++;
		}
		foreach($str['email']['text'] as $key=>$val){
			$_SESSION['str'][$key]['email'] =  $val;
		}
}
?>
<form class="form-horizontal" role="form" method="post" action="">
  <div class="form-group">
  	<div class="col-sm-12">
        <div class="input-group">
		      <span class="input-group-addon" id="basic-addon1">URL</span>
              <input type="url" class="form-control input-lg" name="url" id="url" placeholder="http://site.com" value="<?php if(isset($_POST['url'])){echo $_POST['url'];}else{echo "http://www.sistersofspam.co.uk/Scam_Email_Addresses_1.php";}?>" required="required">
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
  <?php $get= 'emails'; require_once('inc/_form_footer.php');?>
</form>