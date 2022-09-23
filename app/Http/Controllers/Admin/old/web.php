<?php

Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

Route::get('data-test',['as'=>'data-test','uses'=>'Admin\DataTestController@dataTest']);
Route::get('clear',['as'=>'clear','uses'=>'Admin\AdminAuthController@clear']);
Route::get('login',['as'=>'login','uses'=>'Admin\AdminAuthController@getLogin']);
Route::post('admin',['as'=>'admin','uses'=>'Admin\AdminAuthController@postLogin']);
Route::get('logout',['as'=>'logout','uses'=>'Admin\AdminAuthController@getLogout']);
// Route::get('instagram-test',['as'=>'login','uses'=>'Admin\DataTestController@getInstagram']);

Route::get('seller/login',['as'=>'seller_login','middleware' => ['guest:seller'], 'uses'=>'Seller\SellerAuthController@getLogin']);
Route::post('seller/post-login',['as'=>'post_seller_login','middleware' => ['guest:seller'], 'uses'=>'Seller\SellerAuthController@postLogin']);


Route::group(['namespace'=>'Seller','middleware'=>'auth:seller'], function () {
    // Route::get('seller/dashboard',['middleware'=>'acl:seller_dashboard','as'=>'seller.dashboard','uses'=>'SellerDashboardController@getIndex']);
    //Seller category
    // Route::get('seller/category',['middleware'=>'acl:view_category','as'=>'seller.category.list','uses'=>'CategoryController@getIndex']);
    // Route::get('seller/category/new',['middleware'=>'acl:new_category','as'=>'seller.category.create','uses'=>'CategoryController@getCreate']);
    // Route::post('seller/category/store',['middleware'=>'acl:new_category','as'=>'seller.category.store','uses'=>'CategoryController@postStore']);
    // Route::get('seller/category/{id}/edit',['middleware'=>'acl:edit_category','as'=>'seller.category.edit','uses'=>'CategoryController@getEdit']);
    // Route::post('seller/category/{id}/update',['middleware'=>'acl:edit_category','as'=>'seller.category.update','uses'=>'CategoryController@postUpdate']);
    // Route::get('seller/category/{id}/delete',['middleware'=>'acl:delete_category','as'=>'seller.category.delete','uses'=>'CategoryController@getDelete']);

    //Seller product
    // Route::get('seller/product',['middleware'=>'acl:view_product','as'=>'seller.product.list','uses'=>'ProductController@getIndex']);
    // Route::get('seller/product/new',['middleware'=>'acl:new_product','as'=>'seller.product.create','uses'=>'ProductController@getCreate']);
    // Route::post('seller/product/store',['middleware'=>'acl:new_product','as'=>'seller.product.store','uses'=>'ProductController@postStore']);
    // Route::get('seller/product/{id}/edit',['middleware'=>'acl:edit_product','as'=>'seller.product.edit','uses'=>'ProductController@getEdit']);
    // Route:: get('seller/product/{id}/view',['middleware'=>'acl:view_product','as'=>'seller.product.view','uses'=>'ProductController@getView']);
    // Route::post('seller/product/{id}/update',['middleware'=>'acl:edit_product','as'=>'seller.product.update','uses'=>'ProductController@putUpdate']);
    // Route::get('seller/product/{id}/delete',['middleware'=>'acl:delete_product','as'=>'seller.product.delete','uses'=>'ProductController@getDelete']);
    // Route::get('seller/product/pending',['middleware'=>'acl:view_pending_master','as'=>'seller.product.pending','uses'=>'ProductController@getPendingMaster']);


    // SELLER STOCK INFO
    // Route::get('seller/invoice-details/new/{id?}',['middleware'=>'acl:new_invoice_details','as'=>'seller.invoice-details.new','uses'=>'InvoiceDetailsController@getCreate']);
    // Route::get('seller/invoice-details/variant/{bar_code}/list/{type}',['middleware'=>'acl:view_invoice_details','as'=>'admin.invoice-details.bar-code/variant-list','uses'=>'InvoiceDetailsController@getVariantListByBarCode']);
    // Route::post('seller/invoice-details/store',['middleware'=>'acl:new_invoice_details','as'=>'seller.invoice-details.store','uses'=>'InvoiceDetailsController@postStore']);

    // Route::post('seller/all_product',['uses'=>'DatatableController@getAllProduct']);

    // Vendor
    // Route::get('seller/vendor',['middleware'=>'acl:view_vendor','as'=>'seller.vendor','uses'=>'SellerVendorController@getIndex']);
    // Route::get('seller/vendor/new',['middleware'=>'acl:new_vendor','as'=>'seller.vendor.new','uses'=>'SellerVendorController@getCreate']);
    // Route::post('seller/vendor/store',['middleware'=>'acl:new_vendor','as'=>'seller.vendor.store','uses'=>'SellerVendorController@postStore']);
    // Route::get('seller/vendor/{id}/edit',['middleware'=>'acl:edit_vendor','as'=>'seller.vendor.edit','uses'=>'SellerVendorController@getEdit']);
    // Route::post('seller/vendor/{id}/update',['middleware'=>'acl:edit_vendor','as'=>'seller.vendor.update','uses'=>'SellerVendorController@postUpdate']);
    // Route::get('seller/vendor/{id}/delete',['middleware'=>'acl:delete_vendor','as'=>'seller.vendor.delete','uses'=>'SellerVendorController@getDelete']);

    // Stack In
    // Route::get('seller/invoice',['middleware'=>'acl:view_invoice','as'=>'seller.invoice','uses'=>'SellerInvoiceController@getIndex']);
    // Route::post('seller/invoice/list',['middleware'=>'acl:view_invoice','as'=>'seller.invoice.list','uses'=>'DatatableController@sellerInvoiceList']);
    // Route::get('seller/invoice/new',['middleware'=>'acl:new_invoice','as'=>'seller.invoice.new','uses'=>'SellerInvoiceController@getCreate']);
    // Route::get('seller/invoice/{id}/edit',['middleware'=>'acl:edit_invoice','as'=>'seller.invoice.edit','uses'=>'SellerInvoiceController@getEdit']);
    // Route::post('seller/invoice/{id}/update',['middleware'=>'acl:edit_invoice','as'=>'seller.invoice.update','uses'=>'SellerInvoiceController@postUpdate']);
    // Route::get('seller/invoice/{id}/product',['middleware'=>'acl:new_invoice','as'=>'seller.invoice.get-product','uses'=>'SellerInvoiceController@getProductBySubCategory']);
    // Route::post('seller/invoice/store',['middleware'=>'acl:new_invoice','as'=>'seller.invoice.store','uses'=>'SellerInvoiceController@postStore']);
    // Route::get('seller/invoice/{id}/delete',['middleware'=>'acl:delete_invoice','as'=>'seller.invoice.delete','uses'=>'SellerInvoiceController@getDelete']);
    // Route::get('seller/bank_acc/{id}',['middleware'=>'acl:new_invoice','as'=>'seller.bank_acc','uses'=>'SellerInvoiceController@getBankAcc']);
    // Route::get('seller/imvoice_img_delete/{id}/{invoice_for}',['middleware'=>'acl:delete_invoice','as'=>'seller.imvoice_img_delete','uses'=>'SellerInvoiceController@getImgDelete']);
    // Route::post('seller/merchant_invoice_pdf_permission',['middleware'=>'acl:edit_invoice','as'=>'seller.merchant.invoice.access','uses'=>'SellerInvoiceController@postMerchantInvoicePdfAccess']);


    //Invoice Details
    // Route::get('seller/invoice-details/new/{id}',['middleware'=>'acl:new_invoice_details','as'=>'seller.invoice-details.new','uses'=>'InvoiceDetailsController@getCreate']);
    // Route::get('seller/invoice-details/{id}',['middleware'=>'acl:view_invoice_details','as'=>'seller.invoice-details','uses'=>'InvoiceDetailsController@getIndex']);
    // Route::get('seller/invoice-details/{id}/delete',['middleware'=>'acl:delete_invoice_details','as'=>'seller.invoice-details.delete','uses'=>'InvoiceDetailsController@getDelete']);
    // Route::post('seller/invoice-details/variant/list',['middleware'=>'acl:view_invoice_details','as'=>'seller.invoice-details.variant-list','uses'=>'InvoiceDetailsController@getVariantListById']);
    // Route::get('seller/invoice-details/variant/{bar_code}/list/{type}',['middleware'=>'acl:view_invoice_details','as'=>'seller.invoice-details.bar-code/variant-list','uses'=>'InvoiceDetailsController@getVariantListByBarCode']);
    // Route::get('seller/invoice-details/{id}/product',['middleware'=>'acl:view_invoice_details','as'=>'seller.invoice-details.get-product','uses'=>'InvoiceDetailsController@getProductBySubCategory']);
    // Route::post('seller/invoice-details/store',['middleware'=>'acl:new_invoice_details','as'=>'seller.invoice-details.store','uses'=>'InvoiceDetailsController@postStore']);
    // Route::get('seller/invoice-product-details/{id}/{type}',['middleware'=>'acl:view_invoice_details','as'=>'seller.invoice-product-details.get-product','uses'=>'InvoiceDetailsController@getProductByInvoice']);

    // Route::get('seller/product/get-variant-info-like',[ 'middleware'=>'acl:new_invoice_details','as'=>'seller.get-variant-info-like','uses'=>'InvoiceDetailsController@getVariantInfoLike']);



    // Route::get('seller/product-variant/search/{bar_code}',['middleware'=>'acl:view_invoice_details','as'=>'seller.product-search','uses'=>'InvoiceDetailsController@getVariantListByQueryString']);
    // Route::get('seller/invoice-processing',['middleware'=>'acl:view_invoice_processing','as'=>'seller.invoice_processing','uses'=>'SellerInvoiceController@invoiceProcessing']);
    // Route::post('seller/invoice-processing/list',['middleware'=>'acl:view_invoice_processing','as'=>'seller.invoice_processing.list','uses'=>'DatatableController@invoiceProcessingList']);
    // Route::get('seller/invoice/stock/{id}/delete',['middleware'=>'acl:delete_invoice_processing','as'=>'seller.stock.delete','uses'=>'SellerInvoiceController@getStockDelete']);
    // Route::post('seller/invoice-processing/store',['middleware'=>'acl:new_invoice_processing','as'=>'seller.invoice_processing.new','uses'=>'SellerInvoiceController@postStoreInvoiceProcessing']);
    // Route::get('seller/invoice-qbentry/{id}',['middleware'=>'acl:view_invoice','as'=>'seller.invoice-qbentry','uses'=>'SellerInvoiceController@invoiceQBentry']);
    // Route::get('seller/invoice-loyalty-claime/{id}',['middleware'=>'acl:edit_invoice','as'=>'seller.loyalty-claime','uses'=>'SellerInvoiceController@invoiceLoyaltyClaime']);
    // Route::get('seller/invoice-vat-claime/{id}',['middleware'=>'acl:edit_invoice','as'=>'seller.vat-claime','uses'=>'SellerInvoiceController@invoiceVatClaime']);
    // Route::post('seller/invoice-to-stock/{id}',['middleware'=>'acl:edit_invoice','as'=>'seller.invoice-to-stock','uses'=>'SellerInvoiceController@invoiceToStock']);

});

// SELLER PANEL
// Seller User



Route::group(['namespace'=>'Admin','middleware' => ['auth:admin,seller']], function () {

    // Route::get('seller/seller-user/new',['middleware'=>'acl:add_seller_user','as'=>'seller.seller-user.new','uses'=>'AdminUserController@getCreate']);
    // Route::post('seller/seller-user/store',['middleware'=>'acl:add_seller_user','as'=>'seller.seller-user.store','uses'=>'AdminUserController@postStore']);
    // Route::get('seller/seller-user/{id}/edit',['middleware'=>'acl:edit_seller_user','as'=>'seller.seller-user.edit','uses'=>'AdminUserController@getEdit']);
    // Route::post('seller/seller-user/{id}/update',['middleware'=>'acl:edit_seller_user','as'=>'seller.seller-user.update','uses'=>'AdminUserController@putUpdate']);
    // Route::get('seller/seller-user/{id}/delete',['middleware'=>'acl:delete_seller_user','as'=>'seller.seller-user.delete','uses'=>'AdminUserController@getDelete']);

    // User-Group
    // Route::get('seller/user-group',['middleware'=>'acl:view_seller_user_group','as'=>'seller.user-group','uses'=>'UserGroupController@getIndex']);
    // Route::get('seller/user-group/new',['middleware'=>'acl:new_seller_user_group','as'=>'seller.user-group.new','uses'=>'UserGroupController@getCreate']);
    // Route::post('seller/user-group/store',['middleware'=>'acl:new_seller_user_group','as'=>'seller.user-group.store','uses'=>'UserGroupController@postStore']);
    // Route::get('seller/user-group/{id}/edit',['middleware'=>'acl:edit_seller_user_group','as'=>'seller.user-group.edit','uses'=>'UserGroupController@getEdit']);
    // Route::post('seller/user-group/{id}/update',['middleware'=>'acl:edit_seller_user_group','as'=>'seller.user-group.update','uses'=>'UserGroupController@putUpdate']);
    // Route::get('seller/user-group/{id}/delete',['middleware'=>'acl:delete_seller_user_group','as'=>'seller.user-group.delete','uses'=>'UserGroupController@getDelete']);

    // Role
    // Route::get('seller/role',['middleware'=>'acl:view_seller_role','as'=>'seller.role','uses'=>'RoleController@getIndex']);
    // Route::get('seller/role/new',['middleware'=>'acl:add_seller_role','as'=>'seller.role.new','uses'=>'RoleController@getCreate']);
    // Route::post('seller/role/store',['middleware'=>'acl:add_seller_role','as'=>'seller.role.store','uses'=>'RoleController@postStore']);
    // Route::get('seller/role/{id}/edit',['middleware'=>'acl:edit_seller_role','as'=>'seller.role.edit','uses'=>'RoleController@getEdit']);
    // Route::post('seller/role/{id}/update',['middleware'=>'acl:edit_seller_role','as'=>'seller.role.update','uses'=>'RoleController@postUpdate']);
    // Route::get('seller/role/{id}/delete',['middleware'=>'acl:delete_seller_role','as'=>'seller.role.delete','uses'=>'RoleController@getDelete']);

    // Permission-Group
    // Route::get('seller/permission-group',['middleware'=>'acl:view_seller_menu','as'=>'seller.permission-group','uses'=>'PermissionGroupController@getIndex']);
    // Route::get('seller/permission-group/new',['middleware'=>'acl:new_seller_menu','as'=>'seller.permission-group.new','uses'=>'PermissionGroupController@getCreate']);
    // Route::post('seller/permission-group/store',['middleware'=>'acl:new_seller_menu','as'=>'seller.permission-group.store','uses'=>'PermissionGroupController@postStore']);
    // Route::get('seller/permission-group/{id}/edit',['middleware'=>'acl:edit_seller_menu','as'=>'seller.permission-group.edit','uses'=>'PermissionGroupController@getEdit']);
    // Route::post('seller/permission-group/{id}/update',['middleware'=>'acl:edit_seller_menu','as'=>'seller.permission-group.update','uses'=>'PermissionGroupController@putUpdate']);
    // Route::get('seller/permission-group/{id}/delete',['middleware'=>'acl:delete_seller_menu','as'=>'seller.permission-group.delete','uses'=>'PermissionGroupController@getDelete']);

    // permission
    // Route::get('seller/permission',['middleware'=>'acl:view_seller_action','as'=>'seller.permission','uses'=>'PermissionController@getIndex']);
    // Route::get('seller/permission/new',['middleware'=>'acl:new_seller_action','as'=>'seller.permission.new','uses'=>'PermissionController@getCreate']);
    // Route::post('seller/permission/store',['middleware'=>'acl:new_seller_action','as'=>'seller.permission.store','uses'=>'PermissionController@postStore']);
    // Route::get('seller/permission/{id}/edit',['middleware'=>'acl:edit_seller_action','as'=>'seller.permission.edit','uses'=>'PermissionController@getEdit']);
    // Route::post('seller/permission/{id}/update',['middleware'=>'acl:edit_seller_action','as'=>'seller.permission.update','uses'=>'PermissionController@putUpdate']);
    // Route::get('seller/permission/{id}/delete',['middleware'=>'acl:delete_seller_action','as'=>'seller.permission.delete','uses'=>'PermissionController@getDelete']);
});


Route::group(['namespace'=>'Admin','middleware' => ['auth:admin']], function () {
    // Dashboard
    //Route::get('dashboard',['middleware'=>'acl:dashboard','as'=>'admin.dashboard','uses'=>'DashboardController@index']);
    // Route::get('dashboard',['as'=>'admin.dashboard','uses'=>'DashboardController@getIndex']);
    Route::get('/',['as'=>'admin.dashboard','uses'=>'DashboardController@getIndex']);
    Route::post('translate',['as'=>'admin.dashboard.translate','uses'=>'DashboardController@postTrnaslate']);
    Route::post('postDashboardNote',['as'=>'admin.dashboard.note.post','uses'=>'DashboardController@postDashboardNote']);

    // USER
    Route::get('user/{id}/single-edit',['middleware'=>'acl:edit_user','as'=>'admin.user.loggedin.edit','uses'=>'AdminUserController@getEditSingle']);
    Route::post('user/{id}/update/{single?}',['middleware'=>'acl:edit_user','as'=>'admin.user.update','uses'=>'AdminUserController@putUpdate']);


    // Admin User
    Route::get('branch-admin',['middleware'=>'acl:view_branch_admin','as'=>'admin.branch-admin','uses'=>'AdminUserController@getBranchAdmin']);
    Route::get('branch-admin/{id}/edit',['middleware'=>'acl:edit_branch_admin','as'=>'admin.branch-admin.edit','uses'=>'AdminUserController@editBranchAdmin']);
    Route::get('branch-admin/{id}/users',['middleware'=>'acl:view_branch_user','as'=>'admin.branch.user_create','uses'=>'AdminUserController@getSellerUser']);
    Route::get('admin-users',['middleware'=>'acl:view_admin_user','as'=>'admin.admin-user','uses'=>'AdminUserController@getIndex']);
    Route::get('admin-user/new',['middleware'=>'acl:add_admin_user','as'=>'admin.admin-user.new','uses'=>'AdminUserController@getCreate']);
    Route::post('admin-user/store',['middleware'=>'acl:add_admin_user','as'=>'admin.admin-user.store','uses'=>'AdminUserController@postStore']);
    Route::get('admin-user/{id}/edit',['middleware'=>'acl:edit_admin_user','as'=>'admin.admin-user.edit','uses'=>'AdminUserController@getEdit']);
    Route::post('admin-user/{id}/update',['middleware'=>'acl:edit_admin_user','as'=>'admin.admin-user.update','uses'=>'AdminUserController@putUpdate']);
    // Route::get('admin-user/{id}/delete',['middleware'=>'acl:delete_admin_user','as'=>'admin.admin-user.delete','uses'=>'AdminUserController@getDelete']);

    // User-Group
    Route::get('user-group',['middleware'=>'acl:view_user_group','as'=>'admin.user-group','uses'=>'UserGroupController@getIndex']);
    Route::get('user-group/new',['middleware'=>'acl:new_user_group','as'=>'admin.user-group.new','uses'=>'UserGroupController@getCreate']);
    Route::post('user-group/store',['middleware'=>'acl:new_user_group','as'=>'admin.user-group.store','uses'=>'UserGroupController@postStore']);
    Route::get('user-group/{id}/edit',['middleware'=>'acl:edit_user_group','as'=>'admin.user-group.edit','uses'=>'UserGroupController@getEdit']);
    Route::post('user-group/{id}/update',['middleware'=>'acl:edit_user_group','as'=>'admin.user-group.update','uses'=>'UserGroupController@putUpdate']);
    Route::get('user-group/{id}/delete',['middleware'=>'acl:delete_user_group','as'=>'admin.user-group.delete','uses'=>'UserGroupController@getDelete']);

    // User-Group
    Route::get('assign-access',['middleware'=>'acl:assign_user_access','as'=>'admin.assign-access','uses'=>'AssignAccessController@getIndex']);
    Route::post('assign-access',['middleware'=>'acl:assign_user_access','as'=>'admin.assign-access.post','uses'=>'AssignAccessController@postIndex']);

    // Role
    Route::get('role',['middleware'=>'acl:view_role','as'=>'admin.role','uses'=>'RoleController@getIndex']);
    Route::get('role/new',['middleware'=>'acl:add_role','as'=>'admin.role.new','uses'=>'RoleController@getCreate']);
    Route::post('role/store',['middleware'=>'acl:add_role','as'=>'admin.role.store','uses'=>'RoleController@postStore']);
    Route::get('role/{id?}/edit',['middleware'=>'acl:edit_role','as'=>'admin.role.edit','uses'=>'RoleController@getEdit']);
    Route::post('role/{id}/update',['middleware'=>'acl:edit_role','as'=>'admin.role.update','uses'=>'RoleController@postUpdate']);
    Route::get('role/{id}/delete',['middleware'=>'acl:delete_role','as'=>'admin.role.delete','uses'=>'RoleController@getDelete']);

    // Permission-Group
    Route::get('permission-group',['middleware'=>'acl:view_menu','as'=>'admin.permission-group','uses'=>'PermissionGroupController@getIndex']);
    Route::get('permission-group/new',['middleware'=>'acl:new_menu','as'=>'admin.permission-group.new','uses'=>'PermissionGroupController@getCreate']);
    Route::post('permission-group/store',['middleware'=>'acl:new_menu','as'=>'admin.permission-group.store','uses'=>'PermissionGroupController@postStore']);
    Route::get('permission-group/{id}/edit',['middleware'=>'acl:edit_menu','as'=>'admin.permission-group.edit','uses'=>'PermissionGroupController@getEdit']);
    Route::post('permission-group/{id}/update',['middleware'=>'acl:edit_menu','as'=>'admin.permission-group.update','uses'=>'PermissionGroupController@putUpdate']);
    Route::get('permission-group/{id}/delete',['middleware'=>'acl:delete_menu','as'=>'admin.permission-group.delete','uses'=>'PermissionGroupController@getDelete']);

    // permission
    Route::get('permission',['middleware'=>'acl:view_action','as'=>'admin.permission','uses'=>'PermissionController@getIndex']);
    Route::get('permission/new',['middleware'=>'acl:new_action','as'=>'admin.permission.new','uses'=>'PermissionController@getCreate']);
    Route::post('permission/store',['middleware'=>'acl:new_action','as'=>'admin.permission.store','uses'=>'PermissionController@postStore']);
    Route::get('permission/{id}/edit',['middleware'=>'acl:edit_action','as'=>'admin.permission.edit','uses'=>'PermissionController@getEdit']);
    Route::post('permission/{id}/update',['middleware'=>'acl:edit_action','as'=>'admin.permission.update','uses'=>'PermissionController@putUpdate']);
    Route::get('permission/{id}/delete',['middleware'=>'acl:delete_action','as'=>'admin.permission.delete','uses'=>'PermissionController@getDelete']);


    //Branch Admin list
    Route::get('branch/users',['middleware'=>'acl:view_branch_user','as'=>'admin.branch-user','uses'=>'AdminUserController@getBranchUser']);

    //product

    Route::post('product/all_product',['middleware'=>'acl:view_product_list','as'=>'admin.product.all_product','uses'=>'DatatableController@getAllProduct']);
    Route::post('product/pending_master',['middleware'=>'acl:view_pending_master','as'=>'admin.product.pending_master','uses'=>'DatatableController@getPendingMaster']);
    Route::post('product/pending_varint_list',['middleware'=>'acl:view_pending_varint','as'=>'admin.product.pending_varint','uses'=>'DatatableController@getPendingVarint']);
    Route::get('product-search-list',['middleware'=>'acl:view_product_list','as'=>'admin.product.searchlist','uses'=>'ProductController@getProductSearch']);
    Route::post('product-search-list',[ 'middleware'=>'acl:view_product_list','as'=>'admin.searchlist.view.post','uses'=>'ProductController@getProductSearchList']);
    Route::get('product-list/{id}/view',['middleware'=>'acl:view_product_list','as'=>'admin.product.searchlist.view','uses'=>'ProductController@getView']);
    Route::get('product-list/{id}/edit',['middleware'=>'acl:edit_product_list','as'=>'admin.product.searchlist.edit','uses'=>'ProductController@getEdit']);
    Route::post('master-variant/view',['middleware'=>'acl:edit_product_list','as'=>'admin.update.masterVariant','uses'=>'ProductController@postMasterVariantView']);
    Route::post('master/search',['middleware'=>'acl:edit_product_list','as'=>'admin.master_search','uses'=>'ProductController@postMasterSearch']);
    Route::post('master/swap',['middleware'=>'acl:edit_product_list','as'=>'admin.update.masterVariant.swap','uses'=>'ProductController@postVariantMasterSwap']);

    Route::get('product',['middleware'=>'acl:view_product','as'=>'admin.product.list','uses'=>'ProductController@getIndex']);
    Route::get('product/new',['middleware'=>'acl:new_product','as'=>'admin.product.create','uses'=>'ProductController@getCreate']);
    Route::post('product/store',['middleware'=>'acl:new_product','as'=>'admin.product.store','uses'=>'ProductController@postStore']);
    Route::get('product/{id}/edit',['middleware'=>'acl:edit_product','as'=>'admin.product.edit','uses'=>'ProductController@getEdit']);
    Route:: get('product/{id}/view',['middleware'=>'acl:view_product','as'=>'admin.product.view','uses'=>'ProductController@getView']);
    Route::post('product/{id}/update',['middleware'=>'acl:edit_product','as'=>'admin.product.update','uses'=>'ProductController@putUpdate']);
    Route::get('product/{id}/delete',['middleware'=>'acl:delete_product','as'=>'admin.product.delete','uses'=>'ProductController@getDelete']);
    Route::get('product/pending',['middleware'=>'acl:view_pending_master','as'=>'admin.product.pending','uses'=>'ProductController@getPendingMaster']);
    Route::get('product/pending_varint',['middleware'=>'acl:view_pending_varint','as'=>'admin.varint.pending','uses'=>'ProductController@getPendingVarint']);
    Route::get('product/{id}/pending_varint_edit',['middleware'=>'acl:view_pending_varint','as'=>'admin.pending_varint.edit','uses'=> 'ProductController@editPendingVarint']);

    Route::post('product_variant/store',['middleware'=>'acl:new_product_variant','as'=>'admin.product_variant.store','uses'=>'ProductController@postStoreProductVariant']);
    Route::post('product_variant/{id}/update',['middleware'=>'acl:edit_product_variant','as'=>'admin.product_variant.update','uses'=>'ProductController@putUpdateProductVariant']);
    Route::get('product_variant/{id}/delete',['middleware'=>'acl:delete_product_variant','as'=>'admin.product_variant.delete','uses'=>'ProductController@getDeleteProductVariant']);
    //ajax route for product module
    Route::get('prod_img_delete/{id}',['middleware'=>'acl:edit_product_variant','as'=>'admin.product.img_delete','uses'=>'ProductController@getDeleteImage']);
    Route::get('prod_subcategory/{id}',[ 'middleware'=>'acl:new_product','as'=>'product.prod_subcategory.','uses' =>'ProductController@getSubcat']);
    Route::get('get_brand_model_by_scat/{id}',[ 'middleware'=>'acl:view_product','as'=>'brand_model_list_by_scat','uses' =>'ProductController@getBrandModelByScat']);


    Route::get('product/branch-products',['middleware'=>'acl:view_product','as'=>'admin.product.branch-products','uses'=>'ProductController@getProAddToShop']);
    Route::post('ajax/variant-by-master',['middleware'=>'acl:view_product','as'=>'variant-by-master','uses'=>'ProductController@getVariantByMasterAj']);
    Route::post('product/store_to_shop',['middleware'=>'acl:product_assigned_to_shop','as'=>'admin.product.storeToShop','uses'=>'ProductController@storeToShop']);

    Route::post('ajax/get-shop-master',[ 'middleware'=>'acl:branch-products','as'=>'get_shop_master','uses' =>'ProductController@getShopMaster']);
    // Route::post('ajax/shop-master-status',[ 'middleware'=>'acl:branch-products','as'=>'shop-master-status','uses' =>'ProductController@getShopMasterStatus']);
    Route::post('ajax/shop-variant-status',[ 'middleware'=>'acl:branch-products','as'=>'shop-variant-status','uses' =>'ProductController@getShopVariantStatus']);


    // Route::get('prod_model/{id}',[ 'middleware'=>'acl:new_product','as'=>'product.prod_model','uses'=>'ProductController@getProdModel']);
    Route::get('get_hscode_by_scat/{id?}',[ 'middleware'=>'acl:new_product','as'=>'get_hscode_by_scat','uses'=>'ProductController@getHscode']);
    Route::get('refresh-product-attribute-ajax',[ 'middleware'=>'acl:new_product','uses'=>'ProductController@postAjaxRefreshProductAttribute']);
    Route::post('product-search',[ 'middleware'=>'acl:new_product','as'=>'admin.product_search','uses'=>'ProductController@getProductSearchList']);
    Route::post('product/search-back',[ 'middleware'=>'acl:new_product','as'=>'admin.add_to_mother_page','uses'=>'ProductController@getProductSearchGoBack']);
    Route::post('product/search-back',[ 'middleware'=>'acl:new_product','as'=>'admin.add_to_mother_page','uses'=>'ProductController@getProductSearchGoBack']);
    Route::post('product/get-category-child',[ 'middleware'=>'acl:new_product','uses'=>'ProductController@getAjaxCategoryChild']);
    Route::post('category-related-attributes',[ 'middleware'=>'acl:new_product','uses'=>'ProductController@getAjaxCategoryAttr']);
    Route::post('get-attribute-childs',[ 'middleware'=>'acl:new_product','uses'=>'ProductController@getAjaxAttrChilds']);
    Route::post('get-feature-options-ajax',[ 'middleware'=>'acl:new_product','uses'=>'ProductController@getAjaxFeaOptions']);
    Route::post('get-generate-variants-ajax',[ 'middleware'=>'acl:new_product','uses'=>'ProductController@getAjaxVariantGenerate']);
    Route::post('delete-additional-category-ajax',[ 'middleware'=>'acl:new_product','uses'=>'ProductController@postAjaxDeleteAddtionalCategory']);
    Route::post('add-additional-category-ajax',[ 'middleware'=>'acl:new_product','uses'=>'ProductController@postAjaxAddAddtionalCategory']);
    Route::post('delete-product-attribute-ajax',[ 'middleware'=>'acl:new_product','uses'=>'ProductController@postAjaxDeleteProductAttribute']);
    Route::post('add-product-spcategory-ajax',['middleware'=>'acl:edit_product','uses'=>'ProductController@postSpcatStoreAjax']);
    Route::post('delete-product-spcategory-ajax',['middleware'=>'acl:edit_product','uses'=>'ProductController@postSpcatDeleteAjax']);

    Route::get('product/variant/{id}/view',['middleware'=>'acl:edit_product','as'=>'seller.product.variant.store.index','uses'=>'ProductController@getVariantStoreView']);
    Route::post('ajax/if-product-master-in-shop',['middleware'=>'acl:edit_product','as'=>'seller.product.if.store','uses'=>'ProductController@postIfMasterStore']);
    Route::post('ajax/if-product-variant-in-shop',['middleware'=>'acl:edit_product','as'=>'seller.variant.if.store','uses'=>'ProductController@postIfVariantStore']);
    Route::post('ajax/if-product-category-in-shop',['middleware'=>'acl:edit_product','as'=>'seller.category.if.store','uses'=>'ProductController@postIfCategoryStore']);
    Route::post('store-product-master-variant-list',['uses'=>'DatatableController@getProductVariantStore']);

    Route::get('delivery/delivery_schedule',['middleware'=>'acl:view_model', 'as'=>'admin.delivery.delivery_schedule', 'uses'=>'DeliveryScheduleController@getIndex']);
    Route::get('ajax/get-schedule-create',['middleware'=>'acl:view_model', 'as'=>'admin.delivery.schedule-create', 'uses'=>'DeliveryScheduleController@getCreate']);
    Route::post('ajax/delivery/schedule_store',['middleware'=>'acl:edit_product', 'as'=>'admin.delivery.schedule_store', 'uses'=>'DeliveryScheduleController@postStore']);
    Route::post('ajax/schedule/generate',['middleware'=>'acl:edit_product', 'as'=>'admin.schedule.generate', 'uses'=>'DeliveryScheduleController@postGenerate']);

    //product-model
    // Route::get('product-model',['middleware'=>'acl:view_model','as'=>'admin.product-model','uses'=>'ProductModelController@getIndex']);
    // Route::get('product-model/new',['middleware'=>'acl:new_model','as'=>'admin.product-model.new','uses'=>'ProductModelController@getCreate']);
    // Route::post('product-model/store',['middleware'=>'acl:new_model','as'=>'admin.product-model.store','uses'=>'ProductModelController@postStore']);
    // Route::get('product-model/{id}/edit',['middleware'=>'acl:edit_model','as'=>'admin.product-model.edit','uses'=>'ProductModelController@getEdit']);
    // Route::post('product-model/{id}/update',['middleware'=>'acl:edit_model','as'=>'admin.product-model.update','uses'=>'ProductModelController@putUpdate']);
    // Route::get('product-model/{id}/delete',['middleware'=>'acl:delete_model','as'=>'admin.product-model.delete','uses'=>'ProductModelController@getDelete']);

    //product-color

    // Route::get('product-color',['middleware'=>'acl:view_color','as'=>'admin.product.color.list','uses'=>'ColorsController@getIndex']);
    // Route::get('product-color/new',['middleware'=>'acl:new_color','as'=>'admin.product.color.create','uses'=>'ColorsController@getCreate']);
    // Route::post('product-color/store',['middleware'=>'acl:new_color','as'=>'admin.product.color.store','uses'=>'ColorsController@postStore']);
    // Route::get('product-color/{id}/edit',['middleware'=>'acl:edit_color','as'=>'admin.product.color.edit','uses'=>'ColorsController@getEdit']);
    // Route::post('product-color/{id}/update',['middleware'=>'acl:edit_color','as'=>'admin.product.color.update','uses'=>'ColorsController@postUpdate']);
    // Route::get('product-color/{id}/delete',['middleware'=>'acl:delete_color','as'=>'admin.product.color.delete','uses'=>'ColorsController@getDelete']);


    //product-size
    // Route::get('product-size',['middleware'=>'acl:view_size','as'=>'admin.product-size','uses'=>'ProductSizeController@getIndex']);
    // Route::get('product-size/new',['middleware'=>'acl:new_size','as'=>'admin.product-size.new','uses'=>'ProductSizeController@getCreate']);
    // Route::post('product-size/store',['middleware'=>'acl:new_size','as'=>'admin.product-size.store','uses'=>'ProductSizeController@postStore']);
    // Route::get('product-size/{id}/edit',['middleware'=>'acl:edit_size','as'=>'admin.product-size.edit','uses'=>'ProductSizeController@getEdit']);
    // Route::post('product-size/{id}/update',['middleware'=>'acl:edit_size','as'=>'admin.product-size.update','uses'=>'ProductSizeController@putUpdate']);
    // Route::get('product-size/{id}/delete',['middleware'=>'acl:delete_size','as'=>'admin.product-size.delete','uses'=>'ProductSizeController@getDelete']);

    // PRODUCT ATTRIBUTES
    Route::get('product-attribute',['middleware'=>'acl:view_product_attr','as'=>'admin.product-attr.index','uses'=>'ProductAttrController@getMasterIndex']);
    Route::get('product-attribute/new',['middleware'=>'acl:add_product_attr','as'=>'admin.product-attr.new','uses'=>'ProductAttrController@getMasterNew']);
    Route::get('product-attribute-child/{id}',['middleware'=>'acl:add_product_attr','as'=>'admin.product-attr-child.new','uses'=>'ProductAttrController@getChildNew']);
    Route::post('product-attribute-store',['middleware'=>'acl:add_product_attr','as'=>'admin.product-attr.store','uses'=>'ProductAttrController@postMaster']);
    Route::get('product-attribute/edit/{id}',['middleware'=>'acl:edit_product_attr','as'=>'admin.product-attr.edit','uses'=>'ProductAttrController@getMasterEdit']);
    Route::post('product-attribute-update/{id}',['middleware'=>'acl:edit_product_attr','as'=>'admin.product-attr.update','uses'=>'ProductAttrController@postMasterUpdate']);
    Route::get('product-attribute-delete/{id}',['middleware'=>'acl:delete_product_attr','as'=>'admin.product-attr.delete','uses'=>'ProductAttrController@getMasterDelete']);
    Route::get('product-attribute-child',['middleware'=>'acl:view_product_attr','as'=>'admin.product-attr-child.index','uses'=>'ProductAttrController@getChildIndex']);
    Route::post('addUpdateChild',['middleware'=>'acl:add_product_attr','as'=>'admin.product-attr-child.update','uses'=>'ProductAttrController@postChildAddUpdate']);
    Route::post('update-attribute-order',['middleware'=>'acl:add_product_attr','as'=>'admin.product-attr-child.update.ajax','uses'=>'ProductAttrController@postChildOrderUpdate']);

    // PRODUCT FEATURES
    Route::get('product-feature',['middleware'=>'acl:view_product_feature','as'=>'admin.product-feature.index','uses'=>'ProductFeatureController@getMasterIndex']);
    Route::get('product-feature/new',['middleware'=>'acl:add_product_feature','as'=>'admin.product-feature.new','uses'=>'ProductFeatureController@getMasterNew']);
    Route::get('product-feature-child/{id}',['middleware'=>'acl:add_product_feature','as'=>'admin.product-feature-child.new','uses'=>'ProductFeatureController@getChildNew']);
    Route::post('product-feature-store',['middleware'=>'acl:add_product_feature','as'=>'admin.product-feature.store','uses'=>'ProductFeatureController@postMaster']);
    Route::get('product-feature/edit/{id}',['middleware'=>'acl:edit_product_feature','as'=>'admin.product-feature.edit','uses'=>'ProductFeatureController@getMasterEdit']);
    Route::post('product-feature-update/{id}',['middleware'=>'acl:edit_product_feature','as'=>'admin.product-feature.update','uses'=>'ProductFeatureController@postMasterUpdate']);
    Route::get('product-feature-delete/{id}',['middleware'=>'acl:delete_product_feature','as'=>'admin.product-feature.delete','uses'=>'ProductFeatureController@getMasterDelete']);
    Route::get('product-feature-child',['middleware'=>'acl:view_product_feature','as'=>'admin.product-feature-child.index','uses'=>'ProductFeatureController@getChildIndex']);
    Route::post('addUpdateFeature',['middleware'=>'acl:edit_product_feature','as'=>'admin.product-feature.update.ajax','uses'=>'ProductFeatureController@postFeatureAddUpdate']);
    Route::post('addUpdateFeatureChilds',['middleware'=>'acl:edit_product_feature','as'=>'admin.product-feature-child.update.ajax','uses'=>'ProductFeatureController@postAddUpdateFeatureChilds']);
    Route::post('update-feature-order',['middleware'=>'acl:edit_product_feature','as'=>'admin.product-feature-order.update.ajax','uses'=>'ProductFeatureController@postMasterOrderUpdate']);
    Route::post('showFeatureChilds',['middleware'=>'acl:add_product_feature','as'=>'admin.product-feature-child.view','uses'=>'ProductFeatureController@postShowFeatureChild']);

    //Brand
    // Route::get('product-brand',['middleware'=>'acl:view_brand','as'=>'product.brand.list','uses'=>'BrandController@getIndex']);
    // Route::get('product-brand/new',['middleware'=>'acl:new_brand','as'=>'product.brand.create','uses'=>'BrandController@getCreate']);
    // Route::post('product-brand/store',['middleware'=>'acl:new_brand','as'=>'product.brand.store','uses'=>'BrandController@postStore']);
    // Route::get('product-brand/{id}/edit',['middleware'=>'acl:edit_brand','as'=>'product.brand.edit','uses'=>'BrandController@postEdit']);
    // Route::post('product-brand/{id}/update',['middleware'=>'acl:edit_brand','as'=>'product.brand.update','uses'=>'BrandController@postUpdate']);
    // Route::get('product-brand/{id}/delete',['middleware'=>'acl:delete_brand','as'=>'product.brand.delete','uses'=>'BrandController@getDelete']);

    // //Account Source
    Route::get('account',['middleware'=>'acl:view_account_source','as'=>'admin.account.list','uses'=>'AccountController@getIndex']);
    Route::get('account/new',['middleware'=>'acl:new_account_source','as'=>'account.source.create','uses'=>'AccountController@getCreate']);
    Route::post('account/store',['middleware'=>'acl:new_account_source','as'=>'account.store','uses'=>'AccountController@postAccSource']);
    Route::get('account/{id}/delete',['middleware'=>'acl:delete_account_source','as'=>'account.source.delete','uses'=>'AccountController@getDelete']);
    Route::post('account/{id}/update',['middleware'=>'acl:edit_account_source','as'=>'account.source.update','uses'=>'AccountController@putUpdate']);

    //Account Bank Name
    Route::get('account-bank',['middleware'=>'acl:view_account_name','as'=>'account.bank.list','uses'=>'BankAccountController@getIndex']);
    Route::get('account-bank/new',['middleware'=>'acl:new_account_name','as'=>'account.bank.create','uses'=>'BankAccountController@getCreateBank']);
    Route::post('account-bank/store',['middleware'=>'acl:new_account_name','as'=>'account.bank.store','uses'=>'BankAccountController@postStore']);
    Route::post('account-bank/store',['middleware'=>'acl:new_account_name','as'=>'account.bank.store.single','uses'=>'BankAccountController@postStoreSingle']);
    Route::post('account-bank/{id}/update',['middleware'=>'acl:edit_account_name','as'=>'account.bank.update','uses'=>'BankAccountController@putUpdate']);
    Route::get('account-bank/{id}/delete',['middleware'=>'acl:delete_account_name','as'=>'account.name.delete','uses'=>'BankAccountController@getDelete']);

    //approved route
    Route::get('accounts/{id}/transaction',['middleware'=>'acl:view_accounts_transaction','as'=>'admin.accounts.transaction','uses'=>'PaymentBankController@getTransaction']);
    Route::get('accounts',['middleware'=>'acl:view_accounts','as'=>'admin.accounts.list','uses'=>'PaymentBankController@getIndex']);
    Route::get('accounts/new',['middleware'=>'acl:new_accounts','as'=>'admin.accounts.create','uses'=>'PaymentBankController@getCreate']);
    Route::post('accounts/store',['middleware'=>'acl:new_payment','as'=>'admin.accounts.store','uses'=>'PaymentBankController@postStore']);
    Route::get('accounts/{id}/edit',['middleware'=>'acl:edit_payment','as'=>'admin.accounts.edit','uses'=>'PaymentBankController@getEdit']);
    Route::post('accounts/{id}/update',['middleware'=>'acl:edit_payment','as'=>'admin.accounts.update','uses'=>'PaymentBankController@postEdit']);

    // Route::get('accounts/balances',['middleware'=>'acl:view_payment_bank','as'=>'accounts.balances','uses'=>'PaymentBankController@bankBalance']);
    // Route::get('accounts/balances/create',['middleware'=>'acl:view_payment_bank','as'=>'accounts.add_balance','uses'=>'PaymentBankController@addBalance']);
    Route::get('accounts/balance_transfer',['middleware'=>'acl:view_payment_bank','as'=>'accounts.balance_transfer','uses'=>'PaymentBankController@balanceTransfer']);
    Route::get('accounts/balance_transfer/create',['middleware'=>'acl:view_payment_bank','as'=>'accounts.balance_transfer.create','uses'=>'PaymentBankController@balanceTransferCreate']);
    Route::get('accounts/balance_history',['middleware'=>'acl:view_payment_bank','as'=>'accounts.balance_history','uses'=>'PaymentBankController@balanceHistory']);
    Route::get('payments/purchase',['middleware'=>'acl:view_payment_purchase','as'=>'payments.purchase','uses'=>'PaymentBankController@paymentPurchase']);
    Route::get('payments/purchase/create',['middleware'=>'acl:new_payment_purchase','as'=>'payments.purchase.create','uses'=>'PaymentBankController@paymentPurchaseCreate']);
    Route::get('payments/non_purchase',['middleware'=>'acl:view_payment_bank','as'=>'payments.non_purchase','uses'=>'PaymentBankController@paymentNonPurchase']);

    // Route::post('account-bank/store',['middleware'=>'acl:new_payment','as'=>'account.bank.store.single','uses'=>'PaymentBankController@postStoreSingle']);
    // Route::post('account-bank/{id}/update',['middleware'=>'acl:edit_account_name','as'=>'account.bank.update','uses'=>'PaymentBankController@putUpdate']);
    // Route::get('account-bank/{id}/delete',['middleware'=>'acl:delete_account_name','as'=>'account.name.delete','uses'=>'PaymentBankController@getDelete']);

    //Account payment method
    Route::post('account-method/{id}/update',['middleware'=>'acl:edit_payment_method','as'=>'account.bank.method.update','uses'=>'AccountMethodController@putUpdate']);
    Route::get('account-method/{id}/delete',['middleware'=>'acl:delete_payment_method','as'=>'account.method.delete','uses'=>'AccountMethodController@getDelete']);
    Route::post('account-method/store',['middleware'=>'acl:new_payment_method','as'=>'account.method.store','uses'=>'AccountMethodController@postStore']);

    //Agent Section
    // Route::get('agent/new',['middleware'=>'acl:new_agent','as'=>'agent.create','uses'=>'AgentController@getCreate']);
    // Route::post('agent/store',['middleware'=>'acl:new_agent','as'=>'admin.agent.store','uses'=>'AgentController@postStore']);
    // Route::get('agent/list',['middleware'=>'acl:view_agent','as'=>'admin.agent.list','uses'=>'AgentController@getIndex']);
    // Route::get('agent/{id}/edit',['middleware'=>'acl:edit_agent','as'=>'admin.agent.edit','uses'=>'AgentController@getEdit']);
    // Route::post('agent/update/{id}',['middleware'=>'acl:edit_agent','as'=>'admin.agent.update','uses'=>'AgentController@postUpdate']);
    // Route::get('agent/{id}/delete',['middleware'=>'acl:delete_agent','as'=>'admin.agent.delete','uses'=>'AgentController@getDelete']);

    //Branch Section
    Route::post('seller/all_reseller','DatatableController@all_reseller');
    Route::get('seller',['middleware'=>'acl:view_seller','as'=>'admin.seller.list','uses'=>'SellerController@getIndex']);
    Route::get('seller/new',['middleware'=>'acl:new_seller','as'=>'admin.seller.create','uses'=>'SellerController@getCreate']);
    Route::post('seller/store',['middleware'=>'acl:new_seller','as'=>'admin.seller.store','uses'=>'SellerController@postStore']);
    Route::get('seller/{id}/edit',['middleware'=>'acl:edit_seller','as'=>'admin.seller.edit','uses'=>'SellerController@getEdit']);
    Route::post('seller/{id}/update',['middleware'=>'acl:edit_seller','as'=>'admin.seller.update','uses'=>'SellerController@postUpdate']);

    Route::post('seller/seller_user',['middleware'=>'acl:new_seller','as'=>'admin.seller.user_store','uses'=>'SellerController@postSellerUser']);
    Route::get('seller/{id}/payment-history',['middleware'=>'acl:edit_seller','as'=>'admin.seller.payment_history','uses'=>'SellerController@getPaymentHistory']);
    // Route::get('seller/{id}/delete',['middleware'=>'acl:delete_seller','as'=>'admin.seller.delete','uses'=>'SellerController@getDelete']);
    Route::get('seller/{id}/view',['middleware'=>'acl:view_seller','as'=>'admin.seller.view','uses'=>'SellerController@getView']);
    Route::get('seller/{id}/business_doc_delete',['middleware'=>'acl:edit_seller','as'=>'admin.seller.business_doc_delete','uses'=>'SellerController@businesDocDelete']);
    Route::post('seller/seller_area',['middleware'=>'acl:edit_seller','as'=>'admin.seller_area.store','uses'=>'SellerController@postSellerAreaStore']);
    // Route::post('seller/ajax/get_area_search',['middleware'=>'acl:edit_seller','as'=>'admin.seller.get_area_search','uses'=>'SellerController@getSearchArea']);
    Route::get('seller/ajax/get-coverage-area-create/{id}',['middleware'=>'acl:edit_seller','as'=>'admin.seller.get_coverage_area_create','uses'=>'SellerController@getCoverageAreaForm']);
    Route::get('ajax/get-coverage-area-delete/{id}',['middleware'=>'acl:edit_seller','as'=>'admin.seller.coverage_area_delete','uses'=>'SellerController@getCoverageAreaDelete']);

    // Route::get('reseller',['middleware'=>'acl:view_reseller','as'=>'reseller.list','uses'=>'SellerController@getIndex']);
    // Route::get('seller/new',['middleware'=>'acl:new_reseller','as'=>'reseller.create','uses'=>'SellerController@getCreate']);
    // Route::post('seller/store',['middleware'=>'acl:new_reseller','as'=>'admin.seller.store','uses'=>'SellerController@postStore']);
    // Route::get('seller/{id}/edit',['middleware'=>'acl:edit_reseller','as'=>'admin.seller.edit','uses'=>'SellerController@getEdit']);
    // Route::post('seller/update/{id}',['middleware'=>'acl:edit_reseller','as'=>'admin.seller.update','uses'=>'SellerController@postUpdate']);
    // Route::get('seller/{id}/delete',['middleware'=>'acl:delete_reseller','as'=>'admin.seller.delete','uses'=>'SellerController@getDelete']);
    //Inventory
    // Route::get('inventory',['middleware'=>'acl:view_inventory','as'=>'product.inventory.list','uses'=>'InventoryController@getIndex']);
    // Route::get('inventory/new',['middleware'=>'acl:new_brand','as'=>'product.inventory.create','uses'=>'InventoryController@getCreate']);
    // Route::post('inventory/store',['middleware'=>'acl:new_brand','as'=>'product.inventory.store','uses'=>'InventoryController@postStore']);
    // Route::post('inventory/{id}/edit',['middleware'=>'acl:edit_brand','as'=>'product.inventory.edit','uses'=>'InventoryController@postEdit']);
    // Route::post('inventory/{id}/update',['middleware'=>'acl:update_brand','as'=>'product.inventory.edit','uses'=>'InventoryController@postUpdate']);
    // Route::post('inventory/{id}/delete',['middleware'=>'acl:delete_brand','as'=>'product.inventory.delete','uses'=>'InventoryController@postDelete']);
    // Procurement =====
    // Vendor
    Route::get('vendors',['middleware'=>'acl:view_vendor','as'=>'admin.vendor','uses'=>'VendorController@getIndex']);
    Route::get('vendors/new',['middleware'=>'acl:new_vendor','as'=>'admin.vendor.new','uses'=>'VendorController@getCreate']);
    Route::post('vendors/store',['middleware'=>'acl:new_vendor','as'=>'admin.vendor.store','uses'=>'VendorController@postStore']);
    Route::get('vendors/{id}/edit',['middleware'=>'acl:edit_vendor','as'=>'admin.vendor.edit','uses'=>'VendorController@getEdit']);
    Route::get('vendors/{id}/view',['middleware'=>'acl:view_vendor','as'=>'admin.vendor.view','uses'=>'VendorController@getView']);
    Route::post('vendors/{id}/update',['middleware'=>'acl:edit_vendor','as'=>'admin.vendor.update','uses'=>'VendorController@postUpdate']);
    Route::get('vendors/{id}/delete',['middleware'=>'acl:delete_vendor','as'=>'admin.vendor.delete','uses'=>'VendorController@getDelete']);

    // Stack In
    Route::get('invoice',['middleware'=>'acl:view_invoice','as'=>'admin.invoice','uses'=>'InvoiceController@getIndex']);
    Route::get('invoice/getpurchaser/{id}',['middleware'=>'acl:new_invoice','as'=>'admin.invoice.getpurchaser','uses'=>'InvoiceController@getPurchaser']);
    Route::post('invoice/list',['middleware'=>'acl:view_invoice','as'=>'admin.invoice.list','uses'=>'DatatableController@InvoiceList']);
    Route::get('invoice/new',['middleware'=>'acl:new_invoice','as'=>'admin.invoice.new','uses'=>'InvoiceController@getCreate']);
    Route::get('invoice/{id}/edit',['middleware'=>'acl:edit_invoice','as'=>'admin.invoice.edit','uses'=>'InvoiceController@getEdit']);
    Route::post('invoice/{id}/update',['middleware'=>'acl:edit_invoice','as'=>'admin.invoice.update','uses'=>'InvoiceController@postUpdate']);
    Route::get('invoice/{id}/product',['middleware'=>'acl:new_invoice','as'=>'admin.invoice.get-product','uses'=>'InvoiceController@getProductBySubCategory']);
    Route::post('invoice/store',['middleware'=>'acl:new_invoice','as'=>'admin.invoice.store','uses'=>'InvoiceController@postStore']);
    Route::get('invoice/{id}/delete',['middleware'=>'acl:delete_invoice','as'=>'admin.invoice.delete','uses'=>'InvoiceController@getDelete']);
    Route::get('bank_acc/{id}',['middleware'=>'acl:new_invoice','as'=>'admin.bank_acc','uses'=>'InvoiceController@getBankAcc']);
    Route::get('imvoice_img_delete/{id}/{invoice_for}',['middleware'=>'acl:delete_invoice','as'=>'admin.imvoice_img_delete','uses'=>'InvoiceController@getImgDelete']);
    Route::post('merchant_invoice_pdf_permission',['middleware'=>'acl:edit_invoice','as'=>'admin.merchant.invoice.access','uses'=>'InvoiceController@postMerchantInvoicePdfAccess']);

    //Invoice Details
    Route::get('invoice-details/new/{id}',['middleware'=>'acl:new_invoice_details','as'=>'admin.invoice-details.new','uses'=>'InvoiceDetailsController@getCreate']);
    Route::get('invoice-details/{id}',['middleware'=>'acl:view_invoice_details','as'=>'admin.invoice-details','uses'=>'InvoiceDetailsController@getIndex']);
    Route::get('invoice-details/{id}/delete',['middleware'=>'acl:delete_invoice_details','as'=>'admin.invoice-details.delete','uses'=>'InvoiceDetailsController@getDelete']);
    Route::post('invoice-details/variant/list',['middleware'=>'acl:view_invoice_details','as'=>'admin.invoice-details.variant-list','uses'=>'InvoiceDetailsController@getVariantListById']);
    Route::get('invoice-details/variant/{bar_code}/list/{type}',['middleware'=>'acl:view_invoice_details','as'=>'admin.invoice-details.bar-code/variant-list','uses'=>'InvoiceDetailsController@getVariantListByBarCode']);
    Route::get('invoice-details/{id}/product',['middleware'=>'acl:view_invoice_details','as'=>'admin.invoice-details.get-product','uses'=>'InvoiceDetailsController@getProductBySubCategory']);
    Route::post('invoice-details/store',['middleware'=>'acl:new_invoice_details','as'=>'admin.invoice-details.store','uses'=>'InvoiceDetailsController@postStore']);
    Route::get('invoice-product-details/{id}/{type}',['middleware'=>'acl:view_invoice_details','as'=>'admin.invoice-product-details.get-product','uses'=>'InvoiceDetailsController@getProductByInvoice']);

    Route::get('product-variant/search/{bar_code}',['middleware'=>'acl:view_invoice_details','as'=>'admin.product-search','uses'=>'InvoiceDetailsController@getVariantListByQueryString']);

    Route::get('invoice_processing',['middleware'=>'acl:view_invoice_processing','as'=>'admin.invoice_processing','uses'=>'InvoiceController@invoiceProcessing']);
    Route::post('invoice_processing/list',['middleware'=>'acl:view_invoice_processing','as'=>'admin.invoice_processing.list','uses'=>'DatatableController@invoiceProcessingList']);
    Route::get('invoice/stock/{id}/delete',['middleware'=>'acl:delete_invoice_processing','as'=>'admin.stock.delete','uses'=>'InvoiceController@getStockDelete']);
    Route::post('invoice_processing/store',['middleware'=>'acl:new_invoice_processing','as'=>'admin.invoice_processing.new','uses'=>'InvoiceController@postStoreInvoiceProcessing']);
    Route::get('invoice-qbentry/{id}',['middleware'=>'acl:view_invoice','as'=>'admin.invoice-qbentry','uses'=>'InvoiceController@invoiceQBentry']);
    Route::get('invoice-loyalty-claime/{id}',['middleware'=>'acl:edit_invoice','as'=>'admin.loyalty-claime','uses'=>'InvoiceController@invoiceLoyaltyClaime']);
    Route::get('invoice-vat-claime/{id}',['middleware'=>'acl:edit_invoice','as'=>'admin.vat-claime','uses'=>'InvoiceController@invoiceVatClaime']);
    Route::post('invoice-to-stock/{id}',['middleware'=>'acl:edit_invoice','as'=>'admin.invoice-to-stock','uses'=>'InvoiceController@invoiceToStock']);

    //VAT processing
    Route::get('vat-processing',['middleware'=>'acl:view_vat_processing','as'=>'admin.vat_processing','uses'=>'VatProcessingController@getIndex']);
    Route::post('vat-processing/list',['middleware'=>'acl:view_vat_processing','as'=>'admin.vat_processing.list','uses'=>'DatatableController@getVatProcessing']);

    // Special category
    Route::get('spcategory',['middleware'=>'acl:view_special_category','as'=>'product.spcategory.list','uses'=>'SpCategoryController@getIndex']);
    Route::get('spcategory/new',['middleware'=>'acl:new_special_category','as'=>'product.spcategory.create','uses'=>'SpCategoryController@getCreate']);
    Route::post('spcategory/store',['middleware'=>'acl:new_special_category','as'=>'product.spcategory.store','uses'=>'SpCategoryController@postStore']);
    Route::get('spcategory/{id}/edit',['middleware'=>'acl:edit_special_category','as'=>'product.spcategory.edit','uses'=>'SpCategoryController@getEdit']);
    Route::post('spcategory-slug/update',['middleware'=>'acl:edit_special_category','as'=>'product.spcategory.slug.update','uses'=>'SpCategoryController@postSlugUpdate']);
    Route::post('spcategory/{id}/update',['middleware'=>'acl:edit_special_category','as'=>'product.spcategory.update','uses'=>'SpCategoryController@postUpdate']);
    Route::get('spcategory/{id}/delete',['middleware'=>'acl:delete_special_category','as'=>'product.spcategory.delete','uses'=>'SpCategoryController@getDelete']);

    //Product ===
    //Category
    Route::get('category',['middleware'=>'acl:view_category','as'=>'product.category.list','uses'=>'CategoryController@getIndex']);
    Route::get('category/new',['middleware'=>'acl:new_category','as'=>'product.category.create','uses'=>'CategoryController@getCreate']);
    Route::post('category/store',['middleware'=>'acl:new_category','as'=>'product.category.store','uses'=>'CategoryController@postStore']);
    Route::get('category/{id}/edit',['middleware'=>'acl:edit_category','as'=>'product.category.edit','uses'=>'CategoryController@getEdit']);
    Route::post('category/{id}/update',['middleware'=>'acl:edit_category','as'=>'product.category.update','uses'=>'CategoryController@postUpdate']);
    Route::get('category/{id}/delete',['middleware'=>'acl:delete_category','as'=>'product.category.delete','uses'=>'CategoryController@getDelete']);
    Route::get('get-parent-attributes/{id}',['middleware'=>'acl:new_category','as'=>'product.category.get-attribute','uses'=>'CategoryController@getParentAttributes']);
    Route::get('shop_cat_add_remove/{shop_id}/{cat_id}/{mode}',['middleware'=>'acl:edit_category','as'=>'product.shop_cat_add_remove','uses'=>'CategoryController@shopCatAddRemove']);
    Route::get('ajax/get-subcategory/{category_id}',['middleware'=>'acl:delete_category','as'=>'product.category.get-subcategory','uses'=>'CategoryController@getSubcategory']);

    // Route::get('category/deleted_list',['middleware'=>'acl:delete_category','as'=>'product.category.deleted_list','uses'=>'CategoryController@getDeletedList']);

    //Sub Category
    // Route::get('sub_category',['middleware'=>'acl:view_sub_category','as'=>'admin.sub_category.list','uses'=>'SubCategoryController@getIndex']);
    // Route::get('sub_category/new',['middleware'=>'acl:new_sub_category','as'=>'admin.sub_category.create','uses'=>'SubCategoryController@getCreate']);
    // Route::post('sub_category/store',['middleware'=>'acl:new_sub_category','as'=>'admin.sub_category.store','uses'=>'SubCategoryController@postStore']);
    // Route::get('sub_category/{id}/edit',['middleware'=>'acl:edit_sub_category','as'=>'admin.sub_category.edit','uses'=>'SubCategoryController@getEdit']);
    // Route::post('sub_category/{id}/update',['middleware'=>'acl:edit_sub_category','as'=>'admin.sub_category.update','uses'=>'SubCategoryController@postUpdate']);
    // Route::get('sub_category/{id}/delete',['middleware'=>'acl:delete_sub_category','as'=>'admin.sub_category.delete','uses'=>'SubCategoryController@getDelete']);

    // Order Management
    // Route::get('order',['middleware'=>'acl:view_order','as'=>'admin.order.list','uses'=>'OrderController@getIndex']);

    Route::get('order/cancelrequest',['middleware'=>'acl:view_order','as'=>'admin.order.cancelrequest','uses'=>'OrderController@getCancelRequest']);
    Route::post('order/{id}/cancel',['middleware'=>'acl:cancel_order','as'=>'admin.order.cancel','uses'=>'OrderController@postCancel']);
    Route::get('order-altered',['middleware'=>'acl:view_order','as'=>'admin.order_alter.list','uses'=>'OrderController@getAlteredIndex']);
    Route::get('default-order',['middleware'=>'acl:view_order','as'=>'admin.order_default.list','uses'=>'OrderController@getDefaultIndex']);
    Route::get('default-order-action',['middleware'=>'acl:view_order','as'=>'admin.order_default_action.list','uses'=>'OrderController@getDefaultActionIndex']);
    Route::get('default-order-penalty',['middleware'=>'acl:view_order','as'=>'admin.order_default_penalty.list','uses'=>'OrderController@getDefaultPenaltyIndex']);
    Route::get('revert-default-order/{id}',['middleware'=>'acl:edit_order','as'=>'admin.order_revert.default','uses'=>'OrderController@getDefaultRevert']);
    Route::get('order/canceled',['middleware'=>'acl:view_order','as'=>'admin.order.canceled','uses'=>'OrderController@getCancelOrder']);
    Route::post('order/{id}/return',['middleware'=>'acl:return_order','as'=>'admin.order.return','uses'=>'OrderController@postReturnOrder']);
    // Route::get('order/new',['middleware'=>'acl:new_order','as'=>'admin.order.new','uses'=>'OrderController@getCreate']);
    Route::post('order/store',['middleware'=>'acl:new_order','as'=>'admin.order.store','uses'=>'OrderController@postStore']);

    Route::post('booking/all_booking',['middleware'=>'acl:view_order','as'=>'admin.order.all_order','uses'=>'DatatableController@getAllBooking']);
    Route::post('order/cancel_order',['middleware'=>'acl:view_order','as'=>'admin.order.cancel_order','uses'=>'DatatableController@getCancelOrder']);
    Route::post('order/altered_order',['middleware'=>'acl:view_order','as'=>'admin.order.altered_order','uses'=>'DatatableController@getAlteredOrder']);
    Route::post('order/default_order',['middleware'=>'acl:view_order','as'=>'admin.order.default_order','uses'=>'DatatableController@getDefaultOrder']);
    Route::post('order/default_order_action',['middleware'=>'acl:view_order','as'=>'admin.order.default_order_action','uses'=>'DatatableController@getDefaultOrderAction']);
    Route::post('order/default_order_penalty',['middleware'=>'acl:view_order','as'=>'admin.order.default_order_penalty','uses'=>'DatatableController@getDefaultOrderPenalty']);

    // Route::get('order/{id}/edit',['middleware'=>'acl:edit_order','as'=>'admin.order.edit','uses'=>'OrderController@getEdit']);
    // Route::post('order/{id}/update',['middleware'=>'acl:edit_order','as'=>'admin.order.update','uses'=>'OrderController@postUpdate']);
    Route::get('order/{id}/delete',['middleware'=>'acl:delete_order','as'=>'admin.order.delete','uses'=>'OrderController@getDelete']);

    Route::post('order_admin_hold',['middleware'=>'acl:edit_booking','as'=>'admin.order_admin_hold','uses'=>'OrderController@postAdminHold']);
    Route::post('order_self_pickup',['middleware'=>'acl:edit_booking','as'=>'admin.order_self_pickup','uses'=>'OrderController@postSelfPickup']);

    Route::post('order/rtc-transfer',['middleware'=>'acl:edit_order','as'=>'admin.order.rtc_transfer','uses'=>'OrderController@postSelfPickup']);
    Route::post('order/rtc-transfer-ajax',['middleware'=>'acl:edit_order','as'=>'admin.order.rtc_transfer_ajax','uses'=>'OrderController@postSelfPickupAjax']);
    Route::post('generate-billplz-url',['middleware'=>'acl:edit_order','as'=>'admin.order.generate_billplz_url','uses'=>'OrderController@postGenerateBillplzUrl']);
    Route::get('delete-billplz-bill/{id}',['middleware'=>'acl:edit_order','as'=>'admin.billplz.bill.delete','uses'=>'OrderController@postDeleteBillplzBill']);

    //DISPATCH
    Route::get('dispatch',['middleware'=>'acl:view_dispatch','as'=>'admin.dispatch.list','uses'=>'DispatchController@getDispatchList']);
    Route::get('dispatched',['middleware'=>'acl:view_dispatched','as'=>'admin.dispatched.list','uses'=>'DispatchController@getDispatchedList']);
    Route::get('delivered',['middleware'=>'acl:view_delivered','as'=>'admin.delivered.list','uses'=>'DispatchController@getDeliveredList']);
    // Route::get('order/{id}/dispatch',['middleware'=>'acl:edit_dispatch','as'=>'admin.order.dispatch','uses'=>'DispatchController@getDispatch']);
    // Route::post('order/{id}/dispatchstore',['middleware'=>'acl:edit_dispatch','as'=>'admin.order.dispatchstore','uses'=>'DispatchController@postDispatch']);
    // Route::post('mark-pickup-list',['middleware'=>'acl:edit_dispatch','as'=>'admin.order.dispatch.mark_pickup','uses'=>'DispatchController@postMarkPickup']);
    // Route::get('collect-order/{id?}',['middleware'=>'acl:view_order_collect','as'=>'admin.order_collect.list','uses'=>'DispatchController@getOrderCollectList']);
    // Route::get('collect-order-batch',['middleware'=>'acl:view_batch_collect','as'=>'admin.batch_collect.list','uses'=>'DispatchController@getBatchCollectList']);
    // Route::get('collect-order-item/{id}',['middleware'=>'acl:view_item_collect','as'=>'admin.item_collect.list','uses'=>'DispatchController@getItemCollectList']);
    // Route::get('revert-from-batch/{id}',['middleware'=>'acl:view_item_collect','as'=>'admin.item_revert.batch','uses'=>'DispatchController@getRevertbatch']);
    // Route::post('assign-order-item',['middleware'=>'acl:assign_item_collect','as'=>'admin.order_item.assign','uses'=>'DispatchController@postAssignOrderItem']);
    // Route::post('bulk-assign-logistic-user',['middleware'=>'acl:assign_item_collect','as'=>'admin.order_bulk_item.assign','uses'=>'DispatchController@postAssignOrderBulkItem']);
    // Route::get('order-batch-list',['middleware'=>'acl:view_batch_collected','as'=>'admin.batch_collected.list','uses'=>'DispatchController@getBatchCollectedList']);
    // Route::get('order-item-list/{id}',['middleware'=>'acl:view_item_collected','as'=>'admin.item_collected.list','uses'=>'DispatchController@getItemCollectedList']);
    // Route::get('pending-dispatch-by-app',['middleware'=>'acl:view_pending_app_dispach','as'=>'admin.pending_by_app.dispatch-list','uses'=>'DispatchController@getPendingAppDispatch']);
    // Route::get('revert-back-to-previous-stage/{id}',['middleware'=>'acl:edit_dispatch','as'=>'admin.revert_dispatch.dispatch','uses'=>'DispatchController@getRevertDispatch']);
    // Route::post('ajax/special_note_status',['middleware'=>'acl:view_item_collected','as'=>'admin.special_note.status','uses'=>'DispatchController@postSpecialNoteStatus']);

    //AJAX
    Route::post('collect-order-datatable',['middleware'=>'acl:view_order_collect','as'=>'admin.order_collect.datalist','uses'=>'DatatableController@getOrderCollection']);
    Route::post('collect-item-datatable',['middleware'=>'acl:view_item_collect','as'=>'admin.item_collect.datalist','uses'=>'DatatableController@getItemCollection']);
    Route::post('collected-item-datatable',['middleware'=>'acl:view_item_collected','as'=>'admin.item_collected.datalist','uses'=>'DatatableController@getItemCollectedList']);
    // Route::post('get-customer-details',['middleware'=>'acl:new_booking','as'=>'admin.booking.getproduct','uses'=>'OrderController@getCusInfo']);
    //COLLECTION LIST
    Route::get('collection-list',['middleware'=>'acl:view_collection_list','as'=>'admin.collection.list','uses'=>'DispatchController@getCollectionList']);
    Route::get('collection-list/{id}',['middleware'=>'acl:view_collection_list_breakdown','as'=>'admin.collection.list.breakdown','uses'=>'DispatchController@getCollectionListBreakdown']);

    //COD/RTC SHELVE STOCK LIST
    // Route::get('stock-list/{id}/shelve',['middleware'=>'acl:view_cod_user_stock_list','as'=>'admin.cod_user.stock_list','uses'=>'DispatchController@getCodRtcUserStockList']);
    //HS code
    Route::get('hscode',['middleware'=>'acl:view_hscode','as'=>'admin.hscode.list','uses'=>'HscodeController@getIndex']);
    Route::get('hscode/new',['middleware'=>'acl:new_hscode','as'=>'admin.hscode.create','uses'=>'HscodeController@getCreate']);
    Route::post('hscode/store',['middleware'=>'acl:new_hscode','as'=>'admin.hscode.store','uses'=>'HscodeController@postStore']);
    Route::get('hscode/{id}/edit',['middleware'=>'acl:edit_hscode','as'=>'admin.hscode.edit','uses'=>'HscodeController@getEdit']);
    Route::post('hscode/{id}/update',['middleware'=>'acl:edit_hscode','as'=>'admin.hscode.update','uses'=>'HscodeController@postUpdate']);
    Route::get('hscode/{id}/delete',['middleware'=>'acl:delete_hscode','as'=>'admin.hscode.delete','uses'=>'HscodeController@getDelete']);
    Route::post('billplz-payout',['middleware'=>'acl:new_customer','as'=>'admin.customer_seller.billplzPayout','uses'=>'CustomerController@postBillplzPayout']);
    Route::match(array('GET','POST'), 'payout-status',['middleware'=>'acl:new_customer','uses'=>'CustomerController@getBillplzPayoutResponse']);

    //Customer
    Route::get('customer',['middleware'=>'acl:view_customer','as'=>'admin.customer.list','uses'=>'CustomerController@getIndex']);
    Route::get('ajax/customer/new',['middleware'=>'acl:new_customer','as'=>'admin.customer.create','uses'=>'CustomerController@getCreate']);
    Route::post('customer/store',['middleware'=>'acl:new_customer','as'=>'admin.customer.store','uses'=>'CustomerController@postStore']);
    Route::post('ajax/customer/store',['middleware'=>'acl:new_customer','as'=>'admin.customer.ajaxStore','uses'=>'CustomerController@postAjaxStore']);
    Route::post('customer/blance-transfer',['middleware'=>'acl:new_customer','as'=>'admin.customer.blance_transfer','uses'=>'CustomerController@postBlanceTransfer']);
    Route::post('customer/store/booking',['middleware'=>'acl:new_customer','as'=>'admin.customer.store.booking','uses'=>'CustomerController@addNewCustomer']);
    Route::get('customer/{id}/edit',['middleware'=>'acl:edit_customer','as'=>'admin.customer.edit','uses'=>'CustomerController@getEdit']);
    Route::get('ajax/customer/edit/{id}',['middleware'=>'acl:edit_customer','as'=>'admin.customer.edit.ajax','uses'=>'CustomerController@getAjaxEdit']);


    Route::get('customer/{id}/payment-history',['middleware'=>'acl:edit_customer','as'=>'admin.customer.payment_history','uses'=>'CustomerController@getPaymentHistory']);
    Route::post('customer/{id}/update',['middleware'=>'acl:edit_customer','as'=>'admin.customer.update','uses'=>'CustomerController@postUpdate']);
    Route::get('customer/delete/{id}',['middleware'=>'acl:delete_customer','as'=>'admin.customer.delete','uses'=>'CustomerController@getDelete']);
    Route::get('parent-root/{type}',[ 'middleware'=>'acl:view_customer','as'=>'admn.customer.root','uses'=>'CustomerController@getCombo']);
    Route::get('customer/{id}/view',['middleware'=>'acl:view_customer','as'=>'admin.customer.view','uses'=>'CustomerController@getView']);
    Route::get('get/{id}/remainingcustomerbalance/',['middleware'=>'acl:view_customer','as'=>'admin.remainingcustomerbalance','uses'=>'CustomerController@getRemainingBalance']);
    Route::get('customer/{id}/history',['middleware'=>'acl:view_customer','as'=>'admin.customer.history','uses'=>'CustomerController@getHistory']);
    //customer dashboard
    Route::get('customer/{id}/history2',['middleware'=>'acl:view_customer','as'=>'admin.customer.history2','uses'=>'CustomerController@getHistory2']);
    Route::get('customer/{id}/address-book',['middleware'=>'acl:view_customer','as'=>'admin.customer.address-book','uses'=>'CustomerController@getAddressBook']);
    Route::get('customer/{id}/orders',['middleware'=>'acl:view_customer','as'=>'admin.customer.orders','uses'=>'CustomerController@getOrderlistByCustomer']);
    Route::get('customer/{id}/payments',['middleware'=>'acl:view_customer','as'=>'admin.customer.payments','uses'=>'CustomerController@getCustomerPayment']);
    Route::get('customer/{id}/balance',['middleware'=>'acl:view_customer','as'=>'admin.customer.balance','uses'=>'CustomerController@getCustomerBalance']);
    Route::post('customer/user-orderList-datatable',['middleware'=>'acl:view_customer','as'=>'admin.customer.my-orders.datatable','uses'=>'DatatableController@getMyOrders']);
    Route::get('customer/orders/view/{id}',['middleware'=>'acl:view_customer','as'=>'customer.orders.view','uses'=>'CustomerController@getOrderView']);
    Route::get('customer/customer-details/{id}',['middleware'=>'acl:view_customer','as'=>'admin.customer.customer-details','uses'=>'CustomerController@getCustomerDetails']);
    Route::get('customer/{id}/refund/{type}',['middleware'=>'acl:new_refund','as'=>'admin.payment.refund','uses'=>'RefundController@getRefund']);
    Route::get('customer/refund',['middleware'=>'acl:view_refund','as'=>'admin.customer.refund','uses'=>'RefundController@getIndex']);
    Route::post('customer/refund/store',['middleware'=>'acl:new_refund','as'=>'admin.paymentrefund.store','uses'=>'RefundController@postRefund']);
    Route::post('customer/refundrequest/store',['middleware'=>'acl:new_refund','as'=>'admin.customer.refundrequeststore','uses'=>'RefundController@postRefundRequest']);
    Route::get('customer/refundrequest',['middleware'=>'acl:view_refund','as'=>'admin.customer.refundrequest','uses'=>'RefundController@getrefundRequestList']);
    Route::get('customer/refunded',['middleware'=>'acl:view_refund','as'=>'admin.customer.refunded','uses'=>'RefundController@getRefunded']);
    Route::get('customer/refundrequest/{id}/deny',['middleware'=>'acl:edit_refund','as'=>'admin.customer.refundrequest_deny','uses'=>'RefundController@getRefundedRequestDeny']);

    Route::get('seller/refund',['middleware'=>'acl:view_reseller_refund','as'=>'admin.seller.refund','uses'=>'RefundController@getIndexReseller']);
    Route::get('seller/refundrequest',['middleware'=>'acl:view_reseller_refund','as'=>'admin.seller.refundrequest','uses'=>'RefundController@getrefundRequestListReseller']);
    Route::get('seller/refunded',['middleware'=>'acl:view_reseller_refund','as'=>'admin.seller.refunded','uses'=>'RefundController@getRefundedReseller']);
    Route::get('seller/refundrequest/{id}/deny',['middleware'=>'acl:edit_reseller_refund','as'=>'admin.seller.refundrequest_deny','uses'=>'RefundController@getRefundedRequestDenyReseller']);

    Route::post('seller/refundrequest/store',['middleware'=>'acl:new_reseller_refund','as'=>'admin.seller.refundrequeststore','uses'=>'RefundController@postRefundRequestReseller']);

    Route::get('seller/{id}/refund/{type}',['middleware'=>'acl:new_reseller_refund','as'=>'admin.payment.refund.reseller','uses'=>'RefundController@getRefundReseller']);
    Route::post('seller/refund/store',['middleware'=>'acl:new_reseller_refund','as'=>'admin.paymentrefund.store.reseller','uses'=>'RefundController@postRefundReseller']);

    //Reseller Dashboard
    // Route::get('seller/{id}/history',['middleware'=>'acl:view_reseller','as'=>'admin.seller.history','uses'=>'SellerController@getHistory']);
    // Route::get('seller/reseller-details/{id}',['middleware'=>'acl:view_reseller','as'=>'admin.seller.reseller-details','uses'=>'SellerController@getResellerDetails']);
    // Route::get('seller/{id}/address-book',['middleware'=>'acl:view_reseller','as'=>'admin.seller.address-book','uses'=>'SellerController@getAddressBook']);
    // Route::get('seller/{id}/orders',['middleware'=>'acl:view_reseller','as'=>'admin.seller.orders','uses'=>'SellerController@getOrderlistByReseller']);
    // Route::get('seller/{id}/payments',['middleware'=>'acl:view_reseller','as'=>'admin.seller.payments','uses'=>'SellerController@getResellerPayment']);
    // Route::get('seller/{id}/balance',['middleware'=>'acl:view_reseller','as'=>'admin.seller.balance','uses'=>'SellerController@getResellerBalance']);
    // Route::post('seller/user-orderList-datatable',['middleware'=>'acl:view_reseller','as'=>'admin.seller.my-orders.datatable','uses'=>'DatatableController@getMyOrders']);
    // Route::get('seller/orders/view/{id}',['middleware'=>'acl:view_reseller','as'=>'reseller.orders.view','uses'=>'SellerController@getOrderView']);
    // Route::get('seller/reseller-details/{id}',['middleware'=>'acl:view_reseller','as'=>'admin.seller.reseller-details','uses'=>'SellerController@getResellerDetails']);


    //Customer Address
    Route::get('customer-address',['middleware'=>'acl:view_customer_address','as'=>'admin.customer-address.list','uses'=>'CustomerAddressController@getIndex']);
    Route::get('customer-address/{id}/new',['middleware'=>'acl:new_customer_address','as'=>'admin.customer-address.create','uses'=>'CustomerAddressController@getCreate']);
    Route::post('customer-address/store',['middleware'=>'acl:new_customer_address','as'=>'admin.customer-address.store','uses'=>'CustomerAddressController@postStore']);
    Route::get('customer-address/{id}/edit',['middleware'=>'acl:edit_customer_address','as'=>'admin.customer-address.edit','uses'=>'CustomerAddressController@getEdit']);
    Route::post('customer-address/update',['middleware'=>'acl:edit_customer_address','as'=>'admin.customer-address.update','uses'=>'CustomerAddressController@postUpdate']);
    Route::get('customer-address/{id}/delete',['middleware'=>'acl:delete_customer_address','as'=>'admin.customer-address.delete','uses'=>'CustomerAddressController@getDelete']);
    Route::get('getCustomerAddressEdit/{customer_id}/{id}/{is_reseller?}',['middleware'=>'acl:edit_customer_address','as'=>'admin.customer-address.order_edit','uses'=>'CustomerAddressController@getCustomerAddressEdit']);
    Route::get('getCustomerByName/{customer_name}/{type?}',['middleware'=>'acl:edit_customer_address','as'=>'admin.customer-address.order_getcusinfo','uses'=>'CustomerAddressController@getCustomerByName']);
    // arif
    Route::get('ajax/address/create/{customer_id}',['middleware'=>'acl:new_customer_address','as'=>'admin.address.create','uses'=>'CustomerAddressController@getAjaxCreate']);
    Route::get('ajax/address/edit/{address_id}',['middleware'=>'acl:new_customer_address','as'=>'admin.address.edit','uses'=>'CustomerAddressController@getAjaxEdit']);
    Route::get('ajax/address/delete/{id}',['middleware'=>'acl:delete_customer_address','as'=>'admin.address.delete','uses'=>'CustomerAddressController@getAjaxDelete']);

    Route::get('get-post-code',['middleware'=>'acl:new_customer_address','as'=>'admin.customer-address.creates','uses'=>'CustomerAddressController@search']);

     //AJAX ROUTE FOR CUSTOMER_ADDRESS
     Route::get('customer_state/{id}',[ 'middleware'=>'acl:new_customer_address','as'=>'admin.customer_state','uses'=>'CustomerAddressController@getState']);
     Route::get('customer_city/{id}',[ 'middleware'=>'acl:new_customer_address','as'=>'admin.customer_city','uses'=>'CustomerAddressController@getCity']);
     Route::get('customer_pCode/{city_id}/{state_id}',[ 'middleware'=>'acl:new_customer_address','as'=>'admin.customer_pCode','uses'=>'CustomerAddressController@getPostC']);
     Route::get('customer_city_by_state/{id}',[ 'middleware'=>'acl:new_customer_address','as'=>'admin.customer_city_by_state','uses'=>'CustomerAddressController@getCitybyState']);
     Route::get('customer_postage_by_city/{id}',[ 'middleware'=>'acl:new_customer_address','as'=>'admin.customer_postage_by_city','uses'=>'CustomerAddressController@getPostagebyCity']);
    //Agent
    // Route::get('agent-view',['middleware'=>'acl:agent_view','as'=>'admin.agent.list','uses'=>'AgentsController@getIndex']);
    // Route::get('agent-new',['middleware'=>'acl:agent_new','as'=>'admin.agent.create','uses'=>'AgentsController@getCreate']);
    // Route::post('agent-store',['middleware'=>'acl:agent_store','as'=>'admin.agent.store','uses'=>'AgentsController@postStore']);
    // Route::get('agent-{id}-edit',['middleware'=>'acl:agent_edit','as'=>'admin.agent.edit','uses'=>'AgentsController@getEdit']);
    // Route::post('agent-{id}-update',['middleware'=>'acl:agent_update','as'=>'admin.agent.update','uses'=>'AgentsController@postUpdate']);
    // Route::get('agent-{id}-delete',['middleware'=>'acl:agent_delete','as'=>'admin.agent.delete','uses'=>'AgentsController@getDelete']);

    //Customer Address Type
    // Route::get('address-type',['middleware'=>'acl:view_address_type','as'=>'admin.address_type.list','uses'=>'AddressController@getIndex']);
    // Route::get('address-type/new',['middleware'=>'acl:new_address_type','as'=>'admin.address_type.create','uses'=>'AddressController@getCreate']);
    // Route::post('address-type/store',['middleware'=>'acl:new_address_type','as'=>'admin.address_type.store','uses'=>'AddressController@postStore']);
    // Route::get('address-type/{id}/edit',['middleware'=>'acl:edit_address_type','as'=>'admin.address_type.edit','uses'=>'AddressController@getEdit']);
    // Route::post('address-type/{id}/update',['middleware'=>'acl:edit_address_type','as'=>'admin.address_type.update','uses'=>'AddressController@postUpdate']);
    // Route::get('address-type/{id}/delete',['middleware'=>'acl:delete_address_type','as'=>'admin.address_type.delete','uses'=>'AddressController@getDelete']);
    // Route::get('address-type-post-code/list',['middleware'=>'acl:view_postage_list','as'=>'admin.address_type.postage_list_','uses'=>'AddressController@getPostageList']);
    // Route::get('address-type-post-code/{id?}',['middleware'=>'acl:edit_postage_list','as'=>'admin.address_type.postage_view_','uses'=>'AddressController@getPostageAddress']);
    // Route::get('address-type-city/{id?}',['middleware'=>'acl:edit_city_list','as'=>'admin.address_type.city_list','uses'=>'AddressController@getCityAddress']);
    // Route::post('post-address-type-city/{id}',['middleware'=>'acl:edit_city_list','as'=>'admin.customer_address_city.put','uses'=>'AddressController@postCityAddress']);
    // Route::post('post-address-type-postage/{id}',['middleware'=>'acl:edit_postage_list','as'=>'admin.customer_address_postage.put','uses'=>'AddressController@postPostageAddress']);

    //POSTCODE CITY ADDRESS ADD UPDATE

    Route::get('address/city_list',['middleware'=>'acl:view_city_list','as'=>'admin.address.city_list','uses'=>'AddressController@getCityList']);
    Route::post('address/new_city',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.city_store','uses'=>'AddressController@postCity']);
    Route::get('ajax/get-city-edit/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.get_city','uses'=>'AddressController@getEditCity']);
    Route::post('address/edit_city',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.city_update','uses'=>'AddressController@updateCity']);
    Route::get('ajax/get-city-create',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.get-city','uses'=>'AddressController@getCityCreate']);
    Route::get('ajax/get-city-delete/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.city_delete','uses'=>'AddressController@getCityDelete']);

    Route::get('address/region_list',['middleware'=>'acl:view_region_list','as'=>'admin.address.region_list','uses'=>'AddressController@getRegionList']);
    Route::get('ajax/get-region-create',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.get-region','uses'=>'AddressController@getRegionCreate']);
    Route::get('ajax/get-region-edit/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.edit_region','uses'=>'AddressController@getRegion']);
    Route::post('address/new_region',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.region_store','uses'=>'AddressController@postRegion']);
    Route::post('address/edit_region',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.region_update','uses'=>'AddressController@updateRegion']);
    Route::get('ajax/get-region-delete/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.region_delete','uses'=>'AddressController@getRegionDelete']);
    Route::get('ajax/get-city-by-region/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.get_city_region','uses'=>'AddressController@getCityByRegion']);

    Route::get('ajax/get-area-create',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.get-area','uses'=>'AddressController@getAreaCreate']);
    Route::post('address/area_create',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.area_create','uses'=>'AddressController@postArea']);
    Route::get('ajax/get-area-edit/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.area_edit','uses'=>'AddressController@getAreaEdit']);
    Route::post('address/area_update',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.area_update','uses'=>'AddressController@updateArea']);
    Route::get('ajax/get-area-delete/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.area_delete','uses'=>'AddressController@getAreaDelete']);
    Route::get('address/sub_area',['middleware'=>'acl:view_region_list','as'=>'admin.address.sub_area','uses'=>'AreaMapController@getIndex']);
    Route::get('ajax/get-area-by-city/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.get_area','uses'=>'AddressController@getAreaByCity']);
    Route::get('address/area_list',['middleware'=>'acl:view_region_list','as'=>'admin.address.area_list','uses'=>'AddressController@getAreaList']);

    Route::post('address/new_map',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.map_store','uses'=>'AreaMapController@postStore']);
    Route::get('ajax/get-map-edit/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.map_edit','uses'=>'AreaMapController@getEdit']);
    Route::post('address/map_update',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.map_update','uses'=>'AreaMapController@postUpdate']);
    Route::get('ajax/get-map-delete/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.address.map_delete','uses'=>'AreaMapController@getDelete']);
    Route::get('address/map',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.map','uses'=>'AreaMapController@getMap']);
    Route::get('ajax/get-map-create',['middleware'=>'acl:edit_postage_list','as'=>'admin.address.map_create','uses'=>'AreaMapController@getCreate']);
    Route::get('ajax/get-subarea-by-area/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.subarea.map_create','uses'=>'AreaMapController@getAreaMapByArea']);
    Route::get('ajax/get-polygon-delete/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.polygon.polygon_delete','uses'=>'AreaMapController@getPolygonDelete']);

    // Delivery Boy
    Route::get('delivery_boy/list',['middleware'=>'acl:view_delivery_boy_list','as'=>'admin.delivery_boy.list','uses'=>'DeliveryBoyController@getIndex']);
    Route::get('ajax/delivery-boy/create',['middleware'=>'acl:view_delivery_boy_list','as'=>'admin.delivery_boy.create','uses'=>'DeliveryBoyController@getCreate']);
    Route::post('delivery_boy/store',['middleware'=>'acl:edit_postage_list','as'=>'admin.delivery_boy.store','uses'=>'DeliveryBoyController@postStore']);
    Route::get('ajax/delivery-boy/edit/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.delivery_boy.edit','uses'=>'DeliveryBoyController@getEdit']);
    Route::post('delivery_boy/{id}/update',['middleware'=>'acl:edit_postage_list','as'=>'admin.delivery_boy.update','uses'=>'DeliveryBoyController@postUpdate']);
    Route::get('ajax/delivery-boy/delete/{id}',['middleware'=>'acl:view_region_list','as'=>'admin.delivery_boy.delete','uses'=>'DeliveryBoyController@getDelete']);
    Route::get('delivery-boy/{id}/view',['middleware'=>'acl:view_product','as'=>'admin.delivery_boy.view','uses'=>'DeliveryBoyController@getView']);
    Route::get('delivery-boy/delivery-list',['middleware'=>'acl:view_product','as'=>'admin.delivery_boy.delivery_list','uses'=>'DeliveryBoyController@getDeliveryList']);
    Route::get('delivery-boy/{id}/area-list',['middleware'=>'acl:edit_delivery_boy','as'=>'admin.delivery_boy.area_list','uses'=>'DeliveryBoyController@getCoverageArea']);
    Route::post('delivery-boy/{id}/area-store',['middleware'=>'acl:edit_delivery_boy','as'=>'admin.delivery_boy.area_list.store','uses'=>'DeliveryBoyController@postCoverageArea']);
    Route::get('ajax/delivery-area/delete/{id}',['middleware'=>'acl:edit_delivery_boy','as'=>'admin.delivery-area.delete','uses'=>'DeliveryBoyController@deliveryAreaDelete']);
    //AJAX
    Route::get('customer_state_by_country/{country}',['middleware'=>'acl:edit_postage_list','as'=>'admin.address_type.city_list_ajax','uses'=>'AddressController@ajaxStateByCountry']);
    //SEARCH & BOOK
    Route::get('get-delivery-cost',['middleware'=>'acl:new_search_booking','as'=>'admin.booking.delivery_cost','uses'=>'BookingController@getDeliveryCost']);
    Route::get('search-&-book',['middleware'=>'acl:new_booking','as'=>'admin.booking.create','uses'=>'BookingController@searchBook']);
    Route::get('booking/{id}/edit',['middleware'=>'acl:edit_booking','as'=>'admin.booking.edit','uses'=>'BookingController@getEdit']);
    Route::get('booking/{id}/view',['middleware'=>'acl:view_booking','as'=>'admin.booking.view','uses'=>'BookingController@getView']);
    Route::post('booking/{id}/update',['middleware'=>'acl:edit_booking','as'=>'admin.booking.update','uses'=>'BookingController@postUpdate']);
    Route::post('booking/store',['middleware'=>'acl:new_booking','as'=>'admin.booking.store','uses'=>'BookingController@postStore']);
    Route::get('booking',['middleware'=>'acl:view_booking','as'=>'admin.booking.list','uses'=>'BookingController@getIndex']);
    Route::get('get-prd-details',['middleware'=>'acl:view_booking','as'=>'admin.booking.getproduct.details','uses'=>'BookingController@getProductINV']);
    Route::post('deliveryaddress/{id}/update',['middleware'=>'acl:view_booking','as'=>'admin.deliveryaddress.update','uses'=>'BookingController@deliveryAddressUpdate']);
    //Booking
    // Route::get('booking/new/{id?}/{type?}',['middleware'=>'acl:new_booking','as'=>'admin.booking.create','uses'=>'BookingController@getCreate']);
    // Route::post('booking/store',['middleware'=>'acl:new_booking','as'=>'admin.booking.store','uses'=>'BookingController@postStore']);
    // Route::get('booking/{id}/edit',['middleware'=>'acl:edit_booking','as'=>'admin.booking.edit','uses'=>'BookingController@getEdit']);
    // Route::get('booking/{id}/view',['middleware'=>'acl:view_booking','as'=>'admin.booking.view','uses'=>'BookingController@getView']);
    // Route::get('booking/{id}/delete',['middleware'=>'acl:delete_booking','as'=>'admin.booking.delete','uses'=>'BookingController@getDelete']);
    // Route::post('booking/offer-apply',['middleware'=>'acl:edit_booking','as'=>'admin.booking.offer-apply','uses'=>'BookingController@postOfferApply']);
    // Route::post('check-offer',['middleware'=>'acl:new_booking','as'=>'admin.checkoffer','uses'=>'BookingController@postCheckOffer']);

    Route::get('{branch_id}/get-variant-info',['middleware'=>'acl:view_booking','as'=>'admin.booking.product','uses'=>'BookingController@search']);
    Route::get('get-customer-info',['middleware'=>'acl:view_booking','as'=>'admin.customer.info','uses'=>'CustomerController@getCustomer']);
    Route::get('get-customer-details',['middleware'=>'acl:view_booking','as'=>'admin.booking.getcustomer.details','uses'=>'BookingController@getCusInfo']);
    Route::get('call-procedure-booking',['as'=>'admin.booking.procedure','uses'=>'BookingController@callProcedure']);
    //Booking to order
    Route::get('booking/{id}/check-offer',['middleware'=>'acl:edit_booking','as'=>'admin.booking.checkoffer','uses'=>'BookingController@checkOffer']);
    Route::get('booking-to-order/{id}',['middleware'=>'acl:edit_booking','as'=>'admin.booking_to_order.create','uses'=>'BookingToOrderController@getBooking']);
    // Route::get('orderbooking/{id}/book-order/view',['middleware'=>'acl:view_order','as'=>'admin.order.view','uses'=>'BookingToOrderController@getBookOrderView']);
    // Route::get('orderbooking/{id}/book-order',['middleware'=>'acl:edit_order','as'=>'admin.booking_to_order.book-order','uses'=>'BookingToOrderController@getBookOrder']);

    Route::post('order/senderaddress/{id}/update',['middleware'=>'acl:edit_order','as'=>'admin.senderaddress.update','uses'=>'OrderController@updateSenderaddress']);
    Route::post('order/receiveraddress/{id}/update',['middleware'=>'acl:edit_order','as'=>'admin.receiveraddress.update','uses'=>'OrderController@updateReceiverAddress']);
    Route::get('order/{id}/admin-approval',['middleware'=>'acl:edit_order','as'=>'admin.booking_to_order.admin-approval','uses'=>'BookingToOrderController@getBookOrderAdminApproval']);
    Route::post('booking-to-order/{id}/admin-approved',['middleware'=>'acl:edit_order','as'=>'admin.bookingtoorder.admin-approved','uses'=>'BookingToOrderController@updateBooktoOrderAdminApproved']);

    //AJAX
    Route::get('delete_book_to_order_item/{id}/{type?}/{booking_no?}',['middleware'=>'acl:edit_order','as'=>'admin.booking_to_order_delete_ajax.book-order','uses'=>'BookingToOrderController@ajaxDelete']);
    Route::post('update_order_payment',['middleware'=>'acl:edit_booking','as'=>'admin.booking_to_order_payment_ajax.book-order','uses'=>'BookingToOrderController@ajaxPayment']);
    Route::get('booking/getCustomerAddress/{id}/{pk_no}/{address_id?}/{reseller_id?}',['middleware'=>'acl:view_order','as'=>'admin.bookingtoorder.getCustomerAddress','uses'=>'BookingToOrderController@getCustomerAddress']);
    Route::post('postCustomerAddress',['middleware'=>'acl:edit_order','as'=>'admin.booking_to_order_ajax.postCustomerAddress','uses'=>'BookingToOrderController@postCustomerAddress']);
    Route::post('postCustomerAddress2',['middleware'=>'acl:edit_order','as'=>'admin.customerAddress.add','uses'=>'BookingToOrderController@postCustomerAddress2']);
    Route::get('checkifCustomerAddressexists/{customer_id}/{type}/{book_id?}',['middleware'=>'acl:view_order','as'=>'admin.bookingtoorder.checkifCustomerAddressexists','uses'=>'BookingToOrderController@checkifCustomerAddressexists']);
    Route::get('bookorder/getPayInfo/{order_id}/{is_reseller}',['middleware'=>'acl:view_order','as'=>'admin.bookingtoorder.getPayInfo','uses'=>'BookingToOrderController@getPayInfo']);
    Route::post('postUpdatedAddress/{order_id}/{type}',['middleware'=>'acl:edit_order','as'=>'admin.booking_to_order_ajax.postUpdatedAddress','uses'=>'BookingToOrderController@postUpdatedAddress']);
    Route::post('postPaymentUncheck',['middleware'=>'acl:edit_order','as'=>'admin.booking_to_order_ajax.postPaymentUncheck','uses'=>'BookingToOrderController@postPaymentUncheck']);
    Route::get('getStockExchangeInfo/{id}',['middleware'=>'acl:edit_order','as'=>'admin.booking_to_order_stock_exchange_ajax','uses'=>'BookingToOrderController@ajaxExchangeStock']);
    Route::post('getStockExchangeInfo-exchange',['middleware'=>'acl:edit_order','as'=>'admin.post_booking_to_order_stock_exchange_ajax','uses'=>'BookingToOrderController@ajaxExchangeStockAction']);
    Route::post('default-order-penalty/{id}',['middleware'=>'acl:edit_order','as'=>'admin.default.order.penalty','uses'=>'BookingToOrderController@postDefaultOrderPenalty']);
    //Payment

    Route::get('payment',['middleware'=>'acl:view_payment','as'=>'admin.payment.list','uses'=>'PaymentController@getIndex']);
    // Route::get('payment/verify/{id}/{type}',['middleware'=>'acl:edit_payment','as'=>'admin.payment.verify','uses'=>'PaymentController@getVrify']);
    Route::get('payment/new/{id?}/{type?}',['middleware'=>'acl:view_payment','as'=>'admin.payment.create','uses'=>'PaymentController@getCreate']);
    Route::get('payment/{id}/details',['middleware'=>'acl:view_payment','as'=>'admin.payment.details','uses'=>'PaymentController@getDetails']);
    Route::post('payment/store',['middleware'=>'acl:new_payment','as'=>'admin.payment.store','uses'=>'PaymentController@postStore']);
    //Route::get('payment/{id}/edit',['middleware'=>'acl:edit_payment','as'=>'admin.payment.edit','uses'=>'PaymentController@getEdit']);
    //Route::post('payment/{id}/update',['middleware'=>'acl:edit_payment','as'=>'admin.payment.update','uses'=>'PaymentController@postUpdate']);
    Route::get('payment/{id}/delete',['middleware'=>'acl:delete_payment','as'=>'admin.payment.delete','uses'=>'PaymentController@getDelete']);
    Route::get('orderpayment/{id}/delete',['middleware'=>'acl:delete_orderpayment','as'=>'admin.orderpayment.delete','uses'=>'PaymentController@getOrderPaymentDelete']);
    Route::post('payment/update-partial',['middleware'=>'acl:edit_payment','as'=>'admin.payment.updatepartial','uses'=>'PaymentController@postUpdatePartial']);
    Route::get('payment-processing',['middleware'=>'acl:view_payment_processing','as'=>'admin.payment_processing.list','uses'=>'PaymentController@getPaymentProcessing']);
    Route::get('bank-to-other/{id?}',['middleware'=>'acl:new_bank_to_other','as'=>'admin.account_to_other.view','uses'=>'PaymentController@getBankToOther']);
    Route::get('bank-to-other-list',['middleware'=>'acl:view_bank_to_other','as'=>'admin.account_to_other_list.view','uses'=>'PaymentController@getBankToOtherList']);
    Route::get('party-transfer-details/{id}',['middleware'=>'acl:view_bank_to_other','as'=>'admin.account_to_other.details','uses'=>'PaymentController@getBankToOtherDetails']);
    Route::post('add-new-type',['middleware'=>'acl:new_bank_to_other','as'=>'admin.account_to_other.type.store','uses'=>'PaymentController@postNewPaymentType']);
    Route::post('bank-to-other-store',['middleware'=>'acl:new_bank_to_other','as'=>'admin.account_to_other.store','uses'=>'PaymentController@postbankToOther']);
    Route::get('bank-to-bank/{id?}',['middleware'=>'acl:new_bank_to_bank','as'=>'admin.account_to_bank.view','uses'=>'PaymentController@getBankToBank']);
    Route::get('bank-to-bank-list',['middleware'=>'acl:view_bank_to_bank','as'=>'admin.account_to_bank_list.view','uses'=>'PaymentController@getBankToBankList']);
    Route::get('internal-transfer-details/{id}',['middleware'=>'acl:view_bank_to_bank','as'=>'admin.account_to_bank.details','uses'=>'PaymentController@getBankToBankDetails']);
    Route::post('bank-to-bank-store',['middleware'=>'acl:new_bank_to_bank','as'=>'admin.account_to_bank.store','uses'=>'PaymentController@postbankToBank']);

    //DATATABLE
    Route::post('bank-to-other-list-ajax',['middleware'=>'acl:view_bank_to_other','as'=>'admin.account_to_other_ajax.list','uses'=>'DatatableController@ajaxbankToOther']);
    Route::post('bank-to-bank-list-ajax',['middleware'=>'acl:view_bank_to_bank','as'=>'admin.account_to_bank_ajax.list','uses'=>'DatatableController@ajaxbankToBank']);

    //AJAX
    Route::post('postAccountBalanceInfo',['middleware'=>'acl:new_bank_to_bank','as'=>'admin.account.bank.balance','uses'=>'PaymentController@postAccountBalanceInfo']);
    //////////////////// BANK STATEMENT  //////////////////
    Route::get('bank-state',['middleware'=>'acl:view_bank_state','as'=>'admin.bankstate.list','uses'=>'BankStateController@getIndex']);
    Route::get('get-bank-state',['middleware'=>'acl:view_bank_state','as'=>'admin.getbankstate.list','uses'=>'BankStateController@getMatchingList']);
    Route::post('bank-state/store',['middleware'=>'acl:new_bank_state','as'=>'admin.bankstate.store','uses'=>'BankStateController@postStore']);
    Route::get('bank-state/{id}/delete',['middleware'=>'acl:delete_bank_state','as'=>'admin.bankstate.delete','uses'=>'BankStateController@getDelete']);
    Route::post('bank-state/delete_bulk',['middleware'=>'acl:delete_bank_state','as'=>'admin.bankstate.delete_bulk','uses'=>'BankStateController@postDeleteBulk']);
    Route::post('bank-state/draft-to-save',['middleware'=>'acl:edit_bank_state','as'=>'admin.bankstate.draft_to_save','uses'=>'BankStateController@postDraftToSave']);
    Route::post('bank-state/mark-as-used',['middleware'=>'acl:edit_bank_state','as'=>'admin.bankstate.mark_as_used','uses'=>'BankStateController@postMarkAsUsed']);
    Route::get('bank-state/verification',['middleware'=>'acl:payment_verification','as'=>'admin.bankstate.verification','uses'=>'BankStateController@getVerification']);
    Route::post('bank-state/verify',['middleware'=>'acl:edit_bank_state','as'=>'admin.bankstate.verify','uses'=>'BankStateController@postVerify']);
    Route::get('bank-state/{id}/unverify',['middleware'=>'acl:edit_bank_state','as'=>'admin.bankstate.unverify','uses'=>'BankStateController@getUnVerify']);

    //Shipment
    Route::get('shipment/new/{id?}',['middleware'=>'acl:new_shipment','as'=>'admin.shipment.create','uses'=>'ShipmentController@getCreate']);
    Route::post('shipment/store',['middleware'=>'acl:new_shipment','as'=>'admin.shipment.store','uses'=>'ShipmentController@postStore']);
    Route::post('shipment/carrier/update',['middleware'=>'acl:new_shipment','as'=>'admin.shipment.carrier','uses'=>'ShipmentController@postCarrier']);
    Route::get('shipment/list',['middleware'=>'acl:view_shipment','as'=>'admin.shipment.list','uses'=>'ShipmentController@getIndex']);
    Route::get('shipment/processing',['middleware'=>'acl:view_shipment_processing','as'=>'admin.shipment.processing','uses'=>'ShipmentController@getProcessingIndex']);
    Route::get('shipment/{id}/new',['middleware'=>'acl:new_shipment_box','as'=>'admin.shipment.new','uses'=>'ShipmentController@getShipmentAdd']);
    Route::get('shipment/view/{id}',['middleware'=>'acl:view_shipment','as'=>'admin.shipment.view','uses'=>'ShipmentController@getShipment']);
    Route::post('get-box-details',['middleware'=>'acl:new_shipment_box','as'=>'admin.shipment.box.details','uses'=>'ShipmentController@addShipmentBox']);
    Route::post('delete-shipment-box',['middleware'=>'acl:delete_shipment_box','as'=>'admin.shipment.box.delete','uses'=>'ShipmentController@deleteShipmentBox']);
    Route::post('update-shipment-status',['middleware'=>'acl:edit_shipment_processing','as'=>'admin.shipment.update','uses'=>'ShipmentController@updateShipmentStatus']);
    Route::post('update-shipmentinfo-status/{id}',['middleware'=>'acl:edit_shipment','as'=>'admin.shipping_info.update','uses'=>'ShipmentController@updateShipmentInfo']);
    Route::get('shipment-packaging/{id}/{type}',['middleware'=>'acl:add_packaging','as'=>'admin.shipment.packaging','uses'=>'ShipmentController@postShipmentPackaging']);
    Route::get('shipment/{id}/invoice',['middleware'=>'acl:add_packaging','as'=>'admin.shipment.invoice','uses'=>'ShipmentController@getShipmentInvoice']);

    //admin.packaging.view
     Route::get('packaging/{id}/edit',['middleware'=>'acl:edit_packaging','as'=>'admin.packaging.edit','uses'=>'PackagingController@getEdit']);
     Route::get('packaging/{id}/end',['middleware'=>'acl:edit_packaging','as'=>'admin.packaging.end','uses'=>'PackagingController@getEndPackaging']);
     Route::post('packingitem/delete',['middleware'=>'acl:edit_packaging','as'=>'admin.packingitem.delete','uses'=>'PackagingController@postDeleteItem']);
     Route::get('get-packaginglist-info/{key}/{type}',['middleware'=>'acl:edit_packaging','as'=>'get-packaginglist-info','uses'=>'PackagingController@gePackagingListInfo']);
     Route::get('product/get-variant-info-like',[ 'middleware'=>'acl:edit_packaging','as'=>'admin.get-variant-info-like','uses'=>'PackagingController@getVariantInfoLike']);
     Route::post('packagingitem-update',[ 'middleware'=>'acl:edit_packaging','as'=>'admin.packagingitemupdate','uses'=>'PackagingController@postPackingItemUpdate']);
     Route::post('packagingitem/store',[ 'middleware'=>'acl:edit_packaging','as'=>'admin.packagingitem.store','uses'=>'PackagingController@postPackingItemStore']);
     Route::post('packagingbox/store',[ 'middleware'=>'acl:edit_packaging','as'=>'admin.packagingbox.store','uses'=>'PackagingController@postPackagingboxStore']);
     Route::get('packaginglist/{shipment_no}/pdf',[ 'middleware'=>'acl:edit_packaging','as'=>'admin.packaginglist.pdf','uses'=>'PackagingController@getPackaginglistPDF']);
     Route::get('packaginglist/{shipment_no}/commarcialpdf',[ 'middleware'=>'acl:edit_packaging','as'=>'admin.packaginglist.commarcialpdf','uses'=>'PackagingController@getPackaginglistCommarcialpdf']);
     Route::get('packaginglist/{shipment_no}/pdfwithinvoice',[ 'middleware'=>'acl:edit_packaging','as'=>'admin.packaginglist.pdfwithinvoice','uses'=>'PackagingController@getPackaginglistPdfWithInvoice']);

    //FAULTY
    Route::get('lost-product/{type?}/{id?}/{dispatched?}',['middleware'=>'acl:view_faulty','as'=>'admin.faulty.list','uses'=>'FaultyController@getIndex']);
    //AJAX
    Route::get('faulty-checker/{type}/{id}/{faulty_type}',['middleware'=>'acl:view_faulty','as'=>'admin.faulty.put','uses'=>'FaultyController@ajaxFaultyChecker']);
    //BOXING
    Route::get('box-type',['middleware'=>'acl:view_box_type','as'=>'admin.box_type.list','uses'=>'BoxController@getBoxTypeList']);
    Route::get('box-type-add/{id?}',['middleware'=>'acl:add_box_type','as'=>'admin.box_type.add','uses'=>'BoxController@getBoxTypeAdd']);
    Route::get('box-type-delete/{id}',['middleware'=>'acl:delete_box_type','as'=>'admin.box_type.delete','uses'=>'BoxController@getBoxTypeDelete']);
    Route::post('box-type-store',['middleware'=>'acl:add_box_type','as'=>'admin.box_type.store','uses'=>'BoxController@postBoxTypeStore']);
    Route::get('box',['middleware'=>'acl:view_box','as'=>'admin.box.list','uses'=>'BoxController@getIndex']);
    Route::get('not-boxed/list',['middleware'=>'acl:view_not_boxed','as'=>'admin.not_box.list','uses'=>'BoxController@getNotBoxed']);
    Route::get('box/view/{id}',['middleware'=>'acl:view_box','as'=>'admin.box.view','uses'=>'BoxController@getBox']);
    Route::get('not-box/view/{id}',['middleware'=>'acl:view_not_boxed','as'=>'admin.not_boxed.view','uses'=>'BoxController@getNotBox']);
    Route::post('update-box-label',['middleware'=>'acl:edit_box_label','as'=>'admin.box_label.update','uses'=>'BoxController@putBoxLabelUpdate']);

    // SHELVING
    Route::get('stock-list',['middleware'=>'acl:view_stock','as'=>'admin.all_product.list','uses'=>'StockController@getAllStockList']);
    Route::post('stock-details/{type}',['middleware'=>'acl:view_warehouse_stock','as'=>'product.details.modal','uses'=>'StockController@getStockDetail']);
    Route::get('shelve',['middleware'=>'acl:view_warehouse_shelved','as'=>'admin.shelve.list','uses'=>'ShelveController@getShelveList']);
    Route::get('unshelved-products/{id}/view',['middleware'=>'acl:view_warehouse_unshelved','as'=>'admin.unshelved.view','uses'=>'ShelveController@getUnshelvedItem']);
    Route::get('unshelved-products',['middleware'=>'acl:view_warehouse_unshelved','as'=>'admin.unshelved.list','uses'=>'ShelveController@getUnshelved']);
    Route::get('shelved-products/{id}/view',['middleware'=>'acl:view_warehouse_shelved','as'=>'admin.shelved.view','uses'=>'ShelveController@getShelvedItem']);
    Route::get('stock-price/{id}/view',['middleware'=>'acl:view_warehouse_stock','as'=>'admin.stock_price.view','uses'=>'ShelveController@getStockPriceInfo']);
    Route::post('product-details-modal-invoice',['middleware'=>'acl:view_warehouse_stock','as'=>'product.details_invoice.modal','uses'=>'ShelveController@getInvoiceProductModal']);
    // Route::post('get-warehouse-dropdown',['middleware'=>'acl:view_warehouse_section','as'=>'warehouse.dropdown','uses'=>'ShelveController@getWarehouseDropdown']);
    Route::get('add-shelve/{id?}',['middleware'=>'acl:add_shelve','as'=>'admin.shelve.add','uses'=>'ShelveController@getShelveStore']);
    Route::post('post-shelve',['middleware'=>'acl:add_shelve','as'=>'admin.shelve.post','uses'=>'ShelveController@postStore']);

    //////////////////// CURRENCY //////////////////
    Route::get('currency',['middleware'=>'acl:view_currency','as'=>'admin.currency.list','uses'=>'CurrencyController@getIndex']);
    Route::post('update/{id?}',['middleware'=>'acl:edit_currency','as'=>'admin.currency.update','uses'=>'CurrencyController@putUpdate']);
    Route::post('store',['middleware'=>'acl:edit_currency','as'=>'admin.currency.store','uses'=>'CurrencyController@postStore']);
    Route::get('delete/{id}',['middleware'=>'acl:delete_currency','as'=>'admin.currency.delete','uses'=>'CurrencyController@getDelete']);

    /////////////////////////////// DATATABLE ROUTES
    Route::post('customer/all_customer','DatatableController@all_customer');
    Route::post('customer/refundlist','DatatableController@customerRefundlist');
    Route::post('seller/refundlist','DatatableController@resellerRefundlist');
    Route::post('customer/refundedList','DatatableController@customerRefunded');
    Route::post('seller/refundedList','DatatableController@resellerRefunded');
    Route::post('customer/refundrequestlist','DatatableController@customerRefundedRequestList');
    Route::post('seller/refundrequestlist','DatatableController@resellerRefundedRequestList');

    Route::post('all_product_list','DatatableController@all_product_list');
    Route::post('unshelved_product_list','DatatableController@unshelved_product_list');
    Route::post('shelved_product_list','DatatableController@shelved_product_list');
    Route::post('boxed_product_list','DatatableController@boxed_product_list');
    Route::post('not_boxed_product_list','DatatableController@notBoxed_product_list');
    Route::post('sales_comission_report','DatatableController@sales_comission_report');
    Route::post('sales_comission_report_list','DatatableController@sales_comission_report_list');

    //////////////////// OFFER TYPE //////////////////
    Route::get('offer-type',['middleware'=>'acl:view_offer_type','as'=>'admin.offer_type.list','uses'=>'OfferTypeController@getIndex']);
    Route::get('offer-type/new',['middleware'=>'acl:new_offer_type','as'=>'admin.offer_type.create','uses'=>'OfferTypeController@getCreate']);
    Route::post('offer-type/store',['middleware'=>'acl:new_offer_type','as'=>'admin.offer_type.store','uses'=>'OfferTypeController@postStore']);
    Route::get('offer-type/{id?}/edit',['middleware'=>'acl:edit_offer_type','as'=>'admin.offer_type.edit','uses'=>'OfferTypeController@getEdit']);
    Route::post('offer-type/{id?}/update',['middleware'=>'acl:edit_offer_type','as'=>'admin.offer_type.update','uses'=>'OfferTypeController@putUpdate']);
    Route::get('offer-type/{id}/delete',['middleware'=>'acl:delete_offer_type','as'=>'admin.offer_type.delete','uses'=>'OfferTypeController@getDelete']);

    ///////////////////////OFFER GROUP/////////////////////
    Route::get('offer-group',['middleware'=>'acl:view_offergroup','as'=>'admin.offergroup.list','uses'=>'OfferGroupController@getIndex']);
    Route::get('offer-group/create',['middleware'=>'acl:new_offergroup','as'=>'admin.offergroup.create','uses'=>'OfferGroupController@getCreate']);
    Route::post('offer-group/store',['middleware'=>'acl:new_offergroup','as'=>'admin.offergroup.store','uses'=>'OfferGroupController@postStore']);
    Route::get('offer-group/{id}/edit',['middleware'=>'acl:edit_offergroup','as'=>'admin.offergroup.edit','uses'=>'OfferGroupController@getEdit']);
    Route::post('offer-group/{id}/update',['middleware'=>'acl:edit_offergroup','as'=>'admin.offergroup.update','uses'=>'OfferGroupController@postUpdate']);
    Route::get('offer-group/{id}/delete',['middleware'=>'acl:delete_offergroup','as'=>'admin.offergroup.delete','uses'=>'OfferGroupController@getDelete']);


    //////////////////// OFFER LIST //////////////////
    Route::get('offer-list',['middleware'=>'acl:view_offer_list','as'=>'admin.offer.list','uses'=>'OfferController@getIndex']);
    Route::get('offer-list/new',['middleware'=>'acl:new_offer_list','as'=>'admin.offer.create','uses'=>'OfferController@getCreate']);
    Route::post('offer-list/store',['middleware'=>'acl:new_offer_list','as'=>'admin.offer.store','uses'=>'OfferController@postStore']);
    Route::get('offer-list/{id?}/edit',['middleware'=>'acl:edit_offer_list','as'=>'admin.offer.edit','uses'=>'OfferController@getEdit']);
    Route::post('offer-list/{id?}/update',['middleware'=>'acl:edit_offer_list','as'=>'admin.offer.update','uses'=>'OfferController@putUpdate']);
    Route::get('offer-list/{id}/delete',['middleware'=>'acl:delete_offer_list','as'=>'admin.offer.delete','uses'=>'OfferController@getDelete']);

     //////////////////// OFFER PRIMARY LIST //////////////////
    Route::get('offer-primary-list',['middleware'=>'acl:view_offer_primary','as'=>'admin.offer_primary.list','uses'=>'OfferPrimaryController@getIndex']);
    Route::get('offer-primary-list/new',['middleware'=>'acl:new_offer_primary','as'=>'admin.offer_primary.create','uses'=>'OfferPrimaryController@getCreate']);
    Route::post('offer-primary-list/store',['middleware'=>'acl:new_offer_primary','as'=>'admin.offer_primary.store','uses'=>'OfferPrimaryController@postStore']);
    Route::get('offer-primary-list/{id?}/edit',['middleware'=>'acl:edit_offer_primary','as'=>'admin.offer_primary.edit','uses'=>'OfferPrimaryController@getEdit']);
    Route::get('offer-primary-list/{id?}/view',['middleware'=>'acl:view_offer_primary','as'=>'admin.offer_primary.view','uses'=>'OfferPrimaryController@getView']);
    Route::post('offer-primary-list/{id?}/update',['middleware'=>'acl:edit_offer_primary','as'=>'admin.offer_primary.update','uses'=>'OfferPrimaryController@putUpdate']);
    Route::get('offer-primary-list/{id}/delete',['middleware'=>'acl:delete_offer_primary','as'=>'admin.offer_primary.delete','uses'=>'OfferPrimaryController@getDelete']);
    Route::get('offer-primary-list/{id}/add-product',['middleware'=>'acl:new_offer_primary','as'=>'admin.offer_primary.add_product','uses'=>'OfferPrimaryController@getAddProduct']);
    Route::post('offer-primary-list/store_product',['middleware'=>'acl:new_offer_primary','as'=>'admin.offer_primary.store_product','uses'=>'OfferPrimaryController@postStoreProduct']);
    Route::post('offer-primary-list/add-productlist',['middleware'=>'acl:new_offer_primary','as'=>'admin.offer_primary.productlist','uses'=>'OfferPrimaryController@getVariantList']);
    Route::get('offer-primary-list/{id}/delete-product',['middleware'=>'acl:edit_offer_primary','as'=>'admin.offer_primary.deleteproduct','uses'=>'OfferPrimaryController@getDeleteProduct']);


      //////////////////// OFFER SECONDARY LIST //////////////////
    Route::get('offer-secondary-list',['middleware'=>'acl:view_offer_secondary','as'=>'admin.offer_secondary.list','uses'=>'OfferSecondaryController@getIndex']);
    Route::get('offer-secondary-list/new',['middleware'=>'acl:new_offer_secondary','as'=>'admin.offer_secondary.create','uses'=>'OfferSecondaryController@getCreate']);
    Route::post('offer-secondary-list/store',['middleware'=>'acl:new_offer_secondary','as'=>'admin.offer_secondary.store','uses'=>'OfferSecondaryController@postStore']);
    Route::get('offer-secondary-list/{id?}/edit',['middleware'=>'acl:edit_offer_secondary','as'=>'admin.offer_secondary.edit','uses'=>'OfferSecondaryController@getEdit']);
    Route::get('offer-secondary-list/{id?}/view',['middleware'=>'acl:view_offer_secondary','as'=>'admin.offer_secondary.view','uses'=>'OfferSecondaryController@getView']);
    Route::post('offer-secondary-list/{id?}/update',['middleware'=>'acl:edit_offer_secondary','as'=>'admin.offer_secondary.update','uses'=>'OfferSecondaryController@putUpdate']);
    Route::get('offer-secondary-list/{id}/delete',['middleware'=>'acl:delete_offer_secondary','as'=>'admin.offer_secondary.delete','uses'=>'OfferSecondaryController@getDelete']);
    Route::get('offer-secondary-list/{id}/add-product',['middleware'=>'acl:new_offer_secondary','as'=>'admin.offer_secondary.add_product','uses'=>'OfferSecondaryController@getAddProduct']);
    Route::post('offer-secondary-list/store_product',['middleware'=>'acl:new_offer_secondary','as'=>'admin.offer_secondary.store_product','uses'=>'OfferSecondaryController@postStoreProduct']);
    Route::post('offer-secondary-list/add-productlist',['middleware'=>'acl:new_offer_secondary','as'=>'admin.offer_secondary.productlist','uses'=>'OfferSecondaryController@getVariantList']);
    Route::get('offer-secondary-list/{id}/delete-product',['middleware'=>'acl:edit_offer_secondary','as'=>'admin.offer_secondary.deleteproduct','uses'=>'OfferSecondaryController@getDeleteProduct']);
         //////////////////// Coupon ////////////////////
    Route::get('coupon-list',['middleware' => 'acl:view_coupon_list', 'as' => 'admin.coupon.list', 'uses' => 'CouponController@getIndex']);
    Route::get('coupon/new',['middleware' => 'acl:new_coupon', 'as' => 'admin.coupon.create', 'uses' => 'CouponController@getCreate']);
    Route::post('coupon/store',['middleware' => 'acl:new_coupon', 'as' => 'admin.coupon.store', 'uses' => 'CouponController@postStore']);
    Route::post('coupon/search-product',['middleware' => 'acl:new_coupon', 'as' => 'admin.coupon.search', 'uses' => 'CouponController@postCouponSearch']);
    Route::post('coupon/get-master-variants',['middleware' => 'acl:new_coupon', 'as' => 'admin.coupon.master_variant', 'uses' => 'CouponController@postCouponMasterVariant']);
    Route::get('coupon/{id?}/edit',['middleware' => 'acl:edit_coupon', 'as' => 'admin.coupon.edit', 'uses' => 'CouponController@getEdit']);
    Route::post('coupon/{id}/update',['middleware' => 'acl:edit_coupon', 'as' => 'admin.coupon.update', 'uses' => 'CouponController@postUpdate']);
    Route::get('coupon/{id}/delete',['middleware' => 'acl:delete_coupon', 'as' => 'admin.coupon.delete', 'uses' => 'CouponController@getDelete']);
    Route::get('coupon/{id}/view',['middleware' => 'acl:view_coupon_list', 'as' => 'admin.coupon.view', 'uses' => 'CouponController@getView']);
    Route::post('apply-coupon', ['as' => 'admin.apply-coupon', 'uses' => 'BookingController@postApplyCoupon']);

    //////////////////// Shipping Address ////////////////////

    Route::get('shipping-address',['middleware'=>'acl:view_shipping_address','as'=>'admin.shipping-address.list','uses'=>'ShippingAddressController@getIndex']);
    Route::get('shipping-address/new',['middleware'=>'acl:new_shipping_address','as'=>'admin.shipping-address.create','uses'=>'ShippingAddressController@getCreate']);
    Route::post('shipping-address/store',['middleware'=>'acl:new_shipping_address','as'=>'admin.shipping-address.store','uses'=>'ShippingAddressController@postStore']);
    Route::get('shipping-address/{id?}/edit',['middleware'=>'acl:edit_shipping_address','as'=>'admin.shipping-address.edit','uses'=>'ShippingAddressController@getEdit']);
    Route::post('shipping-address/{id}/update',['middleware'=>'acl:edit_shipping_address','as'=>'admin.shipping-address.update','uses'=>'ShippingAddressController@postUpdate']);
    Route::get('shipping-address/{id}/delete',['middleware'=>'acl:delete_shipping_address','as'=>'admin.shipping-address.delete','uses'=>'ShippingAddressController@getDelete']);

    /////////////// Shipment Signature //////////////////
    Route::get('shipment-signature',['middleware'=>'acl:view_shipment_signature','as'=>'admin.shipment-signature.list','uses'=>'ShipmentSignController@getIndex']);
    Route::get('shipment-signature/new',['middleware'=>'acl:new_shipment_signature','as'=>'admin.shipment-signature.create','uses'=>'ShipmentSignController@getCreate']);
    Route::post('shipment-signature/store',['middleware'=>'acl:new_shipment_signature','as'=>'admin.shipment-signature.store','uses'=>'ShipmentSignController@postStore']);
    Route::get('shipment-signature/{id?}/edit',['middleware'=>'acl:edit_shipment_signature','as'=>'admin.shipment-signature.edit','uses'=>'ShipmentSignController@getEdit']);
    Route::post('shipment-signature/{id}/update',['middleware'=>'acl:edit_shipment_signature','as'=>'admin.shipment-signature.update','uses'=>'ShipmentSignController@postUpdate']);
    Route::get('shipment-signature/{id}/delete',['middleware'=>'acl:delete_shipment_signature','as'=>'admin.shipment-signature.delete','uses'=>'ShipmentSignController@getDelete']);
    //Ajax route for signature
    Route::get('signature_img_delete/{id}',['middleware'=>'acl:delete_shipment_signature','as'=>'admin.signature.img_delete','uses'=>'ShipmentSignController@getDeleteImage']);

    //////////////////// SMS notification ////////////////////
    Route::get('notification/email',['middleware'=>'acl:view_notify_email','as'=>'admin.notify_email.list','uses'=>'NotifySmsController@getEmailIndex']);
    Route::post('notification/email/list',['middleware'=>'acl:view_notify_email','as'=>'admin.notify_email','uses'=>'DatatableController@getEmailList']);
    Route::get('notification/email/view/{id}',['middleware'=>'acl:view_notify_email_body','as'=>'admin.notify_email.body','uses'=>'NotifySmsController@getEmailBody']);
    Route::get('notification/{id}/email-send',['middleware'=>'acl:send_notify_email','as'=>'admin.notify_email.send','uses'=>'NotifySmsController@getSendEmail']);
    Route::get('notification/sms',['middleware'=>'acl:view_notify_sms','as'=>'admin.notify_sms.list','uses'=>'NotifySmsController@getIndex']);
    Route::post('notification/all_notification',['middleware'=>'acl:view_notify_sms','as'=>'admin.notify_sms.all_notification','uses'=>'DatatableController@getNotificationList']);
    Route::get('notification/{id}/sms-send',['middleware'=>'acl:send_notify_sms','as'=>'admin.notify_sms.send','uses'=>'NotifySmsController@getSendSms']);

    //New Arival
    Route::get('newarival',['middleware'=>'acl:view_newarival','as'=>'admin.newarival.list','uses'=>'NewarivalController@getIndex']);
    Route::post('get_newarival',['middleware'=>'acl:view_newarival','as'=>'admin.get_newarival','uses'=>'DatatableController@getNewArival']);
    Route::post('newarival/store',['middleware'=>'acl:new_newarival','as'=>'admin.newarival.create','uses'=>'NewarivalController@newArivalCreate']);
    Route::get('newarival/{id}/view',['middleware'=>'acl:view_newarival','as'=>'admin.newarival.view','uses'=>'NewarivalController@newArivalView']);

    Route::get('newarival-variant/{id}/list',['middleware'=>'acl:view_newarival','as'=>'admin.newarival_variant.list','uses'=>'NewarivalController@getNewArivalVariant']);
    Route::post('newarival/delete',['middleware'=>'acl:edit_newarival','as'=>'admin.newarival.delete','uses'=>'NewarivalController@newArivalDelete']);
    Route::post('newarival-variant/delete',['middleware'=>'acl:edit_newarival','as'=>'admin.newarival.variant.delete','uses'=>'NewarivalController@newArivalVariantDelete']);
    Route::post('newarival/orderid_update',['middleware'=>'acl:edit_newarival','as'=>'admin.newarival.orderid_update','uses'=>'NewarivalController@newArivalOrderidUpdate']);
    Route::post('newarival-variant/orderid_update',['middleware'=>'acl:edit_newarival','as'=>'admin.na_variant.orderid_update','uses'=>'NewarivalController@newArivalVariantOrderidUpdate']);
    Route::post('get-newarival-master','NewarivalController@getNewArivalMaster')->name('get-newarival-master');
    Route::post('get-newarival-variant/{id}','NewarivalController@getNotNewArivalVariant')->name('get-newarival-variant');
    Route::post('newarival-master/store',['middleware'=>'acl:new_newarival','as'=>'admin.newarival_master.create','uses'=>'NewarivalController@postNewArivalMasterStore']);
    Route::post('newarival-variant/store',['middleware'=>'acl:new_newarival','as'=>'admin.newarival_variant.create','uses'=>'NewarivalController@postNewArivalVaraitnStore']);
    Route::post('get_newarival_view/{id}',['middleware'=>'acl:view_newarival','as'=>'admin.get_newarival_view','uses'=>'DatatableController@getNewAriavalView']);
    Route::post('get_newarival_variant/{id}',['middleware'=>'acl:view_newarival','as'=>'admin.get_newarival_variant','uses'=>'DatatableController@getNewArivalVariantView']);

    //SALES REPORT
    Route::get('sales-report',['middleware'=>'acl:view_sales_report','as'=>'admin.sales_report.list','uses'=>'SalesReportController@getIndex']);
    Route::get('sales-report/{id}',['middleware'=>'acl:view_sales_report','as'=>'admin.sales_report.list-item','uses'=>'SalesReportController@getComissionReport']);
    Route::get('yet-to-ship',['middleware'=>'acl:view_yet_to_ship','as'=>'admin.yet_to_ship.list','uses'=>'SalesReportController@getYetToShip']);
    //AJAX
    Route::get('sales-comission-list-view/{agent_id}/{date}',['middleware'=>'acl:view_sales_report','as'=>'admin.sales_report.list-item-ajax','uses'=>'SalesReportController@ajaxComissionReport']);
    Route::get('report/top-sell',['middleware'=>'acl:view_top_sell','as'=>'admin.top_sell.list','uses'=>'SalesReportController@topSell']);
    Route::get('top-sell/{id}/view',['middleware'=>'acl:view_top_sell','as'=>'admin.top_sell.view','uses'=>'SalesReportController@topSellView']);
    Route::get('top-sell/{id}/pdf',['middleware'=>'acl:new_top_sell','as'=>'admin.top_sell.pdf','uses'=>'SalesReportController@getTopSellPdf']);
    Route::get('top-sell-variant/{id}/list',['middleware'=>'acl:view_top_sell','as'=>'admin.top_sell_variant.list','uses'=>'SalesReportController@getTopSellVariant']);
    Route::post('top-sell/delete',['middleware'=>'acl:edit_top_sell','as'=>'admin.top_sell.delete','uses'=>'SalesReportController@topSellDelete']);
    Route::post('top-sell-variant/delete',['middleware'=>'acl:edit_top_sell','as'=>'admin.top_sell_variant.delete','uses'=>'SalesReportController@topSellVariantDelete']);
    Route::post('top-sell/orderid_update',['middleware'=>'acl:edit_top_sell','as'=>'admin.top_sell.orderid_update','uses'=>'SalesReportController@topSellOrderidUpdate']);
    Route::post('top-sell-variant/orderid_update',['middleware'=>'acl:edit_top_sell','as'=>'admin.top_sell_variant.orderid_update','uses'=>'SalesReportController@topSellVariantOrderidUpdate']);
    Route::post('get-topsell-master','SalesReportController@getTopSellMaster')->name('get-topsell-master');
    Route::post('get-topsell-variant/{id}','SalesReportController@getNotTopSellVariant')->name('get-topsell-variant');

    Route::post('report/top-sell/store',['middleware'=>'acl:new_top_sell','as'=>'admin.top_sell.create','uses'=>'SalesReportController@topSellCreate']);
    Route::post('report/top-sell-master/store',['middleware'=>'acl:new_top_sell','as'=>'admin.top_sell_master.create','uses'=>'SalesReportController@postTopSellMasterStore']);
    Route::post('report/top-sell-variant/store',['middleware'=>'acl:new_top_sell','as'=>'admin.top_sell_variant.create','uses'=>'SalesReportController@postTopSellVaraitnStore']);
    Route::post('get_top_sell',['middleware'=>'acl:view_top_sell','as'=>'admin.get_top_sell','uses'=>'DatatableController@getTopSell']);
    Route::post('get_top_sell_view/{id}',['middleware'=>'acl:view_top_sell','as'=>'admin.get_top_sell_view','uses'=>'DatatableController@getTopSellView']);
    Route::post('get_top_sell_variant/{id}',['middleware'=>'acl:view_top_sell','as'=>'admin.get_top_sell_variant','uses'=>'DatatableController@getTopSellVariantView']);
        //consigment note
    Route::post('order/{id}/consignmentNote',['middleware'=>'acl:edit_dispatch','as'=>'admin.order.consignmentNote','uses'=>'PosLazuController@getConsignmentNote']);
    Route::get('ajax/consignment/getTrackingId/{id}',['middleware'=>'acl:edit_dispatch','as'=>'admin.consignment.getTrackingId','uses'=>'PosLazuController@getTrackingId']);

    //API list
    //  Route::get('apilist',['middleware'=>'acl:view_apilist','as'=>'admin.apilist.list','uses'=>'ApiListController@getIndex']);
    //  Route::get('apilist/{id}/edit',['middleware'=>'acl:edit_apilist','as'=>'admin.apilist.edit','uses'=>'ApiListController@getEdit']);
    //  Route::post('apilist/{id}/update',['middleware'=>'acl:edit_apilist','as'=>'admin.apilist.update','uses'=>'ApiListController@postEdit']);

     //dispatched order item return request
     Route::get('dispathed/returned',['middleware'=>'acl:view_item_return_request','as'=>'admin.return_request.list','uses'=>'ReturnRequestController@getIndex']);

    // Route::get('merchant',['middleware'=>'acl:view_merchant','as'=>'admin.merchant.list','uses'=>'MerchantController@getIndex']);
    // Route::get('merchant/create',['middleware'=>'acl:new_merchant','as'=>'admin.merchant.create','uses'=>'MerchantController@getCreate']);
    // Route::get('merchant/{id}/edit',['middleware'=>'acl:edit_merchant','as'=>'admin.merchant.edit','uses'=>'MerchantController@getEdit']);
    // Route::post('merchant/{id}/update',['middleware'=>'acl:edit_merchant','as'=>'admin.merchant.update','uses'=>'MerchantController@postUpdate']);
    // Route::post('merchant/store',['middleware'=>'acl:new_merchant','as'=>'admin.merchant.store','uses'=>'MerchantController@postStore']);
    // Route::get('merchant/bill',['middleware'=>'acl:view_merchant_bill','as'=>'admin.mer_bill.list','uses'=>'MerchantBillController@getIndex']);
    // Route::get('merchant/bill/{id}/edit',['middleware'=>'acl:edit_merchant_bill','as'=>'admin.mer_bill.edit','uses'=>'MerchantBillController@getEdit']);
    // Route::post('merchant/bill/{id}/update',['middleware'=>'acl:edit_merchant_bill','as'=>'admin.mer_bill.update','uses'=>'MerchantBillController@postUpdate']);
    // Route::get('merchant/bill/{id}/delete',['middleware'=>'acl:delete_merchant_bill','as'=>'admin.mer_bill.delete','uses'=>'MerchantBillController@getDelete']);
    // Route::post('merchant/bill/create',['middleware'=>'acl:new_merchant_bill','as'=>'admin.mer_bill.create','uses'=>'MerchantBillController@postStore']);
    // Route::get('merchant/payment',['middleware'=>'acl:view_merchant_payment','as'=>'merchant.payment.list','uses'=>'MerchantPayController@getIndex']);
    // Route::get('merchant/payment/{id}/create',['middleware'=>'acl:new_merchant_payment','as'=>'merchant.payment.create','uses'=>'MerchantPayController@getCreate']);
    // Route::post('merchant/payment/store',['middleware'=>'acl:new_merchant_payment','as'=>'merchant.payment.store','uses'=>'MerchantPayController@postStore']);

    //get options
    Route::get('getoptions/{table}/{key}/{val}/{cond_col}/{cond_val}',['as'=>'admin.getoptions','uses'=>'DashboardController@getOtions']);

});

Route::group(['namespace'=>'Web','middleware' => ['auth:admin']], function () {
    //Mail
    // Route::get('mail/config','MailController@getIndex')->name('web.mail.index');
    // Route::post('mail/env-update','MailController@env_key_update')->name('env_key_update.update');
    //WEB ROUTE
    Route::get('home/settings',['middleware'=>'acl:view_web_settings','as'=>'web.home.settings','uses'=>'WebSettingsController@getIndex']);
    Route::post('home/settings/store',['middleware'=>'acl:view_web_settings','as'=>'web.home.settings.store','uses'=>'WebSettingsController@postStore']);
    Route::get('home/custom-link',['middleware'=>'acl:view_web_custom_link','as'=>'web.home.custom_link','uses'=>'SliderController@getCustomLinks']);
    Route::get('home/custom-link/create',['middleware'=>'acl:new_web_custom_link','as'=>'web.home.custom_link.create','uses'=>'SliderController@createCustomLink']);
    Route::get('/get-custom-link-title',['middleware'=>'acl:edit_web_custom_link','as'=>'web.home.custom_link.get_titles','uses'=>'SliderController@getCustomLinkSearch']);
    Route::get('home/custom-link/edit/{id}',['middleware'=>'acl:edit_web_custom_link','as'=>'web.home.custom_link.edit','uses'=>'SliderController@getCustomLink']);
    Route::post('home/custom-link/store',['middleware'=>'acl:new_web_custom_link','as'=>'web.home.custom_link.store','uses'=>'SliderController@postCustomLinkStore']);
    Route::post('home/custom-link/{id}/update',['middleware'=>'acl:edit_web_new_web_custom_link','as'=>'web.home.custom_link.update','uses'=>'SliderController@postCustomLinkUpdate']);
    Route::get('home/custom-link/{id}/delete',['middleware'=>'acl:delete_web_custom_link','as'=>'web.home.custom_link.delete','uses'=>'SliderController@getCustomLinkDelete']);
    Route::get('web/slider/create',['middleware'=>'acl:view_web_settings','as'=>'web.slider.create','uses'=>'SliderController@createSlider']);
    Route::get('web/slider',['middleware'=>'acl:view_web_settings','as'=>'web.slider','uses'=>'SliderController@getAllSlider']);
    Route::get('web/slider/edit/{id}',['middleware'=>'acl:view_web_settings','as'=>'web.slider.edit','uses'=>'SliderController@getEdit']);
    Route::post('web/slider/store',['middleware'=>'acl:view_web_settings','as'=>'web.slider.store','uses'=>'SliderController@postStore']);
    Route::post('web/slider/{id}/update',['middleware'=>'acl:view_web_settings','as'=>'web.slider.update','uses'=>'SliderController@postUpdate']);
    Route::get('web/slider/{id}/delete',['middleware'=>'acl:view_web_settings','as'=>'web.slider.delete','uses'=>'SliderController@getDelete']);
    Route::get('slider/delete-photo/{id}',['middleware'=>'acl:edit_product_variant','as'=>'admin.slider.delete_photo','uses'=>'SliderController@getDeleteSlider']);
    Route::post('web/slider/featureStatus',['middleware'=>'acl:view_web_settings','as'=>'web.slider.featureStatus','uses'=>'SliderController@changeFeatureStatus']);
    Route::get('web/slider/order-up/{id}',['middleware'=>'acl:view_web_settings','as'=>'web.slider.order-up','uses'=>'SliderController@getOrderUp']);
    Route::get('web/slider/order-down/{id}',['middleware'=>'acl:view_web_settings','as'=>'web.slider.order-down','uses'=>'SliderController@getOrderDown']);
    Route::post('web/slider/photo/update/{id}',['middleware'=>'acl:view_web_settings','as'=>'web.slider.photo_update','uses'=>'SliderController@updateSliderPhotos']);
    Route::post('web/slider/add_photo',['middleware'=>'acl:view_web_settings','as'=>'web.slider.add_photo','uses'=>'SliderController@postAddPhotos']);
     //ajax route for product module
     Route::get('gellery/delete/{id}',['middleware'=>'acl:edit_gellery','as'=>'admin.gellery.delete','uses'=>'SliderController@getDeleteSliderImage']);
     // WEB HOME PAGE SETTING
    Route::get('web/home/setting',['middleware'=>'acl:view_web_settings','as'=>'web.home.setting','uses'=>'PageController@getHomeSetting']);
    Route::post('web/home_setting/update',['middleware'=>'acl:view_web_settings','as'=>'web.home_setting.update','uses'=>'PageController@postSettingUpdate']);
    Route::post('web/home_setting/slider_update',['middleware'=>'acl:view_web_settings','as'=>'web.home_setting.sliderUpdate','uses'=>'PageController@sliderUpdate']);
    //WEB ARTICLE
    Route::get('web/blog/article',['middleware'=>'acl:view_web_settings','as'=>'web.blog.article','uses'=>'ArticleController@getAllArticle']);
    Route::get('web/blog/article/create',['middleware'=>'acl:view_web_settings','as'=>'web.blog.article.create','uses'=>'ArticleController@getCreate']);
    Route::post('web/blog/article/store',['middleware'=>'acl:view_web_settings','as'=>'web.blog.article.store','uses'=>'ArticleController@postStore']);
    Route::get('web/blog/article/{id?}/edit',['middleware'=>'acl:view_web_settings','as'=>'web.blog.article.edit','uses'=>'ArticleController@getEdit']);
    Route::post('web/blog/article/{id}/update',['middleware'=>'acl:view_web_settings','as'=>'web.blog.article.update','uses'=>'ArticleController@postUpdate']);
    Route::get('web/blog/article/{id}/delete',['middleware'=>'acl:view_web_settings','as'=>'web.blog.article.delete','uses'=>'ArticleController@getDelete']);
    Route::post('ajax/text-editor/image-upload',['middleware'=>'acl:view_web_settings','as'=>'web.blog.text-editor.image','uses'=>'ArticleController@postEditorImageUpload']);
    Route::get('web/blog/category',['middleware'=>'acl:view_web_settings','as'=>'web.blog.category','uses'=>'BlogCategoryController@getAllCategory']);
    Route::get('web/blog/category/create',['middleware'=>'acl:view_web_settings','as'=>'web.blog.category.create','uses'=>'BlogCategoryController@getCreate']);
    Route::post('web/blog/category/store',['middleware'=>'acl:view_web_settings','as'=>'web.blog.category.store','uses'=>'BlogCategoryController@postStore']);
    Route::get('web/blog/category/{id?}/edit',['middleware'=>'acl:view_web_settings','as'=>'web.blog.category.edit','uses'=>'BlogCategoryController@getEdit']);
    Route::post('web/blog/category/{id}/update',['middleware'=>'acl:view_web_settings','as'=>'web.blog.category.update','uses'=>'BlogCategoryController@postUpdate']);
    Route::get('web/blog/category/{id}/delete',['middleware'=>'acl:view_web_settings','as'=>'web.blog.category.delete','uses'=>'BlogCategoryController@getDelete']);
        //WEB PAGES
    Route::get('web/page',['middleware'=>'acl:view_web_settings','as'=>'web.page','uses'=>'PageController@getAllPage']);
    Route::get('web/page/create',['middleware'=>'acl:view_web_settings','as'=>'web.page.create','uses'=>'PageController@getCreate']);
    Route::post('web/page/store',['middleware'=>'acl:view_web_settings','as'=>'web.page.store','uses'=>'PageController@postStore']);
    Route::get('web/page/{id}/edit',['middleware'=>'acl:view_web_settings','as'=>'web.page.edit','uses'=>'PageController@getEdit']);
    Route::post('web/page/{id}/update',['middleware'=>'acl:view_web_settings','as'=>'web.page.update','uses'=>'PageController@postUpdate']);
    Route::get('web/page/{id}/delete',['middleware'=>'acl:view_web_settings','as'=>'web.page.delete','uses'=>'PageController@getDelete']);
    Route::get('web/page/order-up/{id}',['middleware'=>'acl:view_web_settings','as'=>'web.page.order-up','uses'=>'PageController@getOrderUp']);
    Route::get('web/page/order-down/{id}',['middleware'=>'acl:view_web_settings','as'=>'web.page.order-down','uses'=>'PageController@getOrderDown']);
    // Route::post('ajax/text-editor/image-upload',['middleware'=>'acl:edit_spage','as'=>'web.blog.text-editor.image','uses'=>'PageController@postEditorImageUpload']);
    //WEB FAQ
    Route::get('web/faq',['middleware'=>'acl:view_web_settings','as'=>'web.faq','uses'=>'FaqController@getAllFaq']);
    Route::get('web/faq/create',['middleware'=>'acl:view_web_settings','as'=>'web.faq.create','uses'=>'FaqController@getCreate']);
    Route::post('web/faq/store',['middleware'=>'acl:view_web_settings','as'=>'web.faq.store','uses'=>'FaqController@postStore']);
    Route::get('web/faq/{id?}/edit',['middleware'=>'acl:view_web_settings','as'=>'web.faq.edit','uses'=>'FaqController@getEdit']);
    Route::post('web/faq/{id}/update',['middleware'=>'acl:view_web_settings','as'=>'web.faq.update','uses'=>'FaqController@postUpdate']);
    Route::get('web/faq/{id}/delete',['middleware'=>'acl:view_web_settings','as'=>'web.faq.delete','uses'=>'FaqController@getDelete']);
    // Route::post('ajax/text-editor/image-upload',['middleware'=>'acl:edit_shipment_signature','as'=>'web.blog.text-editor.image','uses'=>'PageController@postEditorImageUpload']);

    // Route::get('web/whatsapp',['middleware'=>'acl:view_web_settings','as'=>'web.whatsapp','uses'=>'WebSettingsController@getWhatsAppList']);
    // Route::get('web/whatsapp/create',['middleware'=>'acl:view_web_settings','as'=>'web.home.whatsapp.create','uses'=>'WebSettingsController@getWhatsAppCreate']);
    // Route::post('web/whatsapp/store',['middleware'=>'acl:view_web_settings','as'=>'web.home.whatsapp.store','uses'=>'WebSettingsController@whatsAppPostStore']);
    // Route::get('web/whatsapp/{id?}/edit',['middleware'=>'acl:view_web_settings','as'=>'web.home.whatsapp.edit','uses'=>'WebSettingsController@getEdit']);
    // Route::post('web/whatsapp/{id}/update',['middleware'=>'acl:view_web_settings','as'=>'web.home.whatsapp.update','uses'=>'WebSettingsController@whatsAppPostUpdate']);
    // Route::get('web/whatsapp/{id}/delete',['middleware'=>'acl:view_web_settings','as'=>'web.home.whatsapp.delete','uses'=>'WebSettingsController@getWhatsAppDelete']);
    // Route::get('web/whatsapp/order-up/{id}',['middleware'=>'acl:view_web_settings','as'=>'web.whatsapp.order-up','uses'=>'WebSettingsController@getOrderUp']);
    // Route::get('web/whatsapp/order-down/{id}',['middleware'=>'acl:view_web_settings','as'=>'web.whatsapp.order-down','uses'=>'WebSettingsController@getOrderDown']);

    // Notification Controllers
     Route::get('web/notification',['middleware'=>'acl:view_web_settings','as'=>'web.notification','uses'=>'PushNotificationController@getIndex']);
    Route::get('web/notification/create',['middleware'=>'acl:view_web_settings','as'=>'web.notification.create','uses'=>'PushNotificationController@getCreate']);
    Route::post('web/notification/bulksend',['middleware'=>'acl:view_web_settings','as'=>'web.notification.bulksend','uses'=>'PushNotificationController@postAppBulkSend']);
    Route::get('web/web-notification/create',['middleware'=>'acl:view_web_settings','as'=>'web.web-notification.create','uses'=>'PushNotificationController@getWebCreate']);
    Route::post('web/notification/web-push',['middleware'=>'acl:view_web_settings','as'=>'web.notification.web-push','uses'=>'PushNotificationController@sendWebNotification']);
    Route::post('web/notification/image-upload',['middleware'=>'acl:view_web_settings','as'=>'web.notification.image-upload','uses'=>'PushNotificationController@ajaxImageUpload']);
    Route::get('web/notification/device-list',['middleware'=>'acl:view_web_settings','as'=>'web.notification.device-list','uses'=>'PushNotificationController@getDeviceList']);
    Route::get('web/subscriber',['middleware'=>'acl:view_web_settings','as'=>'web.subscriber','uses'=>'SubscriberController@getIndex']);
    Route::get('web/contact',['middleware'=>'acl:view_web_settings','as'=>'web.contact','uses'=>'ContactController@getIndex']);
});
