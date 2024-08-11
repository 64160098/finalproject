<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('เพิ่มข้อมูลสินค้า') }}
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
                                    / <span>เพิ่มข้อมูลสินค้า</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                            <form action="{{ route('product.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="id" :value="__('รหัสสินค้า')" />
                                            <x-text-input wire:model="id" id="id"
                                                name="id" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="id" placeholder="รหัสสินค้า"/>
                                                <div class="alert alert-danger" id="id_error" style="display:none;"></div>
                                            @error('id')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="product_name" :value="__('ชื่อสินค้า')" />
                                            <x-text-input wire:model="product_name" id="product_name"
                                                name="product_name" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="product_name" placeholder="ชื่อสินค้า"/>
                                                <div class="alert alert-danger" id="product_name_error" style="display:none;"></div>
                                            @error('product_name')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="product_type_id" :value="__('ประเภท')" />
                                            <select class="form-select" name="product_type_id">
                                                <option value="" selected>-</option>
                                                @foreach($producttypes as $row)
                                                    <option value="{{ $row->id }}">{{ $row->product_type }}</option>
                                                @endforeach                                            
                                            </select>
                                            @error('product_type_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="product_unit_id" :value="__('หน่วยนับ')" />
                                            <select class="form-select" name="product_unit_id">
                                                <option value="" selected>-</option>
                                                @foreach ($units as $row)
                                                    <option value="{{ $row->id }}">{{ $row->unit }}</option>
                                                @endforeach  
                                            </select>
                                            @error('product_unit_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <div class="flex items-center">
                                                <!-- ช่องกว้าง -->
                                                <div class="w-24">
                                                    <x-input-label for="product_width" :value="__('กว้าง')" />
                                                    <x-text-input wire:model="product_width" id="product_width" name="product_width" type="text" class="mt-1 block" required autofocus autocomplete="product_width" style="max-width: 50px;" />
                                                    @error('product_width')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; line-height: 1;">×</span>
                                                </div>

                                                <!-- ช่องยาว -->
                                                <div class="w-24">
                                                    <x-input-label for="product_length" :value="__('ยาว')" />
                                                    <x-text-input wire:model="product_length" id="product_length" name="product_length" type="text" class="mt-1 block" required autofocus autocomplete="product_length" style="max-width: 50px;" />
                                                    @error('product_length')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- เครื่องหมายคูณ -->
                                                <div class="flex items-center" style="height: 100%;">
                                                    <span class="text-lg" style="margin: 0 7px; line-height: 1;">×</span>
                                                </div>

                                                <!-- ช่องสูง -->
                                                <div class="w-24">
                                                    <x-input-label for="product_height" :value="__('สูง')" />
                                                    <x-text-input wire:model="product_height" id="product_height" name="product_height" type="text" class="mt-1 block" required autofocus autocomplete="product_height" style="max-width: 50px;" />
                                                    @error('product_height')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="price" :value="__('ราคา')" />
                                            <x-text-input wire:model="price" id="price"
                                                name="price" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="price" placeholder="ราคา"/>
                                            @error('price')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
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
        $(document).ready(function(){
            $('#submit-button').click(function(event){
                event.preventDefault(); // ป้องกันการส่งฟอร์มไปยังเซิร์ฟเวอร์
    
                var formData = new FormData($('form')[0]); // สร้าง FormData จากฟอร์ม
    
                // รีเซ็ตข้อความแสดงข้อผิดพลาด
                $('#id_error').hide().text('');
                $('#product_name_error').hide().text('');
    
                $.ajax({
                    url: '{{ route('product.store') }}', // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        alert('เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('product.products') }}";
                    },
                    error: function(xhr){
                        // กระบวนการเมื่อเกิดข้อผิดพลาด
                        console.error('Error:', xhr);
                        if (xhr.status === 422) {
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
