// Chỉnh màu nền và chữ
$(document).ready(function() {
	if (localStorage.getItem('switch-color')!==null) 
	{
		const data = localStorage.getItem('switch-color');
		const data_obj= JSON.parse(data);
		$('.switch-color').toggleClass(data_obj.class_1);
		$('.switch-color-white').toggleClass(data_obj.class_2)
		$("select option[value='dark']").attr("selected","selected")
	}
});


$(document).on('change','#switch-color', function(event) {
	event.preventDefault()
	$('.switch-color').toggleClass('dark-theme');
	$('.switch-color-white').toggleClass('color-white')
	if($(this).val()=='dark'){
		var items = {
			'class_1':'dark-theme',
			'class_2':'color-white'
		}
		localStorage.setItem('switch-color',JSON.stringify(items));
	}else{
		localStorage.removeItem('switch-color');
	}
});
// Chỉnh cỡ chữ
$(document).ready(function() {
	if (localStorage.getItem('font-size-change')!==null) 
	{
		var fontSize=JSON.parse(localStorage.getItem('font-size-change')) ;
		$('.font-size-change').css('font-size', fontSize.size);
		$('select option[value="'+fontSize.size+'"]').attr('selected','selected');;
	}
});
$('#switch-font-size').on('change', function(event) {
	event.preventDefault();
	var value = $(this).val();
	var fontSize;
	$('.font-size-change').css('font-size', value);
	switch (value)
		{
		    case '24px':
		    	localStorage.removeItem('font-size-change');
		      fontSize={'size':'24px'}
		      localStorage.setItem('font-size-change',JSON.stringify(fontSize))
		      break;
		    case '26px':
		    localStorage.removeItem('font-size-change');
		      fontSize={'size':'26px'}
		      localStorage.setItem('font-size-change',JSON.stringify(fontSize))
		      break;
		   	case '28px':
		   	localStorage.removeItem('font-size-change');
		      fontSize={'size':'28px'}
		      localStorage.setItem('font-size-change',JSON.stringify(fontSize))
		      break;

		     case '30px':
		     localStorage.removeItem('font-size-change');
		      fontSize={'size':'30px'}
		      localStorage.setItem('font-size-change',JSON.stringify(fontSize))
		      break;
		    default:
		    localStorage.removeItem('font-size-change');
		      fontSize={'size':'18px'}
		      localStorage.setItem('font-size-change',JSON.stringify(fontSize))
		}
});

// Chỉnh giãn cách dòng

$(document).ready(function() {
	if (localStorage.getItem('line-height-change')!==null) 
	{
		var lineHeight = JSON.parse(localStorage.getItem('line-height-change'));
		$('.line-height-change').css('line-height', lineHeight.line_height);
		$('select option[value="'+lineHeight.line_height+'"]').attr('selected','selected');
	}
});

$('#switch-line-height').on('change', function(event) {
	event.preventDefault();
	var value = $(this).val();
	var lineHeight;
	$('.line-height-change').css('line-height', value);
	switch (value)
		{
		    case '140%':
		    	localStorage.removeItem('line-height-change');
		      lineHeight={'line_height':'140%'}
		      localStorage.setItem('line-height-change',JSON.stringify(lineHeight))
		      break;
		    case '160%':
		    localStorage.removeItem('line-height-change');
		      lineHeight={'line_height':'160%'}
		      localStorage.setItem('line-height-change',JSON.stringify(lineHeight))
		      break;
		   	case '180%':
		   	localStorage.removeItem('line-height-change');
		      lineHeight={'line_height':'180%'}
		      localStorage.setItem('line-height-change',JSON.stringify(lineHeight))
		      break;

		     case '200%':
		     localStorage.removeItem('line-height-change');
		      lineHeight={'line_height':'200%'}
		      localStorage.setItem('line-height-change',JSON.stringify(lineHeight))
		      break;
		    default:
		    localStorage.removeItem('line-height-change');
		      lineHeight={'line_height':'120%'}
		      localStorage.setItem('line-height-change',JSON.stringify(lineHeight))
		}
});
