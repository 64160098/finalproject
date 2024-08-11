<x-appnormal-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('เลือกรายการสินค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="contrainer mt-2">
                        <div class="row">
                            <div class="flex items-center gap-4">
                                <p class="bread"><span><a href="{{ route('productsalereport.productsalereports') }}"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">ย้อนกลับ</a></span>
                                    / <span>เลือกรายการสินค้า</span></p>
                            </div>
                            @if (session('status'))
                                <div class="aleart alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <section>
                                    <table id="producttable" width="100%" border="1" cellpadding="5" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="10%" align="left" valign="middle"><strong>รหัส</strong></td>
                                                <td width="10%" align="left" valign="middle"><strong>ชื่อสินค้า</strong></td>
                                                <td width="10%" align="left" valign="middle"><strong>ประเภท</strong></td>
                                                <td width="10%" align="left" valign="middle"><strong>หน่วยนับ</strong></td>
                                                <td width="10%" align="left" valign="middle"><strong>สี</strong></td>
                                                <td width="10%" align="left" valign="middle"><strong>ขนาด</strong></td>
                                                <td width="10%" align="left" valign="middle"><strong>ราคา</strong></td>
                                                <td width="10%" align="left" valign="middle"><strong>ระบุจำนวน</strong></td>
                                                <td width="10%" align="center" valign="middle"><strong>เลือกสินค้า</strong></td>
                                            </tr>

                                            @foreach ($products as $product)
                                                <form action="{{ route('productsalereport.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <table width="100%" border="1" cellpadding="5" cellspacing="0">
                                                        <tr>
                                                            <!-- ข้อมูลของสินค้า -->
                                                            <td width="10%" align="left" valign="middle">{{ $product->code }}
                                                                <input type="hidden" name="code" value="{{ $product->code }}">
                                                            </td>
                                                            <td width="10%" align="left" valign="middle">{{ $product->product_name }}
                                                                <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                                                            </td>
                                                            <td width="10%" align="left" valign="middle">{{ $product->product_type }}
                                                                <input type="hidden" name="product_type" value="{{ $product->product_type }}">
                                                            </td>
                                                            <td width="10%" align="left" valign="middle">{{ $product->unit }}
                                                                <input type="hidden" name="unit" value="{{ $product->unit }}">
                                                            </td>
                                                            <td width="10%" align="left" valign="middle">{{ $product->color }}
                                                                <input type="hidden" name="color" value="{{ $product->color }}">
                                                            </td>
                                                            <td width="10%" align="left" valign="middle">{{ $product->size }}
                                                                <input type="hidden" name="size" value="{{ $product->size }}">
                                                            </td>
                                                            <td width="10%" align="left" valign="middle">{{ $product->price }}
                                                                <input type="hidden" name="price" value="{{ $product->price }}">
                                                            </td>                                                         
                                                            <td width="10%" align="left" valign="middle">
                                                                <x-text-input id="quantity_products_sale{{$product->id}}" 
                                                                              name="quantity_products_sale{{$product->id}}" 
                                                                              type="number" class="mt-1 block w-full" 
                                                                              required autofocus 
                                                                              autocomplete="quantity_products_sale{{$product->id}}" 
                                                                              placeholder="1"/>
                                                            </td>

                                                            <td width="10%" align="center" valign="middle">
                                                                <!-- ปุ่มสำหรับเลือกสินค้า -->
                                                                <input type="hidden" name="code" value="{{ $product->code }}">
                                                                <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                                                                <input type="hidden" name="product_type" value="{{ $product->product_type }}">
                                                                <input type="hidden" name="unit" value="{{ $product->unit }}">
                                                                <input type="hidden" name="color" value="{{ $product->color }}">
                                                                <input type="hidden" name="size" value="{{ $product->size }}">
                                                                <input type="hidden" name="price" value="{{ $product->price }}">
                                                                <input type="hidden" name="amount" value="{{ $product->amount }}">
                                                                <!-- ปุ่มสำหรับเลือกสินค้า -->
                                                                <button type="submit" name="selected_product" value="{{ $product->id }}">
                                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke="currentColor"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {!! $products->links() !!}
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-appadmin-layout>
