<?php return [
	// This contains the Laravel Packages that you want this plugin to utilize listed under their package identifiers
    'packages' => [
        'mews/purifier' => [
	        // Service providers to be registered by your plugin
            'providers' => [
                '\Mews\Purifier\PurifierServiceProvider',
            ],
            
            // Aliases to be registered by your plugin in the form of $alias => $pathToFacade
            'aliases' => [
                'Purifier' => '\Mews\Purifier\Facades\Purifier',
            ],
            
            // The namespace to set the configuration under. For this example, this package accesses it's config via config('purifier.' . $key), so the namespace 'purifier' is what we put here
            'config_namespace' => 'purifier',
            
            // The configuration file for the package itself. Start this out by copying the default one that comes with the package and then modifying what you need.
            'config' => [
                'encoding'      => 'UTF-8',
                'finalize'      => true,
                'cachePath'     => storage_path('app/purifier'),
                'cacheFileMode' => 0755,
                'settings'      => [
                    'default' => [
                        'HTML' => [
                            'Doctype'             => 'XHTML 1.0 Strict',
                            'Allowed'             => 'div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]',
                        ],
                        'CSS'  => [
                            'AllowedProperties'   => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
                        ],
                        'AutoFormat' => [
                            'AutoParagraph' => true,
                            'RemoveEmpty'   => true,
                        ],
                    ],
                    'test'    => [
                        'Attr' => ['EnableID' => true]
                    ],
                    "youtube" => [
                        "HTML" => ["SafeIframe" => 'true'],
                        "URI"  => ["SafeIframeRegexp" => "%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%"],
                    ],
                ],
            ],
        ],
    ],
];
