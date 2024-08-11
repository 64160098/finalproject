
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
<x-appadmin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ยอดขายรายเดือน') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mt-2">
                        <div class="space-y-6">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('ผลการรายงานยอดขายรายเดือน') }}
                            </h2>
                            <div class="flex justify-between">
                                <p class="bread"><span><a href="{{ route('dailysale.admindailysales') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">รายวัน</a></span>
                                    / <span>รายเดือน</span></p>
                                <form method="GET" action="{{ route('dailysale.adminmonthlysales') }}">
                                <div class="form-group">
                                    <label for="year">เลือกปี:</label>
                                    <select id="year" name="year" class="form-control" onchange="this.form.submit()">
                                        @for ($i = 2019; $i <= \Carbon\Carbon::now()->year; $i++)
                                            <option value="{{ $i }}" {{ $i == $selectedYear ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </form>
                            </div>
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                            @endif
                            <table id="dailysaletable" width="100%" border="1" cellpadding="5" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="25%" align="center" valign="middle"><strong>เดือน</strong></td>
                                        <td width="25%" align="center" valign="middle"><strong>ยอดขายรวม</strong></td>
                                    </tr>
                                
                                    @foreach($monthlySales as $month => $total)
                                    <tr>

                                        <td width="10%" align="center" valign="middle">{{ $month }}</td>
                                        <td width="10%" align="center" valign="middle"> {{ number_format($total, 2) }}</td>
                                    </tr>                 
                                     @endforeach
                                </tbody>
                            </table>

                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <div class="container mt-2">
                                    <div class="space-y-6">
                                        <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center gap-4">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
                                            <tbody>
                                            <tr>
                                              <td width="12%" align="left" valign="middle">ยอดขายรวมทั้งหมด :</td>
                                              <td width="12%">{{ number_format($totalSales, 2) }}</td>
                                            </tr>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let table = new DataTable('#dailysaletable');
    </script>



</x-appadmin-layout>

