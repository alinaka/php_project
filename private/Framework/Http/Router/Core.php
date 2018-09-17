<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class Core
{
    protected $matcher;
    protected $resolver;

    public function __construct($router)
    {
        $this->matcher = $router;
        $this->resolver = new ActionResolver();
    }

    public function handle(ServerRequestInterface $request)
    {
        try {
            $result = $this->matcher->match($request);
            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }
            /** @var callable $action */
            $handler = $result->getHandler();

            return $this->resolver->resolve($handler, $request);
        } catch (RequestNotMatchedException $e) {
            return HtmlResponse('Undefined page', 404);
        }
    }
}
