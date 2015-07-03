<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<?php echo form_open('tools'); ?>
			<div class="form-group">
				<label>Raw Input</label>
				<textarea name="raw" id="raw" class="form-control" rows="15"><?php echo $raw; ?></textarea>
			</div>
			<div class="form-group">
				<label>Output</label>
				<textarea name="output" id="output" class="form-control" rows="15"><?php echo $output; ?></textarea>
			</div>
			<div class="form-group">
				<?php echo form_submit('subit', 'convert', 'class="btn btn-primary"'); ?>
			</div>
			<?php echo form_close(); ?>
		</div>
		<div class="col-sm-4">
			<div class="well">
				This tool creates a serialized string for storage in the database for level grids. yeah.
			</div>
		</div>
	</div>

</div>