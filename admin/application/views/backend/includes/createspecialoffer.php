<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewspecialoffer'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 specialoffer Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createspecialoffersubmit');?>" enctype= "multipart/form-data">
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Offer</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Category</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('category',$category,set_value('category'),'id="select1" onchange="getlisting()"class="chzn-select form-control" 	data-placeholder="Choose a Category..."');
					?>
				  </div>
				</div>
				
					<div class="form-group">
						<label class="col-sm-2 control-label">Listing</label>
						<div class="col-sm-4 listingbycategory">
                       <select name="listing[]" multiple>
						   <?php 
//								echo form_dropdown('listing',$listing,set_value('listing'),'id="select10" class="form-control populate placeholder select2-offscreen"');
								 
							?>
							</select>
						</div>
					</div>
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label">listing</label>
				  <div class="col-sm-4">
					<?php
						echo form_multiselect('listing[]', $listing,set_value('listing'),'id="select4" class="form-control"');
					?>
				  </div>
				</div>
-->
				
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
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewspecialoffer'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>
<script type="text/javascript">
     var nodata=9;
    function getlisting() {
//        alert($('#select1').val());

        $.getJSON(
            "<?php echo base_url(); ?>index.php/site/getlistingbycategory/" + $('#select1').val(), {
                id: "123"
            },
            function (data) {
//                  alert(data);
                console.log(data);
                nodata=data;
                changelistingdropdown(data);

            }

        );

    }
                  var mallbycity=$(".listingbycategory select").select2({allowClear: true,width:343});
                  
    function changelistingdropdown(data) {
        $(".listingbycategory select").html("");
        for(var i=0;i<data.length;i++)
        {
            $(".listingbycategory select").append("<option value='"+data[i].listingid+"'>"+data[i].name+"</option>");
            
        }

    };
                  
                $(document).ready(function() {
                   
    $('#select10').select2(
    {
		
		allowClear: true,
		//minimumInputLength: 3,
		
	 }
    );
                });
                </script>