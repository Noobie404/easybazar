<?php
return [

    'return_reason' => [
        '0'     =>'nothing',
        '10'    => 'Item does not fit me',
        '20'    => 'Item has missing freebie',
        '30'    => 'I received the wrong item',
        '40'    => 'I did not order this size',
        '50'    => 'Don\'t want the item anymore',
        '60'    => 'Item is defective or not working',
        '70'    => 'Item does not match description or picture',
        '80'    => 'Item or accessory is missing in the package',
        '90'    => 'Item is damaged/broken/has dent or scratches',
    ],

    'booking_status' => [
        '10'    => 'Ordered',
        '20'    => 'Cancel request',
        '30'    => 'Cancelled',
        '50'    => 'Confirmed',
        '70'    => 'Ready to dispatch',
        '80'    => 'Dispatched',
        '85'    => 'Shipped',
        '90'    => 'Delivered',
        '100'   => 'Customer acknowladged',
        '110'   => 'Customer returned',
    ],
    'booking_status_notice' => [
        '10'    => 'Your order has been placed. Thank you for shopping at Easybazar!',
        '20'    => 'Cancel request placed',
        '30'    => 'Your order has been Cancelled',
        '50'    => 'Your order has been successfully verified.',
        '70'    => 'Your order Ready to dispatch',
        '80'    => 'Your order Dispatched',
        '90'    => 'Your order Delivered',
        '100'   => 'Customer acknowladged',
        '110'   => 'Customer returned',
    ],


    'price_used' => [
        'REGULAR_PRICE'     => 'REGULAR_PRICE',
        'SPECIAL_PRICE'     => 'SPECIAL_PRICE',
        'WHOLESALE_PRICE'   => 'WHOLESALE_PRICE',
        // 'INSTALLMENT_PRICE' => 'INSTALLMENT_PRICE',

    ],

    'refund_reason' => [
        'Out of Stock' => 'Out of Stock',
        'Defect/Faulty' => 'Defect/Faulty',
        'Waiting too long' => 'Waiting too long',
    ],


    'return_condition' => [
        1 => 'Sellable - Full refund + postage',
        4 => 'Sellable - Partial refund penalty',
        2 => 'Partial Damage - Full refund + postage',
        3 => 'Non Sellable - Refund full',
        5 => 'Partial Damage - Refund discount amount',
        6 => 'Non Sellable - Full refund + postage',
    ],


'product_attr_type' => [
        1 => 'Text',
        2 => 'Dropdown',
        3 => 'Multiselect',
        4 => 'Number',
    ],

'product_feature_type' => [
        1 => 'Dropdown',
        2 => 'Multiselect',
    ],
]
?>
