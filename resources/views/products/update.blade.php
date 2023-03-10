<x-admin-layout>
    <div class="text-lg font-bold text-secondary mb-6">Update venue</div>
    <div class="flex w-full">
        <form action="{{ route('product.update_venue', ['id' => $venue->id]) }}" method="post">
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
                <label for="Venue" class="mx-4 w-2/5">Venue Name</label>
                <input type="text" name="venue_name"
                    value="{{ $venue->venue_name ? $venue->venue_name : old('venue_name') }}"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Venue Location</label>
                <input type="text" name="venue_location"
                    value="{{ $venue->venue_location ? $venue->venue_location: old('venue_location') }}"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Date Start</label>
                <input type="datetime-local" name="date_start"
                    value="{{ $venue->date_start ? $venue->date_start : old('date_start') }}"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Date End</label>
                <input type="datetime-local" name="date_end"
                    value="{{ $venue->date_end ? $venue->date_end  : old('date_end') }}"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>
            {{-- <div class="flex w-full inline-flex items-center my-2">
                <label for="capacity" class="mx-4 w-2/5">Capacity per day</label>
                <input type="text" name="capacity"
                    value="{{ $venue->capacity->max_capacity ? $venue->capacity->max_capacity : old('capacity') }}"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="capacity" class="mx-4 w-2/5">Status</label>
                <select name="status"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                    <option value="Available" {{ $venue->capacity->status == 'Available' ? 'selected' : '' }}>Available
                    </option>
                    <option value="Low in stock" {{ $venue->capacity->status == 'Low in stock' ? 'selected' : '' }}>Low
                        in
                        stock</option>
                    <option value="Sold out" {{ $venue->capacity->status == 'Sold out' ? 'selected' : '' }}>Sold out
                    </option>
                </select>
            </div> --}}
            @if (count($pricings) == 0)
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Pricing" class="mx-4 w-full font-bold">Pricing list</label>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="adult" class="mx-4 w-2/5">Adult</label>
                <input type="text" name="type[Adult][]"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="adult" class="mx-4 w-2/5">Elderly & kids</label>
                <input type="text" name="type[Elderly & kids][]"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="adult" class="mx-4 w-2/5">Group</label>
                <input type="text" name="type[Group][]"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>
            @endif

            <div class="flex justify-end w-full inline-flex items-center my-2">
                <a href="{{ route('product.view') }}" class="font-normal text-secondary test-base mx-2 underline:hover">Back</a>
                <button
                    class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">Submit</button>
            </div>
        </form>
    </div>
</x-admin-layout>