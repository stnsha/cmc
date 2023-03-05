<x-guest-layout>
    <div class="flex flex-col m-4 sm:m-[35px]">
        <ol class="flex justify-center items-center w-full text-sm font-medium text-center text-gray-500 sm:text-base">
            <li
                class="flex md:w-full items-center sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                <span
                    class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:font-light after:text-gray-200">
                    <span class="mr-2">1</span>
                    Order <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                </span>
            </li>

            <li
                class="flex md:w-full items-center text-brown-cream after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                <span
                    class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:font-light after:text-gray-200">

                    <svg aria-hidden="true" class="w-4 h-4 mr-2 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Customers <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                </span>
            </li>
            <li class="flex items-center">
                <span class="mr-2">3</span>
                Confirmation
            </li>
        </ol>

        <div class="flex flex-row">
            <div class="flex m-4 sm:mx-[150px] sm:py-32">
                <form action="{{ route('submit_details') }}" method="post">
                    @csrf
                    @method('post')
                    @if(session()->has('success'))
                    <div
                        class="bg-green-100 text-sm font-normal border rounded-md border-green-400 text-green-700 px-4 py-3">
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    @if(session()->has('fail'))
                    <div class="bg-red-100 text-sm font-normal border rounded-md border-red-400 text-red-700 px-4 py-3">
                        {{ session()->get('fail') }}
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="bg-red-100 text-sm font-normal border rounded-md border-red-400 text-red-700 px-4 py-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="flex w-full inline-flex items-center my-2">
                        <label for="Venue" class="mx-4 w-2/5">Venue & date</label>
                        <input type="text" name="venue_date" value="{{ $venue_date }}"
                            class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            readonly required>
                    </div>
                    @if (count(session()->get('venue_details')[2]) != 0)
                    <div class="flex w-full inline-flex items-center my-2">
                        <label for="Adults" class="mx-4 w-2/5">Adults</label>
                        <label for="Adults" class="w-3/5">{{ session()->get('venue_details')[2]['quantity'] }}
                            pax</label>
                    </div>
                    @endif
                    @if (count(session()->get('venue_details')[3]) != 0)
                    <div class="flex w-full inline-flex items-center my-2">
                        <label for="Adults" class="mx-4 w-2/5">Elderly & kids</label>
                        <label for="Adults" class="w-3/5">{{ session()->get('venue_details')[3]['quantity'] }}
                            pax</label>
                    </div>
                    @endif
                    @if (count(session()->get('venue_details')[4]) != 0)
                    <div class="flex w-full inline-flex items-center my-2">
                        <label for="Adults" class="mx-4 w-2/5">Group</label>
                        <label for="Adults" class="w-3/5">{{ session()->get('venue_details')[4]['quantity'] }}
                            pax</label>
                    </div>
                    @endif
                    <div class="flex w-full inline-flex items-center my-2">
                        <label for="Pricing" class="mx-4 w-2/5 font-bold">Customer details</label>
                        <label for="Adults" class="w-3/5">Total: {{ session()->get('venue_details')[1] }} pax</label>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2">
                        <label for="Adults" class="mx-4 w-2/5">Your name</label>
                        <input type="text" name="customer_name"
                            value="{{ session()->get('venue_details')[0]['customer_name'] }}"
                            class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2">
                        <label for="Adults" class="mx-4 w-2/5">Your email</label>
                        <input type="text" name="customer_email"
                            value="{{ session()->get('venue_details')[0]['customer_email'] }}"
                            class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2">
                        <label for="Adults" class="mx-4 w-2/5">Phone no.</label>
                        <input type="text" name="customer_phone"
                            value="{{ session()->get('venue_details')[0]['customer_phone'] }}"
                            class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                    @for ($i = 1; $i < session()->get('venue_details')[1]; $i++)
                        <div class="flex w-full inline-flex items-center my-2">
                            <label for="Adults" class="mx-4 w-2/5">Customer name</label>
                            <input type="text" name="customer_details[]"
                                class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="flex w-full inline-flex items-center my-2">
                            <label for="Adults" class="mx-4 w-2/5">Phone no.</label>
                            <input type="text" name="customer_details[]"
                                class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        @endfor
                        <div class="flex justify-end w-full inline-flex items-center my-2">
                            <button
                                class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">Next</button>
                        </div>
                </form>
            </div>
            <div class="flex flex-row hidden sm:block">
                <img src="{{ asset('img/abc1.jpg') }}" alt="" class="max-w-full h-auto">
            </div>
        </div>

    </div>
</x-guest-layout>