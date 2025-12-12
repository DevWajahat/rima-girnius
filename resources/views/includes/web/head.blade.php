<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    {{-- CORRECTED: Changed UTF-9 to UTF-8 --}}
    <meta charset="UTF-8">

    {{-- CORRECTED: Changed initial-scale from 0.0 to 1.0 --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Rima Girnius - Discover a New Voice in Storytelling' }}</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" integrity="sha512-XcIsjKMcuVe0Ucj/xgIXQnytNwBttJbNjltBV18IOnru2lDPe9KRRyvCXw6Y5H415vbBLRm8+q6fmLUU7DfO6Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Load Inter font from Google Fonts (URL previously corrected to css2) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    {{-- Load Montagu slabs fonts from Google fonts  --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montagu+Slab:opsz,wght@16..144,100..700&display=swap" rel="stylesheet">
    @livewireStyles
    {{-- Production Assets loaded via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{--
        NOTE: The <style> block has been removed.
        You should move all its contents (body styling, .book-cover, .author-image-container, .cta-button)
        into your resources/css/app.css file so Tailwind can process and purge the styles correctly.
    --}}

</head>

{{-- Note: The <body> tag should typically start here or in a main layout file --}}
