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
		var texture = '';
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
				htmlBuffer.push('<div class="col-sm-1 column"><a href="#" data-texture="'+texture+'" data-tile="true" id="tile_'+j+'_'+i+'" data-col="'+i+'" data-row="'+j+'" data-type="' + type + '" data-health="' + health + '" class="tile btn btn-default btn-block">t:' + type + ' h:'+health+'</a></div>');
			}
			htmlBuffer.push('</div>');
		}
		$('#gridarea').html(htmlBuffer.join('\n'));

		$('#btnExportJSON').removeClass('disabled');
		$('#btnExportData').removeClass('disabled');
		$('#btnExportPrettyJSON').removeClass('disabled');
	});

	$(document).on('click', 'a.tile', function(e){
		e.preventDefault();

		$('#helpTip').hide();

		//get current data attributes for the properties panel.
		var currentCol = $(this).data('col');
		var currentRow = $(this).data('row');

		var currentType = $(this).attr('data-type');
		var currentHealth = $(this).attr('data-health');
		var currentTexture = $(this).attr('data-texture');

		var currentTile = $(this).attr('id');

		//now create panel and append it. duh.

		var panel = [];

		panel.push('<form class="form">');

		panel.push(inputGroupStart());
		panel.push(inputHTML('Texture <small>String texture name</small>', 'formtexture', 'formtexture', currentTexture));
		panel.push(inputGroupEnd());
		panel.push(inputGroupStart());
		panel.push(inputSelect('Type', 'formtype', 'formtype', typeOptions, currentType));
		panel.push(inputGroupEnd());
		panel.push(inputGroupStart());
		panel.push(inputHTML('Health <small>Default 1</small>', 'formhealth','formhealth', currentHealth));
		panel.push(inputGroupEnd());
		panel.push(inputGroupStart());
		panel.push(inputSubmit('tileUpdate'));
		panel.push(inputHidden('tileID', 'tileID', currentTile));
		panel.push(inputGroupEnd());

		panel.push('</form>');

		$('#properies-area').html(panel.join('\n'));

	});


	$(document).on('click', 'input#tileUpdate', function(e){

		e.preventDefault();
		//we're going update the data attributes!
		//set them up!
		var type = $('#formtype').val();
		var texture = $("#formtexture").val();
		var health = $('#formhealth').val();
		var tile = $('#tileID').val();

		$('#'+tile).attr('data-texture',texture);
		$('#'+tile).attr('data-type', type);
		$('#'+tile).attr('data-health', health);

		if(type == 0)
		{
			$('#'+tile).addClass('btn-danger');
		}
		else if(type == 2)
		{
			$('#'+tile).addClass('btn-info');
		}
		else
		{
			$('#'+tile).removeClass('btn-info');
			$('#'+tile).removeClass('btn-danger');
		}

		$('#'+tile).html('t:'+type+' h:'+health);

		$('#properties-area').html('');
	});

	$(document).on('click', 'input#saveLevelGrid', function(e) {
		e.preventDefault();
		
		var dataRows = [];
		
		$('#gridarea').find('div.row').each(function(index, element){
			
			var dataCols = [];
			
			$(this).find('div.column').each( function(j, el) {
				var colData = $(this).find('a');
				var tmpArr = [];
				var tmpObject = {};
				
				tmpObject = {type:colData.attr('data-type'), health:colData.attr('data-health'), texture:colData.attr('data-texture')};
				tmpArr = [colData.attr('data-type'), colData.attr('data-health'), colData.attr('data-texture')];

				dataCols.push(tmpObject);
			});
			dataRows.push(dataCols);
		});

		//Call controller with datas.
		$.ajax({
			url: SITE_URL + 'json/save_grid',
			data: 'data=' + JSON.stringify(dataRows) + "&level=" + $('#level').val() + "&track=" + $('#track').val(),
			type: 'POST',
			success: function(resp)
			{
				if(resp.status == 'error')
				{
					alert("Error saving record! Sorry for being so soecific");
				}
				else
				{
					$('#messageAlertContent').html('Saved grid sucessfully');
					$('#messageAlert').show();
				}
			}
		})
	});

	/// ---------------------------------------------------------------------------------------------------------------------
	/// HTML UTILITY FUCNTION FOR BUILDING FORM
	/// ---------------------------------------------------------------------------------------------------------------------

	function inputHidden(name, id, value)
	{
		return '<input type="hidden" name="'+name+'" id="'+id+'" value="' + value + '" />';
	}

	function inputGroupStart(className)
	{
		className = typeof className !== 'undefined' ? className : 'form-group';
		return '<div class="'+className+'">';
	}
	function inputGroupEnd()
	{
		return '</div>';
	}
	function inputHTML(label, id, name, value)
	{
		return '<label>'+label+'</label><input type="text" class="form-control" name="'+name+'" id="'+id+'" value="'+value+'" />';
	}

	function inputSubmit(id)
	{
		return '<input type="submit" name="submit" id="'+id+'" value="Update" class="btn btn-primary btn-sm"/>';
	}
	function inputSelect(label,name, id, options, value)
	{
		var select = [];
		select.push('<label>'+label+'</label><select class="form-control" name="'+name+'" id="'+id+'">');

		if(options.length)
		{
			for(var i = 0; i < options.length; i++)
			{
				var selected = (options[i].value == value) ? ' selected="selected"' : '';
				select.push('<option value="' + options[i].value + '" ' + selected + '>' + options[i].name + '</option>');
			}
		}

		select.push('</select>');

		return select.join('\n');
	}
});