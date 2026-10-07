<body class="font-sans antialiased bg-gray-50 text-sky-500">

    <div class="min-h-screen bg-gray-50">

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="text-sky-500">

            {{ $slot ?? '' }}

            @yield('content')

        </main>

    </div>

</body>