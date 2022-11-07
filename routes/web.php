<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' , 'auth']
    ], function(){ //...

    Route::group(['prefix' => 'admin'], function() {
            Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
            Route::get('/charts/sales', [\App\Http\Controllers\Admin\AdminController::class, 'salesCharts'])->name('sales-charts');
            Route::get('/charts/sales-payment-status', [\App\Http\Controllers\Admin\AdminController::class, 'salesPaymentStatusCharts'])->name('sales-payment-status-charts');

            //Roles & Permissions
            Route::resource('/users', App\Http\Controllers\Admin\UserController::class);
            Route::delete('/delete-selected-users', [App\Http\Controllers\Admin\UserController::class, 'deleteSelectedUsers'])->name('deleteSelectedUsers');
            Route::get('/users/role/{id}', [App\Http\Controllers\Admin\UserController::class, 'usersOfRoleQuery'])->name('usersOfRoleQuery');

            Route::resource('/perm_categories', App\Http\Controllers\Admin\PermissionsCategoriesController::class);
            Route::delete('/delete-selected-permissions-categories', [App\Http\Controllers\Admin\PermissionsCategoriesController::class, 'deleteSelectedPermissionsCategoies'])->name('deleteSelectedPermissionsCategoies');
            Route::get('/perm_categories/create/translated/{cat}', [App\Http\Controllers\Admin\PermissionsCategoriesController::class, 'translatePermissionsCat'])->name('translatePermissionsCat');
            Route::get('/perm_categories/edit/translated/{role}', [App\Http\Controllers\Admin\PermissionsCategoriesController::class, 'translateEditPermCategories'])->name('translateEditPermCategories');

            Route::resource('/jobs', App\Http\Controllers\Admin\JobsController::class);
            Route::delete('/delete-selected-jobs', [App\Http\Controllers\Admin\JobsController::class, 'deleteSelectedJobs'])->name('deleteSelectedJobs');
            Route::get('/jobs/create/translated/{job}', [App\Http\Controllers\Admin\JobsController::class, 'translateJob'])->name('translateJob');
            Route::get('/jobs/edit/translated/{job}', [App\Http\Controllers\Admin\JobsController::class, 'translateEditJob'])->name('translateEditJob');

            Route::resource('/permissions', App\Http\Controllers\Admin\PermissionsController::class);
            Route::delete('/delete-selected-permissions', [App\Http\Controllers\Admin\PermissionsController::class, 'deleteSelectedPermissions'])->name('deleteSelectedPermissions');
            Route::get('/permissions/create/translated/{perm}', [App\Http\Controllers\Admin\PermissionsController::class, 'translatePermission'])->name('translatePermission');
            Route::get('/permissions/edit/translated/{perm}', [App\Http\Controllers\Admin\PermissionsController::class, 'translateEditPermission'])->name('translateEditPermission');

            Route::resource('/roles', App\Http\Controllers\Admin\RolesController::class);
            Route::delete('/delete-selected-roles', [App\Http\Controllers\Admin\RolesController::class, 'deleteSelectedRoles'])->name('deleteSelectedRoles');
            Route::get('/roles/create/translated/{role}', [App\Http\Controllers\Admin\RolesController::class, 'translateRole'])->name('translateRole');
            Route::get('/roles/edit/translated/{role}', [App\Http\Controllers\Admin\RolesController::class, 'translateEditRole'])->name('translateEditRole');


            //Edit User Account Info
            Route::get('edit-account-info', [App\Http\Controllers\EditUserAccountInfoController::class, 'index'])->name('editUserAccount');
            Route::post('edit-account-info/name-email', [App\Http\Controllers\EditUserAccountInfoController::class, 'updateNameEmail'])->name('editUserAccountNameEmail');
            Route::post('edit-account-info/change-password', [App\Http\Controllers\EditUserAccountInfoController::class, 'changePassword'])->name('changePassword');

    });

    Route::group(['prefix' => 'erp'], function() {
        //Branches
        Route::resource('/branches', \App\Http\Controllers\ERP\BranchesController::class);
        Route::get('/branches/create/translated/{name}/{address}', [\App\Http\Controllers\ERP\BranchesController::class, 'translateBranch'])->name('translateBranch');
        Route::get('/branches/edit/translated/{name}/{address}', [\App\Http\Controllers\ERP\BranchesController::class, 'translateEditBranch'])->name('translateEditBranch');
        Route::delete('/delete-selected-branches', [\App\Http\Controllers\ERP\BranchesController::class, 'deleteSelectedBranches'])->name('deleteSelectedBranches');

       //Settings
        Route::group(['prefix' => 'settings'], function() {
            //General Settings
            Route::resource('/general-settings', \App\Http\Controllers\ERP\Settings\GeneralSettingsController::class);
            //Sequential Numbering
            Route::resource('/sequential-codes', \App\Http\Controllers\ERP\Settings\SequentialCodesController::class);
            //Route::delete('/delete-selected-sequential-codes', [\App\Http\Controllers\ERP\Settings\SequentialCodesController::class, 'deleteSelectedSeqCodes'])->name('deleteSelectedSeqCodes');
            //Taxes
            Route::resource('/taxes', \App\Http\Controllers\ERP\Settings\TaxesController::class);
            //Measurement Units
            Route::resource('/units-templates', \App\Http\Controllers\ERP\Settings\UnitsTemplatesController::class);
            Route::resource('/measurement-units', \App\Http\Controllers\ERP\Settings\MeasurementUnitsController::class)->except('create');
            Route::get('/measurement-units/create/{template_id}', [\App\Http\Controllers\ERP\Settings\MeasurementUnitsController::class, 'create'])->name('measurement-units.create');

            //Products
            Route::get('/products', [App\Http\Controllers\ERP\Settings\Products\ProductsSettingsController::class, 'index'])->name('productsSettings');
            //**Sections**
            Route::resource('/products/sections', \App\Http\Controllers\ERP\Settings\Products\SectionsController::class);
            //**Brands**
            Route::resource('/products/brands', \App\Http\Controllers\ERP\Settings\Products\BrandsController::class);
            //**Categories**
            Route::resource('/products/categories', \App\Http\Controllers\ERP\Settings\Products\CategoriesController::class);
            //**SubCategories**
            Route::resource('/products/subcategories', \App\Http\Controllers\ERP\Settings\Products\SubCategoriesController::class);

        });

        //Sales
        Route::group(['prefix' => 'sales'], function () {
           //Clients
            Route::resource('/clients', \App\Http\Controllers\ERP\Sales\ClientsController::class);
            Route::delete('/delete-client-contact', [\App\Http\Controllers\ERP\Sales\ClientsController::class, 'deleteClientContact'])->name('deleteClientContact');
            Route::patch('/edit-client-opening-balance/{id}', [\App\Http\Controllers\ERP\Sales\ClientsController::class, 'editClientOpeningBalance'])->name('editClientOpeningBalance');
            Route::patch('/suspend-client/{id}', [\App\Http\Controllers\ERP\Sales\ClientsController::class, 'suspendClient'])->name('suspendClient');
            Route::patch('/activate-client/{id}', [\App\Http\Controllers\ERP\Sales\ClientsController::class, 'activateClient'])->name('activateClient');

            //Sales Invoices
            Route::resource('sales-invoices', \App\Http\Controllers\ERP\Sales\SalesInvoicesController::class);
            Route::get('/filePreview/{folderDate}/{invoiceNumber}/{fileName}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'filePreview'])->name('SalesFilePreview');
            Route::get('/fileDownload/{folderDate}/{invoiceNumber}/{fileName}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'fileDownload'])->name('SalesFileDownload');
            Route::get('/sales-invoice-preview/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'invoicePreview'])->name('SalesInvoicePreview');
            Route::get('/sales-invoice-print/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'invoicePrint'])->name('SalesInvoicePrint');
            Route::get('/sales-invoice-pdf/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'invoicePDF'])->name('SalesInvoicePDF');
            Route::get('/sales-invoice-package-sticker-pdf/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'invoicePackageStickerPDF'])->name('salesInvoicePackageStickerPDF');
            Route::get('/sales-invoice-receipt-list-pdf/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'invoiceReceiptListPDF'])->name('salesInvoiceReceiptListPDF');
            Route::get('/sales-invoice-delivery-sticker-pdf/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'invoiceDeliveryStickerPDF'])->name('salesInvoiceDeliveryStickerPDF');
            Route::get('/sales-invoice/send-to-email/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'sentToEmail'])->name('sendToEmailSalesInvoice');
            Route::get('/sales-invoice-add-payment-transaction/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'addPaymentTransaction'])->name('SalesInvoiceAddPaymentTransaction');
            Route::post('/sales-invoice-store-payment-transaction', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'storePaymentTransaction'])->name('SalesInvoiceStorePaymentTransaction');
            Route::get('/sales-invoice-show-down-payment-ajax/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'showDownPaymentResponse'])->name('SalesInvoiceShowDownPaymentResponse');
            Route::get('/sales-invoice-show-payment-transaction-ajax/{paymentId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'showPaymentTransactionResponse'])->name('SalesInvoiceShowPaymentTransactionResponse');
            Route::get('/sales-invoice-edit-payment-transaction-ajax/{paymentId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'editPaymentTransactionResponse'])->name('SalesInvoiceEditPaymentTransactionResponse');
            Route::patch('/sales-invoice-update-payment-transaction', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'updatePaymentTransaction'])->name('SalesInvoiceUpdatePaymentTransaction');
            Route::get('/sales-invoice-complete-payment-transaction/{paymentId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'completePaymentTransaction'])->name('SalesInvoiceCompletePaymentTransaction');
            Route::get('/sales-payment-receipt-print/{paymentId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'paymentReceiptPrint'])->name('SalesInvoicePaymentReceiptPrint');
            Route::get('/sales-payment-receipt-print-ajax/{paymentId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'paymentReceiptPrintResponse'])->name('SalesInvoicePaymentReceiptPrintResponse');
            Route::get('/sales-payment-receipt-pdf/{paymentId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'paymentReceiptPdf'])->name('SalesInvoicePaymentReceiptPdf');
            Route::get('/sales-invoice-down-payment-receipt-print/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'downPaymentReceiptPrint'])->name('SalesInvoiceDownPaymentReceiptPrint');
            Route::get('/sales-invoice-down-payment-receipt-pdf/{salesInvoiceId}', [\App\Http\Controllers\ERP\Sales\SalesInvoicesController::class, 'downPaymentReceiptPdf'])->name('SalesInvoiceDownPaymentReceiptPdf');
        });

        //Purchases
        Route::group(['prefix' => 'purchases'], function() {
            //Suppliers
            Route::resource('/suppliers', \App\Http\Controllers\ERP\Purchases\SuppliersController::class);
            Route::delete('/delete-selected-suppliers', [\App\Http\Controllers\ERP\Purchases\SuppliersController::class, 'deleteSelectedSuppliers'])->name('deleteSelectedSuppliers');
            Route::delete('/delete-supplier-contact', [\App\Http\Controllers\ERP\Purchases\SuppliersController::class, 'deleteSupplierContact'])->name('deleteSupplierContact');
            Route::patch('/edit-supplier-opening-balance/{id}', [\App\Http\Controllers\ERP\Purchases\SuppliersController::class, 'editSupplierOpeningBalance'])->name('editSupplierOpeningBalance');
            Route::patch('/suspend-supplier/{id}', [\App\Http\Controllers\ERP\Purchases\SuppliersController::class, 'suspendSupplier'])->name('suspendSupplier');
            Route::patch('/activate-supplier/{id}', [\App\Http\Controllers\ERP\Purchases\SuppliersController::class, 'activateSupplier'])->name('activateSupplier');

            //Purchase Invoices
            Route::resource('purchase-invoices', \App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class);
            Route::get('/filePreview/{folderDate}/{invoiceNumber}/{fileName}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'filePreview'])->name('filePreview');
            Route::get('/fileDownload/{folderDate}/{invoiceNumber}/{fileName}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'fileDownload'])->name('fileDownload');
            Route::get('/purchase-invoice-preview/{purchaseInvoiceId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'invoicePreview'])->name('invoicePreview');
            Route::get('/purchase-invoice-print/{purchaseInvoiceId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'invoicePrint'])->name('invoicePrint');
            Route::get('/purchase-invoice-pdf/{purchaseInvoiceId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'invoicePDF'])->name('invoicePDF');
            Route::get('/purchase-invoice-create-barcode-pdf/{purchaseInvoiceId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'createInvoiceBarcodePDF'])->name('createInvoiceBarcodePDF');
            Route::post('/purchase-invoice-barcode-pdf', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'invoiceBarcodePDF'])->name('invoiceBarcodePDF');
            Route::get('/purchase-invoice/send-to-email/{purchaseInvoiceId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'sentToEmail'])->name('sendToEmail');
            Route::get('/purchase-invoice-add-payment-transaction/{purchaseInvoiceId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'addPaymentTransaction'])->name('addPaymentTransaction');
            Route::post('/purchase-invoice-store-payment-transaction', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'storePaymentTransaction'])->name('storePaymentTransaction');
            Route::get('/purchase-invoice-show-down-payment-ajax/{purchaseInvoiceId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'showDownPaymentResponse'])->name('showDownPaymentResponse');
            Route::get('/purchase-invoice-show-payment-transaction-ajax/{paymentId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'showPaymentTransactionResponse'])->name('showPaymentTransactionResponse');
            Route::get('/purchase-invoice-edit-payment-transaction-ajax/{paymentId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'editPaymentTransactionResponse'])->name('editPaymentTransactionResponse');
            Route::patch('/purchase-invoice-update-payment-transaction', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'updatePaymentTransaction'])->name('updatePaymentTransaction');
            Route::get('/purchase-invoice-complete-payment-transaction/{paymentId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'completePaymentTransaction'])->name('completePaymentTransaction');
            Route::get('/purchase-payment-receipt-print/{paymentId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'paymentReceiptPrint'])->name('paymentReceiptPrint');
            Route::get('/purchase-payment-receipt-print-ajax/{paymentId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'paymentReceiptPrintResponse'])->name('paymentReceiptPrintResponse');
            Route::get('/purchase-payment-receipt-pdf/{paymentId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'paymentReceiptPdf'])->name('paymentReceiptPdf');
            Route::get('/purchase-invoice-down-payment-receipt-print/{purchaseInvoiceId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'downPaymentReceiptPrint'])->name('downPaymentReceiptPrint');
            Route::get('/purchase-invoice-down-payment-receipt-pdf/{purchaseInvoiceId}', [\App\Http\Controllers\ERP\Purchases\PurchaseInvoicesController::class, 'downPaymentReceiptPdf'])->name('downPaymentReceiptPdf');
        });

        //Inventory
        Route::group(['prefix' => 'inventory'], function() {
            //Warehouses
            Route::resource('/warehouses', \App\Http\Controllers\ERP\Inventory\WarehousesController::class);
            Route::get('/warehouses/inventory-value/{warehouseId}', [\App\Http\Controllers\ERP\Inventory\WarehousesController::class, 'inventoryValue'])->name('inventoryValue');
            //Products
            Route::resource('/products', \App\Http\Controllers\ERP\Inventory\ProductsController::class);
        });
    });



});



