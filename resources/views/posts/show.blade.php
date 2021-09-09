<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Locale test</title>

  <style>
    html, body {
      font-size: 16px;
      font-family: sans-serif;
    }
  </style>
</head>
<body>
<h1>Current locale: {{ app()->getLocale() }} | Post slug: {{ request()->route('post') }}</h1>

<nav>
  <ul>
    @foreach(config()->get('app.allowed_locales') as $locale)
      <li>
        <a href="{{ __route(request()->route()->getName(), request()->route()->parameters(), locale: $locale) }}">
          Go to {{ $locale }} locale
        </a>
      </li>
    @endforeach
    <li>
      <a href="{{ __route('root') }}">
        Back to root
      </a>
    </li>
  </ul>
</nav>
</body>
</html>
