<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('แก้ไขรายงานยอดขาย') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('dailysale.admindailysales') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>แก้ไขรายงานยอดขาย</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                            <form action="{{ route('dailysale.adminupdate', $admindailysale->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="sale_date" :value="__('วันที่')" />
                                            <x-text-input wire:model="sale_date" id="sale_date"
                                                name="sale_date" value="{{ $admindailysale->sale_date }}" type="date" class="mt-1 block w-full"
                                                required autofocus autocomplete="sale_date" placeholder="หน่วยนับ"/>
                                            @error('sale_date')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="total_earning" :value="__('รายได้ทั้งหมด')" />
                                            <x-text-input wire:model="total_earning" id="total_earning"
                                                name="total_earning" value="{{ $admindailysale->total_earning }}" type="number" class="mt-1 block w-full"
                                                required autofocus autocomplete="total_earning" placeholder="รายได้ทั้งหมด"/>
                                            @error('total_earning')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="Scan_to_pay" :value="__('ยอดโอน')" />
                                            <x-text-input wire:model="Scan_to_pay" id="Scan_to_pay"
                                                name="Scan_to_pay" value="{{ $admindailysale->Scan_to_pay }}" type="number" class="mt-1 block w-full"
                                                required autofocus autocomplete="Scan_to_pay" placeholder="ยอดโอน"/>
                                            @error('Scan_to_pay')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="cash" :value="__('เงินสด')" />
                                            <x-text-input wire:model="cash" id="cash"
                                                name="cash" value="{{ $admindailysale->cash }}" type="number" class="mt-1 block w-full"
                                                required autofocus autocomplete="cash" placeholder="หน่วยนับ"/>
                                            @error('cash')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="reporter_name" :value="__('ผู้รายงาน')" />
                                            {{ $admindailysale->reporter_name }}
                                            @error('reporter_name')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="items-center gap-4">
                                        <x-primary-button type="submit">{{ __('บันทีกข้อมูล') }}</x-primary-button>
                                    </div>
                                </div>
                            </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-appadmin-layout>
