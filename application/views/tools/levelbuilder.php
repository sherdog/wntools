<div class="contaienr">
	<div class="row">

		<div class="col-sm-12">
			<div class="well">Create a tile grid for a level. Define # rows/cols then select each col and define that tile.</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form class="form-inline"><label>Rows: </label><input type="text" name="rows" id="formrow" /> <label>Cols: </label><input type="text" name="cols" id="formcol" /> <input type="submit" id="setgrid" name="submit" value="Set" /></form>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-6">
			<div id="gridarea" class="text-center"></div>
		</div>
		<div class="col-sm-6" id="properties-box">
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
			<button id="btnExportData" name="btnExportData" class="btn btn-default disabled">Serialize Data</button>
			<button id="btnExportJSON" name="btnExportJSON" class="btn btn-default disabled">Export JSON</button>
		</div>
	</div>
	<div class="row export-area">
		<div class="row">
			<hr>
			<div class="col-sm-12">
				<label>Result:</label>
				<textarea id="exportText" name="exportText" class="form-control"></textarea>
			</div>
		</div>
	</div>
	<hr>

</div>

