<?php return array (
  'apidoc' => 
  array (
    'type' => 'static',
    'output_folder' => 'public/docs',
    'laravel' => 
    array (
      'autoload' => false,
      'docs_url' => '/doc',
      'middleware' => 
      array (
      ),
    ),
    'router' => 'laravel',
    'storage' => 'local',
    'base_url' => NULL,
    'postman' => 
    array (
      'enabled' => true,
      'name' => NULL,
      'description' => NULL,
      'auth' => NULL,
    ),
    'routes' => 
    array (
      0 => 
      array (
        'match' => 
        array (
          'domains' => 
          array (
            0 => '*',
          ),
          'prefixes' => 
          array (
            0 => '*',
          ),
          'versions' => 
          array (
            0 => 'v1',
          ),
        ),
        'include' => 
        array (
        ),
        'exclude' => 
        array (
        ),
        'apply' => 
        array (
          'headers' => 
          array (
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
          ),
          'response_calls' => 
          array (
            'methods' => 
            array (
              0 => 'GET',
            ),
            'config' => 
            array (
              'app.env' => 'documentation',
              'app.debug' => false,
            ),
            'cookies' => 
            array (
            ),
            'queryParams' => 
            array (
            ),
            'bodyParams' => 
            array (
            ),
          ),
        ),
      ),
    ),
    'strategies' => 
    array (
      'metadata' => 
      array (
        0 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\Metadata\\GetFromDocBlocks',
      ),
      'urlParameters' => 
      array (
        0 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\UrlParameters\\GetFromUrlParamTag',
      ),
      'queryParameters' => 
      array (
        0 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\QueryParameters\\GetFromQueryParamTag',
      ),
      'headers' => 
      array (
        0 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\RequestHeaders\\GetFromRouteRules',
      ),
      'bodyParameters' => 
      array (
        0 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\BodyParameters\\GetFromBodyParamTag',
      ),
      'responses' => 
      array (
        0 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\Responses\\UseTransformerTags',
        1 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\Responses\\UseResponseTag',
        2 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\Responses\\UseResponseFileTag',
        3 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\Responses\\UseApiResourceTags',
        4 => 'Mpociot\\ApiDoc\\Extracting\\Strategies\\Responses\\ResponseCalls',
      ),
    ),
    'logo' => false,
    'default_group' => 'general',
    'example_languages' => 
    array (
      0 => 'bash',
      1 => 'javascript',
    ),
    'fractal' => 
    array (
      'serializer' => NULL,
    ),
    'faker_seed' => NULL,
    'routeMatcher' => 'Mpociot\\ApiDoc\\Matching\\RouteMatcher',
  ),
  'app' => 
  array (
    'name' => 'Medsurlink',
<<<<<<< HEAD
    'env' => 'production',
    'debug' => true,
    'url' => 'https://www.back.medsurlink.com',
    'asset_url' => NULL,
    'frontend_url' => 'https://www.medsurlink.com/login',
    'momo_url' => 'https://proxy.momoapi.mtn.com',
    'stripe_key' => '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',
=======
    'env' => 'local',
    'debug' => true,
    'url' => 'http://127.0.0.1:8001/api/',
    'asset_url' => NULL,
    'frontend_url' => 'www.medsurlink.com/login',
    'momo_url' => 'https://proxy.momoapi.mtn.com',
    'stripe_key' => 'sk_test_51HfRm5AB7Hl5NGXsFgNP6YeAnDn8W4ieGbRuREW0YU1IJRIXPvlNEDYANGCStZ3KP4aGV5mWewJQevVmdPlPh5RR00FDtdo9q5',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
    'url_loccale' => 'http://localhost:8080',
    'url_stagging' => 'https://www.staging.medsurlink.com',
    'url_prod' => 'https://www.medsurlink.com',
    'teleconsultation_loccale' => 'http://localhost:8081',
    'teleconsultation_stagging' => 'https://staging-teleconsultations.medsurlink.com',
    'teleconsultation_prod' => 'https://teleconsultations.medsurlink.com',
    'password' => 
    array (
      'moderator' => '9UqG@CQAE6dfB',
      'attendee' => '8UqG@CQAE9dfB',
    ),
    'timezone' => 'Africa/Douala',
    'locale' => 'fr',
    'fallback_locale' => 'fr',
    'faker_locale' => 'en_US',
<<<<<<< HEAD
    'key' => 'base64:5vDNggwGuY3FXVhfdI8ehD1CXj9yTWNXwXAZScxJKBw=',
=======
    'key' => 'base64:E26NBpavaocwuzD5sOgwZkiJye9ejG5+5/rGdxEL6po=',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
    'cipher' => 'AES-256-CBC',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Spatie\\Permission\\PermissionServiceProvider',
      23 => 'Barryvdh\\DomPDF\\ServiceProvider',
      24 => 'Barryvdh\\Snappy\\ServiceProvider',
      25 => 'Gbrock\\Table\\Providers\\TableServiceProvider',
      26 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
      27 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
      28 => 'LaraCrafts\\UrlShortener\\UrlShortenerServiceProvider',
      29 => 'App\\Providers\\AppServiceProvider',
      30 => 'App\\Providers\\AuthServiceProvider',
      31 => 'App\\Providers\\EventServiceProvider',
      32 => 'App\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'SPDF' => 'Barryvdh\\Snappy\\Facades\\SnappyPdf',
      'SnappyImage' => 'Barryvdh\\Snappy\\Facades\\SnappyImage',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'passport',
        'provider' => 'users',
        'hash' => false,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'redis',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'cluster' => 'mt1',
          'encrypted' => true,
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'redis',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
<<<<<<< HEAD
        'path' => '/var/www/html/medicalink-app/storage/framework/cache/data',
=======
        'path' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/framework/cache/data',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
    ),
    'prefix' => 'medsurlink_cache',
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
<<<<<<< HEAD
        'database' => 'medsurlink',
=======
        'database' => 'DB_MEDSURLINK',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
<<<<<<< HEAD
        'database' => 'medsurlink',
        'username' => 'eric',
        'password' => '/9qmvKFmX',
=======
        'database' => 'DB_MEDSURLINK',
        'username' => 'root',
        'password' => 'root',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'modes' => 
        array (
          0 => 'STRICT_TRANS_TABLES',
          1 => 'NO_ZERO_IN_DATE',
          2 => 'NO_ZERO_DATE',
          3 => 'ERROR_FOR_DIVISION_BY_ZERO',
          4 => 'NO_ENGINE_SUBSTITUTION',
        ),
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
<<<<<<< HEAD
        'database' => 'medsurlink',
        'username' => 'eric',
        'password' => '/9qmvKFmX',
=======
        'database' => 'DB_MEDSURLINK',
        'username' => 'root',
        'password' => 'root',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
<<<<<<< HEAD
        'database' => 'medsurlink',
        'username' => 'eric',
        'password' => '/9qmvKFmX',
=======
        'database' => 'DB_MEDSURLINK',
        'username' => 'root',
        'password' => 'root',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'predis',
      'options' => 
      array (
        'cluster' => 'predis',
        'prefix' => 'Medsurlink_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
<<<<<<< HEAD
        'password' => 'p1PYLfg12/D+qhqn6WmYFV3dyYH/wYTUaW9xILIgpAKE+pQrAsfYqFLbaOUULbdYWK+SF4BCeNDWLgGG',
=======
        'password' => 'YE7OFGQXtoayXIhAm04MFMXWj7+xFrgd5coL0FR60Bx91ieT3dKOIt7HQeU/AOXX340zyr+2FRrUH7Q4',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'port' => '6379',
        'database' => 0,
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
<<<<<<< HEAD
        'password' => 'p1PYLfg12/D+qhqn6WmYFV3dyYH/wYTUaW9xILIgpAKE+pQrAsfYqFLbaOUULbdYWK+SF4BCeNDWLgGG',
=======
        'password' => 'YE7OFGQXtoayXIhAm04MFMXWj7+xFrgd5coL0FR60Bx91ieT3dKOIt7HQeU/AOXX340zyr+2FRrUH7Q4',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'port' => '6379',
        'database' => 1,
      ),
      'model_changes_history' => 
      array (
        'host' => '127.0.0.1',
<<<<<<< HEAD
        'password' => 'p1PYLfg12/D+qhqn6WmYFV3dyYH/wYTUaW9xILIgpAKE+pQrAsfYqFLbaOUULbdYWK+SF4BCeNDWLgGG',
=======
        'password' => 'YE7OFGQXtoayXIhAm04MFMXWj7+xFrgd5coL0FR60Bx91ieT3dKOIt7HQeU/AOXX340zyr+2FRrUH7Q4',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'port' => '6379',
        'database' => 0,
      ),
    ),
  ),
  'debug-server' => 
  array (
    'host' => 'tcp://127.0.0.1:9912',
  ),
  'debugbar' => 
  array (
    'enabled' => NULL,
    'except' => 
    array (
      0 => 'telescope*',
      1 => 'horizon*',
    ),
    'storage' => 
    array (
      'enabled' => true,
      'driver' => 'file',
<<<<<<< HEAD
      'path' => '/var/www/html/medicalink-app/storage/debugbar',
=======
      'path' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/debugbar',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
      'connection' => NULL,
      'provider' => '',
    ),
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'error_handler' => false,
    'clockwork' => false,
    'collectors' => 
    array (
      'phpinfo' => true,
      'messages' => true,
      'time' => true,
      'memory' => true,
      'exceptions' => true,
      'log' => true,
      'db' => true,
      'views' => true,
      'route' => true,
      'auth' => false,
      'gate' => true,
      'session' => true,
      'symfony_request' => true,
      'mail' => true,
      'laravel' => false,
      'events' => false,
      'default_request' => false,
      'logs' => false,
      'files' => false,
      'config' => false,
      'cache' => false,
      'models' => true,
      'livewire' => true,
    ),
    'options' => 
    array (
      'auth' => 
      array (
        'show_name' => true,
      ),
      'db' => 
      array (
        'with_params' => true,
        'backtrace' => true,
        'backtrace_exclude_paths' => 
        array (
        ),
        'timeline' => false,
        'explain' => 
        array (
          'enabled' => false,
          'types' => 
          array (
            0 => 'SELECT',
          ),
        ),
        'hints' => false,
      ),
      'mail' => 
      array (
        'full_log' => false,
      ),
      'views' => 
      array (
        'data' => false,
      ),
      'route' => 
      array (
        'label' => true,
      ),
      'logs' => 
      array (
        'file' => NULL,
      ),
      'cache' => 
      array (
        'values' => true,
      ),
    ),
    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_domain' => NULL,
    'theme' => 'auto',
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => 
    array (
<<<<<<< HEAD
      'font_dir' => '/var/www/html/medicalink-app/storage/fonts/',
      'font_cache' => '/var/www/html/medicalink-app/storage/fonts/',
      'temp_dir' => '/tmp',
      'chroot' => '/var/www/html/medicalink-app',
=======
      'font_dir' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/fonts/',
      'font_cache' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/fonts/',
      'temp_dir' => '/tmp',
      'chroot' => '/home/medsur/Documents/projets/medsurlink/medicalink-app',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => false,
    ),
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'strict_null_comparison' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'ignore_empty' => false,
      'heading_row' => 
      array (
        'formatter' => 'slug',
      ),
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
      'properties' => 
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' => 
    array (
      'driver' => 'memory',
      'batch' => 
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' => 
      array (
        'store' => NULL,
      ),
    ),
    'transactions' => 
    array (
      'handler' => 'db',
    ),
    'temporary_files' => 
    array (
<<<<<<< HEAD
      'local_path' => '/var/www/html/medicalink-app/storage/framework/laravel-excel',
=======
      'local_path' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/framework/laravel-excel',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
      'force_resync_remote' => NULL,
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
<<<<<<< HEAD
        'root' => '/var/www/html/medicalink-app/storage/app',
=======
        'root' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/app',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'permissions' => 
        array (
          'file' => 
          array (
            'public' => 436,
            'private' => 384,
          ),
          'dir' => 
          array (
            'public' => 509,
            'private' => 448,
          ),
        ),
      ),
      'public' => 
      array (
        'driver' => 'local',
<<<<<<< HEAD
        'root' => '/var/www/html/medicalink-app/storage/app/public',
        'url' => 'https://www.back.medsurlink.com/storage',
=======
        'root' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/app/public',
        'url' => 'http://127.0.0.1:8001/api//storage',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
      ),
      'model_changes_history' => 
      array (
        'driver' => 'local',
<<<<<<< HEAD
        'root' => '/var/www/html/medicalink-app/storage/app/model_changes_history',
=======
        'root' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/app/model_changes_history',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
      ),
    ),
  ),
  'gbrock-tables' => 
  array (
    'key_field' => 'sort',
    'key_direction' => 'dir',
    'default_direction' => 'asc',
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'daily',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
<<<<<<< HEAD
        'path' => '/var/www/html/medicalink-app/storage/logs/laravel.log',
=======
        'path' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/logs/laravel.log',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
<<<<<<< HEAD
        'path' => '/var/www/html/medicalink-app/storage/logs/laravel.log',
=======
        'path' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/logs/laravel.log',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
<<<<<<< HEAD
    'host' => 'ssl0.ovh.net',
    'port' => '587',
    'from' => 
    array (
      'address' => 'noreply@medicasure.com',
      'name' => 'Medsurlink',
    ),
    'encryption' => 'TLS',
    'username' => 'noreply@medicasure.com',
    'password' => 'ta4Tvb2D304E',
=======
    'host' => 'smtp.mailtrap.io',
    'port' => '2525',
    'from' => 
    array (
      'address' => 'noreply@medsurlink.com',
      'name' => 'Medsurlink',
    ),
    'encryption' => 'tls',
    'username' => '82f0518b22d1a6',
    'password' => '84b09b0ecd5139',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
<<<<<<< HEAD
        0 => '/var/www/html/medicalink-app/resources/views/vendor/mail',
=======
        0 => '/home/medsur/Documents/projets/medsurlink/medicalink-app/resources/views/vendor/mail',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
      ),
    ),
    'log_channel' => NULL,
  ),
  'model_changes_history' => 
  array (
    'record_changes_history' => true,
    'use_only_for_debug' => true,
    'record_stack_trace' => true,
    'ignored_actions' => 
    array (
    ),
    'storage' => 'database',
    'stores' => 
    array (
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'model_changes_history',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'disk' => 'model_changes_history',
        'file_name' => 'changes_history.txt',
        'model_changes_history' => 
        array (
          'driver' => 'local',
<<<<<<< HEAD
          'root' => '/var/www/html/medicalink-app/storage/app/model_changes_history',
=======
          'root' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/app/model_changes_history',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'key' => 'model_changes_history',
        'connection' => 'model_changes_history',
        'model_changes_history' => 
        array (
          'host' => '127.0.0.1',
<<<<<<< HEAD
          'password' => 'p1PYLfg12/D+qhqn6WmYFV3dyYH/wYTUaW9xILIgpAKE+pQrAsfYqFLbaOUULbdYWK+SF4BCeNDWLgGG',
=======
          'password' => 'YE7OFGQXtoayXIhAm04MFMXWj7+xFrgd5coL0FR60Bx91ieT3dKOIt7HQeU/AOXX340zyr+2FRrUH7Q4',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
          'port' => '6379',
          'database' => 0,
        ),
      ),
    ),
  ),
  'passport' => 
  array (
    'private_key' => NULL,
    'public_key' => NULL,
  ),
  'permission' => 
  array (
    'models' => 
    array (
      'permission' => 'Spatie\\Permission\\Models\\Permission',
      'role' => 'Spatie\\Permission\\Models\\Role',
    ),
    'table_names' => 
    array (
      'roles' => 'roles',
      'permissions' => 'permissions',
      'model_has_permissions' => 'model_has_permissions',
      'model_has_roles' => 'model_has_roles',
      'role_has_permissions' => 'role_has_permissions',
    ),
    'column_names' => 
    array (
      'model_morph_key' => 'model_id',
    ),
    'display_permission_in_exception' => false,
    'cache' => 
    array (
      'expiration_time' => 
      DateInterval::__set_state(array(
         'y' => 0,
         'm' => 0,
         'd' => 0,
         'h' => 24,
         'i' => 0,
         's' => 0,
         'f' => 0.0,
         'weekday' => 0,
         'weekday_behavior' => 0,
         'first_last_day_of' => 0,
         'invert' => 0,
         'days' => false,
         'special_type' => 0,
         'special_amount' => 0,
         'have_weekday_relative' => 0,
         'have_special_relative' => 0,
      )),
      'key' => 'spatie.permission.cache',
      'model_key' => 'name',
      'store' => 'default',
    ),
  ),
  'queue' => 
  array (
    'default' => 'redis',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ),
    ),
    'failed' => 
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'model' => 'App\\User',
      'key' => NULL,
      'secret' => NULL,
      'webhook' => 
      array (
        'secret' => NULL,
        'tolerance' => 300,
      ),
    ),
    'teleconsultations' => 
    array (
<<<<<<< HEAD
      'base_uri' => 'http://back-teleconsultations.medsurlink.com',
=======
      'base_uri' => 'http://localhost:8002',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
      'secret' => 'EgDwYss1HthxUbAjbRViO0QaNF82gsJIyCiKXiZr',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
<<<<<<< HEAD
    'files' => '/var/www/html/medicalink-app/storage/framework/sessions',
=======
    'files' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/framework/sessions',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'medsurlink_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
    'same_site' => NULL,
  ),
  'sluggable' => 
  array (
    'source' => NULL,
    'maxLength' => NULL,
    'maxLengthKeepWords' => true,
    'method' => NULL,
    'separator' => '-',
    'unique' => true,
    'uniqueSuffix' => NULL,
    'includeTrashed' => false,
    'reserved' => NULL,
    'onUpdate' => false,
  ),
  'snappy' => 
  array (
    'pdf' => 
    array (
      'enabled' => true,
      'binary' => '"C:\\Program Files (x86)\\wkhtmltopdf\\bin\\wkhtmltopdf"',
      'timeout' => false,
      'options' => 
      array (
      ),
      'env' => 
      array (
      ),
    ),
    'image' => 
    array (
      'enabled' => true,
      'binary' => '/usr/local/bin/wkhtmltoimage',
      'timeout' => false,
      'options' => 
      array (
      ),
      'env' => 
      array (
      ),
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
  'trustedproxy' => 
  array (
    'proxies' => NULL,
    'headers' => 30,
  ),
  'view' => 
  array (
    'paths' => 
    array (
<<<<<<< HEAD
      0 => '/var/www/html/medicalink-app/resources/views',
    ),
    'compiled' => '/var/www/html/medicalink-app/storage/framework/views',
=======
      0 => '/home/medsur/Documents/projets/medsurlink/medicalink-app/resources/views',
    ),
    'compiled' => '/home/medsur/Documents/projets/medsurlink/medicalink-app/storage/framework/views',
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'medialibrary' => 
  array (
    'disk_name' => 'public',
    'max_file_size' => 10485760,
    'queue_name' => '',
    'media_model' => 'Spatie\\MediaLibrary\\Models\\Media',
    's3' => 
    array (
      'domain' => 'https://.s3.amazonaws.com',
    ),
    'remote' => 
    array (
      'extra_headers' => 
      array (
        'CacheControl' => 'max-age=604800',
      ),
    ),
    'responsive_images' => 
    array (
      'width_calculator' => 'Spatie\\MediaLibrary\\ResponsiveImages\\WidthCalculator\\FileSizeOptimizedWidthCalculator',
      'use_tiny_placeholders' => true,
      'tiny_placeholder_generator' => 'Spatie\\MediaLibrary\\ResponsiveImages\\TinyPlaceholderGenerator\\Blurred',
    ),
    'url_generator' => NULL,
    'version_urls' => false,
    'path_generator' => NULL,
    'image_optimizers' => 
    array (
      'Spatie\\ImageOptimizer\\Optimizers\\Jpegoptim' => 
      array (
        0 => '--strip-all',
        1 => '--all-progressive',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Pngquant' => 
      array (
        0 => '--force',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Optipng' => 
      array (
        0 => '-i0',
        1 => '-o2',
        2 => '-quiet',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Svgo' => 
      array (
        0 => '--disable=cleanupIDs',
      ),
      'Spatie\\ImageOptimizer\\Optimizers\\Gifsicle' => 
      array (
        0 => '-b',
        1 => '-O3',
      ),
    ),
    'image_generators' => 
    array (
      0 => 'Spatie\\MediaLibrary\\ImageGenerators\\FileTypes\\Image',
      1 => 'Spatie\\MediaLibrary\\ImageGenerators\\FileTypes\\Webp',
      2 => 'Spatie\\MediaLibrary\\ImageGenerators\\FileTypes\\Pdf',
      3 => 'Spatie\\MediaLibrary\\ImageGenerators\\FileTypes\\Svg',
      4 => 'Spatie\\MediaLibrary\\ImageGenerators\\FileTypes\\Video',
    ),
    'image_driver' => 'gd',
    'ffmpeg_path' => '/usr/bin/ffmpeg',
    'ffprobe_path' => '/usr/bin/ffprobe',
    'temporary_directory_path' => NULL,
    'jobs' => 
    array (
      'perform_conversions' => 'Spatie\\MediaLibrary\\Jobs\\PerformConversions',
      'generate_responsive_images' => 'Spatie\\MediaLibrary\\Jobs\\GenerateResponsiveImages',
    ),
  ),
<<<<<<< HEAD
=======
  'ide-helper' => 
  array (
    'filename' => '_ide_helper',
    'format' => 'php',
    'meta_filename' => '.phpstorm.meta.php',
    'include_fluent' => false,
    'include_factory_builders' => false,
    'write_model_magic_where' => true,
    'write_model_relation_count_properties' => true,
    'write_eloquent_model_mixins' => false,
    'include_helpers' => false,
    'helper_files' => 
    array (
      0 => '/home/medsur/Documents/projets/medsurlink/medicalink-app/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
    ),
    'model_locations' => 
    array (
      0 => 'app',
    ),
    'ignored_models' => 
    array (
    ),
    'extra' => 
    array (
      'Eloquent' => 
      array (
        0 => 'Illuminate\\Database\\Eloquent\\Builder',
        1 => 'Illuminate\\Database\\Query\\Builder',
      ),
      'Session' => 
      array (
        0 => 'Illuminate\\Session\\Store',
      ),
    ),
    'magic' => 
    array (
    ),
    'interfaces' => 
    array (
    ),
    'custom_db_types' => 
    array (
    ),
    'model_camel_case_properties' => false,
    'type_overrides' => 
    array (
      'integer' => 'int',
      'boolean' => 'bool',
    ),
    'include_class_docblocks' => false,
  ),
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
  'url-shortener' => 
  array (
    'default' => 'tiny_url',
    'shorteners' => 
    array (
      'bit_ly' => 
      array (
        'driver' => 'bit_ly',
        'domain' => 'bit.ly',
        'token' => NULL,
      ),
      'firebase' => 
      array (
        'driver' => 'firebase',
        'prefix' => NULL,
        'token' => NULL,
        'suffix' => 'UNGUESSABLE',
      ),
      'is_gd' => 
      array (
        'driver' => 'is_gd',
        'base_uri' => 'https://is.gd',
        'statistics' => false,
      ),
      'ouo_io' => 
      array (
        'driver' => 'ouo_io',
        'token' => NULL,
      ),
      'polr' => 
      array (
        'driver' => 'polr',
        'prefix' => NULL,
        'token' => NULL,
      ),
      'shorte_st' => 
      array (
        'driver' => 'shorte_st',
        'token' => NULL,
      ),
      'tiny_url' => 
      array (
        'driver' => 'tiny_url',
      ),
      'v_gd' => 
      array (
        'driver' => 'is_gd',
        'base_uri' => 'https://v.gd',
        'statistics' => false,
      ),
    ),
  ),
<<<<<<< HEAD
  'ide-helper' => 
  array (
    'filename' => '_ide_helper',
    'format' => 'php',
    'meta_filename' => '.phpstorm.meta.php',
    'include_fluent' => false,
    'include_factory_builders' => false,
    'write_model_magic_where' => true,
    'write_model_relation_count_properties' => true,
    'write_eloquent_model_mixins' => false,
    'include_helpers' => false,
    'helper_files' => 
    array (
      0 => '/var/www/html/medicalink-app/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
    ),
    'model_locations' => 
    array (
      0 => 'app',
    ),
    'ignored_models' => 
    array (
    ),
    'extra' => 
    array (
      'Eloquent' => 
      array (
        0 => 'Illuminate\\Database\\Eloquent\\Builder',
        1 => 'Illuminate\\Database\\Query\\Builder',
      ),
      'Session' => 
      array (
        0 => 'Illuminate\\Session\\Store',
      ),
    ),
    'magic' => 
    array (
    ),
    'interfaces' => 
    array (
    ),
    'custom_db_types' => 
    array (
    ),
    'model_camel_case_properties' => false,
    'type_overrides' => 
    array (
      'integer' => 'int',
      'boolean' => 'bool',
    ),
    'include_class_docblocks' => false,
  ),
=======
>>>>>>> 3f2b4ea1aa2d1a6d5214e5c7a8c6a951797f5dbc
);
