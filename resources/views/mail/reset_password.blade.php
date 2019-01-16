@component('mail::message')
# Introduction

Plese Reset Ur password by Clicking the link below{{$token}}

@component('mail::button', ['url' => 'http://localhost:8000/api/auth/RememberPasswordViewPage'.$token])
Rest Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
