@component('mail::message')
<h1>Xin chào {{$user->name}}</h1>
<p>Bạn nhận được email này vì đã yêu cầu đặt lại mật khẩu.</p>

<p>Mã xác nhận của bạn là:</p>
@component('mail::button',["url"=>""])
<span style="font-size: 20px">{{$user->otp}}</span>
@endcomponent
<p>Mã xác nhận sẽ có hiệu lực trong vòng 5 phút.</p>

<p>Tuyệt đối không cung cấp mã này cho bất cứ ai kể cả admin.</p>

<hr>
Trân trọng,<br>
<h1>Tiên Vực Team</h1>

@endcomponent