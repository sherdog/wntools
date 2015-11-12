<div class="row" style="margin-top:30px;">
	<div class="col-sm-4 col-md-offset-3">
		<?php echo form_open('level/add_level', array('class'=>'form-horizontal')); ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">Level</label>
				<div class="col-sm-10">
					<input type="text" name="level" id="level" class="form-control" value="" />
				</div>
			</div>
			<div class="form-group ">
				<label class="col-sm-2 control-label">Track</label>
				<div class="col-sm-10">
					<select name="track" id="track" class="form-control  col-sm-4">
						<?php foreach($tracks as $track): ?>
							<option value="<?php echo $track->id; ?>"><?php echo $track->track_name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-group ">
				<div class="col-sm-10 col-sm-offset-2">
					<input type="submit" name="submit" class="btn btn-primary" value="Add Level" />
				</div>
			</div>	
		<?php echo form_close(); ?>
	</div>
</div>
