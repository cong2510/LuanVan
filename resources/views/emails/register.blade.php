@component('mail::message')
<p> Hello {{ $user->name }}</p>

@component('mail::button',['url' => url('/verify/'.$user->remember_token)])
    Xac nhan tai khoan
@endcomponent

@endcomponent
