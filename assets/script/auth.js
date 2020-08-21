$(document).ready(function(){
	$('.submit_form').submit(function(){
		var email = $('input[name=email]').val();
		var password = $('input[name=password]').val();
		$.ajax({
			url:base_url + "/auth/login_user",
			type:"POST",
			data:{email:email,password:password},
			success:function(res)
			{
				res = JSON.parse(res);
				if(res.success)
				{
					toastr['success'](res.message);
					window.location.href = base_url;
				}
				else
				{
					toastr['error'](res.message);
				}
			}
		})

		return false;
	})
})