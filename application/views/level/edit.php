<div class="container">
	<?php if(isset($message)) : ?>
	<div class="row">
		<div class="alert alert-info"><?php echo $message; ?></div>
	</div>
	<?php endif; ?>
	<?php if(isset($error)) : ?>
	<div class="row">
		<div class="alert alert-info"><?php echo $errorse; ?></div>
	</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-sm-8">
			<div class="row">
				<?php echo form_open('level/save_info'); ?>
				<input type="hidden" id="level_id" name="level_id" value="<?php echo $level->level_id; ?>" />
				<input type="hidden" id="level" name="level" value="<?php echo $level->level; ?>" />
				<input type="hidden" id="_id" name="_id" value="<?php echo $level->_id; ?>" />

				<div class="form-group">
					<label>Level #</label>
				</div>
				<div class="form-group ">
					<label>Track</label>
					<select name="track" id="track" class="form-control  col-sm-4">
						<?php foreach($trackOptions as $track): ?>
							<option value="<?php echo $track->id; ?>" <?php if($level->track == $track->id): ?> selected="selected" <?php endif; ?> ><?php echo $track->track_name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<h4>Level Ends in</h4>
				<div class="form-group">
					<label>Moves</label>
					<input type="text" name="moves" id="moves" class="form-control" value="<?php echo $level->complete['moves']; ?>" />
				</div>
				<div class="form-group">
					<label>Time</label>
					<input type="text" name="time" id="time" class="form-control" value="<?php echo $level->complete['time']; ?>" />
				</div>
				<div class="form-group">
					<input type="submit" name="submit" class="btn btn-primary" value="Save Level" />
				</div>	
				<?php echo form_close(); ?>
			</div>
		</div>
		<div class="col-sm-4">
		<?php $this->load->view('level/sidebar'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<div class="row">
				<?php if($level->date_created) : ?>
					<i>Created: <?php echo $level->date_created; ?> </i>
				<?php endif; ?>
				<?php if($level->last_modified) : ?>
					Last Modified: <?php echo $level->last_modified; ?> 
				<?php endif; ?>
			</div>
		</div>
	</div>
	<br />
</div>

<!-- Modal For Word Find -->
<div class="modal fade" id="valueModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Set Word Find Objectives</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnModalSubmit"></button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
var typeOptionsObject = '<?php echo json_encode($levelObjectiveTypes); ?>';
var level_id = '<?php echo $this->uri->segment(3); ?>';
var base_url = '<?php echo base_url(); ?>';
</script>