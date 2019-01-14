@component('mail::message')
# Introduction

Plese Reset Ur password by Clicking the link below

@component('mail::button', ['url' => ''])
Rest Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
