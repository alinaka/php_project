<?php

namespace Framework\Http\Router;

class ActionResolver
{
    public function resolve($handler, $request) 
    {
        if (is_string($handler)){
            $handler_exp = explode('::', $handler);
            
            $controller = new $handler_exp[0]($request);
            $action = $handler_exp[1];
            
            return $controller->$action($request);
        }
        return $handler;
    }
}