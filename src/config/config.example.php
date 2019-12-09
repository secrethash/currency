<?php

return [

    /**
     * Default Converter (String)
     * ------------------------------------------------------
     * This Defines from which currency conversion
     * service provider's do you want to start the conversions
     * with.
     * ------------------------------------------------------
     * Values: 'currencylayer', 'exchangerate'
     */
    "default" => "exchangerate",

    /**
     * Self Drive Mode (Boolean)
     * ------------------------------------------------------
     * This defines whether the Self Drive Mode or the
     * Smart Mode will be ON (true) or OFF (false).
     * ------------------------------------------------------
     * Values: true, false
     */
    "selfdrive" => true,

    /**
     * Cache Duration (Integer)
     * ------------------------------------------------------
     * This Smart Conversions Library uses the Caching to
     * reduce the Quota Utilizations by Caching the Rates
     * and utilising it on concurrent requests.
     * Set it to `0` for real-time updates.
     * (!) NOTE: Usually Providers update their rate on
     *     Hourly basis. Therefore if on free plan, setting it
     *     on real-time updates will only consume your quota.
     * ------------------------------------------------------
     * Values: Any time frame in Minutes.
     */
    "cache" => 30, # in Minutes
    
    /**
     * Cache Duration (Integer)
     * ------------------------------------------------------
     * This Smart Conversions Library uses the Caching to
     * reduce the Quota Utilizations by Caching the Rates
     * and utilising it on concurrent requests.
     * This would not be used if real-time updates are
     * active and running.
     * ------------------------------------------------------
     * Values: Folder Location from the root directory of this library.
     */
    "cache_path" => "cache/", # folder location

    /**
     * API Details (String)
     * ------------------------------------------------------
     * API Details for the CurrencyLayer API
     * ------------------------------------------------------
     * GET YOUR KEY FROM https://www.exchangerate-api.com/
     * GET YOUR KEY FROM https://www.currencylayer.com/
     * ------------------------------------------------------
     * Values: array
     */
    "api" => [
        "currencylayer" => [
            "key" => "YOUR_API_KEY_HERE",
            "provider" => "http://apilayer.net/api/live?access_key=%s&currencies=%s&format=1",
        ],

        "exchangerate" => [
            "key" => "YOUR_API_KEY_HERE",
            "provider" => "https://v3.exchangerate-api.com/pair/%s/%s/%s",
        ],
    ],
];


