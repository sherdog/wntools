<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<a class="btn btn-primary pull-right" href="<?php echo base_url('level/add'); ?>">Add Level</a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h1>Level Manager</h1>
			<table class="table table-striped">
			<thead>
				<tr>
					<th>Level</th>
					<th>Track</th>
					<th width="100">&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($levels as $level): ?>
				<tr>
					<td><?php echo $level['level']; ?></td>
					<td><?php echo $level['track']; ?></td>
						<td>
						<a href="<?php echo base_url('level/edit/'.$level['level'].'/'.$level['track']); ?>" class="btn btn-primary ">Edit</a>
					</td>
					<td>
						 <a onclick="return confirm('Are you sure you want to delete <?php echo 'Level: ' . $level['level'].' '.$level['track']; ?>?');" href="<?php echo base_url('level/delete/'.$level['level'].'_'.$level['track']); ?>" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-remove"></span></a> 
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			</table>
		</div>
	</div>
</div>