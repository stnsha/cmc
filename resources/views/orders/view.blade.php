<x-admin-layout>
    <div class="text-lg font-bold text-secondary mb-6">Orders</div>
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
    <div class="relative overflow-x-auto mt-2 shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-start text-gray-500">
            <!-- venue / capacity / pricing -->
            <thead class="text-xs text-white uppercase bg-medium-gray">
                <tr>
                    <th scope="col" class="px-2 py-3">
                        Order ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Customer details
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orders as $item)

                <tr class="bg-white border-b justify-center items-center">
                    <td class="px-2 py-3 font-bold">#{{ $item->id }}</td>
                    <td class="py-3">
                        {{ $item->customer_name }} <br>
                        {{ $item->customer_phone }} <br>
                        {{ $item->customer_email }} <br>
                    </td>
                    <td class="py-3">
                        RM {{ number_format((float)$item->total, 2, '.', '') }}
                    </td>
                    <td class="py-3">
                        {{ $item->status }}
                    </td>
                    <td class="py-3 justify-center items-center content-center">
                        <div class="flex flex-col w-1/2 text-center">
                            <a href="{{ route('orders.view_order', ['order_id' => $item->id]) }}" type="button"
                                class="bg-medium-gray text-white px-2.5 py-2.5 text-sm font-normal rounded-xl mb-3">View
                                order</a>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</x-admin-layout>