<div class=" row" style="padding:1% 0;">
	<div class="col-md-11">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createbilling'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Billing Details
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("Billing List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="listingname">Listing</th>
                        <th data-field="firstname">User</th>
                        <th data-field="paymenttype">Paymenttype</th>
                        <th data-field="amount">Amount</th>
                        <th data-field="period">Period</th>
                        <th data-field="credits">Credits</th>
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
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.listingname + "</td><td>" + resultrow.firstname + "</td><td>" + resultrow.paymenttype + "</td><td>" + resultrow.amount + "</td><td>" + resultrow.period + "</td><td>" + resultrow.credits + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editbilling?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deletebilling?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>