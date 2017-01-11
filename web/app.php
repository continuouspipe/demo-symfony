<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$environment = getenv('SYMFONY_ENV');
if ($environment === false) {
    $environment = 'prod';
}

if (($useDebugging = getenv('SYMFONY_DEBUG')) === false || $useDebugging === '') {
    $useDebugging = $environment === 'dev';
}

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';

if (!$useDebugging) {
    include_once __DIR__ . '/../var/bootstrap.php.cache';
}

require_once __DIR__ . '/../app/AppKernel.php';

if ($useDebugging) {
    Debug::enable();
}

$kernel = new AppKernel($environment, $useDebugging);

// we don't want to use the classes cache if we are in a debug session
if (!$useDebugging) {
    $kernel->loadClassCache();
}


// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
