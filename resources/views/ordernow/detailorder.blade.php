<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รายละเอียด') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-2">
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('ordernow.ordernows') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>รายละเอียด</span></p>
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <!-- Display warehouse details -->
                            <h3 class="text-xl mb-4"><strong>รายละเอียด</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center">
                                    <strong>เลขที่ใบสั่งซื้อ:</strong> 
                                    <span style="margin-left: 5px;">{{ $ordernow->id  }}</span>
                                </div>
                            </div> 
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center">
                                    <strong>วันที่สั่งซื้อ:</strong> 
                                    <span style="margin-left: 5px;">{{ $ordernow->order_date  }}</span>
                                </div>
                            </div> 
                            <hr class="my-4 border-gray-300 dark:border-gray-700">                                           
                            <h3 class="text-l mb-4"><strong>ข้อมูลผู้ขาย</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>เลขที่บริษัท:</strong> 
                                    <span style="margin-left: 5px;">{{ $supplier->id  }}</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ชื่อบริษัท:</strong> 
                                    <span style="margin-left: 5px;">{{ $supplier->supplier_name }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>จำหน่ายสินค้าประเภท:</strong> 
                                    <span style="margin-left: 5px;">{{ $supplier->supplier_product }}</span>
                                </div>
                            </div>  
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ชื่อผู้ติดต่อ:</strong> 
                                    <span style="margin-left: 5px;">{{ $supplier->supplier_product }}</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>เบอร์ติดต่อ:</strong> 
                                    <span style="margin-left: 5px;">{{ $supplier->supplier_contact_number }}</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>อีเมลล์:</strong> 
                                    <span style="margin-left: 5px;">{{ $supplier->supplier_email }}</span>
                                </div>
                            </div>  
                            <hr class="my-4 border-gray-300 dark:border-gray-700"> 
                            <h3 class="text-l mb-4"><strong>ข้อมูลผู้สั่งซื้อ</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>รหัสพนักงาน:</strong> 
                                    <span style="margin-left: 5px;">{{ $employee->id }}</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>ชื่อ-นามสกุล:</strong> 
                                    <span style="margin-left: 5px;">{{ $employee->employee_firstname }} {{ $employee->employee_lastname }}</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;"> <!-- กำหนด margin-right แบบ inline -->
                                    <strong>สถานะ:</strong> 
                                    <span style="margin-left: 5px;">{{ $employee->employee_status }}</span>
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>เบอร์ติดต่อ:</strong> 
                                    <span style="margin-left: 5px;">{{ $employee->employee_contact_number }}</span>
                                </div>
                                <div class="flex items-center" style="margin-right: 20px;">
                                    <strong>อีเมลล์:</strong> 
                                    <span style="margin-left: 5px;">{{ $employee->employee_email }}</span>
                                </div>
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700"> 
                            <h3 class="text-l mb-4"><strong>สินค้าที่สั่งซื้อ</strong></h3>
                            <table width="100%" border="1" cellpadding="5" cellspacing="0" class="text-gray-900 dark:text-gray-100">
                                <tbody>
                                    <tr>
                                        <td width="10%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>จำนวน</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>ราคา</strong></td>
                                    </tr>
                                @foreach ($productDetails as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->productUnit->unit }}</td>
                                        <td>{{ $product->price }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="flex items-center" style="margin-right: 20px;">
                                <strong>ราคารวม:</strong> 
                                <span style="margin-left: 5px;">{{ $ordernow->total_price }}</span>
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">  
                            <a href="{{ route('ordernow.generateorderPDF', $ordernow->id) }}">
                                <x-primary-button class="mt-6 flex items-center space-x-2">   
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                                    </svg>                                    
                                    <span>ดาวน์โหลด</span>
                                </x-primary-button>
                            </a>                                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let table = new DataTable('#productunittable');
    </script>

    <script>
        $('.delete-button-eoq').click(function(event) {
            event.preventDefault(); // ป้องกันการทำงานเริ่มต้นของลิงก์

            // แสดงตัวยืนยันการลบ
            var confirmDelete = confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?');

            // ถ้าผู้ใช้ยืนยันการลบ
            if (confirmDelete) {
                var deleteUrl = $(this).data('url'); // รับ URL สำหรับการลบ

                // ส่งคำขอลบไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // แสดงการแจ้งเตือนหลังจากการลบข้อมูล
                        alert(response.success);
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('product.products') }}";
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        alert('เกิดข้อผิดพลาดในการลบข้อมูล');
                    }
                });
            }
        });
    </script>

    <script>
        $('.delete-button').click(function(event){
            event.preventDefault(); // ป้องกันการทำงานเริ่มต้นของปุ่ม

            // แสดงตัวยืนยันการลบ
            var confirmDelete = confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?');
            
            // ถ้าผู้ใช้ยืนยันการลบ
            if (confirmDelete) {
                var zoneId = $(this).data('id');
                
                // ส่งคำขอลบไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: "".replace(':id', zoneId),
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response){
                        // แสดงการแจ้งเตือนหลังจากการลบข้อมูล
                        alert(response.success);
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "";
                    },
                    error: function(xhr){
                        console.error('Error:', xhr);
                        alert('เกิดข้อผิดพลาดในการลบข้อมูล');
                    }
                });
            }
        });
    </script>

</x-appadmin-layout>