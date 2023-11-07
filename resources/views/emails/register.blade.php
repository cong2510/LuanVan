@component('mail::message')
<p> Hello {{ $user->name }}</p>

@component('mail::button',['url' => url('/verify/'.$user->remember_token)])
    Xác nhận tài khoản
@endcomponent

@endcomponent
