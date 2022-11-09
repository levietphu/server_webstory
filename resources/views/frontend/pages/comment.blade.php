@foreach($comment as $key => $value)
<p style="background-color: white;" class="mt-10 mr-10 ml-10 border-radius-10">
    <span class="ml-10 mr-10" style="display: block;"><b class="uppercase">{{$value->user_comment->name}}: </b>{{$value->created_at->diffForHumans($now)}}</span>
    <span class="ml-10 mr-10" style="display: block;">{!!$value->content!!}</span>
    <span class="ml-10"><a id="children_comment_{{$key+1}}" style="cursor: pointer;color: blue;">{{$value->children_comment()->count()}} trả lời</a></span>
</p>
@if(Auth::check())
<form action="" method="POST" role="form" class="ml-30 mr-10 mb-10">
    <textarea id="children_content_{{$key+1}}" class="form-control border-radius-10" rows="2" style="display: none;" id_comment="{{$value->id}}"></textarea>
</form>
@endif
<div>
    @include('frontend.pages.children_comment')
</div>
<script type="text/javascript">
        $('#children_comment_{{$key+1}}').on('click', function(event) {
           $('#children_content_{{$key+1}}').toggle()
        });
        
        $('#children_content_{{$key+1}}').on('keypress', function (event) {
            var children_content = $(this).val();
            var id_comment = $(this).attr('id_comment');
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
