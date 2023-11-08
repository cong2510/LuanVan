@component('mail::message')
<p> Hello {{ $user->name }}</p>

@component('mail::button',['url' => url('/reset-password/'.$user->remember_token)])
    Reset password
@endcomponent

@endcomponent
