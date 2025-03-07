<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รายละเอียดประวัติการรับสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="flex items-center gap-4">
                            <p class="bread"><span>
                                <a href="{{ route('orderhistory.orderhistorys') }}"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                / <span>รายละเอียด</span></p>
                        </div>
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <section>
                            <form id="receive-product-form" method="POST" action="{{ route('receiveproduct.store') }}">
                            @csrf
                            <div class="space-y-6">
                            <hr class="my-4 border-gray-300 dark:border-gray-700 mt-6"> 
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center">
                                    <strong>วันที่รับสินค้า:</strong> 
                                    <span style="margin-left: 5px;">{{ $receiveproducts->received_date->format('Y-m-d') }}</span>
                                </div>
                            </div> 
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center">
                                    <strong>เลขที่ใบสั่งซื้อ:</strong> 
                                    <span style="margin-left: 5px;">{{ $receiveproducts->order_id }}</span>
                                </div>
                            </div> 
                            <div class="flex flex-wrap mb-4">
                                <div class="flex items-center">
                                    <strong>วันที่สั่งซื้อ:</strong> 
                                    <span style="margin-left: 5px;">{{ $orderNow->order_date }}</span>
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
                            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="10%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>จำนวนที่สั่ง</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>จำนวนที่รับมา</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                        <td width="5%" align="left" valign="middle"><strong>ราคา</strong></td>
                                    </tr>
                                @foreach ($productDetails as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->ordered_quantity }}</td>
                                        <td>{{ $product->received_quantity }}</td> 
                                        <td>{{ $product->productUnit->unit }}</td>
                                        <td>{{ $product->price }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="flex items-center" style="margin-right: 20px;">
                                <strong>ราคารวม:</strong> 
                                <x-text-input type="text" name="total_price" id="total_price" value="{{ $orderNow->total_price }}" style="margin-left: 5px;" required autofocus autocomplete="total_price" readonly />
                            </div>
                            <div class="flex items-center" style="margin-right: 20px;">
                                <strong>ราคารวม ณ วันที่จ่ายจริง:</strong> 
                                <x-text-input type="text" name="total_price_at_received_date" id="total_price_at_received_date" value="{{ $receiveproducts->total_price_at_received_date }}" style="margin-left: 5px;" required autofocus autocomplete="total_price_at_received_date" readonly />
                            </div>                                                     
                        </div>
                    </form>
                </section> 
                </div>
            </div>
        </div>
    </div>
</x-appadmin-layout>