<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('แก้ไขข้อมูลพนักงาน') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('employee.employees') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>แก้ไขข้อมูลพนักงาน</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                            <form action="{{ route('employee.update', $employee->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="employee_id" :value="__('รหัสพนักงาน')" />
                                            <x-text-input wire:model="employee_id" id="employee_id"
                                                name="employee_id" value="{{ $employee->employee_id }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="employee_id" placeholder="รหัสพนักงาน"/>
                                                <div class="alert alert-danger" id="employee_id_error"></div>
                                            @error('employee_id')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="firstname" :value="__('ชื่อจริง')" />
                                            <x-text-input wire:model="firstname" id="firstname"
                                                name="firstname" value="{{ $employee->firstname }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="firstname" placeholder="ชื่อจริง"/>
                                            @error('firstname')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="lastname" :value="__('นามสกุล')" />
                                            <x-text-input wire:model="lastname" id="lastname"
                                                name="lastname" value="{{ $employee->lastname }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="lastname" placeholder="นามสกุล"/>
                                            @error('lastname')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="contact_number" :value="__('เบอร์ติดต่อ')" />
                                            <x-text-input wire:model="contact_number" id="contact_number"
                                                name="contact_number" value="{{ $employee->contact_number }}" type="text" class="mt-1 block w-full"
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
                                                name="email" value="{{ $employee->email }}" type="email" class="mt-1 block w-full"
                                                required autofocus autocomplete="email" placeholder="อีเมลล์"/>
                                            @error('email')
                                                <div class="aleart alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <div>
                                            <x-input-label for="status" :value="__('สถานะ')" />
                                            <x-text-input wire:model="status" id="status"
                                                name="status" value="{{ $employee->status }}" type="text" class="mt-1 block w-full"
                                                required autofocus autocomplete="status" placeholder="สถานะ"/>
                                            @error('status')
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

                // รีเซ็ตข้อความแสดงข้อผิดพลาด
                $('#employee_id_error').hide().text('');

                $.ajax({
                    url: '{{ route('employee.update', $employee->id) }}', // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        alert('แก้ไขข้อมูลพนักงานเรียบร้อยแล้ว');
                        window.location.href = "{{ route('employee.employees') }}";
                    },
                    error: function(xhr){
                        // กระบวนการเมื่อเกิดข้อผิดพลาด
                        console.error('Error:', xhr);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.employee_id) {
                                $('#employee_id_error').show().text(errors.employee_id[0]);
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
