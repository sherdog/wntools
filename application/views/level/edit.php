<div class="container">
	<?php if(isset($message)) : ?>

	<div class="row">
		<div class="alert alert-danger"><?php echo $message; ?></div>
	</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-sm-8">
			<div class="row">
				<?php echo form_open('level/edit'); ?>
				<div class="form-group">
					<label>Level #</label>
					<?php echo form_input($levelId); ?>
				</div>
				<div class="form-group">
				<h3>Level Ends in</h3>
				</div>
				<div class="form-group">
					<label>Moves</label>
					<input type="text" name="moves" id="moves" class="form-control" value="" />
				</div>
				<div class="form-group">
					<label>Time</label>
					<input type="text" name="time" id="time" class="form-control" value="" />
				</div>
				<?php echo form_close(); ?>
			</div>
			<hr>

			<div class="row">
				<h3>Level Objectives</h3>
				<!-- Existing Objectives -->
				<?php if($currentLevelObjectves): ?>
				Yup has objectives?
				<?php endif; ?>
				<div id="level-objectives">
					<?php echo form_open('level/addobjective', array('class'=>'form-inline'), $hidden); ?>
					<div class="form-group">
						<label>Objective Type:</label>
						<select id="level_objective_type" name="level_objective_type_id" class="form-control">
							<option value="">Choose</option>
							<?php foreach($levelObjectiveTypes as $type) : ?>
							<option value="<?php echo $type->id; ?>"><?php echo $type->title; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<?php echo form_submit("submit", "submit", 'class="btn btn-primary"'); ?>
					</div>
					<?php echo form_close(); ?>
				</div>	
			</div>
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
<script type="text/javascript">
var typeOptionsObject = '<?php echo json_encode($levelObjectiveTypes); ?>';
var level_id = '<?php echo $this->uri->segment(3); ?>';
var base_url = '<?php echo base_url(); ?>';
</script>