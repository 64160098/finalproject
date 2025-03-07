<x-appnormal-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รายละเอียดรายงานสินค้าคงเหลือ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-2">
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('inventoryreport.inventoryreports') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>รายละเอียดรายงานสินค้าคงเหลือ</span></p>
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <!-- Display warehouse details -->
                            <h3 class="text-xl mb-4"><strong>รายละเอียด</strong></h3>
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center">
                                    <strong>วันที่ทำรายการ:</strong> 
                                    <span style="margin-left: 5px;">{{ $inventoryreport->transaction_date  }}</span>
                                </div>
                            </div> 
                            <hr class="my-4 border-gray-300 dark:border-gray-700">                                           
                            <h3 class="text-l mb-4"><strong>ข้อมูลผู้รายงาน</strong></h3>
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
                            <h3 class="text-l mb-4"><strong>รายการสินค้าคงเหลือ</strong></h3>
                            <table width="100%" border="1" cellpadding="5" cellspacing="0">
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
                                        <td>{{ $product->price }} บาท</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="flex items-center" style="margin-right: 20px;">
                                <strong>ราคารวม:</strong> 
                                <span style="margin-left: 5px;">{{ $inventoryreport->total_inventory_value }} บาท</span>
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">                                                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</x-appnormal-layout>