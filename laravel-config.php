<?php

return [

    /**
     * Integratino mode
     * Possible value: "development", "production"
     */
    'mode'  => env('PRISMALINK_MODE', 'production'),

    /**
     * Merchant ID
     */
    'merchant_id'     => env('PRISMALINK_MERCHANT_ID', ''),

    /**
     * Key ID
     */
    'key_id'     => env('PRISMALINK_KEY_ID', ''),

    /**
     * Secret Key
     */
    'secret_key'     => env('PRISMALINK_SECRET_KEY', ''),

];
