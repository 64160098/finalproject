<style>
    .scrollable-table-container {
        max-height: 400px; /* ปรับขนาดความสูงตามต้องการ */
        overflow-y: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td, th {
        border: 1px solid #ddd;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('สร้างใบสั่งซื้อ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('ordernow.createstep1') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>ขั้นตอน 2</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                                <form id="orderForm" action="{{ route('ordernow.postStep2') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-6">
                                        <hr class="border-gray-300 dark:border-gray-700">
                                        <h1 class="font-bold text-xl mb-4">รายละเอียดใบสั่งซื้อ</h1>
                                        <div class="w-1/2">
                                            <x-input-label for="id" :value="__('รหัสใบสั่งซื้อ ')" />
                                            <x-text-input value="{{ $id }}" id="id" name="id" type="text" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="id" placeholder="รหัสใบสั่งซื้อ" readonly />
                                            <div class="alert alert-danger" id="id_error" style="display:none;"></div>
                                            @error('id')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="w-1/2">
                                            <x-input-label for="order_date" :value="__('วันที่สั่งซื้อ ')" />
                                            <x-text-input value="{{ $orderDate }}" id="order_date" name="order_date" type="date" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="order_date" placeholder="วันที่สั่งซื้อ" readonly />
                                            <div class="alert alert-danger" id="order_date_error" style="display:none;"></div>
                                            @error('order_date')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="w-1/2">
                                            <x-input-label for="supplier_id" :value="__('รหัสผู้ขาย')" />
                                            <x-text-input value="{{ $supplierId }}" id="supplier_id" name="supplier_id" type="text" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="supplier_id" placeholder="รหัสผู้ขาย" readonly />
                                            <div class="alert alert-danger" id="supplier_id_error" style="display:none;"></div>
                                            @error('supplier_id')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="w-1/2">
                                            <x-input-label for="employee_id" :value="__('รหัสพนักงาน')" />
                                            <x-text-input value="{{ $employeeId }}" id="employee_id" name="employee_id" type="text" class="mt-1 block w-full" style="max-width: 300px;" required autofocus autocomplete="employee_id" placeholder="รหัสพนักงาน" readonly />
                                            <div class="alert alert-danger" id="employee_id_error" style="display:none;"></div>
                                            @error('employee_id')
                                                <div class="alert alert-success">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <hr class="my-4 border-gray-300 dark:border-gray-700">
                                
                                        <h1 class="font-bold text-xl mb-4">เลือกรายการสินค้า</h1>
                                        <div class="scrollable-table-container">
                                            <input type="hidden" name="selected_products" id="selected_products">
                                            <table width="100%" border="1" cellpadding="5" cellspacing="0" class="text-gray-900 dark:text-gray-100">
                                                <tbody>
                                                    <tr>
                                                        <td width="5%" align="left" valign="middle"><strong>รหัส</strong></td>
                                                        <td width="16%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                                        <td width="6%" align="left" valign="middle"><strong>ประเภท</strong></td>
                                                        <td width="6%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                                        <td width="7%" align="left" valign="middle"><strong>ขนาด</strong></td>
                                                        <td width="5%" align="left" valign="middle"><strong>ราคา</strong></td>
                                                        <td width="4%" align="center" valign="middle"><strong>Action</strong></td>
                                                    </tr>
                                                    @foreach ($products as $product)
                                                    <tr>
                                                        <td width="5%" align="left" valign="middle">{{ $product->id }}</td>
                                                        <td width="16%" align="left" valign="middle">{{ $product->product_name }}</td>
                                                        <td width="6%" align="left" valign="middle">{{ $product->productType->product_type }}</td>
                                                        <td width="6%" align="left" valign="middle">{{ $product->productUnit->unit }}</td>
                                                        <td width="7%" align="left" valign="middle">{{ $product->product_width }}×{{ $product->product_length }}×{{ $product->product_height }}</td>
                                                        <td width="5%" align="left" valign="middle">{{ $product->price }}</td>
                                                        <td width="4%" align="center" valign="middle"><button type="button" class="select-btn" data-product-id="{{ $product->id }}">เลือก</button></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                
                                        <h1 class="font-bold text-xl mb-4">รายการสินค้า</h1>
                                        <table width="100%" border="1" cellpadding="5" cellspacing="0" class="text-gray-900 dark:text-gray-100">
                                            <tbody>
                                                <tr>
                                                    <td width="5%" align="left" valign="middle"><strong>รหัส</strong></td>
                                                    <td width="16%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                                    <td width="6%" align="left" valign="middle"><strong>ประเภท</strong></td>
                                                    <td width="6%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                                    <td width="7%" align="left" valign="middle"><strong>ขนาด</strong></td>
                                                    <td width="5%" align="left" valign="middle"><strong>ราคา</strong></td>
                                                    <td width="5%" align="left" valign="middle"><strong>จำนวน</strong></td>
                                                    <td width="4%" align="center" valign="middle"><strong>Action</strong></td>
                                                </tr>
                                            </tbody>
                                            <tbody id="selectedProducts">
                                                <!-- รายการสินค้าที่เลือกจะแสดงที่นี่ -->
                                            </tbody>
                                        </table>
                                        <div id="totalPrice" class="font-bold text-xl mt-4">ราคารวม: 0.00</div>
                                
                                        <div class="items-center gap-4">
                                            <x-primary-button id="submit-button" type="submit">{{ __('บันทึกข้อมูล') }}</x-primary-button>
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
            // ฟังก์ชันอัปเดตค่าที่ซ่อนและราคารวม
            function updateSelectedProducts() {
                var products = [];
                var totalPrice = 0;

                $('#selectedProducts tr').each(function() {
                    var productId = $(this).find('.quantity-input').data('product-id');
                    var quantity = $(this).find('.quantity-input').val();
                    var price = parseFloat($(this).find('td:eq(5)').text()); // ดึงราคา
                    totalPrice += price * quantity; // คำนวณราคารวม
                    products.push({ id: productId, quantity: quantity });
                });

                // อัปเดต input hidden
                $('#selected_products').val(JSON.stringify(products));

                // แสดงราคารวม
                $('#totalPrice').text('ราคารวม: ' + totalPrice.toFixed(2));
            }

            // เพิ่มสินค้าเข้ารายการเมื่อคลิกที่ปุ่มเลือกสินค้า
            $('.select-btn').on('click', function() {
                var productId = $(this).data('product-id');
                var row = $(this).closest('tr');
                var productName = row.find('td:eq(1)').text(); // ดึงชื่อสินค้า
                var productType = row.find('td:eq(2)').text(); // ดึงประเภทสินค้า
                var productUnit = row.find('td:eq(3)').text(); // ดึงหน่วยนับ
                var productSize = row.find('td:eq(4)').text(); // ดึงขนาดสินค้า
                var productPrice = parseFloat(row.find('td:eq(5)').text()); // ดึงราคาและแปลงเป็นเลขทศนิยม

                // ตรวจสอบว่ามีสินค้านี้อยู่ในรายการแล้วหรือยัง
                var existingRow = $('#selectedProducts').find(`tr:has(.quantity-input[data-product-id="${productId}"])`);
                if (existingRow.length) {
                    var quantityInput = existingRow.find('.quantity-input');
                    quantityInput.val(parseInt(quantityInput.val()) + 1);
                } else {
                    // สร้างรายการสินค้าที่เลือก
                    $('#selectedProducts').append(
                        `<tr>
                            <td width="5%" align="left" valign="middle">${productId}</td>
                            <td width="16%" align="left" valign="middle">${productName}</td>
                            <td width="6%" align="left" valign="middle">${productType}</td>
                            <td width="6%" align="left" valign="middle">${productUnit}</td>
                            <td width="7%" align="left" valign="middle">${productSize}</td>
                            <td width="5%" align="left" valign="middle">${productPrice.toFixed(2)}</td>
                            <td width="5%" align="left" valign="middle">
                                <input type="number" class="quantity-input" data-product-id="${productId}" value="1" min="1">
                            </td>
                            <td width="4%" align="center" valign="middle">
                                <button type="button" class="remove-btn" data-product-id="${productId}">ลบ</button>
                            </td>
                        </tr>`
                    );
                }
                updateSelectedProducts(); // อัปเดตค่าที่ซ่อนและราคารวม
            });

            // ลบรายการสินค้า
            $('#selectedProducts').on('click', '.remove-btn', function() {
                $(this).closest('tr').remove();
                updateSelectedProducts(); // อัปเดตค่าที่ซ่อนและราคารวม
            });

            // เปลี่ยนจำนวนสินค้า
            $('#selectedProducts').on('input', '.quantity-input', function() {
                updateSelectedProducts(); // อัปเดตค่าที่ซ่อนและราคารวม
            });

            // อัปเดตราคารวมเมื่อโหลดหน้า
            updateSelectedProducts();
        });
    </script>         
       
       <script>
        $(document).ready(function(){
            // ตั้งค่า CSRF token ใน AJAX request headers
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            $('#submit-button').click(function(event){
                event.preventDefault(); // ป้องกันการส่งฟอร์มไปยังเซิร์ฟเวอร์
        
                var formData = new FormData($('#orderForm')[0]); // สร้าง FormData จากฟอร์มที่มี id="orderForm"
        
                // รีเซ็ตข้อความแสดงข้อผิดพลาด
                $('#id_error').hide().text('');
                $('#product_name_error').hide().text('');
        
                $.ajax({
                    url: '{{ route('ordernow.postStep2') }}', // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        alert('สร้างใบสั่งซื้อเรียบร้อยแล้ว');
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('ordernow.ordernows') }}";
                    },
                    error: function(xhr){
                        // กระบวนการเมื่อเกิดข้อผิดพลาด
                        console.error('Error:', xhr); // แสดงข้อผิดพลาดในคอนโซล
                        var errorMessage = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'; // ข้อความพื้นฐานที่จะแสดงให้ผู้ใช้
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message; // ใช้ข้อความจากเซิร์ฟเวอร์ถ้ามี
                        }
                        alert(errorMessage); // แสดงข้อความผิดพลาดให้แก่ผู้ใช้
                    }
                });
            });
        });
        </script>
             
    
    
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

</x-appadmin-layout>
