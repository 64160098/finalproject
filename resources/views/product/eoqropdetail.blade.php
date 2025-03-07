<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>{{ $title }}</title>
            <style>
                @font-face {
                    font-family: 'THSarabun';
                    src: url('{{ public_path('fonts/THSarabun-Regular.ttf') }}');
                    font-weight: normal;
                }

                @font-face {
                    font-family: 'THSarabun';
                    src: url('{{ public_path('fonts/THSarabun-Bold.ttf') }}');
                    font-weight: bold;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                .footer {
                    text-align: center;
                    position: fixed;
                    bottom: 0;
                    width: 100%;
                }
                .company-name {
                    font-size: 32px;
                    font-weight: 900;
                    text-align: center;
                    line-height: 0.8;
                }
                .company-details, .project-details {
                    text-align: center;
                    font-size: 18px;
                    margin-bottom: 20px;
                }
                .purchase-order {
                    font-size: 28px;
                    text-align: center;
                    vertical-align: middle;
                    height: 30px; /* ลดความสูงกรอบ */
                    border: 1px solid black; /* เพิ่มเส้นกรอบสีดำ */
                    line-height: 20px; /* ปรับความสูงของบรรทัดเพื่อให้ตรงกลาง */
                }
            </style>
        </head>
        <body>
            <div class="company-name">
                บริษัท ตัวอย่าง จำกัด (ร้านค้าส่ง)<br>EXAMPLE WHOLESALE CO., LTD.
            </div>

            <div class="company-details">
                สำนักงานใหญ่ : 789 ถนนสุขสวัสดิ์ แขวงบางประกอก เขตราษฎร์บูรณะ กทม. 10140<br>
                Head Office: 789 Suksawat Road, Bang Pakok, Rat Burana, Bangkok 10140<br>
                โทร. 02-123-4567 | Fax. 02-123-4568 | เลขประจำตัวผู้เสียภาษี 1234567890123
            </div>

            <table>
                <tr>
                    <td class="purchase-order">ใบวิเคราะห์การสั่งซื้อและจุดสั่งซ้ำ</td>
                </tr>
            </table>

            <div class="number" style="text-align: right; font-size: 20px;">
                <span>เลขที่</span> <span>{{ $eoqrop->id }}</span> <br>
                <span>วันที่</span> <span>{{ $eoqrop->created_at->format('d/m/Y') }}</span>
            </div>

            <table style="border: 1px solid black;">
                <thead>
                    <th style="text-align: left; font-size: 20px; font-weight: bolder;">ข้อมูลสินค้า</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="border-top: 1px solid black; font-size: 18px;">
                            รหัสสินค้า: {{ $product->id }} <br>
                            ชื่อสินค้า: {{ $product->product_name }} / ราคา: {{ $product->price }} บาท/หน่วย<br>
                            ขนาดสินค้า: {{ $product->product_width }} × {{ $product->product_length }} × {{ $product->product_height }} <br>
                            ปริมาตรสินค้า: {{ $product->product_volume }} ลูกบาศก์เซนติเมตร
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="border: 1px solid black;">
                <thead>
                    <th style="text-align: left; font-size: 20px; font-weight: bolder;">ข้อมูลคลังสินค้า</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="border-top: 1px solid black; font-size: 18px;">
                            รหัสคลังสินค้า: {{ $warehouse->id }} <br>
                            ชื่อคลังสินค้า: {{ $warehouse->name }} <br>
                            ที่อยู่: {{ $warehouse->address }} <br>
                            ขนาดคลังสินค้า: {{ $warehouse->warehouse_width }} × {{ $warehouse->warehouse_length }} × {{ $warehouse->warehouse_height }} <br>
                            พื้นที่ทั้งหมด: {{ $warehouse->warehouse_total_area }} ตารางเมตร / พื้นที่จัดเก็บที่ใช้ได้: {{ $warehouse->warehouse_available_area }} ตารางเมตร <br>
                            ประเภทพื้นที่: {{ $warehouse->warehouse_area_type }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="border: 1px solid black;">
                <thead>
                    <th style="text-align: left; font-size: 20px; font-weight: bolder;">ข้อมูลพื้นที่จัดเก็บสินค้า</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="border-top: 1px solid black; font-size: 18px;">
                            รหัสพื้นที่จัดเก็บสินค้า: {{ $zone->id }} <br>
                            ชื่อพื้นที่จัดเก็บสินค้า: {{ $zone->name }} <br>
                            ขนาดพื้นที่จัดเก็บสินค้า: {{ $zone->zone_width }} × {{ $zone->zone_length }} × {{ $zone->zone_height }} <br>
                            ปริมาตรพื้นที่จัดเก็บสินค้า: {{ $zone->zone_volume }} ลูกบาศก์เมตร
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="border: 1px solid black;">
                <thead>
                    <th style="text-align: left; font-size: 20px; font-weight: bolder;">ข้อมูลวิเคราะห์การสั่งซื้อและจุดสั่งซ้ำ</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="border-top: 1px solid black; font-size: 18px;">
                            <strong>ปริมาณการสั่งซื้อที่ประหยัดที่สุด (EOQ):</strong> {{ $eoqrop->eoq }} หน่วย <br>
                            <strong>จุดสั่งซื้อซ้ำ (ROP):</strong> {{ $eoqrop->rop }} หน่วย <br>
                            <strong>ความจุของพื้นที่จัดเก็บ:</strong> {{ $eoqrop->storage_capacity }} หน่วย
                        </td>                        
                    </tr>
                </tbody>
            </table>
        
            <div class="footer">
                ข้อมูลนี้เป็นข้อมูลส่วนบุคคลและเป็นความลับ ห้ามนำไปเผยแพร่ ดัดแปลง หรือใช้เพื่อวัตถุประสงค์อื่นใดนอกเหนือจากที่ได้รับอนุญาตโดยเด็ดขาด หากฝ่าฝืนจะมีการดำเนินคดีตามกฎหมาย
            </div>
        </body>
        </html>
        
    </table>
</body>
</html>

