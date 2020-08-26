var phone_code = "";
var selectedid = "";
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

	$('select[name=country]').change(function(){
		var country = $(this).val();
		$.post(base_url + "reader/get_phone_code",{country:country},function(res){
			phone_code = res;
			$('#phone_code').html('+' + res);
		})
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
		if(!id)
		{
			if($('input[name=password]').val() != $('input[name=confirm_password]').val())
			{
				toastr['error']('Confirm Password is not matched with Password');
				return false;
			}
		}
		var enable = true;
		var data = {};
		$('.form-control').each(function(){
			var name = $(this).attr('name');
			if(name == 'confirm_password' || name == 'password')
			{
				if(!id)
				{
					if(!$(this).val())
					{
						input_error(this,"This field is required");
						enable = false;
					}
					else
					{
						input_success(this);
					}
				}

				if(enable && name=='password')
				{
					data[name] = $(this).val();
				}
			}
			else {
				if(!$(this).val() && $(this).attr('required'))
				{
					input_error(this,'This field is required');
					enable = false;	
				}
				else if(name)
				{
					data[name] = $(this).val();
					input_success();
				}
			}

			if(name == 'email')
			{
				 var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				 if(!re.test($(this).val()))
				 {
				 	enable = false;
				 	input_error(this,'email is not valid');
				 }
				 else
				 {
				 	input_success(this);
				 }
			}
			else if(name == 'phone_number')
			{
				if(Number.isNaN(Number($(this).val())))
				{
					enable = false;
					input_error(this,'Phone Number is not valid');
				}
				else
				{
					data[name] = $(this).val();
					input_success(this);
				}
			}
		})

		return enable?data:enable;
	}

	$('.submit_reader').click(function(){
		var formdata = new FormData();
		var id = $(this).attr('attr_id');

		var data = validate(id);

		if(data)
		{
			var file = $('#browser')[0]['files'];
			console.log(file);
			if(file && file.length > 0)
			{
				formdata.append('userfile',file[0]);
			}

			if(id)
			{
				formdata.append('id',id);
			}

			console.log(data);

			for(let item in data)
			{
				if(item != 'age_from' && item != 'age_to')
				{
					if(item == 'phone_number')
					{
						formdata.append(item,'+' + phone_code + data[item]);	
					}
					else
					{
						formdata.append(item,data[item]);
					}
				}
			}

			formdata.append('age_group',data.age_from + '~' + data.age_to);

			$('input[name=gender]').each(function(){
				if(this.checked)
				{
					formdata.append('gender',$(this).val());
				}
			})

			if(data.user_type == 'reader')
			{
				formdata.append('status','ACTIVE');	
			}
			else if(data.user_type == 'writer')
			{
				formdata.append('status','UNDERREVIEW');
			}	

			$.ajax({
				url:base_url + "reader/add_user",
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
       					window.location.href = base_url + "reader";	
       				}
       				else
       				{
       					toastr['error'](res.message,'Error');
       				}
       			}
			})
		}	
	})

	$('.pagination li').click(function(){
		selectedid = "";
		$('#dom-jqry tbody tr').each(function(){
			$(this).removeClass('active');
		})
		$('.editable').addClass('disabled');
	})

	$('#dom-jqry tbody').on('click','tr',function(){
		if($(this).hasClass('active'))
		{	
			selectedid = "";
			$('.editable').addClass('disabled');
			$(this).removeClass('active');
		}
		else
		{
			$('#dom-jqry tbody tr').each(function(){
				$(this).removeClass('active');
			})

			selectedid = $(this).attr('attr_id');
			$('.editable').removeClass('disabled');
			$(this).addClass('active');	
		}
	})

	$('.edit').click(function(){
		if(selectedid)
		{
			window.location.href = base_url + "reader/add/" + selectedid;
		}
	})

	$('.inactive').click(function(){
		if(selectedid)
		{
			var row = table.row($('#dom-jqry tbody tr.active'));
			var rowdata = row.data();
			
			var status = $(this).attr('attr_status');

			$.ajax({
				url:base_url + "writer/active",
				type:'POST',
				data:{active:status,id:selectedid},
				success:function(res)
				{
					if(rowdata[14] != status)
					{
						row.remove();
						row.draw();
					}
				}		
			})
		}
	})

	$('.get_user_active').click(function(){
		let status = $(this).attr('attr_status');
		$('.status').each(function(){
			$(this).css('opacity',0.5);
		})

		$(this).css('opacity','');
		getuser(status);
	})

	function setactive(status,row)
	{
		$('.get_user_active').each(function(){
			if($(this).css('opacity') != 0.5)
			{
				var active = $(this).attr('attr_status');
				if(active == 'all' || active == status)
				{
					let rowdata = row.data();
					rowdata[13] = status;
					row.data(rowdata);
					row.draw();
				}	
				else
				{
					row.remove();
					row.draw();
				}
			}
		})
	}

	function getuser(status)
	{
		$.ajax({
			url:base_url + "writer/get_user",
			type:'POST',
			data:{status:status},
			success:function(res)
			{
				res = JSON.parse(res);
				var result = [];
				for(let item in res)
				{
					res[item].profile_pic = res[item].profile_pic?'<img src="' + base_url + res[item].profile_pic + '" style="width:50%"/>':'';
					res[item].status = res[item].status == '1'?'Active':'InActive';
					res[item].language = res[item].language == 'en'?'English':'Arabic';

					result.push([
						Number(item) + 1,
						res[item].profile_pic,
						res[item].username,
						res[item].email,
						res[item].phone_number,
						res[item].dob,
						res[item].age_group,
						res[item].gender,
						res[item].country_name,
						res[item].city,
						res[item].short_bio,
						"",
						res[item].language,
						res[item].status
					]);
				}

				table.clear();
				table.rows.add(result);
				table.draw();
				disable();
			}
		})
	}

	$('.delete').click(function(){
		delete_user();
	})

	function delete_user()
	{
		if(selectedid)
		{
			if(confirm('Are you sure that you want to delete this user?'))
			{
				var row = table.row($('#dom-jqry tbody tr.active'));
				$.ajax({
					url:base_url + "writer/delete",
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

	function disable()
	{
		selectedid = "";
		$('.editable').addClass('disabled');
	}
});