<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('แก้ไขรายการสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('inventoryreport.inventoryreports') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>แก้ไขรายการสินค้า</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                                <form action="{{ route('inventoryreport.update', $inventoryreport->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-6">
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="code" :value="__('รหัส')" />
                                                {{ $inventoryreport->code }}
                                                @error('code')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="product_name" :value="__('ชื่อสินค้า')" />
                                                {{ $inventoryreport->product_name }}
                                                @error('product_name')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="quuantity_products_sold" :value="__('จำนวนที่ขาย')" />
                                                <x-text-input wire:model="quuantity_products_sold" id="quuantity_products_sold"
                                                    name="quuantity_products_sold" value="{{ $inventoryreport->quuantity_products_sold }}" type="number" class="mt-1 block w-full"
                                                    required autofocus autocomplete="quuantity_products_sold" placeholder="จำนวนสินค้าที่สั่ง"/>
                                                @error('quuantity_products_sold')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="unit" :value="__('หน่วยนับ')" />
                                                {{ $inventoryreport->unit }}
                                                @error('unit')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="cost_unit" :value="__('ต้นทุน/หน่วย')" />
                                                {{ $inventoryreport->cost_unit }}
                                                @error('cost_unit')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="total" :value="__('เป็นเงินทั้งหมด')" />
                                                {{ $inventoryreport->total }}
                                                @error('total')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- เพิ่ม input field ซ่อนสำหรับระบุ HTTP method เป็น PUT -->
                                        <input type="hidden" name="_method" value="PUT">
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
