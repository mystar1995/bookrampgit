var table;
$(document).ready(function(){
	if($('#dom-jqry').length > 0)
	{
		table = $('#dom-jqry').DataTable();	
	}
	
	$('.upload').click(function(){
		$('#browser').click();
	})

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

	function validate(id)
	{
		var enable = true;
		var data = {};
		$('.form-control').each(function(){
			if($(this).attr('required') && !$(this).val())
			{
				enable = false;
				input_error(this,"This field is required");
			}
			else if($(this).attr('name'))
			{
				data[$(this).attr('name')] = $(this).val();
			}
		})

		if(id)
		{
			data['id'] = id;
		}

		return enable?data:enable;
	}

	$('.submit_books').click(function(){
		var id = $(this).attr('attr_id');

		var data = validate(id);

		if(data)
		{
			var formdata = new FormData();
			for(item in data)
			{
				formdata.append(item,data[item]);
			}

			var cover_image = $('#browser')[0].files;

			if(cover_image && cover_image.length > 0)
			{
				formdata.append('cover_image',cover_image[0]);
			}

			var content_file = $('#content_file')[0].files;

			if(content_file && content_file.length > 0)
			{
				formdata.append('content_file',content_file[0]);
			}

			$.ajax({
				url:base_url + "books/add_book",
				type:"POST",
				data:formdata,
				processData: false,
       			contentType: false,
       			success:function(res)
       			{
       				toastr['success']('You have succssfully Add The Books');
       				window.location.href = base_url + "books/published";
       			}
			})
		}
	})

	$('.continue_writing').click(function(){
		var id = $(this).attr('attr_id');

		var data = validate(id);

		if(data)
		{
			data['status'] = 'DRAFT';
			var formdata = new FormData();
			for(item in data)
			{
				formdata.append(item,data[item]);
			}

			var cover_image = $('#browser')[0].files;

			if(cover_image && cover_image.length > 0)
			{
				formdata.append('cover_image',cover_image[0]);
			}

			var content_file = $('#content_file')[0].files;

			if(content_file && content_file.length > 0)
			{
				formdata.append('content_file',content_file[0]);
			}

			$.ajax({
				url:base_url + "books/add_book",
				type:"POST",
				data:formdata,
				processData: false,
       			contentType: false,
       			success:function(res)
       			{
       				res = JSON.parse(res);
       				window.location.href = res.redirecturl;
       			}
			})
		}
	})

	$('.pagination li').click(function(){
		selectedid = "";
		$('#dom-jqry tbody tr').each(function(){
			$(this).removeClass('active');
		})
		$('.action_btn').addClass('disabled');
	})

	$('#dom-jqry tbody').on('click','tr',function(){
		if($(this).hasClass('active'))
		{	
			selectedid = "";
			$('.action_btn').addClass('disabled');
			$(this).removeClass('active');
		}
		else
		{
			$('#dom-jqry tbody tr').each(function(){
				$(this).removeClass('active');
			})

			selectedid = $(this).attr('attr_id');

			if(selectedid && !Number.isNaN(Number(selectedid)))
			{
				$('.action_btn').removeClass('disabled');
				$(this).addClass('active');		
			}
		}
	})

	$('.edit').click(function(){
		if(selectedid)
		{
			window.location.href = base_url + "books/add/" + selectedid;
		}
	})

	$('.active').click(function(){
		if(selectedid)
		{
			var row = table.row($('#dom-jqry tbody tr.active'));
			var rowdata = row.data();
			var status = $(this).attr('attr_status');
			$.ajax({
				url:base_url + "books/changestatus",
				type:'POST',
				data:{status:status,id:selectedid},
				success:function(res)
				{
					row.remove();
					row.draw();
				}
			})
		}
	})

	

	$('.delete').click(function(){
		delete_content();
	})

	function delete_content()
	{
		if(selectedid)
		{
			if(confirm('Are you sure that you want to delete this content?'))
			{
				var row = table.row($('#dom-jqry tbody tr.active'));
				$.ajax({
					url:base_url + "books/delete",
					data:{id:selectedid},
					type:"POST",
					success:function(res)
					{
						row.remove();
						table.draw();
						disable();
						toastr['success']('You have successfully Deleted this user');
					}
				})
			}
		}
	}

	$('.download').click(function(){
		$.ajax({
			url:base_url + "books/download",
			data:{id:selectedid},
			type:"POST",
			success:function(res)
			{
				res = JSON.parse(res);
				if(res.success)
				{
					window.open(base_url + res.url,'_blank');
					//window.location.href = base_url + res.url;
				}
				else
				{
					window.open(base_url + "books/content/" + res.id,'_blank');
				}
			}
		})
	})

	function disable()
	{
		selectedid = "";
		$('.action_btn').addClass('disabled');
	}
});