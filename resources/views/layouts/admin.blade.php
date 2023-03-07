<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('dist/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/all.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <title>Admin Dashboard</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!--Container -->
    <div class="mx-auto bg-grey-400">
        <!--Screen-->
        <div class="min-h-screen flex flex-col">
            <!--Header Section Starts Here-->
            <header class="bg-slate-200">
                <div class="flex justify-between">
                    <div class="p-1 mx-3 inline-flex items-center">
                        <i class="fas fa-bars pr-2 text-gray-900" onclick="sidebarToggle()"></i>
                        <h1 class="text-gray-900 p-2">Cahya Mata Catering</h1>
                    </div>
                </div>
            </header>
            <!--/Header-->

            <div class="flex flex-1">
                <!--Sidebar-->
                <aside id="sidebar"
                    class="bg-side-nav w-1/2 md:w-1/6 lg:w-1/6 border-r border-side-nav hidden md:block lg:block">
                    <ul class="list-reset flex flex-col">
                        <li class=" w-full h-full py-3 px-2 border-b border-light-border bg-white">
                            <a href="{{ route('admin.dashboard') }}"
                                class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                                <i class="fas fa-tachometer-alt mx-2"></i>
                                Dashboard
                                <span><i class="fas fa-angle-right float-right"></i></span>
                            </a>
                        </li>
                        <li class="w-full h-full py-3 px-2 border-b border-light-border">
                            <a href="{{ route('product.view') }}"
                                class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                                <i class="fa-solid fa-building mx-2"></i>
                                Venues & Capacity
                                <span><i class="fa fa-angle-right float-right"></i></span>
                            </a>
                        </li>
                        <li class="w-full h-full py-3 px-2 border-b border-light-border">
                            <a href="{{ route('orders.view') }}"
                                class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                                <i class="fa-solid fa-cart-shopping mx-2"></i>
                                Orders
                                <span><i class="fa fa-angle-right float-right"></i></span>
                            </a>
                        </li>
                        <li class="w-full h-full py-3 px-2 border-b border-light-border">
                            <a href="{{ route('customers.view') }}"
                                class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                                <i class="fa-solid fa-user mx-2"></i>
                                Customers
                                <span><i class="fa fa-angle-right float-right"></i></span>
                            </a>
                        </li>
                        <li class="w-full h-full py-3 px-2 border-b border-light-border">
                            <a href="#"
                                class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                                <i class="fa-solid fa-file mx-2"></i>
                                Reports
                                <span><i class="fa fa-angle-right float-right"></i></span>
                            </a>
                        </li>
                        <li class="w-full h-full py-3 px-2 border-b border-300-border">
                            <a href="{{ route('auth.logout') }}"
                                class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                                <i class="fa-solid fa-right-from-bracket mx-2"></i>
                                Logout
                                <span><i class="fa fa-angle-right float-right"></i></span>
                            </a>
                        </li>
                    </ul>

                </aside>
                <!--/Sidebar-->
                <!--Main-->
                <main class="bg-white-300 flex-1 p-3 overflow-hidden">
                    {{ $slot }}
                </main>
                <!--/Main-->
            </div>

        </div>

    </div>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>