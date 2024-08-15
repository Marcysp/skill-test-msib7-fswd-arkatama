<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


    </head>
    <body class="font-sans antialiased ">
        <section class="home-section bg-slate-100 overflow-y-auto">
            <div class="z-10 relative min-h-full" id="tumpukan">
                @yield('content')
            </div>
        </section>
    </body>
</html>
