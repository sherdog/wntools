$(document).ready(function(e) {

	$(document).on('click', 'a#add-level-objective', function(e){
		e.preventDefault();
		var typeOptions = jQuery.parseJSON(typeOptionsObject);
		
		var options = [];
		options.push('<option value="">Choose</option>');
		$.each(typeOptions, function(){
			options.push('<option value="'+this.id+'">'+this.title+'</option>');
		});


		//create a row.
		$('#objectives-area').append(
			$('<div>', {'class':'row insertItemRow', 'id': 'row_' + $('.insertItemRow').length }).append(
				$('<div>', {'class':'form-group'}).append(
					$('<label>').html('Type'),
					$('<select>', { 'name': 'objective_type[]', 'id':'objective_type_' + $('.insertItemRow').length, 'class':'form-control'}).html(options.join(''))
				),
				$('<div>', {'class':'form-group'}).append(
					$('<label>').html('Value'),
					$('<input>', { 'name': 'objective_value[]', 'id':'objective_value_' + $('.insertItemRow').length, 'type':'text', 'class':'form-control'})
				),
				$('<div>', { 'class':'form-group'}).append(
					$('<a>', { 'href': '#', 'class':'btn btn-success btnAddObjective', 'rel': + $('.insertItemRow').length, 'id':'insertObjective'}).text("Add"),
					$('<span>').html('&nbsp'),
					$('<a>', { 'href': '#', 'class':'btn btn-danger btnRemoveObjective', 'rel': + $('.insertItemRow').length, 'id':'deleteObjective'}).text("Remove")
				)
			)
		);
	});

	$(document).on('click', 'a.btnAddObjective', function(e){
		e.preventDefault();

		var $id = $(this).attr('rel'); //get the id so we can access the form elements
		var $error = false;
		var $type = $('#objective_type_'+$id).val();
		var $value = $('#objective_value_'+$id).val();
		var $levelID = level_id;
		if($type == '')
		{
			$error = true;
		}

		if($value == '')
		{
			$error = true;
		}

		if(!$error)
		{
			var postData = {level:level_id, type:$type, value:$value };
			//save this and then on success add it to the correct one.
			$.ajax({
				url: base_url + 'json/saveobjective',
				data: postData,
				method: 'POST',
				success: function(resp)
				{
					alert(resp);
				}
			})
		}
		else
		{
			alert('Fields cannot be blank');
		}




	});

	$(document).on('click', 'a.btnRemoveObjective', function(e){
		e.preventDefault();

		var $id = $(this).attr('rel');
		$('#row_'+$id).remove();

	});
});