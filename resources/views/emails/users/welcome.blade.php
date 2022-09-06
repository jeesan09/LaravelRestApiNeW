@component('mail::message')

   Welcome {{$UserName}}

The body of your Password is: {{$password}}

@component('mail::button', ['url' => 'http://localhost:8000/'])
           Goto WebSite
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
