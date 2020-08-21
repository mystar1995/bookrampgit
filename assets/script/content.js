$(document).ready(function(){
	$('#summernote_1').summernote({height: 300});

	$('.publish_book').click(function(){
		var content = {};
		content.id = $(this).attr('attr_id');
		content.book_content = $('#summernote_1').summernote('code');
		content.status = 'UNDERREVIEW';

		$.ajax({
			url:base_url + "books/save_content",
			data:content,
			type:"POST",
			success:function(res)
			{
				res = JSON.parse(res);

				if(res.success && res.redirect_url)
				{
					toastr['success']('You have successfully submited DRAFT');
					window.location.href = res.redirect_url;
				}
				else if(res.success)
				{
					toastr['success']('You have successfully saved DRAFT');
				}
			}
		})
	})

	$('.save_book').click(function(){
		var content = {};
		content.id = $(this).attr('attr_id');
		content.book_content = $('#summernote_1').summernote('code');

		$.ajax({
			url:base_url + "books/save_content",
			data:content,
			type:"POST",
			success:function(res)
			{
				res = JSON.parse(res);

				if(res.success && res.redirect_url)
				{
					toastr['success']('You have successfully submited DRAFT');
					window.location.href = res.redirect_url;
				}
				else if(res.success)
				{
					toastr['success']('You have successfully saved DRAFT');
				}
			}
		})
	})
})