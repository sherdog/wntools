<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>Level Manager</h1>
			<table class="table table-striped">
			<thead>
				<tr>
					<th>Level</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($levels as $level): ?>
				<tr>
					<td><?php echo $level->level; ?></td>
					<td><a href="<?php echo base_url('level/edit/'.$level->level); ?>" class="btn btn-primary">Edit</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			</table>
		</div>
	</div>
</div>