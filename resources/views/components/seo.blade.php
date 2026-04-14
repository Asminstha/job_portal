@props([
    'title'       => config('app.name') . ' — Find Jobs in Nepal',
    'description' => 'JobsNepal is Nepal\'s modern job portal. Find thousands of jobs from top companies. Free for job seekers.',
    'image'       => null,
    'url'         => null,
    'type'        => 'website',
    'noindex'     => false,
])

@php
    $url   = $url   ?? request()->url();
    $image = $image ?? asset('images/og-default.png');
@endphp

{{-- Basic --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ Str::limit(strip_tags($description), 160) }}">
<meta name="robots" content="{{ $noindex ? 'noindex,nofollow' : 'index,follow' }}">
<link rel="canonical" href="{{ $url }}">

{{-- Open Graph --}}
<meta property="og:type"        content="{{ $type }}">
<meta property="og:title"       content="{{ $title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($description), 160) }}">
<meta property="og:image"       content="{{ $image }}">
<meta property="og:url"         content="{{ $url }}">
<meta property="og:site_name"   content="{{ config('app.name') }}">
<meta property="og:locale"      content="en_NP">

{{-- Twitter Card --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $title }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($description), 160) }}">
<meta name="twitter:image"       content="{{ $image }}">

{{-- Extra --}}
<meta name="theme-color" content="#2563eb">
<meta name="author"      content="JobsNepal">
