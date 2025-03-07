<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('คำนวน EOQ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('product.products') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>คำนวน EOQ</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                            <form action="{{ route('eoqrop.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <hr class="border-gray-300 dark:border-gray-700">
                                        <h1 class="font-bold text-xl mb-4">ข้อมูลสินค้า</h1>
                                        <div class="flex flex-wrap gap-4">
                                            <!-- บรรทัดแรก -->
                                            <div class="w-1/2">
                                                <x-input-label for="product_id" :value="__('รหัสสินค้า')" />
                                                <select id="product_id" name="product_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                                                focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-500 
                                                dark:focus:ring-indigo-600 focus:ring-opacity-50 rounded-md shadow-sm" style="width: 200px;" required>
                                                    <option value="">เลือกรหัสสินค้า</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->id }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="alert alert-danger" id="product_id_error" style="display:none;"></div>
                                                @error('product_id')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="product_name" :value="__('ชื่อสินค้า')" />
                                                <x-text-input id="product_name" name="product_name" type="text" class="mt-1 block" style="width: 300px;" placeholder="ชื่อสินค้า" readonly />
                                                <div class="alert alert-danger" id="product_name_error" style="display:none;"></div>
                                                @error('product_name')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- บรรทัดที่สอง -->
                                        <div class="flex items-center mt-4">
                                            <div class="flex items-center">
                                                <!-- ช่องกว้าง -->
                                                <div class="w-24">
                                                    <x-input-label for="product_width" :value="__('กว้าง')" />
                                                    <x-text-input wire:model="product_width" id="product_width" name="product_width" type="text" class="mt-1 block" style="max-width: 80px;" readonly/>
                                                    @error('product_width')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; height: 0px;">×</span>
                                                </div>
                                                <!-- ช่องยาว -->
                                                <div class="w-24">
                                                    <x-input-label for="product_length" :value="__('ยาว')" />
                                                    <x-text-input wire:model="product_length" id="product_length" name="product_length" type="text" class="mt-1 block" style="max-width: 80px;" readonly/>
                                                    @error('product_length')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; height: 0px;">×</span>
                                                </div>
                                                <!-- ช่องสูง -->
                                                <div class="w-24">
                                                    <x-input-label for="product_height" :value="__('สูง')" />
                                                    <x-text-input wire:model="product_height" id="product_height" name="product_height" type="text" class="mt-1 block" style="max-width: 80px;" readonly/>
                                                    @error('product_height')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- เครื่องหมายเท่ากับ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 10px; height: 0px;">=</span>
                                                </div>
                                                <!-- ช่องปริมาตร -->
                                                <div class="w-24">
                                                    <x-input-label for="product_volume" :value="__('ปริมาตรสินค้า')" />
                                                    <x-text-input wire:model="product_volume" id="product_volume" name="product_volume" type="text" class="mt-1 block" style="max-width: 150px;" equired autofocus autocomplete="product_volume" placeholder="ปริมาตรสินค้า" readonly/>
                                                    @error('product_volume')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <h1 style="margin: 0 10px; height: 0px;">ลูกบาศก์เซนติเมตร</h1>
                                            </div>
                                        </div>

                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    
                                        <h1 class="font-bold text-xl mb-4">ขนาดพื้นจัดเก็บที่สินค้า</h1>
                                        <div class="flex flex-wrap gap-4">
                                            <!-- บรรทัดแรก -->
                                            <div class="w-1/2">
                                                <x-input-label for="warehouse_id" :value="__('คลังสินค้า')" />
                                                <select id="warehouse-select" name="warehouse_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                                                focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-500 
                                                dark:focus:ring-indigo-600 focus:ring-opacity-50 rounded-md shadow-sm" style="width: 200px;">
                                                    <option value="">เลือกคลังสินค้า</option>
                                                </select>
                                                <div class="alert alert-danger mt-2" id="warehouse_id_error" style="display:none;"></div>
                                                @error('warehouse_id')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="warehouse_name" :value="__('ชื่อคลังสินค้า')" />
                                                <x-text-input wire:model="warehouse_name" id="warehouse_name" name="warehouse_name" type="text" class="mt-1 block" style="width: 300px;" placeholder="ชื่อคลังสินค้า" readonly/>
                                                <div class="alert alert-danger" id="warehouse_name_error" style="display:none;"></div>
                                                @error('warehouse_name')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- บรรทัดที่สอง -->
                                        <div class="flex items-center mt-4">
                                            <div class="flex items-center">
                                                <!-- ช่องกว้าง -->
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_width" :value="__('กว้าง')" />
                                                    <x-text-input wire:model="warehouse_width" id="warehouse_width" name="warehouse_width" type="text" class="mt-1 block" style="max-width: 80px;" readonly/>
                                                    @error('warehouse_width')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; height: 0px;">×</span>
                                                </div>
                                                <!-- ช่องยาว -->
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_length" :value="__('ยาว')" />
                                                    <x-text-input wire:model="warehouse_length" id="warehouse_length" name="warehouse_length" type="text" class="mt-1 block" style="max-width: 80px;" readonly/>
                                                    @error('warehouse_length')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; height: 0px;">×</span>
                                                </div>
                                                <!-- ช่องสูง -->
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_height" :value="__('สูง')" />
                                                    <x-text-input wire:model="warehouse_height" id="warehouse_height" name="warehouse_height" type="text" class="mt-1 block" style="max-width: 80px;" readonly/>
                                                    @error('warehouse_height')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- เครื่องหมายเท่ากับ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 10px; height: 0px;">=</span>
                                                </div>
                                                <!-- ช่องปริมาตร -->
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_total_area" :value="__('พื้นที่ทั้งหมด')" />
                                                    <x-text-input wire:model="warehouse_total_area" id="warehouse_total_area" name="warehouse_total_area" type="text" class="mt-1 block" style="max-width: 150px;" placeholder="พื้นที่ทั้งหมด" readonly/>
                                                    @error('warehouse_total_area')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <h1 style="margin: 0 10px; height: 0px;">&</h1>
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_available_area" :value="__('พื้นที่จัดเก็บที่ใช้ได้')" />
                                                    <x-text-input wire:model="warehouse_available_area" id="warehouse_available_area" name="warehouse_available_area" type="text" class="mt-1 block" style="max-width: 150px;" placeholder="พื้นที่จัดเก็บที่ใช้ได้" readonly/>
                                                    @error('warehouse_available_area')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <h1 style="margin: 0 10px; height: 0px;">ตารางเมตร</h1>
                                            </div>
                                        </div>

                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                        
                                        <div class="flex flex-wrap gap-4">
                                            <!-- บรรทัดสาม-->
                                            <div class="w-1/2">
                                                <x-input-label for="zone-select" :value="__('พื้นที่จัดเก็บสินค้า')" />
                                                <select id="zone-select" name="zone_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                                                focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-500 
                                                dark:focus:ring-indigo-600 focus:ring-opacity-50 rounded-md shadow-sm" style="width: 230px;">
                                                    <option value="">เลือกพื้นที่จัดเก็บสินค้า</option>
                                                </select>
                                                <div class="alert alert-danger mt-2" id="zone_id_error" style="display:none;"></div>
                                                @error('zone_id')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>                                            
                                            <div class="w-1/2">
                                                <x-input-label for="zone_name" :value="__('ชื่อโซน')" />
                                                <x-text-input id="zone_name" name="zone_name" type="text" class="mt-1 block" style="width: 300px;" placeholder="ชื่อโซน" readonly />
                                                <div class="alert alert-danger" id="zone_name_error" style="display:none;"></div>
                                                @error('zone_name')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- บรรทัดที่สี่ -->
                                        <div class="flex items-center mt-4">
                                            <div class="flex items-center">
                                                <!-- ช่องกว้าง -->
                                                <div class="w-24">
                                                    <x-input-label for="zone_width" :value="__('กว้าง')" />
                                                    <x-text-input wire:model="zone_width" id="zone_width" name="zone_width" type="text" class="mt-1 block" style="max-width: 80px;" readonly/>
                                                    @error('zone_width')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; height: 0px;">×</span>
                                                </div>
                                                <!-- ช่องยาว -->
                                                <div class="w-24">
                                                    <x-input-label for="zone_length" :value="__('ยาว')" />
                                                    <x-text-input wire:model="zone_length" id="zone_length" name="zone_length" type="text" class="mt-1 block" style="max-width: 80px;" readonly/>
                                                    @error('zone_length')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; height: 0px;">×</span>
                                                </div>
                                                <!-- ช่องสูง -->
                                                <div class="w-24">
                                                    <x-input-label for="zone_height" :value="__('สูง')" />
                                                    <x-text-input wire:model="zone_height" id="zone_height" name="zone_height" type="text" class="mt-1 block" style="max-width: 80px;" readonly/>
                                                    @error('zone_height')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- เครื่องหมายเท่ากับ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 10px; height: 0px;">=</span>
                                                </div>
                                                <!-- ช่องปริมาตร -->
                                                <div class="w-24">
                                                    <x-input-label for="zone_volume" :value="__('ปริมาตรพื้นที่')" />
                                                    <x-text-input wire:model="zone_volume" id="zone_volume" name="zone_volume" type="text" class="mt-1 block" style="max-width: 150px;" equired autofocus autocomplete="zone_volume" placeholder="ปริมาตรพื้นที่" readonly/>
                                                    @error('zone_volume')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <h1 style="margin: 0 10px; height: 0px;">ลูกบาศก์เมตร</h1>
                                            </div>
                                        </div>
                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                        <div class="w-1/2">
                                            <x-input-label for="id" :value="__('รหัสใบวิเคราะห์ข้อมูล ')" />
                                            <x-text-input wire:model="id" id="id" value="{{ $id }}" name="id" type="text" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="id" placeholder="รหัสใบวิเคราะห์ข้อมูล" readonly />
                                            <div class="alert alert-danger" id="id_error" style="display:none;"></div>
                                            @error('id')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                        <h1 class="font-bold text-xl mb-4 flex items-center">
                                            Economic Order Quantity (EOQ)
                                        </h1>                                                                              
                                        <div class="flex flex-wrap gap-4">
                                            <!-- บรรทัดแรก -->
                                            <div class="w-1/2">
                                                <x-input-label for="demand" :value="__('Demand (𝐷)')" />
                                                <x-text-input wire:model="demand" id="demand" name="demand" type="text" class="mt-1 block w-full" required autofocus autocomplete="demand" placeholder="จำนวนหน่วย" />
                                                <div class="alert alert-danger" id="demand_error" style="display:none;"></div>
                                                @error('demand')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="order_cost" :value="__('Order Cost (S)')" />
                                                <x-text-input wire:model="order_cost" id="order_cost" name="order_cost" type="text" class="mt-1 block w-full" required autofocus autocomplete="order_cost" placeholder="บาท" />
                                                <div class="alert alert-danger" id="order_cost_error" style="display:none;"></div>
                                                @error('order_cost')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="holding_cost" :value="__('Holding Cost (𝐻)')" />
                                                <x-text-input wire:model="holding_cost" id="holding_cost" name="holding_cost" type="text" class="mt-1 block w-full" required autofocus autocomplete="holding_cost" placeholder="บาท" />
                                                <div class="alert alert-danger" id="holding_cost_error" style="display:none;"></div>
                                                @error('holding_cost')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>                                                                                                                                                                                              
                                        <h1 class="font-bold text-xl mb-4 flex items-center"> Reorder Point (ROP) </h1>                                                                              
                                        <div class="flex flex-wrap gap-4">
                                            <!-- บรรทัดแรก -->
                                            <div class="w-1/2">
                                                <x-input-label for="daily_usage_rate" :value="__('Daily Usage Rate (𝐷)')" />
                                                <x-text-input wire:model="daily_usage_rate" id="daily_usage_rate" name="daily_usage_rate" type="text" class="mt-1 block w-full" required autofocus autocomplete="daily_usage_rate" placeholder="จำนวนหน่วย" />
                                                <div class="alert alert-danger" id="daily_usage_rate_error" style="display:none;"></div>
                                                @error('daily_usage_rate')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="lead_time" :value="__('Lead Time (𝐿) ')" />
                                                <x-text-input wire:model="lead_time" id="lead_time" name="lead_time" type="text" class="mt-1 block w-full" required autofocus autocomplete="lead_time" placeholder="จำนวนวัน" />
                                                <div class="alert alert-danger" id="lead_time_error" style="display:none;"></div>
                                                @error('lead_time')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="safety_stock" :value="__('Safety Stock (SS) ')" />
                                                <x-text-input wire:model="safety_stock" id="safety_stock" name="safety_stock" type="text" class="mt-1 block w-full" required autofocus autocomplete="safety_stock" placeholder="ปริมาณสินค้าสำรอง (หน่วย)" />
                                                <div class="alert alert-danger" id="safety_stock_error" style="display:none;"></div>
                                                @error('safety_stock')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                        <a href="{{ route('product.detail') }}" style="display: flex; align-items: center; margin: 0 10px; margin-top: 20px;" title="รายละเอียด">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <span style="margin-left: 8px;">รายละเอียดเพิ่มเติม</span>
                                        </a>

                                    <div class="items-center gap-4">
                                        <x-primary-button id="submit-button" type="submit">{{ __('บันทีกข้อมูล') }}</x-primary-button>
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

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // เมื่อเลือกรหัสสินค้า
            $('#product_id').on('change', function() {
                let productId = $(this).val();
                if (productId) {
                    $.ajax({
                        url: '/product-and-warehouses/' + productId,
                        type: 'GET',
                        success: function(response) {
                            // แสดงข้อมูลสินค้า
                            $('#product_name').val(response.product.name);
                            $('#product_width').val(response.product.width);
                            $('#product_length').val(response.product.length);
                            $('#product_height').val(response.product.height);
                            $('#product_volume').val(response.product.volume);

                            // เคลียร์และแสดงคลังสินค้าใน dropdown
                            $('#warehouse-select').empty().append('<option value="">เลือกคลังสินค้า</option>');
                            $.each(response.warehouses, function(index, warehouse) {
                                $('#warehouse-select').append('<option value="' + warehouse.warehouse_id + '">' + warehouse.name + '</option>');
                            });

                            // เคลียร์ฟิลด์คลังสินค้าและโซนเมื่อเปลี่ยนสินค้า
                            $('#warehouse_name, #warehouse_width, #warehouse_length, #warehouse_height, #warehouse_total_area, #warehouse_available_area').val('');
                            $('#zone-select, #zone_name, #zone_width, #zone_length, #zone_height, #zone_volume').empty().val('');
                        },
                        error: function(xhr) {
                            alert('ไม่พบข้อมูลสินค้าหรือคลังสินค้า');
                        }
                    });
                } else {
                    // เคลียร์ฟิลด์ทั้งหมดเมื่อไม่มีสินค้าที่ถูกเลือก
                    $('#product_name, #product_width, #product_length, #product_height, #product_volume').val('');
                    $('#warehouse-select').empty().append('<option value="">เลือกคลังสินค้า</option>');
                    $('#warehouse_name, #warehouse_width, #warehouse_length, #warehouse_height, #warehouse_total_area, #warehouse_available_area').val('');
                    $('#zone-select, #zone_name, #zone_width, #zone_length, #zone_height, #zone_volume').empty().val('');
                }
            });

                // เมื่อเลือกคลังสินค้า
                $('#warehouse-select').on('change', function() {
                let warehouseId = $(this).val();
                let productId = $('#product_id').val();  // ใช้ productId ที่เลือกไปก่อนหน้า

                // เคลียร์ข้อมูลโซนทุกครั้งที่เปลี่ยนคลังสินค้าใหม่
                $('#zone-select').empty().append('<option value="">เลือกรหัสโซน</option>');
                $('#zone_name, #zone_width, #zone_length, #zone_height, #zone_volume').val('');

                if (warehouseId && productId) {
                    $.ajax({
                        url: '/warehouse-zones/' + warehouseId + '/' + productId,
                        type: 'GET',
                        success: function(response) {
                            // แสดงข้อมูลคลังสินค้า
                            let warehouse = response.warehouses[0];
                            $('#warehouse_name').val(warehouse.name);
                            $('#warehouse_width').val(warehouse.width);
                            $('#warehouse_length').val(warehouse.length);
                            $('#warehouse_height').val(warehouse.height);
                            $('#warehouse_total_area').val(warehouse.total_area);
                            $('#warehouse_available_area').val(warehouse.available_area);

                            // เคลียร์และแสดงโซนใน dropdown
                            $('#zone-select').empty().append('<option value="">เลือกรหัสโซน</option>');
                            $.each(response.zones, function(index, zone) {
                                $('#zone-select').append('<option value="' + zone.zone_id + '">' + zone.name + '</option>');
                            });
                        },
                        error: function(xhr) {
                            alert('ไม่พบข้อมูลโซน');
                        }
                    });
                } else {
                    // เคลียร์ข้อมูลคลังสินค้าและโซน
                    $('#warehouse_name, #warehouse_width, #warehouse_length, #warehouse_height, #warehouse_total_area, #warehouse_available_area').val('');
                    $('#zone-select').empty().append('<option value="">เลือกรหัสโซน</option>');
                    $('#zone_name, #zone_width, #zone_length, #zone_height, #zone_volume').val('');
                }
            });

            // เมื่อเลือกโซน
            $('#zone-select').on('change', function() {
                let zoneId = $(this).val();
                if (zoneId) {
                    $.ajax({
                        url: '/zone-details/' + zoneId,  // URL ที่ใช้ดึงข้อมูลโซน
                        type: 'GET',
                        success: function(response) {
                            // แสดงข้อมูลโซน
                            $('#zone_name').val(response.zone.name);
                            $('#zone_width').val(response.zone.width);
                            $('#zone_length').val(response.zone.length);
                            $('#zone_height').val(response.zone.height);
                            $('#zone_volume').val(response.zone.volume);
                        },
                        error: function(xhr) {
                            alert('ไม่พบข้อมูลโซน');
                        }
                    });
                } else {
                    // เคลียร์ข้อมูลเมื่อไม่มีโซนที่เลือก
                    $('#zone_name, #zone_width, #zone_length, #zone_height, #zone_volume').val('');
                }
            });
        });
    </script> 
    
    <script>
        $(document).ready(function(){
            $('#submit-button').click(function(event){
                event.preventDefault(); // ป้องกันการส่งฟอร์มไปยังเซิร์ฟเวอร์
        
                var formData = new FormData($('form')[0]); // สร้าง FormData จากฟอร์ม
        
                $.ajax({
                    url: '{{ route('eoqrop.store') }}', // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        alert(response.message); // แสดงข้อความสำเร็จ
                        window.location.href = "{{ route('product.products') }}"; // รีเฟรชหน้าหรือเปลี่ยนหน้า
                    },
                    error: function(xhr){
                        // กระบวนการเมื่อเกิดข้อผิดพลาด
                        console.error('Error:', xhr);
                        if (xhr.status === 400 && xhr.responseJSON && xhr.responseJSON.message) {
                            // แสดงข้อความแจ้งเตือนหากข้อมูลซ้ำ
                            alert(xhr.responseJSON.message);
                        } else if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.id) {
                                $('#id_error').show().text(errors.id[0]);
                            }
                            if (errors.product_name) {
                                $('#product_name_error').show().text(errors.product_name[0]);
                            }
                        } else {
                            alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                        }
                    }
                });
            });
        });
    </script>
    

</x-appadmin-layout>
