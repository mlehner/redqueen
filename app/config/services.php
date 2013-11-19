<?php

use Phalcon\DI\FactoryDefault,
Phalcon\Mvc\View,
Phalcon\Mvc\Url as UrlResolver,
Phalcon\Mvc\View\Engine\Volt as VoltEngine,
Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter,
Phalcon\Mvc\Router\Annotations as RouterAnnotations,
Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Load router from external file
 */
$di->set('router', function(){
    require __DIR__.'/routing.php';
    return $router;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function() use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function() use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
            '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
        ));

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function() use ($config) {
    $db_class = 'Phalcon\\Db\\Adapter\\Pdo\\' . $config->database->adapter;
    if (!class_exists($db_class)) {
        throw new \InvalidArgumentException(sprintf('Invalid Db Adapter class: %s', $db_class));
    }

    return new $db_class((array) $config->database);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function() {
    return new MetaDataAdapter();

    // Instantiate a meta-data adapter
    $metaData = new ApcMetaData(array(
        "lifetime" => 86400,
        "prefix"   => "my-prefix"
    ));

    //Set a custom meta-data database introspection
    $metaData->setStrategy(new StrategyAnnotations());

    return $metaData;
});

/**
 * Re-register Security for more control over workfactor
 */
$di->set('security', function() { 
    $security = new Phalcon\Security();

    $security->setWorkFactor(15);

    return $security;

});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function() {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});
