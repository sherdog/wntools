<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<?php echo form_open('level/edit'); ?>

			<div class="form-group">
				<label>Level #</label>
				<?php echo form_input($levelId); ?>
			</div>
			<div class="form-group">
				<label>Objective Type</label>
				<?php echo form_dropdown('objective_type', $objectTypeOptions, $selectedObjectiveType, 'class="form-control"'); ?>
			</div>
			<div class="col-sm-4">

				<?php foreach($objectTypeKeys as $objKey) : ?>

			<?php endforeach; ?>
				<div class="form-group">

				</div>
			</div>

			<?php echo form_close(); ?>
		</div>
		<div class="col-sm-4">
			<div class="well">
				<div class="panel panel-default">
				  <!-- Default panel contents -->
				  <div class="panel-heading">Level Options</div>
				  <!-- List group -->
				  <ul class="list-group">
				    <li class="list-group-item"><a href="#">Grid</a></li>
				    <li class="list-group-item"><a href="#">Objectives</a></li>
				    <li class="list-group-item"><a href="#">Score Tier</a></li>
				    <li class="list-group-item"><a href="#">Word Objectives</a></li>
				</div>
			</div>
		</div>
	</div>
</div>