
@php
    use Carbon\Carbon;
    $currentDate = Carbon::now()->locale('th')->isoFormat('วันddddที่ D MMMM YYYY');
    $currentMonth = Carbon::now()->locale('th')->isoFormat('MMMM');
@endphp

<style>
.custom-blue-box {
    background-color: #E0FFFF; /* เปลี่ยนเป็นสีเขียวตามต้องการ */
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}  
.custom-green-box {
    background-color: #7FFFD4; /* เปลี่ยนเป็นสีเขียวตามต้องการ */
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}  
.custom-yellow-box {
    background-color: #FFFFE0; /* เปลี่ยนเป็นสีเขียวตามต้องการ */
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}  
</style>

<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('หน้าหลัก Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>{{ __("สวัสดีคุณ") }} <strong>{{ auth()->user()->name }}</strong> ,{{ $currentDate }}</p>

                    <div class="flex flex-row gap-6 mt-8">
                        <!-- เริ่มต้นกล่องสี่เหลี่ยมภายใน -->
                        <div class="custom-blue-box overflow-hidden shadow-sm sm:rounded-lg border border-black">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">รายการสินค้า</h3>
                                <p style="font-size: 2em;">{{ $productCount }}</p>
                            </div>
                        </div>                   
                        <!-- สิ้นสุดกล่องสี่เหลี่ยมภายใน -->

                        <!-- เริ่มต้นกล่องสี่เหลี่ยมที่สอง -->
                        <div class="custom-green-box overflow-hidden shadow-sm sm:rounded-lg border border-black">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">ยอดขาย</h3>
                                <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ $currentDate }}</h4>
                                
                                @if ($dailySales->isEmpty())
                                    <p>ไม่มีข้อมูลยอดขายในวันนี้</p>
                                @else
                                    @foreach ($dailySales as $sale)
                                        <div class="mb-4">
                                            <p style="font-size: 2em;">{{ number_format($sale->total_earning, 2) }} บาท</p>
                                        </div>
                                    @endforeach
                                @endif
                                
                            </div>
                        </div>
                        <!-- สิ้นสุดกล่องสี่เหลี่ยมที่สอง -->

                        <!-- เริ่มต้นกล่องสี่เหลี่ยมที่สาม -->
                        <div class="custom-yellow-box overflow-hidden shadow-sm sm:rounded-lg border border-black">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">ยอดขายประจำเดือน</h3>
                                <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ $currentMonth }}</h4>
                                
                                @if ($monthlySales->isEmpty())
                                    <p>ไม่มีข้อมูลยอดขายประจำเดือนนี้</p>
                                @else
                                    <p style="font-size: 2em;">{{ number_format($totalMonthlySales, 2) }} บาท</p>
                                @endif
                            </div>
                        </div>
                        <!-- สิ้นสุดกล่องสี่เหลี่ยมที่สาม -->
                    </div>
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            var ctx = document.getElementById('salesChart').getContext('2d');
            var salesData = @json(array_values($salesData));
            var salesLabels = @json(array_keys($salesData));
    
            var salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'ยอดขาย',
                        data: salesData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

</x-appadmin-layout>
