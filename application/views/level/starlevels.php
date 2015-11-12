<div class="container">
	<div class="col-sm-8">
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
				<div class="col-sm-12">
					<h1>Star Level Manager</h1>
					<?php echo form_open('level/save_star_level'); ?>
					<input type="hidden" name="level" value="<?php echo $this->uri->segment(3); ?>" />
					<input type="hidden" name="track" value="<?php echo $this->uri->segment(4); ?>" />
					<?php for($i = 0; $i < 3; $i++) : ?>
						<?php $level = $i + 1; ?>
						<?php $value = ($starLevels[$i]) ? $starLevels[$i] : 0; ?> 	
						<div class="form-group">
							<label>Level: <?php echo $level; ?></label>
							<input type="text" name="starLevel[<?php echo $i; ?>]" id="starLevel_<?php echo $i; ?>" class="form-control" value="<?php echo $value; ?>" />
						</div>
					<?php endfor; ?>
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-primary" id="submit" value="Save" />
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
	</div>
	<div class="col-sm-4">
		<?php $this->load->view('level/sidebar'); ?>
		</div>
</div>