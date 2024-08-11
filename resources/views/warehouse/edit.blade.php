<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('แก้ไขข้อมูลคลังสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('warehouse.warehouses') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>แก้ไขข้อมูลคลังสินค้า</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                            <form action="{{ route('warehouse.update', $warehouse->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div>
                                        <x-input-label for="id" :value="__('รหัสคลังสินค้า')" />
                                        <x-text-input wire:model="id" id="id"
                                            name="id" type="text" value="{{ $warehouse->id }}" class="mt-1 block w-full"
                                            required autofocus autocomplete="id" style="max-width: 300px;" placeholder="รหัสคลังสินค้า"/>
                                            <div class="alert alert-danger" id="id_error" style="display:none;"></div>
                                        @error('id')
                                            <div class="aleart alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div>
                                        <x-input-label for="name" :value="__('ชื่อคลังสินค้า')" />
                                        <x-text-input wire:model="name" id="name"
                                            name="name" type="text" value="{{ $warehouse->name }}" class="mt-1 block w-full"
                                            required autofocus autocomplete="name" style="max-width: 300px;" placeholder="ชื่อคลังสินค้า"/>
                                            <div class="alert alert-danger" id="name_error" style="display:none;"></div>
                                        @error('name')
                                            <div class="aleart alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div>
                                        <x-input-label for="address" :value="__('ที่อยู่')" />
                                        <x-text-input wire:model="address" id="address"
                                            name="address" type="text" value="{{ $warehouse->address }}" class="mt-1 block w-full"
                                            required autofocus autocomplete="address" style="max-width: 800px;" placeholder="ที่อยู่"/>
                                            <div class="alert alert-danger" id="address_error" style="display:none;"></div>
                                        @error('address')
                                            <div class="aleart alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div class="flex items-center gap-2">
                                        <div>
                                            <x-input-label for="warehouse_total_area" :value="__('พื้นที่ทั้งหมด')" />
                                            <x-text-input wire:model="warehouse_total_area" id="warehouse_total_area"
                                                name="warehouse_total_area" type="text" value="{{ $warehouse->warehouse_total_area }}" class="mt-1 block w-full"
                                                required autofocus autocomplete="warehouse_total_area" style="max-width: 200px;" placeholder="พื้นที่ทั้งหมด" />
                                            <div class="alert alert-danger" id="warehouse_total_area_error" style="display:none;"></div>
                                            @error('warehouse_total_area')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <h1 class="mt-6">ตารางเมตร</h1>
                                        </div>
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div class="flex items-center gap-2">
                                        <div>
                                            <x-input-label for="warehouse_available_area" :value="__('พื้นที่จัดเก็บที่ใช้ได้')" />
                                            <x-text-input wire:model="warehouse_available_area" id="warehouse_available_area"
                                                name="warehouse_available_area" type="text" value="{{ $warehouse->warehouse_available_area }}" class="mt-1 block w-full"
                                                required autofocus autocomplete="warehouse_available_area" style="max-width: 200px;" placeholder="พื้นที่จัดเก็บที่ใช้ได้" />
                                            <div class="alert alert-danger" id="warehouse_available_area_error" style="display:none;"></div>
                                            @error('warehouse_available_area')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <h1 class="mt-6">ตารางเมตร</h1>
                                        </div>
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div class="flex items-center gap-2">
                                        <div>
                                            <x-input-label for="warehouse_width" :value="__('กว้าง')" />
                                            <x-text-input wire:model="warehouse_width" id="warehouse_width"
                                                name="warehouse_width" type="text" value="{{ $warehouse->warehouse_width }}" class="mt-1 block w-full"
                                                required autofocus autocomplete="warehouse_width" style="max-width: 100px;" placeholder="กว้าง"/>
                                                <div class="alert alert-danger" id="warehouse_width_error" style="display:none;"></div>
                                            @error('warehouse_width')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <h1 class="mt-6">เมตร</h1>
                                        </div>
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div class="flex items-center gap-2">
                                        <div>
                                            <x-input-label for="warehouse_length" :value="__('ยาว')" />
                                            <x-text-input wire:model="warehouse_length" id="warehouse_length"
                                                name="warehouse_length" type="text" value="{{ $warehouse->warehouse_length }}" class="mt-1 block w-full"
                                                required autofocus autocomplete="warehouse_length" style="max-width: 100px;" placeholder="ยาว"/>
                                                <div class="alert alert-danger" id="warehouse_length_error" style="display:none;"></div>
                                            @error('warehouse_length')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <h1 class="mt-6">เมตร</h1>
                                        </div>
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div class="flex items-center gap-2">
                                        <div>
                                            <x-input-label for="warehouse_height" :value="__('สูง')" />
                                            <x-text-input wire:model="warehouse_height" id="warehouse_height"
                                                name="warehouse_height" type="text" value="{{ $warehouse->warehouse_height }}" class="mt-1 block w-full"
                                                required autofocus autocomplete="warehouse_height" style="max-width: 100px;" placeholder="สูง"/>
                                                <div class="alert alert-danger" id="warehouse_height_error" style="display:none;"></div>
                                            @error('warehouse_height')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <h1 class="mt-6">เมตร</h1>
                                        </div>
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div>
                                        <x-input-label for="warehouse_area_type" :value="__('ประเภทพื้นที่')" />
                                        <x-text-input wire:model="warehouse_area_type" id="height"
                                            name="warehouse_area_type" type="text" value="{{ $warehouse->warehouse_area_type }}" class="mt-1 block w-full"
                                            required autofocus autocomplete="warehouse_area_type" style="max-width: 300px;" placeholder="ประเภทพื้นที่"/>
                                            <div class="alert alert-danger" id="warehouse_area_type_error" style="display:none;"></div>
                                        @error('warehouse_area_type')
                                            <div class="aleart alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    <div>
                                        <x-input-label for="status" :value="__('สถานะ')" />
                                        <x-text-input wire:model="status" id="height"
                                            name="status" type="text" value="{{ $warehouse->status }}" class="mt-1 block w-full"
                                            required autofocus autocomplete="status" style="max-width: 300px;" placeholder="สถานะ"/>
                                            <div class="alert alert-danger" id="status_error" style="display:none;"></div>
                                        @error('status')
                                            <div class="aleart alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>

                                <div class="items-center gap-4">
                                    <x-primary-button id="update-button" type="submit">{{ __('บันทีกข้อมูล') }}</x-primary-button>
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
        $(document).ready(function(){
            $('#update-button').click(function(event){
                event.preventDefault(); // ป้องกันการส่งฟอร์มไปยังเซิร์ฟเวอร์
    
                var formData = new FormData($('form')[0]); // สร้าง FormData จากฟอร์ม
    
                // รีเซ็ตข้อความแสดงข้อผิดพลาด
                $('#unit_error').hide().text('');
    
                $.ajax({
                    url: '{{ route('warehouse.update', $warehouse->id) }}', // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        alert('แก้ไขข้อมูลคลังสินค้าเรียบร้อยแล้ว');
                        window.location.href = "{{ route('warehouse.warehouses') }}";
                    },
                    error: function(xhr){
                        // กระบวนการเมื่อเกิดข้อผิดพลาด
                        console.error('Error:', xhr);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.unit) {
                                $('#unit_error').show().text(errors.unit[0]);
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
