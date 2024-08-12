<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Beem API Key
    |--------------------------------------------------------------------------
    |
    | You can obtain this key after creating a Beem vendor account, then
    | visit the Profile tab and click on "Authentication Information"
    |
    */
    'api_key' => env('BEEM_KEY'),

    /*
   |--------------------------------------------------------------------------
   | Beem Secret Key
   |--------------------------------------------------------------------------
   |
   | You can obtain this key after creating a Beem vendor account, then visit
   | the Profile tab and click on "Authentication Information" then Generate
   |
   */
    'secret_key' => env('BEEM_SECRET'),

    /*
   |--------------------------------------------------------------------------
   | Beem Source Address
   |--------------------------------------------------------------------------
   |
   | The title that recipients  will see where the messages are coming from
   |
   */
    'source' => env('BEEM_SOURCE', 'INFO'),

];
