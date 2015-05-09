<div class=" row" style="padding:1% 0;">
	<div class="col-md-11">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createadd'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Add Details
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("Adds List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="name">Name</th>
                        <th data-field="positionname">Position</th>
                        <th data-field="fromtimestamp">From Timestamp</th>
                        <th data-field="totimestamp">toTimestamp</th>
                        <th data-field="details">Details</th>
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
//                if(!resultrow.address)
//                {
//                    resultrow.address="";
//                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.positionname + "</td><td>" + resultrow.fromtimestamp + "</td><td>" + resultrow.totimestamp + "</td><td>" + resultrow.details + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editadd?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteadd?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>