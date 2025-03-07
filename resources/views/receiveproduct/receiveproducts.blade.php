<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รับสินค้าเข้าคลัง') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                            <div>
                                <a href="{{ route('receiveproduct.create') }}" class="">
                                    <x-primary-button style="background-color: #28A745; color: white; text-shadow: 1px 1px 2px black;">
                                        เลือกข้อมูลใบสั่งซื้อ
                                    </x-primary-button>
                                </a>
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
                            <div class="flex flex-wrap gap-4">
                                <div class="w-1/2">
                                    <x-input-label for="received_date" :value="__('วันที่รับสินค้า')" />
                                    <x-text-input wire:model="received_date" value="{{ old('received_date', $currentDate) }}" id="received_date" name="received_date" type="date" class="mt-1 block" style="width: 300px;" required autofocus autocomplete="received_date" placeholder="วันที่รับสินค้า" />
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
                                        value="{{ optional($ordernow)->id ?? 'กรุณาเลือกข้อมูลใบสั่งซื้อ' }}" />
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
                                            value="{{ optional($ordernow)->order_date }}" readonly />
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
                                        value="{{ optional($supplier)->id }}" readonly />
                                    <div class="alert alert-danger" id="supplier_id_error" style="display:none;"></div>
                                    @error('supplier_id')
                                        <div class="alert alert-success">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-1/2">
                                    <x-input-label for="supplier_name" :value="__('ชื่อบริษัท')" />
                                    <x-text-input wire:model="supplier_name" id="supplier_name" name="supplier_name" type="text" class="mt-1 block" style="width: 300px;" 
                                        value="{{ optional($supplier)->supplier_name }}" readonly />
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
                                            value="{{ optional($supplier)->supplier_product }}" readonly />
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
                                        value="{{ optional($supplier)->supplier_name }}" readonly />
                                    <div class="alert alert-danger" id="supplier_name_error" style="display:none;"></div>
                                    @error('supplier_name')
                                        <div class="alert alert-success">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-24">
                                    <x-input-label for="supplier_contact_number" :value="__('เบอร์ติดต่อ')" />
                                    <x-text-input wire:model="supplier_contact_number" id="supplier_contact_number" name="supplier_contact_number" type="text" class="mt-1 block" style="width: 300px;" 
                                        value="{{ optional($supplier)->supplier_contact_number }}" readonly />
                                    <div class="alert alert-danger" id="supplier_contact_number_error" style="display:none;"></div>
                                    @error('supplier_contact_number')
                                        <div class="alert alert-success">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-24">
                                    <x-input-label for="supplier_email" :value="__('อีเมลล์')" />
                                    <x-text-input wire:model="supplier_email" id="supplier_email" name="supplier_email" type="text" class="mt-1 block" style="width: 300px;" 
                                        value="{{ optional($supplier)->supplier_email }}" readonly />
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
                                        value="{{ optional($employee)->id }}" readonly />
                                    <div class="alert alert-danger" id="employee_id_error" style="display:none;"></div>
                                    @error('employee_id')
                                        <div class="alert alert-success">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- ช่องกรอกชื่อ-นามสกุล -->
                                <div class="w-1/2">
                                    <x-input-label for="employee_name" :value="__('ชื่อ-นามสกุล')" />
                                    <x-text-input wire:model="employee_name" id="employee_name" name="employee_name" type="text" class="mt-1 block" style="width: 300px;" 
                                        value="{{ optional($employee)->employee_firstname }} {{ optional($employee)->employee_lastname }}" readonly />
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
                                        value="{{ optional($employee)->employee_status }}" readonly />
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
                                        value="{{ optional($employee)->employee_contact_number }}" readonly />
                                    <div class="alert alert-danger" id="employee_contact_number_error" style="display:none;"></div>
                                    @error('employee_contact_number')
                                        <div class="alert alert-success">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- ช่องกรอกอีเมลล์ -->
                                <div class="w-1/2">
                                    <x-input-label for="employee_email" :value="__('อีเมลล์')" />
                                    <x-text-input wire:model="employee_email" id="employee_email" name="employee_email" type="text" class="mt-1 block" style="width: 300px;" 
                                        value="{{ optional($employee)->employee_email }}" readonly />
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
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                                        <input type="hidden" name="products[{{ $index }}][ordered_quantity]" value="{{ $product->quantity }}">
                                        <td>{{ $product->quantity }}</td>
                                        <td>
                                            <x-text-input type="number" name="products[{{ $index }}][received_quantity]" value="" min="0" class="mt-1 block w-full" style="max-width: 100px;" />
                                        </td>
                                        <td>{{ $product->productUnit->unit }}</td>
                                        <td>{{ $product->price }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="flex items-center" style="margin-right: 20px;">
                                <strong>ราคารวม:</strong> 
                                <x-text-input type="text" name="total_price" id="total_price" value="{{ old('total_price', optional($ordernow)->total_price) }}" style="margin-left: 5px;" required autofocus autocomplete="total_price" readonly />
                            </div>
                            <div class="flex items-center" style="margin-right: 20px;">
                                <strong>ราคารวม ณ วันที่จ่ายจริง:</strong> 
                                <x-text-input type="text" name="total_price_at_received_date" id="total_price_at_received_date" value="{{ old('total_price_at_received_date', '0.00') }}" style="margin-left: 5px;" required autofocus autocomplete="total_price_at_received_date" readonly />
                            </div>                         
                            
                        <div id="submit-btn">
                            <x-primary-button id="confirm-button"> ยืนยันการรับสินค้า </x-primary-button>
                        </div>   
                    </div>
                </form>
                </section> 
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let table = new DataTable('#producttable');
    </script>

    <script>
        $(document).ready(function(){
            $('#confirm-button').click(function(event){
                event.preventDefault(); // ป้องกันการส่งฟอร์มไปยังเซิร์ฟเวอร์

                var formData = $('#receive-product-form').serializeArray();
                var productData = {}; // เก็บข้อมูลสินค้า
                var isValid = true;

                // รวบรวมข้อมูลสินค้าในรูปแบบอาร์เรย์
                $.each(formData, function(i, field) {
                    if (field.name.startsWith('products[')) {
                        var index = field.name.match(/\[(\d+)\]/)[1];
                        if (!productData[index]) {
                            productData[index] = {};
                        }
                        productData[index][field.name.split('][')[1].split(']')[0]] = field.value;
                    }
                });

                // ตรวจสอบจำนวนที่กรอกไม่เกินจำนวนที่มีอยู่
                $.each(productData, function(index, product) {
                    var orderedQuantity = parseInt(product['ordered_quantity'], 10);
                    var receivedQuantity = parseInt(product['received_quantity'], 10);

                    if (receivedQuantity > orderedQuantity) {
                        alert('จำนวนที่รับสินค้าไม่สามารถเกินจำนวนที่สั่งซื้อได้');
                        isValid = false;
                        return false; // ออกจาก loop
                    }
                });

                if (isValid) {
                    // ตรวจสอบว่ามีข้อมูลใบสั่งซื้อตัวใดถูกเลือกหรือไม่
                    var hasData = false;
                    $.each(productData, function(index, product) {
                        if (product['received_quantity'] && product['received_quantity'] > 0) {
                            hasData = true;
                            return false; // ออกจาก loop
                        }
                    });

                    if (!hasData) {
                        alert('กรุณาเลือกข้อมูลใบสั่งซื้อเพื่อทำรายการ');
                        return;
                    }

                    // แสดงกล่องยืนยันก่อนส่งข้อมูล
                    if (confirm('กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนกดยืนยัน')) {
                        // ส่งข้อมูลไปยังเซิร์ฟเวอร์ถ้าผู้ใช้กดยืนยัน
                        $.ajax({
                            url: "{{ route('receiveproduct.store') }}",
                            type: 'POST',
                            data: formData,
                            success: function(response){
                                if (response.success) {
                                    alert('รับสินค้าสำเร็จ');
                                    window.location.href = "{{ route('orderhistory.orderhistorys') }}";
                                } else {
                                    console.error('Unexpected response format:', response);
                                    alert('กรุณาเลือกข้อมูลใบสั่งซื้อเพื่อทำรายการ');
                                }
                            },
                            error: function(xhr, status, error){
                                console.error('Error:', error);
                                alert('กรุณาเลือกข้อมูลใบสั่งซื้อเพื่อทำรายการ');
                            }
                        });
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            // ฟังก์ชันคำนวณราคารวม
            function calculateTotalPrice() {
                var totalPrice = 0;

                // วนลูปผ่านแต่ละแถวในตารางเพื่อคำนวณราคารวม
                $('table tbody tr').each(function(){
                    var price = parseFloat($(this).find('td').eq(4).text()); // ราคา
                    var receivedQuantity = parseFloat($(this).find('input[name*="[received_quantity]"]').val()); // จำนวน ณ วันรับ

                    if (!isNaN(price) && !isNaN(receivedQuantity)) {
                        totalPrice += price * receivedQuantity; // คำนวณราคาสำหรับแต่ละรายการ
                    }
                });

                // แสดงราคารวมในช่อง "ราคารวม ณ วันที่จ่ายจริง"
                $('#total_price_at_received_date').val(totalPrice.toFixed(2)); // ตั้งค่าเป็นค่า 2 ตำแหน่งทศนิยม
            }

            // เรียกใช้ฟังก์ชันคำนวณเมื่อโหลดหน้าเว็บ
            calculateTotalPrice();

            // เพิ่มการฟังเหตุการณ์เพื่อคำนวณใหม่เมื่อข้อมูลเปลี่ยนแปลง
            $('input[name*="[received_quantity]"]').on('input', function() {
                calculateTotalPrice();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#cancel-button').click(function(event) {
                event.preventDefault();
                
                if (confirm('คุณต้องการยกเลิกรายการสินค้าทั้งหมดใช่หรือไม่?')) {
                    $.ajax({
                        url: "{{ route('receiveproduct.deleteAll') }}",
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response); // แสดงผลลัพธ์ในคอนโซล
                            alert(response.success); // แสดง alert จากการตอบสนอง JSON
                            window.location.reload(); // รีโหลดหน้าเพจใหม่
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
        });
    </script>

</x-appadmin-layout>