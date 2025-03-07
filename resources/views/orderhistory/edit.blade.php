<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('แก้ไขประวัติการรับสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('orderhistory.orderhistorys') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>แก้ไขประวัติการรับสินค้า</span></p>
                            </div>
                            <section>
                                <form action="{{ route('orderhistory.update', $receiveproduct->order_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="space-y-6">
                                        <div class="flex flex-wrap gap-4">
                                            <div class="w-1/2">
                                                <x-input-label for="received_date" :value="__('วันที่รับสินค้า')" />
                                                <x-text-input wire:model="received_date" value="{{ \Carbon\Carbon::parse($receiveproduct->received_date)->format('Y-m-d') }}" id="received_date" name="received_date" type="text" class="mt-1 block" style="width: 300px;" required autofocus autocomplete="received_date" placeholder="วันที่รับสินค้า" readonly />
                                                <div class="alert alert-danger" id="received_date_error" style="display:none;"></div>
                                                @error('received_date')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>                            
                                        <hr class="my-4 border-gray-300 dark:border-gray-700"> 
                                        <h1 class="font-bold text-xl mb-4">รายละเอียด</h1>
                                        <div class="flex flex-wrap gap-4">
                                            <div class="w-1/2">
                                                <x-input-label for="order_id" :value="__('เลขที่ใบสั่งซื้อ')" />
                                                <x-text-input wire:model="order_id" id="order_id" name="order_id" type="text" class="mt-1 block" style="width: 300px;" required autofocus autocomplete="order_id" placeholder="เลขที่ใบสั่งซื้อ" readonly
                                                    value="{{ $receiveproduct->order_id }}" />
                                                <div class="alert alert-danger" id="order_id_error" style="display:none;"></div>
                                                @error('order_id')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>  
                                        <!-- บรรทัดที่สอง -->
                                        <div class="flex items-center mt-4">
                                            <div class="flex items-center">
                                                <div class="w-24">
                                                    <x-input-label for="order_date" :value="__('วันที่สั่งซื้อ')" />
                                                    <x-text-input wire:model="order_date" id="order_date" name="order_date" type="text" class="mt-1 block" style="width: 300px;" required autofocus autocomplete="order_date" 
                                                        value="{{ $receiveproduct->order_date }}" readonly />
                                                    <div class="alert alert-danger" id="order_date_error" style="display:none;"></div>
                                                    @error('order_date')
                                                        <div class="alert alert-success">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-4 border-gray-300 dark:border-gray-700">                                           
                                        <h3 class="text-l mb-4"><strong>ข้อมูลผู้ขาย</strong></h3>
                                        <div class="flex flex-wrap gap-4">
                                            <div class="w-1/2">
                                                <x-input-label for="supplier_id" :value="__('เลขที่บริษัท')" />
                                                <x-text-input wire:model="supplier_id" id="supplier_id" name="supplier_id" type="text" class="mt-1 block" style="width: 300px;" required autofocus autocomplete="supplier_id" 
                                                    value="{{ $supplier->id }}" readonly />
                                                <div class="alert alert-danger" id="supplier_id_error" style="display:none;"></div>
                                                @error('supplier_id')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-1/2">
                                                <x-input-label for="supplier_name" :value="__('ชื่อบริษัท')" />
                                                <x-text-input wire:model="supplier_name" id="supplier_name" name="supplier_name" type="text" class="mt-1 block" style="width: 300px;" 
                                                    value="{{ $supplier->supplier_name }}" readonly />
                                                <div class="alert alert-danger" id="supplier_name_error" style="display:none;"></div>
                                                @error('supplier_name')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
            
                                        <!-- บรรทัดที่สอง -->
                                        <div class="flex items-center mt-4">
                                            <div class="flex items-center">
                                                <div class="w-24">
                                                    <x-input-label for="supplier_product" :value="__('จำหน่ายสินค้าประเภท')" />
                                                    <x-text-input wire:model="supplier_product" id="supplier_product" name="supplier_product" type="text" class="mt-1 block" style="width: 300px;" 
                                                        value="{{ $supplier->supplier_product }}" readonly />
                                                    <div class="alert alert-danger" id="supplier_product_error" style="display:none;"></div>
                                                    @error('supplier_product')
                                                        <div class="alert alert-success">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
            
                                        <!-- บรรทัดที่สาม -->
                                        <div class="flex flex-wrap gap-4">
                                            <div class="w-24">
                                                <x-input-label for="supplier_name" :value="__('ชื่อผู้ติดต่อ')" />
                                                <x-text-input wire:model="supplier_name" id="supplier_name" name="supplier_name" type="text" class="mt-1 block" style="width: 300px;" 
                                                    value="{{ $supplier->supplier_name }}" readonly />
                                                <div class="alert alert-danger" id="supplier_name_error" style="display:none;"></div>
                                                @error('supplier_name')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-24">
                                                <x-input-label for="supplier_contact_number" :value="__('เบอร์ติดต่อ')" />
                                                <x-text-input wire:model="supplier_contact_number" id="supplier_contact_number" name="supplier_contact_number" type="text" class="mt-1 block" style="width: 300px;" 
                                                    value="{{ $supplier->supplier_contact_number }}" readonly />
                                                <div class="alert alert-danger" id="supplier_contact_number_error" style="display:none;"></div>
                                                @error('supplier_contact_number')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="w-24">
                                                <x-input-label for="supplier_email" :value="__('อีเมลล์')" />
                                                <x-text-input wire:model="supplier_email" id="supplier_email" name="supplier_email" type="text" class="mt-1 block" style="width: 300px;" 
                                                    value="{{ $supplier->supplier_email }}" readonly />
                                                <div class="alert alert-danger" id="supplier_email_error" style="display:none;"></div>
                                                @error('supplier_email')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <hr class="my-4 border-gray-300 dark:border-gray-700"> 
            
                                        <h3 class="text-l mb-4"><strong>ข้อมูลผู้สั่งซื้อ</strong></h3>
            
                                        <div class="flex flex-wrap gap-4">
                                            <!-- ช่องกรอกรหัสพนักงาน -->
                                            <div class="w-1/2">
                                                <x-input-label for="employee_id" :value="__('รหัสพนักงาน')" />
                                                <x-text-input wire:model="employee_id" id="employee_id" name="employee_id" type="text" class="mt-1 block" style="width: 300px;" required autofocus autocomplete="employee_id"
                                                    value="{{ $employee->id }}" readonly />
                                                <div class="alert alert-danger" id="employee_id_error" style="display:none;"></div>
                                                @error('employee_id')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!-- ช่องกรอกชื่อ-นามสกุล -->
                                            <div class="w-1/2">
                                                <x-input-label for="employee_name" :value="__('ชื่อ-นามสกุล')" />
                                                <x-text-input wire:model="employee_name" id="employee_name" name="employee_name" type="text" class="mt-1 block" style="width: 300px;" 
                                                    value="{{ $employee->employee_firstname }} {{ $employee->employee_lastname }}" readonly />
                                                <div class="alert alert-danger" id="employee_name_error" style="display:none;"></div>
                                                @error('employee_name')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-wrap gap-4 mt-4">
                                            <!-- ช่องกรอกสถานะ -->
                                            <div class="w-1/2">
                                                <x-input-label for="employee_status" :value="__('สถานะ')" />
                                                <x-text-input wire:model="employee_status" id="employee_status" name="employee_status" type="text" class="mt-1 block" style="width: 300px;" 
                                                    value="{{ $employee->employee_status }}" readonly />
                                                <div class="alert alert-danger" id="employee_status_error" style="display:none;"></div>
                                                @error('employee_status')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-wrap gap-4 mt-4">
                                            <!-- ช่องกรอกเบอร์ติดต่อ -->
                                            <div class="w-1/2">
                                                <x-input-label for="employee_contact_number" :value="__('เบอร์ติดต่อ')" />
                                                <x-text-input wire:model="employee_contact_number" id="employee_contact_number" name="employee_contact_number" type="text" class="mt-1 block" style="width: 300px;" 
                                                    value="{{ $employee->employee_contact_number }}" readonly />
                                                <div class="alert alert-danger" id="employee_contact_number_error" style="display:none;"></div>
                                                @error('employee_contact_number')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!-- ช่องกรอกอีเมลล์ -->
                                            <div class="w-1/2">
                                                <x-input-label for="employee_email" :value="__('อีเมลล์')" />
                                                <x-text-input wire:model="employee_email" id="employee_email" name="employee_email" type="text" class="mt-1 block" style="width: 300px;" 
                                                    value="{{ $employee->employee_email }}" readonly />
                                                <div class="alert alert-danger" id="employee_email_error" style="display:none;"></div>
                                                @error('employee_email')
                                                    <div class="alert alert-success">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <hr class="my-4 border-gray-300 dark:border-gray-700"> 
                                        <h3 class="text-l mb-4"><strong>สินค้าที่สั่งซื้อ</strong></h3>
                                        <table width="100%" border="1" cellpadding="5" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td width="10%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                                    <td width="5%" align="left" valign="middle"><strong>จำนวนที่สั่ง</strong></td>
                                                    <td width="5%" align="left" valign="middle"><strong>จำนวน ณ วันรับ</strong></td>
                                                    <td width="5%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                                    <td width="5%" align="left" valign="middle"><strong>ราคา</strong></td>
                                                </tr>
                                                @foreach ($productDetails as $index => $product)
                                                <tr class="product-row">
                                                    <td>{{ $product->product_name }}</td>
                                                    <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                                                    <input type="hidden" name="products[{{ $index }}][ordered_quantity]" value="{{ $product->ordered_quantity }}">
                                                    
                                                    <td>{{ $product->ordered_quantity }}</td>
                                                    <td>
                                                        <x-text-input type="number" name="products[{{ $index }}][received_quantity]" 
                                                                      value="{{ $product->received_quantity ?? 0 }}" 
                                                                      min="0" class="received-quantity mt-1 block w-full" style="max-width: 100px;"/>
                                                    </td>
                                                    <td>{{ $product->productUnit->unit }}</td>
                                                    <td class="product-price">{{ $product->price }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        
                                        <div class="flex items-center" style="margin-right: 20px;">
                                            <strong>ราคารวม:</strong> 
                                            <x-text-input type="text" name="total_price" id="total_price" value="{{ old('total_price', $receiveproduct->total_price) }}" style="margin-left: 5px;" required autofocus autocomplete="total_price" readonly />
                                        </div>
                                        
                                        <div class="flex items-center" style="margin-right: 20px;">
                                            <strong>ราคารวม ณ วันที่จ่ายจริง:</strong> 
                                            <x-text-input type="text" name="total_price_at_received_date" id="total_price_at_received_date" 
                                                          value="{{ old('total_price_at_received_date', $receiveproduct->total_price_at_received_date) }}" 
                                                          style="margin-left: 5px;" required autofocus autocomplete="total_price_at_received_date" readonly />
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
    
                var valid = true; // กำหนดตัวแปรเพื่อตรวจสอบความถูกต้อง
                var errorMessage = ''; // เก็บข้อความแจ้งเตือนข้อผิดพลาด
    
                // วนลูปตรวจสอบทุกแถวของสินค้า
                $('.product-row').each(function(index, element) {
                    var receivedQuantity = parseFloat($(this).find('.received-quantity').val()); // จำนวนที่กรอก
                    var orderedQuantity = parseFloat($(this).find('input[name="products[' + index + '][ordered_quantity]"]').val()); // จำนวนที่สั่ง
    
                    // ตรวจสอบว่าจำนวนที่กรอกเกินกว่าจำนวนที่สั่งหรือไม่
                    if (receivedQuantity > orderedQuantity) {
                        errorMessage += 'จำนวนที่รับสินค้าไม่สามารถเกินจำนวนที่สั่งซื้อได้\n'; // เปลี่ยนข้อความที่นี่
                        valid = false; // ถ้ามีจำนวนที่เกิน จะเปลี่ยน valid เป็น false
                    }
                });
    
                // ถ้าพบข้อผิดพลาด (จำนวนที่รับเกิน)
                if (!valid) {
                    alert(errorMessage); // แสดงการแจ้งเตือนข้อผิดพลาด
                    return; // หยุดการทำงานของฟอร์ม
                }
    
                // ถ้าข้อมูลถูกต้อง ทำการส่งฟอร์มด้วย AJAX
                var formData = new FormData($('form')[0]); // สร้าง FormData จากฟอร์ม
                
                if (confirm('กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนกดยืนยัน')) {
                    $.ajax({
                        url: '{{ route('orderhistory.update', $receiveproduct->order_id) }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            // กระบวนการเมื่อสำเร็จ
                            console.log(response); // แสดงผลลัพธ์ในคอนโซล
                            alert('แก้ไขข้อมูลการรับสินค้าเรียบร้อยแล้ว');
                            window.location.href = "{{ route('orderhistory.orderhistorys') }}";
                        },
                        error: function(xhr){
                            console.error('Error:', xhr);
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                var errorMessage = '';
                                if (errorMessage) {
                                    alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล:\n' + errorMessage); // แสดงข้อผิดพลาดใน alert
                                }
                            } else {
                                alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล'); // แจ้งเตือนเมื่อมีข้อผิดพลาดทั่วไป
                            }
                        }
                    });
                }
            });
        });
    </script>    

    <script>
        function calculateTotalPrice() {
            let totalPrice = 0;

            document.querySelectorAll('.product-row').forEach(row => {
                const receivedQuantity = parseFloat(row.querySelector('.received-quantity').value) || 0;
                const price = parseFloat(row.querySelector('.product-price').textContent) || 0;
                totalPrice += receivedQuantity * price;
            });

            document.getElementById('total_price_at_received_date').value = totalPrice.toFixed(2);
        }

        // คำนวณทุกครั้งที่มีการเปลี่ยนแปลงจำนวนที่รับ
        document.querySelectorAll('.received-quantity').forEach(input => {
            input.addEventListener('input', calculateTotalPrice);
        });

        // คำนวณครั้งแรกเมื่อโหลดหน้า
        calculateTotalPrice();
    </script>

</x-appadmin-layout>
