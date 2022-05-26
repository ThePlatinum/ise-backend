@component('mail::message')
# Welcome to ISE

{{ $user->firstname }}, welcome to ISE!

Your account has been fully verified.
We are glad to have you on board. You can now start using our platform to the fullest.

- Get Jobs from the best companies
- Get Hired by the best companies
- Establish your career

@component('mail::button', ['url' => env('APP_URL')])
Get Started
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
