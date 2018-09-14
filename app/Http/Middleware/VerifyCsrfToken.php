<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [ '/admin/getChildCategory', '/admin/deleteCategory', '/admin/changeVendorStatus',
    						'api/get-category',
    						'/test-api',
    						'api/get-locations',
    						'api/add-vendor',
    						'api/login-vendor',
        //
    ];
}
