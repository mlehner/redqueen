<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Sqlite',
        'dbname'      => '/home/matt/buffalolab/redqueen/redqueen.sqlite',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/Controllers/',
        'modelsDir'      => __DIR__ . '/../../app/Models/',
        'formsDir'       => __DIR__ . '/../../app/Forms/',
        'viewsDir'       => __DIR__ . '/../../app/Views/',
        'validatorDir'       => __DIR__ . '/../../app/Validators/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'baseUri'        => '/',
    )
));
