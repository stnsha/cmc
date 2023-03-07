<x-admin-layout>
    <div class="text-lg font-bold text-secondary mb-6">Products</div>
    <div class="flex justify-start mb-4">
        <a href="{{ route('product.create') }}" type="button"
            class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">Create
            venue</a>
    </div>
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
                    <th></th>
                    <th scope="col" class="px-6 py-3">
                        Venue
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Capacity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Pricing
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($venues as $item)

                <tr class="bg-white border-b justify-center items-center">
                    <td class="px-2 py-3 text-end">{{ $loop->iteration }}.</td>
                    <td class="px-2 py-3">{{ $item->venue_name.', '.$item->venue_location }}</td>
                    <td class="py-3">
                        <a href="{{ route('capacity.view_venue_capacity', ['venue_id' => $item->id]) }}"
                            class="bg-medium-gray text-white px-2.5 py-2.5 text-sm font-normal rounded-xl mb-3">View
                            current capacity</a>
                    </td>
                    <td class="py-3">
                        <div class="flex flex-col items-start">
                            @foreach ($pricings as $price)
                            <div class="inline-flex">
                                <span class="text-sm font-normal text-gray-500 mr-2">{{ $price->type }}:</span>
                                <span class="text-sm font-normal text-gray-500">RM {{ number_format($price->price, 2)
                                    }}</span>
                            </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="py-3 justify-center items-center content-center">
                        <div class="flex flex-col w-1/2 text-center">
                            <a href="{{ route('product.update', ['id' => $item->id]) }}" type="button"
                                class="bg-medium-gray text-white px-2.5 py-2.5 text-sm font-normal rounded-xl mb-3">Update
                                venue</a>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</x-admin-layout>