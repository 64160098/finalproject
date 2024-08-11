@php
    use Carbon\Carbon;
    $currentDate = Carbon::now()->locale('th')->isoFormat('วันddddที่ D MMMM YYYY');
    $currentMonth = Carbon::now()->locale('th')->isoFormat('MMMM');
@endphp
<style>
.custom-blue-box {
background-color: #FFC0CB; /* เปลี่ยนเป็นสีเขียวตามต้องการ */
padding: 10px;
border-radius: 8px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
} 
</style>
<x-appsuperadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('หน้าหลัก SuperAdmin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>{{ __("สวัสดีคุณ") }} <strong>{{ auth()->user()->name }}</strong> ,{{ $currentDate }}</p>

                    <div class="flex flex-row gap-6 mt-8">
                        <div class="custom-blue-box overflow-hidden shadow-sm sm:rounded-lg border border-black">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">จำนวนบัญชีผู้ใช้</h3>
                                <p style="font-size: 2em;">{{ $userCount }}</p>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-appsuperadmin-layout>
