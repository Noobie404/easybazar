<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/_ignition/health-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.healthCheck',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/execute-solution' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.executeSolution',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/share-report' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.shareReport',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/data-test' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'data-test',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/clear' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'clear',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login_as' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.login_as',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/translate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.dashboard.translate',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/postDashboardNote' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.dashboard.note.post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/branch-admin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.branch-admin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin-users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.admin-user',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin-user/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.admin-user.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin-user/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.admin-user.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user-group' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.user-group',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user-group/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.user-group.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user-group/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.user-group.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/assign-access' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.assign-access',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.assign-access.post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/role' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.role',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/role/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.role.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/role/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.role.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/permission-group' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission-group',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/permission-group/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission-group.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/permission-group/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission-group.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/permission' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/permission/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/permission/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/branch/users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.branch-user',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/all_product' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.all_product',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/pending_master' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.pending_master',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/pending_varint_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.pending_varint',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-search-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.searchlist',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.searchlist.view.post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master-variant/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.update.masterVariant',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.master_search',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/swap' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.update.masterVariant.swap',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/pending' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.pending',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/pending_varint' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.varint.pending',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product_variant/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product_variant.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/branch-products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.branch-products',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/variant-by-master' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'variant-by-master',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/store_to_shop' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.storeToShop',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/get-shop-master' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'get_shop_master',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/shop-variant-status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shop-variant-status',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/refresh-product-attribute-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZnkTIKH68iU1IO58',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product_search',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/search-back' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.add_to_mother_page',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/get-category-child' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6TugyiVSc5WK9a2Q',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category-related-attributes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZYdyubVJv0quDX5V',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-attribute-childs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XJqRJHtLu5iwZ50N',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-feature-options-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2w7qWouQZMWck88N',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-generate-variants-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YQ4F2cWEeK6NWM8s',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-additional-category-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::klV6toAepcRhsVIo',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/add-additional-category-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dlpcpoETiUJQhVvR',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-product-attribute-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VPKVCsrprJM7GSDT',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/add-product-spcategory-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ppwXSDiHqZ6Km8ep',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-product-spcategory-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::hcZgGctiRDJDdOuf',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/if-product-master-in-shop' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'seller.product.if.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/if-product-variant-in-shop' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'seller.variant.if.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/if-product-category-in-shop' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'seller.category.if.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/store-product-master-variant-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::aoJxF5f4HQf02GNp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delivery/delivery_schedule' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery.delivery_schedule',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/get-schedule-create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery.schedule-create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/delivery/schedule_store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery.schedule_store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/schedule/generate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.schedule.generate',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-attribute' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-attribute/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-attribute-store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-attribute-child' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr-child.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/addUpdateChild' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr-child.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/update-attribute-order' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr-child.update.ajax',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-feature' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-feature/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-feature-store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-feature-child' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature-child.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/addUpdateFeature' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature.update.ajax',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/addUpdateFeatureChilds' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature-child.update.ajax',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/update-feature-order' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature-order.update.ajax',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/showFeatureChilds' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature-child.view',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.source.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account-bank' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.bank.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account-bank/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.bank.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account-bank/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.bank.store.single',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/accounts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.accounts.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/accounts/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.accounts.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/accounts/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.accounts.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/accounts/balance_transfer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.balance_transfer',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/accounts/balance_transfer/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.balance_transfer.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/accounts/balance_history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.balance_history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payments/purchase' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payments.purchase',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payments/purchase/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payments.purchase.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payments/non_purchase' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payments.non_purchase',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account-method/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.method.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/all_reseller' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::27QM3hKuuYPg2PBZ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/seller_user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.user_store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/seller_area' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller_area.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/vendors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vendor',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/vendors/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vendor.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/vendors/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vendor.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoice' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoice/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice.list',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoice/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoice/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/merchant_invoice_pdf_permission' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.merchant.invoice.access',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoice-details/variant/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-details.variant-list',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoice_processing' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice_processing',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoice_processing/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice_processing.list',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoice_processing/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice_processing.new',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/vat-processing' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vat_processing',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/vat-processing/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vat_processing.list',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/spcategory' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.spcategory.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/spcategory/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.spcategory.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/spcategory/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.spcategory.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/spcategory-slug/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.spcategory.slug.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.category.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.category.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.category.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/cancelrequest' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.cancelrequest',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order-altered' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order_alter.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/default-order' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order_default.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/default-order-action' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order_default_action.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/default-order-penalty' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order_default_penalty.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/canceled' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.canceled',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/booking/all_booking' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.all_order',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/cancel_order' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.cancel_order',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/altered_order' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.altered_order',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/default_order' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.default_order',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/default_order_action' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.default_order_action',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/default_order_penalty' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.default_order_penalty',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order_admin_hold' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order_admin_hold',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order_self_pickup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order_self_pickup',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/rtc-transfer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.rtc_transfer',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/rtc-transfer-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.rtc_transfer_ajax',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/generate-billplz-url' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.generate_billplz_url',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/confirm-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.dispatch.confirm-list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ready-to-dispatch' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.dispatch.ready_to_dispatch',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dispatched' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.dispatched.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delivered' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivered.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cancel-request-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.cancel-request-list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/collect-order-datatable' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order_collect.datalist',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/collect-item-datatable' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.item_collect.datalist',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/collected-item-datatable' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.item_collected.datalist',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/collection-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.collection.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/hscode' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.hscode.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/hscode/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.hscode.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/hscode/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.hscode.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/billplz-payout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer_seller.billplzPayout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payout-status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qsl16EZZWEoKOYyv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'POST' => 1,
            'HEAD' => 2,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/customer/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/customer/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.ajaxStore',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/blance-transfer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.blance_transfer',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/store/booking' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.store.booking',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/user-orderList-datatable' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.my-orders.datatable',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/refund' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.refund',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/refund/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.paymentrefund.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/refundrequest/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.refundrequeststore',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/refundrequest' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.refundrequest',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/refunded' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.refunded',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/refund' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.refund',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/refundrequest' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.refundrequest',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/refunded' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.refunded',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/refundrequest/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.refundrequeststore',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/refund/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.paymentrefund.store.reseller',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/user-orderList-datatable' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.my-orders.datatable',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer-address' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer-address.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer-address/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer-address.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer-address/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer-address.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/address/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.delete',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-post-code' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer-address.creates',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address-type' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address_type.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address-type/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address_type.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address-type/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address_type.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address-type-post-code/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address_type.postage_list_',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/city_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.city_list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/new_city' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.city_store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/edit_city' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.city_update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/get-city-create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.get-city',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/region_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.region_list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/get-region-create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.get-region',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/new_region' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.region_store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/edit_region' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.region_update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/get-area-create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.get-area',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/area_create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.area_create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/area_update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.area_update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/sub_area' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.sub_area',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/area_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.area_list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/new_map' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.map_store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/map_update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.map_update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/map' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.map',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/get-map-create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.map_create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delivery_boy/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/delivery-boy/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delivery_boy/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delivery-boy/delivery-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.delivery_list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delivery-man/bulk-assign' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery-man.bulkAssign',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-delivery-cost' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.delivery_cost',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/search-&-book' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/booking/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/booking/store-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.store-ajax',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/booking' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/assign-deliveryman' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.assign-deliveryman',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-prd-details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.getproduct.details',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/booking/bulk_update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.bulk_update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web-cart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.cart.web-cart',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-customer-info' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.info',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/customer/get-cart-details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.get-cart-details',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/flat-discount' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.flat-discount',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/coupon-discount' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.coupon-discountt',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/remove-coupon' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.remove-coupon',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/update-apply-coupon' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.update-apply-coupon',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/search-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.search-list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/add-to-cart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.add-to-cart',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/delete-to-cart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delete-to-cart',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/update-cart-qty' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.update-cart-qty',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/search-customer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.search-customer',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-customer-details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.getcustomer.details',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/call-procedure-booking' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.procedure',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/address/coordinator' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.coordinator',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/update_order_payment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking_to_order_payment_ajax.book-order',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/postCustomerAddress' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking_to_order_ajax.postCustomerAddress',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/postCustomerAddress2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customerAddress.add',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/postPaymentUncheck' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking_to_order_ajax.postPaymentUncheck',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/getStockExchangeInfo-exchange' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.post_booking_to_order_stock_exchange_ajax',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payment/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payment/update-partial' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.updatepartial',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payment-processing' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment_processing.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-to-other-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_other_list.view',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/add-new-type' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_other.type.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-to-other-store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_other.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-to-bank-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_bank_list.view',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-to-bank-store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_bank.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-to-other-list-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_other_ajax.list',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-to-bank-list-ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_bank_ajax.list',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/postAccountBalanceInfo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account.bank.balance',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-state' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bankstate.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-bank-state' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.getbankstate.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-state/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bankstate.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-state/delete_bulk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bankstate.delete_bulk',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-state/draft-to-save' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bankstate.draft_to_save',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-state/mark-as-used' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bankstate.mark_as_used',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-state/verification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bankstate.verification',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/bank-state/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bankstate.verify',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/get-variant-info-like' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.get-variant-info-like',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/stock-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.all_product.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-details-modal-invoice' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.details_invoice.modal',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/currency' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currency.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currency.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/all_customer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pVbw2y3lolmA2rbF',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/refundlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uKR7Ftrc7cymiksG',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/refundlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::L37yE3RkoMktxbkS',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/refundedList' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Z0IdBe2osSuGK9CV',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/refundedList' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qAvllEqnnxQ9B1Kd',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/refundrequestlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CHsCd0U7TrPv8eCS',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/seller/refundrequestlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::K8lguIU1RG5LEm69',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/all_product_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ew1NMUccAstWRPcM',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/unshelved_product_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AhVxOciWT2bUNQQF',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shelved_product_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::t3EXdd7IOaw7jKXN',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/boxed_product_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::hNeN11pj3nwDPGky',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/not_boxed_product_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5hwNZxid2zkombpX',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sales_comission_report' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cPFtyFTQFyMtCyLm',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sales_comission_report_list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::BbKjmjWZ9nYXxg5E',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-type' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_type.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-type/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_type.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-type/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_type.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-group' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offergroup.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-group/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offergroup.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-group/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offergroup.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-list/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-list/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-primary-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-primary-list/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-primary-list/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-primary-list/store_product' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.store_product',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-primary-list/add-productlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.productlist',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-secondary-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-secondary-list/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-secondary-list/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-secondary-list/store_product' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.store_product',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/offer-secondary-list/add-productlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.productlist',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/coupon-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.coupon.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/coupon/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.coupon.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/coupon/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.coupon.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/coupon/search-product' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.coupon.search',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/coupon/get-master-variants' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.coupon.master_variant',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/apply-coupon' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.apply-coupon',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shipping-address' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.shipping-address.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shipping-address/new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.shipping-address.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shipping-address/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.shipping-address.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notification/email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notify_email.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notification/email/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notify_email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notification/sms' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notify_sms.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notification/all_notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notify_sms.all_notification',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newarival' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.newarival.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get_newarival' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.get_newarival',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newarival/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.newarival.create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newarival/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.newarival.delete',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newarival-variant/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.newarival.variant.delete',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newarival/orderid_update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.newarival.orderid_update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newarival-variant/orderid_update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.na_variant.orderid_update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-newarival-master' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'get-newarival-master',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newarival-master/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.newarival_master.create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newarival-variant/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.newarival_variant.create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sales-report' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.sales_report.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/yet-to-ship' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.yet_to_ship.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/top-sell' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/top-sell/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell.delete',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/top-sell-variant/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell_variant.delete',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/top-sell/orderid_update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell.orderid_update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/top-sell-variant/orderid_update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell_variant.orderid_update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-topsell-master' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'get-topsell-master',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/top-sell/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell.create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/top-sell-master/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell_master.create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/report/top-sell-variant/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell_variant.create',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get_top_sell' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.get_top_sell',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dispathed/returned' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.return_request.list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dispathed/return-request' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.return-request',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/order/return' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.return',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/confirm-return' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.confirm-return',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/documentaion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.documentation',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/documentation-view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.documentation-view',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/documentation/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.documentation.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/text-editor/image' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.text-editor.image',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mail/config' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.mail.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mail/env-update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'env_key_update.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/home/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/home/settings/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.settings.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/home/custom-link' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.custom_link',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/home/custom-link/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.custom_link.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-custom-link-title' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.custom_link.get_titles',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/home/custom-link/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.custom_link.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/slider/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/slider' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/slider/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/slider/featureStatus' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.featureStatus',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/slider/add_photo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.add_photo',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/home/setting' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.setting',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/home_setting/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home_setting.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/home_setting/slider_update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home_setting.sliderUpdate',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/blog/article' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.article',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/blog/article/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.article.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/blog/article/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.article.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ajax/text-editor/image-upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.text-editor.image',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/blog/category' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.category',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/blog/category/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.category.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/blog/category/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.category.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/page' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.page',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/page/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.page.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/page/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.page.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/faq' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.faq',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/faq/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.faq.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/faq/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.faq.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.notification',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/notification/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.notification.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/notification/bulksend' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.notification.bulksend',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/web-notification/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.web-notification.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/notification/web-push' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.notification.web-push',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/notification/image-upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.notification.image-upload',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/notification/device-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.notification.device-list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/subscriber' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.subscriber',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web/contact' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.contact',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/notification/save-token' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'notification.save-token',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/_ignition/s(?|cripts/([^/]++)(*:37)|tyles/([^/]++)(*:58))|/user(?|/([^/]++)/(?|single\\-edit(*:99)|update(?:/([^/]++))?(*:126))|\\-group/([^/]++)/(?|edit(*:159)|update(*:173)|delete(*:187)))|/b(?|ranch\\-admin/([^/]++)/(?|edit(*:231)|users(*:244))|ank_acc/([^/]++)(*:269)|ooking/([^/]++)/(?|edit(*:300)|view(*:312)|d(?|ownload_pdf(*:335)|elete(*:348))|update(*:363)))|/a(?|d(?|min\\-user/([^/]++)/(?|edit(*:408)|update(*:422))|dress\\-type(?|/([^/]++)/(?|edit(*:462)|update(*:476)|delete(*:490))|\\-(?|post\\-code(?:/([^/]++))?(*:528)|city(?:/([^/]++))?(*:554))))|jax/(?|schedule\\-delete/([^/]++)(*:597)|get\\-(?|c(?|overage\\-area\\-delete/([^/]++)(*:647)|ity\\-(?|edit/([^/]++)(*:676)|delete/([^/]++)(*:699)|by\\-region/([^/]++)(*:726)))|sub(?|category/([^/]++)(*:759)|area\\-by\\-area/([^/]++)(*:790))|region\\-(?|edit/([^/]++)(*:823)|delete/([^/]++)(*:846))|area\\-(?|edit/([^/]++)(*:877)|delete/([^/]++)(*:900)|by\\-city/([^/]++)(*:925))|map\\-(?|edit/([^/]++)(*:955)|delete/([^/]++)(*:978))|polygon\\-delete/([^/]++)(*:1011)|delivery\\-man/([^/]++)(*:1042))|customer/edit/([^/]++)(*:1074)|address/(?|create/([^/]++)(*:1109)|edit/([^/]++)(*:1131))|delivery\\-(?|boy/(?|edit/([^/]++)(*:1174)|delete/([^/]++)(*:1198))|area/delete/([^/]++)(*:1228)))|ccount(?|/([^/]++)/(?|delete(*:1267)|update(*:1282))|\\-(?|bank/([^/]++)/(?|update(*:1320)|delete(*:1335))|method/([^/]++)/(?|update(*:1370)|delete(*:1385)))|s/([^/]++)/(?|transaction(*:1421)|edit(*:1434)|update(*:1449)))|gent/([^/]++)/edit(*:1478))|/r(?|ole/([^/]++)/(?|edit(*:1513)|update(*:1528)|delete(*:1543))|evert\\-default\\-order/([^/]++)(*:1583))|/p(?|ermission(?|\\-group/([^/]++)/(?|edit(*:1634)|update(*:1649)|delete(*:1664))|/([^/]++)/(?|edit(*:1691)|update(*:1706)|delete(*:1721)))|rod(?|uct(?|\\-(?|list/([^/]++)/(?|view(*:1770)|edit(*:1783))|attribute(?|\\-(?|child/([^/]++)(*:1824)|update/([^/]++)(*:1848)|delete/([^/]++)(*:1872))|/edit/([^/]++)(*:1896))|feature(?|\\-(?|child/([^/]++)(*:1935)|update/([^/]++)(*:1959)|delete/([^/]++)(*:1983))|/edit/([^/]++)(*:2007))|variant/search/([^/]++)(*:2040))|/(?|([^/]++)/(?|edit(*:2070)|view(*:2083)|update(*:2098)|delete(*:2113)|pending_varint_edit(*:2141))|variant/([^/]++)/view(*:2172))|_variant/([^/]++)/(?|update(*:2209)|delete(*:2224)))|_(?|img_delete/([^/]++)(*:2258)|subcategory/([^/]++)(*:2287)))|arent\\-root/([^/]++)(*:2318)|ost\\-address\\-type\\-(?|city/([^/]++)(*:2363)|postage/([^/]++)(*:2388)))|/get(?|_(?|brand_model_by_scat/([^/]++)(*:2438)|hscode_by_scat(?:/([^/]++))?(*:2475))|\\-parent\\-attributes/([^/]++)(*:2514)|/([^/]++)/remainingcustomerbalance(*:2557)|Customer(?|AddressEdit/([^/]++)/([^/]++)(?:/([^/]++))?(*:2620)|ByName/([^/]++)(?:/([^/]++))?(*:2658)))|/s(?|eller/(?|([^/]++)/(?|edit(*:2699)|update(*:2714)|payment\\-history(*:2739)|view(*:2752)|business_doc_delete(*:2780))|ajax/get\\-coverage\\-area\\-create/([^/]++)(*:2831)|refundrequest/([^/]++)/deny(*:2867)|([^/]++)/(?|refund/([^/]++)(*:2903)|history(*:2919))|reseller\\-details/([^/]++)(*:2955)|([^/]++)/(?|address\\-book(*:2989)|orders(*:3004)|payments(*:3021)|balance(*:3037))|orders/view/([^/]++)(*:3067))|pcategory/([^/]++)/(?|edit(*:3103)|update(*:3118)|delete(*:3133))|hop_cat_add_remove/([^/]++)/([^/]++)/([^/]++)(*:3188))|/vendors/([^/]++)/(?|edit(*:3223)|view(*:3236)|update(*:3251)|delete(*:3266))|/i(?|nvoice(?|/(?|getpurchaser/([^/]++)(*:3315)|([^/]++)/(?|edit(*:3340)|update(*:3355)|product(*:3371)|delete(*:3386))|stock/([^/]++)/delete(*:3417))|\\-(?|details/(?|new/([^/]++)(*:3455)|([^/]++)(?|(*:3475)|/delete(*:3491))|variant/([^/]++)/list/([^/]++)(*:3531)|([^/]++)/product(*:3556)|store(*:3570))|product\\-details/([^/]++)/([^/]++)(*:3614)|qbentry/([^/]++)(*:3639)|loyalty\\-claime/([^/]++)(*:3672)|vat\\-claime/([^/]++)(*:3701)|to\\-stock/([^/]++)(*:3728)))|mvoice_img_delete/([^/]++)/([^/]++)(*:3774))|/c(?|ategory/([^/]++)/(?|edit(*:3813)|update(*:3828)|delete(*:3843))|ollection\\-list/([^/]++)(*:3877)|ustomer(?|/(?|([^/]++)/(?|edit(*:3916)|payment\\-history(*:3941)|update(*:3956))|delete/([^/]++)(*:3981)|([^/]++)/(?|view(*:4006)|history(?|(*:4025)|2(*:4035))|address\\-book(*:4058)|orders(*:4073)|payments(*:4090)|balance(*:4106))|orders/view/([^/]++)(*:4136)|customer\\-details/([^/]++)(*:4171)|([^/]++)/refund/([^/]++)(*:4204)|refundrequest/([^/]++)/deny(*:4240))|\\-address/([^/]++)/(?|new(*:4275)|edit(*:4288)|delete(*:4303))|_(?|state/([^/]++)(*:4331)|city(?|/([^/]++)(*:4356)|_by_state/([^/]++)(*:4383))|p(?|Code/([^/]++)/([^/]++)(*:4419)|ostage_by_city/([^/]++)(*:4451)))))|/order/([^/]++)/(?|cancel(*:4489)|d(?|elete(*:4507)|ispatch(?|(*:4526)|store(*:4540))))|/hscode/([^/]++)/(?|edit(*:4576)|update(*:4591)|delete(*:4606))|/delivery(?|_boy/([^/]++)/update(*:4648)|\\-boy/([^/]++)/(?|view(*:4679)|area\\-(?|list(*:4701)|store(*:4715)))|address/([^/]++)/update(*:4749))|/([^/]++)/get\\-variant\\-info(*:4787)|/b(?|ook(?|ing(?|/(?|([^/]++)/check\\-offer(*:4838)|getCustomerAddress/([^/]++)/([^/]++)(?:/([^/]++)(?:/([^/]++))?)?(*:4911))|\\-to\\-order/([^/]++)(?|(*:4944)|/admin\\-approved(*:4969)))|order/getPayInfo/([^/]++)/([^/]++)(*:5014))|ank\\-(?|to\\-(?|other(?:/([^/]++))?(*:5058)|bank(?:/([^/]++))?(*:5085))|state/([^/]++)/(?|delete(*:5119)|unverify(*:5136))))|/o(?|rder(?|booking/([^/]++)/book\\-order(*:5188)|/(?|senderaddress/([^/]++)/update(*:5230)|receiveraddress/([^/]++)/update(*:5270)|([^/]++)/admin\\-approval(*:5303))|payment/([^/]++)/delete(*:5336))|ffer\\-(?|type/([^/]++)/(?|edit(*:5376)|update(*:5391)|delete(*:5406))|group/([^/]++)/(?|edit(*:5438)|update(*:5453)|delete(*:5468))|list/([^/]++)/(?|edit(*:5499)|update(*:5514)|delete(*:5529))|primary\\-list/([^/]++)/(?|edit(*:5569)|view(*:5582)|update(*:5597)|delete(?|(*:5615)|\\-product(*:5633))|add\\-product(*:5655))|secondary\\-list/([^/]++)/(?|edit(*:5697)|view(*:5710)|update(*:5725)|delete(?|(*:5743)|\\-product(*:5761))|add\\-product(*:5783))))|/de(?|lete(?|_book_to_order_item/([^/]++)(?:/([^/]++)(?:/([^/]++))?)?(*:5864)|/([^/]++)(*:5882))|fault\\-order\\-penalty/([^/]++)(*:5922))|/c(?|heckifCustomerAddressexists/([^/]++)/([^/]++)(?:/([^/]++))?(*:5996)|oupon/([^/]++)/(?|edit(*:6027)|update(*:6042)|delete(*:6057)|view(*:6070)))|/p(?|ostUpdatedAddress/([^/]++)/([^/]++)(*:6121)|a(?|yment/(?|new(?:/([^/]++)(?:/([^/]++))?)?(*:6174)|([^/]++)/de(?|tails(*:6202)|lete(*:6215)))|rty\\-transfer\\-details/([^/]++)(*:6257)))|/ge(?|t(?|StockExchangeInfo/([^/]++)(*:6304)|\\-(?|newarival\\-variant/([^/]++)(*:6345)|topsell\\-variant/([^/]++)(*:6379))|_(?|newarival_v(?|iew/([^/]++)(*:6419)|ariant/([^/]++)(*:6443))|top_sell_v(?|iew/([^/]++)(*:6478)|ariant/([^/]++)(*:6502)))|options/([^/]++)/([^/]++)/([^/]++)/([^/]++)/([^/]++)(*:6565))|llery/delete/([^/]++)(*:6596))|/internal\\-transfer\\-details/([^/]++)(*:6643)|/lost\\-product(?:/([^/]++)(?:/([^/]++)(?:/([^/]++))?)?)?(*:6708)|/faulty\\-checker/([^/]++)/([^/]++)/([^/]++)(*:6760)|/s(?|tock\\-(?|details/([^/]++)(*:6799)|price/([^/]++)/view(*:6827))|hipping\\-address/([^/]++)/(?|edit(*:6870)|update(*:6885)|delete(*:6900))|ignature_img_delete/([^/]++)(*:6938)|ales\\-(?|report/([^/]++)(*:6971)|comission\\-list\\-view/([^/]++)/([^/]++)(*:7019))|lider/delete\\-photo/([^/]++)(*:7057))|/update(?:/([^/]++))?(*:7088)|/n(?|otification/(?|email/view/([^/]++)(*:7136)|([^/]++)/(?|email\\-send(*:7168)|sms\\-send(*:7186)))|ewarival(?|/([^/]++)/view(*:7222)|\\-variant/([^/]++)/list(*:7254)))|/top\\-sell(?|/([^/]++)/(?|view(*:7295)|pdf(*:7307))|\\-variant/([^/]++)/list(*:7340))|/home/custom\\-link/(?|edit/([^/]++)(*:7385)|([^/]++)/(?|update(*:7412)|delete(*:7427)))|/web/(?|slider/(?|edit/([^/]++)(*:7469)|([^/]++)/(?|update(*:7496)|delete(*:7511))|order\\-(?|up/([^/]++)(*:7542)|down/([^/]++)(*:7564))|photo/update/([^/]++)(*:7595))|blog/(?|article/([^/]++)/(?|edit(*:7637)|update(*:7652)|delete(*:7667))|category/([^/]++)/(?|edit(*:7702)|update(*:7717)|delete(*:7732)))|page/(?|([^/]++)/(?|edit(*:7767)|update(*:7782)|delete(*:7797))|order\\-(?|up/([^/]++)(*:7828)|down/([^/]++)(*:7850)))|faq/([^/]++)/(?|edit(*:7881)|update(*:7896)|delete(*:7911))))/?$}sDu',
    ),
    3 => 
    array (
      37 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.scripts',
          ),
          1 => 
          array (
            0 => 'script',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      58 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.styles',
          ),
          1 => 
          array (
            0 => 'style',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      99 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.user.loggedin.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      126 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.user.update',
            'single' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'single',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      159 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.user-group.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      173 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.user-group.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      187 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.user-group.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      231 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.branch-admin.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      244 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.branch.user_create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      269 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bank_acc',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      300 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      312 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      335 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.download_pdf',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      348 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      363 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      408 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.admin-user.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      422 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.admin-user.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      462 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address_type.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      476 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address_type.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      490 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address_type.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      528 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address_type.postage_view_',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      554 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address_type.city_list',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      597 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery.delete-schedule',
          ),
          1 => 
          array (
            0 => 'schedule_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      647 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.coverage_area_delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      676 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.get_city',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      699 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.city_delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      726 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.get_city_region',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      759 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.category.get-subcategory',
          ),
          1 => 
          array (
            0 => 'category_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      790 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.subarea.map_create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      823 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.edit_region',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      846 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.region_delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      877 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.area_edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      900 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.area_delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      925 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.get_area',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      955 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.map_edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      978 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.map_delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1011 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.polygon.polygon_delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1042 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.edit_delivery_boy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1074 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.edit.ajax',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1109 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.create',
          ),
          1 => 
          array (
            0 => 'customer_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1131 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.address.edit',
          ),
          1 => 
          array (
            0 => 'address_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1174 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1198 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1228 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery-area.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1267 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.source.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1282 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.source.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1320 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.bank.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1335 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.name.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1370 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.bank.method.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1385 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'account.method.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1421 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.accounts.transaction',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1434 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.accounts.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1449 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.accounts.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1478 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.agent.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1513 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.role.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1528 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.role.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1543 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.role.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1583 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order_revert.default',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1634 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission-group.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1649 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission-group.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1664 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission-group.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1691 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1706 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1721 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.permission.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1770 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.searchlist.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1783 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.searchlist.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1824 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr-child.new',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1848 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1872 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1896 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-attr.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1935 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature-child.new',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1959 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1983 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2007 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-feature.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2040 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product-search',
          ),
          1 => 
          array (
            0 => 'bar_code',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2070 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2083 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2098 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2113 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2141 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.pending_varint.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2172 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'seller.product.variant.store.index',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2209 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product_variant.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2224 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product_variant.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2258 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.product.img_delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2287 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.prod_subcategory.',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2318 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admn.customer.root',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2363 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer_address_city.put',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2388 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer_address_postage.put',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2438 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'brand_model_list_by_scat',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2475 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'get_hscode_by_scat',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2514 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.category.get-attribute',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2557 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.remainingcustomerbalance',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2620 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer-address.order_edit',
            'is_reseller' => NULL,
          ),
          1 => 
          array (
            0 => 'customer_id',
            1 => 'id',
            2 => 'is_reseller',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2658 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer-address.order_getcusinfo',
            'type' => NULL,
          ),
          1 => 
          array (
            0 => 'customer_name',
            1 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2699 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2714 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2739 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.payment_history',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2752 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2780 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.business_doc_delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2831 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.get_coverage_area_create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2867 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.refundrequest_deny',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2903 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.refund.reseller',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2919 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.history',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2955 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.reseller-details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2989 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.address-book',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3004 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.orders',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3021 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.payments',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3037 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.seller.balance',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3067 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reseller.orders.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3103 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.spcategory.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3118 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.spcategory.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3133 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.spcategory.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3188 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.shop_cat_add_remove',
          ),
          1 => 
          array (
            0 => 'shop_id',
            1 => 'cat_id',
            2 => 'mode',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3223 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vendor.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3236 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vendor.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3251 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vendor.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3266 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vendor.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3315 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice.getpurchaser',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3340 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3355 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3371 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice.get-product',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3386 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3417 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.stock.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3455 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-details.new',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3475 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3491 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-details.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3531 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-details.bar-code/variant-list',
          ),
          1 => 
          array (
            0 => 'bar_code',
            1 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3556 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-details.get-product',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3570 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-details.store',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3614 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-product-details.get-product',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3639 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-qbentry',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3672 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.loyalty-claime',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3701 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.vat-claime',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3728 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoice-to-stock',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3774 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.imvoice_img_delete',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'invoice_for',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3813 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.category.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3828 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.category.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3843 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.category.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3877 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.collection.list.breakdown',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3916 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3941 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.payment_history',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3956 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3981 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4006 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4025 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.history',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4035 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.history2',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4058 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.address-book',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4073 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.orders',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4090 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.payments',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4106 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.balance',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4136 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.orders.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4171 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.customer-details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4204 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.refund',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4240 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer.refundrequest_deny',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4275 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer-address.create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4288 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer-address.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4303 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer-address.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4331 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer_state',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4356 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer_city',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4383 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer_city_by_state',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4419 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer_pCode',
          ),
          1 => 
          array (
            0 => 'city_id',
            1 => 'state_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4451 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.customer_postage_by_city',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4489 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.cancel',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4507 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4526 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.dispatch',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4540 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.order.dispatchstore',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4576 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.hscode.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4591 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.hscode.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4606 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.hscode.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4648 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4679 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4701 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.area_list',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4715 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delivery_boy.area_list.store',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4749 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.deliveryaddress.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4787 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.product',
          ),
          1 => 
          array (
            0 => 'branch_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4838 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking.checkoffer',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4911 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bookingtoorder.getCustomerAddress',
            'address_id' => NULL,
            'reseller_id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'pk_no',
            2 => 'address_id',
            3 => 'reseller_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4944 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking_to_order.create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4969 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bookingtoorder.admin-approved',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5014 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bookingtoorder.getPayInfo',
          ),
          1 => 
          array (
            0 => 'order_id',
            1 => 'is_reseller',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5058 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_other.view',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5085 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_bank.view',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5119 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bankstate.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5136 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bankstate.unverify',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5188 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking_to_order.book-order',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5230 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.senderaddress.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5270 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.receiveraddress.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5303 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking_to_order.admin-approval',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5336 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.orderpayment.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5376 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_type.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5391 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_type.update',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5406 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_type.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5438 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offergroup.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5453 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offergroup.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5468 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offergroup.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5499 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5514 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer.update',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5529 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5569 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5582 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.view',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5597 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.update',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5615 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5633 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.deleteproduct',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5655 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_primary.add_product',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5697 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5710 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.view',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5725 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.update',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5743 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5761 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.deleteproduct',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5783 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.offer_secondary.add_product',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5864 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking_to_order_delete_ajax.book-order',
            'type' => NULL,
            'booking_no' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'type',
            2 => 'booking_no',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5882 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currency.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5922 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.default.order.penalty',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5996 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bookingtoorder.checkifCustomerAddressexists',
            'book_id' => NULL,
          ),
          1 => 
          array (
            0 => 'customer_id',
            1 => 'type',
            2 => 'book_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6027 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.coupon.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6042 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.coupon.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6057 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.coupon.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6070 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.coupon.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6121 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking_to_order_ajax.postUpdatedAddress',
          ),
          1 => 
          array (
            0 => 'order_id',
            1 => 'type',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6174 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.create',
            'id' => NULL,
            'type' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6202 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6215 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6257 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_other.details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6304 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.booking_to_order_stock_exchange_ajax',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6345 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'get-newarival-variant',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6379 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'get-topsell-variant',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6419 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.get_newarival_view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6443 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.get_newarival_variant',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6478 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.get_top_sell_view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6502 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.get_top_sell_variant',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6565 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.getoptions',
          ),
          1 => 
          array (
            0 => 'table',
            1 => 'key',
            2 => 'val',
            3 => 'cond_col',
            4 => 'cond_val',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6596 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.gellery.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6643 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.account_to_bank.details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6708 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.faulty.list',
            'type' => NULL,
            'id' => NULL,
            'dispatched' => NULL,
          ),
          1 => 
          array (
            0 => 'type',
            1 => 'id',
            2 => 'dispatched',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6760 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.faulty.put',
          ),
          1 => 
          array (
            0 => 'type',
            1 => 'id',
            2 => 'faulty_type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6799 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.details.modal',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6827 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.stock_price.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6870 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.shipping-address.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6885 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.shipping-address.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6900 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.shipping-address.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6938 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.signature.img_delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6971 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.sales_report.list-item',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7019 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.sales_report.list-item-ajax',
          ),
          1 => 
          array (
            0 => 'agent_id',
            1 => 'date',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7057 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.slider.delete_photo',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7088 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.currency.update',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7136 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notify_email.body',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7168 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notify_email.send',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7186 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.notify_sms.send',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7222 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.newarival.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7254 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.newarival_variant.list',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7295 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell.view',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7307 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell.pdf',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7340 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.top_sell_variant.list',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7385 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.custom_link.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7412 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.custom_link.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7427 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.home.custom_link.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7469 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7496 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7511 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7542 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.order-up',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7564 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.order-down',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7595 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.slider.photo_update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7637 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.article.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7652 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.article.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7667 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.article.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7702 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.category.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7717 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.category.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7732 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.blog.category.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7767 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.page.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7782 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.page.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7797 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.page.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7828 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.page.order-up',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7850 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.page.order-down',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      7881 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.faq.edit',
            'id' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7896 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.faq.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      7911 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web.faq.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'ignition.healthCheck' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/health-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Facade\\Ignition\\Http\\Middleware\\IgnitionEnabled',
        ),
        'uses' => 'Facade\\Ignition\\Http\\Controllers\\HealthCheckController@__invoke',
        'controller' => 'Facade\\Ignition\\Http\\Controllers\\HealthCheckController',
        'as' => 'ignition.healthCheck',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.executeSolution' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/execute-solution',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Facade\\Ignition\\Http\\Middleware\\IgnitionEnabled',
          1 => 'Facade\\Ignition\\Http\\Middleware\\IgnitionConfigValueEnabled:enableRunnableSolutions',
        ),
        'uses' => 'Facade\\Ignition\\Http\\Controllers\\ExecuteSolutionController@__invoke',
        'controller' => 'Facade\\Ignition\\Http\\Controllers\\ExecuteSolutionController',
        'as' => 'ignition.executeSolution',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.shareReport' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/share-report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Facade\\Ignition\\Http\\Middleware\\IgnitionEnabled',
          1 => 'Facade\\Ignition\\Http\\Middleware\\IgnitionConfigValueEnabled:enableShareButton',
        ),
        'uses' => 'Facade\\Ignition\\Http\\Controllers\\ShareReportController@__invoke',
        'controller' => 'Facade\\Ignition\\Http\\Controllers\\ShareReportController',
        'as' => 'ignition.shareReport',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.scripts' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/scripts/{script}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Facade\\Ignition\\Http\\Middleware\\IgnitionEnabled',
        ),
        'uses' => 'Facade\\Ignition\\Http\\Controllers\\ScriptController@__invoke',
        'controller' => 'Facade\\Ignition\\Http\\Controllers\\ScriptController',
        'as' => 'ignition.scripts',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.styles' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/styles/{style}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Facade\\Ignition\\Http\\Middleware\\IgnitionEnabled',
        ),
        'uses' => 'Facade\\Ignition\\Http\\Controllers\\StyleController@__invoke',
        'controller' => 'Facade\\Ignition\\Http\\Controllers\\StyleController',
        'as' => 'ignition.styles',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'as' => 'admin.dashboard',
        'uses' => 'App\\Http\\Controllers\\Admin\\DashboardController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\DashboardController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'data-test' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'data-test',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'data-test',
        'uses' => 'App\\Http\\Controllers\\Admin\\DataTestController@dataTest',
        'controller' => 'App\\Http\\Controllers\\Admin\\DataTestController@dataTest',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'clear' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'clear',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'clear',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@clear',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@clear',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'login',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@getLogin',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@getLogin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.login_as' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login_as',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'admin.login_as',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@getLoginAs',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@getLoginAs',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'admin',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@postLogin',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@postLogin',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'logout',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@getLogout',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminAuthController@getLogout',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.dashboard.translate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'translate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'as' => 'admin.dashboard.translate',
        'uses' => 'App\\Http\\Controllers\\Admin\\DashboardController@postTrnaslate',
        'controller' => 'App\\Http\\Controllers\\Admin\\DashboardController@postTrnaslate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.dashboard.note.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'postDashboardNote',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'as' => 'admin.dashboard.note.post',
        'uses' => 'App\\Http\\Controllers\\Admin\\DashboardController@postDashboardNote',
        'controller' => 'App\\Http\\Controllers\\Admin\\DashboardController@postDashboardNote',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.user.loggedin.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/{id}/single-edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_user',
        ),
        'as' => 'admin.user.loggedin.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getEditSingle',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getEditSingle',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.user.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/{id}/update/{single?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_user',
        ),
        'as' => 'admin.user.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.branch-admin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'branch-admin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_branch_admin',
        ),
        'as' => 'admin.branch-admin',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getBranchAdmin',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getBranchAdmin',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.branch-admin.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'branch-admin/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_branch_admin',
        ),
        'as' => 'admin.branch-admin.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@editBranchAdmin',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@editBranchAdmin',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.branch.user_create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'branch-admin/{id}/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_branch_user',
        ),
        'as' => 'admin.branch.user_create',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getSellerUser',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getSellerUser',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.admin-user' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin-users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_admin_user',
        ),
        'as' => 'admin.admin-user',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.admin-user.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin-user/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_admin_user',
        ),
        'as' => 'admin.admin-user.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.admin-user.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin-user/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_admin_user',
        ),
        'as' => 'admin.admin-user.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.admin-user.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin-user/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_admin_user',
        ),
        'as' => 'admin.admin-user.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.admin-user.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin-user/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_admin_user',
        ),
        'as' => 'admin.admin-user.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.user-group' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user-group',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_user_group',
        ),
        'as' => 'admin.user-group',
        'uses' => 'App\\Http\\Controllers\\Admin\\UserGroupController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserGroupController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.user-group.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user-group/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_user_group',
        ),
        'as' => 'admin.user-group.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\UserGroupController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserGroupController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.user-group.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user-group/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_user_group',
        ),
        'as' => 'admin.user-group.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\UserGroupController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserGroupController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.user-group.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user-group/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_user_group',
        ),
        'as' => 'admin.user-group.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\UserGroupController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserGroupController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.user-group.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user-group/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_user_group',
        ),
        'as' => 'admin.user-group.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\UserGroupController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserGroupController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.user-group.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user-group/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_user_group',
        ),
        'as' => 'admin.user-group.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\UserGroupController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\UserGroupController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.assign-access' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'assign-access',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:assign_user_access',
        ),
        'as' => 'admin.assign-access',
        'uses' => 'App\\Http\\Controllers\\Admin\\AssignAccessController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\AssignAccessController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.assign-access.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'assign-access',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:assign_user_access',
        ),
        'as' => 'admin.assign-access.post',
        'uses' => 'App\\Http\\Controllers\\Admin\\AssignAccessController@postIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\AssignAccessController@postIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.role' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'role',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_role',
        ),
        'as' => 'admin.role',
        'uses' => 'App\\Http\\Controllers\\Admin\\RoleController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\RoleController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.role.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'role/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_role',
        ),
        'as' => 'admin.role.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\RoleController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\RoleController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.role.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'role/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_role',
        ),
        'as' => 'admin.role.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\RoleController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\RoleController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.role.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'role/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_role',
        ),
        'as' => 'admin.role.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\RoleController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\RoleController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.role.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'role/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_role',
        ),
        'as' => 'admin.role.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\RoleController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\RoleController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.role.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'role/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_role',
        ),
        'as' => 'admin.role.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\RoleController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\RoleController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission-group' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'permission-group',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_menu',
        ),
        'as' => 'admin.permission-group',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission-group.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'permission-group/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_menu',
        ),
        'as' => 'admin.permission-group.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission-group.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'permission-group/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_menu',
        ),
        'as' => 'admin.permission-group.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission-group.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'permission-group/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_menu',
        ),
        'as' => 'admin.permission-group.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission-group.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'permission-group/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_menu',
        ),
        'as' => 'admin.permission-group.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission-group.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'permission-group/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_menu',
        ),
        'as' => 'admin.permission-group.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionGroupController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'permission',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_action',
        ),
        'as' => 'admin.permission',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'permission/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_action',
        ),
        'as' => 'admin.permission.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'permission/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_action',
        ),
        'as' => 'admin.permission.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'permission/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_action',
        ),
        'as' => 'admin.permission.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'permission/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_action',
        ),
        'as' => 'admin.permission.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.permission.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'permission/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_action',
        ),
        'as' => 'admin.permission.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\PermissionController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\PermissionController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.branch-user' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'branch/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_branch_user',
        ),
        'as' => 'admin.branch-user',
        'uses' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getBranchUser',
        'controller' => 'App\\Http\\Controllers\\Admin\\AdminUserController@getBranchUser',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.all_product' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/all_product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product_list',
        ),
        'as' => 'admin.product.all_product',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getAllProduct',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getAllProduct',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.pending_master' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/pending_master',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_pending_master',
        ),
        'as' => 'admin.product.pending_master',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getPendingMaster',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getPendingMaster',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.pending_varint' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/pending_varint_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_pending_varint',
        ),
        'as' => 'admin.product.pending_varint',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getPendingVarint',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getPendingVarint',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.searchlist' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-search-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product_list',
        ),
        'as' => 'admin.product.searchlist',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getProductSearch',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getProductSearch',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.searchlist.view.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product-search-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product_list',
        ),
        'as' => 'admin.searchlist.view.post',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getProductSearchList',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getProductSearchList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.searchlist.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-list/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product_list',
        ),
        'as' => 'admin.product.searchlist.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.searchlist.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-list/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_list',
        ),
        'as' => 'admin.product.searchlist.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.update.masterVariant' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'master-variant/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_list',
        ),
        'as' => 'admin.update.masterVariant',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postMasterVariantView',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postMasterVariantView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.master_search' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'master/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_list',
        ),
        'as' => 'admin.master_search',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postMasterSearch',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postMasterSearch',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.update.masterVariant.swap' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'master/swap',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_list',
        ),
        'as' => 'admin.update.masterVariant.swap',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postVariantMasterSwap',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postVariantMasterSwap',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product',
        ),
        'as' => 'admin.product.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'admin.product.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'admin.product.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'as' => 'admin.product.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product',
        ),
        'as' => 'admin.product.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'as' => 'admin.product.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_product',
        ),
        'as' => 'admin.product.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.pending' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/pending',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_pending_master',
        ),
        'as' => 'admin.product.pending',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getPendingMaster',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getPendingMaster',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.varint.pending' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/pending_varint',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_pending_varint',
        ),
        'as' => 'admin.varint.pending',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getPendingVarint',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getPendingVarint',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.pending_varint.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/{id}/pending_varint_edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_pending_varint',
        ),
        'as' => 'admin.pending_varint.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@editPendingVarint',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@editPendingVarint',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product_variant.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product_variant/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product_variant',
        ),
        'as' => 'admin.product_variant.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postStoreProductVariant',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postStoreProductVariant',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product_variant.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product_variant/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_variant',
        ),
        'as' => 'admin.product_variant.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@putUpdateProductVariant',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@putUpdateProductVariant',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product_variant.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product_variant/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_product_variant',
        ),
        'as' => 'admin.product_variant.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getDeleteProductVariant',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getDeleteProductVariant',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.img_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prod_img_delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_variant',
        ),
        'as' => 'admin.product.img_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getDeleteImage',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getDeleteImage',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.prod_subcategory.' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prod_subcategory/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'product.prod_subcategory.',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getSubcat',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getSubcat',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'brand_model_list_by_scat' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get_brand_model_by_scat/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product',
        ),
        'as' => 'brand_model_list_by_scat',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getBrandModelByScat',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getBrandModelByScat',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.branch-products' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/branch-products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product',
        ),
        'as' => 'admin.product.branch-products',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getProAddToShop',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getProAddToShop',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'variant-by-master' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/variant-by-master',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product',
        ),
        'as' => 'variant-by-master',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getVariantByMasterAj',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getVariantByMasterAj',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.storeToShop' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/store_to_shop',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:product_assigned_to_shop',
        ),
        'as' => 'admin.product.storeToShop',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@storeToShop',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@storeToShop',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'get_shop_master' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/get-shop-master',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:branch-products',
        ),
        'as' => 'get_shop_master',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getShopMaster',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getShopMaster',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shop-variant-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/shop-variant-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:branch-products',
        ),
        'as' => 'shop-variant-status',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getShopVariantStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getShopVariantStatus',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'get_hscode_by_scat' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get_hscode_by_scat/{id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'get_hscode_by_scat',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getHscode',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getHscode',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZnkTIKH68iU1IO58' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'refresh-product-attribute-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postAjaxRefreshProductAttribute',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postAjaxRefreshProductAttribute',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ZnkTIKH68iU1IO58',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product_search' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product-search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'admin.product_search',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getProductSearchList',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getProductSearchList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.add_to_mother_page' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/search-back',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'admin.add_to_mother_page',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getProductSearchGoBack',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getProductSearchGoBack',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6TugyiVSc5WK9a2Q' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/get-category-child',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxCategoryChild',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxCategoryChild',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::6TugyiVSc5WK9a2Q',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZYdyubVJv0quDX5V' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'category-related-attributes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxCategoryAttr',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxCategoryAttr',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ZYdyubVJv0quDX5V',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XJqRJHtLu5iwZ50N' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get-attribute-childs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxAttrChilds',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxAttrChilds',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::XJqRJHtLu5iwZ50N',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2w7qWouQZMWck88N' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get-feature-options-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxFeaOptions',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxFeaOptions',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::2w7qWouQZMWck88N',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YQ4F2cWEeK6NWM8s' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get-generate-variants-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxVariantGenerate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getAjaxVariantGenerate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::YQ4F2cWEeK6NWM8s',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::klV6toAepcRhsVIo' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'delete-additional-category-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postAjaxDeleteAddtionalCategory',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postAjaxDeleteAddtionalCategory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::klV6toAepcRhsVIo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dlpcpoETiUJQhVvR' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'add-additional-category-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postAjaxAddAddtionalCategory',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postAjaxAddAddtionalCategory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::dlpcpoETiUJQhVvR',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VPKVCsrprJM7GSDT' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'delete-product-attribute-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postAjaxDeleteProductAttribute',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postAjaxDeleteProductAttribute',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::VPKVCsrprJM7GSDT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ppwXSDiHqZ6Km8ep' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'add-product-spcategory-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postSpcatStoreAjax',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postSpcatStoreAjax',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ppwXSDiHqZ6Km8ep',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::hcZgGctiRDJDdOuf' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'delete-product-spcategory-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postSpcatDeleteAjax',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postSpcatDeleteAjax',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::hcZgGctiRDJDdOuf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'seller.product.variant.store.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/variant/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'as' => 'seller.product.variant.store.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getVariantStoreView',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getVariantStoreView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'seller.product.if.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/if-product-master-in-shop',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'as' => 'seller.product.if.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postIfMasterStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postIfMasterStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'seller.variant.if.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/if-product-variant-in-shop',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'as' => 'seller.variant.if.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postIfVariantStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postIfVariantStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'seller.category.if.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/if-product-category-in-shop',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'as' => 'seller.category.if.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@postIfCategoryStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@postIfCategoryStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::aoJxF5f4HQf02GNp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'store-product-master-variant-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getProductVariantStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getProductVariantStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::aoJxF5f4HQf02GNp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery.delivery_schedule' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'delivery/delivery_schedule',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_model',
        ),
        'as' => 'admin.delivery.delivery_schedule',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery.schedule-create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-schedule-create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_model',
        ),
        'as' => 'admin.delivery.schedule-create',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery.schedule_store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/delivery/schedule_store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'as' => 'admin.delivery.schedule_store',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.schedule.generate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/schedule/generate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product',
        ),
        'as' => 'admin.schedule.generate',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@postGenerate',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@postGenerate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery.delete-schedule' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/schedule-delete/{schedule_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_model',
        ),
        'as' => 'admin.delivery.delete-schedule',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryScheduleController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-attribute',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product_attr',
        ),
        'as' => 'admin.product-attr.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getMasterIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getMasterIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-attribute/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_product_attr',
        ),
        'as' => 'admin.product-attr.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getMasterNew',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getMasterNew',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr-child.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-attribute-child/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_product_attr',
        ),
        'as' => 'admin.product-attr-child.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getChildNew',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getChildNew',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product-attribute-store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_product_attr',
        ),
        'as' => 'admin.product-attr.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@postMaster',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@postMaster',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-attribute/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_attr',
        ),
        'as' => 'admin.product-attr.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getMasterEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getMasterEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product-attribute-update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_attr',
        ),
        'as' => 'admin.product-attr.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@postMasterUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@postMasterUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-attribute-delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_product_attr',
        ),
        'as' => 'admin.product-attr.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getMasterDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getMasterDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr-child.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-attribute-child',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product_attr',
        ),
        'as' => 'admin.product-attr-child.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getChildIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@getChildIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr-child.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'addUpdateChild',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_product_attr',
        ),
        'as' => 'admin.product-attr-child.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@postChildAddUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@postChildAddUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-attr-child.update.ajax' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'update-attribute-order',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_product_attr',
        ),
        'as' => 'admin.product-attr-child.update.ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@postChildOrderUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductAttrController@postChildOrderUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-feature',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product_feature',
        ),
        'as' => 'admin.product-feature.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getMasterIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getMasterIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-feature/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_product_feature',
        ),
        'as' => 'admin.product-feature.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getMasterNew',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getMasterNew',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature-child.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-feature-child/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_product_feature',
        ),
        'as' => 'admin.product-feature-child.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getChildNew',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getChildNew',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product-feature-store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_product_feature',
        ),
        'as' => 'admin.product-feature.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postMaster',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postMaster',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-feature/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_feature',
        ),
        'as' => 'admin.product-feature.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getMasterEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getMasterEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product-feature-update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_feature',
        ),
        'as' => 'admin.product-feature.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postMasterUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postMasterUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-feature-delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_product_feature',
        ),
        'as' => 'admin.product-feature.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getMasterDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getMasterDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature-child.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-feature-child',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product_feature',
        ),
        'as' => 'admin.product-feature-child.index',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getChildIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@getChildIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature.update.ajax' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'addUpdateFeature',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_feature',
        ),
        'as' => 'admin.product-feature.update.ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postFeatureAddUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postFeatureAddUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature-child.update.ajax' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'addUpdateFeatureChilds',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_feature',
        ),
        'as' => 'admin.product-feature-child.update.ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postAddUpdateFeatureChilds',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postAddUpdateFeatureChilds',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature-order.update.ajax' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'update-feature-order',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_feature',
        ),
        'as' => 'admin.product-feature-order.update.ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postMasterOrderUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postMasterOrderUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-feature-child.view' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'showFeatureChilds',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:add_product_feature',
        ),
        'as' => 'admin.product-feature-child.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postShowFeatureChild',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductFeatureController@postShowFeatureChild',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_account_source',
        ),
        'as' => 'admin.account.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\AccountController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\AccountController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.source.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_account_source',
        ),
        'as' => 'account.source.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\AccountController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AccountController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_account_source',
        ),
        'as' => 'account.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AccountController@postAccSource',
        'controller' => 'App\\Http\\Controllers\\Admin\\AccountController@postAccSource',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.source.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_account_source',
        ),
        'as' => 'account.source.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\AccountController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\AccountController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.source.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_account_source',
        ),
        'as' => 'account.source.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AccountController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AccountController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.bank.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account-bank',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_account_name',
        ),
        'as' => 'account.bank.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankAccountController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankAccountController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.bank.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account-bank/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_account_name',
        ),
        'as' => 'account.bank.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankAccountController@getCreateBank',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankAccountController@getCreateBank',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.bank.store.single' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account-bank/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_account_name',
        ),
        'as' => 'account.bank.store.single',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankAccountController@postStoreSingle',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankAccountController@postStoreSingle',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.bank.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account-bank/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_account_name',
        ),
        'as' => 'account.bank.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankAccountController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankAccountController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.name.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account-bank/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_account_name',
        ),
        'as' => 'account.name.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankAccountController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankAccountController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.accounts.transaction' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts/{id}/transaction',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_accounts_transaction',
        ),
        'as' => 'admin.accounts.transaction',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@getTransaction',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@getTransaction',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.accounts.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_accounts',
        ),
        'as' => 'admin.accounts.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.accounts.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_accounts',
        ),
        'as' => 'admin.accounts.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.accounts.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'accounts/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_payment',
        ),
        'as' => 'admin.accounts.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.accounts.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_payment',
        ),
        'as' => 'admin.accounts.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.accounts.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'accounts/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_payment',
        ),
        'as' => 'admin.accounts.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@postEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@postEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.balance_transfer' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts/balance_transfer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_payment_bank',
        ),
        'as' => 'accounts.balance_transfer',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@balanceTransfer',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@balanceTransfer',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.balance_transfer.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts/balance_transfer/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_payment_bank',
        ),
        'as' => 'accounts.balance_transfer.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@balanceTransferCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@balanceTransferCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.balance_history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts/balance_history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_payment_bank',
        ),
        'as' => 'accounts.balance_history',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@balanceHistory',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@balanceHistory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payments.purchase' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payments/purchase',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_payment_purchase',
        ),
        'as' => 'payments.purchase',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@paymentPurchase',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@paymentPurchase',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payments.purchase.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payments/purchase/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_payment_purchase',
        ),
        'as' => 'payments.purchase.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@paymentPurchaseCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@paymentPurchaseCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payments.non_purchase' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payments/non_purchase',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_payment_bank',
        ),
        'as' => 'payments.non_purchase',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@paymentNonPurchase',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentBankController@paymentNonPurchase',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.bank.method.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account-method/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_payment_method',
        ),
        'as' => 'account.bank.method.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AccountMethodController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AccountMethodController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.method.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account-method/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_payment_method',
        ),
        'as' => 'account.method.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\AccountMethodController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\AccountMethodController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'account.method.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account-method/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_payment_method',
        ),
        'as' => 'account.method.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AccountMethodController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\AccountMethodController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.agent.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'agent/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_agent',
        ),
        'as' => 'admin.agent.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\AgentController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AgentController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::27QM3hKuuYPg2PBZ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/all_reseller',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@all_reseller',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@all_reseller',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::27QM3hKuuYPg2PBZ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_seller',
        ),
        'as' => 'admin.seller.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_seller',
        ),
        'as' => 'admin.seller.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_seller',
        ),
        'as' => 'admin.seller.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_seller',
        ),
        'as' => 'admin.seller.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_seller',
        ),
        'as' => 'admin.seller.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.user_store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/seller_user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_seller',
        ),
        'as' => 'admin.seller.user_store',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@postSellerUser',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@postSellerUser',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.payment_history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/payment-history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_seller',
        ),
        'as' => 'admin.seller.payment_history',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getPaymentHistory',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getPaymentHistory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_seller',
        ),
        'as' => 'admin.seller.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.business_doc_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/business_doc_delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_seller',
        ),
        'as' => 'admin.seller.business_doc_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@businesDocDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@businesDocDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller_area.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/seller_area',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_seller',
        ),
        'as' => 'admin.seller_area.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@postSellerAreaStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@postSellerAreaStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.get_coverage_area_create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/ajax/get-coverage-area-create/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_seller',
        ),
        'as' => 'admin.seller.get_coverage_area_create',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getCoverageAreaForm',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getCoverageAreaForm',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.coverage_area_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-coverage-area-delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_seller',
        ),
        'as' => 'admin.seller.coverage_area_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getCoverageAreaDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getCoverageAreaDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vendor' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'vendors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_vendor',
        ),
        'as' => 'admin.vendor',
        'uses' => 'App\\Http\\Controllers\\Admin\\VendorController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\VendorController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vendor.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'vendors/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_vendor',
        ),
        'as' => 'admin.vendor.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\VendorController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\VendorController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vendor.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'vendors/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_vendor',
        ),
        'as' => 'admin.vendor.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\VendorController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\VendorController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vendor.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'vendors/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_vendor',
        ),
        'as' => 'admin.vendor.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\VendorController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\VendorController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vendor.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'vendors/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_vendor',
        ),
        'as' => 'admin.vendor.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\VendorController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\VendorController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vendor.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'vendors/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_vendor',
        ),
        'as' => 'admin.vendor.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\VendorController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\VendorController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vendor.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'vendors/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_vendor',
        ),
        'as' => 'admin.vendor.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\VendorController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\VendorController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice',
        ),
        'as' => 'admin.invoice',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice.getpurchaser' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice/getpurchaser/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_invoice',
        ),
        'as' => 'admin.invoice.getpurchaser',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getPurchaser',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getPurchaser',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice.list' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoice/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice',
        ),
        'as' => 'admin.invoice.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@InvoiceList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@InvoiceList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_invoice',
        ),
        'as' => 'admin.invoice.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_invoice',
        ),
        'as' => 'admin.invoice.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoice/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_invoice',
        ),
        'as' => 'admin.invoice.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice.get-product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice/{id}/product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_invoice',
        ),
        'as' => 'admin.invoice.get-product',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getProductBySubCategory',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getProductBySubCategory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoice/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_invoice',
        ),
        'as' => 'admin.invoice.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_invoice',
        ),
        'as' => 'admin.invoice.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bank_acc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bank_acc/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_invoice',
        ),
        'as' => 'admin.bank_acc',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getBankAcc',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getBankAcc',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.imvoice_img_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'imvoice_img_delete/{id}/{invoice_for}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_invoice',
        ),
        'as' => 'admin.imvoice_img_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getImgDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getImgDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.merchant.invoice.access' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'merchant_invoice_pdf_permission',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_invoice',
        ),
        'as' => 'admin.merchant.invoice.access',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@postMerchantInvoicePdfAccess',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@postMerchantInvoicePdfAccess',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-details.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice-details/new/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_invoice_details',
        ),
        'as' => 'admin.invoice-details.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice_details',
        ),
        'as' => 'admin.invoice-details',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-details.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice-details/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_invoice_details',
        ),
        'as' => 'admin.invoice-details.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-details.variant-list' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoice-details/variant/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice_details',
        ),
        'as' => 'admin.invoice-details.variant-list',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getVariantListById',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getVariantListById',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-details.bar-code/variant-list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice-details/variant/{bar_code}/list/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice_details',
        ),
        'as' => 'admin.invoice-details.bar-code/variant-list',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getVariantListByBarCode',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getVariantListByBarCode',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-details.get-product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice-details/{id}/product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice_details',
        ),
        'as' => 'admin.invoice-details.get-product',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getProductBySubCategory',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getProductBySubCategory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-details.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoice-details/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_invoice_details',
        ),
        'as' => 'admin.invoice-details.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-product-details.get-product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice-product-details/{id}/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice_details',
        ),
        'as' => 'admin.invoice-product-details.get-product',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getProductByInvoice',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getProductByInvoice',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product-search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-variant/search/{bar_code}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice_details',
        ),
        'as' => 'admin.product-search',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getVariantListByQueryString',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceDetailsController@getVariantListByQueryString',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice_processing' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice_processing',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice_processing',
        ),
        'as' => 'admin.invoice_processing',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceProcessing',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceProcessing',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice_processing.list' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoice_processing/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice_processing',
        ),
        'as' => 'admin.invoice_processing.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@invoiceProcessingList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@invoiceProcessingList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.stock.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice/stock/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_invoice_processing',
        ),
        'as' => 'admin.stock.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getStockDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@getStockDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice_processing.new' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoice_processing/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_invoice_processing',
        ),
        'as' => 'admin.invoice_processing.new',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@postStoreInvoiceProcessing',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@postStoreInvoiceProcessing',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-qbentry' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice-qbentry/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_invoice',
        ),
        'as' => 'admin.invoice-qbentry',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceQBentry',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceQBentry',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.loyalty-claime' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice-loyalty-claime/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_invoice',
        ),
        'as' => 'admin.loyalty-claime',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceLoyaltyClaime',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceLoyaltyClaime',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vat-claime' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice-vat-claime/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_invoice',
        ),
        'as' => 'admin.vat-claime',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceVatClaime',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceVatClaime',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoice-to-stock' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoice-to-stock/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_invoice',
        ),
        'as' => 'admin.invoice-to-stock',
        'uses' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceToStock',
        'controller' => 'App\\Http\\Controllers\\Admin\\InvoiceController@invoiceToStock',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vat_processing' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'vat-processing',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_vat_processing',
        ),
        'as' => 'admin.vat_processing',
        'uses' => 'App\\Http\\Controllers\\Admin\\VatProcessingController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\VatProcessingController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.vat_processing.list' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'vat-processing/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_vat_processing',
        ),
        'as' => 'admin.vat_processing.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getVatProcessing',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getVatProcessing',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.spcategory.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'spcategory',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_special_category',
        ),
        'as' => 'product.spcategory.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.spcategory.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'spcategory/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_special_category',
        ),
        'as' => 'product.spcategory.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.spcategory.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'spcategory/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_special_category',
        ),
        'as' => 'product.spcategory.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.spcategory.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'spcategory/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_special_category',
        ),
        'as' => 'product.spcategory.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.spcategory.slug.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'spcategory-slug/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_special_category',
        ),
        'as' => 'product.spcategory.slug.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@postSlugUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@postSlugUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.spcategory.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'spcategory/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_special_category',
        ),
        'as' => 'product.spcategory.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.spcategory.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'spcategory/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_special_category',
        ),
        'as' => 'product.spcategory.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\SpCategoryController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.category.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_category',
        ),
        'as' => 'product.category.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\CategoryController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\CategoryController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.category.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_category',
        ),
        'as' => 'product.category.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\CategoryController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CategoryController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.category.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'category/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_category',
        ),
        'as' => 'product.category.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\CategoryController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\CategoryController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.category.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_category',
        ),
        'as' => 'product.category.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\CategoryController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\CategoryController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.category.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'category/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_category',
        ),
        'as' => 'product.category.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\CategoryController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CategoryController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.category.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_category',
        ),
        'as' => 'product.category.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\CategoryController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\CategoryController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.category.get-attribute' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-parent-attributes/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_category',
        ),
        'as' => 'product.category.get-attribute',
        'uses' => 'App\\Http\\Controllers\\Admin\\CategoryController@getParentAttributes',
        'controller' => 'App\\Http\\Controllers\\Admin\\CategoryController@getParentAttributes',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.shop_cat_add_remove' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shop_cat_add_remove/{shop_id}/{cat_id}/{mode}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_category',
        ),
        'as' => 'product.shop_cat_add_remove',
        'uses' => 'App\\Http\\Controllers\\Admin\\CategoryController@shopCatAddRemove',
        'controller' => 'App\\Http\\Controllers\\Admin\\CategoryController@shopCatAddRemove',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.category.get-subcategory' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-subcategory/{category_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_category',
        ),
        'as' => 'product.category.get-subcategory',
        'uses' => 'App\\Http\\Controllers\\Admin\\CategoryController@getSubcategory',
        'controller' => 'App\\Http\\Controllers\\Admin\\CategoryController@getSubcategory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.cancelrequest' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'order/cancelrequest',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order.cancelrequest',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@getCancelRequest',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@getCancelRequest',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/{id}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:cancel_order',
        ),
        'as' => 'admin.order.cancel',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@postCancel',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@postCancel',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order_alter.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'order-altered',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order_alter.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@getAlteredIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@getAlteredIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order_default.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'default-order',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order_default.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@getDefaultIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@getDefaultIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order_default_action.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'default-order-action',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order_default_action.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@getDefaultActionIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@getDefaultActionIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order_default_penalty.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'default-order-penalty',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order_default_penalty.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@getDefaultPenaltyIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@getDefaultPenaltyIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order_revert.default' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'revert-default-order/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.order_revert.default',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@getDefaultRevert',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@getDefaultRevert',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.canceled' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'order/canceled',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order.canceled',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@getCancelOrder',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@getCancelOrder',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_order',
        ),
        'as' => 'admin.order.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.all_order' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'booking/all_booking',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order.all_order',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getDatatableBooking',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getDatatableBooking',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.cancel_order' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/cancel_order',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order.cancel_order',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getCancelOrder',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getCancelOrder',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.altered_order' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/altered_order',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order.altered_order',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getAlteredOrder',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getAlteredOrder',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.default_order' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/default_order',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order.default_order',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getDefaultOrder',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getDefaultOrder',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.default_order_action' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/default_order_action',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order.default_order_action',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getDefaultOrderAction',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getDefaultOrderAction',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.default_order_penalty' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/default_order_penalty',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.order.default_order_penalty',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getDefaultOrderPenalty',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getDefaultOrderPenalty',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'order/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_order',
        ),
        'as' => 'admin.order.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order_admin_hold' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order_admin_hold',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_booking',
        ),
        'as' => 'admin.order_admin_hold',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@postAdminHold',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@postAdminHold',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order_self_pickup' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order_self_pickup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_booking',
        ),
        'as' => 'admin.order_self_pickup',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@postSelfPickup',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@postSelfPickup',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.rtc_transfer' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/rtc-transfer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.order.rtc_transfer',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@postSelfPickup',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@postSelfPickup',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.rtc_transfer_ajax' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/rtc-transfer-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.order.rtc_transfer_ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@postSelfPickupAjax',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@postSelfPickupAjax',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.generate_billplz_url' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'generate-billplz-url',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.order.generate_billplz_url',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@postGenerateBillplzUrl',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@postGenerateBillplzUrl',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.dispatch.confirm-list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'confirm-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_dispatch',
        ),
        'as' => 'admin.dispatch.confirm-list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DispatchController@getConfirmList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DispatchController@getConfirmList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.dispatch.ready_to_dispatch' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ready-to-dispatch',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_dispatch',
        ),
        'as' => 'admin.dispatch.ready_to_dispatch',
        'uses' => 'App\\Http\\Controllers\\Admin\\DispatchController@getReadyToDispatch',
        'controller' => 'App\\Http\\Controllers\\Admin\\DispatchController@getReadyToDispatch',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.dispatched.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dispatched',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_dispatched',
        ),
        'as' => 'admin.dispatched.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DispatchController@getDispatchedList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DispatchController@getDispatchedList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivered.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'delivered',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_delivered',
        ),
        'as' => 'admin.delivered.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DispatchController@getDeliveredList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DispatchController@getDeliveredList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.cancel-request-list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cancel-request-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_delivered',
        ),
        'as' => 'admin.cancel-request-list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DispatchController@getCancelRequestList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DispatchController@getCancelRequestList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.dispatch' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'order/{id}/dispatch',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_dispatch',
        ),
        'as' => 'admin.order.dispatch',
        'uses' => 'App\\Http\\Controllers\\Admin\\DispatchController@getDispatch',
        'controller' => 'App\\Http\\Controllers\\Admin\\DispatchController@getDispatch',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.dispatchstore' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/{id}/dispatchstore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_dispatch',
        ),
        'as' => 'admin.order.dispatchstore',
        'uses' => 'App\\Http\\Controllers\\Admin\\DispatchController@postDispatch',
        'controller' => 'App\\Http\\Controllers\\Admin\\DispatchController@postDispatch',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order_collect.datalist' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'collect-order-datatable',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order_collect',
        ),
        'as' => 'admin.order_collect.datalist',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getOrderCollection',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getOrderCollection',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.item_collect.datalist' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'collect-item-datatable',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_item_collect',
        ),
        'as' => 'admin.item_collect.datalist',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getItemCollection',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getItemCollection',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.item_collected.datalist' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'collected-item-datatable',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_item_collected',
        ),
        'as' => 'admin.item_collected.datalist',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getItemCollectedList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getItemCollectedList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.collection.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'collection-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_collection_list',
        ),
        'as' => 'admin.collection.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DispatchController@getCollectionList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DispatchController@getCollectionList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.collection.list.breakdown' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'collection-list/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_collection_list_breakdown',
        ),
        'as' => 'admin.collection.list.breakdown',
        'uses' => 'App\\Http\\Controllers\\Admin\\DispatchController@getCollectionListBreakdown',
        'controller' => 'App\\Http\\Controllers\\Admin\\DispatchController@getCollectionListBreakdown',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.hscode.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'hscode',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_hscode',
        ),
        'as' => 'admin.hscode.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\HscodeController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\HscodeController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.hscode.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'hscode/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_hscode',
        ),
        'as' => 'admin.hscode.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\HscodeController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\HscodeController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.hscode.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'hscode/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_hscode',
        ),
        'as' => 'admin.hscode.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\HscodeController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\HscodeController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.hscode.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'hscode/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_hscode',
        ),
        'as' => 'admin.hscode.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\HscodeController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\HscodeController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.hscode.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'hscode/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_hscode',
        ),
        'as' => 'admin.hscode.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\HscodeController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\HscodeController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.hscode.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'hscode/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_hscode',
        ),
        'as' => 'admin.hscode.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\HscodeController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\HscodeController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer_seller.billplzPayout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'billplz-payout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer',
        ),
        'as' => 'admin.customer_seller.billplzPayout',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@postBillplzPayout',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@postBillplzPayout',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qsl16EZZWEoKOYyv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'POST',
        2 => 'HEAD',
      ),
      'uri' => 'payout-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getBillplzPayoutResponse',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getBillplzPayoutResponse',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::qsl16EZZWEoKOYyv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/customer/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer',
        ),
        'as' => 'admin.customer.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer',
        ),
        'as' => 'admin.customer.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.ajaxStore' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/customer/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer',
        ),
        'as' => 'admin.customer.ajaxStore',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@postAjaxStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@postAjaxStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.blance_transfer' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/blance-transfer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer',
        ),
        'as' => 'admin.customer.blance_transfer',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@postBlanceTransfer',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@postBlanceTransfer',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.store.booking' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/store/booking',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer',
        ),
        'as' => 'admin.customer.store.booking',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@addNewCustomer',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@addNewCustomer',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_customer',
        ),
        'as' => 'admin.customer.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.edit.ajax' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/customer/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_customer',
        ),
        'as' => 'admin.customer.edit.ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getAjaxEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getAjaxEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.payment_history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/payment-history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_customer',
        ),
        'as' => 'admin.customer.payment_history',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getPaymentHistory',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getPaymentHistory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_customer',
        ),
        'as' => 'admin.customer.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_customer',
        ),
        'as' => 'admin.customer.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admn.customer.root' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'parent-root/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admn.customer.root',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCombo',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCombo',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.remainingcustomerbalance' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get/{id}/remainingcustomerbalance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.remainingcustomerbalance',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getRemainingBalance',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getRemainingBalance',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.history',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getHistory',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getHistory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.history2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/history2',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.history2',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getHistory2',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getHistory2',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.address-book' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/address-book',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.address-book',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getAddressBook',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getAddressBook',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.orders' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.orders',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getOrderlistByCustomer',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getOrderlistByCustomer',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.payments' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/payments',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.payments',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCustomerPayment',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCustomerPayment',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.balance' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/balance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.balance',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCustomerBalance',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCustomerBalance',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.my-orders.datatable' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/user-orderList-datatable',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.my-orders.datatable',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getMyOrders',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getMyOrders',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.orders.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/orders/view/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'customer.orders.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getOrderView',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getOrderView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.customer-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/customer-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer',
        ),
        'as' => 'admin.customer.customer-details',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCustomerDetails',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCustomerDetails',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.refund' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/{id}/refund/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_refund',
        ),
        'as' => 'admin.payment.refund',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefund',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefund',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.refund' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/refund',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_refund',
        ),
        'as' => 'admin.customer.refund',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.paymentrefund.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/refund/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_refund',
        ),
        'as' => 'admin.paymentrefund.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@postRefund',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@postRefund',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.refundrequeststore' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/refundrequest/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_refund',
        ),
        'as' => 'admin.customer.refundrequeststore',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@postRefundRequest',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@postRefundRequest',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.refundrequest' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/refundrequest',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_refund',
        ),
        'as' => 'admin.customer.refundrequest',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getrefundRequestList',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getrefundRequestList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.refunded' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/refunded',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_refund',
        ),
        'as' => 'admin.customer.refunded',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefunded',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefunded',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.refundrequest_deny' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/refundrequest/{id}/deny',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_refund',
        ),
        'as' => 'admin.customer.refundrequest_deny',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefundedRequestDeny',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefundedRequestDeny',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.refund' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/refund',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller_refund',
        ),
        'as' => 'admin.seller.refund',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getIndexReseller',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getIndexReseller',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.refundrequest' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/refundrequest',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller_refund',
        ),
        'as' => 'admin.seller.refundrequest',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getrefundRequestListReseller',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getrefundRequestListReseller',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.refunded' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/refunded',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller_refund',
        ),
        'as' => 'admin.seller.refunded',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefundedReseller',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefundedReseller',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.refundrequest_deny' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/refundrequest/{id}/deny',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_reseller_refund',
        ),
        'as' => 'admin.seller.refundrequest_deny',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefundedRequestDenyReseller',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefundedRequestDenyReseller',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.refundrequeststore' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/refundrequest/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_reseller_refund',
        ),
        'as' => 'admin.seller.refundrequeststore',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@postRefundRequestReseller',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@postRefundRequestReseller',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.refund.reseller' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/refund/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_reseller_refund',
        ),
        'as' => 'admin.payment.refund.reseller',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefundReseller',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@getRefundReseller',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.paymentrefund.store.reseller' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/refund/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_reseller_refund',
        ),
        'as' => 'admin.paymentrefund.store.reseller',
        'uses' => 'App\\Http\\Controllers\\Admin\\RefundController@postRefundReseller',
        'controller' => 'App\\Http\\Controllers\\Admin\\RefundController@postRefundReseller',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller',
        ),
        'as' => 'admin.seller.history',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getHistory',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getHistory',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.reseller-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/reseller-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller',
        ),
        'as' => 'admin.seller.reseller-details',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getResellerDetails',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getResellerDetails',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.address-book' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/address-book',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller',
        ),
        'as' => 'admin.seller.address-book',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getAddressBook',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getAddressBook',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.orders' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller',
        ),
        'as' => 'admin.seller.orders',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getOrderlistByReseller',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getOrderlistByReseller',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.payments' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/payments',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller',
        ),
        'as' => 'admin.seller.payments',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getResellerPayment',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getResellerPayment',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.balance' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/{id}/balance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller',
        ),
        'as' => 'admin.seller.balance',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getResellerBalance',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getResellerBalance',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.seller.my-orders.datatable' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/user-orderList-datatable',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller',
        ),
        'as' => 'admin.seller.my-orders.datatable',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getMyOrders',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getMyOrders',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reseller.orders.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'seller/orders/view/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_reseller',
        ),
        'as' => 'reseller.orders.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\SellerController@getOrderView',
        'controller' => 'App\\Http\\Controllers\\Admin\\SellerController@getOrderView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer-address.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer-address',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_customer_address',
        ),
        'as' => 'admin.customer-address.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer-address.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer-address/{id}/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.customer-address.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer-address.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer-address/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.customer-address.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer-address.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer-address/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_customer_address',
        ),
        'as' => 'admin.customer-address.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer-address.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer-address/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_customer_address',
        ),
        'as' => 'admin.customer-address.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer-address.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer-address/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_customer_address',
        ),
        'as' => 'admin.customer-address.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer-address.order_edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'getCustomerAddressEdit/{customer_id}/{id}/{is_reseller?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_customer_address',
        ),
        'as' => 'admin.customer-address.order_edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCustomerAddressEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCustomerAddressEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer-address.order_getcusinfo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'getCustomerByName/{customer_name}/{type?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_customer_address',
        ),
        'as' => 'admin.customer-address.order_getcusinfo',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCustomerByName',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCustomerByName',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/address/create/{customer_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.address.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getAjaxCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getAjaxCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/address/edit/{address_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.address.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getAjaxEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getAjaxEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.delete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/address/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_customer_address',
        ),
        'as' => 'admin.address.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getAjaxDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getAjaxDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer-address.creates' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-post-code',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.customer-address.creates',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@search',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@search',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer_state' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer_state/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.customer_state',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getState',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getState',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer_city' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer_city/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.customer_city',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCity',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCity',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer_pCode' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer_pCode/{city_id}/{state_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.customer_pCode',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getPostC',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getPostC',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer_city_by_state' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer_city_by_state/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.customer_city_by_state',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCitybyState',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getCitybyState',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer_postage_by_city' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer_postage_by_city/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_customer_address',
        ),
        'as' => 'admin.customer_postage_by_city',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getPostagebyCity',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerAddressController@getPostagebyCity',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address_type.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address-type',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_address_type',
        ),
        'as' => 'admin.address_type.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address_type.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address-type/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_address_type',
        ),
        'as' => 'admin.address_type.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address_type.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address-type/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_address_type',
        ),
        'as' => 'admin.address_type.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address_type.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address-type/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_address_type',
        ),
        'as' => 'admin.address_type.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address_type.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address-type/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_address_type',
        ),
        'as' => 'admin.address_type.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address_type.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address-type/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_address_type',
        ),
        'as' => 'admin.address_type.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address_type.postage_list_' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address-type-post-code/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_postage_list',
        ),
        'as' => 'admin.address_type.postage_list_',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getPostageList',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getPostageList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address_type.postage_view_' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address-type-post-code/{id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address_type.postage_view_',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getPostageAddress',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getPostageAddress',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address_type.city_list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address-type-city/{id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_city_list',
        ),
        'as' => 'admin.address_type.city_list',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityAddress',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityAddress',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer_address_city.put' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'post-address-type-city/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_city_list',
        ),
        'as' => 'admin.customer_address_city.put',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@postCityAddress',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@postCityAddress',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer_address_postage.put' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'post-address-type-postage/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.customer_address_postage.put',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@postPostageAddress',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@postPostageAddress',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.city_list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address/city_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_city_list',
        ),
        'as' => 'admin.address.city_list',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityList',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.city_store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address/new_city',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.city_store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@postCity',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@postCity',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.get_city' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-city-edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.get_city',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getEditCity',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getEditCity',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.city_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address/edit_city',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.city_update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@updateCity',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@updateCity',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.get-city' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-city-create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.get-city',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.city_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-city-delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.city_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.region_list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address/region_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.region_list',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getRegionList',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getRegionList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.get-region' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-region-create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.get-region',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getRegionCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getRegionCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.edit_region' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-region-edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.edit_region',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getRegion',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getRegion',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.region_store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address/new_region',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.region_store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@postRegion',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@postRegion',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.region_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address/edit_region',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.region_update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@updateRegion',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@updateRegion',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.region_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-region-delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.region_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getRegionDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getRegionDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.get_city_region' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-city-by-region/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.get_city_region',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityByRegion',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getCityByRegion',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.get-area' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-area-create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.get-area',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.area_create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address/area_create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.area_create',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@postArea',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@postArea',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.area_edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-area-edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.area_edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.area_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address/area_update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.area_update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@updateArea',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@updateArea',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.area_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-area-delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.area_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.sub_area' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address/sub_area',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.sub_area',
        'uses' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.get_area' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-area-by-city/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.get_area',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaByCity',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaByCity',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.subarea.map_create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-subarea-by-area/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.subarea.map_create',
        'uses' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getAreaMapByArea',
        'controller' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getAreaMapByArea',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.area_list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address/area_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.area_list',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaList',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getAreaList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.map_store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address/new_map',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.map_store',
        'uses' => 'App\\Http\\Controllers\\Admin\\AreaMapController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\AreaMapController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.map_edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-map-edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.map_edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.map_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'address/map_update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.map_update',
        'uses' => 'App\\Http\\Controllers\\Admin\\AreaMapController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AreaMapController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.map_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-map-delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.address.map_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.map' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address/map',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.map',
        'uses' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getMap',
        'controller' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getMap',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.map_create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-map-create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.address.map_create',
        'uses' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.polygon.polygon_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-polygon-delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.polygon.polygon_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getPolygonDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\AreaMapController@getPolygonDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'delivery_boy/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_delivery_boy_list',
        ),
        'as' => 'admin.delivery_boy.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/delivery-boy/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_delivery_boy_list',
        ),
        'as' => 'admin.delivery_boy.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'delivery_boy/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.delivery_boy.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/delivery-boy/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.delivery_boy.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'delivery_boy/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_postage_list',
        ),
        'as' => 'admin.delivery_boy.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/delivery-boy/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_region_list',
        ),
        'as' => 'admin.delivery_boy.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'delivery-boy/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product',
        ),
        'as' => 'admin.delivery_boy.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.delivery_list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'delivery-boy/delivery-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_product',
        ),
        'as' => 'admin.delivery_boy.delivery_list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getDeliveryList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getDeliveryList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.area_list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'delivery-boy/{id}/area-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_delivery_boy',
        ),
        'as' => 'admin.delivery_boy.area_list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getCoverageArea',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getCoverageArea',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery_boy.area_list.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'delivery-boy/{id}/area-store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_delivery_boy',
        ),
        'as' => 'admin.delivery_boy.area_list.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@postCoverageArea',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@postCoverageArea',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery-area.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/delivery-area/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_delivery_boy',
        ),
        'as' => 'admin.delivery-area.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@deliveryAreaDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@deliveryAreaDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.edit_delivery_boy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/get-delivery-man/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_delivery_boy',
        ),
        'as' => 'admin.edit_delivery_boy',
        'uses' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getDeliveryManByShop',
        'controller' => 'App\\Http\\Controllers\\Admin\\DeliveryBoyController@getDeliveryManByShop',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delivery-man.bulkAssign' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'delivery-man/bulk-assign',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_delivery_boy',
        ),
        'as' => 'admin.delivery-man.bulkAssign',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@bulkAssignDeliveryMan',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@bulkAssignDeliveryMan',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.delivery_cost' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-delivery-cost',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_search_booking',
        ),
        'as' => 'admin.booking.delivery_cost',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@getDeliveryCost',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@getDeliveryCost',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'search-&-book',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_booking',
        ),
        'as' => 'admin.booking.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@searchBook',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@searchBook',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'booking/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_booking',
        ),
        'as' => 'admin.booking.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'booking/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.booking.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.download_pdf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'booking/{id}/download_pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.booking.download_pdf',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@getDownloadPDF',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@getDownloadPDF',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'booking/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_booking',
        ),
        'as' => 'admin.booking.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'booking/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_booking',
        ),
        'as' => 'admin.booking.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.store-ajax' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'booking/store-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_booking',
        ),
        'as' => 'admin.booking.store-ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@postCartStoreAjax',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@postCartStoreAjax',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'booking',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.booking.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.assign-deliveryman' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/assign-deliveryman',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.booking.assign-deliveryman',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@assignDeliveryman',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@assignDeliveryman',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.getproduct.details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-prd-details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.booking.getproduct.details',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@getProductINV',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@getProductINV',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.deliveryaddress.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'deliveryaddress/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.deliveryaddress.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@deliveryAddressUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@deliveryAddressUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.bulk_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'booking/bulk_update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.booking.bulk_update',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@postBulkUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@postBulkUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'booking/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_booking',
        ),
        'as' => 'admin.booking.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '{branch_id}/get-variant-info',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.booking.product',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@search',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@search',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.cart.web-cart' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web-cart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_booking',
        ),
        'as' => 'admin.cart.web-cart',
        'uses' => 'App\\Http\\Controllers\\Admin\\CartController@getCart',
        'controller' => 'App\\Http\\Controllers\\Admin\\CartController@getCart',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.info' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-customer-info',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.customer.info',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCustomer',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@getCustomer',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.get-cart-details' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/customer/get-cart-details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.customer.get-cart-details',
        'uses' => 'App\\Http\\Controllers\\Admin\\CartController@getCartDetails',
        'controller' => 'App\\Http\\Controllers\\Admin\\CartController@getCartDetails',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.flat-discount' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/flat-discount',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.customer.flat-discount',
        'uses' => 'App\\Http\\Controllers\\Admin\\CartController@postFlatDiscount',
        'controller' => 'App\\Http\\Controllers\\Admin\\CartController@postFlatDiscount',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.coupon-discountt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/coupon-discount',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.customer.coupon-discountt',
        'uses' => 'App\\Http\\Controllers\\Admin\\CartController@postCouponDiscount',
        'controller' => 'App\\Http\\Controllers\\Admin\\CartController@postCouponDiscount',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customer.remove-coupon' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/remove-coupon',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.customer.remove-coupon',
        'uses' => 'App\\Http\\Controllers\\Admin\\CartController@getRemoveCoupon',
        'controller' => 'App\\Http\\Controllers\\Admin\\CartController@getRemoveCoupon',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.update-apply-coupon' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/update-apply-coupon',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.update-apply-coupon',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@updateApplyCoupon',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@updateApplyCoupon',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.product.search-list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ajax/search-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'admin.product.search-list',
        'uses' => 'App\\Http\\Controllers\\Admin\\ProductController@getSearchList',
        'controller' => 'App\\Http\\Controllers\\Admin\\ProductController@getSearchList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.add-to-cart' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/add-to-cart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'admin.add-to-cart',
        'uses' => 'App\\Http\\Controllers\\Admin\\CartController@addToCart',
        'controller' => 'App\\Http\\Controllers\\Admin\\CartController@addToCart',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delete-to-cart' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/delete-to-cart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'admin.delete-to-cart',
        'uses' => 'App\\Http\\Controllers\\Admin\\CartController@removeCart',
        'controller' => 'App\\Http\\Controllers\\Admin\\CartController@removeCart',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.update-cart-qty' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/update-cart-qty',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_product',
        ),
        'as' => 'admin.update-cart-qty',
        'uses' => 'App\\Http\\Controllers\\Admin\\CartController@updateCartQty',
        'controller' => 'App\\Http\\Controllers\\Admin\\CartController@updateCartQty',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.search-customer' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/search-customer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'as' => 'admin.search-customer',
        'uses' => 'App\\Http\\Controllers\\Admin\\CustomerController@postSearchCustomer',
        'controller' => 'App\\Http\\Controllers\\Admin\\CustomerController@postSearchCustomer',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.getcustomer.details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-customer-details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_booking',
        ),
        'as' => 'admin.booking.getcustomer.details',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@getCusInfo',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@getCusInfo',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.procedure' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'call-procedure-booking',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'as' => 'admin.booking.procedure',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@callProcedure',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@callProcedure',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.checkoffer' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'booking/{id}/check-offer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_booking',
        ),
        'as' => 'admin.booking.checkoffer',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@checkOffer',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@checkOffer',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking_to_order.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'booking-to-order/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_booking',
        ),
        'as' => 'admin.booking_to_order.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getBooking',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getBooking',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.address.coordinator' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'address/coordinator',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_booking',
        ),
        'as' => 'admin.address.coordinator',
        'uses' => 'App\\Http\\Controllers\\Admin\\AddressController@getCoordinator',
        'controller' => 'App\\Http\\Controllers\\Admin\\AddressController@getCoordinator',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking_to_order.book-order' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'orderbooking/{id}/book-order',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.booking_to_order.book-order',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getBookOrder',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getBookOrder',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.senderaddress.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/senderaddress/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.senderaddress.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@updateSenderaddress',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@updateSenderaddress',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.receiveraddress.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/receiveraddress/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.receiveraddress.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\OrderController@updateReceiverAddress',
        'controller' => 'App\\Http\\Controllers\\Admin\\OrderController@updateReceiverAddress',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking_to_order.admin-approval' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'order/{id}/admin-approval',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.booking_to_order.admin-approval',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getBookOrderAdminApproval',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getBookOrderAdminApproval',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bookingtoorder.admin-approved' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'booking-to-order/{id}/admin-approved',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.bookingtoorder.admin-approved',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@updateBooktoOrderAdminApproved',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@updateBooktoOrderAdminApproved',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking_to_order_delete_ajax.book-order' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'delete_book_to_order_item/{id}/{type?}/{booking_no?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.booking_to_order_delete_ajax.book-order',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@ajaxDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@ajaxDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking_to_order_payment_ajax.book-order' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'update_order_payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_booking',
        ),
        'as' => 'admin.booking_to_order_payment_ajax.book-order',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@ajaxPayment',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@ajaxPayment',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bookingtoorder.getCustomerAddress' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'booking/getCustomerAddress/{id}/{pk_no}/{address_id?}/{reseller_id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.bookingtoorder.getCustomerAddress',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getCustomerAddress',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getCustomerAddress',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking_to_order_ajax.postCustomerAddress' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'postCustomerAddress',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.booking_to_order_ajax.postCustomerAddress',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postCustomerAddress',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postCustomerAddress',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.customerAddress.add' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'postCustomerAddress2',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.customerAddress.add',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postCustomerAddress2',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postCustomerAddress2',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bookingtoorder.checkifCustomerAddressexists' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'checkifCustomerAddressexists/{customer_id}/{type}/{book_id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.bookingtoorder.checkifCustomerAddressexists',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@checkifCustomerAddressexists',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@checkifCustomerAddressexists',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bookingtoorder.getPayInfo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bookorder/getPayInfo/{order_id}/{is_reseller}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_order',
        ),
        'as' => 'admin.bookingtoorder.getPayInfo',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getPayInfo',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@getPayInfo',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking_to_order_ajax.postUpdatedAddress' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'postUpdatedAddress/{order_id}/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.booking_to_order_ajax.postUpdatedAddress',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postUpdatedAddress',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postUpdatedAddress',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking_to_order_ajax.postPaymentUncheck' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'postPaymentUncheck',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.booking_to_order_ajax.postPaymentUncheck',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postPaymentUncheck',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postPaymentUncheck',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking_to_order_stock_exchange_ajax' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'getStockExchangeInfo/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.booking_to_order_stock_exchange_ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@ajaxExchangeStock',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@ajaxExchangeStock',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.post_booking_to_order_stock_exchange_ajax' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'getStockExchangeInfo-exchange',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.post_booking_to_order_stock_exchange_ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@ajaxExchangeStockAction',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@ajaxExchangeStockAction',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.default.order.penalty' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'default-order-penalty/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_order',
        ),
        'as' => 'admin.default.order.penalty',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postDefaultOrderPenalty',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingToOrderController@postDefaultOrderPenalty',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_payment',
        ),
        'as' => 'admin.payment.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payment/new/{id?}/{type?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_payment',
        ),
        'as' => 'admin.payment.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payment/{id}/details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_payment',
        ),
        'as' => 'admin.payment.details',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getDetails',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getDetails',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'payment/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_payment',
        ),
        'as' => 'admin.payment.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payment/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_payment',
        ),
        'as' => 'admin.payment.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.orderpayment.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'orderpayment/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_orderpayment',
        ),
        'as' => 'admin.orderpayment.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getOrderPaymentDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getOrderPaymentDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment.updatepartial' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'payment/update-partial',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_payment',
        ),
        'as' => 'admin.payment.updatepartial',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@postUpdatePartial',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@postUpdatePartial',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment_processing.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payment-processing',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_payment_processing',
        ),
        'as' => 'admin.payment_processing.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getPaymentProcessing',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getPaymentProcessing',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_other.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bank-to-other/{id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_bank_to_other',
        ),
        'as' => 'admin.account_to_other.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToOther',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToOther',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_other_list.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bank-to-other-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_bank_to_other',
        ),
        'as' => 'admin.account_to_other_list.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToOtherList',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToOtherList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_other.details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'party-transfer-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_bank_to_other',
        ),
        'as' => 'admin.account_to_other.details',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToOtherDetails',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToOtherDetails',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_other.type.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'add-new-type',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_bank_to_other',
        ),
        'as' => 'admin.account_to_other.type.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@postNewPaymentType',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@postNewPaymentType',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_other.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bank-to-other-store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_bank_to_other',
        ),
        'as' => 'admin.account_to_other.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@postbankToOther',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@postbankToOther',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_bank.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bank-to-bank/{id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_bank_to_bank',
        ),
        'as' => 'admin.account_to_bank.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToBank',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToBank',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_bank_list.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bank-to-bank-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_bank_to_bank',
        ),
        'as' => 'admin.account_to_bank_list.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToBankList',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToBankList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_bank.details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'internal-transfer-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_bank_to_bank',
        ),
        'as' => 'admin.account_to_bank.details',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToBankDetails',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@getBankToBankDetails',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_bank.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bank-to-bank-store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_bank_to_bank',
        ),
        'as' => 'admin.account_to_bank.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@postbankToBank',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@postbankToBank',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_other_ajax.list' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bank-to-other-list-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_bank_to_other',
        ),
        'as' => 'admin.account_to_other_ajax.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@ajaxbankToOther',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@ajaxbankToOther',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account_to_bank_ajax.list' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bank-to-bank-list-ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_bank_to_bank',
        ),
        'as' => 'admin.account_to_bank_ajax.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@ajaxbankToBank',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@ajaxbankToBank',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.account.bank.balance' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'postAccountBalanceInfo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_bank_to_bank',
        ),
        'as' => 'admin.account.bank.balance',
        'uses' => 'App\\Http\\Controllers\\Admin\\PaymentController@postAccountBalanceInfo',
        'controller' => 'App\\Http\\Controllers\\Admin\\PaymentController@postAccountBalanceInfo',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bankstate.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bank-state',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_bank_state',
        ),
        'as' => 'admin.bankstate.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.getbankstate.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-bank-state',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_bank_state',
        ),
        'as' => 'admin.getbankstate.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@getMatchingList',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@getMatchingList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bankstate.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bank-state/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_bank_state',
        ),
        'as' => 'admin.bankstate.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bankstate.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bank-state/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_bank_state',
        ),
        'as' => 'admin.bankstate.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bankstate.delete_bulk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bank-state/delete_bulk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_bank_state',
        ),
        'as' => 'admin.bankstate.delete_bulk',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@postDeleteBulk',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@postDeleteBulk',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bankstate.draft_to_save' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bank-state/draft-to-save',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_bank_state',
        ),
        'as' => 'admin.bankstate.draft_to_save',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@postDraftToSave',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@postDraftToSave',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bankstate.mark_as_used' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bank-state/mark-as-used',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_bank_state',
        ),
        'as' => 'admin.bankstate.mark_as_used',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@postMarkAsUsed',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@postMarkAsUsed',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bankstate.verification' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bank-state/verification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:payment_verification',
        ),
        'as' => 'admin.bankstate.verification',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@getVerification',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@getVerification',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bankstate.verify' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'bank-state/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_bank_state',
        ),
        'as' => 'admin.bankstate.verify',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@postVerify',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@postVerify',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bankstate.unverify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'bank-state/{id}/unverify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_bank_state',
        ),
        'as' => 'admin.bankstate.unverify',
        'uses' => 'App\\Http\\Controllers\\Admin\\BankStateController@getUnVerify',
        'controller' => 'App\\Http\\Controllers\\Admin\\BankStateController@getUnVerify',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.get-variant-info-like' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/get-variant-info-like',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_packaging',
        ),
        'as' => 'admin.get-variant-info-like',
        'uses' => 'App\\Http\\Controllers\\Admin\\PackagingController@getVariantInfoLike',
        'controller' => 'App\\Http\\Controllers\\Admin\\PackagingController@getVariantInfoLike',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.faulty.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'lost-product/{type?}/{id?}/{dispatched?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_faulty',
        ),
        'as' => 'admin.faulty.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\FaultyController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\FaultyController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.faulty.put' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'faulty-checker/{type}/{id}/{faulty_type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_faulty',
        ),
        'as' => 'admin.faulty.put',
        'uses' => 'App\\Http\\Controllers\\Admin\\FaultyController@ajaxFaultyChecker',
        'controller' => 'App\\Http\\Controllers\\Admin\\FaultyController@ajaxFaultyChecker',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.all_product.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'stock-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_stock',
        ),
        'as' => 'admin.all_product.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\StockController@getAllStockList',
        'controller' => 'App\\Http\\Controllers\\Admin\\StockController@getAllStockList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.details.modal' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'stock-details/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_warehouse_stock',
        ),
        'as' => 'product.details.modal',
        'uses' => 'App\\Http\\Controllers\\Admin\\StockController@getStockDetail',
        'controller' => 'App\\Http\\Controllers\\Admin\\StockController@getStockDetail',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.stock_price.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'stock-price/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_warehouse_stock',
        ),
        'as' => 'admin.stock_price.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\ShelveController@getStockPriceInfo',
        'controller' => 'App\\Http\\Controllers\\Admin\\ShelveController@getStockPriceInfo',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.details_invoice.modal' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product-details-modal-invoice',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_warehouse_stock',
        ),
        'as' => 'product.details_invoice.modal',
        'uses' => 'App\\Http\\Controllers\\Admin\\ShelveController@getInvoiceProductModal',
        'controller' => 'App\\Http\\Controllers\\Admin\\ShelveController@getInvoiceProductModal',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currency.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'currency',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_currency',
        ),
        'as' => 'admin.currency.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\CurrencyController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\CurrencyController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currency.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'update/{id?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_currency',
        ),
        'as' => 'admin.currency.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\CurrencyController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CurrencyController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currency.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_currency',
        ),
        'as' => 'admin.currency.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\CurrencyController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\CurrencyController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.currency.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_currency',
        ),
        'as' => 'admin.currency.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\CurrencyController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\CurrencyController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pVbw2y3lolmA2rbF' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/all_customer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@all_customer',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@all_customer',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::pVbw2y3lolmA2rbF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uKR7Ftrc7cymiksG' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/refundlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@customerRefundlist',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@customerRefundlist',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::uKR7Ftrc7cymiksG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::L37yE3RkoMktxbkS' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/refundlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@resellerRefundlist',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@resellerRefundlist',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::L37yE3RkoMktxbkS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Z0IdBe2osSuGK9CV' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/refundedList',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@customerRefunded',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@customerRefunded',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Z0IdBe2osSuGK9CV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qAvllEqnnxQ9B1Kd' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/refundedList',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@resellerRefunded',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@resellerRefunded',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::qAvllEqnnxQ9B1Kd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CHsCd0U7TrPv8eCS' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/refundrequestlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@customerRefundedRequestList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@customerRefundedRequestList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::CHsCd0U7TrPv8eCS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::K8lguIU1RG5LEm69' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'seller/refundrequestlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@resellerRefundedRequestList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@resellerRefundedRequestList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::K8lguIU1RG5LEm69',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ew1NMUccAstWRPcM' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'all_product_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@all_product_list',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@all_product_list',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ew1NMUccAstWRPcM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AhVxOciWT2bUNQQF' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'unshelved_product_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@unshelved_product_list',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@unshelved_product_list',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::AhVxOciWT2bUNQQF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::t3EXdd7IOaw7jKXN' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shelved_product_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@shelved_product_list',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@shelved_product_list',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::t3EXdd7IOaw7jKXN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::hNeN11pj3nwDPGky' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'boxed_product_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@boxed_product_list',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@boxed_product_list',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::hNeN11pj3nwDPGky',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5hwNZxid2zkombpX' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'not_boxed_product_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@notBoxed_product_list',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@notBoxed_product_list',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5hwNZxid2zkombpX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cPFtyFTQFyMtCyLm' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sales_comission_report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@sales_comission_report',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@sales_comission_report',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::cPFtyFTQFyMtCyLm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::BbKjmjWZ9nYXxg5E' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sales_comission_report_list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@sales_comission_report_list',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@sales_comission_report_list',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::BbKjmjWZ9nYXxg5E',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_type.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-type',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_offer_type',
        ),
        'as' => 'admin.offer_type.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_type.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-type/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_type',
        ),
        'as' => 'admin.offer_type.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_type.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-type/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_type',
        ),
        'as' => 'admin.offer_type.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_type.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-type/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_type',
        ),
        'as' => 'admin.offer_type.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_type.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-type/{id?}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_type',
        ),
        'as' => 'admin.offer_type.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_type.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-type/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_offer_type',
        ),
        'as' => 'admin.offer_type.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferTypeController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offergroup.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-group',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_offergroup',
        ),
        'as' => 'admin.offergroup.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offergroup.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-group/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offergroup',
        ),
        'as' => 'admin.offergroup.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offergroup.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-group/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offergroup',
        ),
        'as' => 'admin.offergroup.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offergroup.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-group/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offergroup',
        ),
        'as' => 'admin.offergroup.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offergroup.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-group/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offergroup',
        ),
        'as' => 'admin.offergroup.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offergroup.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-group/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_offergroup',
        ),
        'as' => 'admin.offergroup.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferGroupController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_offer_list',
        ),
        'as' => 'admin.offer.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-list/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_list',
        ),
        'as' => 'admin.offer.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-list/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_list',
        ),
        'as' => 'admin.offer.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-list/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_list',
        ),
        'as' => 'admin.offer.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-list/{id?}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_list',
        ),
        'as' => 'admin.offer.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-list/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_offer_list',
        ),
        'as' => 'admin.offer.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-primary-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_offer_primary',
        ),
        'as' => 'admin.offer_primary.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-primary-list/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_primary',
        ),
        'as' => 'admin.offer_primary.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-primary-list/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_primary',
        ),
        'as' => 'admin.offer_primary.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-primary-list/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_primary',
        ),
        'as' => 'admin.offer_primary.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-primary-list/{id?}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_offer_primary',
        ),
        'as' => 'admin.offer_primary.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-primary-list/{id?}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_primary',
        ),
        'as' => 'admin.offer_primary.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-primary-list/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_offer_primary',
        ),
        'as' => 'admin.offer_primary.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.add_product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-primary-list/{id}/add-product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_primary',
        ),
        'as' => 'admin.offer_primary.add_product',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getAddProduct',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getAddProduct',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.store_product' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-primary-list/store_product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_primary',
        ),
        'as' => 'admin.offer_primary.store_product',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@postStoreProduct',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@postStoreProduct',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.productlist' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-primary-list/add-productlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_primary',
        ),
        'as' => 'admin.offer_primary.productlist',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getVariantList',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getVariantList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_primary.deleteproduct' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-primary-list/{id}/delete-product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_primary',
        ),
        'as' => 'admin.offer_primary.deleteproduct',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getDeleteProduct',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferPrimaryController@getDeleteProduct',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-secondary-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-secondary-list/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-secondary-list/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-secondary-list/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-secondary-list/{id?}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-secondary-list/{id?}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@putUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@putUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-secondary-list/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.add_product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-secondary-list/{id}/add-product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.add_product',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getAddProduct',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getAddProduct',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.store_product' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-secondary-list/store_product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.store_product',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@postStoreProduct',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@postStoreProduct',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.productlist' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'offer-secondary-list/add-productlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.productlist',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getVariantList',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getVariantList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.offer_secondary.deleteproduct' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'offer-secondary-list/{id}/delete-product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_offer_secondary',
        ),
        'as' => 'admin.offer_secondary.deleteproduct',
        'uses' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getDeleteProduct',
        'controller' => 'App\\Http\\Controllers\\Admin\\OfferSecondaryController@getDeleteProduct',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.coupon.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'coupon-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_coupon_list',
        ),
        'as' => 'admin.coupon.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\CouponController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\CouponController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.coupon.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'coupon/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_coupon',
        ),
        'as' => 'admin.coupon.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\CouponController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CouponController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.coupon.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'coupon/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_coupon',
        ),
        'as' => 'admin.coupon.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\CouponController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\CouponController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.coupon.search' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'coupon/search-product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_coupon',
        ),
        'as' => 'admin.coupon.search',
        'uses' => 'App\\Http\\Controllers\\Admin\\CouponController@postCouponSearch',
        'controller' => 'App\\Http\\Controllers\\Admin\\CouponController@postCouponSearch',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.coupon.master_variant' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'coupon/get-master-variants',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_coupon',
        ),
        'as' => 'admin.coupon.master_variant',
        'uses' => 'App\\Http\\Controllers\\Admin\\CouponController@postCouponMasterVariant',
        'controller' => 'App\\Http\\Controllers\\Admin\\CouponController@postCouponMasterVariant',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.coupon.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'coupon/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_coupon',
        ),
        'as' => 'admin.coupon.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\CouponController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\CouponController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.coupon.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'coupon/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_coupon',
        ),
        'as' => 'admin.coupon.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\CouponController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\CouponController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.coupon.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'coupon/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_coupon',
        ),
        'as' => 'admin.coupon.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\CouponController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\CouponController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.coupon.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'coupon/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_coupon_list',
        ),
        'as' => 'admin.coupon.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\CouponController@getView',
        'controller' => 'App\\Http\\Controllers\\Admin\\CouponController@getView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.apply-coupon' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'apply-coupon',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'as' => 'admin.apply-coupon',
        'uses' => 'App\\Http\\Controllers\\Admin\\BookingController@postApplyCoupon',
        'controller' => 'App\\Http\\Controllers\\Admin\\BookingController@postApplyCoupon',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.shipping-address.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shipping-address',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_shipping_address',
        ),
        'as' => 'admin.shipping-address.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.shipping-address.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shipping-address/new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_shipping_address',
        ),
        'as' => 'admin.shipping-address.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.shipping-address.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shipping-address/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_shipping_address',
        ),
        'as' => 'admin.shipping-address.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@postStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.shipping-address.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shipping-address/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_shipping_address',
        ),
        'as' => 'admin.shipping-address.edit',
        'uses' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.shipping-address.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shipping-address/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_shipping_address',
        ),
        'as' => 'admin.shipping-address.update',
        'uses' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.shipping-address.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shipping-address/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_shipping_address',
        ),
        'as' => 'admin.shipping-address.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\ShippingAddressController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.signature.img_delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'signature_img_delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_shipment_signature',
        ),
        'as' => 'admin.signature.img_delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\ShipmentSignController@getDeleteImage',
        'controller' => 'App\\Http\\Controllers\\Admin\\ShipmentSignController@getDeleteImage',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notify_email.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notification/email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_notify_email',
        ),
        'as' => 'admin.notify_email.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getEmailIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getEmailIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notify_email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'notification/email/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_notify_email',
        ),
        'as' => 'admin.notify_email',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getEmailList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getEmailList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notify_email.body' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notification/email/view/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_notify_email_body',
        ),
        'as' => 'admin.notify_email.body',
        'uses' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getEmailBody',
        'controller' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getEmailBody',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notify_email.send' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notification/{id}/email-send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:send_notify_email',
        ),
        'as' => 'admin.notify_email.send',
        'uses' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getSendEmail',
        'controller' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getSendEmail',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notify_sms.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notification/sms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_notify_sms',
        ),
        'as' => 'admin.notify_sms.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notify_sms.all_notification' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'notification/all_notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_notify_sms',
        ),
        'as' => 'admin.notify_sms.all_notification',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getNotificationList',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getNotificationList',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.notify_sms.send' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notification/{id}/sms-send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:send_notify_sms',
        ),
        'as' => 'admin.notify_sms.send',
        'uses' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getSendSms',
        'controller' => 'App\\Http\\Controllers\\Admin\\NotifySmsController@getSendSms',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.newarival.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'newarival',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_newarival',
        ),
        'as' => 'admin.newarival.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.get_newarival' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get_newarival',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_newarival',
        ),
        'as' => 'admin.get_newarival',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getNewArival',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getNewArival',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.newarival.create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'newarival/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_newarival',
        ),
        'as' => 'admin.newarival.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.newarival.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'newarival/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_newarival',
        ),
        'as' => 'admin.newarival.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalView',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.newarival_variant.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'newarival-variant/{id}/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_newarival',
        ),
        'as' => 'admin.newarival_variant.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@getNewArivalVariant',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@getNewArivalVariant',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.newarival.delete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'newarival/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_newarival',
        ),
        'as' => 'admin.newarival.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.newarival.variant.delete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'newarival-variant/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_newarival',
        ),
        'as' => 'admin.newarival.variant.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalVariantDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalVariantDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.newarival.orderid_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'newarival/orderid_update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_newarival',
        ),
        'as' => 'admin.newarival.orderid_update',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalOrderidUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalOrderidUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.na_variant.orderid_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'newarival-variant/orderid_update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_newarival',
        ),
        'as' => 'admin.na_variant.orderid_update',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalVariantOrderidUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@newArivalVariantOrderidUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'get-newarival-master' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get-newarival-master',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@getNewArivalMaster',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@getNewArivalMaster',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'get-newarival-master',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'get-newarival-variant' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get-newarival-variant/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@getNotNewArivalVariant',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@getNotNewArivalVariant',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'get-newarival-variant',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.newarival_master.create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'newarival-master/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_newarival',
        ),
        'as' => 'admin.newarival_master.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@postNewArivalMasterStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@postNewArivalMasterStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.newarival_variant.create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'newarival-variant/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_newarival',
        ),
        'as' => 'admin.newarival_variant.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\NewarivalController@postNewArivalVaraitnStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\NewarivalController@postNewArivalVaraitnStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.get_newarival_view' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get_newarival_view/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_newarival',
        ),
        'as' => 'admin.get_newarival_view',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getNewAriavalView',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getNewAriavalView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.get_newarival_variant' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get_newarival_variant/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_newarival',
        ),
        'as' => 'admin.get_newarival_variant',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getNewArivalVariantView',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getNewArivalVariantView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.sales_report.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales-report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_sales_report',
        ),
        'as' => 'admin.sales_report.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.sales_report.list-item' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales-report/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_sales_report',
        ),
        'as' => 'admin.sales_report.list-item',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getComissionReport',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getComissionReport',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.yet_to_ship.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'yet-to-ship',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_yet_to_ship',
        ),
        'as' => 'admin.yet_to_ship.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getYetToShip',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getYetToShip',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.sales_report.list-item-ajax' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales-comission-list-view/{agent_id}/{date}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_sales_report',
        ),
        'as' => 'admin.sales_report.list-item-ajax',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@ajaxComissionReport',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@ajaxComissionReport',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'report/top-sell',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_top_sell',
        ),
        'as' => 'admin.top_sell.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSell',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSell',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'top-sell/{id}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_top_sell',
        ),
        'as' => 'admin.top_sell.view',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellView',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell.pdf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'top-sell/{id}/pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_top_sell',
        ),
        'as' => 'admin.top_sell.pdf',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getTopSellPdf',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getTopSellPdf',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell_variant.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'top-sell-variant/{id}/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_top_sell',
        ),
        'as' => 'admin.top_sell_variant.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getTopSellVariant',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getTopSellVariant',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell.delete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'top-sell/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_top_sell',
        ),
        'as' => 'admin.top_sell.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell_variant.delete' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'top-sell-variant/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_top_sell',
        ),
        'as' => 'admin.top_sell_variant.delete',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellVariantDelete',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellVariantDelete',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell.orderid_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'top-sell/orderid_update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_top_sell',
        ),
        'as' => 'admin.top_sell.orderid_update',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellOrderidUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellOrderidUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell_variant.orderid_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'top-sell-variant/orderid_update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_top_sell',
        ),
        'as' => 'admin.top_sell_variant.orderid_update',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellVariantOrderidUpdate',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellVariantOrderidUpdate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'get-topsell-master' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get-topsell-master',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getTopSellMaster',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getTopSellMaster',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'get-topsell-master',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'get-topsell-variant' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get-topsell-variant/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getNotTopSellVariant',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@getNotTopSellVariant',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'get-topsell-variant',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell.create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'report/top-sell/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_top_sell',
        ),
        'as' => 'admin.top_sell.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellCreate',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@topSellCreate',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell_master.create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'report/top-sell-master/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_top_sell',
        ),
        'as' => 'admin.top_sell_master.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@postTopSellMasterStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@postTopSellMasterStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.top_sell_variant.create' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'report/top-sell-variant/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_top_sell',
        ),
        'as' => 'admin.top_sell_variant.create',
        'uses' => 'App\\Http\\Controllers\\Admin\\SalesReportController@postTopSellVaraitnStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\SalesReportController@postTopSellVaraitnStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.get_top_sell' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get_top_sell',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_top_sell',
        ),
        'as' => 'admin.get_top_sell',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getTopSell',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getTopSell',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.get_top_sell_view' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get_top_sell_view/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_top_sell',
        ),
        'as' => 'admin.get_top_sell_view',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getTopSellView',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getTopSellView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.get_top_sell_variant' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'get_top_sell_variant/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_top_sell',
        ),
        'as' => 'admin.get_top_sell_variant',
        'uses' => 'App\\Http\\Controllers\\Admin\\DatatableController@getTopSellVariantView',
        'controller' => 'App\\Http\\Controllers\\Admin\\DatatableController@getTopSellVariantView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.return_request.list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dispathed/returned',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_item_return_request',
        ),
        'as' => 'admin.return_request.list',
        'uses' => 'App\\Http\\Controllers\\Admin\\ReturnRequestController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReturnRequestController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.booking.return-request' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dispathed/return-request',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_item_return_request',
        ),
        'as' => 'admin.booking.return-request',
        'uses' => 'App\\Http\\Controllers\\Admin\\ReturnRequestController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReturnRequestController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.return' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'order/return',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:return_order',
        ),
        'as' => 'admin.order.return',
        'uses' => 'App\\Http\\Controllers\\Admin\\ReturnRequestController@postReturnOrder',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReturnRequestController@postReturnOrder',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.order.confirm-return' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/confirm-return',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:return_order',
        ),
        'as' => 'admin.order.confirm-return',
        'uses' => 'App\\Http\\Controllers\\Admin\\ReturnRequestController@postConfirmReturnOrder',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReturnRequestController@postConfirmReturnOrder',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.documentation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documentaion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:return_order',
        ),
        'as' => 'admin.documentation',
        'uses' => 'App\\Http\\Controllers\\Admin\\DashboardController@getDocumentation',
        'controller' => 'App\\Http\\Controllers\\Admin\\DashboardController@getDocumentation',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.documentation-view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documentation-view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:return_order',
        ),
        'as' => 'admin.documentation-view',
        'uses' => 'App\\Http\\Controllers\\Admin\\DashboardController@getDocumentationView',
        'controller' => 'App\\Http\\Controllers\\Admin\\DashboardController@getDocumentationView',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.documentation.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'documentation/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:return_order',
        ),
        'as' => 'admin.documentation.store',
        'uses' => 'App\\Http\\Controllers\\Admin\\DashboardController@postDocumentationStore',
        'controller' => 'App\\Http\\Controllers\\Admin\\DashboardController@postDocumentationStore',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.text-editor.image' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/text-editor/image',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:return_order',
        ),
        'as' => 'admin.text-editor.image',
        'uses' => 'App\\Http\\Controllers\\Admin\\DashboardController@textEditorImageUpload',
        'controller' => 'App\\Http\\Controllers\\Admin\\DashboardController@textEditorImageUpload',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.getoptions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'getoptions/{table}/{key}/{val}/{cond_col}/{cond_val}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'as' => 'admin.getoptions',
        'uses' => 'App\\Http\\Controllers\\Admin\\DashboardController@getOtions',
        'controller' => 'App\\Http\\Controllers\\Admin\\DashboardController@getOtions',
        'namespace' => 'App\\Http\\Controllers\\Admin',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.mail.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mail/config',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Web\\MailController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Web\\MailController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'web.mail.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'env_key_update.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'mail/env-update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Web\\MailController@env_key_update',
        'controller' => 'App\\Http\\Controllers\\Web\\MailController@env_key_update',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'env_key_update.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'home/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.home.settings',
        'uses' => 'App\\Http\\Controllers\\Web\\WebSettingsController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Web\\WebSettingsController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.settings.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'home/settings/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.home.settings.store',
        'uses' => 'App\\Http\\Controllers\\Web\\WebSettingsController@postStore',
        'controller' => 'App\\Http\\Controllers\\Web\\WebSettingsController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.custom_link' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'home/custom-link',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_custom_link',
        ),
        'as' => 'web.home.custom_link',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getCustomLinks',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getCustomLinks',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.custom_link.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'home/custom-link/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_web_custom_link',
        ),
        'as' => 'web.home.custom_link.create',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@createCustomLink',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@createCustomLink',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.custom_link.get_titles' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-custom-link-title',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_web_custom_link',
        ),
        'as' => 'web.home.custom_link.get_titles',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getCustomLinkSearch',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getCustomLinkSearch',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.custom_link.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'home/custom-link/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_web_custom_link',
        ),
        'as' => 'web.home.custom_link.edit',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getCustomLink',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getCustomLink',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.custom_link.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'home/custom-link/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:new_web_custom_link',
        ),
        'as' => 'web.home.custom_link.store',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@postCustomLinkStore',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@postCustomLinkStore',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.custom_link.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'home/custom-link/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_web_new_web_custom_link',
        ),
        'as' => 'web.home.custom_link.update',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@postCustomLinkUpdate',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@postCustomLinkUpdate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.custom_link.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'home/custom-link/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:delete_web_custom_link',
        ),
        'as' => 'web.home.custom_link.delete',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getCustomLinkDelete',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getCustomLinkDelete',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/slider/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.create',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@createSlider',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@createSlider',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/slider',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getAllSlider',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getAllSlider',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/slider/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.edit',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/slider/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.store',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@postStore',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/slider/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.update',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/slider/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.delete',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.slider.delete_photo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'slider/delete-photo/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_product_variant',
        ),
        'as' => 'admin.slider.delete_photo',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getDeleteSlider',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getDeleteSlider',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.featureStatus' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/slider/featureStatus',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.featureStatus',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@changeFeatureStatus',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@changeFeatureStatus',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.order-up' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/slider/order-up/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.order-up',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getOrderUp',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getOrderUp',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.order-down' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/slider/order-down/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.order-down',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getOrderDown',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getOrderDown',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.photo_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/slider/photo/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.photo_update',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@updateSliderPhotos',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@updateSliderPhotos',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.slider.add_photo' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/slider/add_photo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.slider.add_photo',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@postAddPhotos',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@postAddPhotos',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.gellery.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'gellery/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:edit_gellery',
        ),
        'as' => 'admin.gellery.delete',
        'uses' => 'App\\Http\\Controllers\\Web\\SliderController@getDeleteSliderImage',
        'controller' => 'App\\Http\\Controllers\\Web\\SliderController@getDeleteSliderImage',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home.setting' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/home/setting',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.home.setting',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@getHomeSetting',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@getHomeSetting',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home_setting.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/home_setting/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.home_setting.update',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@postSettingUpdate',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@postSettingUpdate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.home_setting.sliderUpdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/home_setting/slider_update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.home_setting.sliderUpdate',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@sliderUpdate',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@sliderUpdate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.article' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/blog/article',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.article',
        'uses' => 'App\\Http\\Controllers\\Web\\ArticleController@getAllArticle',
        'controller' => 'App\\Http\\Controllers\\Web\\ArticleController@getAllArticle',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.article.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/blog/article/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.article.create',
        'uses' => 'App\\Http\\Controllers\\Web\\ArticleController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Web\\ArticleController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.article.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/blog/article/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.article.store',
        'uses' => 'App\\Http\\Controllers\\Web\\ArticleController@postStore',
        'controller' => 'App\\Http\\Controllers\\Web\\ArticleController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.article.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/blog/article/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.article.edit',
        'uses' => 'App\\Http\\Controllers\\Web\\ArticleController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Web\\ArticleController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.article.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/blog/article/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.article.update',
        'uses' => 'App\\Http\\Controllers\\Web\\ArticleController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Web\\ArticleController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.article.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/blog/article/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.article.delete',
        'uses' => 'App\\Http\\Controllers\\Web\\ArticleController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Web\\ArticleController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.text-editor.image' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ajax/text-editor/image-upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.text-editor.image',
        'uses' => 'App\\Http\\Controllers\\Web\\ArticleController@postEditorImageUpload',
        'controller' => 'App\\Http\\Controllers\\Web\\ArticleController@postEditorImageUpload',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/blog/category',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.category',
        'uses' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@getAllCategory',
        'controller' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@getAllCategory',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.category.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/blog/category/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.category.create',
        'uses' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.category.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/blog/category/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.category.store',
        'uses' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@postStore',
        'controller' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.category.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/blog/category/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.category.edit',
        'uses' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.category.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/blog/category/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.category.update',
        'uses' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.blog.category.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/blog/category/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.blog.category.delete',
        'uses' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Web\\BlogCategoryController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.page' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/page',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.page',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@getAllPage',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@getAllPage',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.page.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/page/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.page.create',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.page.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/page/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.page.store',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@postStore',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.page.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/page/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.page.edit',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.page.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/page/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.page.update',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.page.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/page/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.page.delete',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.page.order-up' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/page/order-up/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.page.order-up',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@getOrderUp',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@getOrderUp',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.page.order-down' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/page/order-down/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.page.order-down',
        'uses' => 'App\\Http\\Controllers\\Web\\PageController@getOrderDown',
        'controller' => 'App\\Http\\Controllers\\Web\\PageController@getOrderDown',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.faq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/faq',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.faq',
        'uses' => 'App\\Http\\Controllers\\Web\\FaqController@getAllFaq',
        'controller' => 'App\\Http\\Controllers\\Web\\FaqController@getAllFaq',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.faq.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/faq/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.faq.create',
        'uses' => 'App\\Http\\Controllers\\Web\\FaqController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Web\\FaqController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.faq.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/faq/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.faq.store',
        'uses' => 'App\\Http\\Controllers\\Web\\FaqController@postStore',
        'controller' => 'App\\Http\\Controllers\\Web\\FaqController@postStore',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.faq.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/faq/{id?}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.faq.edit',
        'uses' => 'App\\Http\\Controllers\\Web\\FaqController@getEdit',
        'controller' => 'App\\Http\\Controllers\\Web\\FaqController@getEdit',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.faq.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/faq/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.faq.update',
        'uses' => 'App\\Http\\Controllers\\Web\\FaqController@postUpdate',
        'controller' => 'App\\Http\\Controllers\\Web\\FaqController@postUpdate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.faq.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/faq/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.faq.delete',
        'uses' => 'App\\Http\\Controllers\\Web\\FaqController@getDelete',
        'controller' => 'App\\Http\\Controllers\\Web\\FaqController@getDelete',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.notification' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.notification',
        'uses' => 'App\\Http\\Controllers\\Web\\PushNotificationController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Web\\PushNotificationController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.notification.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/notification/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.notification.create',
        'uses' => 'App\\Http\\Controllers\\Web\\PushNotificationController@getCreate',
        'controller' => 'App\\Http\\Controllers\\Web\\PushNotificationController@getCreate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.notification.bulksend' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/notification/bulksend',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.notification.bulksend',
        'uses' => 'App\\Http\\Controllers\\Web\\PushNotificationController@postAppBulkSend',
        'controller' => 'App\\Http\\Controllers\\Web\\PushNotificationController@postAppBulkSend',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.web-notification.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/web-notification/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.web-notification.create',
        'uses' => 'App\\Http\\Controllers\\Web\\PushNotificationController@getWebCreate',
        'controller' => 'App\\Http\\Controllers\\Web\\PushNotificationController@getWebCreate',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.notification.web-push' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/notification/web-push',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.notification.web-push',
        'uses' => 'App\\Http\\Controllers\\Web\\PushNotificationController@sendWebNotification',
        'controller' => 'App\\Http\\Controllers\\Web\\PushNotificationController@sendWebNotification',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.notification.image-upload' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web/notification/image-upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.notification.image-upload',
        'uses' => 'App\\Http\\Controllers\\Web\\PushNotificationController@ajaxImageUpload',
        'controller' => 'App\\Http\\Controllers\\Web\\PushNotificationController@ajaxImageUpload',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.notification.device-list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/notification/device-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.notification.device-list',
        'uses' => 'App\\Http\\Controllers\\Web\\PushNotificationController@getDeviceList',
        'controller' => 'App\\Http\\Controllers\\Web\\PushNotificationController@getDeviceList',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.subscriber' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/subscriber',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.subscriber',
        'uses' => 'App\\Http\\Controllers\\Web\\SubscriberController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Web\\SubscriberController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web.contact' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'web/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
          2 => 'acl:view_web_settings',
        ),
        'as' => 'web.contact',
        'uses' => 'App\\Http\\Controllers\\Web\\ContactController@getIndex',
        'controller' => 'App\\Http\\Controllers\\Web\\ContactController@getIndex',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'notification.save-token' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'notification/save-token',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:admin',
        ),
        'as' => 'notification.save-token',
        'uses' => 'App\\Http\\Controllers\\Web\\PushNotificationController@postBulkToken',
        'controller' => 'App\\Http\\Controllers\\Web\\PushNotificationController@postBulkToken',
        'namespace' => 'App\\Http\\Controllers\\Web',
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
