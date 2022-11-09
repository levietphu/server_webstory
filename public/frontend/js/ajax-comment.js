$(document).ready(function() {
	$(document).on('keypress','#comment',function(e) {
			var content = $(this).val()
	    	var _token = $('input[name="_token"]').val();
	    	var id_truyen = $(this).attr('id_truyen');
	    if(e.which == 13) {	
	       	$.ajax({
	       			url: 'comment',
	       			type: 'post',
	       			data: {_token:_token,content:content,id_truyen:id_truyen},
	       			success: function (data) {
	       				$('#comment').val('');
	       				$('#includecomment').html(data);
	       			}
	       		});
	    }
	});
});
