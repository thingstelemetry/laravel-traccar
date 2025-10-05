<?php

declare(strict_types=1);

return [

    /*
     |--------------------------------------------------------------------------
     | Traccar API Key
     |--------------------------------------------------------------------------
     | The API key used to authenticate requests to the Traccar server.
     | You can obtain this from your Traccar server administrator or
     | configuration settings.
     */
    'api_key' => env('TRACCAR_API_KEY'),

    /*
     |--------------------------------------------------------------------------
     | Traccar Base URL
     |--------------------------------------------------------------------------
     | The base URL of your Traccar server’s API endpoint.
     | Example: https://your-traccar-server.com/api
     */
    'base_url' => env('TRACCAR_BASE_URL'),
];
