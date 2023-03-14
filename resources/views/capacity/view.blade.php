<x-admin-layout>
    <div class="text-lg font-bold text-secondary mb-6">Venue Capacity</div>
    <div class="flex justify-start mb-4">
        <a href="{{ route('product.view') }}" type="button"
            class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">View
            other
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
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Maximum Capacity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Current Capacity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($capacities as $item)

                <tr class="bg-white border-b justify-center items-center">
                    <td class="px-2 py-3 text-end">{{ $loop->iteration }}.</td>
                    <td class="px-2 py-3">{{ $item->venue->venue_name.', '.$item->venue->venue_location }}</td>
                    <td class="px-2 py-3">{{ date('d-m-Y l', strtotime($item->venue_date)) }}</td>
                    <td class="px-2 py-3">
                        {{ $item->max_capacity }} <br>
                        Status: {{ $item->status }}
                    </td>
                    <td class="px-2 py-3">
                        {{ $item->current_capacity }}
                    </td>
                    <td class="px-2 py-3 justify-center items-center content-center">
                        <div class="flex flex-col w-1/2 text-center">
                            <a href="{{ route('capacity.update', ['id' => $item->id]) }}" type="button"
                                class="bg-medium-gray text-white px-2.5 py-2.5 text-sm font-normal rounded-xl mb-3">Update
                                capacity</a>
                            <a href="{{ route('capacity.download_excel', ['id' => $item->id]) }}" type="button"
                                class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">Download
                                Excel</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $capacities->links() }}
    </div>
</x-admin-layout>