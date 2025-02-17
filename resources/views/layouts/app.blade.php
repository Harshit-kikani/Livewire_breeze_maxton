<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-bs-theme="{{ request()->routeIs('admin.*') ? 'blue-theme' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@stack('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    @if (Auth::user()->isAdmin('U'))
        @auth('web')
            @vite(['resources/css/app.css', 'resources/js/app.js'])
            @include('livewire.admin.layout.includes.frontend')
        @endauth
    @else
        @auth('admin')
            @include('livewire.admin.layout.includes.backend')
        @endauth
    @endif
    @stack('extra_css')
</head>

<body class="font-sans antialiased">
    {{-- <div class="min-h-screen bg-gray-100"> --}}
    @if (Auth::user()->isAdmin('U'))
        @auth('web')
            <livewire:layout.navigation />
        @endauth
    @else
        @auth('admin')
            <livewire:Admin.layout.navigation />
        @endauth
    @endif


    <!-- Page Heading -->
    {{-- @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif --}}

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
    {{-- </div> --}}



    @if (Auth::user()->isAdmin('U'))
        @auth('web')
            @include('livewire.admin.layout.includes.frontendjs')
        @endauth
    @else
        @auth('admin')
            @include('livewire.admin.layout.includes.backendjs')
        @endauth
    @endif
    @stack('script')

</body>

</html>
