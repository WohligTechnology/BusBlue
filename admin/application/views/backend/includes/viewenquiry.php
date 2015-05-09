<div class=" row" style="padding:1% 0;">
	<div class="col-md-11">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createenquiry'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Enquiry Details
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("Enquiry List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="name">Name</th>
<!--
                        <th data-field="listingname">Listing</th>
                        <th data-field="categoryname">Category</th>
-->
                        <th data-field="email">Email</th>
                        <th data-field="phone">Phone</th>
                        <th data-field="timestamp">Timestamp</th>
                        <th data-field="enquiryfrom">From</th>
                        <th data-field="listingcategory">Listings</th>
                        <th data-field="action"> Actions </th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
                </table>
                   <?php $this->chintantable->createpagination();?>
            </div>
		</section>
		<script>
            function drawtable(resultrow) {
                if(!resultrow.address)
                {
                    resultrow.address="";
                }
                if(resultrow.enquiryfrom==1)
                {
                    resultrow.enquiryfrom="Website";
                }
                else if(resultrow.enquiryfrom==2)
                {
                    resultrow.enquiryfrom="Phone";
                }
                else
                {
                    resultrow.enquiryfrom="Website";
                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.email + "</td><td>" + resultrow.phone + "</td><td>" + resultrow.timestamp + "</td><td>" + resultrow.enquiryfrom + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/viewenquirylistingcategory?id=');?>"+resultrow.id +"'>Show All</a></td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editenquiry?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteenquiry?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>