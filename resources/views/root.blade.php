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

    dt {
      font-weight: bold;
    }

    dd + dt {
      margin-top: 2rem;
    }
  </style>
</head>
<body>
<h1>Current locale: {{ app()->getLocale() }}</h1>

<hr>

<nav>
  <p>Link tests</p>
  <ul>
    @foreach(config()->get('app.allowed_locales') as $locale)
      <li>
        <a href="{{ __route(request()->route()->getName(), request()->route()->parameters(), locale: $locale) }}">
          Go to {{ $locale }} locale
        </a>
      </li>
    @endforeach
  </ul>
  <ul>
    @foreach(config()->get('app.allowed_locales') as $locale)
      <li>
        <a href="{{ __route('posts.show', ['post' => 'post-slug'], locale: $locale) }}">
          Go to post.show in {{ $locale }} locale
        </a>
      </li>
    @endforeach
  </ul>
  <ul>
    @foreach(config()->get('app.allowed_locales') as $locale)
      <li>
        <a href="{{ __route('about', locale: $locale) }}">
          About us page
        </a>
      </li>
    @endforeach
  </ul>
</nav>

<hr>

<p><code>__route()</code> examples & trivia :</p>
<dl>
  <dt>Defaulting to current locale</dt>
  <dd><code>__route('root');</code></dd>

  <dt>Using the locale parameter</dt>
  <dd><code>__route('root', locale: 'fr'); // with PHP 8 named arguments</code></dd>
  <dd><code>__route('root', null, null, 'fr');</code></dd>

  <dt>It is smart enough to switch to the correct route name, or use bare route names</dt>
  <dd><code>__route('root', locale: 'fr');</code></dd>
  <dd><code>__route('fr:root', locale: 'fr');</code></dd>
  <dd><code>__route('de:root', locale: 'fr');</code></dd>
  <dd>are all equivalent</dd>

  <dt>It prioritise __route() parameter over current locale</dt>
  <dd>
    <code>app()->setLocale('fr');</code>
    <code>__route('root', locale: 'de'); // will use 'de' locale</code>
  </dd>
</dl>
</body>
</html>
