<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('รายละอียดการใช้งาน Economic Order Quantity (EOQ)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread">
                                    <span>
                                        <a href="{{ route('product.createeoq') }}"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                ย้อนกลับ
                                        </a>
                                    </span> /
                                    <span>
                                        Economic Order Quantity (EOQ)
                                    </span> / 
                                    <a href="{{ route('product.detailrop') }}"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        Reorder Point (ROP)
                                    </a>
                                </p> 
                            </div>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <!-- Display EOQ details -->
                            <h3 class="text-xl mb-4 mt-6"><strong>สมการ Economic Order Quantity (EOQ)</strong></h3>
                            <p>สมการของ EOQ คือ:</p>

                                <!-- Display EOQ equation -->
                                <p>$$EOQ = \sqrt{\frac{2DS}{H}}$$</p>

                            <p>โดยที่:</p>
                            <br>
                            <p><strong>EOQ</strong> คือ ขนาดการสั่งซื้อที่เหมาะสม (Economic Order Quantity)</p>
                            <br>
                            <p><strong>𝐷 (Demand)</strong> คือ ความต้องการสินค้าต่อปี (Annual Demand)</p>
                            <br>
                            <p><strong>S (Order Cost)</strong> คือ ต้นทุนในการสั่งซื้อสินค้าหนึ่งครั้ง (Ordering Cost per Order)</p>
                            <br>
                            <p><strong>𝐻 (Holding Cost)</strong> คือ ต้นทุนการเก็บรักษาสินค้าหนึ่งหน่วยต่อปี (Holding Cost per Unit per Year)</p>
                            <br>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <h3 class="text-xl mb-4 mt-6"><strong>วิธีการหาค่า Demand (𝐷)</strong></h3>
                            <p><strong>รวบรวมข้อมูลยอดขายหรือการใช้งาน:</strong>  ใช้ข้อมูลจากระบบบัญชีหรือรายงานยอดขายเพื่อหายอดการใช้งานสินค้าตลอดทั้งปี</p>
                            <br>
                            <p><strong>คำนวณยอดการใช้งานประจำปี:</strong></p><br>
                            <ul style="margin-left: 20px;">
                                <li>หากข้อมูลรายเดือน: รวมยอดขายจากทุกเดือน</li>
                                <li>หากข้อมูลรายไตรมาส: รวมยอดขายจากทุกไตรมาส</li>
                                <li>หากข้อมูลรายสัปดาห์: รวมยอดขายจากทุกสัปดาห์</li>
                            </ul>
                            <br>
                            <p><strong>ตัวอย่างการคำนวณ:</strong></p>
                            <br>
                            <p>สมมติว่าคุณขายสินค้าได้ 1,000 หน่วยในเดือนมกราคม, 1,200 หน่วยในเดือนกุมภาพันธ์, และยอดขายรวมตลอดทั้งปีเป็น 12,000 หน่วย</p>
                            <br>
                            <p><strong>D</strong> = 12,000 หน่วย</p>
                            <br>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <h3 class="text-xl mb-4 mt-6"><strong>วิธีการหาค่า Order Cost (S)</strong></h3>
                            <p><strong>พิจารณาต้นทุนที่เกี่ยวข้องกับการสั่งซื้อ:</strong>  รวมค่าใช้จ่ายในการสั่งซื้อสินค้าหนึ่งครั้ง เช่น ค่าจัดส่ง, ค่าคอมมิชชัน, หรือค่าใช้จ่ายอื่นๆ</p>
                            <p>$$S = \text{รวมค่าใช้จ่ายในการจัดการคำสั่งซื้อ} + \text{ค่าใช้จ่ายในการขนส่งและการจัดส่งสินค้า} + \text{ค่าใช้จ่ายในการรับและจัดเก็บสินค้า}$$</p>
                            <p><strong>ตัวอย่าง:</strong></p>
                            <br>
                            <p>สมมติว่าคุณมีข้อมูลค่าใช้จ่ายดังนี้:</p>
                            <br>
                            <ul style="margin-left: 20px;">
                                <li><strong>ค่าใช้จ่ายในการจัดการคำสั่งซื้อ:</strong> 1,000 บาท</li>
                                <li><strong>ค่าใช้จ่ายในการขนส่งและการจัดส่งสินค้า:</strong> 2,500 บาท</li>
                                <li><strong>ค่าใช้จ่ายในการรับและจัดเก็บสินค้า:</strong> 500 บาท</li>
                                <li><strong>ค่าแรงงาน:</strong> คำนวณค่าใช้จ่ายในการจัดการสินค้า เช่น ค่าแรงงานในการจัดการคลังสินค้า</li>
                            </ul>
                            <br>
                            <p>การคำนวณ Order Cost (S) จะเป็นดังนี้:</p>
                            <p>$$S = 1,000 \text{ บาท} + 2,500 \text{ บาท} + 500 \text{ บาท} = 4,000 \text{ บาท}$$</p>
                            <br>
                            <p><strong>S</strong> = 4000 บาท</p>
                            <br>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <h3 class="text-xl mb-4 mt-6"><strong>วิธีการหาค่า Holding Cost (𝐻)</strong></h3>
                            <p><strong>1. รวบรวมข้อมูลต้นทุน</strong></p>
                            <br>
                            <ul style="margin-left: 20px;">
                                <li><strong>ค่าเช่าพื้นที่เก็บสินค้า:</strong> คำนวณค่าใช้จ่ายที่เกี่ยวข้องกับพื้นที่เก็บสินค้า เช่น ค่าเช่าคลังสินค้า, ค่าใช้จ่ายในการทำความสะอาด</li>
                                <li><strong>ค่าบำรุงรักษา:</strong> คำนวณค่าใช้จ่ายในการบำรุงรักษาสินค้า เช่น ค่าบำรุงรักษาและค่าใช้จ่ายในการจัดเก็บ</li>
                                <li><strong>ค่าเสื่อมสภาพ:</strong> ประมาณการค่าใช้จ่ายที่เกิดจากการเสื่อมสภาพหรือการสูญเสียสินค้า เช่น การสูญเสียหรือการหมดอายุของสินค้า</li>
                                <li><strong>ค่าแรงงาน:</strong> คำนวณค่าใช้จ่ายในการจัดการสินค้า เช่น ค่าแรงงานในการจัดการคลังสินค้า</li>
                            </ul>
                            <br>
                            <p><strong>2. รวมค่าใช้จ่ายทั้งหมด:</strong>  รวมค่าใช้จ่ายที่เกี่ยวข้องกับการเก็บรักษาสินค้า</p>
                            <br>
                            <p>$$\text{Total Annual Holding Costs} = \text{ค่าเช่าพื้นที่เก็บสินค้า} + \text{ค่าบำรุงรักษา} + \text{ค่าเสื่อมสภาพ} + \text{ค่าแรงงาน}$$</p>
                            <br>
                            <p><strong>3. หาจำนวนสินค้าคงคลังเฉลี่ย:</strong>  จำนวนสินค้าคงคลังเฉลี่ยคือค่าเฉลี่ยของจำนวนสินค้าที่เก็บไว้ในคลังในช่วงหนึ่งปี</p>
                            <br>
                            <p>$$\text{Average Inventory} = \frac{EOQ}{2}$$</p>
                            <p><strong>วิธีการหาค่า Average Inventory ในกรณียังไม่มีค่า EOQ</strong></p>
                            <br>
                            <p><strong>3.1 ใช้การคาดการณ์ยอดขาย</strong></p>
                            <br>
                            <ul style="margin-left: 20px;">
                                <li><strong>คาดการณ์ยอดขาย:</strong> สมมติว่าคุณคาดการณ์ว่าจะขายสินค้าประมาณ 800 หน่วยต่อเดือน</li>
                            </ul>
                            <br>
                            <p><strong>ตัวอย่าง:</strong></p>
                            <br>
                            <ul style="margin-left: 20px;">
                                <p>$$\text{Average Inventory} = \frac{Estimated Order Quantity}{2}$$</p>
                                <p>$$\text{Average Inventory} = \frac{800}{2} = 400 \text{ หน่วย}$$</p>
                            </ul>
                            <br>
                            <p><strong>3.2 เริ่มต้นจากการทดลอง</strong></p>
                            <br>
                            <ul style="margin-left: 20px;">
                                <li><strong>ทดลอง:</strong> สั่งซื้อสินค้าปริมาณ 500 หน่วยและติดตามข้อมูล</li>
                                <li><strong>คำนวณ:</strong> ใช้ข้อมูลที่ได้ในการปรับปรุงการประมาณการในอนาคต</li>
                            </ul>
                            <br>
                            <p><strong>ตัวอย่าง:</strong></p>
                            <br>
                            <ul style="margin-left: 20px;">
                                <p>$$\text{Average Inventory} = \frac{Order Quantity}{2}$$</p>
                                <p>$$\text{Average Inventory} = \frac{500}{2} = 250 \text{ หน่วย}$$</p>
                            </ul>
                            <br>
                            <p><strong>4. คำนวณต้นทุนการเก็บรักษาต่อหน่วยต่อปี:</strong></p>
                            <br>
                            <p>$$H = \frac{\text{Total Annual Holding Costs}}{\text{Average Inventory}}$$</p>
                            <br>
                            <p><strong>ตัวอย่างการคำนวณ:</strong></p>
                            <p>สมมติว่า:</p><br>
                            <ul style="margin-left: 20px;">
                                <li><strong>ค่าเช่าพื้นที่เก็บสินค้า =</strong> 60,000 บาทต่อปี</li>
                                <li><strong>ค่าบำรุงรักษา =</strong> 10,000 บาทต่อปี</li>
                                <li><strong>ค่าเสื่อมสภาพ =</strong> 5,000 บาทต่อปี</li>
                                <li><strong>ค่าแรงงาน =</strong> 15,000 บาทต่อปี</li>
                                <li><strong>จำนวนสินค้าคงคลังเฉลี่ย =</strong> 2,000 หน่วย</li>
                            </ul>
                            <br>
                            <p>$$\text{Total Annual Holding Costs} = 60,000 + 10,000 + 5,000 + 15,000 = 90,000 \text{ บาท}$$</p>
                            <p>$$H = \frac{\text{Total Annual Holding Costs}}{\text{Average Inventory}} = \frac{90,000}{2,000} = 45 \text{ บาทต่อหน่วยต่อปี}$$</p>

                            <p>ดังนั้น ต้นทุนในการเก็บรักษาสินค้าต่อหน่วยต่อปี (𝐻) คือ 45 บาท</p>

                            <br>
                            <hr class="my-4 border-gray-300 dark:border-gray-700">
                            <h3 class="text-xl mb-4 mt-6"><strong>ตัวอย่างการคำนวณ EOQ</strong></h3>
                            <p>หากธุรกิจของคุณมีความต้องการสินค้า (D) เท่ากับ 12,000 หน่วยต่อปี, 
                                ค่าใช้จ่ายในการสั่งซื้อสินค้าแต่ละครั้ง (S) เท่ากับ 4000 บาท และต้นทุนในการเก็บรักษาสินค้า (H) เท่ากับ 45 บาทต่อหน่วยต่อปี ดังนั้น:</p>

                                <p>$$EOQ = \sqrt{\frac{2DS}{H}}$$</p>

                                <p>$$EOQ = \sqrt{\frac{2 \times 12,000 \times 4,000}{45}}$$</p>

                                <p>$$EOQ = \sqrt{1,066,666.67} \approx 1,033 \text{ หน่วย}$$</p>

                            <p>ดังนั้น: หมายความว่าคุณควรสั่งซื้อสินค้าในแต่ละครั้งเป็นจำนวน 1033 หน่วย เพื่อให้ได้ต้นทุนการจัดการสินค้าคงคลังที่ต่ำที่สุด</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('#submit-button').click(function(event){
                event.preventDefault(); // ป้องกันการส่งฟอร์มไปยังเซิร์ฟเวอร์
    
                var formData = new FormData($('form')[0]); // สร้าง FormData จากฟอร์ม
    
                // รีเซ็ตข้อความแสดงข้อผิดพลาด
                $('#id_error').hide().text('');
                $('#product_name_error').hide().text('');
    
                $.ajax({
                    url: '{{ route('product.store') }}', // URL ของการส่งข้อมูล
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // กระบวนการเมื่อสำเร็จ
                        console.log(response); // แสดงผลลัพธ์ในคอนโซล
                        alert('เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
                        // รีเฟรชหน้าหรือทำสิ่งอื่นตามต้องการ
                        window.location.href = "{{ route('product.products') }}";
                    },
                    error: function(xhr){
                        // กระบวนการเมื่อเกิดข้อผิดพลาด
                        console.error('Error:', xhr);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.id) {
                                $('#id_error').show().text(errors.id[0]);
                            }
                            if (errors.product_name) {
                                $('#product_name_error').show().text(errors.product_name[0]);
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
