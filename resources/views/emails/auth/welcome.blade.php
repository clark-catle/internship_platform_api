<x-mail::message>
  # Welcome, {{ $user->name }}!

  Thanks for registering. Your account has been created successfully.

  **Email:** {{ $user->email }}
  **Role:** {{ $user->role->value }}

  <x-mail::button :url="config('app.frontend_url')">
    Go to App
  </x-mail::button>

  Thanks,
  {{ config('app.name') }}
</x-mail::message>