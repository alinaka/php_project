<?php

namespace alina\project\App;

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use alina\project\App\DB;

class App {

    private $request;
    private $frame;
    private $real_routes;

    public function __construct($config) {
        $this->real_routes = $this->getRealRoutes($config);
        $this->request = Request::createFromGlobals();
        $this->frame = new Core($this->real_routes);
    }

    private function getRealRoutes($_config) {
        $_real_routes = new Routing\RouteCollection();
        $_config_arr = json_decode($_config, true);
        foreach ($_config_arr as $key => $value) {
            if ($key == 'urls') {
                $routes_config = $value;
                foreach ($routes_config as $routs_key => $routs_value) {
                    $name = $routs_key;
                    $path = $routs_value['path'];
                    $controller = $routs_value['controller'];
                    $_real_routes->add($name, new Routing\Route($path, array(
                        '_controller' => $controller,
                            )
                            )
                    );
                }
            } elseif ($key == 'db') {
                $db = DB::getInstance();
                $db->setDBConfig($value);
            }
        }
        return $_real_routes;
    }

    public function run() {
        $this->frame->handle($this->request)->send();
    }

}
