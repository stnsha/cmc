<x-guest-layout>
    <section class="bg-cover bg-scroll" style="background-image: url('img/img2.jpg');">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            {{-- <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-secondary">
                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg"
                    alt="logo">
                Flowbite
            </a> --}}
            <div class="w-full bg-light-gray rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-secondary md:text-2xl">
                        Register now
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ route('auth.signup') }}" method="post">
                        @csrf
                        @method('post')
                        @if ($errors->any())
                        <div class="bg-red-100 border rounded-md border-red-400 text-red-700 px-4 py-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-secondary">
                                Name</label>
                            <input type="name" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-secondary sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-secondary">
                                Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-secondary sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="name@company.com" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-secondary">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-secondary sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required>
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('auth.login') }}"
                                class="text-sm font-medium text-primary-600 hover:underline">Already register?
                                Sign in here</a>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>