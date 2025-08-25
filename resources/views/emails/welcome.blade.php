<x-mail::message>
# Welcome, {{ $user->name }}

Thanks for joining our platform. We’re excited to have you!

<x-mail::button :url="$verificationUrl">
Verify Your Email
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
