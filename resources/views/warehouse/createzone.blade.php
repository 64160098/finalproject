<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('เพิ่มข้อมูลโชน') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('warehouse.zone', ['id' => $warehouse->id]) }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>เพิ่มข้อมูลโชน</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                            <form id="zone-form" action="{{ route('warehouse.createzone.store', ['id' => $warehouse->id]) }}" method="POST">
                                @csrf
                                <div class="space-y-6">
                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                        <h1 class="font-bold text-xl mb-4">ข้อมูลคลังสินค้า</h1>
                                        <div class="flex flex-wrap gap-4">
                                            <!-- บรรทัดแรก -->
                                            <div class="w-1/2">
                                                <x-input-label for="warehouse_id" :value="__('รหัสคลังสินค้า')" />
                                                <x-text-input id="warehouse_id" name="warehouse_id" type="text" value="{{ $warehouse->id }}" class="mt-1 block w-full" required readonly/>
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="name" :value="__('ชื่อ')" />
                                                <x-text-input id="name" value="{{ $warehouse->name }}" name="product_volume" type="text" style="max-width: 300px;" readonly />
                                            </div>
                                        </div>
                                        <!-- บรรทัดที่สอง -->
                                        <div class="flex items-center mt-4">
                                            <div class="flex items-center">
                                                <!-- ช่องกว้าง -->
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_width" :value="__('กว้าง')" />
                                                    <x-text-input id="warehouse_width" value="{{ $warehouse->warehouse_width }}" name="warehouse_width" type="text" style="max-width: 80px;" readonly />
                                                </div>
                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; height: 0px;">×</span>
                                                </div>
                                                <!-- ช่องยาว -->
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_length" :value="__('ยาว')" />
                                                    <x-text-input id="warehouse_length" value="{{ $warehouse->warehouse_length }}" name="warehouse_length" type="text" style="max-width: 80px;" readonly />
                                                </div>
                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; height: 0px;">×</span>
                                                </div>
                                                <!-- ช่องสูง -->
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_height" :value="__('สูง')" />
                                                    <x-text-input id="warehouse_height" value="{{ $warehouse->warehouse_height }}" name="warehouse_height" type="text" style="max-width: 80px;" readonly />
                                                </div>
                                                <!-- เครื่องหมายเท่ากับ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 10px; height: 0px;">=</span>
                                                </div>
                                                <!-- พื้นที่ทั้งหมด -->
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_total_area" :value="__('พื้นที่ทั้งหมด')" />
                                                    <x-text-input id="warehouse_total_area" value="{{ $warehouse->warehouse_total_area }}" name="warehouse_total_area" type="text" style="max-width: 150px;" readonly />
                                                </div>
                                                <h1 style="margin: 0 10px; height: 0px;">ตารางเมตร</h1>
                                            </div>
                                        </div>
                                        <!-- บรรทัดที่สาม -->
                                        <div class="flex items-center mt-4">
                                            <div class="flex items-center">
                                                <!-- พื้นที่จัดเก็บสินค้าที่ใช้ได้ -->
                                                <div class="w-24">
                                                    <x-input-label for="warehouse_available_area" :value="__('พื้นที่จัดเก็บสินค้าที่ใช้ได้')" />
                                                    <x-text-input id="warehouse_available_area" value="{{ $warehouse->warehouse_available_area }}" name="warehouse_available_area" type="text" style="max-width: 150px;" readonly />
                                                </div>
                                                <h1 style="margin: 0 10px; height: 0px;">ตารางเมตร</h1>
                                            </div>
                                        </div>
                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                        <h1 class="font-bold text-xl mb-4">ข้อมูลสินค้าที่ถูกจัดเก็บในพื้นที่</h1>
                                        <div class="flex flex-wrap gap-4">
                                            <!-- บรรทัดแรก -->
                                            <div class="w-1/2">
                                                <x-input-label for="product_id" :value="__('รหัสสินค้า')" />
                                                <select id="product_id" name="product_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" style="width: 200px;"required>
                                                    <option value="">เลือกรหัสสินค้า</option>
                                                    <!-- คุณควรดึงข้อมูลสินค้าจากฐานข้อมูลมาแสดงในรูปแบบ select option -->
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="product_name" :value="__('ชื่อสินค้า')" />
                                                <x-text-input id="product_name" name="product_name" type="text" style="width: 300px;" readonly />
                                                @error('product_name')
                                                    <div class="text-red-500">{{ $message }}</div>
                                                @enderror
                                            </div>                                            
                                        </div>
                                        <!-- บรรทัดที่สอง -->
                                        <div class="flex items-center mt-4">
                                            <div class="flex items-center">
                                                <!-- ช่องกว้าง -->
                                                <div class="w-24">
                                                    <x-input-label for="product_width" :value="__('กว้าง')" />
                                                    <x-text-input id="product_width" name="product_width" type="text" style="width: 80px;" readonly />
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
                                                    <x-text-input id="product_length" name="product_length" type="text" style="width: 80px;" readonly />
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
                                                    <x-text-input id="product_height" name="product_height" type="text" style="max-width: 80px;" readonly />
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
                                                    <x-input-label for="product_volume" :value="__('ปริมาตรของสินค้า')" />
                                                    <x-text-input id="product_volume" name="product_volume" type="text" style="max-width: 200px;" readonly />
                                                    @error('product_volume')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <h1 style="margin: 0 10px; height: 0px;">ลูกบาศก์เมตร</h1>
                                            </div>
                                        </div>

                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                        <div>
                                            <x-input-label for="id	" :value="__('รหัสโซน')" />
                                            <x-text-input id="id" name="id" type="text" class="mt-1 block w-full" style="width: 200px;" required placeholder="รหัสโซน"/>
                                        </div>
                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                        <div>
                                            <x-input-label for="name" :value="__('ชื่อโซน')" />
                                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" style="width: 200px;" required placeholder="ชื่อโซน"/>
                                        </div>

                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                            <div class="flex items-center">
                                            <!-- ช่องกว้าง -->
                                            <div class="w-24">
                                                <x-input-label for="zone_width" :value="__('กว้าง')" />
                                                <x-text-input id="zone_width" name="zone_width" type="text" class="mt-1 block" style="width: 80px;" required placeholder="กว้าง"/>
                                            </div>

                                            <!-- เครื่องหมายคูณ -->
                                            <div class="flex items-center" style="height: 100%;">
                                                <span class="text-lg" style="margin: 0 7px; line-height: 1;">×</span>
                                            </div>

                                            <!-- ช่องยาว -->
                                            <div class="w-24">
                                                <x-input-label for="zone_length" :value="__('ยาว')" />
                                                <x-text-input id="zone_length" name="zone_length" type="text" class="mt-1 block" style="width: 80px;" required placeholder="ยาว"/>
                                            </div>

                                            <!-- เครื่องหมายคูณ -->
                                            <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; line-height: 1;">×</span>
                                                </div>

                                            <!-- ช่องสูง -->
                                            <div class="w-24">
                                                <x-input-label for="zone_height" :value="__('สูง')" />
                                                <x-text-input id="zone_height" name="zone_height" type="text" class="mt-1 block" style="width: 80px;" required placeholder="สูง"/>
                                            </div>
                                        </div>
                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                        <div>
                                            <x-input-label for="zone_status" :value="__('สถานะ')" />
                                            <x-text-input id="zone_status" name="zone_status" type="text" class="mt-1 block w-full" style="width: 200px;" required placeholder="สถานะ"/>
                                        </div>

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
        $('#submit-button').click(function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = new FormData($('#zone-form')[0]); // Create FormData from form

            $.ajax({
                url: $('#zone-form').attr('action'), // Use form action URL
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response); // Show response in console
                    alert('เพิ่มข้อมูลโซนเรียบร้อยแล้ว');
                    window.location.href = "{{ route('warehouse.zone', ['id' => $warehouse->id]) }}";
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.id) {
                            $('#id_error').show().text(errors.id[0]);
                        }
                    } else {
                        alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                    }
                }
            });
        });
    </script> 
    
    <script>
        $(document).ready(function() {
            $('#product_id').on('change', function() {
                let id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '/zone-product-details/' + id,
                        type: 'GET',
                        success: function(response) {
                            $('#product_name').val(response.product_name);
                            $('#product_width').val(response.product_width);
                            $('#product_length').val(response.product_length);
                            $('#product_height').val(response.product_height);
                            $('#product_volume').val(response.product_volume);
                        },
                        error: function() {
                            alert('ไม่พบข้อมูลสินค้า');
                        }
                    });
                } else {
                    $('#product_name').val('');
                    $('#product_width').val('');
                    $('#product_length').val('');
                    $('#product_height').val('');
                    $('#product_volume').val('');
                }
            });
        });
    </script>

</x-appadmin-layout>
