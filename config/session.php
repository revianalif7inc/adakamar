<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default session "driver" that will be used on
    | requests. By default, we will use the lightweight native driver but
    | you may specify any of the other wonderful drivers provided here.
    |
    | Supported: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that will be allowed to
    | elapse before the user is asked to re-authenticate via login. This is
    | a security feature kept by Laravel to make sure sessions stay secure
    | and a user cannot stay logged in forever.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | When utilizing the "file" or "cookie" session drivers, we need a
    | location where session files may be stored. A default has been set
    | for you but a different location may be specified. This is only
    | needed for file sessions.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | When using the "database" or "redis" session drivers, you may specify a
    | connection that should be used to manage these sessions. This should
    | correspond to a connection in your database configuration options.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table we
    | should use to manage the sessions. Of course, a sensible default has
    | been provided for you; however, you are free to change this as needed.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | When using the "apc", "memcached", or "dynamodb" session drivers you
    | may list a cache store that should be used for these sessions. This
    | value must match with one of the application's configured stores.
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Some session drivers must manually sweep their storage location to get
    | rid of old sessions from storage. Here are the chances that it will
    | happen on a given request. By default, the odds are 2 out of 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Settings
    |--------------------------------------------------------------------------
    |
    | Here you may change the properties of the cookie that is created by the
    | framework when an authenticated session is stored for the user. This
    | setting will be used in template responses sent back to the client.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | This value contains the name of the cookie used to identify a session
    | instance by ID. It should be a string. Other cookie options are defined
    | as top-level configuration keys below to match Laravel expectations.
    |
    */
    'cookie' => env('SESSION_COOKIE', 'ada_kamar_session'),

    /* Cookie options (top-level) */
    'path' => '/',
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIES', false),
    'http_only' => true,
    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Session Expiration on Browser Close
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will expire the session when the browser is
    | closed, and false will allow the session to be valid for the lifetime.
    |
    */

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Encrypt Session Data
    |--------------------------------------------------------------------------
    |
    | This option allows you to easily specify that session data should be
    | encrypted before it is stored. All encryption will automatically be
    | handled transparently for you so you can use the sessions normally.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | HTTP Referer Restriction
    |--------------------------------------------------------------------------
    |
    | By default, Lumen requires a match of the HTTP referer and your URL
    | host name. If you don't want this security feature, set it to false.
    |
    */

];
