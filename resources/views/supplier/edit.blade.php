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
                                            <x-input-label for="company_name" :value="__('ชื่อบริษัท')" />
                                            <x-text-input wire:model="company_name" id="company_name"
                                                name="company_name" value="{{ $supplier->company_name }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="company_name" placeholder="ชื่อบริษัท"/>
                                            @error('company_name')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="customer_name" :value="__('ชื่อลูกค้า')" />
                                            <x-text-input wire:model="customer_name" id="customer_name"
                                                name="customer_name" value="{{ $supplier->customer_name }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="customer_name" placeholder="ชื่อลูกค้า"/>
                                            @error('customer_name')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="about_product" :value="__('จำหน่ายสินค้า')" />
                                            <x-text-input wire:model="about_product" id="about_product"
                                                name="about_product" value="{{ $supplier->about_product }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="about_product" placeholder="จำหน่ายสินค้า"/>
                                            @error('about_product')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="contact_number" :value="__('เบอร์ติดต่อ')" />
                                            <x-text-input wire:model="contact_number" id="contact_number"
                                                name="contact_number" value="{{ $supplier->contact_number }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="contact_number" placeholder="เบอร์ติดต่อ"/>
                                            @error('contact_number')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="email" :value="__('อีเมลล์')" />
                                            <x-text-input wire:model="email" id="email"
                                                name="email" value="{{ $supplier->email }}" type="email" class="mt-1 block w-full"
                                                required autofocus autocomplete="email" placeholder="อีเมลล์"/>
                                            @error('email')
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
