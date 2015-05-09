<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Category Details
			</header>
			<div class="panel-body">
				<form class="form-horizontal row-fluid" method="post" action="<?php echo site_url('site/createcategorysubmit');?>" enctype= "multipart/form-data">
					<div class="form-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
						</div>
					</div>		
					<div class="form-group">
						<label class="col-sm-2 control-label" >Parent</label>
						<div class="col-sm-4">
						   <?php 
								echo form_dropdown('parent',$category,set_value('parent'),'id="select1" class="form-control populate placeholder select2-offscreen"');
								 
							?>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 control-label" >Type Of Image</label>
						<div class="col-sm-4">
						   <?php 
								echo form_dropdown('typeofimage',$typeofimage,set_value('typeofimage'),'id="typeofimage" onchange="changeimageortag()" class="form-control populate placeholder "');
								 
							?>
						</div>
					</div>
<!--
					<div class=" form-group">
					  <label class="col-sm-2 control-label">Status</label>
					  <div class="col-sm-4">
						<?php
							
							echo form_dropdown('status',$status,set_value('status'),'id="select2" class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
						?>
					  </div>
					</div>
-->
					
					<div class="form-group" style="display:none" id="ontagselect">
						User Font Awesome Icons >> 
						Example : fa fa-money fa-3x
						<label class="col-sm-2 control-label">Logo(in tag)</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="logo" value="<?php echo set_value('logo');?>">
						</div>
					</div>
					
                    <div class=" form-group" style="display:none" id="onimageselect">
                      <label class="col-sm-2 control-label" for="normal-field">Image</label>
                      <div class="col-sm-4">
                        <input type="file" id="normal-field" class="form-control" name="image" value="<?php echo set_value('image');?>">
                      </div>
                    </div>
                    <div class=" form-group">
                        Upload category banner Image of size 1140 X 160px.
                      <label class="col-sm-2 control-label" for="normal-field">Banner</label>
                      <div class="col-sm-4">
                        <input type="file" id="normal-field" class="form-control" name="banner" value="<?php echo set_value('banner');?>">
                      </div>
                    </div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Banner Start Date</label>
				  <div class="col-sm-4">
					<input type="date" id="d" class="form-control" name="startdateofbanner" value="<?php echo set_value('startdateofbanner');?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">End Date Banner</label>
				  <div class="col-sm-4">
					<input type="date" id="d2" class="form-control" name="enddateofbanner" value="<?php echo set_value('enddateofbanner');?>">
				  </div>
				</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-4">	
							<button type="submit" class="btn btn-info">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</section>
    </div>
</div>
<script type="text/javascript">
     var nodata=9;
    function changeimageortag() {
        console.log($('#typeofimage').val());
        if($('#typeofimage').val()==0)
        {
            $("#ontagselect").show();
            $("#onimageselect").hide();
        }
        else if( $('#typeofimage').val()==1)
        {
            $("#onimageselect").show();
            $("#ontagselect").hide();
        }
       
    }
</script>