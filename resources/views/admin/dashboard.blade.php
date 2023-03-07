<x-admin-layout>
    <div class="flex text-lg font-bold text-secondary mb-6">Admin Dashboard</div>
    <div class="flex flex-col sm:flex-row mb-4 justify-center">
        <div class="flex flex-col sm:flex-row bg-blue-200 mb-4 mx-4 w-[1/3] rounded-lg">
            <div class="flex flex-col m-6">
                <span class="text-4xl text-gray-900 font-bold">{{ $total_order }}</span>
                <span class="text-lg text-gray-800 font-bold">Total Orders</span>
                <span class="text-md font-normal text-gray-700">As of {{ date('d F Y h:i:s A') }}</span>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row bg-green-200 mb-4 mx-4 w-[1/3] rounded-lg">
            <div class="flex flex-col m-6">
                <span class="text-4xl text-gray-900 font-bold">RM {{ $total_sales }}</span>
                <span class="text-lg text-gray-800 font-bold">Total Sales</span>
                <span class="text-md font-normal text-gray-700">As of {{ date('d F Y h:i:s A') }}</span>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row bg-yellow-200 mb-4 mx-4 w-[1/3] rounded-lg">
            <div class="flex flex-col m-6">
                <span class="text-4xl text-gray-900 font-bold">{{ $total_customers }}</span>
                <span class="text-lg text-gray-800 font-bold">Total Customers</span>
                <span class="text-md font-normal text-gray-700">As of {{ date('d F Y h:i:s A') }}</span>
            </div>
        </div>
    </div>
</x-admin-layout>