Stack/RegisterGlobals
====================

`Gongo\RegisterGlobals` is a [register_globals](http://php.net/register_globals) (emulator) [Stack](http://stackphp.com/) middleware.

Usage
--------------------

```php
<?php
// index.php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

$app = new Application;
$app->get('/', function (Request $request) {
    $fromRequestObject  = $request->get('foo');
    $fromGlobalVariable = $GLOBALS['foo'];

    return sprintf(
        'request->get("foo"): %s, $GLOBALS["foo"]: %s',
        $fromRequestObject,
        $fromGlobalVariable
    );
});

$stack = (new Stack\Builder())->push('Gongo\RegisterGlobals');

$app = $stack->resolve($app);
$request = Request::createFromGlobals();
$response = $app->handle($request)->send();
$app->terminate($request, $response);
```

And run:

```
$ php -S localhost:5000 index.php
```

And access to `http://localhost:5000/?foo=123`, display following:

```
request->get("foo"): 123, $GLOBALS["foo"]: 123
```

E.g.

```diff
-$stack = (new Stack\Builder())->push('Gongo\RegisterGlobals');
+$stack = new Stack\Builder;
```

Then:

```
request->get("foo"): 123, $GLOBALS["foo"]:
```

IMPORTANT
--------------------

For now, `$_SESSION` is not injected to `$GLOBALS`. Only `EGPCS` superglobals.

License
--------------------

MIT License.
