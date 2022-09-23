
<ul class="navigation navigation-main mt-1" id="main-menu-navigation" data-menu="menu-navigation">
    <li class=" nav-item @yield('dashboard')">
        <a href="{{ route('admin.dashboard')}}"><i class="la la-dashboard"></i><span class="menu-title" data-i18n="@lang('left_menu.dashboard')">@lang('left_menu.dashboard')</span></a>
    </li>

    {{-- <li class=" nav-item @yield('dashboard_seller')">
        <a href="{{ route('seller.dashboard')}}"><i class="la la-dashboard"></i><span class="menu-title" data-i18n="@lang('left_menu.dashboard_seller')">@lang('left_menu.dashboard_seller')</span></a>
    </li> --}}

    <!-- li class=" navigation-header"><span data-i18n="Modules">Modules</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Modules" ></i>
    </li -->

    @if(hasAccessAbility('view_product_management', $roles))
    <li class="nav-item @yield('Product Management')">
        <a href="#"><i class="fas fa-box-open"></i></i><span class="menu-title" data-i18n="@lang('left_menu.product_management')">@lang('left_menu.product_management')</span></a>
        <ul class="menu-content sticky-dropdown">
            @if(hasAccessAbility('view_product_list', $roles))
            <li class="@yield('product_search_list')"><a class="menu-item" href="{{route('admin.product.searchlist')}}"><i></i><span data-i18n="@lang('left_menu.product_search_list')">@lang('left_menu.product_search_list')</span></a></li>
            @endif
            @if(hasAccessAbility('view_product', $roles))
            @if(Auth::user()->USER_TYPE == 10)
            <li class="@yield('product_list')"><a class="menu-item" href="{{ route('admin.product.branch-products') }}"><i></i><span data-i18n="@yield('product_list')">Product Master</span></a></li>
            @else
            <li class="@yield('product_list')"><a class="menu-item" href="{{ route('admin.product.list',['product' => 'all']) }}"><i></i><span data-i18n="@yield('product_list')">Product Master</span></a></li>
            @endif
            @endif
            {{-- @if(hasAccessAbility('new_product', $roles))
            <li class="@yield('product_create')"><a class="menu-item" href="{{ route('admin.product.create') }}"><i></i><span data-i18n="@yield('product_create')">Add New Product</span></a></li>
            @endif --}}
            @if(hasAccessAbility('view_category', $roles))
            <li class="@yield('product category')"><a class="menu-item" href="{{route('product.category.list')}}"><i></i><span data-i18n="@yield('product category')">Product Category</span></a></li>
            @endif
            @if(hasAccessAbility('view_special_category', $roles))
            <li class="@yield('product_special_category')"><a class="menu-item" href="{{route('product.spcategory.list')}}"><i></i><span data-i18n="@yield('product_special_category')">Special Category</span></a></li>
            @endif
            {{-- @if(hasAccessAbility('view_brand', $roles))
            <li class="@yield('product brand')"><a class="menu-item" href="{{route('product.brand.list')}}"><i></i><span data-i18n="@lang('left_menu.brand')">@lang('left_menu.product_brand')</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_sub_category', $roles))
            <li class="@yield('product sub-category')"><a class="menu-item" href="{{route('admin.sub_category.list')}}"><span data-i18n="Basic">@lang('left_menu.sub_category')</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_pending_master', $roles))
            <li class="@yield('pending_master')"><a class="menu-item" href="{{route('admin.product.pending')}}"><span data-i18n="Basic">Pending Master Index</span></a></li>
            @endif --}}

            {{-- @if(hasAccessAbility('view_pending_varint', $roles))
            <li class="@yield('pending_varint')"><a class="menu-item" href="{{route('admin.varint.pending')}}"><span data-i18n="Basic">Pending Product Variant</span></a></li>
            @endif --}}

            @if(hasAccessAbility('view_product_attr', $roles))
            <li class="@yield('product attr master')"><a class="menu-item" href="{{route('admin.product-attr.index')}}"><span data-i18n="Basic">Product Attributes</span></a></li>
            @endif
            @if(hasAccessAbility('view_product_feature', $roles))
            <li class="@yield('product feature master')"><a class="menu-item" href="{{route('admin.product-feature.index')}}"><span data-i18n="Basic">Variant Factors</span></a></li>
            @endif
        </ul>
    </li>
    @endif

    @if(hasAccessAbility('view_procurement', $roles))
    <li class=" nav-item @yield('Procurement')">
        <a href="#"><i class="la la-server"></i>
            <span class="menu-title" data-i18n="@yield('Procurement')">@lang('left_menu.procurement')</span>
        </a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_vendor', $roles))
            <li class="@yield('vendor')">
                <a class="menu-item" href="{{route('admin.vendor')}}"><i></i>
                    <span data-i18n="@yield('vendor')">@lang('left_menu.vendor')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_invoice', $roles))
            <li class="@yield('invoice')">
                <a class="menu-item" href="{{route('admin.invoice')}}"><i></i>
                <span data-i18n="@yield('invoice')">@lang('left_menu.invoice')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_invoice_processing', $roles))
            <li class="@yield('stock_processing')">
                <a class="menu-item" href="{{route('admin.invoice_processing')}}"><i></i>
                <span data-i18n="@yield('stock_processing')">Invoice to Stock</span>
                </a>
            </li>
            @endif

            {{-- @if(hasAccessAbility('view_vat_processing', $roles))
            <li class="@yield('vat_processing')">
                <a class="menu-item" href="{{route('admin.vat_processing', ['invoice_for' => 'azuramart'])}}"><i></i>
                <span data-i18n="@yield('vat_processing')">@lang('left_menu.vat_processing')</span>
                </a>
            </li>
            @endif --}}

            {{-- @if(hasAccessAbility('view_payment_processing', $roles))
            <li class=" nav-item @yield('payment_processing')"><a class="menu-item" href="{{ route('admin.payment_processing.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_processing')</span></a></li>
            @endif --}}

            @if(hasAccessAbility('view_stock', $roles))
            <li class="@yield('product_list_')">
                @if(Auth::user()->USER_TYPE == 10)
                <a class="menu-item" href="{{route('admin.all_product.list')}}?shop_id={{ Auth::user()->SHOP_ID }}"><i></i>
                <span data-i18n="">@lang('left_menu.product_list_')</span>
                </a>
                @else
                <a class="menu-item" href="{{route('admin.all_product.list')}}"><i></i>
                <span data-i18n="">@lang('left_menu.product_list_')</span>
                </a>
                @endif
            </li>
            @endif

        </ul>
    </li>
    @endif

    {{-- @if(hasAccessAbility('view_warehouse_section', $roles))
    <li class="nav-item  @yield('Warehouse Operation')"><a href="#"><i class="fas fa-tasks"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Warehouse Operation</span></a>

        <ul class="menu-content">
            @if(hasAccessAbility('view_warehouse_stock', $roles))
            <li class="@yield('product_list_')">
                <a class="menu-item" href="{{route('admin.all_product.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.product_list_')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_warehouse_unshelved', $roles))
            <li class="@yield('unshelved_list')">
                <a class="menu-item" href="{{route('admin.unshelved.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.unshelved_list')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_warehouse_shelved', $roles))
            <li class="@yield('shelve_list')">
                <a class="menu-item" href="{{route('admin.shelve.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.shelve_list')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_box_list', $roles))
            <li class="@yield('box_list')">
                <a class="menu-item" href="{{route('admin.box.list')}}{{ Auth::user()->F_MERCHANT_NO > 0 ? '' : '?invoice_for=azuramart' }}"><i></i>
                    <span data-i18n="">@lang('left_menu.box_list')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_box_type', $roles))
            <li class="@yield('box_type_list')">
                <a class="menu-item" href="{{route('admin.box_type.list')}}"><i></i>
                    <span data-i18n="">Box Type</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_not_box_list', $roles))
            <li class="@yield('not_box_list')">
                <a class="menu-item" href="{{route('admin.not_box.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.not_box_list')</span>
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif --}}

    {{-- @if(hasAccessAbility('view_shipment_section', $roles))
    <li class=" nav-item @yield('Shipping')">
        <a href="#"><i class="fas fa-shipping-fast"></i></i>
            <span class="menu-title" data-i18n="@yield('Shipping')">@lang('left_menu.shipping')</span>
        </a>
        <ul class="menu-content">

            <li class="@yield('add_shipping')">
                <a class="menu-item" href="{{route('admin.shipment.create')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.add_shipping')</span>
                </a>
            </li>
            @if(hasAccessAbility('view_shipment', $roles))
            <li class="@yield('list_shipping')">
                <a class="menu-item" href="{{route('admin.shipment.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.list_shipping')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_shipment_processing', $roles))
            <li class="@yield('processing_shipping')">
                <a class="menu-item" href="{{route('admin.shipment.processing')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.processing_shipping')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_shipping_address', $roles))
            <li class="@yield('shipping_address')">
                <a class="menu-item" href="{{route('admin.shipping-address.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.shipping_address')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_shipment_signature', $roles))
            <li class="@yield('shipment_sign')">
                <a class="menu-item" href="{{ route('admin.shipment-signature.list') }}"><i></i>
                    <span data-i18n="">@lang('left_menu.shipment_sign')</span>
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif --}}


    @if(hasAccessAbility('view_seller', $roles))
    <li class="nav-item  @yield('Seller Management')"><a href="#"><i class="fas fa-users-cog"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Branch Management</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('branch_product', $roles))
            <li class="@yield('branch_product')"><a class="menu-item" href="{{ route('admin.product.branch-products') }}"><i></i><span data-i18n="branch_product">Branch products</span></a></li>
            @endif
            @if(hasAccessAbility('view_seller', $roles))
            <li class="@yield('seller_list')"><a class="menu-item" href="{{route('admin.seller.list')}}"><i></i><span data-i18n="seller_list">Branches</span></a></li>
            @endif
            @if(hasAccessAbility('view_branch_admin', $roles))
            <li class="@yield('branch-admin')">
                <a href="{{ route('admin.branch-admin') }}"><span class="menu-title" data-i18n="@lang('left_menu.branch_admin')">Branch Users</span></a>
            </li>
            @endif
        </ul>
    </li>
    @endif



    @if(hasAccessAbility('view_customer', $roles))
    <li class="nav-item  @yield('Customer Management')"><a href="#"><i class="fas fa-users-cog"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Customer Management</span></a>
        <ul class="menu-content">
            {{-- <li class="@yield('add_customer')"><a class="menu-item" href="{{route('admin.customer.create')}}"><i></i><span data-i18n="@lang('left_menu.add_customer')r">Add Customer</span></a></li> --}}
            @if(hasAccessAbility('view_customer', $roles))
            <li class="@yield('customer_list')"><a class="menu-item" href="{{route('admin.customer.list')}}"><i></i><span data-i18n="@lang('left_menu.customer_list')">Customers</span></a></li>
            @endif
            {{-- <li class="@yield('reseller_add')"><a class="menu-item" href="{{route('admin.seller.create')}}"><i></i><span data-i18n="@lang('left_menu.reseller_list')">@lang('left_menu.add_reseller')</span></a></li> --}}
            {{-- @if(hasAccessAbility('view_reseller', $roles))
            <li class="@yield('reseller_list')"><a class="menu-item" href="{{route('admin.seller.list')}}"><i></i><span data-i18n="@lang('left_menu.reseller_list')">@lang('left_menu.reseller_list')</span></a></li>
            @endif --}}

            {{-- @if(hasAccessAbility('view_merchant', $roles))
            <li class="@yield('merchant_list')">
                <a class="menu-item" href="{{route('admin.merchant.list')}}"><i></i>
                    <span data-i18n="">Merchant List</span>
                </a>
            </li>
            @endif --}}

        </ul>
    </li>
    @endif

    {{-- @if(hasAccessAbility('view_customer_notification', $roles))
    <li class="nav-item  @yield('Customer Notification')"><a href="#"><i class="fas fa-users-cog"></i><span class="menu-title">Customer Notifications</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_notify_sms', $roles))
            <li class="@yield('notify_sms')"><a class="menu-item" href="{{route('admin.notify_sms.list')}}"><span data-i18n="@yield('notify_sms')">Notification SMS</span></a></li>
            @endif
            @if(hasAccessAbility('view_notify_email', $roles))
            <li class="@yield('notify_email')"><a class="menu-item" href="{{route('admin.notify_email.list',['type' => 'success','filter'=>'Order Create'])}}"><span data-i18n="@yield('notify_email')">Notification Email</span></a></li>
            @endif
        </ul>
    </li>
    @endif --}}

    @if(hasAccessAbility('view_order_management', $roles))
    <li class=" nav-item @yield('Order Management')"><a href="#"><i class="fas fa-cart-plus"></i><span class="menu-title" data-i18n="@lang('left_menu.order_management')">Order Management</span></a>
        <ul class="menu-content">

            @if(hasAccessAbility('view_booking', $roles))
            <li class="@yield('list_order')"><a class="menu-item" href="{{ route('admin.booking.list') }}"><i></i><span data-i18n="@yield('list_order')">Orderes</span></a></li>
            @endif

            @if(hasAccessAbility('new_booking', $roles))
                @if(Auth::user()->USER_TYPE == 10)
                    <li class="@yield('new_booking')"><a class="menu-item" href="{{route('admin.booking.create')}}?branch_id={{ Auth::user()->SHOP_ID }}"><i></i><span data-i18n="@yield('new_booking')">Search & Order</span></a></li>
                @else
                    <li class="@yield('new_booking')"><a class="menu-item" href="{{route('admin.booking.create')}}"><i></i><span data-i18n="@yield('new_booking')">Add New Order</span></a></li>
                @endif
            @endif

            @if(hasAccessAbility('edit_booking', $roles))
            <li class="@yield('web_cart')"><a class="menu-item" href="{{route('admin.cart.web-cart')}}"><i></i><span data-i18n="@yield('web_cart')">Web Cart</span></a></li>
            @endif

            {{-- @if(hasAccessAbility('edit_booking', $roles))
            <li class="@yield('list_altered_order')"><a class="menu-item" href="{{route('admin.order_alter.list')}}"><i></i><span data-i18n="@yield('list_order')">Awaiting Approval</span></a></li>
            @endif --}}

            {{-- @if(hasAccessAbility('view_booking', $roles))
            <li class="@yield('booking_list')"><a class="menu-item" href="{{ route('admin.booking.list') }}"><span data-i18n="@yield('booking_list')">@lang('left_menu.booking_list')</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_booking', $roles))
            <li class="@yield('list_default_order')"><a class="menu-item" href="{{route('admin.order_default.list')}}"><i></i><span data-i18n="@yield('list_default_order')">Default & Cancel Order</span></a></li>
            @endif --}}



        </ul>
    </li>
    @endif

    @if(hasAccessAbility('view_dispatch_management', $roles))
    <li class=" nav-item @yield('Dispatch Management')"><a href="#"><i class="la la-truck"></i><span class="menu-title" data-i18n="@lang('left_menu.dispatch_management')">Dispatch Management</span></a>
        <ul class="menu-content">

            @if(hasAccessAbility('view_dispatch', $roles))
            <li class="@yield('list_dispatch')"><a class="menu-item" href="{{route('admin.dispatch.confirm-list')}}"><i></i><span data-i18n="@yield('list_dispatch')">Confirmed List</span></a></li>
            @endif

            @if(hasAccessAbility('ready_to_dispatch', $roles))
            <li class="@yield('ready_to_dispatch')"><a class="menu-item" href="{{route('admin.dispatch.ready_to_dispatch')}}"><i></i><span data-i18n="@yield('ready_to_dispatch')">Ready to Dispatch</span></a></li>
            @endif

            @if(hasAccessAbility('view_dispatched', $roles))
            <li class="@yield('dispatched_list')"><a class="menu-item" href="{{route('admin.dispatched.list')}}"><span data-i18n="@yield('dispatched_list')">Dispatched List</span></a></li>
            @endif


            {{-- @if(hasAccessAbility('view_dispatched', $roles))
            <li class="@yield('dispatched_list')"><a class="menu-item" href="{{route('admin.dispatched.list')}}"><span data-i18n="@yield('dispatched_list')">Dispatched List</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_notify_sms', $roles))
            <li class="@yield('notify_sms')"><a class="menu-item" href="{{route('admin.notify_sms.list')}}"><span data-i18n="@yield('notify_sms')">Notification SMS</span></a></li>
            @endif
            @if(hasAccessAbility('view_notify_email', $roles))
            <li class="@yield('notify_email')"><a class="menu-item" href="{{route('admin.notify_email.list')}}"><span data-i18n="@yield('notify_email')">Notification Email</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_pending_app_dispach', $roles))
            <li class="@yield('view_pending_app_dispach')"><a class="menu-item" href="{{route('admin.pending_by_app.dispatch-list')}}"><span data-i18n="@yield('view_pending_app_dispach')">Pending App Dispatch</span></a></li>
            @endif --}}


            @if(hasAccessAbility('view_item_return_request', $roles))
            <li class="@yield('item_return_request_list')"><a class="menu-item" href="{{route('admin.return_request.list')}}"><span data-i18n="@yield('item_return_request_list')">Return Request List</span></a></li>
            @endif

            {{-- @if(hasAccessAbility('view_batch_collected', $roles))
            <li class="@yield('view_batch_list_collected')"><a class="menu-item" href="{{route('admin.batch_collected.list')}}"><span data-i18n="@yield('view_batch_list_collected')">RTS Batch List</span></a></li>
            @endif --}}

            {{-- @if(hasAccessAbility('view_order_collect', $roles))
            <li class="@yield('order_collect_list')"><a class="menu-item" href="{{route('admin.order_collect.list')}}"><span data-i18n="@yield('order_collect_list')">Order Collect List</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_batch_collect', $roles))
            <li class="@yield('view_batch_list')"><a class="menu-item" href="{{route('admin.batch_collect.list')}}"><span data-i18n="@yield('view_batch_list')">RTS Batch List</span></a></li>
            @endif --}}
        </ul>
    </li>
    @endif

    @if(hasAccessAbility('view_delivery_management', $roles))
    <li class=" nav-item @yield('Delivery Management')"><a href="#"><i class="la la-truck"></i><span class="menu-title" data-i18n="@lang('left_menu.delivery_management')">Delivery Management</span></a>
        <ul class="menu-content">

            @if(hasAccessAbility('view_delivered', $roles))
            <li class="@yield('list_delivered')"><a class="menu-item" href="{{route('admin.delivered.list')}}"><i></i><span data-i18n="@yield('list_delivered')">Delivered</span></a></li>
            @endif
            @if(hasAccessAbility('view_cancel', $roles))
            <li class="@yield('cancel_request_list')"><a class="menu-item" href="{{route('admin.cancel-request-list')}}"><i></i><span data-i18n="@yield('list_delivered')">Order Cancel Request</span></a></li>
            @endif
            @if(hasAccessAbility('view_delivery_boy', $roles))
                <li class="@yield('d_boy')">
                    <a class="menu-item" href="{{ route('admin.delivery_boy.list') }}"><span data-i18n="@lang('left_menu.role')">Delivery Man</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif

    @if(hasAccessAbility('view_account_management', $roles))
    <li class="nav-item @yield('Payment')">
        <a href="#"><i class="la la-paypal"></i><span class="menu-title" data-i18n="Calendars">Accounts Management</span></a>
        <ul class="menu-content">
            <li class="has-sub is-shown"><a class="menu-item" href="#"><i></i><span data-i18n="Coming Soon">Cash Book</span></a>
              <ul class="menu-content">
                {{-- @if(hasAccessAbility('view_account_source', $roles))
                <li class="nav-item @yield('Payment Management')"><a class="menu-item" href="{{route('admin.account.list')}}"><i></i><span data-i18n="Accounts">Accounts</span></a></li>
                @endif --}}
                @if(hasAccessAbility('view_accounts', $roles))
                <li class="nav-item @yield('payment_bank')"><a class="menu-item" href="{{route('admin.accounts.list')}}"><i></i><span data-i18n="Accounts">Accounts</span></a></li>
                @endif
                {{-- @if(hasAccessAbility('view_payment_bank', $roles))
                <li class="nav-item @yield('bank_balance')"><a class="menu-item" href="{{route('accounts.balances')}}"><i></i><span data-i18n="Accounts">Add Balance</span></a></li>
                @endif --}}
                @if(hasAccessAbility('view_payment_bank', $roles))
                <li class="nav-item @yield('balance_transfer')"><a class="menu-item" href="{{route('accounts.balance_transfer')}}"><i></i><span data-i18n="Accounts">Balance Transfers</span></a></li>
                @endif
                @if(hasAccessAbility('view_payment_bank', $roles))
                <li class="nav-item @yield('balance_history')"><a class="menu-item" href="{{route('accounts.balance_history')}}"><i></i><span data-i18n="Accounts">Transaction History</span></a></li>
                @endif
              </ul>
            </li>
            @if(hasAccessAbility('view_payment_suppliers', $roles))
            <li class="has-sub"><a class="menu-item " href="#"><i></i><span data-i18n="Suppliers">Suppliers Payments</span></a>
                <ul class="menu-content" style="">
                    @if(hasAccessAbility('view_payment_purchase', $roles))
                        <li class="nav-item @yield('payments_purchase')"><a class="menu-item " href="{{ route('payments.purchase') }}"><i></i><span data-i18n="Purchase">Purchase Payments</span></a></li>
                    @endif
                    @if(hasAccessAbility('view_payment_suppliers', $roles))
                        <li class="nav-item  @yield('payments_non_purchase')"><a class="menu-item" href="{{ route('payments.non_purchase') }}"><i></i><span data-i18n="Non-Purchase">Non-Purchase Payments</span></a></li>
                    @endif

                </ul>
            </li>
            @endif
            {{-- @if(hasAccessAbility('view_bank_state', $roles))
            <li class=" nav-item @yield('bankstatement')"><a class="menu-item" href="{{ route('admin.bankstate.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.bankstatement')</span></a></li>
            @endif --}}
            {{--
            @if(hasAccessAbility('view_bank_to_bank', $roles))
            <li class="@yield('bank_to_bank_xfer')"><a class="menu-item" href="{{route('admin.account_to_bank_list.view')}}"><i></i><span data-i18n="@yield('bank_to_bank_xfer')">Internal Transfer</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_merchant_payment', $roles))
            <li class=" nav-item @yield('merchant_payment_list')"><a class="menu-item" href="{{ route('merchant.payment.list') }}"><i></i><span data-i18n="Basic">Merchant Payment</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_merchant_bill', $roles))
            <li class=" nav-item @yield('merchant_bill')"><a class="menu-item" href="{{ route('admin.mer_bill.list') }}"><i></i><span data-i18n="Basic">Merchant Bill</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('view_payment', $roles))
            <li class=" nav-item @yield('payment_list')"><a class="menu-item" href="{{ route('admin.payment.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_list')</span></a></li>
            @endif --}}
            {{-- @if(hasAccessAbility('payment_verification', $roles))
            <li class=" nav-item @yield('payment_verification')"><a class="menu-item" href="{{ route('admin.bankstate.verification') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_verification')</span></a></li>
            @endif --}}
            @if(hasAccessAbility('view_refund', $roles))
            <li class="nav-item @yield('view_refund')"><a class="menu-item" href="{{ route('admin.customer.refund') }}"><i></i><span data-i18n="Basic">Refund (Customer)</span></a></li>
            @endif
            {{-- @if(hasAccessAbility('view_refund', $roles))
            <li class="nav-item @yield('view_reseller_refund')"><a class="menu-item" href="{{ route('admin.seller.refund') }}"><i></i><span data-i18n="Basic">Refund (Reseller)</span></a></li>
            @endif --}}
            {{-- <li class=" nav-item @yield('payment_entry')"><a class="menu-item" href="{{ route('admin.payment.create') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_entry')</span></a></li> --}}
            {{-- @if(hasAccessAbility('view_bank_to_other', $roles))
            <li class="@yield('bank_to_other_xfer')"><a class="menu-item" href="{{route('admin.account_to_other_list.view')}}"><i></i><span data-i18n="@yield('bank_to_other_xfer')">Third Party Payments</span></a></li>
            @endif --}}
          </ul>
    </li>
    @endif

    {{-- <li class=" nav-item"><a href="{{route('product.inventory.list')}}"><i class="la la-calendar"></i><span class="menu-title" data-i18n="Calendars">@lang('left_menu.inventory')</span></a>
    </li> --}}
    @if(hasAccessAbility('view_offer_management', $roles))
    <li class=" nav-item @yield('offer_management')">
        <a href="#"><i class="fas fa-gifts"></i>
            <span class="menu-title" data-i18n="@yield('offer_management')">Offer Management</span>
        </a>
        <ul class="menu-content">
{{--
            <li class="@yield('offer_group')">
                <a class="menu-item" href="{{route('admin.offergroup.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_group')</span>
                </a>
            </li>
            <li class="@yield('offer_list')">
                <a class="menu-item" href="{{route('admin.offer.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_list')</span>
                </a>
            </li>
            <li class="@yield('offer_primary_list')">
                <a class="menu-item" href="{{route('admin.offer_primary.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_primary_list')</span>
                </a>
            </li>
            <li class="@yield('offer_secondary_list')">
                <a class="menu-item" href="{{route('admin.offer_secondary.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_secondary_list')</span>
                </a>
            </li>
            <li class="@yield('offer_type')">
                <a class="menu-item" href="{{route('admin.offer_type.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_type')</span>
                </a>
            </li> --}}
            @if(hasAccessAbility('view_coupon_list', $roles))
            <li class="@yield('coupon_discount')">
                <a class="menu-item" href="{{route('admin.coupon.list')}}"><i></i>
                    <span data-i18n="">Coupons</span>
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_sales_report_section', $roles))
    <li class="nav-item  @yield('Sales Report')"><a href="#"><i class="ft-bar-chart"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Report  Management</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_top_sell', $roles))
            <li class="@yield('top_sell')">
                <a class="menu-item" href="{{route('admin.top_sell.list')}}"><i></i>
                    <span data-i18n="">Best Sell</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_newarival', $roles))
            <li class="@yield('newarival')">
                <a class="menu-item" href="{{route('admin.newarival.list')}}"><i></i>
                    <span data-i18n="">New Arrival</span>
                </a>
            </li>
            @endif

            {{-- @if(hasAccessAbility('view_sales_report', $roles))
            <li class="@yield('sales_report')">
                <a class="menu-item" href="{{route('admin.sales_report.list')}}"><i></i>
                    <span data-i18n="">Sales Commission</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_collection_list', $roles))
            <li class="@yield('view_bank_collection')"><a class="menu-item" href="{{route('admin.collection.list')}}"><span data-i18n="@yield('view_bank_collection')">COD payment Position</span></a></li>
            @endif
            @if(hasAccessAbility('yet_to_ship', $roles))
            <li class="@yield('yet_to_ship')"><a class="menu-item" href="{{route('admin.yet_to_ship.list')}}"><span data-i18n="@yield('yet_to_ship')">Yet to Ship</span></a></li>
            @endif --}}

        </ul>
    </li>
@endif

    <li class=" navigation-header"><span data-i18n="Settings">Settings</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Settings" ></i>
    </li>
    @if(hasAccessAbility('view_admin_management', $roles))
        <li class=" nav-item @yield('Admin Mangement')">
            <a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="@lang('left_menu.admin_management')">User Management<span></a>
            <ul class="menu-content">
                @if(hasAccessAbility('view_admin_user', $roles))
                    <li class="@yield('admin-user')">
                        <a href="{{ route('admin.admin-user') }}"><span class="menu-title" data-i18n="@lang('left_menu.admin_user')">Users</span></a>
                    </li>
                @endif
                @if(hasAccessAbility('view_user_group', $roles))
                    <li class=" nav-item @yield('user-group')">
                        <a href="{{ route('admin.user-group') }}">
                            <span class="menu-title" data-i18n="@lang('left_menu.user_category')">User Group</span>
                        </a>
                    </li>
                @endif

                {{-- @if(hasAccessAbility('view_agent', $roles))
                <li class="@yield('agent_list')"><a class="menu-item" href="{{route('admin.agent.list')}}"><i></i><span data-i18n="Basic">@lang('left_menu.agent_list')</span></a></li>
                @endif --}}
            </ul>
        </li>
    @endif

    {{-- @if(hasAccessAbility('view_seller_management', $roles))
        <li class=" nav-item @yield('Branch Mangement')">
            <a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="@lang('left_menu.seller_management')">Branch Management<span></a>
            <ul class="menu-content">
                @if(hasAccessAbility('view_seller_user', $roles))
                    <li class="@yield('seller-user')">
                        <a href="{{ route('admin.branch-user') }}"><span class="menu-title" data-i18n="@lang('left_menu.seller_user')">Branch Admin List</span></a>
                    </li>
                @endif
                @if(hasAccessAbility('view_user_group', $roles))
                    <li class=" nav-item @yield('seller-user-group')">
                        <a href="{{ route('seller.user-group') }}">
                            <span class="menu-title" data-i18n="@lang('left_menu.user_category')">Branch Admin Group</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif --}}

    @if(hasAccessAbility('view_admin_permission', $roles))
        <li class=" nav-item @yield('Role Management')">
            <a href="#">
                <i class="la la-user-plus"></i>
                <span class="menu-title" data-i18n="@lang('left_menu.role_management')">User Permission</span>
            </a>
            <ul class="menu-content">
                @if(hasAccessAbility('view_role', $roles))
                    <li class="@yield('role')">
                        <a class="menu-item" href="{{ route('admin.role') }}">
                            <i></i>
                            <span data-i18n="@lang('left_menu.role')">Role</span>
                        </a>
                    </li>
                @endif
                @if(hasAccessAbility('view_menu', $roles))
                    <li class="@yield('permission-group')">
                        <a class="menu-item" href="{{ route('admin.permission-group') }}"><i></i><span data-i18n="@lang('left_menu.menus')">@lang('left_menu.menus')</span>
                        </a>
                    </li>
                @endif
                @if(hasAccessAbility('view_action', $roles))
                    <li class="@yield('permission')"><a class="menu-item" href="{{ route('admin.permission') }}"><i></i><span data-i18n="@lang('left_menu.actions')">@lang('left_menu.actions')</span></a>
                    </li>
                @endif
                {{-- @if(hasAccessAbility('assign_user_access', $roles))
                    <li class=" nav-item @yield('assign-access')">
                        <a href="{{ route('admin.assign-access') }}">
                            <span class="menu-title" data-i18n="@lang('left_menu.assign_access')">@lang('left_menu.assign_access')</span>
                        </a>
                    </li>
                @endif --}}
            </ul>
        </li>
    @endif
    {{-- @if(hasAccessAbility('view_seller_permission', $roles))
        <li class=" nav-item @yield('Seller Role Management')">
            <a href="#">
                <i class="la la-user-plus"></i>
                <span class="menu-title" data-i18n="@lang('left_menu.role_management')">Seller Permission</span>
            </a>
            <ul class="menu-content">
                @if(hasAccessAbility('view_role', $roles))
                    <li class="@yield('seller-role')">
                        <a class="menu-item" href="{{ route('seller.role') }}">
                            <i></i>
                            <span data-i18n="@lang('left_menu.role')">Seller Role</span>
                        </a>
                    </li>
                @endif
                @if(hasAccessAbility('view_menu', $roles))
                    <li class="@yield('seller-permission-group')">
                        <a class="menu-item" href="{{ route('seller.permission-group') }}"><i></i><span data-i18n="@lang('left_menu.menus')">@lang('left_menu.menus')</span>
                        </a>
                    </li>
                @endif
                @if(hasAccessAbility('view_action', $roles))
                    <li class="@yield('seller-permission')"><a class="menu-item" href="{{ route('seller.permission') }}"><i></i><span data-i18n="@lang('left_menu.actions')">@lang('left_menu.actions')</span></a>
                    </li>
                @endif
            </ul>
        </li>
    @endif --}}
    {{-- @if(hasAccessAbility('view_account_management', $roles))
    <li class=" nav-item @yield('Accounts')">
        <a href="#"><i class="fas fa-money-check"></i><span class="menu-title" data-i18n="Calendars">Account Management</span></a>
        <ul class="menu-content">

            @if(hasAccessAbility('view_account_source', $roles))
            <li class=" nav-item @yield('Payment Management')"><a class="menu-item" href="{{route('admin.account.list')}}"><i></i><span data-i18n="Basic">Source Account Method</span></a></li>
            @endif

            @if(hasAccessAbility('view_payment_bank', $roles))
            <li class=" nav-item @yield('payment_bank')"><a class="menu-item" href="{{route('admin.payment_bank.list')}}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_bank')</span></a></li>
            @endif
        </ul>
    </li>
    @endif --}}

    @if(hasAccessAbility('view_system_settings', $roles))
        <li class=" nav-item @yield('System Settings')">
            <a href="#"><i class="la la-cogs"></i><span class="menu-title" data-i18n="@lang('left_menu.system_settings')">System Settings</span></a>
            <ul class="menu-content">
            <li class="@yield('documentation')"><a class="menu-item" href="{{route('admin.documentation')}}"><i></i><span data-i18n="seller_list">Documentation</span></a></li>
            <li class="@yield('delivery_schedule')"><a class="menu-item" href="{{route('admin.delivery.delivery_schedule')}}"><i></i><span data-i18n="seller_list">Delivery Schedule</span></a></li>
                @if(hasAccessAbility('view_apilist', $roles))
                {{-- <li class="@yield('api_list')"><a class="menu-item" href="{{route('admin.apilist.list')}}"><i></i><span data-i18n="Basic">API List</span></a></li> --}}
                @endif
                @if(hasAccessAbility('view_currency', $roles))
                <li class="nav-item @yield('currency')">
                    <a class="menu-item" href="{{ route('admin.currency.list') }}"> <span data-i18n="Basic">@lang('left_menu.currency')</span></a>
                </li>
                @endif
                @if(hasAccessAbility('view_region_list', $roles))
                <li class="@yield('region_list')">
                    <a class="menu-item" href="{{route('admin.address.region_list')}}"><span data-i18n="Basic">Region</span></a>
                </li>
                @endif
                @if(hasAccessAbility('view_city_list', $roles))
                <li class="@yield('city_list')"><a class="menu-item" href="{{route('admin.address.city_list')}}"><i></i><span data-i18n="Basic">City</span></a>
                </li>
                @endif
                @if(hasAccessAbility('view_area_list', $roles))
                <li class="@yield('area_list')"><a class="menu-item" href="{{route('admin.address.area_list')}}"><i></i><span data-i18n="Basic">Area</span></a>
                </li>
                @endif
                @if(hasAccessAbility('view_area_list', $roles))
                <li class="@yield('sub_area')"><a class="menu-item" href="{{route('admin.address.sub_area')}}"><i></i><span data-i18n="Basic">Sub Area</span></a>
                </li>
                @endif
                @if(hasAccessAbility('view_postage_list', $roles))
                {{-- <li class="@yield('postage_list')"><a class="menu-item" href="{{route('admin.address_type.postage_list_')}}"><i></i><span data-i18n="Basic">Postage List</span></a>
                </li> --}}
                @endif
            </ul>
        </li>
    @endif

    @if(hasAccessAbility('view_notification', $roles))
        <li class="nav-item @yield('notification-list')">
            <a href="#"><i class="la la-bell"></i><span class="menu-title">Push Notification</span></a>
            <ul class="menu-content">
                <li class="@yield('notification')"><a class="menu-item" href="{{route('web.notification')}}"><i></i><span data-i18n="Basic">Notification List</span></a>
                </li>
                <li class="@yield('notification-create')"><a class="menu-item" href="{{route('web.notification.create')}}"><i></i><span data-i18n="Basic">App Bulk Notification</span></a>
                </li>
                <li class="@yield('web-notification')"><a class="menu-item" href="{{route('web.web-notification.create')}}"><i></i><span data-i18n="Basic">Web Notification</span></a>
                </li>
                <li class="@yield('device-list')"><a class="menu-item" href="{{route('web.notification.device-list')}}"><i></i><span data-i18n="Basic">Device List</span></a>
                </li>

            </ul>
        </li>
    @endif

    @if(hasAccessAbility('view_web_settings', $roles))
    <li class=" nav-item @yield('web')">
        <a href="#"><i class="la la-cog"></i>
            <span class="menu-title" data-i18n="@yield('web')">Web Settings</span>
        </a>
        <ul class="menu-content">
            <li class="@yield('slider')">
                <a class="menu-item" href="{{route('web.slider')}}">
                    <span data-i18n="">Gallery</span>
                </a>
            </li>

            <li class="@yield('home_page')">
                <a class="menu-item" href="{{route('web.home.setting')}}">
                    <span data-i18n="">Home Page Setting</span>
                </a>
            </li>

            @if(hasAccessAbility('view_web_custom_link', $roles))
            <li class="@yield('custom link')">
                <a class="menu-item" href="{{route('web.home.custom_link')}}">
                    <span data-i18n="">Custom Link Highlighter</span>
                </a>
            </li>
            @endif
        </ul>
        <ul class="menu-content">
            <li class="@yield('blog-category')">
                <a class="menu-item" href="{{route('web.blog.category')}}">
                    <span data-i18n="@yield('blog-category')">Blog Category</span>
                </a>
            </li>
            <li class="@yield('article')">
                <a class="menu-item" href="{{route('web.blog.article')}}">
                    <span data-i18n="@yield('blog-article')">Blog Article</span>
                </a>
            </li>
            <li class="@yield('pages')">
                <a class="menu-item" href="{{route('web.page')}}">
                    <span data-i18n="@yield('pages')">Pages</span>
                </a>
            </li>
            <li class="@yield('subscribers')">
                <a class="menu-item" href="{{route('web.subscriber')}}">
                    <span data-i18n="@yield('subscriber')">Subscriber</span>
                </a>
            </li>
            <li class="@yield('contact')">
                <a class="menu-item" href="{{route('web.contact')}}">
                    <span data-i18n="@yield('contact')">Contact Message</span>
                </a>
            </li>
            <li class="@yield('faq')">
                <a class="menu-item" href="{{route('web.faq')}}">
                    <span data-i18n="@yield('faq')">Faq</span>
                </a>
            </li>
            {{-- <li class="@yield('about')">
                <a class="menu-item" href="{{route('web.about')}}">
                    <span data-i18n="@yield('about')">About</span>
                </a>
            </li> --}}
            <li class="@yield('settings')">
                <a class="menu-item" href="{{route('web.home.settings')}}"><i></i>
                    <span data-i18n="@yield('settings')">Settings</span>
                </a>
            </li>
            {{-- <li class="@yield('whatsapp')">
                <a class="menu-item" href="{{route('web.whatsapp')}}"><i></i>
                    <span data-i18n="@yield('whatsapp')">WhatsApp</span>
                </a>
            </li> --}}
            {{-- <li class="@yield('mail')">
                <a class="menu-item" href="{{route('web.mail.index')}}"><i></i>
                    <span data-i18n="@yield('mail')">Email Config</span>
                </a>
            </li> --}}
        </ul>
    </li>
    @endif
</ul>
