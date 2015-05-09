	    <section class="panel">
		    <header class="panel-heading">
				 enquiry Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editenquirysubmit');?>" enctype= "multipart/form-data">
				<input type="text" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before->name);?>">
				  </div>
				</div>
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label">user</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('user',$user,set_value('user',$before->user),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
-->
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Type Of Enquiry</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('typeofenquiry',$typeofenquiry,set_value('typeofenquiry',$before->type),'onchange="changetypeofenquiry()" class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..." id="typeofenquiry"');
					?>
				  </div>
				</div>
-->
				<?php
//                    if($before->type=="1")
//                    {
                  ?>
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Listing</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('listing',$listing,set_value('listing',$before->listing),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
-->
				<?php
//} else {
                  ?>
<!--
				<div class=" form-group"  id="categoryid">
				  <label class="col-sm-2 control-label">category</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('category',$category,set_value('category',$before->category),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
-->
				<?php 
//} 
                  ?>
            
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before->email);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Phone Number</label>
				  <div class="col-sm-4">
					<input type="number" id="normal-field" class="form-control" name="phone" value="<?php echo set_value('phone',$before->phone);?>">
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
