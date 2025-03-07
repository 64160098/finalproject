<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('แก้ไขใบสั่งซื้อ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span>
                                    <a href="{{ route('ordernow.ordernows') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>ขั้นตอน 1</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                                <form action="{{ route('ordernow.updateStep1', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <hr class="border-gray-300 dark:border-gray-700">
                                    <div class="w-1/2">
                                        <x-input-label for="id" :value="__('รหัสใบสั่งซื้อ ')" />
                                        <x-text-input id="id" value="{{ $order->id }}" name="id" type="text" class="mt-1 block w-full" style="max-width: 350px;" required autofocus autocomplete="id" placeholder="รหัสใบสั่งซื้อ" readonly />
                                        <div class="alert alert-danger" id="id_error" style="display:none;"></div>
                                        @error('id')
                                            <div class="alert alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <x-input-label for="order_date" :value="__('วันที่สั่งซื้อ ')" />
                                        <x-text-input value="{{ $order->order_date }}" id="order_date" name="order_date" type="date" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="order_date" placeholder="วันที่สั่งซื้อ"  readonly/>
                                        <div class="alert alert-danger" id="order_date_error" style="display:none;"></div>
                                        @error('order_date')
                                            <div class="alert alert-success">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr class="my-4 border-gray-300 dark:border-gray-700">
                                        <h1 class="font-bold text-xl mb-4">ข้อมูลผู้จัดจำหน่าย</h1>
                                        <div class="flex flex-wrap gap-4">
                                            <!-- บรรทัดแรก -->
                                            <div class="w-1/2">
                                                <x-input-label for="supplier_id" :value="__('เลขที่บริษัท')" />
                                                <select id="supplier_id" name="supplier_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                                                focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-500 
                                                dark:focus:ring-indigo-600 focus:ring-opacity-50 rounded-md shadow-sm" style="width: 200px;" required>
                                                    <option value="">เลือกเลขที่บริษัท</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}" {{ $supplier->id == old('supplier_id', $selectedSupplierId) ? 'selected' : '' }}>
                                                            {{ $supplier->id }}
                                                        </option>
                                                    @endforeach
                                                </select>                                                
                                                <div class="alert alert-danger" id="supplier_id_error" style="display:none;"></div>
                                                @error('supplier_id')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="supplier_name" :value="__('ชื่อบริษัท')" />
                                                <x-text-input id="supplier_name" name="supplier_name" type="text" class="mt-1 block" style="width: 300px;" placeholder="ชื่อบริษัท" readonly />
                                                <div class="alert alert-danger" id="supplier_name_error" style="display:none;"></div>
                                                @error('supplier_name')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="supplier_product" :value="__('จำหน่ายสินค้าประเภท')" />
                                                <x-text-input id="supplier_product" name="supplier_product" type="text" class="mt-1 block" style="width: 300px;" placeholder="จำหน่ายสินค้าประเภท" readonly />
                                                <div class="alert alert-danger" id="supplier_product_error" style="display:none;"></div>
                                                @error('supplier_product')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- บรรทัดที่สอง -->
                                        <div class="flex flex-wrap gap-4">
                                            <div class="w-1/2">
                                                <x-input-label for="supplier_customer_name" :value="__('ชื่อผู้ติดต่อ')" />
                                                <x-text-input id="supplier_customer_name" name="supplier_customer_name" type="text" class="mt-1 block" style="width: 300px;" placeholder="ชื่อผู้ติดต่อ" readonly />
                                                <div class="alert alert-danger" id="supplier_customer_name_error" style="display:none;"></div>
                                                @error('supplier_customer_name')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="supplier_contact_number" :value="__('เบอร์ติดต่อ')" />
                                                <x-text-input id="supplier_contact_number" name="supplier_contact_number" type="text" class="mt-1 block" style="width: 300px;" placeholder="เบอร์ติดต่อ" readonly />
                                                <div class="alert alert-danger" id="supplier_contact_number_error" style="display:none;"></div>
                                                @error('supplier_contact_number')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="supplier_email" :value="__('อีเมลล์')" />
                                                <x-text-input id="supplier_email" name="supplier_email" type="text" class="mt-1 block" style="width: 300px;" placeholder="อีเมลล์" readonly />
                                                <div class="alert alert-danger" id="supplier_email_error" style="display:none;"></div>
                                                @error('supplier_email')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                    
                                        <h1 class="font-bold text-xl mb-4">ข้อมูลผู้สั่งซื้อ</h1>
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

                                    <div class="items-center gap-4">
                                        <x-primary-button type="submit">{{ __('ต่อไป') }}</x-primary-button>
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
            $('#supplier_id').on('change', function() {
                let id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '/supplier-details/' + id,
                        type: 'GET',
                        success: function(response) {
                            console.log(response); // ตรวจสอบข้อมูลที่ได้รับ
                            if (response.supplier) {
                                $('#supplier_name').val(response.supplier.name);
                                $('#supplier_customer_name').val(response.supplier.customer_name);
                                $('#supplier_product').val(response.supplier.product);
                                $('#supplier_contact_number').val(response.supplier.contact_number);
                                $('#supplier_email').val(response.supplier.email);
                            } else {
                                console.error('Supplier data not found in response');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error fetching supplier details:', xhr.responseText);
                            alert('ไม่พบรายละเอียดของผู้จัดจำหน่าย');
                        }
                    });
                } else {
                    $('#supplier_name, #supplier_customer_name, #supplier_product, #supplier_contact_number, #supplier_email').val('');
                }
            });
        });
    </script>    

    <script>
        $(document).ready(function() {
            $('#employee_id').on('change', function() {
                let id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '/employee-details/' + id,
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
                    const response = await fetch(`/employee-details/${employeeId}`);
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
        
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const supplierSelect = document.getElementById('supplier_id');

        // ฟังก์ชันในการดึงข้อมูลผู้จัดจำหน่าย
        async function getSupplierDetails(supplierId) {
            if (!supplierId) return;

            try {
                const response = await fetch(`/supplier-details/${supplierId}`);
                if (!response.ok) {
                    throw new Error('Supplier not found');
                }
                const data = await response.json();
                // แสดงข้อมูลในฟิลด์ที่อ่านได้
                document.getElementById('supplier_name').value = data.supplier.name;
                document.getElementById('supplier_product').value = data.supplier.product_type;
                document.getElementById('supplier_customer_name').value = data.supplier.contact_person;
                document.getElementById('supplier_contact_number').value = data.supplier.contact_number;
                document.getElementById('supplier_email').value = data.supplier.email;
            } catch (error) {
                console.error('Error fetching supplier details:', error);
                // จัดการข้อผิดพลาดที่เหมาะสม
            }
        }

        // ตรวจจับการเปลี่ยนแปลงใน dropdown
        supplierSelect.addEventListener('change', function () {
            const selectedSupplierId = this.value;
            getSupplierDetails(selectedSupplierId);
        });

        // โหลดข้อมูลผู้จัดจำหน่ายที่เลือกไว้ในเซสชันตอนโหลดหน้า
        const selectedSupplierId = '{{ $selectedSupplierId }}';
        if (selectedSupplierId) {
            getSupplierDetails(selectedSupplierId);
        }
    });
    </script>  


</x-appadmin-layout>
