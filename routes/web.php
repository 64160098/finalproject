<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeInformationController;
use App\Http\Controllers\SupplierInformationController;
use App\Http\Controllers\ReceiveProductController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DailySaleController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\InventoryReportController;
use App\Http\Controllers\ProductSalesHistoryController;
use App\Http\Controllers\AdminInventoryReportController;
use App\Http\Controllers\ProductSaleReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\EoqropCalculationController;

Route::redirect('/', '/login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'normal'])
    ->name('dashboard');

Route::view('admin', 'admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin');

Route::view('superadmin', 'superadmin')
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('superadmin');

Route::view('profileadmin', 'profileadmin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('profileadmin');

Route::view('profilenormal', 'profilenormal')
    ->middleware(['auth', 'verified', 'normal'])
    ->name('profilenormal');

Route::view('profilesuperadmin', 'profilesuperadmin')
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('profilesuperadmin');

//Route ProductType 

Route::get('producttype/producttypes', [ProductTypeController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('producttype.producttypes');

Route::get('producttype/{producttype}/edit', [ProductTypeController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('producttype.edit');

Route::post('producttype/{producttype}', [ProductTypeController::class, 'update'])
    ->middleware(['auth', 'web', 'verified', 'admin'])
    ->name('producttype.update');

Route::delete('producttype/{producttype}', [ProductTypeController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('producttype.destroy');

Route::resource('producttype', ProductTypeController::class);

//Route ProductUnit

Route::get('productunit/productunits', [ProductUnitController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productunit.productunits');

Route::get('productunit/{productunit}/edit', [ProductUnitController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productunit.edit');

Route::post('productunit/{productunit}', [ProductUnitController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productunit.update');

Route::delete('productunit/{productunit}', [ProductUnitController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productunit.destroy');

Route::resource('productunit', ProductUnitController::class);

//Route Product

Route::get('product/products', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.products');

Route::get('product/{product}/edit', [ProductController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.edit');

Route::post('product/{product}', [ProductController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.update');

Route::get('product/create', [ProductController::class, 'create'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.create');

Route::get('product/detail', [ProductController::class, 'seemore'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.detail');

Route::get('product/detailrop', [ProductController::class, 'seemorerop'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.detailrop');

// Route สำหรับแสดงหน้า createeoq
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // แสดงหน้า create EOQ
    Route::get('/product/create-eoq', [ProductController::class, 'createEoq'])
        ->name('product.createeoq');

    // ดึงข้อมูลสินค้าโดยใช้รหัส
    Route::get('/product-details/{id}', [ProductController::class, 'getProductDetails'])
        ->name('product.getDetails');
});

Route::get('product/{product}', [ProductController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.edit');

Route::post('eoqrop/store', [EoqropCalculationController::class, 'store'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('eoqrop.store');

Route::resource('product', ProductController::class);

//Route EmployeeInformation

Route::get('employee/employees', [EmployeeInformationController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('employee.employees');

Route::get('employee/{employee}/edit', [EmployeeInformationController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('employee.edit');

Route::post('employee/{employee}', [EmployeeInformationController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('employee.update');

Route::delete('employee/{employee}', [EmployeeInformationController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('employee.destroy');

Route::resource('employee', EmployeeInformationController::class);

//Route SupplierInformation

Route::get('supplier/suppliers', [SupplierInformationController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('supplier.suppliers');

Route::get('supplier/{supplier}/edit', [SupplierInformationController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('supplier.edit');

Route::post('supplier/{supplier}', [SupplierInformationController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('supplier.update');

Route::delete('supplier/{supplier}', [SupplierInformationController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('supplier.destroy');

Route::resource('supplier', SupplierInformationController::class);

//Route ReceiveProduct

Route::get('receiveproduct/receiveproducts', [ReceiveProductController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.receiveproducts');

Route::get('receiveproduct/{create}', [ReceiveProductController::class, 'showReceiveForm'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.create');

Route::get('receiveproduct/{receiveproduct}/edit', [ReceiveProductController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.edit');

Route::post('receiveproduct/{receiveproduct}', [ReceiveProductController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.update');

Route::delete('receiveproduct/{receiveproduct}', [ReceiveProductController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.destroy');

Route::post('receiveproduct/{receiveproduct}', [ReceiveProductController::class, 'store'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.store');

Route::get('receiveproduct/confirmorders', [ReceiveProductController::class, 'confirm'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.confirmorders');

Route::delete('receiveproduct', [ReceiveProductController::class, 'deleteAll'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.deleteAll');

Route::resource('receiveproduct', ReceiveProductController::class);

//Route OrderHistory

Route::get('orderhistory/orderhistorys', [OrderHistoryController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderhistory.orderhistorys');

Route::post('orderhistory/{orderhistorys}', [OrderHistoryController::class, 'store'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderhistory.store');

Route::get('orderhistory/{orderhistory}/edit', [OrderHistoryController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderhistory.edit');

Route::post('orderhistory/{orderhistory}', [OrderHistoryController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderhistory.update');

Route::resource('orderhistory', OrderHistoryController::class);

//Route Inventory

Route::get('inventory/inventories', [InventoryController::class, 'showInventoryForm'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventory.inventories');

Route::get('inventory/{inventory}/edit', [InventoryController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventory.edit');

Route::post('inventory/{inventory}', [InventoryController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventory.update');

Route::delete('inventory/{inventory}', [InventoryController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventory.destroy');

Route::resource('inventory', InventoryController::class);

//Route DailySale

Route::get('dailysale/dailysales', [DailySaleController::class, 'index'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('dailysale.dailysales');

Route::get('dailysale/{dailysale}/edit', [DailySaleController::class, 'edit'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('dailysale.edit');

Route::post('dailysale/{dailysale}', [DailySaleController::class, 'update'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('dailysale.update');

Route::delete('dailysale/{dailysale}', [DailySaleController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('dailysale.destroy');

Route::delete('admindailysale/{admindailysale}', [DailySaleController::class, 'admindestroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.admindestroy');

Route::get('dailysale/admindailysales', [DailySaleController::class, 'admindailysale'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.admindailysales');

Route::post('admindailysale/{admindailysale}', [DailySaleController::class, 'adminupdate'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.adminupdate');

Route::get('admindailysale/{admindailysale}/edit', [DailySaleController::class, 'adminedit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.adminedit');

Route::get('dailysale/adminmonthlysales', [DailySaleController::class, 'adminmonthlysales'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.adminmonthlysales');

Route::get('dailysale/adminmonthlysales', [DailySaleController::class, 'getMonthlySales'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.adminmonthlysales');

Route::resource('dailysale', DailySaleController::class);

//Route OrderProduct

Route::get('orderproduct/orderproducts', [OrderProductController::class, 'index'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('orderproduct.orderproducts');

Route::get('orderproduct/{create}', [OrderProductController::class, 'showOrderForm'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('orderproduct.create');

Route::get('orderproduct/{orderproduct}/edit', [OrderProductController::class, 'edit'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('orderproduct.edit');

Route::post('orderproduct/{orderproduct}', [OrderProductController::class, 'update'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('orderproduct.update');

Route::delete('orderproduct/{orderproduct}', [OrderProductController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('orderproduct.destroy');

Route::post('orderproduct/{orderproduct}', [OrderProductController::class, 'store'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('orderproduct.store');

Route::get('orderproduct/confirmorders', [OrderProductController::class, 'confirm'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('orderproduct.confirmorders');

Route::delete('orderproduct', [OrderProductController::class, 'deleteAll'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('orderproduct.deleteAll');

Route::resource('orderproduct', OrderProductController::class);

//Route OrderList

Route::get('orderlist/orderlists', [OrderListController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderlist.orderlists');

Route::post('orderlist/{orderlists}', [OrderListController::class, 'store'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderlist.store');

Route::get('orderlist/{orderlist}/edit', [OrderListController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderlist.edit');

Route::post('orderlist/{orderlist}', [OrderListController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderlist.update');

Route::resource('orderlist', OrderListController::class);

//Route InventoryReport

Route::get('inventoryreport/inventoryreports', [InventoryReportController::class, 'index'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.inventoryreports');

Route::get('inventoryreport/{create}', [InventoryReportController::class, 'showReportForm'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.create');

Route::get('inventoryreport/{inventoryreport}/edit', [InventoryReportController::class, 'edit'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.edit');

Route::post('inventoryreport/{inventoryreport}', [InventoryReportController::class, 'update'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.update');

Route::delete('inventoryreport/{inventoryreport}', [InventoryReportController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.destroy');

Route::post('inventoryreport/{inventoryreport}', [InventoryReportController::class, 'store'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.store');

Route::get('inventoryreport/confirmorders', [InventoryReportController::class, 'confirm'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.confirmorders');

Route::delete('inventoryreport', [InventoryReportController::class, 'deleteAll'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.deleteAll');

Route::resource('inventoryreport', InventoryReportController::class);

//Route AdminInventoryReport

Route::get('admininventoryreport/admininventoryreports', [AdminInventoryReportController::class, 'admininventoryreports'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventoryreport.admininventoryreports');

Route::get('admininventoryreport/{admininventoryreport}/edit', [AdminInventoryReportController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventoryreport.adminedit');

Route::post('admininventoryreport/{admininventoryreport}', [AdminInventoryReportController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventoryreport.adminupdate');

Route::post('admininventoryreport/admininventoryreport', [AdminInventoryReportController::class, 'store'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admininventoryreport.store');

Route::delete('admininventoryreport/{admininventoryreport}', [AdminInventoryReportController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admininventoryreport.destroy');

Route::resource('admininventoryreport', AdminInventoryReportController::class);

//Route ProductSaleReport

Route::get('productsalereport/productsalereports', [ProductSaleReportController::class, 'index'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.productsalereports');

Route::get('productsalereport/{create}', [ProductSaleReportController::class, 'showProductForm'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.create');

Route::get('productsalereport/{productsalereport}/edit', [ProductSaleReportController::class, 'edit'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.edit');

Route::post('productsalereport/{productsalereport}', [ProductSaleReportController::class, 'update'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.update');

Route::delete('productsalereport/{productsalereport}', [ProductSaleReportController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.destroy');

Route::post('productsalereport/{productsalereport}', [ProductSaleReportController::class, 'store'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.store');

Route::get('productsalereport/confirmorders', [ProductSaleReportController::class, 'confirm'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.confirmorders');

Route::delete('productsalereport', [ProductSaleReportController::class, 'deleteAll'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.deleteAll');

Route::resource('productsalereport', ProductSaleReportController::class);


//Route ProductSalesHistory

Route::get('productsalehistory/productsalehistorys', [ProductSalesHistoryController::class, 'productsalehistorys'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalereport.productsalehistorys');

Route::post('productsalehistory/productsalehistory', [ProductSalesHistoryController::class, 'store'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalehistory.store');

Route::get('productsalehistory/{productsalehistory}/edit', [ProductSalesHistoryController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalehistory.edit');

Route::post('productsalehistory/{productsalehistory}', [ProductSalesHistoryController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalehistory.update');

Route::delete('productsalehistory/{productsalehistory}', [ProductSalesHistoryController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalehistory.destroy');

Route::resource('productsalehistory', ProductSalesHistoryController::class);

//Route User

Route::get('user/users', [UserController::class, 'index'])
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('user.users');

Route::get('user/{user}/edit', [UserController::class, 'edit'])
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('user.edit');

Route::post('user/{user}', [UserController::class, 'update'])
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('user.update');

Route::delete('user/{user}', [UserController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('user.destroy');

Route::resource('user', UserController::class);

//Route Admin

Route::get('admin', [AdminController::class, 'showusername'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin');

Route::get('admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin');

//Route Admin

Route::get('superadmin', [SuperadminController::class, 'index'])
    ->middleware(['auth', 'verified', 'superadmin'])
    ->name('superadmin');

//Route Warehouse

Route::get('warehouse/warehouses', [WarehouseController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('warehouse.warehouses');

Route::get('warehouse/create', [WarehouseController::class, 'create'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('warehouse.create');

Route::post('warehouse/warehouses', [WarehouseController::class, 'store'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('warehouse.store');

Route::post('warehouse/{warehouse}', [WarehouseController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('warehouse.update');

Route::delete('warehouse/{warehouse}', [WarehouseController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('warehouse.destroy');

Route::resource('warehouse', WarehouseController::class);

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('warehouse/{id}', [WarehouseController::class, 'show'])
        ->name('warehouse.zone');
    
    Route::get('warehouse/{id}/zone/create', [ZoneController::class, 'create'])
        ->name('warehouse.createzone');
});

Route::post('warehouse/{id}/zone/create', [ZoneController::class, 'store'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('warehouse.createzone.store');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('warehouse/{id}/zone/edit', [ZoneController::class, 'edit'])
        ->name('warehouse.editzone');
    Route::post('warehouse/zone/{id}', [ZoneController::class, 'update'])
        ->name('warehouse.editzone.update');
});

Route::delete('warehouse/{warehouse}/zone/{zone}', [ZoneController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('warehouse.zone.destroy');

Route::get('/zone-product-details/{id}', [ZoneController::class, 'getProductDetailsByZone'])
    ->name('zone.productDetails');


require __DIR__.'/auth.php';
