$(document).ready(function () {
	$('.list').click(function (e) {
		$('.display_list').show();
		$(this).hide();
	});
	$('.display_list').change(function (e) {
		var url = $(this).val();
		if(url){
			window.location=url;
		}
		return false;
	});
})