<x-admin-layout>
    <div class="text-lg font-bold text-secondary mb-6">Order #{{ $order->id }}</div>
    <div class="flex w-full">
        <form action="{{ route('orders.view', ['order_id' => $order->id]) }}" method="post">
            @csrf
            @method('put')
            @if(session()->has('success'))
            <div class="bg-green-100 text-sm font-normal border rounded-md border-green-400 text-green-700 px-4 py-3">
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
                <label for="Venue" class="mx-4 w-2/5">Customer Name</label>
                <input type="text" name="customer_name"
                    value="{{ $order->customer_name ? $order->customer_name : old('customer_name') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Customer Phone no.</label>
                <input type="text" name="customer_phone"
                    value="{{ $order->customer_phone ? $order->customer_phone : old('customer_phone') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Customer email</label>
                <input type="text" name="customer_email"
                    value="{{ $order->customer_email ? $order->customer_email : old('customer_email') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Venue</label>
                <input type="text" name="customer_venue"
                    value="{{ $order->capacities ? $order->capacities->venue->venue_name: old('customer_venue') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Date</label>
                <input type="datetime-local" name="date_chosen"
                    value="{{ $order->date_chosen ? $order->date_chosen : old('date_chosen') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Total payment</label>
                <input type="text" name="total"
                    value="{{ $order->total ? number_format((float)$order->total, 2, '.', ''): old('total') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Payment status</label>
                <input type="text" name="status" value="{{ $order->status ? $order->status : old('status') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <div class="flex w-full inline-flex items-center my-2">
                    <label for="Pricing" class="mx-4 w-full font-bold text-center">Order details</label>
                </div>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <div class="flex w-full inline-flex items-center my-2">
                    <label for="Pricing" class="mx-4 w-1/3 font-bold">Customer type</label>
                    <label for="Pricing" class="mx-4 w-1/3 font-bold">Price</label>
                    <label for="Pricing" class="mx-4 w-1/3 font-bold">Quantity</label>
                </div>

            </div>
            @foreach ($order->order_details as $item)
            <div class="flex w-full inline-flex items-center my-2">
                <label for="price" class="mx-4 w-1/3">{{ $item->pricing->description }}</label>
                <input type="text" name="price"
                    value="{{ $item->price ? 'RM '. number_format((float)$item->price, 2, '.', '') : old('price') }}"
                    class="bg-gray-200 w-1/3 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mx-2"
                    required readonly>
                <input type="text" name="quantity" value="{{ $item->quantity ? $item->quantity : old('quantity') }}"
                    class="bg-gray-200 w-1/3 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mx-2"
                    required readonly>
            </div>
            @endforeach
            <div class="flex justify-end w-full inline-flex items-center my-2">
                <a href="{{ route('orders.view') }}"
                    class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">Back</a>
                {{-- <button
                    class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">Submit</button>--}}
            </div>
        </form>
    </div>
</x-admin-layout>