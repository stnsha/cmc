<x-admin-layout>
    <div class="text-lg font-bold text-secondary mb-6">Update capacity</div>
    <div class="flex w-full">
        <form action="{{ route('capacity.update_capacity', ['id' => $capacity->id]) }}" method="post">
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
                    value="{{ $capacity->venue->venue_name ? $capacity->venue->venue_name : old('venue_name') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Venue Location</label>
                <input type="text" name="venue_location"
                    value="{{ $capacity->venue->venue_location ? $capacity->venue->venue_location: old('venue_location') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Date Start</label>
                <input type="datetime-local" name="date_start"
                    value="{{ $capacity->venue->date_start ? $capacity->venue->date_start : old('date_start') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Date End</label>
                <input type="datetime-local" name="date_end"
                    value="{{ $capacity->venue->date_end ? $capacity->venue->date_end  : old('date_end') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5"> Current Capacity</label>
                <input type="text" name="current_capacity"
                    value="{{ $capacity->current_capacity ? $capacity->current_capacity : old('current_capacity') }}"
                    class="bg-gray-200 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="Venue" class="mx-4 w-2/5">Maximum Capacity</label>
                <input type="text" name="max_capacity"
                    value="{{ $capacity->max_capacity ? $capacity->max_capacity : old('max_capacity') }}"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="capacity" class="mx-4 w-2/5">Status</label>
                <select name="status"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
                    <option value="Available" {{ $capacity->status == 'Available' ? 'selected' : '' }}>Available
                    </option>
                    <option value="Low in stock" {{ $capacity->status == 'Low in stock' ? 'selected' : '' }}>Low
                        in
                        stock</option>
                    <option value="Sold out" {{ $capacity->status == 'Sold out' ? 'selected' : '' }}>Sold out
                    </option>
                </select>
            </div>
            {{-- <div class="flex w-full inline-flex items-center my-2">
                <label for="capacity" class="mx-4 w-2/5">Capacity per day</label>
                <input type="text" name="capacity"
                    value="{{ $capacity->venue->capacity->max_capacity ? $capacity->venue->capacity->max_capacity : old('capacity') }}"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
            </div>
            <div class="flex w-full inline-flex items-center my-2">
                <label for="capacity" class="mx-4 w-2/5">Status</label>
                <select name="status"
                    class="bg-gray-50 w-3/5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required readonly>
                    <option value="Available" {{ $capacity->venue->capacity->status == 'Available' ? 'selected' : ''
                        }}>Available
                    </option>
                    <option value="Low in stock" {{ $capacity->venue->capacity->status == 'Low in stock' ? 'selected' :
                        '' }}>Low
                        in
                        stock</option>
                    <option value="Sold out" {{ $capacity->venue->capacity->status == 'Sold out' ? 'selected' : ''
                        }}>Sold out
                    </option>
                </select>
            </div> --}}

            <div class="flex justify-end w-full inline-flex items-center my-2">
                <a href="{{ route('capacity.view_venue_capacity', ['venue_id' => $capacity->venue_id]) }}"
                    class="font-normal text-secondary test-base mx-2 underline:hover">Back</a>
                <button
                    class="text-white bg-brown-cream hover:bg-light-brown focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-3 md:mr-0">Submit</button>
            </div>
        </form>
    </div>
</x-admin-layout>