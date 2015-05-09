<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewenquiry'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 enquiry Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createenquirysubmit');?>" enctype= "multipart/form-data">
			  
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label">user</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('user',$user,set_value('user'),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
-->
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Type Of Enquiry</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('typeofenquiry',$typeofenquiry,set_value('typeofenquiry'),'onchange="changetypeofenquiry()" class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..." id="typeofenquiry"');
					?>
				  </div>
				</div>
				<div class=" form-group" style="display:none;" id="listingid">
				  <label class="col-sm-2 control-label">Listing</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('listing',$listing,set_value('listing'),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				<div class=" form-group" style="display:none;" id="categoryid">
				  <label class="col-sm-2 control-label">category</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('category',$category,set_value('category'),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Phone Number</label>
				  <div class="col-sm-4">
					<input type="number" id="normal-field" class="form-control" name="phone" value="<?php echo set_value('phone');?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Comment</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="comment" value="<?php echo set_value('comment');?>">
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewenquiry'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>

<script type="text/javascript">
     var nodata=9;
    function changetypeofenquiry() {
        console.log($('#typeofenquiry').val());
        if($('#typeofenquiry').val()==1)
        {
            $("#listingid").show();
            $("#categoryid").hide();
        }
        else if( $('#typeofenquiry').val()==2)
        {
            $("#categoryid").show();
            $("#listingid").hide();
        }
        else
        {
            $("#categoryid").hide();
            $("#listingid").hide();
        }
       
    }
</script>