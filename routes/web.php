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
use App\Http\Controllers\OrdernowController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\loginnController;

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

Route::delete('product/{product}', [ProductController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.destroy');

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

Route::get('product/{id}/editeoq', [EoqropCalculationController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('eoqrop.edit');

Route::post('product/{id}/editeoq', [EoqropCalculationController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.editeoq.update');

Route::delete('eoqrop/{eoqrop}', [EoqropCalculationController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.destroyeoq');


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

Route::get('receiveproduct/{receiveproduct}/edit', [ReceiveProductController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.edit');

Route::post('receiveproduct/{receiveproduct}', [ReceiveProductController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('receiveproduct.update');

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

Route::get('orderhistory/{order_id}', [OrderHistoryController::class, 'detailorderhistory'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderhistory.detailorderhistory');

Route::get('orderhistory/{order_id}/edit', [OrderHistoryController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderhistory.edit');

Route::post('orderhistory/{order_id}', [OrderHistoryController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderhistory.update');


Route::delete('orderhistory/{orderhistory}', [OrderHistoryController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderhistory.destroy');

Route::resource('orderhistory', OrderHistoryController::class);

//Route Inventory

Route::get('inventory/inventories', [InventoryController::class, 'index'])
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

Route::get('/employee-details-dailysale/{id}', [DailySaleController::class, 'getEmployeeDetails'])
    ->name('inventoryreport.getDetailsemployee');

Route::get('dailysale/edit/{id}', [DailySaleController::class, 'edit'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('dailysale.user.edit');

Route::post('dailysale/edit/{id}', [DailySaleController::class, 'update'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('dailysale.user.update');

Route::delete('dailysale/{dailysale}', [DailySaleController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('dailysale.destroy');

Route::delete('admindailysale/{admindailysale}', [DailySaleController::class, 'admindestroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.admindestroy');

Route::get('dailysale/admindailysales', [DailySaleController::class, 'admindailysale'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.admindailysales');

Route::post('dailysale/adminedit/{id}', [DailySaleController::class, 'adminupdate'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.admin.update');

Route::get('dailysale/adminedit/{id}', [DailySaleController::class, 'adminedit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.admin.edit');

Route::get('dailysale/adminmonthlysales', [DailySaleController::class, 'adminmonthlysales'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.adminmonthlysales');

Route::get('dailysale/adminmonthlysales', [DailySaleController::class, 'getMonthlySales'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dailysale.adminmonthlysales');

Route::resource('dailysale', DailySaleController::class);

//Route OrderList

Route::get('orderlist/orderlists', [OrderListController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('orderlist.orderlists');

Route::resource('orderlist', OrderListController::class);

//Route InventoryReport

Route::get('inventoryreport/inventoryreports', [InventoryReportController::class, 'index'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.inventoryreports');

Route::get('inventoryreport/{create}', [InventoryReportController::class, 'create'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.create');

Route::get('/employee-details-inventoryreport/{id}', [InventoryReportController::class, 'getEmployeeDetails'])
    ->name('inventoryreport.getDetailsemployee');

Route::post('inventoryreport/inventoryreport', [InventoryReportController::class, 'store'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.store');

Route::get('inventoryreport/edit/{id}', [InventoryReportController::class, 'edit'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.user.edit');

Route::post('inventoryreport/edit/{id}', [InventoryReportController::class, 'update'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.user.update');

Route::delete('inventoryreport/{inventoryreport}', [InventoryReportController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.destroy');

Route::get('inventoryreport/detailinventoryreport/{id}', [InventoryReportController::class, 'showInventoryReportDetails'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('inventoryreport.detailinventoryreport');

Route::resource('inventoryreport', InventoryReportController::class);

//Route AdminInventoryReport

Route::get('admininventoryreport/admininventoryreports', [AdminInventoryReportController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventoryreport.admininventoryreports');

Route::get('inventoryreport/adminedit/{id}', [AdminInventoryReportController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventoryreport.admin.edit');

Route::post('inventoryreport/adminedit/{id}', [AdminInventoryReportController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventoryreport.admin.update');

Route::delete('admininventoryreport/{admininventoryreport}', [AdminInventoryReportController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admininventoryreport.destroy');

Route::get('inventoryreport/admindetailinventoryreport/{id}', [AdminInventoryReportController::class, 'AdminshowInventoryReportDetails'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('inventoryreport.admindetailinventoryreport');

Route::resource('admininventoryreport', AdminInventoryReportController::class);

//Route ProductSaleReport

Route::get('productsalereport/productsalereports', [ProductSaleReportController::class, 'index'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.productsalereports');

Route::get('productsalereport/create', [ProductSaleReportController::class, 'create'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.create');

Route::get('/employee-details-productsalereport/{id}', [ProductSaleReportController::class, 'getEmployeeDetails'])
    ->name('productsalereport.getDetailsemployee');

Route::post('productsalereport/productsalereport', [ProductSaleReportController::class, 'store'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.store');

Route::get('productsalereport/edit/{id}', [ProductSaleReportController::class, 'edit'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.edit');

Route::post('productsalereport/edit/{id}', [ProductSaleReportController::class, 'update'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.user.update');

Route::delete('productsalereport/{productsalereport}', [ProductSaleReportController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.destroy');

Route::get('productsalereport/detailproductsale/{id}', [ProductSaleReportController::class, 'showProductSaleDetails'])
    ->middleware(['auth', 'verified', 'normal'])
    ->name('productsalereport.detailproductsale');

Route::get('productsalereport/monthlyproductsales', [ProductSaleReportController::class, 'show'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalereport.monthlyproductsales');

Route::resource('productsalereport', ProductSaleReportController::class);


//Route ProductSalesHistory

Route::get('productsalehistory/productsalehistorys', [ProductSalesHistoryController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalereport.productsalehistorys');

Route::get('productsalereport/detailproductsaleadmin/{id}', [ProductSalesHistoryController::class, 'showadminProductSaleDetails'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalereport.admin.detailproductsaleadmin');

Route::get('productsalereport/adminedit/{id}', [ProductSalesHistoryController::class, 'edit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalereport.adminedit');

Route::post('productsalereport/{productsalereport}', [ProductSalesHistoryController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('productsalereport.history.update');



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

Route::get('generate-pdf/{id}', [EoqropCalculationController::class, 'generatePDF'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.eoqropdetail');

Route::get('product/detailmore/{productId}', [EoqropCalculationController::class, 'showDetails'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('product.detailmore');

Route::get('/product-and-warehouses/{productId}', [EoqropCalculationController::class, 'getProductAndWarehouses'])
    ->middleware(['auth', 'verified', 'admin']);

Route::get('/warehouse-zones/{warehouseId}/{productId}', [EoqropCalculationController::class, 'getZonesByWarehouse'])
    ->middleware(['auth', 'verified', 'admin']);

Route::get('/zone-details/{zoneId}', [EoqropCalculationController::class, 'getZoneDetails'])
    ->middleware(['auth', 'verified', 'admin']);

//Route Ordernow

Route::get('ordernow/ordernows', [OrdernowController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.ordernows');

Route::get('ordernow/createstep1', [OrdernowController::class, 'createstep1'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.createstep1');

Route::post('ordernow/createstep1', [OrdernowController::class, 'postStep1'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.postStep1');
    
Route::get('ordernow/createstep2', [OrdernowController::class, 'createstep2'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.createstep2');

Route::post('ordernow/createstep2', [OrdernowController::class, 'postStep2'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.postStep2');

// ขั้นตอนที่ 1
Route::get('ordernow/editstep1/{id}', [OrdernowController::class, 'editStep1'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.editstep1');

Route::post('ordernow/editstep1/{id}', [OrdernowController::class, 'updateStep1'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.updateStep1');

// ขั้นตอนที่ 2
Route::get('ordernow/editstep2/{id}', [OrdernowController::class, 'editStep2'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.editstep2');

Route::post('ordernow/editstep2/{id}', [OrdernowController::class, 'updateStep2'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.updateStep2');

Route::delete('ordernow/{ordernow}', [OrdernowController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.destroy');

Route::get('/supplier-details/{id}', [OrdernowController::class, 'getSupplierDetails'])
    ->name('ordernow.getDetailssupplier');

Route::get('/employee-details/{id}', [OrdernowController::class, 'getEmployeeDetails'])
    ->name('ordernow.getDetailsemployee');

Route::get('ordernow/detailorder/{id}', [OrdernowController::class, 'showOrderDetails'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.detailorder');

Route::get('ordernow/{id}/detailorder', [OrdernowController::class, 'generateorderPDF'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('ordernow.generateorderPDF');
    
Route::resource('ordernow', OrdernowController::class);

require __DIR__.'/auth.php';
