<x-guest-layout>
    <div class="flex flex-col m-4 sm:m-[35px]">
        <ol class="flex justify-center items-center w-full text-sm font-medium  text-gray-500 sm:text-base">
            <li
                class="flex md:w-full items-center sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                <span
                    class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:font-light after:text-gray-200">
                    <span class="mr-2">1</span>
                    Order <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                </span>
            </li>

            <li
                class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                <span
                    class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:font-light after:text-gray-200">
                    <span class="mr-2">2</span>
                    Customer <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                </span>
            </li>
            <li class="flex items-center">
                <span
                    class="flex items-center text-brown-cream after:content-['/'] sm:after:hidden after:mx-2 after:font-light after:text-gray-200">

                    <svg aria-hidden="true" class="w-4 h-4 mr-2 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Payment <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                </span>
            </li>
        </ol>
        <div class="flex flex-row">
            <div class="flex flex-col w-full mt-16 bg-secondary-100">
                <span class="text-2xl font-bold text-center text-gray-900 my-8">Order summary</span>
                <div
                    class="flex flex-row relative overflow-x-auto w-full justify-center items-center0 mx-auto rounded-lg">
                    <table class="h-full mx-12">
                        <thead>
                            <tr class="border-b whitespace-normal">
                                <th class="text-md font-bold text-gray-700 pl-2 sm:px-8 sm:py-4">Customer type</th>
                                <th class="text-md font-bold text-gray-700 pl-2 sm:px-8 sm:py-4">Price</th>
                                <th class="text-md font-bold text-gray-700 pl-2 sm:px-8 sm:py-4">Quantity</th>
                                <th class="text-md font-bold text-gray-700 pl-2 sm:px-8 sm:py-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="whitespace-normal">
                            @foreach ($order->order_details as $item)
                            <tr class="border-b">
                                <td class="text-md font-normal text-gray-900 pl-2 sm:px-8 sm:py-4">{{ $item->pricing->type }}
                                </td>
                                <td class="text-md font-normal text-gray-900 pl-2 sm:px-8 sm:py-4">RM {{
                                    number_format($item->pricing->price,
                                    2)
                                    }}</td>
                                <td class="text-md font-normal text-gray-900 pl-2 sm:px-8 sm:py-4">{{ $item->quantity }}</td>
                                <td class="text-md font-normal text-gray-900 pl-2 sm:px-8 sm:py-4">RM {{
                                    number_format($item->subtotal,
                                    2)
                                    }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="3" class="text-right">Subtotal</th>
                                <td colspan="0" class="pl-2 sm:px-8">RM {{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">Service charge</th>
                                <td class="pl-2 sm:px-8">RM {{ number_format($order->service_charge, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <td class="pl-2 sm:px-8">RM {{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col justify-center items-center my-8">
                    <a href="{{ route('edit_order', ['order_id' => $order->id]) }}"
                        class="text-sm font-bold text-secondary hover:underline">Have changes? Click here to edit your
                        order</a>
                    <a href="{{ route('submit_payment', ['order_id' => $order->id]) }}" type="button"
                        class="bg-brown-cream hover:bg-light-brown m-2 rounded-md text-slate-200 font-medium text-base text-center mt-2 p-4">Proceed
                        to payment</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>