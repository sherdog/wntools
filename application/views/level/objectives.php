<div class="cotnainer">
	<div class="row">
		<div class="col-sm-8">
			<!-- Start Main Content -->
			<div class="row">
				<h3>Level <?php echo $level; ?> objectives</h3>
				
				<?php echo form_open('level/objectives', array('class'=>'form-inline')); ?>

				<input type="hidden" name="levelID" value="<?php echo $levelID; ?>" />
				<input type="hidden" name="level" value="<?php echo $level; ?>" />
				<input type="hidden" name="track" value="<?php echo $track; ?>" />

				<div class="form-group">

					<label>Type</label>
					<select name="objectiveType" id="objective-type" class="form-control">
						<?php foreach($objectiveTypes->types as $key=>$val) : ?>
							<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
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
					<?php foreach($currentObjectives['types'] as $key=>$val) : ?>
						<?php if(is_array($val)) : ?>
							<?php foreach($val as $k=>$v): ?>
							<tr>
								<td><?php echo $key; ?></td>
								<td><?php echo $k; ?></td>
								<td><?php echo $v; ?></td>
								<td><a href="<?php echo base_url('level/deleteobjective/'); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this objecive? this is not undoable.');" />Delete</a></td>
							</tr>
						<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td><?php echo $key; ?></td>
								<td><?php if(is_array($val)){ echo key($val); } else { echo $val; } ?></td>
								<td><?php if(is_array($val)){ echo $val[key($val)]; }else{ echo ''; }?></td>
								<td><a href="<?php echo base_url('level/deleteobjective/'); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this objecive? this is not undoable.');" />Delete</a></td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
				</table>
			</div> <!-- ./ row -->
			<!-- End main content -->
		</div> <!-- ./ col-sm-8-->
		<div class="col-sm-4">
			<?php $this->load->view('level/sidebar'); ?>
		</div> <!-- ./col-sm-4 -->
	</div><!-- ./ row -->
</div><!-- ./ container -->