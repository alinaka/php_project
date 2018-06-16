<?php
namespace alina\project\App;

class Template
{
    private $loader;
    private $environment;
    
    public function __construct(){
        $this->loader = new \Twig_Loader_Filesystem('../private/Views');
        $this->environment = new \Twig_Environment(
                    $this->loader,
                    array('debug'=>true)
                );
    }
    
    public function renderView($template, array $data=[]){
        return $this->environment->render($template, $data);
    }
}
