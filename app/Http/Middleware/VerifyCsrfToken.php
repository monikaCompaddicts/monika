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
    protected $except = [ '/getChildCategory', '/deleteCategory', '/changeVendorStatus', 'orderCategory', 'getCMSContent', '/changeAdStatus',
                            'api/get-category',
                            '/test-api',
                            'api/get-locations',
                            'api/add-vendor',
                            'api/login-vendor',
                            'api/get-sub-category',
                            'api/post-ad',
                            'api/receive-alert-user',
                            'api/search-ads',
                            'api/get-advertisement/{page?}',
                            'api/get-cms',
                            'api/update-user-profile',
                            'api/update-user-address',
                            'api/get-user-details',
                            'api/change-password',
                            'api/get-dashboard',
                            'api/get-ad-details',
                            'api/send-enquiry',
                            'api/forgot-password',
                            'api/get-vendor-ad-details',
                            'api/delete-vendor-ad',
                            'api/get-ad-bycatid',
                            'api/edit-ad',
                            'api/get-customer-ad-details',
                            'api/add-vendor-provider',
                            'api/contact-us',
                            'api/change-ad-status',
                            'api/save-review',
                            'api/delete-ad-image',
                            'api/post-report',
                            'api/save-ad-without-login',
                            'api/match-otp-post-ad',
                            'api/resend-otp',
                            'api/site-info',
                            'change-advertismente-status',
                            'change-client-status'
        //
    ];
}
