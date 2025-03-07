<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('แก้ไขข้อมูลผู้จัดจำหน่าย') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('supplier.suppliers') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>แก้ไขข้อมูลผู้จัดจำหน่าย</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                            <form action="{{ route('supplier.update', $supplier->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="id" :value="__('เลขที่บริษัท')" />
                                            <x-text-input wire:model="id" id="id"
                                                name="id" value="{{ $supplier->id }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="id" placeholder="เลขที่บริษัท"/>
                                            @error('id')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="supplier_name" :value="__('ชื่อบริษัท')" />
                                            <x-text-input wire:model="supplier_name" id="supplier_name"
                                                name="supplier_name" value="{{ $supplier->supplier_name }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="supplier_name" placeholder="ชื่อบริษัท"/>
                                            @error('supplier_name')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="supplier_customer_name" :value="__('ชื่อผู้ติดต่อ')" />
                                            <x-text-input wire:model="supplier_customer_name" id="supplier_customer_name"
                                                name="supplier_customer_name" value="{{ $supplier->supplier_customer_name }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="supplier_customer_name" placeholder="ชื่อผู้ติดต่อ"/>
                                            @error('supplier_customer_name')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="supplier_product" :value="__('จำหน่ายสินค้า')" />
                                            <x-text-input wire:model="supplier_product" id="supplier_product"
                                                name="supplier_product" value="{{ $supplier->supplier_product }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="supplier_product" placeholder="จำหน่ายสินค้า"/>
                                            @error('supplier_product')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="supplier_contact_number" :value="__('เบอร์ติดต่อ')" />
                                            <x-text-input wire:model="supplier_contact_number" id="supplier_contact_number"
                                                name="supplier_contact_number" value="{{ $supplier->supplier_contact_number }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="supplier_contact_number" placeholder="เบอร์ติดต่อ"/>
                                            @error('supplier_contact_number')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="supplier_email" :value="__('อีเมลล์')" />
                                            <x-text-input wire:model="supplier_email" id="supplier_email"
                                                name="supplier_email" value="{{ $supplier->supplier_email }}" type="email" class="mt-1 block w-full"
                                                required autofocus autocomplete="supplier_email" placeholder="อีเมลล์"/>
                                            @error('supplier_email')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
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
    
                $.ajax({
                    url: '{{ route('supplier.update', $supplier->id) }}', // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        alert('แก้ไขข้อมูลผู้จัดจำหน่ายเรียบร้อยแล้ว');
                        window.location.href = "{{ route('supplier.suppliers') }}";
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
