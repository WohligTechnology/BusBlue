<div class=" row" style="padding:1% 0;">
	<div class="col-md-11">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createenquirylistingcategory?id=').$this->input->get('id'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                All Enquiries
            </header>
			<table class="table table-striped table-hover fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<!--<th>Id</th>-->
<!--					<th>Listing</th>-->
					<th>Type Of Enquiry</th>
					<th>Listing</th>
					<th>Category</th>
					<th>Comment</th>
					<th>Timestamp</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<!--<td><?php echo $row->id;?></td>-->
<!--						<td><?php echo $row->listing;?></td>-->
						<td><?php echo $row->typeofenquiry;?></td>
						<td><?php echo $row->listingname;?></td>
						<td><?php echo $row->categoryname;?></td>
						<td><?php echo $row->comment;?></td>
						<td><?php echo $row->timestamp;?></td>
						
						<td>
							<a href="<?php echo site_url('site/deleteenquirylistingcategory?id=').$row->enquiryid.'&enquirylistingcategoryid='.$row->id; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?');">
								<i class="icon-trash "></i>
							</a> 
						
						</td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
	</div>
</div>