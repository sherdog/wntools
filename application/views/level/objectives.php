<div class="cotnainer">
	<div class="row">
		<div class="col-sm-12">
			<!-- Start Main Content -->
			<div class="row">
				<h3>Level <?php echo $level; ?> objectives</h3>
				
				<?php echo form_open('level/objectives', array('class'=>'form-inline')); ?>
				<input type="hidden" name="levelID" value="<?php echo $level; ?>" />
				<div class="form-group">
					<label>Type</label>
					<select name="objectiveType" id="objective-type" class="form-control">
						<?php foreach($objectiveTypes as $type) : ?>
						<option value="<?php echo $type->id; ?>"><?php echo $type->title; ?></option>
						<?php endforeach; ?>
					</select>

					<label id="objective-key-label">Key</label>
					<input type="text" class="form-control" name="objectiveKey" id="objective-key" value="" />

					<label id="objective-value-label">Value</label>
					<input type="text" class="form-control" name="objectiveValue" id="objective-value" value="" />

					<button type="submit" name="submit" class="btn btn-default btn-primary">Add</button>

				</div>
				<?php echo form_close(); ?>

			</div> <!-- ./ row -->
			<div class="row">

				<h3>Current Objectives</h3>

				<table class="table table-striped">
				<thead>	
					<tr>
						<th>Type</th>
						<th>Key</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($currentObjectives as $obj) : ?>
					<tr>
						<td><?php echo $obj->title; ?></td>
						<td><?php echo $obj->key; ?></td>
						<td><?php echo $obj->value; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>

			</div> <!-- ./ row -->
			<!-- End main content -->
		</div> <!-- ./ col-sm-9 -->
	</div><!-- ./ row -->
</div><!-- ./ container -->