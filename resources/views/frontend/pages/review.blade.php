<div class="rate-holder" data-score="{{$score}}">
                                
</div>
<em class="rate-text"></em>
<div style="color: #198754 ;" class="small"><em>Đánh giá: <span itemprop="ratingValue">{{$score}}</span>/<span class="text-muted" itemprop="bestRating">10</span> từ <span itemprop="ratingCount">{{$count_review}}</span> lượt</em></div>
@if(Auth::check())
    @if($review_user->count()<1)
        <script>
                $('div.rate-holder').on('click',function(e){
                    var score = $('input[name="score"]').val();
                    var _token = $('input[name="_token"]').val(); 
                    var id_truyen = $('#comment').attr('id_truyen');
                   $.ajax({
                        url: '{{route('review')}}',
                        type: 'post',
                        data: {_token:_token,score:score,id_truyen:id_truyen},
                        success: function (data) {
                            $('.rate').html(data);
                        }
                    });
                })
        </script>
    @else
        <script>
            $('div.rate-holder').click(function(e){
                alert('Bạn đã đánh giá rồi')
            })
        </script>
    @endif
@else
<script>
    $('div.rate-holder').click(function(e){
                alert('Bạn cần đăng nhập để đánh giá')
            })
</script>
@endif

@if(Auth::check()) 
    @if($review_user->count()<1)                        
    <script type="text/javascript">
        $('div.rate-holder').raty({ 
                number: 10,
                cancelButton: false,
                target:'.rate-text',
                hints: [['Không còn gì để nói', 'bad'], ['WTF', 'poor'], ['Cái gì thế này?', 'regular'], ['Haizz', 'good'], ['Tạm', 'gorgeous'],['Cũng được','6'],['Khá đấy','7'],['Được','8'],['Hay','9'],['Tuyệt đỉnh','10']],
            });

    </script> 
    @else
        <script>
            $('div.rate-holder').raty({ number:10,readOnly: true, score: {{$score}} });
        </script>
    @endif
@else
<script>
    $('div.rate-holder').raty({ number:10,readOnly: true, score: {{$score}} });
</script>
@endif                           