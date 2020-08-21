var table;
$(document).ready(function(){
	$('.upload').click(function(){
		$('#browser').click();
	})

	if($('#dom-jqry').length > 0)
	{
		table = $('#dom-jqry').DataTable();	
	}

	$('#browser').change(function(event){
		var reader = new FileReader();
		reader.onload = function()
		{
			$('.imagepicker').html('<img src="' + reader.result + '" style="width:100%;height:100%;"/>');
		}

		 reader.readAsDataURL(event.target.files[0]);
	})


	function input_error(element,text)
	{
		$(element).parents('.row').eq(0).addClass('has-error');
		$(element).addClass('input-danger');
		$(element).parents('.row').eq(0).find('.messages').eq(0).html('<p class="text-danger error">' + text + '</p>');
	}

	function input_success(element)
	{
		$(element).parents('.row').eq(0).removeClass('has-error');
		$(element).removeClass('input-danger');
		$(element).parents('.row').eq(0).find('.messages').eq(0).html('');
	}

	$('.delete').click(function(){
		var id = $(this).attr('attr_id');
		var row = table.row($('#dom-jqry tbody tr.active'));
		if(confirm("Are you sure you want to delete this category"))
		{
			$.ajax({
				url:base_url + "category/delete",
				type:"POST",
				data:{id:id},
				success:function(res)
				{
					window.location.reload();
					toastr['success']('You have successfully delete one category','Success');
				}
			})	
		}
		
	})

	$('.submit_category').click(function(){
		var formdata = new FormData();
		var category = $('input[name=category]').val();
		var id = $(this).attr('attr_id');
		var enable = true;
		$('.form-control').each(function(){
			if($(this).val())
			{
				formdata.append($(this).attr('name'),$(this).val());
				input_success(this);
			}
			else if($(this).attr('required'))
			{
				enable = false;
				input_error(this,"This field is required");
			}
		})

		if(!enable)
		{
			return;
		}
		else
		{
			var file = $('#browser')[0]['files'];
			if(file && file.length > 0)
			{
				formdata.append('coverfile',file[0]);
			}

			if(id)
			{
				formdata.append('id',id);
			}

			$.ajax({
				url:base_url + "category/add_category",
				type:'POST',
				data:formdata,
				processData: false,
       			contentType: false,
       			success:function(res)
       			{
       				res = JSON.parse(res);
       				if(res.success)
       				{
       					toastr['success'](res.message,'Success');
       					window.location.href = base_url + "category";	
       				}
       				else
       				{
       					toastr['error'](res.message,'Error');
       				}
       			}
			})
		}
	})
})