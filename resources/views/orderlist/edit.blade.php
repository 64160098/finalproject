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
                                <p class="bread"><span><a href="{{ route('orderlist.orderlists') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>แก้ไขรายการสินค้า</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                                <form action="{{ route('orderlist.update', $orderlist->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-6">
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="code" :value="__('รหัส')" />
                                                {{ $orderlist->code }}
                                                @error('code')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="product_name" :value="__('ชื่อสินค้า')" />
                                                {{ $orderlist->product_name }}
                                                @error('product_name')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="quantity_products_order" :value="__('จำนวนสินค้าที่สั่ง')" />
                                                <x-text-input wire:model="quantity_products_order" id="quantity_products_order"
                                                    name="quantity_products_order" value="{{ $orderlist->quantity_products_order }}" type="number" class="mt-1 block w-full"
                                                    required autofocus autocomplete="quantity_products_order" placeholder="จำนวนสินค้าที่สั่ง"/>
                                                @error('quantity_products_order')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="unit" :value="__('หน่วยนับ')" />
                                                {{ $orderlist->unit }}
                                                @error('unit')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="cost_unit" :value="__('ต้นทุน/หน่วย')" />
                                                {{ $orderlist->cost_unit }}
                                                @error('cost_unit')
                                                    <div class="aleart alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                            <div>
                                                <x-input-label for="total" :value="__('เป็นเงินทั้งหมด')" />
                                                {{ $orderlist->total }}
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
