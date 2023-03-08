<x-guest-layout>
    <div class="flex flex-col sm:flex-row m-4 sm:m-[35px]">
        <div class="flex flex-col justify-center items-center w-full bg-blue-100">
            <div class="flex flex-row mx-4">
                <img src="{{ asset('img/arena.jpg') }}" class="max-w-1/2 h-auto">
            </div>
            <div class="flex flex-col justify-center items-center">
                <span class="text-2xl font-bold text-center my-4">Dewan Arena CMC, Ujong Pasir</span>
                <a href="{{ route('order_form') }}" type="button"
                    class="bg-brown-cream hover:bg-light-brown rounded-md text-slate-200 font-medium text-base text-center p-4 w-[200px]">Tempah
                    sekarang</a>
            </div>

        </div>
        <div class="w-full bg-red-100">
            <div class="flex flex-row mx-4">
                <img src="{{ asset('img/abc1.jpg') }}" class="max-w-1/2 h-auto">
            </div>
        </div>
    </div>
</x-guest-layout>