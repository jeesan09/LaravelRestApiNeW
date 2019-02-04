@component('mail::message')
# Introduction

Plese Reset Ur password by Clicking the link below <br>Token : {{$token}}

@component('mail::button',['url' => 'http://localhost:8080/ComfirmPassword'] )
Rest Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
<!-- ['url' => 'http://localhost:8000/api/auth/RememberPasswordViewPage'.$token] -->