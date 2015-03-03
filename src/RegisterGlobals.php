<?php
namespace Gongo;

use Gongo\MercifulPolluter\Request as RequestPolluter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class RegisterGlobals implements HttpKernelInterface
{
    private $app;

    public function __construct(HttpKernelInterface $app, array $options = [])
    {
        $this->app = $app;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        (new RequestPolluter)->pollute();
        return $this->app->handle($request, $type, $catch);
    }
}
