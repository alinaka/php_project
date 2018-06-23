<?php
namespace alina\project\App;

class Response
{
    private $headers = [];
    private $body;
    private $statusCode;
    
    public function __construct($body='', $headers=[], $statusCode=200){
        $this->setBody($body)
                ->setHeaders($headers)
                ->setStatusCode($statusCode);
    }
    
    public function setBody($body){
        $this->body = $body;
        return $this;
    }
    
    public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
        return $this;
    }
    
    public function setHeaders($headers){
        $this->headers = array_merge($this->getHeaders(), $headers);
        return $this;
    }
    
    protected function getHeaders(){
        return $this->headers;
    }
    
    protected function getBody(){
        return $this->body;
    }
    
    protected function sendBody(){
        echo $this->getBody();
        return $this;
    }
    
    protected function sendHeaders(){
        if(headers_sent()){
            return $this->headers;
        }
        foreach ($this->headers as $name=>$val){
            header("$name:$val", false, $this->statusCode);
        }
        http_response_code($this->statusCode);
        return $this;
    }
    
    public function send(){
        $this
            ->sendHeaders()
            ->sendBody();
    }
    
}

