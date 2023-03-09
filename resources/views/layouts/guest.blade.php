<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <nav class="bg-slate-200 border-gray-200 px-2 sm:px-4 py-2.5 rounded">
            <div class="container flex flex-wrap items-center justify-between mx-auto">
                <a href="https://cahyamatacatering.com/" class="flex items-center">
                    <span class="self-center text-xl font-semibold whitespace-nowrap">Cahya Mata Catering</span>
                </a>
                <button data-collapse-toggle="navbar-default" type="button"
                    class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    aria-controls="navbar-default" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                    <ul
                        class="flex flex-col p-4 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-slate-200">

                        <li>
                            <a href="#"
                                class="block py-2 pl-3 pr-4 text-gray-900 rounded md:bg-transparent md:text-brown-cream mb-4 sm:mb-0 md:p-0"
                                aria-current="page">Halaman Utama</a>
                        </li>
                        @if (auth()->user())
                        <li>
                            <a href="{{ route('admin.dashboard')}}"
                                class="bg-brown-cream hover:bg-light-brown m-2 rounded-md text-slate-200 font-medium text-base mb-4 text-center mt-6 p-4 w-[200px]">Admin
                                dashboard</a>
                        </li>
                        @else

                        <li>
                            <a href="{{ route('venue.view') }}"
                                class="bg-brown-cream hover:bg-light-brown m-2 rounded-md text-slate-200 font-medium text-base mb-4 text-center mt-6 p-4 w-[200px]">Iftar
                                Ramadan 2023</a>
                        </li>
                        @endif


                    </ul>
                </div>
            </div>
        </nav>
        {{ $slot }}
    </div>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
</body>

</html>