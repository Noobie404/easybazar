
<ul class="navigation navigation-main mt-1" id="main-menu-navigation" data-menu="menu-navigation">
    <li class=" nav-item @yield('dashboard')">
        <a href="{{ route('admin.dashboard')}}"><i class="la la-dashboard"></i><span class="menu-title" data-i18n="@lang('left_menu.dashboard')">@lang('left_menu.dashboard')</span></a>
    </li>
    <!-- li class=" navigation-header"><span data-i18n="Modules">Modules</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Modules" ></i>
    </li -->

    @if(hasAccessAbility('view_product_management', $roles))

    <li class="nav-item @yield('Product Management')">
        <a href="#"><i class="fas fa-box-open"></i></i><span class="menu-title" data-i18n="@lang('left_menu.product')">@lang('left_menu.products')</span></a>
        <ul class="menu-content sticky-dropdown">

            {{-- @if(hasAccessAbility('view_product_list', $roles))
            <li class="@yield('product_search_list')"><a class="menu-item" href="{{route('admin.product.searchlist')}}"><i></i><span data-i18n="@lang('left_menu.product_search_list')">@lang('left_menu.product_search_list')</span></a></li>
            @endif --}}

            @if(hasAccessAbility('view_product', $roles))
            <li class="@yield('product_list')"><a class="menu-item" href="{{ route('seller.product.list') }}?product=all"><i></i><span data-i18n="@yield('product_list')">Manage products</span></a></li>
            @endif

            {{-- @if(hasAccessAbility('view_invoice_processing', $roles))
            <li class="@yield('manage_stocks')">
                <a class="menu-item" href="{{route('seller.invoice-details.new')}}"><i></i>
                <span data-i18n="@yield('manage_stocks')">Manage stocks</span>
                </a>
            </li>
            @endif --}}

            @if(hasAccessAbility('view_category', $roles))
            <li class="@yield('product category')"><a class="menu-item" href="{{route('seller.category.list')}}?category=all"><i></i><span data-i18n="@yield('product category')">Category</span></a></li>
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

            @if(hasAccessAbility('view_attr_master', $roles))
            <li class="@yield('product attr master')"><a class="menu-item" href="{{route('admin.product-attr.index')}}"><span data-i18n="Basic">Product Attributes</span></a></li>
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
                <a class="menu-item" href="{{route('seller.vendor')}}"><i></i>
                    <span data-i18n="@yield('vendor')">@lang('left_menu.vendor')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_invoice', $roles))
            <li class="@yield('invoice')">
                <a class="menu-item" href="{{route('seller.invoice')}}"><i></i>
                <span data-i18n="@yield('invoice')">@lang('left_menu.invoice')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_invoice_processing', $roles))
            <li class="@yield('stock_processing')">
                <a class="menu-item" href="{{route('seller.invoice_processing')}}"><i></i>
                <span data-i18n="@yield('stock_processing')">@lang('left_menu.stock_processing')</span>
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_order_management', $roles))
    <li class=" nav-item @yield('Order Management')"><a href="#"><i class="fas fa-cart-plus"></i><span class="menu-title" data-i18n="@lang('left_menu.order_management')">Order & reviews</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_order', $roles))
            <li class="@yield('list_order')"><a class="menu-item" href="{{route('admin.order.list')}}"><i></i><span data-i18n="@yield('list_order')">Manage orders</span></a></li>
            @endif

            @if(hasAccessAbility('view_order', $roles))
            <li class="@yield('list_altered_order')"><a class="menu-item" href="{{route('admin.order_alter.list')}}"><i></i><span data-i18n="@yield('list_order')">Manage reviews</span></a></li>
            @endif

            {{-- @if(hasAccessAbility('view_booking', $roles))
            <li class="@yield('booking_list')"><a class="menu-item" href="{{ route('admin.booking.list') }}"><span data-i18n="@yield('booking_list')">@lang('left_menu.booking_list')</span></a></li>
            @endif
            @if(hasAccessAbility('view_order', $roles))
            <li class="@yield('list_default_order')"><a class="menu-item" href="{{route('admin.order_default.list')}}"><i></i><span data-i18n="@yield('list_default_order')">Default & Cancel Order</span></a></li>
            @endif


            @if(hasAccessAbility('new_search_booking', $roles))
            <li class="@yield('new_search_booking')"><a class="menu-item" href="{{route('admin.booking.search_create')}}"><i></i><span data-i18n="@yield('new_search_booking')">Search & Book</span></a></li>
            @endif --}}

        </ul>
    </li>
    @endif

    @if(hasAccessAbility('view_offer_management', $roles))
    <li class=" nav-item @yield('offer_management')">
        <a href="#"><i class="fas fa-gifts"></i>
            <span class="menu-title" data-i18n="@yield('offer_management')">Promotions</span>
        </a>
        <ul class="menu-content">
            <li class="@yield('offer_group')">
                <a class="menu-item" href="{{route('admin.offergroup.list')}}"><i></i>
                    <span data-i18n="">Campain</span>
                </a>
            </li>
            <li class="@yield('offer_list')">
                <a class="menu-item" href="{{route('admin.offer.list')}}"><i></i>
                    <span data-i18n="">Bundles</span>
                </a>
            </li>
            <li class="@yield('offer_primary_list')">
                <a class="menu-item" href="{{route('admin.offer_primary.list')}}"><i></i>
                    <span data-i18n="">Coupons</span>
                </a>
            </li>
            <li class="@yield('offer_secondary_list')">
                <a class="menu-item" href="{{route('admin.offer_secondary.list')}}"><i></i>
                    <span data-i18n="">Free shipping</span>
                </a>
            </li>
            {{-- <li class="@yield('offer_type')">
                <a class="menu-item" href="{{route('admin.offer_type.list')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.offer_type')</span>
                </a>
            </li> --}}
        </ul>
    </li>
    @endif


    @if(hasAccessAbility('view_payment_section', $roles))
    <li class="nav-item @yield('Payment')">
        <a href="#"><i class="la la-dollar" aria-hidden="true"></i><span class="menu-title" data-i18n="Calendars">Finance</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_bank_state', $roles))
            <li class=" nav-item @yield('bankstatement')"><a class="menu-item" href="{{ route('admin.bankstate.list') }}"><i></i><span data-i18n="Basic">Account statements</span></a></li>
            @endif

            @if(hasAccessAbility('view_bank_to_bank', $roles))
            <li class="@yield('bank_to_bank_xfer')"><a class="menu-item" href="{{route('admin.account_to_bank_list.view')}}"><i></i><span data-i18n="@yield('bank_to_bank_xfer')">Order overview</span></a></li>
            @endif

            @if(hasAccessAbility('view_merchant_payment', $roles))
            <li class=" nav-item @yield('merchant_payment_list')"><a class="menu-item" href="{{ route('merchant.payment.list') }}"><i></i><span data-i18n="Basic">Transaction overview</span></a></li>
            @endif

            {{-- @if(hasAccessAbility('view_merchant_bill', $roles))
            <li class=" nav-item @yield('merchant_bill')"><a class="menu-item" href="{{ route('admin.mer_bill.list') }}"><i></i><span data-i18n="Basic">Merchant Bill</span></a></li>
            @endif

            @if(hasAccessAbility('view_payment', $roles))
            <li class=" nav-item @yield('payment_list')"><a class="menu-item" href="{{ route('admin.payment.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_list')</span></a></li>
            @endif

            @if(hasAccessAbility('payment_verification', $roles))
            <li class=" nav-item @yield('payment_verification')"><a class="menu-item" href="{{ route('admin.bankstate.verification') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_verification')</span></a></li>
            @endif

            @if(hasAccessAbility('view_refund', $roles))
            <li class="nav-item @yield('view_refund')"><a class="menu-item" href="{{ route('admin.customer.refund') }}"><i></i><span data-i18n="Basic">Refund (Customer)</span></a></li>
            @endif
            @if(hasAccessAbility('view_refund', $roles))
            <li class="nav-item @yield('view_reseller_refund')"><a class="menu-item" href="{{ route('admin.seller.refund') }}"><i></i><span data-i18n="Basic">Refund (Reseller)</span></a></li>
            @endif --}}

            {{-- <li class=" nav-item @yield('payment_entry')"><a class="menu-item" href="{{ route('admin.payment.create') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_entry')</span></a></li> --}}

{{--
            @if(hasAccessAbility('view_bank_to_other', $roles))
            <li class="@yield('bank_to_other_xfer')"><a class="menu-item" href="{{route('admin.account_to_other_list.view')}}"><i></i><span data-i18n="@yield('bank_to_other_xfer')">Third Party Payments</span></a></li>
            @endif --}}


        </ul>
    </li>
    @endif

    @if(hasAccessAbility('view_admin_support', $roles))
    <li class="nav-item @yield('Admin support')"><a href="#"><i class="fas fa-tasks"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Admin support</span></a>

        <ul class="menu-content">
            @if(hasAccessAbility('view_help_center', $roles))
                <li class="@yield('view_help_center')">
                    <a class="menu-item" href="{{route('admin.all_product.list')}}"><i></i>
                        <span data-i18n="">Help center</span>
                    </a>
                </li>
            @endif
            @if(hasAccessAbility('contact_us', $roles))
                <li class="@yield('contact_us')">
                    <a class="menu-item" href="{{route('admin.all_product.list')}}"><i></i>
                        <span data-i18n="">Cotact us</span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endif


    @if(hasAccessAbility('view_shipment_section', $roles))
    <li class=" nav-item @yield('Shipping')">
        <a href="#"><i class="fas fa-shipping-fast"></i></i>
            <span class="menu-title" data-i18n="@yield('Shipping')">@lang('left_menu.shipping')</span>
        </a>
        <ul class="menu-content">

            {{-- <li class="@yield('add_shipping')">
                <a class="menu-item" href="{{route('admin.shipment.create')}}"><i></i>
                    <span data-i18n="">@lang('left_menu.add_shipping')</span>
                </a>
            </li> --}}
            @if(hasAccessAbility('view_shipment', $roles))
            <li class="@yield('list_shipping')">
                <a class="menu-item" href="{{route('admin.shipment.list')}}"><i></i>
                    <span data-i18n="">Deliveryman list</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_shipment_processing', $roles))
            <li class="@yield('processing_shipping')">
                <a class="menu-item" href="{{route('admin.shipment.processing')}}"><i></i>
                    <span data-i18n="">Shipment process</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_shipping_address', $roles))
            <li class="@yield('shipping_address')">
                <a class="menu-item" href="{{route('admin.shipping-address.list')}}"><i></i>
                    <span data-i18n="">Trace order</span>
                </a>
            </li>
            @endif
            {{-- @if(hasAccessAbility('view_shipment_signature', $roles))
            <li class="@yield('shipment_sign')">
                <a class="menu-item" href="{{ route('admin.shipment-signature.list') }}"><i></i>
                    <span data-i18n="">@lang('left_menu.shipment_sign')</span>
                </a>
            </li>
            @endif --}}
        </ul>
    </li>
    @endif




























    {{--
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
                <a class="menu-item" href="{{route('admin.invoice')}}{{ Auth::user()->F_MERCHANT_NO > 0 ? '?invoice_for=merchant' : '?invoice_for=azuramart' }}"><i></i>
                <span data-i18n="@yield('invoice')">@lang('left_menu.invoice')</span>
                </a>
            </li>
            @endif

            @if(hasAccessAbility('view_invoice_processing', $roles))
            <li class="@yield('stock_processing')">
                <a class="menu-item" href="{{route('admin.invoice_processing')}}{{ Auth::user()->F_MERCHANT_NO > 0 ? '?invoice_for=merchant' : '?invoice_for=azuramart' }}"><i></i>
                <span data-i18n="@yield('stock_processing')">Stocks</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_vat_processing', $roles))
            <li class="@yield('vat_processing')">
                <a class="menu-item" href="{{route('admin.vat_processing', ['invoice_for' => 'azuramart'])}}"><i></i>
                <span data-i18n="@yield('vat_processing')">@lang('left_menu.vat_processing')</span>
                </a>
            </li>
            @endif
            @if(hasAccessAbility('view_payment_processing', $roles))
            <li class=" nav-item @yield('payment_processing')"><a class="menu-item" href="{{ route('admin.payment_processing.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_processing')</span></a></li>
            @endif



        </ul>
    </li>
    @endif
    --}}

{{--
    @if(hasAccessAbility('view_warehouse_section', $roles))
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
                <a class="menu-item" href="{{route('admin.not_box.list')}}{{ Auth::user()->F_MERCHANT_NO > 0 ? '?invoice_for=merchant' : '?invoice_for=azuramart' }}"><i></i>
                    <span data-i18n="">@lang('left_menu.not_box_list')</span>
                </a>
            </li>
            @endif


        </ul>
    </li>
    @endif --}}

    {{-- @if(hasAccessAbility('view_seller', $roles))
    <li class="nav-item  @yield('Seller Management')"><a href="#"><i class="fas fa-users-cog"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Seller Management</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_seller', $roles))
            <li class="@yield('seller_list')"><a class="menu-item" href="{{route('admin.seller.list')}}"><i></i><span data-i18n="seller_list">Seller list</span></a></li>
            @endif

        </ul>
    </li>
    @endif --}}


    {{-- @if(hasAccessAbility('view_customer', $roles))
    <li class="nav-item  @yield('Customer Management')"><a href="#"><i class="fas fa-users-cog"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Customers</span></a>
        <ul class="menu-content">
            <li class="@yield('add_customer')"><a class="menu-item" href="{{route('admin.customer.create')}}"><i></i><span data-i18n="@lang('left_menu.add_customer')r">Add Customer</span></a></li>
            @if(hasAccessAbility('view_customer', $roles))
            <li class="@yield('customer_list')"><a class="menu-item" href="{{route('admin.customer.list')}}"><i></i><span data-i18n="@lang('left_menu.customer_list')">@lang('left_menu.customer_list')</span></a></li>
            @endif
            <li class="@yield('reseller_add')"><a class="menu-item" href="{{route('admin.seller.create')}}"><i></i><span data-i18n="@lang('left_menu.reseller_list')">@lang('left_menu.add_reseller')</span></a></li>
            @if(hasAccessAbility('view_reseller', $roles))
            <li class="@yield('reseller_list')"><a class="menu-item" href="{{route('admin.seller.list')}}"><i></i><span data-i18n="@lang('left_menu.reseller_list')">@lang('left_menu.reseller_list')</span></a></li>
            @endif

            @if(hasAccessAbility('view_merchant', $roles))
            <li class="@yield('merchant_list')">
                <a class="menu-item" href="{{route('admin.merchant.list')}}"><i></i>
                    <span data-i18n="">Merchant List</span>
                </a>
            </li>
            @endif

        </ul>
    </li>
    @endif --}}
{{--
    @if(hasAccessAbility('view_customer_notification', $roles))
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




    {{-- @if(hasAccessAbility('view_dispatch_management', $roles))
    <li class=" nav-item @yield('Dispatch Management')"><a href="#"><i class="la la-truck"></i><span class="menu-title" data-i18n="@lang('left_menu.dispatch_management')">Dispatch Management</span></a>
        <ul class="menu-content">
            @if(hasAccessAbility('view_dispatch', $roles))
            <li class="@yield('list_dispatch')"><a class="menu-item" href="{{route('admin.dispatch.list',['dispatch' => 'rts'])}}"><i></i><span data-i18n="@yield('list_dispatch')">Dispatch List</span></a></li>
            @endif
            @if(hasAccessAbility('view_dispatched', $roles))
            <li class="@yield('dispatched_list')"><a class="menu-item" href="{{route('admin.dispatched.list')}}"><span data-i18n="@yield('dispatched_list')">Dispatched List</span></a></li>
            @endif
            @if(hasAccessAbility('view_notify_sms', $roles))
            <li class="@yield('notify_sms')"><a class="menu-item" href="{{route('admin.notify_sms.list')}}"><span data-i18n="@yield('notify_sms')">Notification SMS</span></a></li>
            @endif
            @if(hasAccessAbility('view_notify_email', $roles))
            <li class="@yield('notify_email')"><a class="menu-item" href="{{route('admin.notify_email.list')}}"><span data-i18n="@yield('notify_email')">Notification Email</span></a></li>
            @endif
            @if(hasAccessAbility('view_pending_app_dispach', $roles))
            <li class="@yield('view_pending_app_dispach')"><a class="menu-item" href="{{route('admin.pending_by_app.dispatch-list')}}"><span data-i18n="@yield('view_pending_app_dispach')">Pending App Dispatch</span></a></li>
            @endif
            @if(hasAccessAbility('view_item_return_request', $roles))
            <li class="@yield('item_return_request_list')"><a class="menu-item" href="{{route('admin.return_request.list')}}"><span data-i18n="@yield('item_return_request_list')">Return Request List</span></a></li>
            @endif

            @if(hasAccessAbility('view_batch_collected', $roles))
            <li class="@yield('view_batch_list_collected')"><a class="menu-item" href="{{route('admin.batch_collected.list')}}"><span data-i18n="@yield('view_batch_list_collected')">RTS Batch List</span></a></li>
            @endif

            @if(hasAccessAbility('view_order_collect', $roles))
            <li class="@yield('order_collect_list')"><a class="menu-item" href="{{route('admin.order_collect.list')}}"><span data-i18n="@yield('order_collect_list')">Order Collect List</span></a></li>
            @endif
            @if(hasAccessAbility('view_batch_collect', $roles))
            <li class="@yield('view_batch_list')"><a class="menu-item" href="{{route('admin.batch_collect.list')}}"><span data-i18n="@yield('view_batch_list')">RTS Batch List</span></a></li>
            @endif
        </ul>
    </li>
    @endif --}}

    {{-- <li class=" nav-item"><a href="{{route('product.inventory.list')}}"><i class="la la-calendar"></i><span class="menu-title" data-i18n="Calendars">@lang('left_menu.inventory')</span></a>
    </li> --}}

    @if(hasAccessAbility('view_sales_report_section', $roles))
    <li class="nav-item  @yield('Sales Report')"><a href="#"><i class="ft-bar-chart"></i><span class="menu-title" data-i18n="@lang('left_menu.customer')">Reports</span></a>
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
            @endif --}}

            @if(hasAccessAbility('view_collection_list', $roles))
            <li class="@yield('view_bank_collection')"><a class="menu-item" href="{{route('admin.collection.list')}}"><span data-i18n="@yield('view_bank_collection')">COD payment Position</span></a></li>
            @endif

            {{-- @if(hasAccessAbility('yet_to_ship', $roles))
            <li class="@yield('yet_to_ship')"><a class="menu-item" href="{{route('admin.yet_to_ship.list')}}"><span data-i18n="@yield('yet_to_ship')">Yet to Ship</span></a></li>
            @endif --}}

        </ul>
    </li>
    @endif



    <li class=" navigation-header"><span data-i18n="Settings">Settings</span><i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right" data-original-title="Settings" ></i>
    </li>
    @if(hasAccessAbility('view_seller_management', $roles))
        <li class=" nav-item @yield('Seller Mangement')">
            <a href="#"><i class="ft-users"></i><span class="menu-title"data-i18n="@lang('left_menu.seller_management')">Seller Management<span></a>
            <ul class="menu-content">
                @if(hasAccessAbility('view_seller_user', $roles))
                    <li class="@yield('seller-user')">
                        <a href="{{ route('seller.seller-user') }}"><span class="menu-title"data-i18n="@lang('left_menu.seller_user')">Seller</span></a>
                    </li>
                @endif
                @if(hasAccessAbility('view_user_group', $roles))
                    <li class=" nav-item @yield('seller-user-group')">
                        <a href="{{ route('seller.user-group') }}">
                            <span class="menu-title" data-i18n="@lang('left_menu.user_category')">Seller Group</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    @if(hasAccessAbility('view_seller_permission', $roles))
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
    @endif
    @if(hasAccessAbility('view_account_management', $roles))
    <li class=" nav-item @yield('Accounts')">
        <a href="#"><i class="fas fa-money-check"></i><span class="menu-title" data-i18n="Calendars">Account Management</span></a>
        <ul class="menu-content">

            @if(hasAccessAbility('view_account_source', $roles))
            <li class=" nav-item @yield('Payment Management')"><a class="menu-item" href="{{route('admin.account.list')}}"><i></i><span data-i18n="Basic">Source Account Method</span></a></li>
            @endif

            @if(hasAccessAbility('view_payment_bank', $roles))
            <li class=" nav-item @yield('payment_bank')"><a class="menu-item" href="{{route('admin.payment_bank.list')}}"><i></i><span data-i18n="Basic">@lang('left_menu.payment_bank')</span></a></li>
            @endif

            {{-- <li><a class="menu-item" href="#"><i></i><span data-i18n="Basic">@lang('left_menu.others')</span></a>
                <ul class="menu-content">
                    <li class="@yield('vat')"><a class="menu-item" href="#!"><i></i><span data-i18n="Basic">@lang('left_menu.Vat')</span></a></li>
                    <li class="@yield('Account Name')"><a class="menu-item" href="#!"><i></i><span data-i18n="Basic">@lang('left_menu.Name')</span></a></li>
                    <li class="@yield('product model')"><a class="menu-item" href="#!"><i></i><span data-i18n="Extra">@lang('left_menu.Method')</span></a></li>
                </ul>
            </li> --}}
        </ul>
    </li>
    @endif
    @if(hasAccessAbility('view_system_settings', $roles))
        <li class=" nav-item @yield('System Settings')">
            <a href="#">
                <i class="la la-cogs"></i>
                <span class="menu-title"
                      data-i18n="@lang('left_menu.system_settings')">System Settings</span>
            </a>
            <ul class="menu-content">
                @if(hasAccessAbility('view_address_type', $roles))
                <li class="@yield('address_type')"><a class="menu-item" href="{{route('admin.address_type.list')}}"><i></i><span data-i18n="@lang('left_menu.address_type')">@lang('left_menu.address_type')</span></a></li>
                @endif
                @if(hasAccessAbility('view_apilist', $roles))
                <li class="@yield('api_list')"><a class="menu-item" href="{{route('admin.apilist.list')}}"><i></i><span data-i18n="Basic">API List</span></a></li>
                @endif
                @if(hasAccessAbility('view_currency', $roles))
                <li class=" nav-item @yield('currency')"><a class="menu-item" href="{{ route('admin.currency.list') }}"><i></i><span data-i18n="Basic">@lang('left_menu.currency')</span></a></li>
                @endif
                @if(hasAccessAbility('view_city_list', $roles))
                <li class="@yield('city_list')"><a class="menu-item" href="{{route('admin.address.city_list')}}"><i></i><span data-i18n="Basic">City List</span></a>
                </li>
                @endif
                @if(hasAccessAbility('view_postage_list', $roles))
                <li class="@yield('postage_list')"><a class="menu-item" href="{{route('admin.address_type.postage_list_')}}"><i></i><span data-i18n="Basic">Postage List</span></a>
                </li>
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
                <a class="menu-item" href="{{route('web.slider')}}"><i></i>

                    <span data-i18n="">Gallery</span>

                </a>
            </li>

            <li class="@yield('home_page')">
                <a class="menu-item" href="{{route('web.home.setting')}}"><i></i>
                    <span data-i18n="">Home Page Setting</span>
                </a>
            </li>


            @if(hasAccessAbility('view_web_custom_link', $roles))
            <li class="@yield('custom link')">
                <a class="menu-item" href="{{route('web.home.custom_link')}}"><i></i>
                    <span data-i18n="">Custom Link Highlighter</span>
                </a>
            </li>
            @endif
        </ul>
        <ul class="menu-content">
            <li class="@yield('blog-category')">
                <a class="menu-item" href="{{route('web.blog.category')}}"><i></i>
                    <span data-i18n="@yield('blog-category')">Blog Category</span>
                </a>
            </li>
            <li class="@yield('article')">
                <a class="menu-item" href="{{route('web.blog.article')}}"><i></i>
                    <span data-i18n="@yield('blog-article')">Blog Article</span>
                </a>
            </li>
            <li class="@yield('pages')">
                <a class="menu-item" href="{{route('web.page')}}"><i></i>
                    <span data-i18n="@yield('pages')">Pages</span>
                </a>
            </li>
            <li class="@yield('subscribers')">
                <a class="menu-item" href="{{route('web.subscriber')}}"><i></i>
                    <span data-i18n="@yield('subscriber')">Subscriber</span>
                </a>
            </li>
            <li class="@yield('contact')">
                <a class="menu-item" href="{{route('web.contact')}}"><i></i>
                    <span data-i18n="@yield('contact')">Contact Message</span>
                </a>
            </li>
            <li class="@yield('faq')">
                <a class="menu-item" href="{{route('web.faq')}}"><i></i>
                    <span data-i18n="@yield('faq')">Faq</span>
                </a>
            </li>
            {{-- <li class="@yield('about')">
                <a class="menu-item" href="{{route('web.about')}}"><i></i>
                    <span data-i18n="@yield('about')">About</span>
                </a>
            </li> --}}
            <li class="@yield('settings')">
                <a class="menu-item" href="{{route('web.home.settings')}}"><i></i>
                    <span data-i18n="@yield('settings')">Settings</span>
                </a>
            </li>
            <li class="@yield('whatsapp')">
                <a class="menu-item" href="{{route('web.whatsapp')}}"><i></i>
                    <span data-i18n="@yield('whatsapp')">WhatsApp</span>
                </a>
            </li>

            {{-- <li class="@yield('mail')">
                <a class="menu-item" href="{{route('web.mail.index')}}"><i></i>
                    <span data-i18n="@yield('mail')">Email Config</span>
                </a>
            </li> --}}
        </ul>


    </li>
    @endif

</ul>
