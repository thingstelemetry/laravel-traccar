@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ "{$title} - Laravel Traccar Demo App" }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-clifford: #da373d;
        }
        :root {
            --color-base-100: oklch(0.958 0 89.876);
        }
        .shiki {
            border-radius: 1rem;
            padding: 1rem;
        }
    </style>
</head>
<body class="min-h-dvh bg-base-100">
<div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex">
        <div class="h-full w-full p-6 mx-auto max-w-screen-md flex flex-col gap-4">
            <h1 class="text-4xl">{{ $title }}</h1>
            {{ $slot }}
        </div>
        <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden fixed bottom-4 right-4">
            MENU
        </label>
    </div>
    <div class="drawer-side">
        <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4">
            <!-- Sidebar content here -->
            <li><a href="{{ route('home') }}">Home</a></li>
            <li>
                <h2 class="menu-title">Server</h2>
                <ul>
                    <li><a href="{{ route('server.get-information') }}">Get Information</a></li>
                    <li><a>Update Information</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</body>
</html>
