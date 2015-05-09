
<div class=" row" style="padding:1% 0;">
	<div class="col-md-9">
		<div class=" pull-right col-md-1 createbtn" ><a href="<?php echo site_url('site/viewlisting'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a> </div>
	</div>
	<div class="col-md-3">
	
		<a class="btn btn-default"  href="<?php echo base_url('uploads/listing.csv'); ?>"><i class="icon-upload"></i>Download CSV Format</a> &nbsp; 
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Upload Listing CSV
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/uploadlistingcsvsubmit');?>" enctype= "multipart/form-data">
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">listing CSV File</label>
				  <div class="col-sm-4">
					<input type="file" id="normal-field" class="form-control" name="file">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Category</label>
				  <div class="col-sm-4">
					<?php
						echo form_multiselect('category[]', $category,set_value('category'),'id="select2" class="form-control"');
					?>
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewlisting'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>