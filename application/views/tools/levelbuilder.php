<div class="contaienr">
	<div class="row" id="messageAlert" style="display:none;">
		<div class="alert alert-info"> <p id="messageAlertContent"></p></div>
	</div>
	<div class="row">

		<div class="col-sm-12">
			<div class="well">Create a tile grid for a level. Define # rows/cols then select each col and define that tile.</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form class="form-inline"><label>Rows: </label><input type="text" value="<?php echo $rows; ?>" name="rows" id="formrow" /> <label>Cols: </label><input type="text" name="cols" value="<?php echo $cols; ?>" id="formcol" /> <input type="submit" id="setgrid" name="submit" value="Set" /></form>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-9">
			<div id="gridarea" class="text-center">
				<?php if(count($grid)) : ?>
				<?php foreach($grid as $row=>$rowData): ?>

					<div class="row">
						<?php foreach($rowData as $col=>$colData) : ?>
							<div class="col-sm-1 column">
								<a id="tile_<?php echo $row; ?>_<?php echo $col; ?>" 
									class="tile btn btn-default btn-block <?php if($colData['type'] == "0") { echo "btn-danger"; } ?>" 
									data-tile="true" 
									data-texture="<?php $colData['texture']; ?>" 
									data-health="<?php echo $colData['health']; ?>" 
									data-col="<?php echo $col; ?>"
									data-type="<?php echo $colData['type']; ?>"
									data-row="<?php echo $row; ?>" 
									href="#">t:<?php echo $colData['type']; ?> h:<?php echo $colData['health']; ?></a>
							</div>
						<?php endforeach; ?>
					</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-sm-3" id="properties-box">
			<div class="row">
				<h3>Properties</h3>
			</div>
			<div class="row">
				<div class="well" id="helpTip">Select a tile to load properties</div>

				<div id="properies-area">

				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-12">
			<!--
			<button id="btnExportData" name="btnExportData" class="btn btn-default disabled">Serialize Data</button>
			<button id="btnExportJSON" name="btnExportJSON" class="btn btn-default disabled">Export JSON</button>
			<button id="btnExportPrettyJSON" name="btnExportPrettyJSON" class="btn btn-default disabled">Export Pretty JSON</button>
			-->
			<input type="hidden" name="level" id="level" value="<?php echo $this->uri->segment(3); ?>" />
			<input type="hidden" name="track" id="track" value="<?php echo $this->uri->segment(4); ?>" />
			<input type="submit" name="submit" id="saveLevelGrid" value="Update Level Grid" class="btn btn-primary" />
		</div>
	</div>
	<div class="row export-area">
		<div class="row">
			<hr>
			<div class="col-sm-12">
				<label>Result: (type, health, texture)</label>
			</div>
		</div>
	</div>
	<hr>

</div>

