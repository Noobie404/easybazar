<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AdminAccessServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    public function registerBindings()
    {
        $repos = [
            'Account',
            'Agent',
            'Booking',
            'Seller',
            'CustomerAddress',
            'AccountMethod',
            'Bank',
            'UserGroup',
            'PermissionGroup',
            'Permission',
            'Role',
            'Auth',
            'Dashboard',
            'AdminUser',
            'ProductModel',
            'Product',
            'Vendor',
            'Invoice',
            'InvoiceDetails',
            'Brand',
            'Color',
            'ProductSize',
            'Category',
            'SpCategory',
            'Hscode',
            'Customer',
            'Order',
            'Shipment',
            'Address',
            'Box',
            'Shelve',
            'Slider',
            'Datatable',
            'Currency',
            'Payment',
            'Offer',
            'OfferGroup',
            'OfferType',
            'Packaging',
            'ShippingAddress',
            'ShipmentSign',
            'OfferPrimary',
            'OfferSecondary',
            'PaymentBank',
            'Faulty',
            'Dispatch',
            'BankState',
            'NotifySms',
            'SalesReport',
            'DeliveryBoy',
            'SearchBooking',
            'Notification',
            'NewArival',
            'Merchant',
            'MerchantBill',
            'Page',
            'ProductAttribute',
            'ProductFeature',
            'Coupon',
            'Stock',
            'Cart',
        ];

        foreach ($repos as $repo) {
            $this->app->bind("App\Repositories\Admin\\{$repo}\\{$repo}Interface", "App\Repositories\Admin\\{$repo}\\{$repo}Abstract");
        }
    }

}
