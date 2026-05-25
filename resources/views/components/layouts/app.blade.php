<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100">
    
    <div class="flex min-h-screen">
        @include('layouts.app.sidebar')

        <main class="flex-1 p-8">
            @include('partials.main-content-alerts')
            
            {{ $slot }} 
        </main>
    </div>

    @fluxScripts
</body>
</html>