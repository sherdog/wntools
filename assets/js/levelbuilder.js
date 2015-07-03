$(document).ready(function(e) {

	var typeOptions = [];
	typeOptions.push({'name': 'disabled', 'value':0});
	typeOptions.push({'name': 'tile', 'value':1});
	typeOptions.push({'name': 'brick', 'value':2});

	$('#setgrid').click(function(e){
		e.preventDefault();

		var rows = 1;
		var cols = 1;
		var str = '';
		var type = 1;
		var health = 1;
		var htmlBuffer = [];

		if( $('#formrow').val() != '')
		{
			rows = $('#formrow').val();
		}

		if( $('#formcol').val() != '')
		{
			cols = $('#formcol').val();
		}

		for(var j = 0; j < rows; j++)
		{
			htmlBuffer.push('<div class="row" >');
			for(var i = 0; i < cols; i++)
			{
				htmlBuffer.push('<div class="col-sm-1"><a href="#" data-tile="true" id="tile_'+j+'_'+i+'" data-col="'+i+'" data-row="'+j+'" data-type="' + type + '" data-health="' + health + '" class="tile btn btn-default btn-block">' + type + '</a></div>');
			}
			htmlBuffer.push('</div>');
		}
		$('#gridarea').html(htmlBuffer.join('\n'));
	});

	$(document).on('click', 'a.tile', function(e){
		e.preventDefault();
		

		//get current data attributes for the properties panel.
		var currentCol = $(this).data('col');
		var currentRow = $(this).data('row');
		var currentType = $(this).data('type');
		var currentHealth = $(this).data('health');
		var currentTexture = $(this).data('texture');

		//now create panel and append it. duh.

		var panel = [];

		panel.push(inputGroupStart());
		panel.push(inputHTML('tile-texture', 'tile-texture', currentTexture));
		panel.push(inputGroupEnd());
		panel.push(inputGroupStart());
		panel.push(inputSelect('tile-type', 'tile-type', tileOptions, currentType));
		panel.push(inputGroupEnd());
		panel.push(inputGroupStart());
		panel.push(inputHTML('health','health', currentHealth));
		panel.push(inputGroupEnd());


	});

	function inputGroupStart()
	{
		return '<div class="form-group">';
	}
	function inputGroupEnd()
	{
		return '</div>';
	}
	function inputHTML(id, name, value)
	{
		return '<input type="text" name="'+name+'" id="'+id+'" value="'+value+'" />';
	}

	function inputSelect(name, id, options, value)
	{
		var select = [];
		select.push('<select class="form-control" name="'+name+'" id="'+id+'">');

	}
});