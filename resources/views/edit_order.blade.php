<x-guest-layout>
    <div class="flex flex-col sm:m-[35px]">
        <ol
            class="flex justify-center items-center w-full text-sm font-normal font-medium text-center text-gray-500 sm:text-base">
            <li
                class="flex md:w-full items-center text-brown-cream sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                <span
                    class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:font-light after:text-gray-200">
                    <svg aria-hidden="true" class="w-4 h-4 mr-2 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Order <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                </span>
            </li>

            <li
                class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                <span
                    class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:font-light after:text-gray-200">
                    <span class="mr-2">2</span>
                    Customers <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                </span>
            </li>
            <li class="flex items-center">
                <span class="mr-2">3</span>
                Confirmation
            </li>
        </ol>
        <div class="flex flex-col sm:flex-row">
            <div>
                <img src="{{ asset('img/arena.jpg') }}" class="max-w-full h-auto">
            </div>
            <div class="flex flex-col justify-center items-center mx-0 sm:mx-[50px]">
                <span class="text-2xl font-bold text-center sm:mb-4">Dewan Arena CMC, Ujong Pasir</span>
                <form action="{{ route('update_order', ['order_id' => $order->id]) }}" method="post">
                    @csrf
                    @method('put')
                    @if(session()->has('success'))
                    <div
                        class="bg-green-100 text-sm font-normal font-normal border rounded-md border-green-400 text-green-700 px-4 py-3">
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    @if(session()->has('fail'))
                    <div
                        class="bg-red-100 text-sm font-normal font-normal border rounded-md border-red-400 text-red-700 px-4 py-3">
                        {{ session()->get('fail') }}
                    </div>
                    @endif
                    @if ($errors->any())
                    <div
                        class="bg-red-100 text-sm font-normal font-normal border rounded-md border-red-400 text-red-700 px-4 py-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="flex w-full inline-flex items-center my-2 border-b">
                        <label for="Adults" class="mx-4 w-1/2">Tempat Pilihan</label>
                        <div class="flex flex-col w-1/2">
                            <span class="text-sm font-normal text-gray-900">{{ $venue->venue_name.',
                                '.$venue->venue_location
                                }}</span>
                            <a href="" class="text-sm font-normal text-brown-cream hover:underline">Tukar tempat</a>
                        </div>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2 border-b">
                        <label for="Venue" class="mx-4 w-1/2">Choose date</label>
                        <select name="venue"
                            class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm font-normal rounded-lg mb-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                            @foreach ($capacities as $item)
                            <option value="{{ $item->id }}" {{ $item->status == 'Sold out' ? 'disabled' : '' }} {{
                                $order->capacity_id == $item->id ? 'selected' : '' }}>{{
                                date('d-m-Y l', strtotime($item->venue_date)).' -
                                '.$item->status}}
                            </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2 border-b">
                        <label for="Adults" class="mx-4 w-1/2">Nama anda</label>
                        <input type="text" name="customer_name" value="{{ $order->customer_name }}"
                            class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm font-normal rounded-lg mb-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2 border-b">
                        <label for="Adults" class="mx-4 w-1/2">Email<span class="text-sm text-red-500">*</span></label>
                        <input type="text" name="customer_email" value="{{ $order->customer_email }}"
                            class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm font-normal rounded-lg mb-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2 border-b">
                        <label for="Adults" class="mx-4 w-1/2">Phone no.</label>
                        <input type="text" name="customer_phone" value="{{ $order->customer_phone }}"
                            class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm font-normal rounded-lg mb-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>

                    <div class="flex w-full inline-flex items-center my-2 border-b">
                        <label for="Pricing" class="mx-4 w-full font-bold text-center sm:text-left">No. of pax</label>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2 border-b">
                        <label for="adult" class="mx-4 w-1/2">Dewasa (RM 65.00)</label>
                        <select name="adults"
                            class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm font-normal rounded-lg mb-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                            @foreach (range(0, 29) as $number) {
                            <option value="{{ $number }}" {{ $number==$adults ? 'selected' : '' }}>{{ $number }}
                            </option>
                            }
                            @endforeach
                        </select>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2"><label for="adult" class="mx-4 w-1/2">Warga
                            emas & Kanak-kanak (RM 39.00)</label>
                        <select name="kids_elderly"
                            class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm font-normal rounded-lg mb-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                            @foreach (range(0, 29) as $number) {
                            <option value="{{ $number }}" {{ $number==$kids_elderly ? 'selected' : '' }}>{{ $number }}
                            </option>
                            }
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col mx-4 border-b">
                        <span class="text-sm font-normal font-normal text-red-500">*Warga emas berumur 60 tahun ke
                            atas</span>
                        <span class="text-sm font-normal font-normal text-red-500">*6 - 12
                            tahun
                            bagi
                            kanak-kanak</span>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2 border-b"><label for="adult"
                            class="mx-4 w-1/2">Kanak-kanak bawah 5 tahun - Tanpa kerusi (Free)</label>
                        <select name="kids_free"
                            class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm font-normal rounded-lg mb-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                            @foreach (range(0, 29) as $number) {
                            <option value="{{ $number }}" {{ $number==$kids_free ? 'selected' : '' }}>{{ $number }}
                            </option>
                            }
                            @endforeach
                        </select>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2 border-b"><label for="adult"
                            class="mx-4 w-1/2">Kanak-kanak bawah 5 tahun -
                            Kerusi diperlukan (RM 10)</label>
                        <select name="kids_pay"
                            class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm font-normal rounded-lg mb-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                            @foreach (range(0, 29) as $number) {
                            <option value="{{ $number }}" {{ $number==$kids_pay ? 'selected' : '' }}>{{ $number }}
                            </option>
                            }
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col mx-4">
                        <span class="text-sm font-normal font-normal text-red-500">*Dewasa sahaja</span>
                        <span class="text-sm font-normal font-normal text-red-500">*Tidak termasuk warga
                            emas/kanak-kanak</span>
                        <span class="text-sm font-normal font-normal text-red-500">*Minimum 30 orang satu
                            kumpulan</span>
                    </div>
                    <div class="flex w-full inline-flex items-center my-2 border-b">
                        <label for="adult" class="mx-4 w-1/2">Group (RM 59.00)</label>
                        <select name="group"
                            class="bg-gray-50 w-1/2 border border-gray-300 text-gray-900 text-sm font-normal rounded-lg mb-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                            <option value="0" selected>0</option>
                            @foreach (range(30, 100) as $number) {
                            <option value="{{ $number }}" {{ $number==$group ? 'selected' : '' }}>{{ $number }}</option>
                            }
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end w-full inline-flex items-center my-2">
                        <button
                            class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg mb-2 text-sm font-normal px-5 py-2.5 text-center mr-3 md:mr-0">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>