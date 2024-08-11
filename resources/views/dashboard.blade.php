@php
    use Carbon\Carbon;
    $currentDate = Carbon::now()->locale('th')->isoFormat('วันddddที่ D MMMM YYYY');
    $currentMonth = Carbon::now()->locale('th')->isoFormat('MMMM');
@endphp
<x-appnormal-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('หน้าหลัก') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>{{ __("สวัสดีคุณ") }} <strong>{{ auth()->user()->name }}</strong> ,{{ $currentDate }}</p>
                </div>
            </div>
        </div>
    </div>
</x-appnormal-layout>
