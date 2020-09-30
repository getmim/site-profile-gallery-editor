<?php

return [
    '__name' => 'site-profile-gallery-editor',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/site-profile-gallery-editor.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/site-profile-gallery-editor' => ['install','update','remove'],
        'theme/site/profile/gallery/editor' => ['install','remove'],
        'app/site-profile-gallery-editor' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'site-profile-gallery' => NULL
            ],
            [
                'profile-gallery' => NULL
            ],
            [
                'lib-form' => NULL
            ],
            [
                'lib-upload' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'SiteProfileGalleryEditor\\Controller' => [
                'type' => 'file',
                'base' => 'app/site-profile-gallery-editor/controller'
            ],
            'SiteProfileGalleryEditor\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-profile-gallery-editor/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteProfileGalleryIndex' => [
                'path' => [
                    'value' => '/profile/(:profile)/gallery',
                    'params' => [
                        'profile' => 'slug'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteProfileGalleryEditor\\Controller\\Gallery::index'
            ],
            'siteProfileGalleryEdit' => [
                'path' => [
                    'value' => '/profile/(:profile)/gallery/(:id)/edit',
                    'params' => [
                        'id' => 'number',
                        'profile' => 'slug'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteProfileGalleryEditor\\Controller\\Gallery::edit'
            ],
            'siteProfileGalleryRemove' => [
                'path' => [
                    'value' => '/profile/(:profile)/gallery/(:id)/remove',
                    'params' => [
                        'id' => 'number',
                        'profile' => 'slug'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteProfileGalleryEditor\\Controller\\Gallery::remove'
            ],
        ]
    ],
    'libForm' => [
        'forms' => [
            'site.profile-gallery.edit' => [
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE
                    ]
                ],
                'images' => [
                    'label' => 'Image List',
                    'type' => 'textarea',
                    'rules' => [
                        'json' => TRUE
                    ]
                ]
            ]
        ]
    ]
];