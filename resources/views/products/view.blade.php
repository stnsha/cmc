<x-admin-layout>
    <div class="text-lg font-bold text-secondary mb-6">Products</div>
    <div class="flex justify-start mb-4">
        <a href="{{ route('product.create') }}" type="button"
            class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">Create
            venue</a>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                <tr class="bg-white border-b justify-center items-center">
                    @foreach ($venues as $item)
                    <td class="px-2 py-3 text-end">{{ $loop->iteration }}.</td>
                    <td class="px-2 py-3">{{ $item->venue }}</td>
                    <td class="py-3">
                        <div class="flex flex-col">
                            <span>Full capacity: {{ $item->capacity->capacity }}</span>
                        </div>
                    </td>
                    @endforeach
                    <td class="py-3">
                        <div class="flex flex-col items-start">
                            @foreach ($pricings as $item)
                            <div class="inline-flex">
                                <span class="text-sm font-normal text-gray-500 mr-2">{{ $item->type }}:</span>
                                <span class="text-sm font-normal text-gray-500">RM {{ number_format($item->price, 2)
                                    }}</span>
                            </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="py-3 justify-center items-center content-center">
                        <div class="flex flex-col w-1/2 text-center">
                            <a href="" type="button"
                                class="bg-medium-gray text-white px-2.5 py-2.5 text-sm font-normal rounded-xl mb-3">Update
                                venue</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-admin-layout>