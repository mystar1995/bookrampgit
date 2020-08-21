var table;
var selectedid;
$(document).ready(function(){
	if($('#dom-jqry').length > 0)
	{
		table = $('#dom-jqry').DataTable();	
	}

	$('.status').click(function(){
		$('.status').each(function(){
			$(this).addClass('inactive');
		})

		var status = $(this).attr('attr_status');
		$(this).removeClass('inactive');

		$.ajax({
			url:base_url + "payments/reader_status",
			type:"POST",
			data:{status:status},
			success:function(res)
			{
				var data = JSON.parse(res);
				var result = [];

				for(let item in data)
				{
					result.push([
						Number(item) + 1,
						data[item].transaction_id,
						data[item].status,
						data[item].readername,
						data[item].contentname,
						'$ ' + data[item].amount,
						data[item].rewards,
						data[item].created_at
					]);
				}

				table.clear();
				table.rows.add(result);
				table.draw();
			}
		})
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

	$('.payment').click(function(){
		console.log(selectedid);
		if(selectedid)
		{
			var row = table.row($('#dom-jqry tbody tr.active'));
			var rowdata = row.data();
			var form = document.createElement('form');
			form.action = base_url + "books/payment";
			form.method = "POST";
			var input = document.createElement('input');
			input.name = "contentid";
			input.value = selectedid;
			form.appendChild(input);

			$('body').append(form);
			form.submit();
		}
		
	})

	$()
})