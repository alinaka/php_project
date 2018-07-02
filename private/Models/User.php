<?php

namespace alina\project\Models;

class User
{
    private $user_id;
    private $login;
    private $email;
    private $hash;
    
    public function setEmail($email){
         $this->email = $email;
         return $this;
    }
    
    public function setHash($hash){
         $this->hash = $hash;
         return $this;
    }
    
    public function setLogin($login){
         $this->login = $login;
         return $this;
    }
    
    public function getHash(){
         return $this->hash;
    }
    
    public function getEmail(){
         return $this->email;
    }
    
    public function getLogin(){
         return $this->login;
    }
  
}
