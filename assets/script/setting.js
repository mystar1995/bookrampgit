$(document).ready(function(){
	$('.save_btn').click(function(){
		var data = {};
		$('.form-control').each(function(){
			var name = $(this).attr('name');
			var value = $(this).val();

			if(name)
			{
				if(value)
				{
					data[name] = value;
				}
			}
		})

		$.ajax({
			url:base_url + "settings/update",
			type:"POST",
			data:data,
			success:function(res)
			{
				res = JSON.parse(res);
				if(res.success)
				{
					toastr['success']('Successfully Saved Settings');
				}
			}
		})
	})
})