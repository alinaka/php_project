<?php

namespace Framework\Http\Router;

use Aura\Router\RouterContainer;
use Aura\Router\Exception\RouteNotFound;
use Psr\Http\Message\ServerRequestInterface;

class AuraRouterAdapter
{
    private $aura;
    
    public function __construct(RouterContainer $aura)
    {
        $this->aura = $aura;
    }
    
    public function match(ServerRequestInterface $request) : Result
    {
        $matcher = $this->aura->getMatcher();
        if($route = $matcher->match($request)){
            return new Result($route->name, $route->handler, $route->attributes);
        }
        throw new RequestNotMatchedException($request);
    }
    
    public function generate($name, array $params) : string
    {
        $generator = $this->aura->getGenerator();
        try {
            return $generator->generate($name, $params);
        } catch (RouteNotFound $e) {
            throw new RouteNotFoundException($name, $params, $e);
        }
    }
}