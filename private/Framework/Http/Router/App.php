<?php

namespace Framework\Http\Router;

use Aura\Router\RouterContainer;
use Zend\Diactoros\ServerRequestFactory;
use Framework\DB;

class App
{
    private $request;
    private $frame;
    private $real_routes;
    private $router;

    public function __construct($config)
    {
        $this->real_routes = $this->getRealRoutes($config);
        $this->request = ServerRequestFactory::fromGlobals();
        $this->router = new AuraRouterAdapter($this->real_routes);
        $this->resolver = new ActionResolver();
    }

    private function getRealRoutes($_config)
    {
        $aura = new RouterContainer();
        $routes = $aura->getMap();
        $_config_arr = json_decode($_config, true);
        foreach ($_config_arr as $key => $value) {
            if ($key == 'urls') {
                $routes_config = $value;
                foreach ($routes_config as $routes_key => $routes_value) {
                    $name = $routes_key;
                    $path = $routes_value['path'];
                    $controller = $routes_value['controller'];
                    $routes->route($name, $path, $controller);
                }
            } elseif ($key == 'db') {
                $db = DB::getInstance();
                $db->setDBConfig($value);
            }
        }
        return $aura;
    }

    public function run()
    {
        try {
            $result = $this->router->match($this->request);
            foreach ($result->getAttributes() as $attribute => $value) {
                $this->request = $this->request->withAttribute($attribute, $value);
            }
            $handler = $result->getHandler();
            return $this->resolver->resolve($handler, $this->request);
        } catch (RequestNotMatchedException $e) {
            return HtmlResponse('Undefined page', 404);
        }
    }
}
