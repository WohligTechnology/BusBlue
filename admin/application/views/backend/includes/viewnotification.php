<!--
<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	<div class=" pull-right col-md-1 createbtn" ><a class="btn btn-primary" href="<?php echo site_url('site/createbuilder'); ?>"><i class="icon-plus"></i>Create </a></div>
	</div>
	
</div>
-->
<div class="row">
	<div class="col-lg-6">
		<section class="panel">
			<header class="panel-heading">
                Notifications before Month
            </header>
			<table class="table table-striped table-hover border-top " id="sample_1" cellpadding="0" cellspacing="0" >
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>Name</th>
					<th>Banner</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($monthbefore as $row) { ?>
					<tr>
						<!--<td><?php echo $row->id; ?></td>-->
						<td><?php echo $row->name; ?></td>
				        <td><img src="<?php echo base_url('uploads')."/".$row->banner; ?>" width="50px" height="auto"></td>
						<td><?php echo $row->startdateofbanner; ?></td>
						<td><?php echo $row->enddateofbanner; ?></td>
						<td> <a class="btn btn-primary btn-xs" href="<?php echo site_url('site/editnotification?id=').$row->id;?>"><i class="icon-pencil"></i></a>
<!--                                      <a class="btn btn-danger btn-xs" href="<?php echo site_url('site/deletenotification?id=').$row->id; ?>"><i class="icon-trash "></i></a>-->
									 
					  </td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
	</div>
	<div class="col-lg-6">
		<section class="panel">
			<header class="panel-heading">
                Notifications before 5 Days
            </header>
			<table class="table table-striped table-hover border-top " id="sample_2" cellpadding="0" cellspacing="0" >
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>Name</th>
					<th>Banner</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($fivedaysbefore as $row) { ?>
					<tr>
						<!--<td><?php echo $row->id; ?></td>-->
						<td><?php echo $row->name; ?></td>
				        <td><img src="<?php echo base_url('uploads')."/".$row->banner; ?>" width="50px" height="auto"></td>
						<td><?php echo $row->startdateofbanner; ?></td>
						<td><?php echo $row->enddateofbanner; ?></td>
						<td> <a class="btn btn-primary btn-xs" href="<?php echo site_url('site/editnotification?id=').$row->id;?>"><i class="icon-pencil"></i></a>
<!--                                      <a class="btn btn-danger btn-xs" href="<?php echo site_url('site/deletenotification?id=').$row->id; ?>"><i class="icon-trash "></i></a>-->
									 
					  </td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
	</div>
  </div>
