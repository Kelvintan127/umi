@component('mail::message')
# {{ $inquiry->name }}@if ($inquiry->company) — {{ $inquiry->company }}@endif

{{ $body }}

@component('mail::table')
| | |
|---|---|
| **Email** | {{ $inquiry->email }} |
| **Phone** | {{ $inquiry->phone ?: '—' }} |
| **Inquiry type** | {{ $inquiry->inquiry_type }} |
| **Locale** | {{ $inquiry->locale }} |
| **Received** | {{ $inquiry->created_at->toDateTimeString() }} (UTC) |
@endcomponent

**Project details**

{{ $inquiry->message }}

@endcomponent
