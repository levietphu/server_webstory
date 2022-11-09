
$('#modal-image').on('hide.bs.modal',function(){
    // Lấy value của input có id = image
    var image = $('#image').val();
    console.log(image);
    $('#img_image').attr('src',image);
});