@props(['title' => 'Masuk'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $title }} | CMS {{ setting('nama_singkat', 'BPKPD') }}</title>
    <link rel="icon" href="{{ media(setting('logo'), asset('favicon.svg')) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-ink font-sans">
    {{ $slot }}
    @livewireScripts
</body>
</html>
