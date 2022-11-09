@foreach($value->children_comment()->orderby('created_at','desc')->get() as $stt => $chil)
<p style="background-color: white;" class="mt-10 mr-10 ml-30 border-radius-10">
    <span class="ml-10 mr-10" style="display: block;"><b class="uppercase">{{$chil->user_comment->name}}: </b>{{$chil->created_at->diffForHumans($now)}}</span>
    <span class="ml-10 mr-10" style="display: block;">{!!$chil->content!!}</span>
    <span class="ml-10"><a id="comment_children_{{$key.$stt}}" style="cursor: pointer;color: blue;">trả lời</a></span>
</p>
@if(Auth::check())
<form action="" method="POST" role="form" class="ml-30 mr-10 mb-10">
    <textarea id="content_children_{{$key.$stt}}" class="form-control border-radius-10" rows="2" style="display: none;"></textarea>
</form>
@endif
<script type="text/javascript">
    $('#comment_children_{{$key.$stt}}').on('click', function(event) {
     $('#content_children_{{$key.$stt}}').toggle()
 });
    
    $('#content_children_{{$key.$stt}}').on('keypress', function (event) {
        var children_content = $(this).val();
        var id_comment = $('#children_content_{{$key+1}}').attr('id_comment');
        var _token=$('input[name="_token"]').val();
        var id_truyen = $('#comment').attr('id_truyen');
        if (event.which == 13) 
        {
            $.ajax({
                url: 'comment',
                type: 'post',
                data: {_token:_token,id_comment:id_comment,id_truyen:id_truyen,children_content:children_content},
                success: function (data) {
                    $('#includecomment').html(data);
                }
            });
        }
    });
</script>
@endforeach
