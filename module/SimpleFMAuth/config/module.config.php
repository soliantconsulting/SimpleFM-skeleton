<?php
/**
 * SimpleFM-skeleton
 * @author jsmall@soliantconsulting.com
 */

return [
    'service_manager' => [
        'factories' => [
            'sfm_validation_adapter' => \SimpleFMAuth\Factory\ValidationAdapterFactory::class,
            'sfm_auth_adapter' => \SimpleFMAuth\Factory\AuthenticationAdapterFactory::class,
            'sfm_auth_service' => \SimpleFMAuth\Factory\AuthenticationServiceFactory::class,
            'sfm_auth_storage' => \SimpleFMAuth\Factory\AuthenticationStorageFactory::class,
        ],
    ],
];
