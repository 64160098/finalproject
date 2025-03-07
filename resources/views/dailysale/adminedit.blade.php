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
                            <form id="dailyForm" action="{{ route('dailysale.admin.update', $admindailysale->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <hr class="border-gray-300 dark:border-gray-700">
                                    <div class="w-1/2">
                                        <x-input-label for="sale_date" :value="__('วันที่ทำรายการ ')" />
                                        <x-text-input value="{{ $currentDate }}" id="sale_date" name="sale_date" type="date" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="sale_date" placeholder="วันที่ทำรายการ" />
                                        <div class="alert alert-danger" id="sale_date_error" style="display:none;"></div>
                                        @error('sale_date')
                                            <div class="alert alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr class="border-gray-300 dark:border-gray-700">
                                    <h1 class="font-bold text-xl mb-4">ข้อมูลผู้รายงาน</h1>
                                    <div class="flex flex-wrap gap-4">
                                        <!-- บรรทัดแรก -->
                                        <div class="w-1/2">
                                            <x-input-label for="employee_id" :value="__('รหัสพนักงาน')" />
                                            <select id="employee_id" name="employee_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-500 
                                            dark:focus:ring-indigo-600 focus:ring-opacity-50 rounded-md shadow-sm" style="width: 200px;" required>
                                                <option value="">เลือกรหัสพนักงาน</option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ $employee->id == old('employee_id', $selectedEmployeeId) ? 'selected' : '' }}>
                                                        {{ $employee->id }} <!-- แสดงรหัสพนักงาน -->
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="alert alert-danger" id="employee_id_error" style="display:none;"></div>
                                            @error('employee_id')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="w-1/2">
                                            <x-input-label for="employee_firstname" :value="__('ชื่อจริง')" />
                                            <x-text-input id="employee_firstname" name="employee_firstname" type="text" class="mt-1 block" style="width: 300px;" placeholder="ชื่อจริง" readonly />
                                            <div class="alert alert-danger" id="employee_firstname_error" style="display:none;"></div>
                                            @error('employee_firstname')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="w-1/2">
                                            <x-input-label for="employee_lastname" :value="__('นามสกุล')" />
                                            <x-text-input id="employee_lastname" name="employee_lastname" type="text" class="mt-1 block" style="width: 300px;" placeholder="นามสกุล" readonly />
                                            <div class="alert alert-danger" id="employee_lastname_error" style="display:none;"></div>
                                            @error('employee_lastname')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- บรรทัดที่สาม -->
                                    <div class="flex items-center mt-4">
                                        <div class="flex items-center">
                                            <div class="w-1/2">
                                                <x-input-label for="employee_status" :value="__('สถานะ')" />
                                                <x-text-input id="employee_status" name="employee_status" type="text" class="mt-1 block" style="width: 300px;" placeholder="สถานะ" readonly />
                                                <div class="alert alert-danger" id="employee_status_error" style="display:none;"></div>
                                                @error('employee_status')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- บรรทัดที่สอง -->
                                    <div class="flex flex-wrap gap-4">
                                        <div class="w-1/2">
                                            <x-input-label for="employee_contact_number" :value="__('เบอร์ติดต่อ')" />
                                            <x-text-input id="employee_contact_number" name="employee_contact_number" type="text" class="mt-1 block" style="width: 300px;" placeholder="เบอร์ติดต่อ" readonly />
                                            <div class="alert alert-danger" id="employee_contact_number_error" style="display:none;"></div>
                                            @error('employee_contact_number')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="w-1/2">
                                            <x-input-label for="employee_email" :value="__('อีเมลล์')" />
                                            <x-text-input id="employee_email" name="employee_email" type="text" class="mt-1 block" style="width: 300px;" placeholder="อีเมลล์" readonly />
                                            <div class="alert alert-danger" id="employee_email_error" style="display:none;"></div>
                                            @error('employee_email')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="border-gray-300 dark:border-gray-700">
                                    <div class="w-1/2">
                                        <x-input-label for="total_earning" :value="__('รายได้ทั้งหมด')" />
                                        <x-text-input id="total_earning" value="{{ $admindailysale->total_earning }}" name="total_earning" type="number" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="total_earning" placeholder="รายได้ทั้งหมด" />
                                        <div class="alert alert-danger" id="total_earning_error" style="display:none;"></div>
                                        @error('total_earning')
                                            <div class="alert alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <x-input-label for="scan_to_pay" :value="__('ยอดโอน')" />
                                        <x-text-input id="scan_to_pay" value="{{ $admindailysale->scan_to_pay }}" name="scan_to_pay" type="number" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="scan_to_pay" placeholder="ยอดโอน" />
                                        <div class="alert alert-danger" id="scan_to_pay_error" style="display:none;"></div>
                                        @error('scan_to_pay')
                                            <div class="alert alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <x-input-label for="cash" :value="__('เงินสด')" />
                                        <x-text-input id="cash" name="cash" value="{{ $admindailysale->cash }}" type="number" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="cash" placeholder="เงินสด" />
                                        <div class="alert alert-danger" id="cash_error" style="display:none;"></div>
                                        @error('cash')
                                            <div class="alert alert-success">{{ $message }}</div>
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

                var formData = new FormData($('#dailyForm')[0]); // สร้าง FormData จากฟอร์ม

                // รีเซ็ตข้อความแสดงข้อผิดพลาด
                $('#id_error').hide().text('');
                $('#product_name_error').hide().text('');
                // เพิ่มข้อความแสดงข้อผิดพลาดทั่วไป
                $('#general_error').hide().text('');

                $.ajax({
                    url: '{{ route('dailysale.admin.update', $admindailysale->id) }}', // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        alert('แก้ไขรายงานยอดขายเรียบร้อยแล้ว');
                        window.location.href = "{{ route('dailysale.admindailysales') }}";
                    },
                    error: function(xhr){
                        // กระบวนการเมื่อเกิดข้อผิดพลาด
                        console.error('Error:', xhr);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;

                            // แสดงข้อผิดพลาดในฟิลด์ที่เกี่ยวข้อง
                            if (errors.id) {
                                $('#id_error').show().text(errors.id.join(', '));
                            }
                            if (errors.product_name) {
                                $('#product_name_error').show().text(errors.product_name.join(', '));
                            }
                        } else if (xhr.status >= 500) {
                            // ข้อผิดพลาดจากเซิร์ฟเวอร์
                            $('#general_error').show().text('เกิดข้อผิดพลาดจากเซิร์ฟเวอร์ กรุณาลองอีกครั้งในภายหลัง');
                        } else {
                            // ข้อผิดพลาดอื่น ๆ
                            $('#general_error').show().text('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                        }
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#employee_id').on('change', function() {
                let id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '/employee-details-dailysale/' + id,
                        type: 'GET',
                        success: function(response) {
                            $('#employee_firstname').val(response.employee.firstname);
                            $('#employee_lastname').val(response.employee.lastname);
                            $('#employee_contact_number').val(response.employee.contact_number);
                            $('#employee_email').val(response.employee.email);
                            $('#employee_status').val(response.employee.status);

                            // เคลียร์ฟิลด์ที่ไม่จำเป็น
                        },
                        error: function(xhr) {
                            console.error('Error fetching employee details:', xhr.responseText);
                            alert('ไม่พบรายละเอียดของพนักงาน');
                        }
                    });
                } else {
                    $('#employee_firstname, #employee_lastname, #employee_contact_number, #employee_email, #employee_status').val('');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const employeeSelect = document.getElementById('employee_id');
        
            // ฟังก์ชันในการดึงข้อมูลพนักงาน
            async function getEmployeeDetails(employeeId) {
                if (!employeeId) return;
        
                try {
                    const response = await fetch(`/employee-details-dailysale/${employeeId}`);
                    if (!response.ok) {
                        throw new Error('Employee not found');
                    }
                    const data = await response.json();
                    // แสดงข้อมูลในฟิลด์ที่อ่านได้
                    document.getElementById('employee_firstname').value = data.employee.firstname;
                    document.getElementById('employee_lastname').value = data.employee.lastname;
                    document.getElementById('employee_contact_number').value = data.employee.contact_number;
                    document.getElementById('employee_email').value = data.employee.email;
                    document.getElementById('employee_status').value = data.employee.status;
                } catch (error) {
                    console.error('Error fetching employee details:', error);
                    // จัดการข้อผิดพลาดที่เหมาะสม
                }
            }
        
            // ตรวจจับการเปลี่ยนแปลงใน dropdown
            employeeSelect.addEventListener('change', function () {
                const selectedEmployeeId = this.value;
                getEmployeeDetails(selectedEmployeeId);
            });
        
            // โหลดข้อมูลพนักงานที่เลือกไว้ในเซสชันตอนโหลดหน้า
            const selectedEmployeeId = '{{ $selectedEmployeeId }}';
            if (selectedEmployeeId) {
                getEmployeeDetails(selectedEmployeeId);
            }
        });
    </script>

</x-appadmin-layout>
