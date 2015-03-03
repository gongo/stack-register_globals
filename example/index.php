<?php
require __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app = new Application;
$app->register(new TwigServiceProvider, array('twig.path' => __DIR__ . '/'));

$app->get('/', function (Request $request) use ($app) {
    $records = array();

    foreach (array_keys($_GET) as $key) {
        $records[$key] = array(
            'request' => $request->get($key),
            'global'  => $GLOBALS[$key],
        );
    }

    return $app['twig']->render('index.twig', array('records' => $records));
});

$stack = (new Stack\Builder())->push('Gongo\RegisterGlobals');
// $stack = new Stack\Builder();

$app = $stack->resolve($app);
$request = Request::createFromGlobals();
$response = $app->handle($request)->send();
$app->terminate($request, $response);
