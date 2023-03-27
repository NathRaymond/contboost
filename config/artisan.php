<?php

return [
    'installed' => env('APP_INSTALLED'),
    'version' => env('APP_VERSION', '1.0.0'),
    'admin_prefix' => env('APP_ADMIN_PREFIX', 'admin'),
    'public_files_disk' => env('PUBLIC_FILES_DISK', 'public'),
    'super_admin_role' => env('SUPER_ADMIN_ROLE', 1),
    'front_theme' => env('FRONT_THEME', 'neuralink'),
    'openai_api_key' => env('OPEN_API_KEY'),
    'openai_model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),

    'enabled_cookie_consent' => env('COOKIE_CONSENT_ENABLED', null),
    'cookie_name' => env('COOKIE_NAME', 'airobo'),
    'cookie_lifetime' => env('COOKIE_LIFETIME', '365'),

    /*
    |--------------------------------------------------------------------------
    | Temporary Path
    |--------------------------------------------------------------------------
    |
    | When initially uploading the files we store them in this path
    | By default, it is stored on the public disk which defaults to `/storage/app/public/{temporary_files_path}`
    |
    */
    'temporary_files_path' => env('UPLOADER_TEMP_PATH', 'uploads'),
    'temporary_files_disk' => env('UPLOADER_TEMP_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Chunks path
    |--------------------------------------------------------------------------
    |
    | When using chunks, we want to place them inside of this folder.
    | Make sure it is writeable.
    | Chunks use the same disk as the temporary files do.
    |
    */
    'chunks_path' => env('UPLOADER_CHUNKS_PATH', 'uploads' . DIRECTORY_SEPARATOR . 'chunks'),
    'input_name' => env('UPLOAD_INPUT_NAME', 'upload'),
];
