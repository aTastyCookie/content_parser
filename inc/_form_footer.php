<hr>
<div class="form-group">
    <div class="col-md-3">
    <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-play fa-fw"></i> Grab</button>
     <div class="btn-group btn-group-lg" role="group">
        <button type="button" class="btn btn-warning dropdown-toggle" <?php if(isset($str) == 0){?>disabled="disabled"<?php }?> data-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-download fa-fw"></i> Export
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" id="export">
            <li><a href="?export=txt"><i class="fa fa-file-text-o fa-fw"></i> txt</a></li>
            <li><a href="?export=json"><i class="fa fa-file-excel-o fa-fw"></i> json</a></li>
            <li><a href="?export=xml"><i class="fa fa-file-code-o fa-fw"></i> xml</a></li>
        </ul>
      </div>
    </div>
    <?php if($demo == true){?>
    <div class="col-md-9">
    <div class="alert alert-info" role="alert">Limitation  demo -  5 query</div>
	</div>
	<?php }?>                                                            
</div>